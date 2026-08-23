<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;

class QueueMonitor extends Component
{
    public function retryJob($uuid)
    {
        Artisan::call('queue:retry', ['id' => [$uuid]]);
        session()->flash('message', 'Job retried successfully.');
    }

    public function deleteFailedJob($uuid)
    {
        Artisan::call('queue:forget', ['id' => [$uuid]]);
        session()->flash('message', 'Failed job deleted.');
    }

    public function render()
    {
        // For Laravel 10/11 using standard redis queues prefix is handled by predis/phpredis automatically on connection.
        // But the queue name is `{prefix}queues:default` where prefix by default is your app name. 
        // We will just use standard Queue connection config to get the correct queue name.
        $queueName = config('queue.connections.redis.queue', 'default');
        
        try {
            // Depending on redis prefix config, we might need just queues:default
            $redisJobs = Redis::connection('default')->lrange('queues:'.$queueName, 0, 50);
            $pendingJobs = [];
            foreach ($redisJobs as $jobPayload) {
                $payload = json_decode($jobPayload);
                $pendingJobs[] = (object) [
                    'id' => $payload->uuid ?? uniqid(),
                    'queue' => $queueName,
                    'payload' => $jobPayload,
                    'attempts' => $payload->attempts ?? 0,
                    'created_at' => isset($payload->pushedAt) ? $payload->pushedAt : time(),
                ];
            }
        } catch (\Exception $e) {
            $pendingJobs = [];
        }

        $failedJobs = DB::table('failed_jobs')->orderBy('failed_at', 'desc')->get();
        $successCount = \App\Models\Profile::where('scraping_status', 'completed')->count();

        return view('livewire.queue-monitor', [
            'pendingJobs' => collect($pendingJobs),
            'failedJobs' => $failedJobs,
            'successfulJobsCount' => $successCount,
            'pendingCount' => count($pendingJobs)
        ]);
    }
}
