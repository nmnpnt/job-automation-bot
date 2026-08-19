<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;

class LogViewer extends Component
{
    public $selectedLog = 'laravel.log';
    public $availableLogs = [];
    public $logContent = '';

    public function mount()
    {
        $this->loadAvailableLogs();
        $this->loadLogContent();
    }

    public function updatedSelectedLog()
    {
        $this->loadLogContent();
    }

    public function loadAvailableLogs()
    {
        $logPath = storage_path('logs');
        if (File::exists($logPath)) {
            $files = File::files($logPath);
            $this->availableLogs = collect($files)
                ->filter(fn($file) => $file->getExtension() === 'log')
                ->map(fn($file) => $file->getFilename())
                ->values()
                ->toArray();
        }
    }

    public function loadLogContent()
    {
        $path = storage_path('logs/' . $this->selectedLog);
        
        if (!File::exists($path)) {
            $this->logContent = "Log file not found: " . $this->selectedLog;
            return;
        }

        // Only read the last 1000 lines to prevent memory exhaustion
        $lines = file($path);
        if ($lines !== false) {
            $lines = array_slice($lines, -1000);
            $this->logContent = implode("", $lines);
        } else {
            $this->logContent = "Unable to read log file.";
        }
    }

    public function clearLog()
    {
        $path = storage_path('logs/' . $this->selectedLog);
        if (File::exists($path)) {
            File::put($path, '');
            $this->loadLogContent();
            session()->flash('message', 'Log file cleared successfully.');
        }
    }

    public function render()
    {
        return view('livewire.log-viewer')->layout('layouts.app');
    }
}
