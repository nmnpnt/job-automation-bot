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
    public function generateContent(string $prompt, float $temperature = 0.7, int $maxTokens = 1000, int $maxRetries = 3): string
    {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            Log::warning('Gemini API key is not set.');
            throw new \Exception("Unable to generate content: Gemini API key missing.");
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$apiKey}";
        
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => $temperature,
                'maxOutputTokens' => $maxTokens,
            ]
        ];

        $attempt = 0;
        $delay = 1000; // start with 1 second delay

        while ($attempt < $maxRetries) {
            $attempt++;
            
            try {
                // We use withoutVerifying() for local dev issues with cURL/SSL on Windows
                $response = Http::withoutVerifying()
                    ->timeout(30)
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                    ])
                    ->post($url, $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                        return trim($data['candidates'][0]['content']['parts'][0]['text']);
                    }
                    
                    Log::error("Attempt {$attempt}: Gemini API returned unexpected format.", ['response' => $data]);
                    throw new \Exception("Failed to parse AI response.");
                }

                $status = $response->status();
                Log::error("Attempt {$attempt}: Gemini API failed with status {$status}", [
                    'body' => $response->body()
                ]);
                
                // If it's a 429 (Rate Limit) or 503 (Service Unavailable), we should retry
                if (in_array($status, [429, 500, 502, 503, 504])) {
                    if ($attempt < $maxRetries) {
                        usleep($delay * 1000); // usleep takes microseconds
                        $delay *= 2; // Exponential backoff
                        continue;
                    }
                }
                
                // For other errors (400, 403, 404) or if max retries reached, throw
                throw new \Exception("Gemini API Error ({$status}): " . $response->body());
                
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                Log::error("Attempt {$attempt}: Connection exception: " . $e->getMessage());
                if ($attempt < $maxRetries) {
                    usleep($delay * 1000);
                    $delay *= 2;
                    continue;
                }
                throw new \Exception("Connection to AI service failed.");
            }
        }

        throw new \Exception("AI service unavailable after {$maxRetries} attempts.");
    }

    /**
     * Same as generateContent but attempts to extract and decode a JSON block from the response.
     */
    public function generateJson(string $prompt, float $temperature = 0.7, int $maxTokens = 1000): array
    {
        // Enforce JSON in prompt
        $prompt .= "\n\nIMPORTANT: Return ONLY valid JSON. Do not include markdown formatting (like ```json), just the raw JSON string.";
        
        $response = $this->generateContent($prompt, $temperature, $maxTokens);
        
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
