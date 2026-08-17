<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Application;
use Illuminate\Support\Facades\DB;

class JobAnalytics extends Component
{
    public function render()
    {
        // 1. Status Breakdown (Pie Chart)
        $statusCounts = Application::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
            
        $statusLabels = $statusCounts->pluck('status')->map(fn($s) => $s->value ?? $s)->toArray();
        $statusData = $statusCounts->pluck('total')->toArray();

        // 2. Source Breakdown (Bar Chart)
        $sourceCounts = Application::select('application_source', DB::raw('count(*) as total'))
            ->groupBy('application_source')
            ->get();
            
        $sourceLabels = $sourceCounts->pluck('application_source')->map(fn($s) => $s->value ?? $s)->toArray();
        $sourceData = $sourceCounts->pluck('total')->toArray();

        // 3. Applications over the last 7 days (Line Chart)
        $dailyCounts = Application::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Fill missing days
        $dates = [];
        $applicationsPerDay = [];
        $thisWeekApplications = 0;
        for ($i = 6; $i >= 0; $i--) {
            $dateStr = now()->subDays($i)->format('Y-m-d');
            $dates[] = $dateStr;
            $match = $dailyCounts->firstWhere('date', $dateStr);
            $total = $match ? $match->total : 0;
            $applicationsPerDay[] = $total;
            $thisWeekApplications += $total;
        }

        // Quick Stats
        $totalApplications = Application::count();
        $interviews = Application::whereIn('status', ['INTERVIEW_REQUESTED', 'OFFER_RECEIVED'])->count();
        $interviewRate = $totalApplications > 0 ? round(($interviews / $totalApplications) * 100, 1) : 0;

        return view('livewire.job-analytics', [
            'statusLabels' => json_encode($statusLabels),
            'statusData' => json_encode($statusData),
            'sourceLabels' => json_encode($sourceLabels),
            'sourceData' => json_encode($sourceData),
            'trendDates' => json_encode($dates),
            'trendData' => json_encode($applicationsPerDay),
            'totalApplications' => $totalApplications,
            'thisWeekApplications' => $thisWeekApplications,
            'interviewRate' => $interviewRate,
        ]);
    }
}
