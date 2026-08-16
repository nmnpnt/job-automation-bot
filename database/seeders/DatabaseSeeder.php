<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\Profile::create([
            'user_id' => $user->id,
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'phone' => '+1234567890',
            'linkedin_url' => 'https://linkedin.com/in/testuser',
            'github_url' => 'https://github.com/testuser',
            'resume_text' => 'Experienced software engineer with 5 years of full-stack web development.',
        ]);

        \App\Models\NotificationPreference::create([
            'user_id' => $user->id,
            'channel_in_app' => true,
            'channel_email' => true,
        ]);
    }
}
