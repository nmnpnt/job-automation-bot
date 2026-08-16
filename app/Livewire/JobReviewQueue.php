<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Application;
use App\Enums\ApplicationStatus;
use App\Services\JobApplicationEngine;
use App\Services\ApplicationSourceDetector;
use App\Services\ResumeMatcherService;

class JobReviewQueue extends Component
{
    public function approve($applicationId)
    {
        $application = Application::where('user_id', auth()->id())->findOrFail($applicationId);
        
        if ($application->status === ApplicationStatus::PENDING_REVIEW) {
            $application->update([
                'status' => ApplicationStatus::READY_TO_APPLY
            ]);
            
            $application->events()->create([
                'event_type' => ApplicationStatus::READY_TO_APPLY->value,
                'message' => 'Manually approved for auto-apply.'
            ]);
            
            event(new \App\Events\ActivityLogged($application, ApplicationStatus::READY_TO_APPLY->value, 'Manually approved for auto-apply.'));

            // Execute the application
            $detector = app(ApplicationSourceDetector::class);
            $provider = $detector->getProvider($application->original_job_url);
            
            if ($provider) {
                app(JobApplicationEngine::class)->executeApplication($application, $provider);
            }
        }
    }

    public function reject($applicationId)
    {
        $application = Application::where('user_id', auth()->id())->findOrFail($applicationId);
        
        if ($application->status === ApplicationStatus::PENDING_REVIEW) {
            $application->update([
                'status' => ApplicationStatus::SKIPPED
            ]);
            
            $application->events()->create([
                'event_type' => ApplicationStatus::SKIPPED->value,
                'message' => 'Manually rejected by user.'
            ]);
            
            event(new \App\Events\ActivityLogged($application, ApplicationStatus::SKIPPED->value, 'Manually rejected by user.'));
        }
    }

    public function render()
    {
        $pendingJobs = Application::where('user_id', auth()->id())
            ->where('status', ApplicationStatus::PENDING_REVIEW->value)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('livewire.job-review-queue', [
            'pendingJobs' => $pendingJobs
        ]);
    }
}
