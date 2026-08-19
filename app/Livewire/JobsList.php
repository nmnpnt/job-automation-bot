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

    public function exportCSV()
    {
        $userId = auth()->id();
        
        $query = Application::where('user_id', $userId)
                            ->orderBy('created_at', 'desc');

        if ($this->filterSource) {
            $query->where('application_source', $this->filterSource);
        }

        $jobs = $query->get();

        $csvHeader = ['Job Title', 'Company', 'Portal', 'Status', 'Applied At', 'URL'];
        
        $callback = function() use ($jobs, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);

            foreach ($jobs as $job) {
                fputcsv($file, [
                    $job->job_title,
                    $job->company_name,
                    $job->application_source->value ?? 'UNKNOWN',
                    $job->status->value ?? 'UNKNOWN',
                    $job->submitted_at ? $job->submitted_at->format('Y-m-d H:i:s') : 'N/A',
                    $job->original_job_url
                ]);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'jobs_export_' . date('Y-md_His') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
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

    public $schedulingJobId = null;
    public $interview_scheduled_at = '';
    public $interview_type = 'Technical Interview';
    public $interview_meeting_link = '';
    public $interview_notes = '';

    public function openScheduleModal($jobId)
    {
        $this->schedulingJobId = $jobId;
        $job = Application::findOrFail($jobId);
        
        $this->interview_scheduled_at = $job->interview_scheduled_at ? $job->interview_scheduled_at->format('Y-m-d\TH:i') : now()->addDays(2)->format('Y-m-d\T10:00');
        $this->interview_type = $job->interview_type ?? 'Technical Interview';
        $this->interview_meeting_link = $job->interview_meeting_link ?? '';
        $this->interview_notes = $job->interview_notes ?? '';

        $this->dispatch('open-modal', 'schedule-interview-modal');
    }

    public function saveScheduledInterview()
    {
        $this->validate([
            'interview_scheduled_at' => 'required|date',
            'interview_type' => 'required|string',
            'interview_meeting_link' => 'nullable|url',
            'interview_notes' => 'nullable|string',
        ]);

        try {
            $job = Application::findOrFail($this->schedulingJobId);
            $formattedDate = \Carbon\Carbon::parse($this->interview_scheduled_at)->format('M d, Y h:i A');

            $job->update([
                'status' => 'INTERVIEW_REQUESTED',
                'interview_scheduled_at' => $this->interview_scheduled_at,
                'interview_type' => $this->interview_type,
                'interview_meeting_link' => $this->interview_meeting_link,
                'interview_notes' => $this->interview_notes,
            ]);

            $job->events()->create([
                'event_type' => 'INTERVIEW_SCHEDULED',
                'message' => "Interview scheduled for {$formattedDate} ({$this->interview_type})."
            ]);

            // Dispatch alert to Slack and WhatsApp
            $alertMsg = "📅 *Interview Scheduled!*
Job: *{$job->job_title}* at *{$job->company_name}*
Time: *{$formattedDate}*
Round: {$this->interview_type}" . ($this->interview_meeting_link ? "\nLink: {$this->interview_meeting_link}" : "");

            auth()->user()->notifyChannels($alertMsg, 'success', 'notify_on_interview');

            $this->dispatch('close-modal', 'schedule-interview-modal');
            $this->dispatch('notify', ['message' => 'Interview scheduled & notifications sent!', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function markAsApplied($jobId)
    {
        try {
            $job = Application::findOrFail($jobId);
            $job->update([
                'status' => 'APPLIED',
                'submitted_at' => now(),
            ]);
            
            $job->events()->create([
                'event_type' => 'APPLIED',
                'message' => 'Manually marked as applied by user.'
            ]);

            // Notify channels
            $msg = "✅ *Job Applied!* You applied to *{$job->job_title}* at *{$job->company_name}*.";
            auth()->user()->notifyChannels($msg, 'info', 'notify_on_submitted');
            
            $this->dispatch('notify', ['message' => 'Job marked as applied!', 'type' => 'success']);
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
