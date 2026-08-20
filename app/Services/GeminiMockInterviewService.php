<?php

namespace App\Services;

use App\Models\User;
use App\Models\Application;

class GeminiMockInterviewService
{
    protected AIService $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function generatePrep(User $user, Application $application): string
    {
        $profile = $user->profile;
        if (!$profile) {
            return "No user profile found.";
        }

        $prompt = $this->buildPrompt($profile, $application);

        try {
            return $this->aiService->generateContent($prompt, 0.5, 1500, 3);
        } catch (\Exception $e) {
            \Log::error('Gemini API Error (Mock Interview)', ['exception' => $e->getMessage()]);
            throw new \Exception("Failed to generate interview prep. " . $e->getMessage());
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
You are an expert technical interviewer at {$company} conducting an interview for the {$jobTitle} role.

Given the candidate's background and the job description, create a tailored mock interview preparation guide.
Format the output in Markdown.

Include:
1. **Company Overview**: A brief note on what {$company} does and what they usually look for in candidates (based on general knowledge).
2. **Top 5 Potential Questions**: 
    - 2 Behavioral questions based on the resume vs job gap.
    - 3 Technical/Domain-specific questions related to the job description.
3. **Key Areas to Review**: What technical or domain concepts should the candidate brush up on before the interview?
4. **Questions to Ask the Interviewer**: Suggest 2 thoughtful questions the candidate can ask at the end of the interview.

### Candidate Profile:
{$resumeText}

### Job Details:
Role: {$jobTitle}
Description:
{$jobDesc}

Please return ONLY the markdown preparation guide.
EOT;
    }
}
