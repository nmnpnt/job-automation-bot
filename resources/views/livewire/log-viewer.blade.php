<div class="space-y-6 animate-fade-in-up">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between bg-slate-900/60 backdrop-blur-2xl p-6 rounded-[2rem] border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-neon-pink/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl -ml-32 -mb-32 pointer-events-none"></div>

        <div class="min-w-0 flex-1 relative z-10 flex items-center">
            <div class="p-3 bg-neon-pink/20 text-neon-pink rounded-2xl mr-4 border border-neon-pink/30 shadow-[0_0_15px_rgba(255,42,133,0.3)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h2 class="text-3xl font-black leading-9 text-white tracking-wide uppercase drop-shadow-md">
                    System Logs
                </h2>
                <p class="mt-1 text-sm text-slate-400 font-bold">View and monitor Laravel application and scraper logs.</p>
            </div>
        </div>
        
        <div class="mt-6 flex md:ml-4 md:mt-0 space-x-4 relative z-10">
            <div class="relative">
                <select wire:model.live="selectedLog" class="appearance-none block w-full rounded-xl border border-white/10 bg-black/50 py-2.5 pl-4 pr-10 text-white font-bold shadow-sm focus:border-neon-pink focus:ring-neon-pink focus:bg-black sm:text-sm transition-all duration-200 cursor-pointer">
                    @foreach($availableLogs as $log)
                        <option value="{{ $log }}" class="bg-slate-900">{{ $log }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-neon-pink">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            
            <button wire:click="loadLogContent" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-xl bg-white/5 border border-white/10 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:text-white hover:bg-white/10 hover:border-white/20 transition-all duration-300 shadow-[inset_0_2px_4px_rgba(0,0,0,0.2)] disabled:opacity-50">
                <span wire:loading.remove wire:target="loadLogContent" class="flex items-center">
                    <svg class="-ml-0.5 mr-2 h-4 w-4 text-neon-cyan" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh
                </span>
                <span wire:loading wire:target="loadLogContent" class="flex items-center">
                    <svg class="animate-spin -ml-0.5 mr-2 h-4 w-4 text-neon-cyan" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Loading...
                </span>
            </button>
            <button x-data x-on:click="if(confirm('Are you sure you want to clear this log file? This cannot be undone.')) $wire.clearLog()" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-neon-pink to-rose-500 hover:from-rose-500 hover:to-rose-400 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(255,42,133,0.4)] transition-all duration-300 border border-neon-pink/50 disabled:opacity-50">
                <span wire:loading.remove wire:target="clearLog" class="flex items-center">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Clear
                </span>
                <span wire:loading wire:target="clearLog" class="flex items-center">
                    <svg class="animate-spin -ml-0.5 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Clearing...
                </span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="rounded-2xl bg-emerald-500/20 p-4 border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.2)] transition-colors duration-300">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-emerald-300">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-black/60 backdrop-blur-2xl rounded-[2rem] shadow-[inset_0_2px_15px_rgba(0,0,0,0.5)] border border-white/10 overflow-hidden transition-colors duration-300">
        <div class="px-6 py-4 border-b border-white/10 bg-white/5 flex justify-between items-center transition-colors duration-300">
            <span class="text-xs font-mono font-bold text-brand-300 tracking-wider">storage/logs/{{ $selectedLog }}</span>
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Showing last 1000 lines</span>
        </div>
        <div class="p-6 overflow-x-auto overflow-y-auto max-h-[70vh] custom-scrollbar">
            <pre class="text-xs font-mono text-neon-cyan/80 whitespace-pre-wrap break-words leading-relaxed">{{ $logContent }}</pre>
        </div>
    </div>
</div>
