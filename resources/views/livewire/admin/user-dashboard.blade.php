<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\ScrapingJob;
use App\Models\ScrapingSchedule;
use App\Models\UserActivity;

new #[Layout('layouts.app')] class extends Component {
    public User $user;
    
    // Stats
    public $totalJobsFound = 0;
    public $totalJobsAdded = 0;
    public $activeSchedulesCount = 0;
    
    // Data lists
    public $recentScrapes = [];
    public $schedules = [];
    public $activityLog = [];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->loadData();
    }
    
    public function loadData()
    {
        // Stats
        $this->totalJobsFound = ScrapingJob::where('user_id', $this->user->id)->sum('total_urls_found');
        $this->totalJobsAdded = ScrapingJob::where('user_id', $this->user->id)->sum('processed_count');
        $this->activeSchedulesCount = ScrapingSchedule::where('user_id', $this->user->id)->where('is_active', true)->count();
        
        // Lists
        $this->recentScrapes = ScrapingJob::where('user_id', $this->user->id)
            ->orderBy('started_at', 'desc')
            ->limit(5)
            ->get();
            
        $this->schedules = ScrapingSchedule::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $this->activityLog = UserActivity::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }
}; ?>

<style>
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
<div>
    <x-slot name="header">
        <div class="relative bg-white/5 backdrop-blur-2xl p-6 rounded-[2rem] hud-border shadow-[0_10px_40px_rgba(0,0,0,0.2)] overflow-hidden flex justify-between items-center w-full">
            <!-- Animated Background Blobs -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-neon-cyan/10 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-blob mix-blend-screen"></div>
            
            <h2 class="relative z-10 text-3xl font-black text-white uppercase tracking-widest drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                {{ __('User 360° Dashboard') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="relative z-10 inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-4 py-2 text-xs font-black uppercase tracking-widest text-white hover:bg-white/10 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 animate-fade-in-up">
            
            <!-- User Profile Header Card -->
            <div class="bg-black/40 backdrop-blur-2xl rounded-[2rem] hud-border shadow-[0_5px_20px_rgba(0,0,0,0.3)] p-8 md:p-10 flex flex-col md:flex-row items-center gap-8 relative overflow-hidden group">
                <!-- decorative background blur -->
                <div class="absolute -inset-1 bg-gradient-to-r from-neon-cyan/20 via-brand-500/20 to-neon-pink/20 blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 pointer-events-none"></div>
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-brand-500/20 rounded-full blur-3xl opacity-50 group-hover:opacity-75 transition-opacity duration-700"></div>
                
                <div class="relative z-10 h-24 w-24 rounded-full bg-gradient-to-br from-brand-600 to-neon-pink p-1 shadow-[0_0_20px_rgba(255,42,133,0.4)] flex-shrink-0">
                    <div class="h-full w-full rounded-full bg-black flex items-center justify-center text-3xl font-black text-white">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
                
                <div class="relative z-10 flex-1 text-center md:text-left">
                    <h3 class="text-3xl font-black text-white tracking-tight">{{ $user->name }}</h3>
                    <p class="text-slate-400 font-medium text-sm mt-1">{{ $user->email }} &bull; Joined {{ $user->created_at->format('F j, Y') }}</p>
                    @if($user->is_admin)
                        <div class="mt-3 inline-flex items-center rounded-md bg-rose-500/10 px-2 py-1 text-xs font-black uppercase tracking-widest text-rose-400 ring-1 ring-inset ring-rose-500/20">Administrator</div>
                    @endif
                </div>
                
                <div class="relative z-10 flex gap-4 flex-wrap justify-center">
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center min-w-[120px]">
                        <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400 drop-shadow-[0_0_10px_rgba(16,185,129,0.5)]">
                            {{ number_format($totalJobsAdded) }}
                        </div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-1">Jobs Sourced</div>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center min-w-[120px]">
                        <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-purple-400 drop-shadow-[0_0_10px_rgba(139,92,246,0.5)]">
                            {{ $activeSchedulesCount }}
                        </div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-1">Active Automations</div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Schedules & Automation -->
                <div class="bg-black/40 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_5px_20px_rgba(0,0,0,0.3)] overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-white/10 bg-white/5 flex items-center justify-between">
                        <h4 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-5 h-5 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Automation Schedules
                        </h4>
                    </div>
                    <div class="p-6 flex-1">
                        <div class="space-y-4">
                            @forelse($schedules as $schedule)
                                <div class="bg-white/5 border border-white/10 rounded-xl p-4 flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-bold text-white flex items-center gap-2">
                                            {{ ucfirst($schedule->frequency) }} at {{ $schedule->time }} ({{ $schedule->timezone }})
                                        </div>
                                        <div class="text-[10px] text-slate-400 mt-1 font-medium">
                                            Next run: {{ $schedule->next_run_at ? $schedule->next_run_at->format('M j, Y H:i') : 'N/A' }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center rounded-md {{ $schedule->is_active ? 'bg-emerald-500/10 text-emerald-400 ring-emerald-500/20' : 'bg-slate-500/10 text-slate-400 ring-slate-500/20' }} px-2 py-1 text-[10px] font-black uppercase tracking-widest ring-1 ring-inset">
                                            {{ $schedule->is_active ? 'Active' : 'Paused' }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-slate-500 text-sm font-bold">No schedules configured.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Scraping Jobs -->
                <div class="bg-black/40 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_5px_20px_rgba(0,0,0,0.3)] overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-white/10 bg-white/5 flex items-center justify-between">
                        <h4 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            Recent Scrape Jobs
                        </h4>
                    </div>
                    <div class="p-6 flex-1">
                        <div class="space-y-4">
                            @forelse($recentScrapes as $job)
                                <div class="bg-white/5 border border-white/10 rounded-xl p-4 flex items-center justify-between">
                                    <div>
                                        <div class="text-xs font-bold text-white flex items-center gap-2">
                                            {{ ucfirst($job->trigger_type) }} Run
                                            <span class="text-[10px] text-slate-400 font-normal">
                                                {{ $job->started_at->format('M j, H:i') }}
                                            </span>
                                        </div>
                                        <div class="text-[10px] text-slate-500 mt-1 flex items-center gap-1.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $job->completed_at ? $job->completed_at->diffInSeconds($job->started_at) . 's duration' : 'Running...' }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center rounded-md {{ $job->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400 ring-emerald-500/20' : ($job->status === 'failed' ? 'bg-rose-500/10 text-rose-400 ring-rose-500/20' : 'bg-amber-500/10 text-amber-400 ring-amber-500/20') }} px-2 py-1 text-[10px] font-black uppercase tracking-widest ring-1 ring-inset">
                                            {{ $job->status }}
                                        </span>
                                        @if($job->status === 'completed')
                                            <div class="text-[10px] font-black text-neon-cyan mt-1 text-right">+{{ $job->new_jobs_added }} jobs</div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-slate-500 text-sm font-bold">No scraping jobs run yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Activity Log -->
            <div class="bg-black/40 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_5px_20px_rgba(0,0,0,0.3)] overflow-hidden">
                <div class="p-6 border-b border-white/10 bg-white/5 flex items-center justify-between">
                    <h4 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Recent Activity
                    </h4>
                </div>
                <div class="divide-y divide-white/5">
                    @forelse($activityLog as $activity)
                        <div class="p-4 px-6 flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-slate-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-white">{{ $activity->activity_type }}</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5 max-w-lg truncate">{{ $activity->description }}</div>
                                </div>
                            </div>
                            <div class="text-xs text-slate-500 font-medium whitespace-nowrap">
                                {{ $activity->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 text-sm font-bold">No recent activity recorded.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
