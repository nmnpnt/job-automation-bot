<div class="space-y-8 animate-fade-in-up">
    <style>
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
    <div class="md:flex md:items-center md:justify-between bg-white/60 backdrop-blur-xl p-6 rounded-3xl border border-slate-200/60 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/20 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-purple-500/10 rounded-full blur-[60px] transform -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-extrabold leading-9 text-slate-900 tracking-tight">
                Analytics Dashboard
            </h2>
            <p class="mt-1 text-sm text-slate-500 font-medium">Track your job search progress and system automations in real-time.</p>
        </div>
        <div class="mt-6 md:mt-0 md:ml-4 flex items-center space-x-4 relative z-10">
            <!-- Scraper Control -->
            <div wire:poll.5s class="flex items-center space-x-3 bg-white/80 backdrop-blur-md pl-4 pr-1 py-1 rounded-2xl shadow-sm border border-slate-200">
                @if($profile)
                    <div class="flex items-center">
                        <div class="w-2 h-2 rounded-full mr-2 {{ $profile->scraping_status === 'running' ? 'bg-amber-500 animate-pulse' : ($profile->scraping_status === 'completed' ? 'bg-emerald-500' : 'bg-slate-400') }}"></div>
                        <span class="text-xs font-bold uppercase tracking-wide text-slate-500">
                            @if($profile->scraping_status === 'running')
                                <span class="text-amber-600">Running</span>
                            @elseif($profile->scraping_status === 'completed')
                                <span class="text-emerald-600">Idle</span>
                            @elseif($profile->scraping_status === 'failed')
                                <span class="text-rose-600">Failed</span>
                            @else
                                <span>Idle</span>
                            @endif
                        </span>
                    </div>
                    
                    <button wire:click="startScraping" @if($profile->scraping_status === 'running') disabled @endif class="inline-flex items-center justify-center rounded-xl border border-transparent bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-600 focus:outline-none transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed group">
                        <svg class="h-4 w-4 mr-2 text-slate-400 group-hover:text-indigo-200 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Scrape
                    </button>
                @endif
            </div>

            <a href="{{ route('resume.view') }}" target="_blank" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 hover:border-slate-300 focus:outline-none transition-all duration-200 hover:-translate-y-0.5">
                <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Resume
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        
        <!-- Total Discovered -->
        <a href="{{ route('jobs.index') }}" target="_blank" class="relative group bg-gradient-to-br from-white to-indigo-50/30 backdrop-blur-xl rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-lg hover:shadow-indigo-500/10 hover:border-indigo-200 transition-all duration-300 hover:-translate-y-1 block overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-full">All Time</span>
            </div>
            <p class="text-sm font-semibold text-slate-500 relative z-10">Jobs Discovered</p>
            <p class="text-3xl font-black text-slate-900 mt-1 relative z-10">{{ $totalJobs }}</p>
        </a>

        <!-- Total Applied -->
        <div class="relative group bg-gradient-to-br from-white to-blue-50/30 backdrop-blur-xl rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-lg hover:shadow-blue-500/10 hover:border-blue-200 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500 relative z-10">Applications Sent</p>
            <p class="text-3xl font-black text-slate-900 mt-1 relative z-10">{{ $totalApplied }}</p>
        </div>

        <!-- Success Rate -->
        <div class="relative group bg-gradient-to-br from-white to-emerald-50/30 backdrop-blur-xl rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500 relative z-10">Application Rate</p>
            <p class="text-3xl font-black text-slate-900 mt-1 relative z-10">{{ $successRate }}%</p>
        </div>

        <!-- Interviews -->
        <div class="relative group bg-gradient-to-br from-white to-violet-50/30 backdrop-blur-xl rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-lg hover:shadow-violet-500/10 hover:border-violet-200 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-violet-100 text-violet-600 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500 relative z-10">Interviews Requested</p>
            <p class="text-3xl font-black text-slate-900 mt-1 relative z-10">{{ $interviews }}</p>
        </div>
    </div>

    <!-- Details Section -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Interviews by Platform -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900">Platform Performance</h3>
                <span class="p-2 bg-indigo-50 text-indigo-500 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></span>
            </div>
            <div class="p-6 flex-1">
                <div class="space-y-4">
                    @forelse($platformStats as $platform => $count)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-indigo-500 mr-3"></div>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-indigo-600 transition-colors">{{ $platform }}</span>
                        </div>
                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">
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
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900">Funnel Breakdown</h3>
                <span class="p-2 bg-purple-50 text-purple-500 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg></span>
            </div>
            <div class="p-6 flex-1">
                <div class="space-y-4">
                    @forelse($statusStats as $status => $count)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center">
                            @php
                                $color = match($status) {
                                    'APPLIED' => 'blue',
                                    'INTERVIEW_REQUESTED' => 'violet',
                                    'OFFER_RECEIVED' => 'emerald',
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
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6">
        <livewire:job-analytics />
    </div>

    <!-- Job Review Queue -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6">
        <livewire:job-review-queue />
    </div>
</div>
