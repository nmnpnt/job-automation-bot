<?php

namespace App\Events;

use App\Models\Application;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Application $application,
        public string $status,
        public string $message
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('activity-feed'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'ActivityLogged';
    }
}
