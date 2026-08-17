<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RunArtisanCommand implements ShouldQueue
{
    use Queueable;

    protected $command;
    protected $args;

    /**
     * Create a new job instance.
     */
    public function __construct(string $command, array $args = [])
    {
        $this->command = $command;
        $this->args = $args;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Illuminate\Support\Facades\Artisan::call($this->command, $this->args);
    }
}
