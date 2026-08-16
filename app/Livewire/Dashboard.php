<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $totalJobs = 0;
    public $totalApplied = 0;
    public $successRate = 0;
    public $interviews = 0;
    public $platformStats = [];
    public $statusStats = [];

    public function mount()
    {
        $userId = auth()->id();

        // 1. Total Jobs Discovered
        $this->totalJobs = \App\Models\Application::where('user_id', $userId)->count();

        // 2. Total Applied
        $this->totalApplied = \App\Models\Application::where('user_id', $userId)
            ->whereIn('status', ['APPLIED', 'INTERVIEW_REQUESTED', 'REJECTED', 'OFFER_RECEIVED'])
            ->count();

        // 3. Success Rate
        if ($this->totalJobs > 0) {
            $this->successRate = round(($this->totalApplied / $this->totalJobs) * 100);
        }

        // 4. Interviews
        $this->interviews = \App\Models\Application::where('user_id', $userId)
            ->where('status', 'INTERVIEW_REQUESTED')
            ->count();

        // 5. Stats by Platform (Interviews)
        $platforms = \App\Models\Application::where('user_id', $userId)
            ->select('application_source', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->where('status', 'INTERVIEW_REQUESTED')
            ->groupBy('application_source')
            ->get();
            
        $this->platformStats = $platforms->pluck('total', 'application_source')->toArray();
        
        // 6. Overall Status Breakdown
        $statuses = \App\Models\Application::where('user_id', $userId)
            ->select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
            
        $this->statusStats = $statuses->pluck('total', 'status')->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
