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

    public $generatedCoverLetter = null;
    public $generatedFeedback = null;
    public $generatedInterviewPrep = null;
    public $isGenerating = false;
    public $isAnalyzing = false;
    public $isPreparing = false;
    public $isFetchingDetails = false;

    public $isEditingDescription = false;
    public $editDescriptionText = '';

    public $interview_scheduled_at = '';
    public $interview_type = 'Technical Interview';
    public $interview_round = 'Round 1';
    public $interview_meeting_link = '';
    public $interview_notes = '';

    public function editDescription()
    {
        $this->editDescriptionText = $this->job->description;
        $this->isEditingDescription = true;
    }

    public function saveDescription()
    {
        $this->job->update(['description' => $this->editDescriptionText]);
        $this->isEditingDescription = false;
        $this->dispatch('notify', ['message' => 'Job description updated manually!', 'type' => 'success']);
    }

    public function manualFetchDescription()
    {
        $this->isFetchingDetails = true;
        try {
            $orchestrator = app(\App\Services\ScraperOrchestrator::class);
            $success = $orchestrator->fetchJobDetails($this->job);
            if ($success) {
                $this->job->refresh();
                $this->dispatch('notify', ['message' => 'Job description fetched successfully!', 'type' => 'success']);
            } else {
                $this->dispatch('notify', ['message' => 'Could not fetch job description automatically. Check if the URL is valid or blocked.', 'type' => 'warning']);
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error fetching details: ' . $e->getMessage(), 'type' => 'error']);
        }
        $this->isFetchingDetails = false;
    }

    private function ensureJobDetails()
    {
        if (empty($this->job->description) && !empty($this->job->original_job_url)) {
            $this->isFetchingDetails = true;
            try {
                $orchestrator = app(\App\Services\ScraperOrchestrator::class);
                $success = $orchestrator->fetchJobDetails($this->job);
                if ($success) {
                    $this->job->refresh(); // get updated description
                }
            } catch (\Exception $e) {
                \Log::error('Failed to fetch job details on demand: ' . $e->getMessage());
            }
            $this->isFetchingDetails = false;
        }
    }

    public function openCoverLetterModal()
    {
        $this->generatedCoverLetter = $this->job->cover_letter;
        $this->dispatch('open-modal', 'cover-letter-modal');
    }

    public function generateCoverLetter()
    {
        $this->ensureJobDetails();
        $this->isGenerating = true;
        try {
            $service = app(\App\Services\GeminiCoverLetterService::class);
            $this->generatedCoverLetter = $service->generateCoverLetter(auth()->user(), $this->job);
            
            $this->job->update(['cover_letter' => $this->generatedCoverLetter]);
        } catch (\Exception $e) {
            $this->generatedCoverLetter = "Error generating cover letter: " . $e->getMessage();
        }
        $this->isGenerating = false;
    }

    public function openResumeMatchModal()
    {
        $this->generatedFeedback = $this->job->resume_feedback;
        $this->dispatch('open-modal', 'resume-feedback-modal');
    }

    public function analyzeMatch()
    {
        $this->ensureJobDetails();
        $this->isAnalyzing = true;
        try {
            $service = app(\App\Services\GeminiResumeAnalyzerService::class);
            $result = $service->analyzeMatch(auth()->user(), $this->job);
            
            $this->generatedFeedback = $result['feedback'];
            
            // Save both feedback and score to the job model
            $updateData = ['resume_feedback' => $this->generatedFeedback];
            if ($result['score'] !== null) {
                $updateData['match_score'] = $result['score'];
            }
            
            $this->job->update($updateData);
        } catch (\Exception $e) {
            $this->generatedFeedback = "Error analyzing resume match: " . $e->getMessage();
        }
        $this->isAnalyzing = false;
    }

    public function openInterviewPrepModal()
    {
        $this->generatedInterviewPrep = $this->job->interview_prep_notes;
        $this->dispatch('open-modal', 'interview-prep-modal');
    }

    public function generateInterviewPrep()
    {
        $this->ensureJobDetails();
        $this->isPreparing = true;
        try {
            $service = app(\App\Services\GeminiMockInterviewService::class);
            $this->generatedInterviewPrep = $service->generatePrep(auth()->user(), $this->job);
            
            // Save it to the job model
            $this->job->update(['interview_prep_notes' => $this->generatedInterviewPrep]);
        } catch (\Exception $e) {
            $this->generatedInterviewPrep = "Error generating interview prep: " . $e->getMessage();
        }
        $this->isPreparing = false;
    }

    public function openScheduleModal()
    {
        $this->interview_scheduled_at = $this->job->interview_scheduled_at ? $this->job->interview_scheduled_at->format('Y-m-d\TH:i') : now()->addDays(2)->format('Y-m-d\T10:00');
        $this->interview_type = $this->job->interview_type ?? 'Technical Interview';
        $this->interview_round = $this->job->interview_round ?? 'Round 1';
        $this->interview_meeting_link = $this->job->interview_meeting_link ?? '';
        $this->interview_notes = $this->job->interview_notes ?? '';

        $this->dispatch('open-modal', 'schedule-interview-modal');
    }

    public function saveScheduledInterview()
    {
        $this->validate([
            'interview_scheduled_at' => 'required|date',
            'interview_type' => 'required|string',
            'interview_round' => 'required|string',
            'interview_meeting_link' => 'nullable|url',
            'interview_notes' => 'nullable|string',
        ]);

        try {
            // Prevent duplicate interview round
            $duplicate = $this->job->events()
                ->where('event_type', 'INTERVIEW_SCHEDULED')
                ->where('message', 'like', "%Round: {$this->interview_round}%")
                ->exists();

            if ($duplicate) {
                $this->dispatch('notify', ['message' => "An interview for {$this->interview_round} is already scheduled.", 'type' => 'error']);
                return;
            }

            $formattedDate = \Carbon\Carbon::parse($this->interview_scheduled_at)->format('M d, Y h:i A');

            $this->job->update([
                'status' => 'INTERVIEW_REQUESTED',
                'interview_scheduled_at' => $this->interview_scheduled_at,
                'interview_type' => $this->interview_type,
                'interview_round' => $this->interview_round,
                'interview_meeting_link' => $this->interview_meeting_link,
                'interview_notes' => $this->interview_notes,
            ]);

            $this->job->events()->create([
                'event_type' => 'INTERVIEW_SCHEDULED',
                'message' => "Interview scheduled for {$formattedDate} ({$this->interview_type}). Round: {$this->interview_round}"
            ]);

            // Dispatch alert to Slack and WhatsApp
            $alertMsg = "📅 *Interview Scheduled!*\nJob: *{$this->job->job_title}* at *{$this->job->company_name}*\nTime: *{$formattedDate}*\nType: {$this->interview_type}\nRound: {$this->interview_round}" . ($this->interview_meeting_link ? "\nLink: {$this->interview_meeting_link}" : "");

            auth()->user()->notifyChannels($alertMsg, 'success', 'notify_on_interview');

            $this->dispatch('close-modal', 'schedule-interview-modal');
            $this->dispatch('notify', ['message' => 'Interview scheduled & notifications sent!', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function markAsApplied()
    {
        try {
            if ($this->job->status !== \App\Enums\ApplicationStatus::DISCOVERED && $this->job->status !== \App\Enums\ApplicationStatus::MATCHED && $this->job->status !== \App\Enums\ApplicationStatus::READY_TO_APPLY) {
                $this->dispatch('notify', ['message' => 'Job is already marked as applied or further along.', 'type' => 'error']);
                return;
            }

            $this->job->update([
                'status' => 'APPLIED',
                'submitted_at' => now(),
            ]);
            
            $this->job->events()->create([
                'event_type' => 'APPLIED',
                'message' => 'Manually marked as applied by user.'
            ]);

            // Notify channels
            $msg = "✅ *Job Applied!* You applied to *{$this->job->job_title}* at *{$this->job->company_name}*.";
            auth()->user()->notifyChannels($msg, 'info', 'notify_on_submitted');
            
            $this->dispatch('notify', ['message' => 'Job marked as applied!', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function render()
    {
        return view('livewire.job-details')->layout('layouts.app');
    }
}
