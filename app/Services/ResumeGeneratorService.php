<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\Job;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResumeGeneratorService
{
    /**
     * Generate a tailored PDF resume for a specific job application.
     *
     * @param Profile $profile
     * @param Job $job
     * @return string Path to the generated PDF relative to the storage app folder.
     */
    public function generateTailoredResume(Profile $profile, Job $job): string
    {
        // For a full implementation, you'd use LLM to rewrite sections of $profile->resume_text
        // Here we'll just pass the standard profile data to a Blade view that formats it.
        // And append the Job Title as a "Targeted Role" to demonstrate tailoring.
        
        $data = [
            'profile' => $profile,
            'job' => $job,
        ];

        $pdf = Pdf::loadView('resumes.tailored', $data);

        $filename = 'resume_' . Str::slug($job->company_name) . '_' . time() . '.pdf';
        $path = 'resumes/' . $filename;
        
        Storage::disk('local')->put($path, $pdf->output());

        return Storage::disk('local')->path($path);
    }
}
