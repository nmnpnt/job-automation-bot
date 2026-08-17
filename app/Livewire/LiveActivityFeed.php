<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Application;
use Livewire\Attributes\On;

class LiveActivityFeed extends Component
{
    public $activities = [];

    public function mount()
    {
        // Load recent applications and their latest events
        $this->activities = Application::with(['events' => function ($query) {
            $query->latest()->limit(1);
        }])
        ->latest('updated_at')
        ->limit(10)
        ->get()
        ->map(function ($app) {
            return $this->formatActivity($app, $app->status->value, $app->events->first()?->message ?? 'Application updated');
        })
        ->toArray();
    }

    #[On('echo:activity-feed,.ActivityLogged')]
    public function handleNewActivity($event)
    {
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
