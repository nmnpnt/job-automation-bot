<div class="space-y-6" wire:poll.5s>
    <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.2)] overflow-hidden transition-colors duration-500 p-6">
        <div class="flex justify-between items-center mb-8 border-b border-white/10 pb-6">
            <div class="flex items-center">
                <div class="p-3 bg-brand-500/20 text-brand-400 rounded-2xl mr-4 border border-brand-500/30 shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-wide uppercase">Background Queue</h2>
                    <p class="text-sm font-bold text-slate-400 mt-1">Monitor and manage automated tasks in real-time.</p>
                </div>
            </div>
            <button wire:click="$refresh" class="inline-flex items-center justify-center rounded-xl bg-white/5 border border-white/10 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:text-white hover:bg-white/10 hover:border-white/20 transition-all duration-300 shadow-[inset_0_2px_4px_rgba(0,0,0,0.2)] group">
                <svg class="w-4 h-4 mr-2 text-slate-400 group-hover:text-white group-hover:rotate-180 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-black/30 rounded-2xl p-5 border border-amber-500/20 shadow-[0_0_15px_rgba(245,158,11,0.1)] relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition-all duration-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-amber-500 mb-1">Pending Jobs</p>
                        <p class="text-4xl font-black text-white drop-shadow-[0_0_8px_rgba(245,158,11,0.4)]">{{ $pendingJobs->count() }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center border border-amber-500/30 shadow-[0_0_10px_rgba(245,158,11,0.2)]">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="bg-black/30 rounded-2xl p-5 border border-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.1)] relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all duration-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-emerald-500 mb-1">Successfully Completed</p>
                        <p class="text-4xl font-black text-white drop-shadow-[0_0_8px_rgba(16,185,129,0.4)]">{{ $successfulJobsCount }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center border border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.2)]">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="bg-black/30 rounded-2xl p-5 border border-neon-pink/20 shadow-[0_0_15px_rgba(255,42,133,0.1)] relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-neon-pink/10 rounded-full blur-2xl group-hover:bg-neon-pink/20 transition-all duration-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-neon-pink mb-1">Failed Jobs</p>
                        <p class="text-4xl font-black text-white drop-shadow-[0_0_8px_rgba(255,42,133,0.4)]">{{ $failedJobs->count() }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-neon-pink/20 flex items-center justify-center border border-neon-pink/30 shadow-[0_0_10px_rgba(255,42,133,0.2)]">
                        <svg class="w-6 h-6 text-neon-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div x-data="{ activeTab: 'failed' }" class="bg-black/20 rounded-[2rem] border border-white/5 overflow-hidden">
            <div class="border-b border-white/5 bg-black/40 px-4">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'failed'"
                            :class="activeTab === 'failed' ? 'border-neon-pink text-neon-pink shadow-[0_2px_10px_rgba(255,42,133,0.4)]' : 'border-transparent text-slate-500 hover:text-slate-300 hover:border-slate-700'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-[11px] font-black uppercase tracking-widest transition-all duration-300">
                        Failed Jobs
                    </button>
                    <button @click="activeTab = 'pending'"
                            :class="activeTab === 'pending' ? 'border-amber-400 text-amber-400 shadow-[0_2px_10px_rgba(251,191,36,0.4)]' : 'border-transparent text-slate-500 hover:text-slate-300 hover:border-slate-700'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-[11px] font-black uppercase tracking-widest transition-all duration-300">
                        Pending Jobs
                    </button>
                </nav>
            </div>

            <!-- Failed Jobs Tab -->
            <div x-show="activeTab === 'failed'" x-cloak class="p-2">
                @if($failedJobs->count() > 0)
                    <div class="mb-4 px-4 pt-4 flex justify-end">
                         <button wire:click="retryAll" wire:loading.attr="disabled" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-neon-cyan/80 hover:from-brand-500 hover:to-neon-cyan px-4 py-2 text-[10px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(139,92,246,0.3)] transition-all duration-300 border border-brand-400/30">
                            <svg wire:loading.remove wire:target="retryAll" class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <svg wire:loading wire:target="retryAll" class="animate-spin w-3.5 h-3.5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                            Retry All Failed
                        </button>
                    </div>
                    <ul role="list" class="divide-y divide-white/5">
                        @foreach ($failedJobs as $fjob)
                            <li class="px-6 py-5 hover:bg-white/5 transition-colors group" x-data="{ open: false }">
                                <div class="flex justify-between items-center">
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <p class="text-sm font-black text-white flex items-center">
                                                {{ Str::limit($fjob->exception, 50) }}
                                            </p>
                                            <span class="ml-3 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest bg-rose-500/20 text-rose-400 border border-rose-500/30">Failed</span>
                                        </div>
                                        <div class="mt-2 flex items-center text-xs font-bold text-slate-400">
                                            <span class="mr-3 font-mono text-slate-500">{{ Str::afterLast($fjob->payload, '\\') ?? 'Unknown Job' }}</span>
                                            <span>Failed {{ \Carbon\Carbon::parse($fjob->failed_at)->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-300">
                                        <button @click="open = !open" class="text-[10px] uppercase font-black tracking-widest text-slate-400 hover:text-white underline decoration-slate-600 hover:decoration-white transition-colors mr-2">
                                            <span x-show="!open">Show Error</span>
                                            <span x-show="open">Hide Error</span>
                                        </button>
                                        <button wire:click="retryJob('{{ $fjob->uuid }}')" wire:loading.attr="disabled" wire:target="retryJob('{{ $fjob->uuid }}')" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center justify-center rounded-xl bg-white/5 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-slate-300 border border-white/10 hover:bg-white/10 hover:text-white transition-all focus:outline-none">
                                            <svg wire:loading.remove wire:target="retryJob('{{ $fjob->uuid }}')" class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            <svg wire:loading wire:target="retryJob('{{ $fjob->uuid }}')" class="animate-spin w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Retry
                                        </button>
                                        <button x-data x-on:click="if(confirm('Are you sure you want to delete this failed job?')) $wire.deleteFailedJob('{{ $fjob->uuid }}')" wire:loading.attr="disabled" wire:target="deleteFailedJob('{{ $fjob->uuid }}')" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center justify-center rounded-xl bg-rose-500/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-rose-400 border border-rose-500/20 hover:bg-rose-500/20 hover:text-rose-300 transition-all focus:outline-none">
                                            <svg wire:loading.remove wire:target="deleteFailedJob('{{ $fjob->uuid }}')" class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <svg wire:loading wire:target="deleteFailedJob('{{ $fjob->uuid }}')" class="animate-spin w-3.5 h-3.5 mr-1 text-rose-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                            Del
                                        </button>
                                    </div>
                                </div>
                                <div x-show="open" x-cloak class="mt-4 bg-black/50 rounded-xl p-4 overflow-x-auto shadow-inner border border-white/5">
                                    <pre class="text-[10px] text-neon-pink font-mono whitespace-pre-wrap break-words leading-relaxed">{{ substr($fjob->exception, 0, 1500) }}{{ strlen($fjob->exception) > 1500 ? '...' : '' }}</pre>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mb-6 shadow-[inset_0_2px_10px_rgba(16,185,129,0.2)] border border-emerald-500/20">
                            <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-black text-white tracking-wide">All clear</h3>
                        <p class="mt-2 text-sm text-slate-400 font-bold max-w-md">No failed jobs to display. Your automation systems are running smoothly.</p>
                    </div>
                @endif
            </div>

            <!-- Pending Jobs Tab -->
            <div x-show="activeTab === 'pending'" x-cloak class="p-2">
                @if($pendingJobs->count() > 0)
                    <ul role="list" class="divide-y divide-white/5">
                        @foreach ($pendingJobs as $job)
                            <li class="px-6 py-5 hover:bg-white/5 transition-colors">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-black text-white flex items-center">
                                            Job #{{ $job->id }}
                                            <span class="ml-3 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest bg-amber-500/20 text-amber-400 border border-amber-500/30 shadow-[0_0_8px_rgba(245,158,11,0.2)]">{{ $job->queue }}</span>
                                        </p>
                                        <p class="mt-2 flex items-center text-xs font-bold text-slate-400">
                                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Created {{ \Carbon\Carbon::createFromTimestamp($job->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="text-right bg-white/5 p-3 rounded-xl border border-white/5">
                                        <p class="text-xl text-neon-cyan font-black drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]">{{ $job->attempts }}</p>
                                        <p class="text-[9px] uppercase tracking-widest text-slate-500 font-black mt-1">Attempts</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mb-6 border border-white/10 shadow-[inset_0_2px_10px_rgba(0,0,0,0.3)]">
                            <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-lg font-black text-white tracking-wide">Queue is clear</h3>
                        <p class="mt-2 text-sm text-slate-400 font-bold max-w-md">No pending jobs in the queue. All background tasks have been processed.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
