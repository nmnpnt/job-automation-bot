<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Application;
use App\Events\ActivityLogged;
use App\Notifications\SystemNotification;

class ProcessApplication implements ShouldQueue
{
    use Queueable;

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

        $sessionDir = storage_path("app/bot-sessions/{$app->user_id}/" . strtolower($app->application_source->value ?? ''));
        $scriptPath = base_path('bot/apply.js');

        // Auto-generate cover letter if null
        if (empty($app->cover_letter)) {
            $this->logActivity('AUTO_APPLYING', 'Auto-generating cover letter via Gemini.', 'info');
            try {
                $geminiService = app(\App\Services\GeminiCoverLetterService::class);
                $coverLetter = $geminiService->generateCoverLetter($app->user, $app);
                $app->update(['cover_letter' => $coverLetter]);
            } catch (\Exception $e) {
                $this->logActivity('AUTO_APPLYING', 'Cover letter generation failed, proceeding without it.', 'info');
            }
        }

        $inputData = json_encode([
            'url' => $app->original_job_url,
            'platform' => strtoupper($app->application_source->value ?? ''),
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

        $this->logActivity('AUTO_APPLYING', 'Auto-Application bot started.', 'info', 'notify_on_submitted');

        $process = new \Symfony\Component\Process\Process(['node', $scriptPath, $inputData]);
        $process->setTimeout(300);
        
        try {
            $process->run();
            
            // Combine both stdout and stderr to parse the output
            $outputStr = $process->getOutput() . "\n" . $process->getErrorOutput();
            $lines = array_filter(explode("\n", trim($outputStr)));
            
            $finalOutput = null;
            // Get the last valid JSON object from the output
            foreach (array_reverse($lines) as $line) {
                $parsed = json_decode($line, true);
                if (is_array($parsed) && isset($parsed['status'])) {
                    $finalOutput = $parsed;
                    break;
                }
            }
            
            if ($finalOutput && $finalOutput['status'] === 'success') {
                $this->logActivity('APPLIED', 'Bot successfully submitted application.', 'success', 'notify_on_submitted');
            } else {
                $errorMessage = $finalOutput['message'] ?? 'Bot failed to submit. No detailed error provided.';
                
                // If it failed at the process level and we didn't get a parsed error, use process error
                if (!$process->isSuccessful() && !$finalOutput) {
                    $errorMessage = 'Process Error: ' . substr($process->getErrorOutput(), 0, 200);
                }
                
                $this->logActivity('FAILED', $errorMessage, 'error', 'notify_on_failed');
            }
        } catch (\Exception $e) {
            $this->logActivity('FAILED', 'Process failed: ' . $e->getMessage(), 'error', 'notify_on_failed');
        }
    }

    private function logActivity($status, $message, $slackType = 'info', $prefKey = null)
    {
        $updateData = ['status' => $status];
        if ($status === 'FAILED' || (is_object($status) && $status->value === 'FAILED')) {
            $updateData['failure_reason'] = $message;
        }
        
        $this->application->update($updateData);
        
        try {
            event(new ActivityLogged($this->application, $status, $message));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Failed to broadcast activity: " . $e->getMessage());
        }

        $prefs = \App\Models\NotificationPreference::where('user_id', $this->application->user_id)->first();
        
        if ($prefs && $prefs->channel_slack && $prefs->slack_webhook_url) {
            if (!$prefKey || $prefs->{$prefKey}) {
                $this->application->user->notify(new SystemNotification(
                    "[{$status}] {$this->application->job_title} at {$this->application->company_name}: {$message}",
                    $slackType
                ));
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        // If the job crashes completely, ensure we mark it as FAILED in the DB
        $this->logActivity('FAILED', 'Queue Job Crashed: ' . $exception->getMessage(), 'error');
    }
}
