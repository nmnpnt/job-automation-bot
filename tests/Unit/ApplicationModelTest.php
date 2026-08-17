<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_application()
    {
        $user = User::factory()->create();
        
        $application = Application::create([
            'user_id' => $user->id,
            'job_title' => 'Software Engineer',
            'company_name' => 'Acme Corp',
            'status' => 'PENDING',
            'application_source' => 'LINKEDIN',
            'original_job_url' => 'https://linkedin.com/jobs/123'
        ]);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'job_title' => 'Software Engineer',
            'company_name' => 'Acme Corp'
        ]);
        
        $this->assertEquals('PENDING', $application->status);
    }
}
