<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    /**
     * The model to use.
     */
    protected string $model = 'gemini-3.6-flash';

    /**
     * Send a prompt to Gemini and return the parsed text with automatic retries and exponential backoff.
     *
     * @param string $prompt
     * @param float $temperature
     * @param int $maxTokens
     * @param int $maxRetries
     * @return string
     * @throws \Exception
     */
    public function generateContent(string $prompt, float $temperature = 0.7, int $maxTokens = 1000, int $maxRetries = 3, bool $isJson = false): string
    {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            Log::warning('Gemini API key is not set.');
            throw new \Exception("Unable to generate content: Gemini API key missing.");
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$apiKey}";
        
        $generationConfig = [
            'temperature' => $temperature,
            'maxOutputTokens' => $maxTokens,
        ];
        
        if ($isJson) {
            $generationConfig['responseMimeType'] = 'application/json';
        }

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => $generationConfig
        ];

        // Use Laravel's built-in retry mechanism: 3 times, 1000ms delay, returning true if status is 429 or 50x
        $response = Http::withoutVerifying()
            ->timeout(30)
            ->retry($maxRetries, 1000, function ($exception, $request) {
                if ($exception instanceof \Illuminate\Http\Client\ConnectionException) {
                    return true;
                }
                
                $response = $exception->response ?? null;
                if ($response) {
                    return in_array($response->status(), [429, 500, 502, 503, 504]);
                }
                
                return false;
            })
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post($url, $payload);

        if ($response->successful()) {
            $data = $response->json();
            
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                return trim($data['candidates'][0]['content']['parts'][0]['text']);
            }
            
            Log::error("Gemini API returned unexpected format.", ['response' => $data]);
            throw new \Exception("Failed to parse AI response.");
        }

        $status = $response->status();
        Log::error("Gemini API failed with status {$status}", [
            'body' => $response->body()
        ]);
        
        throw new \Exception("Gemini API Error ({$status}): " . $response->body());
    }

    /**
     * Same as generateContent but attempts to extract and decode a JSON block from the response.
     */
    public function generateJson(string $prompt, float $temperature = 0.7, int $maxTokens = 1000): array
    {
        // Enforce JSON in prompt
        $prompt .= "\n\nIMPORTANT: Return ONLY valid JSON. Do not include markdown formatting (like ```json), just the raw JSON string.";
        
        $response = $this->generateContent($prompt, $temperature, $maxTokens, 3, true);
        
        // Clean up potential markdown formatting that the LLM might stubbornly include
        $response = preg_replace('/```json/i', '', $response);
        $response = preg_replace('/```/', '', $response);
        $response = trim($response);

        $parsed = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "AI JSON parse error: " . json_last_error_msg() . "\n";
            echo "RAW RESPONSE:\n" . $response . "\n";
            Log::error("AI JSON parse error: " . json_last_error_msg(), ['raw' => $response]);
            throw new \Exception("The AI returned invalid format instead of JSON.");
        }
        
        return $parsed;
    }
}
