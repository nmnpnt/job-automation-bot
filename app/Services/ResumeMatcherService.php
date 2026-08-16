<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ResumeMatcherService
{
    /**
     * Call the Gemini API to match a resume to a job description.
     * Returns an array with 'score' (0-100) and 'reason' (string).
     */
    public function match(string $resumeText, string $jobDescription): array
    {
        $apiKey = config('services.gemini.key');
        if (!$apiKey) {
            Log::warning('Gemini API key is not set. Defaulting to high match score.');
            return ['score' => 100, 'reason' => 'Gemini API key missing. Assumed match.'];
        }

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
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'response_mime_type' => 'application/json',
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $jsonText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
                $result = json_decode($jsonText, true);

                return [
                    'score' => $result['score'] ?? 50,
                    'reason' => $result['reason'] ?? 'Failed to parse reasoning from LLM.'
                ];
            }

            Log::error('Gemini API returned an error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Error communicating with Gemini API: ' . $e->getMessage());
        }

        // Fallback
        return ['score' => 50, 'reason' => 'Failed to reach AI matcher API.'];
    }

    /**
     * Call the Gemini API to generate a cover letter based on resume and job description.
     */
    public function generateCoverLetter(string $resumeText, string $jobDescription): string
    {
        $apiKey = config('services.gemini.key');
        if (!$apiKey) {
            return "Dear Hiring Manager,\n\nI am very interested in this role and believe my skills would be a great fit.\n\nSincerely,\nCandidate";
        }

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
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            }
        } catch (\Exception $e) {
            Log::error('Error generating cover letter: ' . $e->getMessage());
        }

        return "Dear Hiring Manager,\n\nI am writing to express my interest in this position. Please find my resume attached.\n\nBest regards,";
    }
}
