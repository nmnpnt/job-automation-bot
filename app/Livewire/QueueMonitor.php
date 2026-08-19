<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

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
        $pendingJobs = DB::table('jobs')->orderBy('id', 'asc')->get();
        $failedJobs = DB::table('failed_jobs')->orderBy('failed_at', 'desc')->get();
        $successCount = \App\Models\Profile::where('scraping_status', 'completed')->count();

        return view('livewire.queue-monitor', [
            'pendingJobs' => $pendingJobs,
            'failedJobs' => $failedJobs,
            'successCount' => $successCount
        ])->layout('layouts.app');
    }
}
