<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use App\Events\ActivityLogged;
use App\Enums\ApplicationStatus;

class SimulateActivity extends Command
{
    protected $signature = 'app:simulate-activity';
    protected $description = 'Simulate a new activity event for testing real-time WebSockets';

    public function handle()
    {
        // Get or create an application
        $app = Application::firstOrCreate(
            ['job_id' => 'sim-'.rand(100, 999)],
            [
                'job_title' => 'Software Engineer',
                'company_name' => 'Tech Corp '.rand(1, 100),
                'original_job_url' => 'https://example.com/job',
                'status' => ApplicationStatus::APPLIED->value,
            ]
        );

        $statuses = [
            ApplicationStatus::PENDING_REVIEW,
            ApplicationStatus::APPLIED,
        ];
        
        $randomStatus = $statuses[array_rand($statuses)];
        $app->status = $randomStatus->value;
        if ($randomStatus === ApplicationStatus::PENDING_REVIEW) {
            $app->match_score = rand(70, 99);
            $app->match_reason = "This candidate has strong experience in PHP and Laravel.";
        }
        $app->save();

        $message = match($randomStatus) {
            ApplicationStatus::PENDING_REVIEW => 'Job scored well and is pending manual review.',
            ApplicationStatus::APPLIED => 'Successfully submitted auto-application.',
            default => 'Status updated.'
        };

        // Dispatch the event
        event(new ActivityLogged($app, $randomStatus->value, $message));
        
        $app->user->notifyChannels(
            "Simulated activity: {$message} for {$app->company_name}",
            'info'
        );

        $this->info("Simulated activity: {$message} for {$app->company_name}");
    }
}
