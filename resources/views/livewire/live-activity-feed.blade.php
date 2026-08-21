<div class="space-y-6">
    <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.2)] overflow-hidden transition-colors duration-500 p-6">
        <div class="flex flex-col md:flex-row justify-between md:items-center mb-8 border-b border-white/10 pb-6">
            <div class="flex items-center">
                <div class="p-3 bg-neon-pink/20 text-neon-pink rounded-2xl mr-4 border border-neon-pink/30 shadow-[0_0_15px_rgba(244,114,182,0.3)]">
                    <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-white tracking-wide uppercase">Live Activity Feed</h2>
                    <p class="text-sm font-bold text-slate-400 mt-1">Real-time updates from your automation bots.</p>
                </div>
            </div>
            
            <!-- Scraper Control -->
            <div wire:poll.5s class="mt-6 md:mt-0 flex items-center space-x-3 bg-black/40 backdrop-blur-xl pl-4 pr-1 py-1 rounded-2xl shadow-inner border border-white/10">
                @if($profile)
                    <div class="flex items-center">
                        <div class="w-2 h-2 rounded-full mr-2 {{ $profile->scraping_status === 'running' ? 'bg-amber-400 animate-pulse shadow-[0_0_8px_rgba(251,191,36,0.8)]' : ($profile->scraping_status === 'completed' ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-500') }}"></div>
                        <span class="text-[10px] font-black uppercase tracking-widest">
                            @if($profile->scraping_status === 'running')
                                <span class="text-amber-400">Running</span>
                            @elseif($profile->scraping_status === 'completed')
                                <span class="text-emerald-400">Idle</span>
                            @elseif($profile->scraping_status === 'failed')
                                <span class="text-neon-pink">Failed</span>
                            @else
                                <span class="text-slate-400">Idle</span>
                            @endif
                        </span>
                    </div>
                    
                    @if($profile->scraping_status === 'running')
                        <button wire:click="stopScraping" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-neon-pink to-rose-500 hover:from-rose-500 hover:to-rose-400 px-5 py-2.5 text-[10px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(255,42,133,0.4)] transition-all duration-300 group border border-neon-pink/50 ml-3">
                            <svg class="h-4 w-4 mr-2 text-white/80 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z" />
                            </svg>
                            Stop Scraper
                        </button>
                    @else
                        <button wire:click="startScraping" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-neon-cyan/80 hover:from-brand-500 hover:to-neon-cyan px-5 py-2.5 text-[10px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(139,92,246,0.4)] transition-all duration-300 group border border-brand-400/30 ml-3">
                            <svg class="h-4 w-4 mr-2 text-white/80 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            Scrape
                        </button>
                    @endif
                @endif
            </div>
        </div>

        @if($profile && $profile->scraping_status === 'running')
            <div class="mb-8">
                <livewire:scraper-console />
            </div>
        @endif

        <div class="space-y-4">
            @forelse($activities as $activity)
                <div class="flex items-start p-5 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl shadow-[inset_0_2px_4px_rgba(0,0,0,0.2)] transition-all duration-300 hover:bg-white/10 hover:border-brand-500/30 group">
                    <div class="flex-shrink-0 mr-5">
                        @if($activity['status'] === 'submitted' || $activity['status'] === 'auto_applied')
                            <div class="h-12 w-12 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                                <svg class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        @elseif($activity['status'] === 'failed' || $activity['status'] === 'requires_manual_intervention')
                            <div class="h-12 w-12 rounded-xl bg-neon-pink/20 border border-neon-pink/30 flex items-center justify-center shadow-[0_0_15px_rgba(255,42,133,0.2)]">
                                <svg class="h-6 w-6 text-neon-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        @else
                            <div class="h-12 w-12 rounded-xl bg-neon-cyan/20 border border-neon-cyan/30 flex items-center justify-center shadow-[0_0_15px_rgba(34,211,238,0.2)]">
                                <svg class="h-6 w-6 text-neon-cyan" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0 mt-1">
                        <p class="text-sm font-black text-white truncate">
                            @if(!empty($activity['original_job_url']))
                                <a href="{{ $activity['original_job_url'] }}" target="_blank" class="text-brand-400 hover:text-brand-300 transition-colors drop-shadow-[0_0_5px_rgba(139,92,246,0.5)]">
                                    {{ $activity['job_title'] }} <span class="text-slate-400 font-bold">at</span> {{ $activity['company_name'] }}
                                </a>
                            @else
                                {{ $activity['job_title'] }} <span class="text-slate-400 font-bold">at</span> {{ $activity['company_name'] }}
                            @endif
                        </p>
                        <p class="text-xs font-bold text-slate-400 mt-1.5">
                            {{ $activity['message'] }}
                        </p>
                        @if($activity['error_screenshot_path'])
                            <div class="mt-3">
                                <a href="{{ asset('storage/' . $activity['error_screenshot_path']) }}" target="_blank" class="text-[10px] uppercase font-black tracking-widest text-neon-pink hover:text-rose-400 inline-flex items-center transition-colors">
                                    <svg class="h-3.5 w-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    View Error Screenshot
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="flex-shrink-0 whitespace-nowrap text-[10px] uppercase font-black tracking-widest text-slate-500 ml-4 mt-2">
                        {{ \Carbon\Carbon::parse($activity['timestamp'])->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mb-4 border border-white/10">
                        <svg class="w-8 h-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-400">No recent activity. Monitoring for new jobs...</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
