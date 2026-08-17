<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Application;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Dispatchable;
use App\Events\ActivityLogged;
use App\Notifications\SystemSlackNotification;

class ProcessApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $application;

    /**
     * Create a new job instance.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $app = $this->application;
        $profile = $app->user->profile;

        if (!$profile) {
            $this->logActivity('FAILED', 'User has no profile configured. Cannot apply.');
            return;
        }

        $sessionDir = storage_path("app/bot-sessions/{$app->user_id}/" . strtolower($app->application_source));
        $scriptPath = base_path('bot/apply.js');

        // Auto-generate cover letter if null
        if (empty($app->cover_letter)) {
            $this->logActivity('PROCESSING', 'Auto-generating cover letter via Gemini.', 'info');
            try {
                $geminiService = app(\App\Services\GeminiCoverLetterService::class);
                $coverLetter = $geminiService->generateCoverLetter($app->user, $app);
                $app->update(['cover_letter' => $coverLetter]);
            } catch (\Exception $e) {
                $this->logActivity('PROCESSING', 'Cover letter generation failed, proceeding without it.', 'info');
            }
        }

        $inputData = json_encode([
            'url' => $app->original_job_url,
            'platform' => strtoupper($app->application_source),
            'session_dir' => $sessionDir,
            'profile' => [
                'first_name' => $profile->first_name ?? explode(' ', $app->user->name)[0] ?? '',
                'last_name' => $profile->last_name ?? explode(' ', $app->user->name)[1] ?? '',
                'email' => $profile->email ?? $app->user->email,
                'phone' => $profile->phone ?? '',
                'resume_path' => $profile->resume_path ? storage_path('app/public/' . $profile->resume_path) : '',
            ],
            'cover_letter' => $app->cover_letter ?? '',
        ]);

        $this->logActivity('PROCESSING', 'Auto-Application bot started.', 'info', 'notify_on_submitted');

        $process = new \Symfony\Component\Process\Process(['node', $scriptPath, $inputData]);
        $process->setTimeout(300);
        
        try {
            $process->mustRun();
            $output = json_decode($process->getOutput(), true);
            
            if (isset($output['status']) && $output['status'] === 'success') {
                $this->logActivity('APPLIED', 'Bot successfully submitted application.', 'success', 'notify_on_submitted');
            } else {
                $this->logActivity('FAILED', $output['message'] ?? 'Bot failed to submit.', 'error', 'notify_on_failed');
            }
        } catch (\Exception $e) {
            $this->logActivity('FAILED', 'Process failed: ' . $e->getMessage(), 'error', 'notify_on_failed');
        }
    }

    private function logActivity($status, $message, $slackType = 'info', $prefKey = null)
    {
        $this->application->update(['status' => $status]);
        event(new ActivityLogged($this->application, $status, $message));

        $prefs = \App\Models\NotificationPreference::where('user_id', $this->application->user_id)->first();
        
        if ($prefs && $prefs->channel_slack && $prefs->slack_webhook_url) {
            if (!$prefKey || $prefs->{$prefKey}) {
                $this->application->user->notify(new SystemSlackNotification(
                    "[{$status}] {$this->application->job_title} at {$this->application->company_name}: {$message}",
                    $slackType
                ));
            }
        }
    }
}
