<?php

namespace App\Services;

use App\Models\User;
use App\Models\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiCoverLetterService
{
    /**
     * Generate a personalized cover letter using Google's Gemini API.
     *
     * @param User $user
     * @param Application $job
     * @return string
     * @throws \Exception
     */
    public function generateCoverLetter(User $user, Application $job): string
    {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            Log::warning('Gemini API key is not set. Cannot generate cover letter.');
            return "Unable to generate cover letter: Gemini API key missing.";
        }

        $prompt = $this->buildPrompt($user, $job);

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
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Extract text from the Gemini response structure
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $coverLetter = $data['candidates'][0]['content']['parts'][0]['text'];
                    return trim($coverLetter);
                }
                
                Log::error('Gemini API returned an unexpected response format.', ['response' => $data]);
                return "Failed to parse generated cover letter.";
            }

            Log::error('Gemini API request failed.', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return "Failed to generate cover letter due to an API error.";
            
        } catch (\Exception $e) {
            Log::error('Exception during Gemini API call: ' . $e->getMessage());
            return "An error occurred while generating the cover letter.";
        }
    }

    /**
     * Construct the prompt for the LLM based on user profile and job description.
     */
    private function buildPrompt(User $user, Application $job): string
    {
        $userName = $user->name;
        // Typically you might have $user->profile->resume_text or similar.
        // Assuming we have basic user info for now.
        $userSkills = "Full Stack Development, PHP, Laravel, JavaScript, Vue.js, Tailwind CSS"; // Placeholder if not in DB
        
        $jobTitle = $job->job_title;
        $companyName = $job->company_name;
        $jobDescription = $job->job_description ?? 'A software engineering role focusing on web development.';

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
