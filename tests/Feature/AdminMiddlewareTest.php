<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_routes()
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get('/admin/users');
        $response->assertStatus(403);
        
        $response = $this->actingAs($user)->get('/admin/schedules');
        $response->assertStatus(403);
        
        $response = $this->actingAs($user)->get('/queue-monitor');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_routes()
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/schedules');
        $response->assertStatus(200);
    }
}
