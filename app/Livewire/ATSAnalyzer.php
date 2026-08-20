<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resume;
use App\Models\Application;
use App\Services\ATSAnalyzerService;

class ATSAnalyzer extends Component
{
    public $resumeId = '';
    public $jobId = '';
    public $jobDescription = '';
    public $mode = 'job_id'; // 'job_id' or 'manual'

    public $analysisResult = null;
    public $isAnalyzing = false;

    public function analyze(ATSAnalyzerService $analyzerService)
    {
        $this->validate([
            'mode' => 'required|in:job_id,manual,none',
        ]);

        $job = null;
        if ($this->mode === 'job_id') {
            $this->validate([
                'jobId' => 'required|exists:applications,id',
            ]);
            $job = Application::findOrFail($this->jobId);
            
            // Ensure they own it
            if ($job->user_id !== auth()->id()) abort(403);
            
        } elseif ($this->mode === 'manual') {
            $this->validate([
                'jobDescription' => 'required|string|min:10',
            ]);
            $job = new Application([
                'description' => $this->jobDescription
            ]);
        }

        $this->isAnalyzing = true;
        $this->analysisResult = null;

        try {
            $this->analysisResult = $analyzerService->analyze(auth()->user(), $job);
            $this->dispatch('notify', ['message' => 'Resume analysis complete!', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => $e->getMessage(), 'type' => 'error']);
        }
        
        $this->isAnalyzing = false;
    }

    public function render()
    {
        $jobs = auth()->user()->applications()->where('is_saved', true)->latest()->get();

        return view('livewire.a-t-s-analyzer', [
            'jobs' => $jobs,
        ])->layout('layouts.app');
    }
}
