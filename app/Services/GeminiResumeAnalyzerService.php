<?php

namespace App\Services;

use App\Models\User;
use App\Models\Application;

class GeminiResumeAnalyzerService
{
    protected AIService $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function analyzeMatch(User $user, Application $application): string
    {
        $profile = $user->profile;
        if (!$profile) {
            return "No user profile found.";
        }

        $prompt = $this->buildPrompt($profile, $application);

        try {
            return $this->aiService->generateContent($prompt, 0.4, 1024, 3);
        } catch (\Exception $e) {
            \Log::error('Gemini API Error (Resume Analyzer)', ['exception' => $e->getMessage()]);
            throw new \Exception("Failed to generate resume feedback. " . $e->getMessage());
        }
    }

    protected function buildPrompt($profile, Application $application): string
    {
        $jobTitle = $application->job_title ?? 'Unknown Title';
        $company = $application->company_name ?? 'Unknown Company';
        $jobDesc = $application->description ?? $application->job_description ?? 'No job description provided.';

        $defaultResume = $application->user->resumes()->where('is_default', true)->first();
        if (!$defaultResume) {
            $defaultResume = $application->user->resumes()->first();
        }

        $resumeText = "Candidate Name: {$profile->first_name} {$profile->last_name}\n";
        $resumeText .= "Candidate Background/Resume:\n" . ($defaultResume ? $defaultResume->full_text : 'No resume provided.'); 

        return <<<EOT
You are an expert technical recruiter and resume reviewer.

Analyze the candidate's profile/resume against the provided job description.
Provide concise feedback in Markdown format.

1. **Match Score**: Give a percentage (e.g. 85%).
2. **Strengths**: What does the candidate have that matches well?
3. **Missing Keywords/Skills**: What important skills or keywords from the JD are missing from the resume?
4. **Suggestions**: 1-2 actionable suggestions to improve the resume for this specific role.

### Candidate Profile:
{$resumeText}

### Job Details:
Role: {$jobTitle} at {$company}
Description:
{$jobDesc}

Please return ONLY the markdown feedback.
EOT;
    }
}
