<?php

namespace App\Livewire;

use Livewire\Component;

class AutomationsHub extends Component
{
    public function triggerScrape($platform = null)
    {
        $args = ['user_id' => auth()->id()];
        if ($platform) {
            $args['platform'] = $platform;
        }
        
        \App\Jobs\RunArtisanCommand::dispatch('jobs:scrape', $args);
        
        $platformName = $platform ? ucfirst(strtolower($platform)) : 'All Platforms';
        session()->flash('status', "Job Scraper task queued successfully for {$platformName}!");
    }

    public function triggerEmailCheck()
    {
        \App\Jobs\RunArtisanCommand::dispatch('app:check-emails');
        session()->flash('status', 'Email Parser task queued successfully!');
    }

    public function triggerSimulateActivity()
    {
        \App\Jobs\RunArtisanCommand::dispatch('app:simulate-activity');
        session()->flash('status', 'Activity Simulation queued successfully!');
    }

    public function render()
    {
        return view('livewire.automations-hub');
    }
}
