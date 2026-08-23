<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ScraperOrchestrator
{
    private string $scraperUrl;

    public function __construct()
    {
        // Default to localhost:8001 for local dev outside docker, 
        // but can be overridden to http://scraper:8000 when running PHP in docker too.
        $this->scraperUrl = env('SCRAPER_API_URL', 'http://127.0.0.1:8001');
    }

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

        try {
            $response = Http::timeout(120)->post("{$this->scraperUrl}/api/apply", $inputData);
            
            if ($response->successful()) {
                $result = $response->json();
                
                if (isset($result['status']) && $result['status'] === 'success') {
                    Log::info('Puppeteer success: ' . ($result['message'] ?? ''));
                    return true;
                } else {
                    $errorMsg = $result['message'] ?? 'Unknown error from scraper API';
                    Log::error('Puppeteer logic failed: ' . $errorMsg);
                    
                    if (isset($result['screenshot_path'])) {
                        $application->update(['error_screenshot_path' => $result['screenshot_path']]);
                    }
                    
                    throw new \Exception($errorMsg);
                }
            } else {
                Log::error('Scraper API returned HTTP ' . $response->status());
                throw new \Exception('Scraper API failed with status ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Puppeteer process failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetch the full job description details for a given application URL.
     */
    public function fetchJobDetails(Application $application): bool
    {
        if (empty($application->original_job_url)) {
            return false;
        }

        $sessionDir = storage_path("app/bot-sessions/{$application->user_id}/" . strtolower($application->application_source->name ?? 'UNKNOWN'));

        $inputData = [
            'url' => $application->original_job_url,
            'platform' => $application->application_source->name ?? 'UNKNOWN',
            'session_dir' => $sessionDir,
            'is_docker' => file_exists('/.dockerenv')
        ];

        try {
            $response = Http::timeout(90)->post("{$this->scraperUrl}/api/fetch_details", $inputData);
            
            if ($response->successful()) {
                $result = $response->json();
                
                if (isset($result['status']) && $result['status'] === 'success') {
                    $details = $result['details'] ?? [];
                    if (!empty($details['description'])) {
                        $application->update([
                            'description' => $details['description'],
                        ]);
                        return true;
                    }
                }
                
                Log::error('Fetch Job Details failed: ' . ($result['message'] ?? 'Empty description returned.'));
                return false;
            } else {
                Log::error('Scraper API returned HTTP ' . $response->status());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Puppeteer fetch details process failed: ' . $e->getMessage());
            return false;
        }
    }
}
