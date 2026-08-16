<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Profile;
use App\Models\Application;
use App\Services\JobApplicationEngine;

Profile::truncate();
Application::truncate();

$profile = new Profile();
$profile->first_name = 'Test';
$profile->last_name = 'User';
$profile->email = 'test@example.com';
$profile->resume_text = 'Senior Software Engineer with 10 years of experience in PHP, Laravel, and JavaScript.';
$profile->save();

echo "Profile created.\n";

$engine = app(JobApplicationEngine::class);

$engine->processNewJob([
    'id' => 'test-job-1',
    'url' => 'https://boards.greenhouse.io/test/jobs/123',
    'description' => 'Looking for a Senior PHP Laravel developer with 5+ years experience.'
]);

$app = Application::first();
echo "Application status: " . $app->status->name . "\n";
echo "Match score: " . $app->match_score . "\n";
echo "Profile text used: " . Profile::first()->resume_text . "\n";
