<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Application;
use App\Enums\ApplicationSource;

class JobsList extends Component
{
    use WithPagination;

    public $filterSource = '';
    public $generatedCoverLetter = null;
    public $generatedFeedback = null;
    public $generatedInterviewPrep = null;
    public $selectedJobId = null;
    public $isGenerating = false;
    public $isAnalyzing = false;
    public $isPreparing = false;

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

    public function analyzeMatch($jobId)
    {
        $this->isAnalyzing = true;
        $this->selectedJobId = $jobId;
        $this->generatedFeedback = null;

        try {
            $job = Application::findOrFail($jobId);
            $service = app(\App\Services\GeminiResumeAnalyzerService::class);
            $this->generatedFeedback = $service->analyzeMatch(auth()->user(), $job);
            
            // Optionally save it to the job model
            $job->update(['resume_feedback' => $this->generatedFeedback]);

        } catch (\Exception $e) {
            $this->generatedFeedback = "Error analyzing resume match: " . $e->getMessage();
        }

        $this->isAnalyzing = false;
        
        $this->dispatch('open-modal', 'resume-feedback-modal');
    }

    public function markAsApplied($jobId)
    {
        try {
            $job = Application::findOrFail($jobId);
            $job->update(['status' => 'APPLIED']);
            
            // Optionally log an event
            $job->events()->create([
                'event_type' => 'APPLIED',
                'message' => 'Manually marked as applied by user.'
            ]);
            
            $this->dispatch('notify', ['message' => 'Job marked as applied!', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function autoApply($jobId)
    {
        try {
            $job = Application::findOrFail($jobId);
            
            // Dispatch the automated background job
            \App\Jobs\ProcessApplication::dispatch($job);
            
            $job->update(['status' => 'AUTO_APPLYING']);
            
            $job->events()->create([
                'event_type' => 'AUTO_APPLYING',
                'message' => 'User manually triggered auto-apply bot.'
            ]);
            
            $this->dispatch('notify', ['message' => 'Auto-Apply bot started in background!', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function markAsInterviewRequested($jobId)
    {
        try {
            $job = Application::findOrFail($jobId);
            $job->update(['status' => 'INTERVIEW_REQUESTED']);
            
            $job->events()->create([
                'event_type' => 'INTERVIEW_REQUESTED',
                'message' => 'User manually marked job as interview requested.'
            ]);
            
            $this->dispatch('notify', ['message' => 'Awesome! Job marked for interview.', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function generateInterviewPrep($jobId)
    {
        $this->isPreparing = true;
        $this->selectedJobId = $jobId;
        $this->generatedInterviewPrep = null;

        try {
            $job = Application::findOrFail($jobId);
            $service = app(\App\Services\GeminiMockInterviewService::class);
            $this->generatedInterviewPrep = $service->generatePrep(auth()->user(), $job);
            
            // Save it to the job model
            $job->update(['interview_prep_notes' => $this->generatedInterviewPrep]);

        } catch (\Exception $e) {
            $this->generatedInterviewPrep = "Error generating interview prep: " . $e->getMessage();
        }

        $this->isPreparing = false;
        
        $this->dispatch('open-modal', 'interview-prep-modal');
    }

    #[On('echo:activity-feed,.ActivityLogged')]
    public function refreshList()
    {
        // This method will be called when the ActivityLogged event is broadcasted on the activity-feed channel.
        // It doesn't need to do anything; simply defining it with the #[On] attribute
        // will cause Livewire to re-render the component and fetch the latest data from the database.
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
