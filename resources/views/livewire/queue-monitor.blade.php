<div class="space-y-8 animate-fade-in-up" wire:poll.5s>
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-slate-900/60 backdrop-blur-2xl p-6 md:p-8 rounded-[2rem] border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.5)] relative overflow-hidden transition-colors duration-500 hud-border">
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500/20 rounded-full blur-[100px] -mr-32 -mt-32 pointer-events-none animate-pulse-glow"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-neon-cyan/20 rounded-full blur-[100px] -ml-32 -mb-32 pointer-events-none animate-pulse-glow" style="animation-delay: 2s;"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl md:text-4xl font-black leading-9 text-white tracking-tight flex items-center drop-shadow-md">
                <div class="p-2.5 bg-brand-500/20 text-brand-400 rounded-2xl mr-5 shadow-[0_0_20px_rgba(139,92,246,0.4)] border border-brand-500/30">
                    <svg class="w-8 h-8 drop-shadow-[0_0_8px_rgba(139,92,246,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                Background Queue
            </h2>
            <p class="mt-2 text-sm text-slate-400 font-bold ml-16 max-w-2xl drop-shadow-md">Monitor and manage automated tasks in real-time.</p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 relative z-10">
            <button wire:click="$refresh" class="inline-flex items-center justify-center rounded-xl bg-white/5 border border-white/10 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:text-white hover:bg-white/10 hover:border-white/20 transition-all duration-300 shadow-inner group hud-border">
                <svg class="w-4 h-4 mr-2 text-brand-400 group-hover:text-brand-300 group-hover:rotate-180 transition-all duration-500 drop-shadow-[0_0_5px_rgba(139,92,246,0.5)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh Status
            </button>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Pending -->
        <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[1.5rem] p-6 border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] hover:shadow-[0_10px_40px_rgba(251,191,36,0.2)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group/card hud-border">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 h-[2px] w-full bg-amber-500 shadow-[0_0_10px_rgba(251,191,36,0.8)]"></div>
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-amber-500 mb-1 drop-shadow-md">Pending Jobs</p>
                    <p class="text-4xl font-black text-white drop-shadow-[0_0_10px_rgba(251,191,36,0.4)]">{{ $pendingJobs->count() }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-amber-500/20 flex items-center justify-center border border-amber-500/30 shadow-[0_0_15px_rgba(251,191,36,0.3)] group-hover/card:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-amber-400 drop-shadow-[0_0_8px_rgba(251,191,36,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Success -->
        <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[1.5rem] p-6 border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] hover:shadow-[0_10px_40px_rgba(16,185,129,0.2)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group/card hud-border">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 h-[2px] w-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.8)]"></div>
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-500 mb-1 drop-shadow-md">Successfully Completed</p>
                    <p class="text-4xl font-black text-white drop-shadow-[0_0_10px_rgba(16,185,129,0.4)]">{{ $successfulJobsCount }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 flex items-center justify-center border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.3)] group-hover/card:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-emerald-400 drop-shadow-[0_0_8px_rgba(16,185,129,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Failed -->
        <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[1.5rem] p-6 border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] hover:shadow-[0_10px_40px_rgba(244,114,182,0.2)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group/card hud-border">
            <div class="absolute inset-0 bg-gradient-to-br from-neon-pink/10 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 h-[2px] w-full bg-neon-pink shadow-[0_0_10px_rgba(244,114,182,0.8)]"></div>
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-neon-pink mb-1 drop-shadow-md">Failed Jobs</p>
                    <p class="text-4xl font-black text-white drop-shadow-[0_0_10px_rgba(244,114,182,0.4)]">{{ $failedJobs->count() }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-neon-pink/20 flex items-center justify-center border border-neon-pink/30 shadow-[0_0_15px_rgba(244,114,182,0.3)] group-hover/card:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-neon-pink drop-shadow-[0_0_8px_rgba(244,114,182,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Area -->
    <div x-data="{ activeTab: 'failed' }" class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.5)] overflow-hidden hud-border">
        <!-- Tabs Header -->
        <div class="border-b border-white/10 bg-black/40 px-6 py-2 relative">
            <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
            <nav class="flex space-x-2" aria-label="Tabs">
                <button @click="activeTab = 'failed'"
                        :class="activeTab === 'failed' ? 'bg-neon-pink/10 text-neon-pink border-b-2 border-neon-pink shadow-[inset_0_-2px_10px_rgba(244,114,182,0.2)]' : 'border-b-2 border-transparent text-slate-400 hover:text-slate-200 hover:bg-white/5'"
                        class="px-5 py-4 text-[11px] font-black uppercase tracking-widest transition-all duration-300 rounded-t-xl relative overflow-hidden group">
                    <div class="absolute inset-0 bg-neon-pink/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none" x-show="activeTab !== 'failed'"></div>
                    Failed Jobs
                    @if($failedJobs->count() > 0)
                        <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-md text-[9px] font-black bg-neon-pink text-white shadow-[0_0_10px_rgba(244,114,182,0.6)]">{{ $failedJobs->count() }}</span>
                    @endif
                </button>
                <button @click="activeTab = 'pending'"
                        :class="activeTab === 'pending' ? 'bg-amber-500/10 text-amber-400 border-b-2 border-amber-400 shadow-[inset_0_-2px_10px_rgba(251,191,36,0.2)]' : 'border-b-2 border-transparent text-slate-400 hover:text-slate-200 hover:bg-white/5'"
                        class="px-5 py-4 text-[11px] font-black uppercase tracking-widest transition-all duration-300 rounded-t-xl relative overflow-hidden group">
                    <div class="absolute inset-0 bg-amber-500/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none" x-show="activeTab !== 'pending'"></div>
                    Pending Jobs
                    @if($pendingJobs->count() > 0)
                        <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-md text-[9px] font-black bg-amber-500 text-amber-900 shadow-[0_0_10px_rgba(251,191,36,0.6)]">{{ $pendingJobs->count() }}</span>
                    @endif
                </button>
            </nav>
        </div>

        <!-- Failed Jobs Tab -->
        <div x-show="activeTab === 'failed'" x-cloak class="p-6">
            @if($failedJobs->count() > 0)
                <div class="mb-6 flex justify-end">
                     <button wire:click="retryAll" wire:loading.attr="disabled" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-neon-pink to-brand-500 hover:from-neon-pink/90 hover:to-brand-400 px-5 py-2.5 text-[10px] font-black uppercase tracking-widest text-white shadow-[0_0_20px_rgba(244,114,182,0.4)] hover:shadow-[0_0_30px_rgba(244,114,182,0.6)] transition-all duration-300 border border-white/10 group hud-border">
                        <svg wire:loading.remove wire:target="retryAll" class="w-4 h-4 mr-2 group-hover:-rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <svg wire:loading wire:target="retryAll" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                        Retry All Failed
                    </button>
                </div>
                <div class="space-y-4">
                    @foreach ($failedJobs as $fjob)
                        <div class="bg-black/40 rounded-2xl p-5 border border-white/5 hover:border-white/10 transition-colors group relative overflow-hidden" x-data="{ open: false }">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-neon-pink shadow-[0_0_10px_rgba(244,114,182,0.8)] opacity-50 group-hover:opacity-100 transition-opacity"></div>
                            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center ml-2 gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center flex-wrap gap-3 mb-2">
                                        <span class="shrink-0 px-2.5 py-1 rounded-md text-[9px] font-black uppercase tracking-widest bg-neon-pink/20 text-neon-pink border border-neon-pink/30 shadow-[0_0_8px_rgba(244,114,182,0.3)] flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            Failed
                                        </span>
                                        <h3 class="text-[13px] font-black text-white leading-tight font-mono truncate w-full sm:w-auto">
                                            {{ Str::limit($fjob->exception, 80) }}
                                        </h3>
                                    </div>
                                    <div class="flex flex-wrap items-center text-[11px] font-bold text-slate-400 gap-4 mt-3">
                                        <span class="flex items-center bg-white/5 px-2 py-1 rounded-md border border-white/5 font-mono text-slate-300">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                            {{ Str::afterLast($fjob->payload, '\\') ?? 'Unknown Job' }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Failed {{ \Carbon\Carbon::parse($fjob->failed_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex flex-row items-center gap-2 shrink-0">
                                    <button @click="open = !open" class="inline-flex items-center justify-center rounded-xl bg-white/5 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-300 border border-white/10 hover:bg-white/10 hover:text-white transition-all shadow-inner hud-border">
                                        <span x-show="!open">Details</span>
                                        <span x-show="open">Hide</span>
                                    </button>
                                    <div class="flex space-x-2">
                                        <button wire:click="retryJob('{{ $fjob->uuid }}')" wire:loading.attr="disabled" wire:target="retryJob('{{ $fjob->uuid }}')" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center justify-center rounded-xl bg-neon-cyan/20 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-neon-cyan border border-neon-cyan/30 hover:bg-neon-cyan/30 hover:text-cyan-300 transition-all shadow-[0_0_10px_rgba(34,211,238,0.2)] hud-border">
                                            <svg wire:loading.remove wire:target="retryJob('{{ $fjob->uuid }}')" class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            <svg wire:loading wire:target="retryJob('{{ $fjob->uuid }}')" class="animate-spin w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Retry
                                        </button>
                                        <button x-data x-on:click="if(confirm('Are you sure you want to delete this failed job?')) $wire.deleteFailedJob('{{ $fjob->uuid }}')" wire:loading.attr="disabled" wire:target="deleteFailedJob('{{ $fjob->uuid }}')" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center justify-center rounded-xl bg-rose-500/10 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-rose-400 border border-rose-500/20 hover:bg-rose-500/20 hover:text-rose-300 transition-all hud-border">
                                            <svg wire:loading.remove wire:target="deleteFailedJob('{{ $fjob->uuid }}')" class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <svg wire:loading wire:target="deleteFailedJob('{{ $fjob->uuid }}')" class="animate-spin w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                            Del
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div x-show="open" x-cloak x-transition class="mt-5 bg-black/60 rounded-xl border border-white/5 overflow-hidden shadow-inner ml-2">
                                <div class="bg-white/5 border-b border-white/5 px-4 py-2 text-[10px] font-black text-slate-500 uppercase tracking-widest">Stack Trace</div>
                                <div class="p-4 overflow-x-auto custom-scrollbar">
                                    <pre class="text-[11px] text-neon-pink/90 font-mono whitespace-pre-wrap break-all leading-relaxed">{{ substr($fjob->exception, 0, 1500) }}{{ strlen($fjob->exception) > 1500 ? '...' : '' }}</pre>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 text-center bg-black/20 rounded-[1.5rem] border border-white/5">
                    <div class="w-24 h-24 bg-emerald-500/10 rounded-3xl flex items-center justify-center mb-6 shadow-[inset_0_2px_15px_rgba(16,185,129,0.2)] border border-emerald-500/20 rotate-3 group-hover:rotate-6 transition-transform">
                        <svg class="w-12 h-12 text-emerald-400 drop-shadow-[0_0_10px_rgba(16,185,129,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-white tracking-wide drop-shadow-md">All Clear</h3>
                    <p class="mt-3 text-sm text-slate-400 font-bold max-w-md">No failed jobs to display. Your automation systems are running flawlessly.</p>
                </div>
            @endif
        </div>

        <!-- Pending Jobs Tab -->
        <div x-show="activeTab === 'pending'" x-cloak class="p-6">
            @if($pendingJobs->count() > 0)
                <div class="space-y-4">
                    @foreach ($pendingJobs as $job)
                        <div class="bg-black/40 rounded-2xl p-5 border border-white/5 hover:border-white/10 transition-colors group relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-500 shadow-[0_0_10px_rgba(251,191,36,0.8)] opacity-50 group-hover:opacity-100 transition-opacity"></div>
                            <div class="flex justify-between items-center ml-2">
                                <div>
                                    <p class="text-sm font-black text-white flex items-center gap-3">
                                        <span class="font-mono text-slate-300">Job #{{ $job->id }}</span>
                                        <span class="px-2.5 py-1 rounded-md text-[9px] font-black uppercase tracking-widest bg-amber-500/20 text-amber-400 border border-amber-500/30 shadow-[0_0_8px_rgba(251,191,36,0.2)]">
                                            {{ $job->queue }}
                                        </span>
                                    </p>
                                    <p class="mt-2 flex items-center text-xs font-bold text-slate-400">
                                        <svg class="flex-shrink-0 mr-1.5 h-3.5 w-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Created {{ \Carbon\Carbon::createFromTimestamp($job->created_at)->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="text-right bg-white/5 px-5 py-3 rounded-xl border border-white/5 shadow-inner">
                                    <p class="text-2xl text-neon-cyan font-black drop-shadow-[0_0_8px_rgba(34,211,238,0.5)] leading-none">{{ $job->attempts }}</p>
                                    <p class="text-[9px] uppercase tracking-widest text-slate-500 font-black mt-2">Attempts</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 text-center bg-black/20 rounded-[1.5rem] border border-white/5">
                    <div class="w-24 h-24 bg-white/5 rounded-3xl flex items-center justify-center mb-6 border border-white/10 shadow-[inset_0_2px_15px_rgba(0,0,0,0.3)] -rotate-3 group-hover:rotate-0 transition-transform">
                        <svg class="w-12 h-12 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-white tracking-wide drop-shadow-md">Queue is Clear</h3>
                    <p class="mt-3 text-sm text-slate-400 font-bold max-w-md">No pending jobs in the queue. All background tasks have been successfully processed.</p>
                </div>
            @endif
        </div>
    </div>
</div>
