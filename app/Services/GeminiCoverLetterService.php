<?php

namespace App\Services;

use App\Models\User;
use App\Models\Application;

class GeminiCoverLetterService
{
    protected AIService $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Generate a personalized cover letter using Google's Gemini API.
     *
     * @param User $user
     * @param Application $job
     * @return string
     */
    public function generateCoverLetter(User $user, Application $job): string
    {
        $prompt = $this->buildPrompt($user, $job);

        try {
            return $this->aiService->generateContent($prompt, 0.7, 800, 3);
        } catch (\Exception $e) {
            \Log::error('Exception during Gemini API call (Cover Letter): ' . $e->getMessage());
            return "An error occurred while generating the cover letter. Please try again later.";
        }
    }

    /**
     * Construct the prompt for the LLM based on user profile and job description.
     */
    private function buildPrompt(User $user, Application $job): string
    {
        $userName = $user->name;
        
        $defaultResume = $user->resumes()->where('is_default', true)->first();
        if (!$defaultResume) {
            $defaultResume = $user->resumes()->first();
        }

        $userSkills = $defaultResume ? $defaultResume->full_text : "No specific skills or resume provided."; 
        
        $jobTitle = $job->job_title;
        $companyName = $job->company_name;
        // Use the newly added description column if available
        $jobDescription = $job->description ?? $job->job_description ?? 'A software engineering role focusing on web development.';

        return <<<EOT
You are an expert career coach and technical writer. 
Write a concise, professional, and highly tailored cover letter for the following job application.

Candidate Name: {$userName}
Candidate Core Skills: {$userSkills}

Job Title: {$jobTitle}
Company: {$companyName}
Job Description summary:
{$jobDescription}

Requirements:
- Keep it under 300 words.
- Tone: Professional, enthusiastic, and confident.
- Do not include placeholders like "[Your Address]" or "[Date]" at the top. Just start with the salutation (e.g., "Dear Hiring Manager,").
- Focus on how the candidate's skills align with the job title and company.
- Conclude with a strong call to action for an interview.
EOT;
    }
}
