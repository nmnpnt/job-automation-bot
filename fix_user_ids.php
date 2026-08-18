<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
if ($user) {
    App\Models\Application::whereNull('user_id')->update(['user_id' => $user->id]);
    echo "Updated application user_ids to {$user->id}\n";
} else {
    echo "No user found\n";
}
