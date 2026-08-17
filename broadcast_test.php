<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pusher = new \Pusher\Pusher('12345', '12345', '12345', [
    'host' => 'localhost',
    'port' => 8080,
    'scheme' => 'http',
    'useTLS' => false,
    'debug' => true,
]);
try {
    $response = $pusher->trigger('activity', 'activity-logged', ['message' => 'test']);
    echo "Pusher response: "; var_dump($response);
} catch (\Throwable $e) {
    echo "Pusher error: " . $e->getMessage() . "\n";
}
