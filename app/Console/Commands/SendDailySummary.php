<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use App\Models\NotificationPreference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily application summary to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();

        $preferences = NotificationPreference::where('daily_summary', true)->get();

        foreach ($preferences as $pref) {
            // In a real application, you'd filter applications by user_id
            $apps = Application::whereBetween('created_at', [$yesterday, $today])->get();

            if ($apps->isEmpty()) {
                continue;
            }

            $totalFound = $apps->count();
            // Assuming status transitions show what happened
            $autoApplied = $apps->where('status', \App\Enums\ApplicationStatus::APPLIED)->count();
            $external = $apps->where('status', \App\Enums\ApplicationStatus::EXTERNAL_APPLICATION)->count();
            $company = $apps->where('status', \App\Enums\ApplicationStatus::COMPANY_WEBSITE)->count();
            $manual = $apps->where('status', \App\Enums\ApplicationStatus::MANUAL_REQUIRED)->count();
            $failed = $apps->where('status', \App\Enums\ApplicationStatus::FAILED)->count();
            $duplicates = $apps->where('status', \App\Enums\ApplicationStatus::ALREADY_APPLIED)->count();

            $report = "📊 Daily Job Application Report\n\n";
            $report .= "Jobs Found: {$totalFound}\n\n";
            $report .= "Applications:\n";
            $report .= "🟢 Automatically Applied: {$autoApplied}\n";
            $report .= "🔵 External Applications: {$external}\n";
            $report .= "🏢 Company Websites: {$company}\n";
            $report .= "🟠 Manual Required: {$manual}\n";
            $report .= "🔴 Failed: {$failed}\n";
            $report .= "⚪ Duplicates: {$duplicates}\n";

            // Here we would send it to the user. E.g., Notification::send()
            Log::info("Daily Summary for User {$pref->user_id}:\n{$report}");
            $this->info("Sent summary for user {$pref->user_id}");
        }
    }
}
