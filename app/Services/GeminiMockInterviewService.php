<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Application;

class GeminiMockInterviewService
{
    protected string $apiKey;
    protected string $model = 'gemini-1.5-flash';

    public function __construct()
    {
        $this->apiKey = (string) config('services.gemini.api_key', '');
    }

    public function generatePrep(User $user, Application $application): string
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
                'temperature' => 0.5,
                'maxOutputTokens' => 1500,
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? "Failed to extract interview prep from Gemini response.";
        }

        \Log::error('Gemini API Error (Mock Interview)', ['response' => $response->body()]);
        throw new \Exception("Failed to generate interview prep. Gemini API returned: " . $response->status());
    }

    protected function buildPrompt($profile, Application $application): string
    {
        $jobTitle = $application->job_title ?? 'Unknown Title';
        $company = $application->company_name ?? 'Unknown Company';
        $jobDesc = $application->job_description ?? 'No job description provided.';

        $resumeText = "User: {$profile->first_name} {$profile->last_name}\n";
        $resumeText .= "Experience/Skills:\n" . ($profile->resume_text ?? 'No resume text available.'); 

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
