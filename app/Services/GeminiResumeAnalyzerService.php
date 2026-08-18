<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Application;

class GeminiResumeAnalyzerService
{
    protected string $apiKey;
    protected string $model = 'gemini-1.5-flash';

    public function __construct()
    {
        $this->apiKey = (string) config('services.gemini.api_key', '');
    }

    public function analyzeMatch(User $user, Application $application): string
    {
        if (empty($this->apiKey)) {
            return "Gemini API key not configured.";
        }

        $profile = $user->profile;
        if (!$profile) {
            return "No user profile found.";
        }

        $prompt = $this->buildPrompt($profile, $application);

        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.4,
                'maxOutputTokens' => 1024,
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? "Failed to extract feedback from Gemini response.";
        }

        \Log::error('Gemini API Error (Resume Analyzer)', ['response' => $response->body()]);
        throw new \Exception("Failed to generate resume feedback. Gemini API returned: " . $response->status());
    }

    protected function buildPrompt($profile, Application $application): string
    {
        $jobTitle = $application->job_title ?? 'Unknown Title';
        $company = $application->company_name ?? 'Unknown Company';
        $jobDesc = $application->job_description ?? 'No job description provided.';

        $resumeText = "User: {$profile->first_name} {$profile->last_name}\n";
        $resumeText .= "Experience/Skills:\n" . ($profile->resume_text ?? 'No resume text available.'); // Assuming you might have a resume_text field, otherwise use what's available

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
