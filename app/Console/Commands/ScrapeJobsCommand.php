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
                    $this->warn("Skipping {$platform} - No active session found.");
                    continue;
                }

                $this->info("Scraping {$platform}...");
                
                $scriptPath = base_path('bot/fetch_jobs.js');
                $inputData = json_encode([
                    'platform' => $platform,
                    'session_dir' => $sessionDir,
                    'preferences' => $prefs,
                ]);

                $process = new \Symfony\Component\Process\Process(['node', $scriptPath, $inputData]);
                $process->setTimeout(600); // 10 minutes max per platform
                
                try {
                    $process->mustRun();
                    if ($process->getErrorOutput()) {
                        $this->warn("Debug: " . $process->getErrorOutput());
                    }
                    $output = $process->getOutput();
                    
                    // Parse output and save to database
                    $result = json_decode($output, true);
                    if (isset($result['status']) && $result['status'] === 'success' && isset($result['jobs'])) {
                        $this->info("Found " . count($result['jobs']) . " jobs.");
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
                                event(new ActivityLogged($app, 'DISCOVERED', "New job discovered: {$jobData['title']} at {$jobData['company']} via {$platform}."));
                                $profile->user->sendSlackNotification(
                                    "New job discovered: {$jobData['title']} at {$jobData['company']} via {$platform}.",
                                    'info',
                                    'notify_on_external' // We can use notify_on_external for discovered jobs as a close match, or daily_summary
                                );
                            }
                        }
                    } else {
                        $this->error("Failed to parse jobs: " . $output);
                    }
                } catch (\Exception $e) {
                    $this->error("Scraper failed: " . $e->getMessage());
                }
            }
        }
    }
}
