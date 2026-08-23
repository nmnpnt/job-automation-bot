<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Application;
use Illuminate\Support\Facades\DB;

class JobAnalytics extends Component
{
    public function render()
    {
        $userId = auth()->id();

        // 1. Status Breakdown (Pie Chart)
        $statusCounts = Application::where('user_id', $userId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
            
        $statusLabels = $statusCounts->pluck('status')->map(fn($s) => $s->value ?? $s)->toArray();
        $statusData = $statusCounts->pluck('total')->toArray();

        // 2. Source Breakdown (Bar Chart)
        $sourceCounts = Application::where('user_id', $userId)
            ->select('application_source', DB::raw('count(*) as total'))
            ->groupBy('application_source')
            ->get();
            
        $sourceLabels = $sourceCounts->pluck('application_source')->map(fn($s) => $s->value ?? $s)->toArray();
        $sourceData = $sourceCounts->pluck('total')->toArray();

        // 3. Applications over the last 7 days (Line Chart)
        $dailyCounts = Application::where('user_id', $userId)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
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
        $totalApplications = Application::where('user_id', $userId)->count();
        $interviews = Application::where('user_id', $userId)->whereIn('status', ['INTERVIEW_REQUESTED', 'OFFER_RECEIVED'])->count();
        $interviewRate = $totalApplications > 0 ? round(($interviews / $totalApplications) * 100, 1) : 0;

        // NEW: 4. Funnel Calculations
        $funnelDiscovered = $totalApplications;
        $funnelMatched = Application::where('user_id', $userId)->where('match_score', '>=', 70)->count();
        $funnelApplied = Application::where('user_id', $userId)
            ->whereIn('status', ['APPLIED', 'INTERVIEW_REQUESTED', 'REJECTED', 'OFFER_RECEIVED'])
            ->count();
        $funnelInterviewing = $interviews;
        $funnelOffers = Application::where('user_id', $userId)->where('status', 'OFFER_RECEIVED')->count();
        
        $funnelData = [
            'Discovered' => $funnelDiscovered,
            'Matched' => $funnelMatched,
            'Applied' => $funnelApplied,
            'Interviewing' => $funnelInterviewing,
            'Offers' => $funnelOffers,
        ];

        // NEW: 5. Match Score Distribution
        $scoreDistribution = DB::table('applications')
            ->where('user_id', $userId)
            ->select(DB::raw('
                SUM(CASE WHEN match_score >= 0 AND match_score < 50 THEN 1 ELSE 0 END) as "bin1",
                SUM(CASE WHEN match_score >= 50 AND match_score < 70 THEN 1 ELSE 0 END) as "bin2",
                SUM(CASE WHEN match_score >= 70 AND match_score < 85 THEN 1 ELSE 0 END) as "bin3",
                SUM(CASE WHEN match_score >= 85 AND match_score <= 100 THEN 1 ELSE 0 END) as "bin4"
            '))
            ->first();
            
        $matchScoreLabels = ['0-50', '50-70', '70-85', '85-100'];
        $matchScoreData = [
            $scoreDistribution->bin1 ?? 0,
            $scoreDistribution->bin2 ?? 0,
            $scoreDistribution->bin3 ?? 0,
            $scoreDistribution->bin4 ?? 0,
        ];

        // NEW: 6. Activity Heatmap (Last 90 Days)
        $heatmapRaw = Application::where('user_id', $userId)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(90)->startOfDay())
            ->groupBy('date')
            ->get();
            
        $heatmapMap = $heatmapRaw->pluck('total', 'date')->toArray();
        $heatmapData = [];
        for ($i = 89; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $count = $heatmapMap[$d] ?? 0;
            // intensity: 0 (none), 1 (1-2), 2 (3-5), 3 (6-10), 4 (11+)
            $intensity = 0;
            if ($count > 0) $intensity = 1;
            if ($count > 2) $intensity = 2;
            if ($count > 5) $intensity = 3;
            if ($count > 10) $intensity = 4;
            $heatmapData[] = [
                'date' => $d,
                'count' => $count,
                'intensity' => $intensity
            ];
        }

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
            'funnelData' => $funnelData,
            'matchScoreLabels' => json_encode($matchScoreLabels),
            'matchScoreData' => json_encode($matchScoreData),
            'heatmapData' => $heatmapData,
        ]);
    }
}
