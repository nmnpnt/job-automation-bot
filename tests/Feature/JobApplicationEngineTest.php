<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\JobApplicationEngine;
use App\Services\ApplicationSourceDetector;
use App\Services\ResumeMatcherService;
use App\Models\Application;
use App\Enums\ApplicationStatus;
use Illuminate\Support\Facades\Event;
use App\Services\Providers\GreenhouseApplicationProvider;
use App\Services\Providers\LeverApplicationProvider;

class JobApplicationEngineTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_routes_high_score_to_pending_review(): void
    {
        Event::fake();

        $detector = $this->mock(ApplicationSourceDetector::class);
        $detector->shouldReceive('detect')->andReturn(\App\Enums\ApplicationSource::GREENHOUSE);
        $providerMock = $this->mock(GreenhouseApplicationProvider::class);
        $detector->shouldReceive('getProvider')->andReturn($providerMock);

        $matcher = $this->mock(ResumeMatcherService::class);
        $matcher->shouldReceive('match')->andReturn(['score' => 85, 'reason' => 'Good']);

        $engine = new JobApplicationEngine($detector, $matcher);

        $engine->processNewJob([
            'id' => 123,
            'url' => 'https://boards.greenhouse.io/test/jobs/123',
            'description' => 'Test job'
        ]);

        $this->assertDatabaseHas('applications', [
            'original_job_url' => 'https://boards.greenhouse.io/test/jobs/123',
            'status' => ApplicationStatus::PENDING_REVIEW->value,
        ]);
    }

    public function test_it_routes_low_score_to_skipped(): void
    {
        Event::fake();

        $detector = $this->mock(ApplicationSourceDetector::class);
        $detector->shouldReceive('detect')->andReturn(\App\Enums\ApplicationSource::LEVER);
        $providerMock = $this->mock(LeverApplicationProvider::class);
        $detector->shouldReceive('getProvider')->andReturn($providerMock);

        $matcher = $this->mock(ResumeMatcherService::class);
        $matcher->shouldReceive('match')->andReturn(['score' => 50, 'reason' => 'Bad']);

        $engine = new JobApplicationEngine($detector, $matcher);

        $engine->processNewJob([
            'id' => 124,
            'url' => 'https://jobs.lever.co/test/124',
            'description' => 'Test job'
        ]);

        $this->assertDatabaseHas('applications', [
            'original_job_url' => 'https://jobs.lever.co/test/124',
            'status' => ApplicationStatus::SKIPPED->value,
        ]);
    }
}
