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

<div class="space-y-6 animate-fade-in-up" wire:poll.1s="fetchLogs">
    <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] overflow-hidden transition-colors duration-500 relative group p-6">
        <!-- Abstract gradient blobs -->
        <div class="absolute -top-32 -right-32 w-[30rem] h-[30rem] bg-neon-cyan/10 rounded-full blur-[100px] pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-32 -left-32 w-[30rem] h-[30rem] bg-brand-500/10 rounded-full blur-[100px] pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        
        <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-4 relative z-10">
            <div class="flex items-center space-x-3">
                <div class="flex space-x-1.5 bg-black/50 p-2 rounded-lg border border-white/5 shadow-inner">
                    <div class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.6)]"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.6)]"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div>
                </div>
                <div class="flex items-center text-slate-300 font-black text-xs tracking-widest uppercase">
                    <svg class="w-4 h-4 mr-1.5 text-neon-cyan drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Scraper Terminal
                </div>
            </div>
            <div class="flex items-center px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.2)]">
                <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-ping absolute"></div>
                <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full relative mr-2 shadow-[0_0_5px_rgba(16,185,129,0.8)]"></div>
                <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Live Connect</span>
            </div>
        </div>

        <div class="h-[500px] overflow-y-auto w-full break-words scrollbar-thin scrollbar-thumb-brand-500/50 scrollbar-track-black/30 bg-black/60 rounded-xl p-4 shadow-[inset_0_2px_15px_rgba(0,0,0,0.8)] border border-white/5 relative z-10" id="terminal-container" x-data="{
            scrollToBottom() {
                let container = document.getElementById('terminal-container');
                container.scrollTop = container.scrollHeight;
            }
        }" x-init="scrollToBottom" @DOMSubtreeModified.debounce.100ms="scrollToBottom">
            <pre class="whitespace-pre-wrap font-mono text-[13px] text-emerald-400 leading-relaxed font-semibold drop-shadow-[0_0_2px_rgba(52,211,153,0.3)]"><code class="language-bash">{!! nl2br(e($logs)) !!}</code></pre>
        </div>
    </div>
</div>
