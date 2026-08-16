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

    #[On('echo:activity-feed,ActivityLogged')]
    public function handleNewActivity($event)
    {
        // Add new activity to the top and keep only the latest 10
        array_unshift($this->activities, $this->formatActivity(
            (object) $event['application'],
            $event['status'],
            $event['message']
        ));
        
        $this->activities = array_slice($this->activities, 0, 10);
    }

    private function formatActivity($app, $status, $message)
    {
        return [
            'id' => is_object($app) ? $app->id : $app['id'],
            'job_title' => is_object($app) ? $app->job_title : $app['job_title'],
            'company_name' => is_object($app) ? $app->company_name : $app['company_name'],
            'status' => $status,
            'message' => $message,
            'timestamp' => now()->diffForHumans(),
            'error_screenshot_path' => is_object($app) ? $app->error_screenshot_path : ($app['error_screenshot_path'] ?? null),
        ];
    }

    public function render()
    {
        return view('livewire.live-activity-feed');
    }
}
