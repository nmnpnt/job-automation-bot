<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Application;
use App\Enums\ApplicationSource;

class JobsList extends Component
{
    use WithPagination;

    public $filterSource = '';
    public $generatedCoverLetter = null;
    public $selectedJobId = null;
    public $isGenerating = false;

    public function updatedFilterSource()
    {
        $this->resetPage();
    }

    public function generateCoverLetter($jobId)
    {
        $this->isGenerating = true;
        $this->selectedJobId = $jobId;
        $this->generatedCoverLetter = null;

        try {
            $job = Application::findOrFail($jobId);
            $service = app(\App\Services\GeminiCoverLetterService::class);
            $this->generatedCoverLetter = $service->generateCoverLetter(auth()->user(), $job);
        } catch (\Exception $e) {
            $this->generatedCoverLetter = "Error generating cover letter: " . $e->getMessage();
        }

        $this->isGenerating = false;
        
        $this->dispatch('open-modal', 'cover-letter-modal');
    }

    public function render()
    {
        $userId = auth()->id();
        
        $query = Application::where('user_id', $userId)
                            ->orderBy('created_at', 'desc');

        if ($this->filterSource) {
            $query->where('application_source', $this->filterSource);
        }

        $jobs = $query->paginate(20);

        return view('livewire.jobs-list', [
            'jobs' => $jobs,
            'sources' => ApplicationSource::cases()
        ])->layout('layouts.app');
    }
}
