<?php

namespace App\Services;

use App\Models\Application;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;

class PuppeteerOrchestrator
{
    public function apply(Application $application): bool
    {
        $profile = \App\Models\Profile::first();
        
        $resumePath = $profile && $profile->resume_path ? storage_path('app/public/' . $profile->resume_path) : '/path/to/resume.pdf';
        
        if ($profile && $application->job) {
            $resumeService = new \App\Services\ResumeGeneratorService();
            $tailoredResume = $resumeService->generateTailoredResume($profile, $application->job);
            if (file_exists($tailoredResume)) {
                $resumePath = $tailoredResume;
            }
        }
        
        $inputData = [
            'url' => $application->original_job_url,
            'platform' => $application->application_source->name,
            'profile' => [
                'first_name' => $profile->first_name ?? 'John',
                'last_name' => $profile->last_name ?? 'Doe',
                'email' => $profile->email ?? 'john.doe@example.com',
                'phone' => $profile->phone ?? '1234567890',
                'linkedin_url' => $profile->linkedin_url ?? '',
                'github_url' => $profile->github_url ?? '',
                'portfolio_url' => $profile->portfolio_url ?? '',
                'resume_path' => $resumePath
            ],
            'cover_letter' => $application->cover_letter ?? '',
            'session_dir' => storage_path("app/bot-sessions/{$application->user_id}/" . strtolower($application->application_source->name))
        ];

        $jsonInput = json_encode($inputData);
        $botPath = base_path('bot/apply.js');
        
        $process = new Process(['node', $botPath, $jsonInput]);
        $process->setTimeout(60);

        try {
            $process->mustRun();
            $output = $process->getOutput();
            
            // Output might have other logs, so parse the last line as JSON, or find JSON
            preg_match('/{.*}/s', $output, $matches);
            
            if (!empty($matches)) {
                $result = json_decode($matches[0], true);
                if (isset($result['status']) && $result['status'] === 'success') {
                    Log::info('Puppeteer success: ' . $result['message']);
                    return true;
                } else {
                    $errorMsg = $result['message'] ?? 'Unknown error';
                    Log::error('Puppeteer logic failed: ' . $errorMsg);
                    
                    if (isset($result['screenshot_path'])) {
                        $application->update(['error_screenshot_path' => $result['screenshot_path']]);
                    }
                    
                    throw new \Exception($errorMsg);
                }
            }
            
            Log::error('Could not parse JSON from Puppeteer script.');
            throw new \Exception('Could not parse JSON from Puppeteer script.');

        } catch (ProcessFailedException $e) {
            Log::error('Puppeteer process failed: ' . $e->getMessage());
            
            $output = $e->getProcess()->getErrorOutput() . "\n" . $e->getProcess()->getOutput();
            preg_match('/{.*}/s', $output, $matches);
            if (!empty($matches)) {
                $result = json_decode($matches[0], true);
                if (isset($result['screenshot_path'])) {
                    $application->update(['error_screenshot_path' => $result['screenshot_path']]);
                }
                $errorMsg = $result['message'] ?? 'Unknown error';
                throw new \Exception($errorMsg);
            }

            throw new \Exception('Puppeteer process failed: ' . $e->getMessage());
        }
    }
}
