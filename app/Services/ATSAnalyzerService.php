<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\Application;

class ATSAnalyzerService
{
    protected AIService $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function analyze(\App\Models\User $user, ?Application $job): array
    {
        $resumeText = "";
        
        if ($user->profile && !empty($user->profile->resume_text)) {
            $resumeText = $user->profile->resume_text;
        } else {
            $defaultResume = $user->resumes()->where('is_default', true)->first();
            if ($defaultResume) {
                // Uses the getFullTextAttribute added previously
                $resumeText = $defaultResume->full_text ?? '';
            }
        }

        if (empty(trim($resumeText))) {
            throw new \Exception("No resume found. Please upload one in your Profile Settings or build one using the AI Builder.");
        }

        if ($job) {
            $jobDesc = $job->description ?? $job->job_description ?? 'No job description provided.';
            $prompt = <<<PROMPT
You are an advanced Applicant Tracking System (ATS) and an expert technical recruiter.
I will provide a candidate's resume and a job description. Evaluate how well the candidate matches the job description, strictly focusing on keywords, skills, and experience.

Return a JSON object containing EXACTLY these keys:
1. "ats_score": An integer (0-100) representing the overall match percentage.
2. "keyword_match_score": An integer (0-100) representing how well the required skills in the JD match the resume.
3. "missing_keywords": An array of strings representing important skills or tools mentioned in the JD that are completely missing from the resume.
4. "suggestions": An array of strings representing actionable recommendations to improve the resume for this specific role.

Output ONLY valid JSON. Do not include markdown formatting or extra text.

RESUME:
{$resumeText}

JOB DESCRIPTION:
{$jobDesc}
PROMPT;
        } else {
            $prompt = <<<PROMPT
You are an advanced Applicant Tracking System (ATS) and an expert technical recruiter.
I will provide a candidate's resume. Perform a general evaluation of its strength, clarity, and keyword optimization for software engineering roles.

Return a JSON object containing EXACTLY these keys:
1. "ats_score": An integer (0-100) representing the overall quality and parsability.
2. "keyword_match_score": An integer (0-100) representing the strength of industry-standard keywords.
3. "missing_keywords": An array of strings representing common industry skills that might be beneficial to add based on the current content.
4. "suggestions": An array of strings representing actionable recommendations to improve the resume generally.

Output ONLY valid JSON. Do not include markdown formatting or extra text.

RESUME:
{$resumeText}
PROMPT;
        }

        try {
            $result = $this->aiService->generateJson($prompt, 0.3, 2500, 3);
            
            return [
                'ats_score' => $result['ats_score'] ?? 0,
                'keyword_match_score' => $result['keyword_match_score'] ?? 0,
                'missing_keywords' => $result['missing_keywords'] ?? [],
                'suggestions' => $result['suggestions'] ?? [],
            ];
            
        } catch (\Exception $e) {
            \Log::error('ATS Analyzer Error: ' . $e->getMessage());
            throw new \Exception("Failed to analyze resume for ATS compatibility. " . $e->getMessage());
        }
    }
}
