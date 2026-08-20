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
    </style>
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-white/60 backdrop-blur-xl p-6 rounded-[2rem] border border-slate-200/80 shadow-sm relative overflow-hidden transition-colors duration-500">
        <div class="absolute top-0 right-0 w-96 h-96 bg-accent-500/10 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-500/10 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-accent-300/10 rounded-full blur-[60px] transform -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-extrabold leading-9 text-slate-900 tracking-tight flex items-center">
                <div class="p-2.5 bg-brand-50 text-brand-600 rounded-xl mr-4 shadow-sm border border-brand-100/50">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                Analytics Dashboard
            </h2>
            <p class="mt-1.5 text-sm text-slate-500 font-medium ml-16">Track your job search progress and system automations in real-time.</p>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex space-x-1 bg-white/60 p-1.5 rounded-2xl w-fit border border-slate-200/80 backdrop-blur-xl shadow-sm mb-4 ring-1 ring-slate-900/5">
        <button @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-white shadow-sm text-brand-600 ring-1 ring-slate-900/5' : 'text-slate-500 hover:text-slate-700 hover:bg-white/50'" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all">Overview</button>
        <button @click="tab = 'analytics'" :class="tab === 'analytics' ? 'bg-white shadow-sm text-brand-600 ring-1 ring-slate-900/5' : 'text-slate-500 hover:text-slate-700 hover:bg-white/50'" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all">Analytics</button>
        <button @click="tab = 'queue'" :class="tab === 'queue' ? 'bg-white shadow-sm text-brand-600 ring-1 ring-slate-900/5' : 'text-slate-500 hover:text-slate-700 hover:bg-white/50'" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all">Review Queue</button>
    </div>

    <!-- Overview Tab -->
    <div x-cloak x-show="tab === 'overview'" x-transition.opacity.duration.300ms class="space-y-8">

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        
        <!-- Total Discovered -->
        <a href="{{ route('jobs.index') }}" target="_blank" class="relative group bg-gradient-to-br from-white to-accent-50/30 backdrop-blur-xl rounded-[2rem] p-6 border border-slate-200/80 shadow-sm hover:shadow-lg hover:shadow-accent-500/10 hover:border-accent-200 transition-all duration-300 hover:-translate-y-1 block overflow-hidden ring-1 ring-slate-900/5">
            <div class="absolute inset-0 bg-gradient-to-br from-accent-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-accent-500/10 rounded-full blur-2xl group-hover:bg-accent-500/20 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-accent-50 text-accent-600 rounded-xl flex items-center justify-center border border-accent-100 shadow-sm group-hover:scale-110 group-hover:bg-accent-100 transition-all duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-1 bg-accent-50 text-accent-600 rounded-full border border-accent-100 shadow-sm">All Time</span>
            </div>
            <p class="text-sm font-semibold text-slate-500 relative z-10">Jobs Discovered</p>
            <p class="text-3xl font-black text-slate-900 mt-1.5 relative z-10">{{ $totalJobs }}</p>
        </a>

        <!-- Total Applied -->
        <div class="relative group bg-gradient-to-br from-white to-brand-50/30 backdrop-blur-xl rounded-[2rem] p-6 border border-slate-200/80 shadow-sm hover:shadow-lg hover:shadow-brand-500/10 hover:border-brand-200 transition-all duration-300 hover:-translate-y-1 overflow-hidden ring-1 ring-slate-900/5">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-brand-500/10 rounded-full blur-2xl group-hover:bg-brand-500/20 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center border border-brand-100 shadow-sm group-hover:scale-110 group-hover:bg-brand-100 transition-all duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500 relative z-10">Applications Sent</p>
            <p class="text-3xl font-black text-slate-900 mt-1.5 relative z-10">{{ $totalApplied }}</p>
        </div>

        <!-- Success Rate -->
        <div class="relative group bg-gradient-to-br from-white to-emerald-50/30 backdrop-blur-xl rounded-[2rem] p-6 border border-slate-200/80 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1 overflow-hidden ring-1 ring-slate-900/5">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center border border-emerald-100 shadow-sm group-hover:scale-110 group-hover:bg-emerald-100 transition-all duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500 relative z-10">Application Rate</p>
            <p class="text-3xl font-black text-slate-900 mt-1.5 relative z-10">{{ $successRate }}%</p>
        </div>

        <!-- Interviews -->
        <div class="relative group bg-gradient-to-br from-white to-purple-50/30 backdrop-blur-xl rounded-[2rem] p-6 border border-slate-200/80 shadow-sm hover:shadow-lg hover:shadow-purple-500/10 hover:border-purple-200 transition-all duration-300 hover:-translate-y-1 overflow-hidden ring-1 ring-slate-900/5">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center border border-purple-100 shadow-sm group-hover:scale-110 group-hover:bg-purple-100 transition-all duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500 relative z-10">Interviews Requested</p>
            <p class="text-3xl font-black text-slate-900 mt-1.5 relative z-10">{{ $interviews }}</p>
        </div>
    </div>

    <!-- Upcoming Scheduled Interviews Section -->
    @if(count($upcomingInterviews) > 0)
    <div class="bg-gradient-to-r from-slate-900 via-brand-950 to-slate-900 text-white rounded-[2rem] p-8 shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-accent-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-64 h-64 bg-brand-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="flex items-center justify-between mb-8 relative z-10">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-white/10 rounded-2xl backdrop-blur-md border border-white/10 shadow-inner">
                    <svg class="w-6 h-6 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-2xl font-black tracking-tight">Upcoming Interviews</h3>
                    <p class="text-sm text-brand-100/80 mt-1 font-medium">Stay prepared for your technical and behavioral rounds.</p>
                </div>
            </div>
            <a href="{{ route('interviews.index') }}" wire:navigate class="text-xs font-black uppercase tracking-wider bg-white/20 hover:bg-white/30 text-white px-5 py-2.5 rounded-xl transition-all backdrop-blur-md border border-white/10 shadow-sm hover:scale-105">
                Manage All
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 relative z-10">
            @foreach($upcomingInterviews as $interview)
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/10 hover:border-brand-400/50 hover:bg-white/15 transition-all group">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-black bg-brand-500/40 text-brand-100 uppercase tracking-wider mb-3 border border-brand-400/20 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-400 mr-1.5"></span>
                            {{ $interview->interview_type ?? 'Interview' }}
                        </span>
                        <h4 class="text-base font-bold text-white group-hover:text-brand-100 transition-colors">{{ Str::limit($interview->job_title, 32) }}</h4>
                        <p class="text-sm text-slate-300 font-medium mt-1 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            {{ $interview->company_name }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                    <div class="flex items-center text-brand-100 font-bold bg-white/5 px-2.5 py-1.5 rounded-lg border border-white/5">
                        <svg class="w-4 h-4 mr-2 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $interview->interview_scheduled_at ? $interview->interview_scheduled_at->format('M d, Y - h:i A') : 'Date TBD' }}
                    </div>
                    @if($interview->interview_meeting_link)
                    <a href="{{ $interview->interview_meeting_link }}" target="_blank" class="inline-flex items-center text-xs font-black bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/30 hover:text-emerald-200 px-3 py-1.5 rounded-lg transition-colors border border-emerald-500/30 shadow-sm">
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
    <div x-cloak x-show="tab === 'analytics'" x-transition.opacity.duration.300ms class="space-y-8">

    <!-- Details Section -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Interviews by Platform -->
        <div class="bg-white/90 backdrop-blur-2xl rounded-[2rem] border border-slate-200/80 shadow-sm overflow-hidden flex flex-col ring-1 ring-slate-900/5 transition-colors duration-500">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-lg font-black text-slate-900">Platform Performance</h3>
                <span class="p-2.5 bg-brand-50 text-brand-600 rounded-xl border border-brand-100 shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></span>
            </div>
            <div class="p-6 flex-1">
                <div class="space-y-4">
                    @forelse($platformStats as $platform => $count)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-brand-500 mr-3"></div>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-brand-600 transition-colors">{{ $platform }}</span>
                        </div>
                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700">
                            {{ $count }}
                        </span>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-full text-center py-8">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-slate-500">No interviews logged yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Overall Status Breakdown -->
        <div class="bg-white/90 backdrop-blur-2xl rounded-[2rem] border border-slate-200/80 shadow-sm overflow-hidden flex flex-col ring-1 ring-slate-900/5 transition-colors duration-500">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-lg font-black text-slate-900">Funnel Breakdown</h3>
                <span class="p-2.5 bg-accent-50 text-accent-600 rounded-xl border border-accent-100 shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg></span>
            </div>
            <div class="p-6 flex-1">
                <div class="space-y-4">
                    @forelse($statusStats as $status => $count)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center">
                            @php
                                    $color = match($status) {
                                    'APPLIED' => 'accent',
                                    'INTERVIEW_REQUESTED' => 'purple',
                                    'OFFER_RECEIVED' => 'brand',
                                    'REJECTED' => 'rose',
                                    default => 'slate'
                                };
                            @endphp
                            <div class="w-2 h-2 rounded-full bg-{{ $color }}-500 mr-3"></div>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-{{ $color }}-600 transition-colors">{{ ucwords(strtolower(str_replace('_', ' ', $status))) }}</span>
                        </div>
                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                            {{ $count }}
                        </span>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-full text-center py-8">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-slate-500">No applications tracked.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Analytics Charts -->
    <div class="bg-white/90 backdrop-blur-2xl rounded-[2rem] border border-slate-200/80 shadow-sm overflow-hidden p-6 ring-1 ring-slate-900/5 transition-colors duration-500">
        <livewire:job-analytics />
    </div>

    </div>

    <!-- Queue Tab -->
    <div x-cloak x-show="tab === 'queue'" x-transition.opacity.duration.300ms class="space-y-8">

    <!-- Job Review Queue -->
    <div class="bg-white/90 backdrop-blur-2xl rounded-[2rem] border border-slate-200/80 shadow-sm overflow-hidden p-6 ring-1 ring-slate-900/5 transition-colors duration-500">
        <livewire:job-review-queue />
    </div>
    
    </div>
</div>
