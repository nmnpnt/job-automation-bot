<?php

namespace App\Services;

class ResumeMatcherService
{
    protected AIService $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Call the Gemini API to match a resume to a job description.
     * Returns an array with 'score' (0-100) and 'reason' (string).
     */
    public function match(string $resumeText, string $jobDescription): array
    {
        $prompt = <<<PROMPT
You are an expert technical recruiter. I will provide a candidate's resume and a job description.
Evaluate how well the candidate matches the job description.
Return a JSON object containing exactly two keys:
1. "score": An integer from 0 to 100 representing the match percentage.
2. "reason": A 1-2 sentence string explaining why this score was given.

Output ONLY valid JSON.

RESUME:
{$resumeText}

JOB DESCRIPTION:
{$jobDescription}
PROMPT;

        try {
            $result = $this->aiService->generateJson($prompt, 0.4, 500);

            return [
                'score' => $result['score'] ?? 50,
                'reason' => $result['reason'] ?? 'Failed to parse reasoning from LLM.'
            ];
        } catch (\Exception $e) {
            \Log::error('Error communicating with Gemini API (Resume Matcher): ' . $e->getMessage());
            return ['score' => 50, 'reason' => 'Failed to reach AI matcher API or parse response.'];
        }
    }

    /**
     * Call the Gemini API to generate a cover letter based on resume and job description.
     */
    public function generateCoverLetter(string $resumeText, string $jobDescription): string
    {
        $prompt = <<<PROMPT
You are an expert technical candidate writing a cover letter. 
Write a short, professional, and highly tailored cover letter (max 3 paragraphs) for this job using the candidate's resume.
Do not include placeholder text like [Your Name] or [Company Name] if you can extract or infer it. If you can't, keep it generic.
Make it sound human, passionate, and directly highlight the overlapping skills.

RESUME:
{$resumeText}

JOB DESCRIPTION:
{$jobDescription}
PROMPT;

        try {
            return $this->aiService->generateContent($prompt, 0.7, 800);
        } catch (\Exception $e) {
            \Log::error('Error generating cover letter (Matcher): ' . $e->getMessage());
            return "Dear Hiring Manager,\n\nI am writing to express my interest in this position. Please find my resume attached.\n\nBest regards,";
        }
    }
}
