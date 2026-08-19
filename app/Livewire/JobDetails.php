<?php

namespace App\Livewire;

use Livewire\Component;

class JobDetails extends Component
{
    public \App\Models\Application $job;

    public function mount($jobId)
    {
        $this->job = \App\Models\Application::with('events')->findOrFail($jobId);
        
        // Ensure user owns this job
        if ($this->job->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$this->job->is_read) {
            $this->job->update(['is_read' => true]);
        }
    }

    public function render()
    {
        return view('livewire.job-details')->layout('layouts.app');
    }
}
