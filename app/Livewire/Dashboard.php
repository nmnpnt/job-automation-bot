<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $totalJobs = 0;
    public $totalApplied = 0;
    public $successRate = 0;
    public $interviews = 0;
    public $upcomingInterviews = [];
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

        // 4b. Upcoming Scheduled Interviews
        $this->upcomingInterviews = \App\Models\Application::where('user_id', $userId)
            ->whereNotNull('interview_scheduled_at')
            ->orderBy('interview_scheduled_at', 'asc')
            ->take(5)
            ->get();

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
            $this->profile->update(['scraping_status' => 'running', 'scraper_pid' => null]);
            try {
                \App\Jobs\RunUserScraperJob::dispatch($this->profile->user_id, null, 'manual');
            } catch (\Exception $e) {
                $this->profile->update(['scraping_status' => 'idle']);
                throw $e;
            }
        }
    }

    public function stopScraping()
    {
        if ($this->profile && $this->profile->scraping_status === 'running') {
            if ($this->profile->scraper_pid) {
                // Kill the node process
                // Using taskkill on Windows, kill on Unix
                if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
                    exec("taskkill /F /PID {$this->profile->scraper_pid} /T");
                } else {
                    exec("kill -TERM {$this->profile->scraper_pid}");
                }
            }
            $this->profile->update(['scraping_status' => 'idle', 'scraper_pid' => null]);
            $logFile = storage_path("logs/scraper-{$this->profile->user_id}.log");
            file_put_contents($logFile, "\n[SYSTEM] Scraper manually stopped by user.\n", FILE_APPEND);
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
