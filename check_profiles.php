<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$applications = App\Models\Application::all();
foreach($applications as $app) {
    $profile = App\Models\Profile::where('user_id', $app->user_id)->first();
    if (!$profile) {
        echo "App {$app->id} has user_id {$app->user_id} which has NO profile.\n";
    }
}
echo "Done checking profiles.\n";
