<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Queue\Queueable;
use App\Events\ActivityLogged;
use Illuminate\Support\Str;

class RunUserScraperJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public $userId;
    public $scheduleId;
    public $triggerType;
    public $timeout = 7200; // 2 hours
    public $tries = 1;
    public $uniqueFor = 7200;

    public function __construct($userId, $scheduleId = null, $triggerType = 'scheduled')
    {
        $this->userId = $userId;
        $this->scheduleId = $scheduleId;
        $this->triggerType = $triggerType;
        $this->onQueue('scraper');
    }

    public function uniqueId()
    {
        return 'user-scraper:' . $this->userId;
    }

    public function handle()
    {
        $userId = $this->userId;
        
        $profile = \App\Models\Profile::where('user_id', $userId)->first();
        if (!$profile) {
            return;
        }

        $platforms = is_array($profile->target_platforms) && count($profile->target_platforms) > 0 
                    ? $profile->target_platforms 
                    : ['LINKEDIN', 'INDEED', 'NAUKRI', 'UPLERS', 'UNSTOP', 'HIRIST', 'CUTSHORT'];
        
        // Create the scraping job execution record
        $scrapingJobRecord = \App\Models\ScrapingJob::create([
            'user_id' => $userId,
            'schedule_id' => $this->scheduleId,
            'platforms' => $platforms,
            'status' => 'running',
            'trigger_type' => $this->triggerType,
            'started_at' => now(),
        ]);
        $platformList = implode(', ', $platforms);
        \Log::info("Targeting platforms: {$platformList}");
            
            try {
                $profile->user->notifyChannels("🔍 Job scraping started on: {$platformList}", 'info', 'notify_on_system');
            } catch (\Throwable $e) {}
            
            $prefs = [
                'target_roles' => $profile->target_roles,
                'target_locations' => $profile->target_locations,
                'remote_preference' => $profile->remote_preference,
                'max_job_age_days' => $profile->max_job_age_days,
            ];

            $totalNewJobs = 0; // Track new jobs across all platforms this run
            $totalJobsFound = 0; // Track total jobs returned by scraper

            foreach ($platforms as $platform) {
                $sessionDir = storage_path("app/bot-sessions/{$profile->user_id}/" . strtolower($platform));
                
                if (!file_exists($sessionDir) || !is_dir($sessionDir)) {
                    \Log::warning("No active session found for {$platform}, but proceeding with unauthenticated scrape for testing...");
                    // continue; // Commented out to allow testing without login
                }

                \Log::info("Scraping {$platform}...");
                
                $inputData = json_encode([
                    'platform' => $platform,
                    'session_dir' => $sessionDir,
                    'preferences' => $prefs,
                    'is_docker' => file_exists('/.dockerenv')
                ]);

                $pythonExe = strncasecmp(PHP_OS, 'WIN', 3) == 0 ? base_path('bot/venv/Scripts/python.exe') : base_path('bot/venv/bin/python');
                $scriptPath = base_path('bot/fetch_jobs.py');
                $process = new \Symfony\Component\Process\Process([$pythonExe, $scriptPath, $inputData]);
                $process->setTimeout(3600); // 1 hour max per platform to handle large batches
                
                try {
                    $logFile = storage_path("logs/scraper-{$profile->user_id}.log");
                    if (!file_exists(dirname($logFile))) {
                        mkdir(dirname($logFile), 0755, true);
                    }
                    if ($platform === $platforms[0]) {
                        // Clear log and write a fresh header at the start of each run
                        $header  = "=====================================\n";
                        $header .= "Scraper Run Started: " . now()->format('Y-m-d H:i:s T') . "\n";
                        $header .= "Platforms: {$platformList}\n";
                        $header .= "=====================================\n";
                        file_put_contents($logFile, $header);
                    }
                    file_put_contents($logFile, "Scraping {$platform}..\n", FILE_APPEND);

                    $process->start();
                    $profile->update(['scraper_pid' => $process->getPid()]);

                    $outputBuffer = '';
                    $process->wait(function ($type, $buffer) use ($logFile, &$outputBuffer) {
                        if ($type === \Symfony\Component\Process\Process::ERR) {
                            file_put_contents($logFile, $buffer, FILE_APPEND);
                        } else {
                            $outputBuffer .= $buffer;
                        }
                    });
                    
                    if ($process->getErrorOutput()) {
                        \Log::warning("Debug: " . $process->getErrorOutput());
                    }
                    
                    // Parse output and save to database
                    $result = json_decode($outputBuffer, true);
                    if (isset($result['status']) && $result['status'] === 'success' && isset($result['jobs'])) {
                        $newForPlatform = 0;
                        $jobsCount = count($result['jobs']);
                        $totalJobsFound += $jobsCount;
                        \Log::info("Found " . $jobsCount . " jobs.");
                        file_put_contents($logFile, "Found " . $jobsCount . " jobs on {$platform}.\n", FILE_APPEND);
                        foreach ($result['jobs'] as $jobData) {
                            $app = \App\Models\Application::updateOrCreate(
                                [
                                    'original_job_url' => $jobData['url'],
                                    'user_id' => $profile->user_id,
                                ],
                                [
                                    'job_title' => $jobData['title'],
                                    'company_name' => $jobData['company'],
                                    'status' => 'DISCOVERED',
                                    'application_source' => $jobData['source'] ?? $platform,
                                    'can_auto_apply' => true,
                                    'description' => $jobData['description'] ?? null,
                                    'skills_required' => $jobData['skills'] ?? null,
                                    'location' => $jobData['location'] ?? null,
                                ]
                            );
                            if ($app->wasRecentlyCreated) {
                                $newForPlatform++;
                                try {
                                    // AI match is now handled manually via the UI to save API quota
                                    // and prevent the queue worker from being blocked by rate limits.
                                    
                                    // Fire live-feed event (no in-app notification per job — summary sent at end)
                                    event(new \App\Events\ActivityLogged($app, 'DISCOVERED', "New job discovered: {$jobData['title']} at {$jobData['company']} via {$platform}."));
                                } catch (\Throwable $e) {}
                            }
                        }
                        $totalNewJobs += $newForPlatform;
                        if ($newForPlatform > 0) {
                            \Log::info("  → {$newForPlatform} new jobs saved from {$platform}.");
                            file_put_contents($logFile, "  → {$newForPlatform} new jobs saved from {$platform}.\n", FILE_APPEND);
                        }
                    } else {
                        \Log::error("Failed to parse jobs: " . $outputBuffer);
                        file_put_contents($logFile, "Failed to parse jobs: " . $outputBuffer . "\n", FILE_APPEND);
                        $hasErrors = true;
                    }
                } catch (\Exception $e) {
                    \Log::error("Scraper failed: " . $e->getMessage());
                    $logFile = storage_path("logs/scraper-{$profile->user_id}.log");
                    file_put_contents($logFile, "Scraper failed: " . $e->getMessage() . "\n", FILE_APPEND);
                    $hasErrors = true;
                }
            }
            
            // Finished — send a single summary notification
            $profile->update(['scraping_status' => 'completed', 'scraper_pid' => null]);
            $logFile = storage_path("logs/scraper-{$profile->user_id}.log");
            file_put_contents($logFile, "Scrape run completed. {$totalNewJobs} new jobs found.\n", FILE_APPEND);
            
            $scrapingJobRecord->update([
                'status' => isset($hasErrors) && $hasErrors ? 'failed' : 'completed',
                'completed_at' => now(),
                'jobs_found' => $totalJobsFound,
                'new_jobs_added' => $totalNewJobs,
                // We'll update the duration later if needed, right now we have started_at and completed_at
            ]);
            
            $platformsWithStatus = implode(', ', array_map(function($p) use ($profile) {
                $sessionDir = storage_path("app/bot-sessions/{$profile->user_id}/" . strtolower($p));
                $status = (file_exists($sessionDir) && is_dir($sessionDir)) ? 'with login' : 'without login';
                return "{$p} ({$status})";
            }, $platforms));

            $summary = $totalNewJobs > 0
                ? "✅ Scraping done on: {$platformsWithStatus}. {$totalNewJobs} new job(s) found!"
                : "✅ Scraping done on: {$platformsWithStatus}. No new jobs this time.";

            try {
                // Now using 'daily_summary' which maps to the "Scraper Completed" preference toggle
                $profile->user->notifyChannels($summary, 'success', 'daily_summary');
            } catch (\Throwable $e) {}
    }
}
