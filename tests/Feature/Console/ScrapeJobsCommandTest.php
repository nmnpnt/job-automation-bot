<?php

namespace Tests\Feature\Console;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class ScrapeJobsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_scrape_jobs_command_executes()
    {
        $user = User::factory()->create();
        UserProfile::create([
            'user_id' => $user->id,
            'target_roles' => 'Software Engineer',
            'target_locations' => 'Remote',
        ]);

        // Just checking that it runs without throwing exception when mocked
        // Note: Real node process execution should be mocked in a true isolated test
        $this->markTestIncomplete('Test requires mocking the node process execution.');
    }
}
