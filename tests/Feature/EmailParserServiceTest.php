<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\EmailParserService;
use App\Enums\ApplicationStatus;

class EmailParserServiceTest extends TestCase
{
    public function test_it_parses_rejection_email(): void
    {
        $service = new EmailParserService();
        
        $subject = 'Update on your application at Acme Corp';
        $body = 'Unfortunately, we have decided to move forward with other candidates.';
        
        $status = $service->determineStatus($subject, $body);

        $this->assertEquals(ApplicationStatus::REJECTED, $status);
    }

    public function test_it_parses_interview_email(): void
    {
        $service = new EmailParserService();
        
        $subject = 'Interview request from Tech Inc';
        $body = 'We would love to schedule a time to speak with you.';
        
        $status = $service->determineStatus($subject, $body);

        $this->assertEquals(ApplicationStatus::INTERVIEW_REQUESTED, $status);
    }
}
