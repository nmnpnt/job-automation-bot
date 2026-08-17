<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class QueueMonitor extends Component
{
    public function retryJob($id)
    {
        Artisan::call('queue:retry', ['id' => [$id]]);
        session()->flash('message', 'Job retried successfully.');
    }

    public function deleteFailedJob($id)
    {
        Artisan::call('queue:forget', ['id' => [$id]]);
        session()->flash('message', 'Failed job deleted.');
    }

    public function render()
    {
        // For standard Laravel jobs table
        $pendingJobs = DB::table('jobs')->orderBy('id', 'asc')->get();
        $failedJobs = DB::table('failed_jobs')->orderBy('failed_at', 'desc')->get();

        return view('livewire.queue-monitor', [
            'pendingJobs' => $pendingJobs,
            'failedJobs' => $failedJobs
        ])->layout('layouts.app');
    }
}
