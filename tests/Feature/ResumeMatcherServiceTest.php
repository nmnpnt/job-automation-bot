<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\ResumeMatcherService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class ResumeMatcherServiceTest extends TestCase
{
    public function test_it_returns_high_score_for_good_match(): void
    {
        Config::set('services.gemini.key', 'fake-key');

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => json_encode(['score' => 90, 'reason' => 'Strong match'])
                                ]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = new ResumeMatcherService();
        $result = $service->match('Laravel developer', 'Looking for Laravel dev');

        $this->assertEquals(90, $result['score']);
        $this->assertEquals('Strong match', $result['reason']);
    }

    public function test_it_returns_fallback_score_on_failure(): void
    {
        Config::set('services.gemini.key', 'fake-key');

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response('Server Error', 500)
        ]);

        $service = new ResumeMatcherService();
        $result = $service->match('Laravel developer', 'Looking for Laravel dev');

        $this->assertEquals(50, $result['score']);
        $this->assertStringContainsString('Failed to reach AI matcher', $result['reason'] ?? '');
    }
}
