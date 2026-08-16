<?php

namespace App\Services;

use App\Enums\ApplicationAction;
use App\Enums\ApplicationSource;
use App\Enums\ApplicationStatus;
use App\Models\Application;
use Illuminate\Support\Facades\Log;
use App\Events\ApplicationSubmitted;
use App\Events\ExternalApplicationDetected;
use App\Events\CompanyWebsiteDetected;
use App\Events\ApplicationFailed;
use App\Events\ManualActionRequired;
use App\Events\DuplicateApplicationDetected;

class JobApplicationEngine
{
    public function __construct(
        protected ApplicationSourceDetector $detector,
        protected ResumeMatcherService $matcher
    ) {}

    public function processNewJob(array $jobData)
    {
        // For demonstration, assume $jobData contains 'url', 'score', etc.
        $url = $jobData['url'] ?? '';
        
        // 1. Detect Application Source
        $source = $this->detector->detect($url);
        
        // 2. Check if already applied
        if (Application::where('original_job_url', $url)->exists()) {
            $application = Application::where('original_job_url', $url)->first();
            $this->logEvent($application, ApplicationStatus::ALREADY_APPLIED, 'Job was already applied.');
            event(new DuplicateApplicationDetected($application));
            return;
        }

        // 3. Create initial Application record
        $application = Application::create([
            'job_id' => $jobData['id'] ?? null,
            'application_source' => $source,
            'original_job_url' => $url,
            'status' => ApplicationStatus::DISCOVERED,
        ]);

        $this->logEvent($application, ApplicationStatus::DISCOVERED, 'Job discovered and source detected.');

        // 4. Decide action based on source
        $provider = $this->detector->getProvider($url);
        
        if ($source === ApplicationSource::COMPANY_WEBSITE) {
            $application->update(['status' => ApplicationStatus::COMPANY_WEBSITE]);
            $this->logEvent($application, ApplicationStatus::COMPANY_WEBSITE, 'Company website application detected.');
            event(new CompanyWebsiteDetected($application));
            return;
        }

        if ($source === ApplicationSource::EXTERNAL_JOB_BOARD || !$provider) {
            $application->update(['status' => ApplicationStatus::EXTERNAL_APPLICATION]);
            $this->logEvent($application, ApplicationStatus::EXTERNAL_APPLICATION, 'External job board application detected.');
            event(new ExternalApplicationDetected($application));
            return;
        }

        // 5. Evaluate Match Score
        $jobDescription = $jobData['description'] ?? 'No description provided.';
        
        $profile = \App\Models\Profile::first();
        if ($profile && $profile->resume_text) {
            $resumeText = $profile->resume_text;
        } else {
            $resumeText = "Senior Software Engineer with 10 years of experience in PHP, Laravel, and JavaScript."; // Fallback
        }

        $match = $this->matcher->match($resumeText, $jobDescription);

        $application->update([
            'match_score' => $match['score'],
            'match_reason' => $match['reason'],
        ]);

        $this->logEvent($application, ApplicationStatus::DISCOVERED, "AI Evaluation complete. Score: {$match['score']}% - {$match['reason']}");

        if ($match['score'] < 70) {
            $application->update(['status' => ApplicationStatus::SKIPPED]);
            $this->logEvent($application, ApplicationStatus::SKIPPED, 'Skipped due to low AI match score.');
            // event(new ApplicationSkipped($application)); // If we wanted an event
            return;
        }

        // Generate Cover Letter
        $coverLetter = $this->matcher->generateCoverLetter($resumeText, $jobDescription);
        $application->update([
            'cover_letter' => $coverLetter
        ]);
        $this->logEvent($application, ApplicationStatus::DISCOVERED, 'Generated dynamic cover letter.');

        // 6. Manual Review Queue
        $application->update([
            'status' => ApplicationStatus::PENDING_REVIEW,
            'can_auto_apply' => true, // Still true, just waiting for human
        ]);
        $this->logEvent($application, ApplicationStatus::PENDING_REVIEW, 'Sent to manual review queue (Match score OK).');

        // Note: executeApplication() will now be triggered via the UI
    }

    public function executeApplication(Application $application, $provider)
    {
        $application->update(['status' => ApplicationStatus::AUTO_APPLYING, 'attempt_count' => $application->attempt_count + 1, 'last_attempt_at' => now()]);
        $this->logEvent($application, ApplicationStatus::AUTO_APPLYING, 'Starting automated application process.');

        try {
            $success = $provider->apply($application);

            if ($success) {
                $application->update([
                    'status' => ApplicationStatus::APPLIED,
                    'submitted_at' => now(),
                    'confirmation_id' => uniqid('APP_')
                ]);
                $this->logEvent($application, ApplicationStatus::APPLIED, 'Application submitted successfully.');
                event(new ApplicationSubmitted($application));
            } else {
                // If it failed cleanly, maybe manual required
                $application->update(['status' => ApplicationStatus::MANUAL_REQUIRED]);
                $this->logEvent($application, ApplicationStatus::MANUAL_REQUIRED, 'Automated apply failed gracefully, manual action required.');
                event(new ManualActionRequired($application));
            }
        } catch (\Exception $e) {
            $application->update([
                'status' => ApplicationStatus::FAILED,
                'failure_reason' => $e->getMessage()
            ]);
            $this->logEvent($application, ApplicationStatus::FAILED, 'Automation encountered an error: ' . $e->getMessage());
            event(new ApplicationFailed($application));
        }
    }

    protected function logEvent(Application $application, ApplicationStatus $status, string $message)
    {
        $application->events()->create([
            'event_type' => $status->value,
            'message' => $message,
            'metadata' => [
                'timestamp' => now()->toIso8601String()
            ]
        ]);

        event(new \App\Events\ActivityLogged($application, $status->value, $message));
    }
}
