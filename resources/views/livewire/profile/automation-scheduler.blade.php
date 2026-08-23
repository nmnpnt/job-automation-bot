<?php

use Livewire\Volt\Component;
use App\Models\ScrapingSchedule;
use App\Models\ScrapingJob;
use App\Jobs\RunUserScraperJob;
use Carbon\Carbon;

new class extends Component {
    public $schedules = [];
    public $recentJobs = [];
    
    // Form fields
    public $frequency = 'daily';
    public $time = '00:00';
    public $timezone = 'UTC';
    public $days = [];
    
    public $showForm = false;
    
    public function mount()
    {
        $this->timezone = config('app.timezone', 'UTC');
        $this->loadData();
    }
    
    public function loadData()
    {
        $this->schedules = ScrapingSchedule::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        $this->recentJobs = ScrapingJob::where('user_id', auth()->id())
            ->orderBy('started_at', 'desc')
            ->limit(5)
            ->get();
    }
    
    public function toggleActive($scheduleId)
    {
        $schedule = ScrapingSchedule::where('id', $scheduleId)->where('user_id', auth()->id())->first();
        if ($schedule) {
            $schedule->is_active = !$schedule->is_active;
            $schedule->save();
            $this->loadData();
        }
    }
    
    public function deleteSchedule($scheduleId)
    {
        ScrapingSchedule::where('id', $scheduleId)->where('user_id', auth()->id())->delete();
        $this->loadData();
    }
    
    public function saveSchedule()
    {
        $this->validate([
            'frequency' => 'required|in:once,daily,weekly,monthly',
            'time' => 'required',
            'timezone' => 'required',
            'days' => 'nullable|array',
        ]);
        
        ScrapingSchedule::create([
            'user_id' => auth()->id(),
            'frequency' => $this->frequency,
            'time' => $this->time,
            'timezone' => $this->timezone,
            'days' => $this->frequency === 'weekly' || $this->frequency === 'monthly' ? $this->days : null,
            'is_active' => true,
        ]);
        
        $this->showForm = false;
        // reset fields
        $this->frequency = 'daily';
        $this->time = '00:00';
        $this->days = [];
        
        $this->loadData();
    }
    
    public function runNow()
    {
        RunUserScraperJob::dispatch(auth()->id(), null, 'manual');
        session()->flash('message', 'Scraping job started manually in the background!');
        $this->loadData();
    }
}; ?>

<div class="space-y-8 animate-fade-in-up">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h3 class="text-2xl font-black text-white uppercase tracking-widest">Automation & Scheduling</h3>
            <p class="text-sm text-slate-400 mt-1 font-bold">Configure when the bot should automatically scrape jobs for you.</p>
        </div>
        <div class="flex space-x-3">
            <button wire:click="runNow" class="inline-flex items-center justify-center rounded-xl border border-emerald-500/50 bg-gradient-to-r from-emerald-500 to-teal-500 px-4 py-2 text-xs font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(16,185,129,0.4)] hover:shadow-[0_0_25px_rgba(16,185,129,0.6)] transition-all duration-300">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Run Now
            </button>
            <button wire:click="$toggle('showForm')" class="inline-flex items-center justify-center rounded-xl border border-neon-cyan/50 bg-gradient-to-r from-neon-cyan to-blue-500 px-4 py-2 text-xs font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(34,211,238,0.4)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] transition-all duration-300">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Schedule
            </button>
        </div>
    </div>
    
    @if (session()->has('message'))
        <div class="p-4 rounded-xl bg-emerald-500/10 text-xs font-black uppercase tracking-widest text-emerald-400 border border-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.2)] flex items-center">
            <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Form -->
    @if($showForm)
    <div class="bg-black/30 rounded-2xl border border-white/10 p-6 mb-8 shadow-inner">
        <h4 class="text-sm font-black text-white uppercase tracking-widest mb-4">Create Schedule</h4>
        <form wire:submit.prevent="saveSchedule" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative group/input">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Frequency</label>
                    <select wire:model.live="frequency" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-2.5 text-white text-sm font-bold shadow-sm focus:border-neon-cyan focus:ring-neon-cyan">
                        <option value="once" class="bg-slate-900">Once</option>
                        <option value="daily" class="bg-slate-900">Daily</option>
                        <option value="weekly" class="bg-slate-900">Weekly</option>
                        <option value="monthly" class="bg-slate-900">Monthly</option>
                    </select>
                </div>
                <div class="relative group/input">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Time</label>
                    <input type="time" wire:model="time" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-2.5 text-white text-sm font-bold shadow-sm focus:border-neon-cyan focus:ring-neon-cyan">
                </div>
                <div class="relative group/input">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Timezone</label>
                    <select wire:model="timezone" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-2.5 text-white text-sm font-bold shadow-sm focus:border-neon-cyan focus:ring-neon-cyan">
                        <option value="UTC" class="bg-slate-900">UTC</option>
                        <option value="America/New_York" class="bg-slate-900">Eastern Time</option>
                        <option value="America/Chicago" class="bg-slate-900">Central Time</option>
                        <option value="America/Los_Angeles" class="bg-slate-900">Pacific Time</option>
                        <option value="Europe/London" class="bg-slate-900">London</option>
                        <option value="Asia/Kolkata" class="bg-slate-900">India</option>
                    </select>
                </div>
            </div>
            
            @if($frequency === 'weekly')
            <div class="relative group/input mt-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Days of Week</label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                    <label class="inline-flex items-center rounded-lg border border-white/10 bg-white/5 px-3 py-1.5 cursor-pointer hover:bg-white/10">
                        <input type="checkbox" wire:model="days" value="{{ $day }}" class="form-checkbox h-4 w-4 text-neon-cyan border-white/20 rounded bg-black/50 focus:ring-neon-cyan">
                        <span class="ml-2 text-xs font-bold text-slate-300">{{ substr($day, 0, 3) }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif
            
            @if($frequency === 'monthly')
            <div class="relative group/input mt-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Day of Month</label>
                <input type="number" wire:model="days.0" min="1" max="31" class="block w-24 rounded-xl border border-white/10 bg-black/50 px-4 py-2.5 text-white text-sm font-bold shadow-sm focus:border-neon-cyan focus:ring-neon-cyan" placeholder="1-31">
            </div>
            @endif

            <div class="mt-4 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-brand-500/20 text-brand-300 border border-brand-500/50 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-brand-500 hover:text-white transition-all shadow-[0_0_10px_rgba(139,92,246,0.2)]">Save</button>
            </div>
        </form>
    </div>
    @endif

    <!-- Schedules List -->
    <div class="bg-black/20 rounded-[1.5rem] border border-white/5 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 bg-white/5">
            <h4 class="text-xs font-black text-white uppercase tracking-widest">Active Schedules</h4>
        </div>
        <div class="divide-y divide-white/5">
            @forelse($schedules as $schedule)
            <div class="p-6 flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-600 to-neon-pink flex items-center justify-center text-white shadow-[0_0_15px_rgba(255,42,133,0.3)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white flex items-center gap-2">
                            {{ ucfirst($schedule->frequency) }} at {{ $schedule->time }} ({{ $schedule->timezone }})
                            @if($schedule->frequency === 'weekly' && is_array($schedule->days))
                                <span class="text-xs text-slate-400 font-medium bg-white/5 px-2 py-0.5 rounded-md">{{ implode(', ', array_map(fn($d) => substr($d,0,3), $schedule->days)) }}</span>
                            @endif
                            @if($schedule->frequency === 'monthly' && is_array($schedule->days))
                                <span class="text-xs text-slate-400 font-medium bg-white/5 px-2 py-0.5 rounded-md">Day {{ $schedule->days[0] ?? 1 }}</span>
                            @endif
                        </div>
                        <div class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider font-black">
                            Next run: <span class="text-neon-cyan">{{ $schedule->next_run_at ? $schedule->next_run_at->diffForHumans() : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button wire:click="toggleActive('{{ $schedule->id }}')" class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $schedule->is_active ? 'bg-emerald-500' : 'bg-slate-700' }}">
                        <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $schedule->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                    </button>
                    <button wire:click="deleteSchedule('{{ $schedule->id }}')" class="p-2 text-rose-400 hover:text-rose-300 hover:bg-rose-400/10 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-400 text-sm font-bold">
                No schedules configured yet. Create one to automate job scraping.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Runs -->
    <div class="bg-black/20 rounded-[1.5rem] border border-white/5 overflow-hidden mt-8">
        <div class="px-6 py-4 border-b border-white/5 bg-white/5">
            <h4 class="text-xs font-black text-white uppercase tracking-widest">Recent Executions</h4>
        </div>
        <div class="divide-y divide-white/5">
            @forelse($recentJobs as $job)
            <div class="p-4 px-6 flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full {{ $job->status === 'completed' ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]' : ($job->status === 'failed' ? 'bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.8)]' : 'bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)] animate-pulse') }}"></div>
                    <div>
                        <div class="text-xs font-bold text-white">
                            {{ ucfirst($job->trigger_type) }} Run
                            <span class="text-slate-400 text-[10px] ml-2 font-normal">{{ $job->started_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-[10px] text-slate-500 mt-0.5">
                            @if(is_array($job->platforms)) {{ implode(', ', $job->platforms) }} @endif
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xs font-bold {{ $job->status === 'completed' ? 'text-emerald-400' : ($job->status === 'failed' ? 'text-rose-400' : 'text-amber-400') }}">
                        {{ ucfirst($job->status) }}
                    </div>
                    @if($job->status === 'completed')
                    <div class="text-[10px] font-black uppercase tracking-wider text-neon-cyan mt-1">
                        +{{ $job->new_jobs_added }} new jobs
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-slate-400 text-sm font-bold">
                No recent executions found.
            </div>
            @endforelse
        </div>
    </div>
</div>
