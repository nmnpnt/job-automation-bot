<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Application;
use Livewire\Attributes\On;

class LiveActivityFeed extends Component
{
    public $activities = [];
    public $profile;

    public function mount()
    {
        $this->profile = \App\Models\Profile::where('user_id', auth()->id())->first();

        // Load recent applications and their latest events
        $this->activities = Application::with(['events' => function ($query) {
            $query->latest()->limit(1);
        }])
        ->where('user_id', auth()->id())
        ->latest('updated_at')
        ->limit(10)
        ->get()
        ->map(function ($app) {
            return $this->formatActivity($app, $app->status->value, $app->events->first()?->message ?? 'Application updated');
        })
        ->toArray();
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

    #[On('echo:activity-feed,.ActivityLogged')]
    public function handleNewActivity($event)
    {
        $appUserId = is_object($event['application']) ? $event['application']->user_id : ($event['application']['user_id'] ?? null);
        if ($appUserId != auth()->id()) {
            return;
        }

        // Add new activity to the top and keep only the latest 10
        array_unshift($this->activities, $this->formatActivity(
            (object) $event['application'],
            $event['status'],
            $event['message']
        ));
        
        $this->activities = array_slice($this->activities, 0, 10);
        
        $jobTitle = is_object($event['application']) ? $event['application']->job_title : ($event['application']['job_title'] ?? 'Job');
        $this->dispatch('activity-logged', message: $event['message'], title: 'Update: ' . $jobTitle);
    }

    private function formatActivity($app, $status, $message)
    {
        return [
            'id' => data_get($app, 'id'),
            'job_title' => data_get($app, 'job_title'),
            'company_name' => data_get($app, 'company_name'),
            'status' => $status,
            'message' => $message,
            'timestamp' => data_get($app, 'updated_at', now()),
            'error_screenshot_path' => data_get($app, 'error_screenshot_path'),
            'original_job_url' => data_get($app, 'original_job_url'),
        ];
    }

    public function render()
    {
        return view('livewire.live-activity-feed');
    }
}
