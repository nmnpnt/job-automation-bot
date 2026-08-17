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
    public $profile;

    public function mount()
    {
        $userId = auth()->id();
        $this->profile = \App\Models\Profile::where('user_id', $userId)->first();

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
            
        $this->platformStats = $platforms->mapWithKeys(function ($item) {
            return [$item->application_source->value => $item->total];
        })->toArray();
        
        // 6. Overall Status Breakdown
        $statuses = \App\Models\Application::where('user_id', $userId)
            ->select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
            
        $this->statusStats = $statuses->mapWithKeys(function ($item) {
            return [$item->status->value => $item->total];
        })->toArray();
    }

    public function startScraping()
    {
        if ($this->profile && $this->profile->scraping_status !== 'running') {
            $this->profile->update(['scraping_status' => 'running']);
            \App\Jobs\RunScraperJob::dispatch($this->profile->id);
        }
    }

    public function render()
    {
        if ($this->profile) {
            $this->profile->refresh();
        }
        return view('livewire.dashboard');
    }
}
