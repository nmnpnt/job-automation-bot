<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\Profile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class RunScraperJob implements ShouldQueue
{
    use Queueable;

    public $profileId;
    public $timeout = 1800; // Allow 30 minutes max

    /**
     * Create a new job instance.
     */
    public function __construct($profileId)
    {
        $this->profileId = $profileId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $profile = Profile::find($this->profileId);
        if (!$profile) return;

        $profile->update(['scraping_status' => 'running']);

        try {
            Artisan::call('jobs:scrape', ['user_id' => $profile->user_id]);
            
            $profile->update([
                'scraping_status' => 'completed',
                'last_scraped_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error("Scraping Job Failed: " . $e->getMessage());
            $profile->update(['scraping_status' => 'failed']);
        }
    }
}
