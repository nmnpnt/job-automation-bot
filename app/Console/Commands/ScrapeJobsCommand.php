<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\ActivityLogged;

class ScrapeJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:scrape {user_id?} {platform?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape jobs from authenticated platforms for users based on their preferences';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $platformArg = $this->argument('platform');

        $query = \App\Models\Profile::query();
        if ($userId) {
            $query->where('user_id', $userId);
        }

        $profiles = $query->get();

        if ($profiles->isEmpty()) {
            $this->info("No profiles found to scrape jobs for.");
            return;
        }

        $platforms = $platformArg ? [strtoupper($platformArg)] : ['LINKEDIN', 'INDEED', 'NAUKRI', 'UPLERS', 'UNSTOP', 'HIRIST', 'CUTSHORT'];

        foreach ($profiles as $profile) {
            $this->info("Processing User ID: {$profile->user_id}");
            
            $prefs = [
                'target_roles' => $profile->target_roles,
                'target_locations' => $profile->target_locations,
                'remote_preference' => $profile->remote_preference,
                'max_job_age_days' => $profile->max_job_age_days,
            ];

            foreach ($platforms as $platform) {
                $sessionDir = storage_path("app/bot-sessions/{$profile->user_id}/" . strtolower($platform));
                
                if (!file_exists($sessionDir) || !is_dir($sessionDir)) {
                    $this->warn("No active session found for {$platform}, but proceeding with unauthenticated scrape for testing...");
                    // continue; // Commented out to allow testing without login
                }

                $this->info("Scraping {$platform}...");
                
                $scriptPath = base_path('bot/fetch_jobs.js');
                $inputData = json_encode([
                    'platform' => $platform,
                    'session_dir' => $sessionDir,
                    'preferences' => $prefs,
                    'is_docker' => file_exists('/.dockerenv')
                ]);

                $process = new \Symfony\Component\Process\Process(['node', $scriptPath, $inputData]);
                $process->setTimeout(600); // 10 minutes max per platform
                
                try {
                    $logFile = storage_path("logs/scraper-{$profile->user_id}.log");
                    if (!file_exists(dirname($logFile))) {
                        mkdir(dirname($logFile), 0755, true);
                    }
                    if ($platform === $platforms[0]) {
                        file_put_contents($logFile, "Starting scraper run...\n");
                    }
                    file_put_contents($logFile, "Scraping {$platform}...\n", FILE_APPEND);

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
                        $this->warn("Debug: " . $process->getErrorOutput());
                    }
                    
                    // Parse output and save to database
                    $result = json_decode($outputBuffer, true);
                    if (isset($result['status']) && $result['status'] === 'success' && isset($result['jobs'])) {
                        $this->info("Found " . count($result['jobs']) . " jobs.");
                        file_put_contents($logFile, "Found " . count($result['jobs']) . " jobs on {$platform}.\n", FILE_APPEND);
                        foreach ($result['jobs'] as $jobData) {
                            $app = \App\Models\Application::updateOrCreate(
                                [
                                    'original_job_url' => $jobData['url'],
                                    'user_id' => $profile->user_id,
                                ],
                                [
                                    'job_title' => $jobData['title'],
                                    'company_name' => $jobData['company'],
                                    // Location could go into a new column, or just be logged
                                    'status' => 'DISCOVERED',
                                    'application_source' => $platform,
                                    'can_auto_apply' => true
                                ]
                            );
                            if ($app->wasRecentlyCreated) {
                                try {
                                    event(new ActivityLogged($app, 'DISCOVERED', "New job discovered: {$jobData['title']} at {$jobData['company']} via {$platform}."));
                                    $profile->user->sendSlackNotification(
                                        "New job discovered: {$jobData['title']} at {$jobData['company']} via {$platform}.",
                                        'info',
                                        'notify_on_external'
                                    );
                                } catch (\Throwable $e) {
                                    // Ignore broadcast / notification failures so jobs are still stored
                                }
                            }
                        }
                    } else {
                        $this->error("Failed to parse jobs: " . $outputBuffer);
                        file_put_contents($logFile, "Failed to parse jobs: " . $outputBuffer . "\n", FILE_APPEND);
                    }
                } catch (\Exception $e) {
                    $this->error("Scraper failed: " . $e->getMessage());
                    $logFile = storage_path("logs/scraper-{$profile->user_id}.log");
                    file_put_contents($logFile, "Scraper failed: " . $e->getMessage() . "\n", FILE_APPEND);
                }
            }
            
            // Finished
            $profile->update(['scraping_status' => 'completed', 'scraper_pid' => null]);
            $logFile = storage_path("logs/scraper-{$profile->user_id}.log");
            file_put_contents($logFile, "Scrape run completed.\n", FILE_APPEND);
        }
    }
}
