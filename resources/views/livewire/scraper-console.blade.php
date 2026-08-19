<?php

use Livewire\Volt\Component;

new class extends Component
{
    public $logs = '';
    public $userId;

    public function mount()
    {
        $this->userId = auth()->id();
        $this->fetchLogs();
    }

    public function fetchLogs()
    {
        $logFile = storage_path("logs/scraper-{$this->userId}.log");
        if (file_exists($logFile)) {
            // Read last 200 lines
            $lines = file($logFile);
            $lastLines = array_slice($lines, -200);
            $this->logs = implode("", $lastLines);
        } else {
            $this->logs = "Waiting for scraper to start...\n";
        }
    }
}; ?>

<div class="bg-black text-green-400 font-mono text-xs rounded-xl p-4 shadow-inner border border-slate-800 relative overflow-hidden" wire:poll.1s="fetchLogs">
    <div class="flex items-center justify-between border-b border-slate-800 pb-2 mb-2">
        <div class="flex items-center space-x-2">
            <div class="flex space-x-1">
                <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
            </div>
            <span class="text-slate-400 font-sans text-[10px] tracking-wider uppercase">Scraper Terminal</span>
        </div>
        <div class="text-slate-500 flex items-center space-x-1 animate-pulse">
            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
            <span class="text-[10px]">LIVE</span>
        </div>
    </div>
    <div class="h-64 overflow-y-auto w-full break-words scrollbar-thin scrollbar-thumb-slate-700" id="terminal-container" x-data="{
        scrollToBottom() {
            let container = document.getElementById('terminal-container');
            container.scrollTop = container.scrollHeight;
        }
    }" x-init="scrollToBottom" @DOMSubtreeModified.debounce.100ms="scrollToBottom">
        <pre class="whitespace-pre-wrap"><code class="language-bash">{!! nl2br(e($logs)) !!}</code></pre>
    </div>
</div>
