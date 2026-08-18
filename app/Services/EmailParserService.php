<?php

namespace App\Services;

use App\Enums\ApplicationStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class EmailParserService
{
    /**
     * Evaluate the subject and body to determine if there's a status update.
     */
    public function determineStatus(string $subject, string $body): ?ApplicationStatus
    {
        $text = strtolower($subject . ' ' . $body);

        if (Str::contains($text, ['offer', 'extend an offer', 'pleased to offer'])) {
            return ApplicationStatus::OFFER_RECEIVED;
        }

        if (Str::contains($text, ['interview', 'chat', 'schedule a time', 'next steps'])) {
            // Be careful not to match "we will reach out if selected for an interview"
            if (!Str::contains($text, ['will reach out if', 'if selected'])) {
                return ApplicationStatus::INTERVIEW_REQUESTED;
            }
        }

        if (Str::contains($text, ['unfortunately', 'not moving forward', 'other candidates', 'not selected', 'decided to pursue'])) {
            return ApplicationStatus::REJECTED;
        }

        return null;
    }

    /**
     * Use Gemini to extract structured interview data from the email body.
     */
    public function extractInterviewDetails(string $body): ?array
    {
        $apiKey = config('services.gemini.api_key', '');
        
        if (empty($apiKey)) {
            return null;
        }

        $prompt = <<<EOT
You are an intelligent email parsing assistant. 
Extract the interview date, time, and any meeting links (Zoom, Google Meet, Teams, etc.) from the following email body.
Return the result strictly as a valid JSON object with keys: "interview_date" (ISO 8601 format or YYYY-MM-DD HH:MM:SS), and "interview_link" (URL string).
If a value is not found, set it to null.
Do not include markdown blocks or any other text outside the JSON.

Email Body:
{$body}
EOT;

        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.1,
                'responseMimeType' => 'application/json',
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $jsonText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
            
            return json_decode($jsonText, true);
        }

        \Log::error('Gemini API Error (Email Parser)', ['response' => $response->body()]);
        return null;
    }
}
