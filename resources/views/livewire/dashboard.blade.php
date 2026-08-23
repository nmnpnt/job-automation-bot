<div x-data="{ tab: 'overview' }" class="space-y-8 animate-fade-in-up">
    <style>
        [x-cloak] { display: none !important; }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .hud-border {
            position: relative;
        }
        .hud-border::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, rgba(139,92,246,0.5), rgba(34,211,238,0.5), rgba(244,114,182,0.5));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
    </style>
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-white/5 backdrop-blur-2xl p-6 rounded-[2rem] hud-border shadow-[0_10px_40px_rgba(0,0,0,0.2)] relative overflow-hidden transition-colors duration-500">
        <!-- Animated Background Blobs -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-neon-cyan/10 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-blob mix-blend-screen"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-500/10 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none animate-blob mix-blend-screen" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-neon-pink/10 rounded-full blur-[60px] transform -translate-x-1/2 -translate-y-1/2 pointer-events-none animate-blob mix-blend-screen" style="animation-delay: 4s;"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-black leading-9 text-white tracking-tight flex items-center">
                <div class="p-3 bg-gradient-to-br from-brand-500/20 to-neon-cyan/20 text-neon-cyan rounded-2xl mr-4 border border-neon-cyan/30 shadow-[0_0_15px_rgba(34,211,238,0.3)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                Command Center
            </h2>
            <p class="mt-2 text-sm text-slate-400 font-medium ml-[4.5rem]">Monitor your automated deployments and interview matrix.</p>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex space-x-2 bg-slate-900/50 p-1.5 rounded-2xl w-fit border border-white/10 backdrop-blur-xl shadow-lg mb-4">
        <button @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-gradient-to-r from-brand-600/80 to-neon-purple/80 shadow-[0_0_15px_rgba(139,92,246,0.4)] text-white' : 'text-slate-400 hover:text-white hover:bg-white/10'" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300">Overview</button>
        <button @click="tab = 'analytics'" :class="tab === 'analytics' ? 'bg-gradient-to-r from-brand-600/80 to-neon-purple/80 shadow-[0_0_15px_rgba(139,92,246,0.4)] text-white' : 'text-slate-400 hover:text-white hover:bg-white/10'" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300">Analytics</button>
    </div>

    <!-- Overview Tab -->
    <div x-cloak x-show="tab === 'overview'" x-transition.opacity.duration.300ms class="space-y-8">

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        
        <!-- Total Discovered -->
        <a href="{{ route('jobs.index') }}" wire:navigate class="relative group bg-slate-900/60 backdrop-blur-xl rounded-[2rem] p-6 border border-white/10 shadow-lg hover:shadow-[0_10px_30px_rgba(34,211,238,0.2)] hover:border-neon-cyan/50 transition-all duration-500 hover:-translate-y-2 block overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-neon-cyan/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-neon-cyan/10 rounded-full blur-2xl group-hover:bg-neon-cyan/20 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-neon-cyan/10 text-neon-cyan rounded-2xl flex items-center justify-center border border-neon-cyan/30 shadow-[0_0_15px_rgba(34,211,238,0.2)] group-hover:scale-110 group-hover:bg-neon-cyan/20 transition-all duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 bg-neon-cyan/10 text-neon-cyan rounded-full border border-neon-cyan/30 shadow-[0_0_10px_rgba(34,211,238,0.2)]">All Time</span>
            </div>
            <p class="text-sm font-semibold text-slate-400 relative z-10 uppercase tracking-wider">Discovered</p>
            <p class="text-4xl font-black text-white mt-1.5 relative z-10 drop-shadow-[0_0_8px_rgba(255,255,255,0.3)]">{{ $totalJobs }}</p>
        </a>

        <!-- Total Applied -->
        <div class="relative group bg-slate-900/60 backdrop-blur-xl rounded-[2rem] p-6 border border-white/10 shadow-lg hover:shadow-[0_10px_30px_rgba(139,92,246,0.2)] hover:border-brand-500/50 transition-all duration-500 hover:-translate-y-2 overflow-hidden cursor-default">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-brand-500/10 rounded-full blur-2xl group-hover:bg-brand-500/20 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-brand-500/10 text-brand-400 rounded-2xl flex items-center justify-center border border-brand-500/30 shadow-[0_0_15px_rgba(139,92,246,0.2)] group-hover:scale-110 group-hover:bg-brand-500/20 transition-all duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-400 relative z-10 uppercase tracking-wider">Applied</p>
            <p class="text-4xl font-black text-white mt-1.5 relative z-10 drop-shadow-[0_0_8px_rgba(255,255,255,0.3)]">{{ $totalApplied }}</p>
        </div>

        <!-- Success Rate -->
        <div class="relative group bg-slate-900/60 backdrop-blur-xl rounded-[2rem] p-6 border border-white/10 shadow-lg hover:shadow-[0_10px_30px_rgba(244,114,182,0.2)] hover:border-neon-pink/50 transition-all duration-500 hover:-translate-y-2 overflow-hidden cursor-default">
            <div class="absolute inset-0 bg-gradient-to-br from-neon-pink/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-neon-pink/10 rounded-full blur-2xl group-hover:bg-neon-pink/20 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-neon-pink/10 text-neon-pink rounded-2xl flex items-center justify-center border border-neon-pink/30 shadow-[0_0_15px_rgba(244,114,182,0.2)] group-hover:scale-110 group-hover:bg-neon-pink/20 transition-all duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-400 relative z-10 uppercase tracking-wider">Hit Rate</p>
            <p class="text-4xl font-black text-white mt-1.5 relative z-10 drop-shadow-[0_0_8px_rgba(255,255,255,0.3)]">{{ $successRate }}%</p>
        </div>

        <!-- Interviews -->
        <div class="relative group bg-slate-900/60 backdrop-blur-xl rounded-[2rem] p-6 border border-white/10 shadow-lg hover:shadow-[0_10px_30px_rgba(59,130,246,0.2)] hover:border-blue-500/50 transition-all duration-500 hover:-translate-y-2 overflow-hidden cursor-default">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-blue-500/10 text-blue-400 rounded-2xl flex items-center justify-center border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.2)] group-hover:scale-110 group-hover:bg-blue-500/20 transition-all duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-400 relative z-10 uppercase tracking-wider">Interviews</p>
            <p class="text-4xl font-black text-white mt-1.5 relative z-10 drop-shadow-[0_0_8px_rgba(255,255,255,0.3)]">{{ $interviews }}</p>
        </div>
    </div>

    <!-- Upcoming Scheduled Interviews Section -->
    @if(count($upcomingInterviews) > 0)
    <div class="bg-slate-900/60 text-white rounded-[2rem] p-8 shadow-[0_10px_40px_rgba(0,0,0,0.3)] relative overflow-hidden hud-border border border-white/5 backdrop-blur-2xl">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-neon-cyan/20 rounded-full blur-[100px] pointer-events-none animate-blob mix-blend-screen"></div>
        <div class="absolute -left-10 -top-10 w-64 h-64 bg-brand-500/20 rounded-full blur-[100px] pointer-events-none animate-blob mix-blend-screen" style="animation-delay: 2s;"></div>
        
        <div class="flex items-center justify-between mb-8 relative z-10 border-b border-white/10 pb-6">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-gradient-to-br from-white/10 to-transparent rounded-2xl backdrop-blur-md border border-white/20 shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                    <svg class="w-7 h-7 text-white drop-shadow-[0_0_5px_rgba(255,255,255,0.5)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-2xl font-black tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400">Incoming Transmissions</h3>
                    <p class="text-sm text-neon-cyan mt-1 font-bold uppercase tracking-widest text-shadow-glow">Awaiting your response</p>
                </div>
            </div>
            <a href="{{ route('interviews.index') }}" wire:navigate class="text-xs font-black uppercase tracking-wider bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl transition-all backdrop-blur-md border border-white/20 shadow-[0_0_15px_rgba(255,255,255,0.1)] hover:shadow-[0_0_20px_rgba(255,255,255,0.2)] hover:scale-105">
                View Log
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
            @foreach($upcomingInterviews as $interview)
            <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 border border-white/10 hover:border-brand-400/50 hover:bg-white/10 hover:shadow-[0_0_30px_rgba(139,92,246,0.15)] transition-all duration-300 group transform hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-[10px] font-black bg-brand-500/20 text-brand-300 uppercase tracking-widest mb-4 border border-brand-400/30 shadow-[0_0_10px_rgba(139,92,246,0.2)]">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-400 mr-2 animate-pulse"></span>
                            {{ $interview->interview_type ?? 'Interview' }}
                        </span>
                        <h4 class="text-lg font-black text-white group-hover:text-brand-300 transition-colors drop-shadow-sm">{{ Str::limit($interview->job_title, 32) }}</h4>
                        <p class="text-sm text-slate-400 font-bold mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            {{ $interview->company_name }}
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-white/10 flex items-center justify-between text-xs">
                    <div class="flex items-center text-neon-cyan font-bold bg-neon-cyan/10 px-3 py-2 rounded-xl border border-neon-cyan/20 shadow-[0_0_10px_rgba(34,211,238,0.1)]">
                        <svg class="w-4 h-4 mr-2 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $interview->interview_scheduled_at ? $interview->interview_scheduled_at->format('M d, Y - h:i A') : 'Date TBD' }}
                    </div>
                    @if($interview->interview_meeting_link)
                    <a href="{{ $interview->interview_meeting_link }}" target="_blank" class="inline-flex items-center text-xs font-black bg-neon-pink/20 text-neon-pink hover:bg-neon-pink/30 hover:shadow-[0_0_15px_rgba(244,114,182,0.3)] px-4 py-2 rounded-xl transition-all border border-neon-pink/30">
                        Join Call
                        <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    </div>

    <!-- Analytics Tab -->
    <div x-cloak x-show="tab === 'analytics'" x-init="$watch('tab', value => { if (value === 'analytics') setTimeout(() => window.dispatchEvent(new Event('resize')), 100) })" x-transition.opacity.duration.300ms class="space-y-8">

    <!-- Details Section -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Interviews by Platform -->
        <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.2)] overflow-hidden flex flex-col transition-colors duration-500">
            <div class="px-6 py-5 border-b border-white/10 flex items-center justify-between bg-white/5">
                <h3 class="text-lg font-black text-white uppercase tracking-wider">Platform Performance</h3>
                <span class="p-2.5 bg-brand-500/20 text-brand-400 rounded-xl border border-brand-500/30 shadow-[0_0_10px_rgba(139,92,246,0.2)]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></span>
            </div>
            <div class="p-6 flex-1">
                <div class="space-y-4">
                    @forelse($platformStats as $platform => $count)
                    <div class="flex items-center justify-between group bg-white/5 p-4 rounded-xl border border-white/5 hover:border-brand-500/30 hover:bg-white/10 transition-all">
                        <div class="flex items-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-brand-500 mr-3 shadow-[0_0_8px_rgba(139,92,246,0.6)]"></div>
                            <span class="text-sm font-bold text-slate-300 group-hover:text-white transition-colors">{{ $platform }}</span>
                        </div>
                        <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-xs font-black bg-brand-500/20 text-brand-300 border border-brand-500/30">
                            {{ $count }}
                        </span>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-full text-center py-8">
                        <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mb-4 border border-white/10">
                            <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-500">No data available.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Overall Status Breakdown -->
        <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.2)] overflow-hidden flex flex-col transition-colors duration-500">
            <div class="px-6 py-5 border-b border-white/10 flex items-center justify-between bg-white/5">
                <h3 class="text-lg font-black text-white uppercase tracking-wider">Funnel Breakdown</h3>
                <span class="p-2.5 bg-neon-cyan/20 text-neon-cyan rounded-xl border border-neon-cyan/30 shadow-[0_0_10px_rgba(34,211,238,0.2)]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg></span>
            </div>
            <div class="p-6 flex-1">
                <div class="space-y-4">
                    @forelse($statusStats as $status => $count)
                    <div class="flex items-center justify-between group bg-white/5 p-4 rounded-xl border border-white/5 hover:border-white/20 hover:bg-white/10 transition-all">
                        <div class="flex items-center">
                            @php
                                $colorClass = match($status) {
                                'APPLIED' => 'bg-neon-cyan shadow-[0_0_8px_rgba(34,211,238,0.8)]',
                                'INTERVIEW_REQUESTED' => 'bg-brand-500 shadow-[0_0_8px_rgba(139,92,246,0.8)]',
                                'OFFER_RECEIVED' => 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]',
                                'REJECTED' => 'bg-neon-pink shadow-[0_0_8px_rgba(255,42,133,0.8)]',
                                default => 'bg-slate-500 shadow-[0_0_8px_rgba(100,116,139,0.8)]'
                            };
                            @endphp
                            <div class="w-2.5 h-2.5 rounded-full mr-3 {{ $colorClass }}"></div>
                            <span class="text-sm font-bold text-slate-300 group-hover:text-white transition-colors">{{ ucwords(strtolower(str_replace('_', ' ', $status))) }}</span>
                        </div>
                        <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-xs font-black bg-white/10 text-white border border-white/20">
                            {{ $count }}
                        </span>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-full text-center py-8">
                        <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mb-4 border border-white/10">
                            <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-500">No data available.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Analytics Charts -->
    <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.2)] overflow-hidden p-6 transition-colors duration-500">
        <livewire:job-analytics />
    </div>

    </div>

</div>
