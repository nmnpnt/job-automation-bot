<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\JobAnalytics;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(JobAnalytics::class)
            ->assertStatus(200)
            ->assertViewHas('quickStats');
    }
}
