<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Application;

class InterviewsList extends Component
{
    use WithPagination;

    public $schedulingJobId = null;
    public $interview_scheduled_at = '';
    public $interview_type = 'Technical Interview';
    public $interview_round = 'Round 1';
    public $interview_meeting_link = '';
    public $interview_notes = '';

    public function editInterview($jobId)
    {
        $this->schedulingJobId = $jobId;
        $job = Application::findOrFail($jobId);
        
        $this->interview_scheduled_at = $job->interview_scheduled_at ? $job->interview_scheduled_at->format('Y-m-d\TH:i') : now()->addDays(2)->format('Y-m-d\T10:00');
        $this->interview_type = $job->interview_type ?? 'Technical Interview';
        $this->interview_round = $job->interview_round ?? 'Round 1';
        $this->interview_meeting_link = $job->interview_meeting_link ?? '';
        $this->interview_notes = $job->interview_notes ?? '';

        $this->dispatch('open-modal', 'edit-interview-modal');
    }

    public function saveInterview()
    {
        $this->validate([
            'interview_scheduled_at' => 'required|date',
            'interview_type' => 'required|string',
            'interview_round' => 'required|string',
            'interview_meeting_link' => 'nullable|url',
            'interview_notes' => 'nullable|string',
        ]);

        try {
            $job = Application::findOrFail($this->schedulingJobId);

            $formattedDate = \Carbon\Carbon::parse($this->interview_scheduled_at)->format('M d, Y h:i A');

            $job->update([
                'interview_scheduled_at' => $this->interview_scheduled_at,
                'interview_type' => $this->interview_type,
                'interview_round' => $this->interview_round,
                'interview_meeting_link' => $this->interview_meeting_link,
                'interview_notes' => $this->interview_notes,
            ]);

            $job->events()->create([
                'event_type' => 'INTERVIEW_UPDATED',
                'message' => "Interview updated to {$formattedDate} ({$this->interview_type}). Round: {$this->interview_round}"
            ]);

            $this->dispatch('close-modal', 'edit-interview-modal');
            $this->dispatch('notify', ['message' => 'Interview updated successfully!', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function cancelInterview($jobId)
    {
        try {
            $job = Application::findOrFail($jobId);
            $job->update([
                'status' => 'PENDING_REVIEW',
                'interview_scheduled_at' => null,
                'interview_type' => null,
                'interview_round' => null,
                'interview_meeting_link' => null,
                'interview_notes' => null,
            ]);
            $job->events()->create([
                'event_type' => 'INTERVIEW_CANCELLED',
                'message' => 'Interview was cancelled and moved back to review.'
            ]);
            $this->dispatch('notify', ['message' => 'Interview cancelled.', 'type' => 'info']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function markDone($jobId)
    {
        try {
            $job = Application::findOrFail($jobId);
            $job->update([
                'status' => 'INTERVIEW_COMPLETED'
            ]);
            $job->events()->create([
                'event_type' => 'INTERVIEW_COMPLETED',
                'message' => 'Interview marked as completed.'
            ]);
            $this->dispatch('notify', ['message' => 'Interview marked as completed!', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function markRejected($jobId)
    {
        try {
            $job = Application::findOrFail($jobId);
            $job->update([
                'status' => 'REJECTED'
            ]);
            $job->events()->create([
                'event_type' => 'REJECTED',
                'message' => 'Application rejected after interview.'
            ]);
            $this->dispatch('notify', ['message' => 'Application marked as rejected.', 'type' => 'info']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    #[On('echo:activity-feed,.ActivityLogged')]
    public function refreshList()
    {
        // Re-render
    }

    public function render()
    {
        $userId = auth()->id();
        
        $interviews = Application::where('user_id', $userId)
            ->whereIn('status', ['INTERVIEW_REQUESTED', 'INTERVIEW_COMPLETED'])
            ->orderBy('interview_scheduled_at', 'asc')
            ->paginate(15);

        return view('livewire.interviews-list', [
            'interviews' => $interviews,
        ])->layout('layouts.app');
    }
}
