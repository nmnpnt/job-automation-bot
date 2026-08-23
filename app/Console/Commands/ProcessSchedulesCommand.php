<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessSchedulesCommand extends Command
{
    protected $signature = 'app:process-schedules';
    protected $description = 'Process all due scraping schedules and dispatch their jobs';

    public function handle()
    {
        $dueSchedules = \App\Models\ScrapingSchedule::where('is_active', true)
            ->where('next_run_at', '<=', now())
            ->get();

        $this->info("Found " . $dueSchedules->count() . " due schedules.");

        foreach ($dueSchedules as $schedule) {
            $this->info("Dispatching schedule {$schedule->id} for user {$schedule->user_id}");
            
            // Dispatch the actual job
            \App\Jobs\RunUserScraperJob::dispatch($schedule->user_id, $schedule->id, 'scheduled');
            
            // Calculate next run immediately to prevent double processing in the next minute
            $schedule->last_run_at = now();
            // This will also trigger the saving event which calls calculateNextRun()
            $schedule->save();
        }
    }
}
