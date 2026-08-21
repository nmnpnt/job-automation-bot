<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('jobs.index') }}" wire:navigate class="mr-4 p-2 rounded-xl bg-white/5 shadow-[0_0_15px_rgba(255,255,255,0.05)] border border-white/10 text-slate-400 hover:text-white hover:bg-white/10 transition-colors hover:shadow-[0_0_20px_rgba(255,255,255,0.1)]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-black text-xl text-white tracking-wide drop-shadow-md">
                    {{ __('Job Details') }}
                </h2>
            </div>
            <div>
                @php
                    $statusConfig = match($job->status->value) {
                        'DISCOVERED' => ['bg' => 'bg-white/10', 'text' => 'text-slate-300', 'border' => 'border-white/20', 'shadow' => 'shadow-[0_0_10px_rgba(255,255,255,0.1)]'],
                        'APPLIED' => ['bg' => 'bg-neon-cyan/20', 'text' => 'text-neon-cyan', 'border' => 'border-neon-cyan/50', 'shadow' => 'shadow-[0_0_10px_rgba(34,211,238,0.3)]'],
                        'PENDING_REVIEW' => ['bg' => 'bg-amber-500/20', 'text' => 'text-amber-300', 'border' => 'border-amber-500/50', 'shadow' => 'shadow-[0_0_10px_rgba(245,158,11,0.3)]'],
                        'INTERVIEW_REQUESTED' => ['bg' => 'bg-brand-500/20', 'text' => 'text-brand-300', 'border' => 'border-brand-500/50', 'shadow' => 'shadow-[0_0_10px_rgba(139,92,246,0.3)]'],
                        'REJECTED' => ['bg' => 'bg-neon-pink/20', 'text' => 'text-neon-pink', 'border' => 'border-neon-pink/50', 'shadow' => 'shadow-[0_0_10px_rgba(244,114,182,0.3)]'],
                        default => ['bg' => 'bg-white/10', 'text' => 'text-slate-300', 'border' => 'border-white/20', 'shadow' => 'shadow-[0_0_10px_rgba(255,255,255,0.1)]']
                    };
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }} {{ $statusConfig['shadow'] }}">
                    {{ str_replace('_', ' ', $job->status->name) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header Card -->
        <div class="bg-slate-900/60 backdrop-blur-2xl overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.5)] sm:rounded-[2rem] border border-white/10 p-6 md:p-10 relative group transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-500/10 to-neon-cyan/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight drop-shadow-[0_0_15px_rgba(255,255,255,0.2)]">{{ $job->job_title }}</h1>
                    <div class="mt-3 text-lg text-slate-300 font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 text-neon-cyan drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $job->company_name }}
                    </div>
                    <div class="mt-5 flex flex-wrap gap-3 text-xs font-black tracking-widest uppercase">
                        @if($job->location)
                            <div class="flex items-center gap-1.5 bg-white/5 border border-white/10 text-slate-300 px-3 py-1.5 rounded-xl shadow-[0_0_10px_rgba(255,255,255,0.05)]">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $job->location }}
                            </div>
                        @endif
                        @if($job->salary_info)
                            <div class="flex items-center gap-1.5 bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 px-3 py-1.5 rounded-xl shadow-[0_0_10px_rgba(16,185,129,0.2)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $job->salary_info }}
                            </div>
                        @endif
                        @if($job->employment_type)
                            <div class="flex items-center gap-1.5 bg-blue-500/20 border border-blue-500/30 text-blue-400 px-3 py-1.5 rounded-xl shadow-[0_0_10px_rgba(59,130,246,0.2)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $job->employment_type }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col gap-3 shrink-0">
                    <a href="{{ $job->original_job_url }}" target="_blank" class="inline-flex justify-center items-center px-6 py-3 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-[0_0_15px_rgba(255,255,255,0.05)] hover:shadow-[0_0_25px_rgba(255,255,255,0.15)] hover:scale-105">
                        Original Post
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    
                    @if(in_array($job->status->value, ['DISCOVERED', 'MATCHED', 'READY_TO_APPLY']))
                    <button wire:click="markAsApplied" wire:loading.attr="disabled" class="disabled:opacity-50 disabled:cursor-wait inline-flex justify-center items-center px-6 py-3 bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/50 text-emerald-400 text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-[0_0_15px_rgba(16,185,129,0.2)] hover:shadow-[0_0_25px_rgba(16,185,129,0.4)] hover:scale-105">
                        <svg wire:loading.remove wire:target="markAsApplied" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <svg wire:loading wire:target="markAsApplied" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        Mark Applied
                    </button>
                    @endif

                    <button wire:click="openScheduleModal" wire:loading.attr="disabled" class="disabled:opacity-50 disabled:cursor-wait inline-flex justify-center items-center px-6 py-3 bg-neon-cyan/20 hover:bg-neon-cyan/30 border border-neon-cyan/50 text-neon-cyan text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-[0_0_15px_rgba(34,211,238,0.2)] hover:shadow-[0_0_25px_rgba(34,211,238,0.4)] hover:scale-105">
                        <svg wire:loading.remove wire:target="openScheduleModal" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <svg wire:loading wire:target="openScheduleModal" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Schedule Intv
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Job Description Section -->
                <div class="bg-slate-900/60 backdrop-blur-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] border border-white/10 p-6 md:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-black uppercase tracking-widest text-brand-400 flex items-center">
                            <div class="p-1.5 bg-brand-500/20 text-brand-300 rounded-lg mr-3 shadow-[0_0_10px_rgba(139,92,246,0.3)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                            </div>
                            Job Description
                        </h3>
                        <div class="flex items-center space-x-2">
                            <button wire:click="manualFetchDescription" wire:loading.attr="disabled" class="disabled:opacity-50 inline-flex items-center px-4 py-2 bg-brand-500/20 border border-brand-500/30 text-brand-300 hover:bg-brand-500/30 hover:border-brand-500/50 text-[10px] uppercase tracking-widest font-black rounded-xl transition-all shadow-[0_0_10px_rgba(139,92,246,0.2)]">
                                <svg wire:loading.remove wire:target="manualFetchDescription" class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                <svg wire:loading wire:target="manualFetchDescription" class="animate-spin w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Fetch
                            </button>
                            <button wire:click="editDescription" class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/10 text-slate-300 hover:bg-white/10 hover:border-white/20 hover:text-white text-[10px] uppercase tracking-widest font-black rounded-xl transition-all shadow-[0_0_10px_rgba(255,255,255,0.05)]">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </button>
                        </div>
                    </div>

                    @if($isEditingDescription)
                        <div class="mt-4">
                            <textarea wire:model="editDescriptionText" rows="12" class="w-full rounded-xl bg-slate-800/50 border border-white/10 text-slate-300 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm font-mono"></textarea>
                            <div class="mt-4 flex justify-end space-x-3">
                                <button wire:click="$set('isEditingDescription', false)" class="px-5 py-2 bg-white/5 border border-white/10 text-white font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-white/10 transition-colors">Cancel</button>
                                <button wire:click="saveDescription" class="px-5 py-2 bg-brand-500 border border-brand-400 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-[0_0_15px_rgba(139,92,246,0.4)] hover:bg-brand-400 transition-colors">Save</button>
                            </div>
                        </div>
                    @else
                        @if($job->description || $job->job_description)
                            <div class="prose prose-invert prose-slate prose-sm sm:prose-base max-w-none text-slate-300 font-medium">
                                {!! nl2br(e($job->description ?? $job->job_description)) !!}
                            </div>
                        @else
                            <div class="text-center py-10 text-slate-500">
                                <p class="mb-3 text-sm font-bold">Detailed description not available.</p>
                                <button wire:click="manualFetchDescription" class="text-neon-cyan text-sm font-black uppercase tracking-widest hover:text-white transition-colors underline decoration-neon-cyan/50 underline-offset-4">Fetch from URL</button>
                            </div>
                        @endif
                    @endif
                </div>

                @if($job->responsibilities || $job->skills_required || $job->qualifications)
                <!-- Requirements Section -->
                <div class="bg-slate-900/60 backdrop-blur-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] border border-white/10 p-6 md:p-8 space-y-10">
                    @if($job->responsibilities)
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-emerald-400 mb-5 flex items-center">
                            <div class="p-1.5 bg-emerald-500/20 text-emerald-300 rounded-lg mr-3 shadow-[0_0_10px_rgba(16,185,129,0.3)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            Responsibilities
                        </h3>
                        <div class="prose prose-invert prose-slate prose-sm sm:prose-base max-w-none text-slate-300 font-medium">
                            {!! nl2br(e($job->responsibilities)) !!}
                        </div>
                    </div>
                    @endif

                    @if($job->skills_required)
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-amber-400 mb-5 flex items-center">
                            <div class="p-1.5 bg-amber-500/20 text-amber-300 rounded-lg mr-3 shadow-[0_0_10px_rgba(245,158,11,0.3)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            Required Skills
                        </h3>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach(explode(',', $job->skills_required) as $skill)
                                <span class="px-4 py-1.5 bg-white/5 text-slate-300 text-xs font-bold rounded-xl border border-white/10 shadow-[0_0_10px_rgba(255,255,255,0.05)] hover:bg-white/10 transition-colors">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($job->qualifications || $job->experience_required)
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-rose-400 mb-5 flex items-center">
                            <div class="p-1.5 bg-rose-500/20 text-rose-300 rounded-lg mr-3 shadow-[0_0_10px_rgba(244,63,94,0.3)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            </div>
                            Qualifications & Experience
                        </h3>
                        @if($job->experience_required)
                            <p class="text-slate-300 font-bold mb-3">Experience: <span class="text-white bg-white/10 px-2 py-0.5 rounded border border-white/20">{{ $job->experience_required }}</span></p>
                        @endif
                        @if($job->qualifications)
                            <div class="prose prose-invert prose-slate prose-sm max-w-none text-slate-300 font-medium">
                                {!! nl2br(e($job->qualifications)) !!}
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Meta Data Card -->
                <div class="bg-slate-900/60 backdrop-blur-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] border border-white/10 p-6 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-6 relative z-10">Job Info</h3>
                    <ul class="space-y-5 relative z-10">
                        <li class="flex items-center gap-4">
                            <div class="p-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-400 shadow-inner">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-0.5">Source</p>
                                <p class="text-sm text-white font-black">{{ $job->application_source->value ?? 'Unknown' }}</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="p-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-400 shadow-inner">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-0.5">Discovered</p>
                                <p class="text-sm text-white font-black">{{ $job->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </li>
                        @if($job->posted_at)
                        <li class="flex items-center gap-4">
                            <div class="p-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-400 shadow-inner">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-0.5">Posted</p>
                                <p class="text-sm text-white font-black">{{ $job->posted_at->format('M d, Y') }}</p>
                            </div>
                        </li>
                        @endif
                        @if($job->application_deadline)
                        <li class="flex items-center gap-4">
                            <div class="p-2.5 bg-neon-pink/10 border border-neon-pink/20 rounded-xl text-neon-pink shadow-[0_0_10px_rgba(244,114,182,0.2)]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-neon-pink/70 font-bold mb-0.5">Deadline</p>
                                <p class="text-sm text-neon-pink font-black">{{ $job->application_deadline->format('M d, Y') }}</p>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>

                <!-- AI Analysis Card -->
                <div class="relative bg-slate-900 rounded-[2rem] p-[1px] overflow-hidden group shadow-[0_10px_40px_rgba(0,0,0,0.5)]">
                    <!-- Animated gradient border -->
                    <div class="absolute inset-0 bg-gradient-to-br from-neon-cyan via-brand-500 to-neon-pink opacity-50 group-hover:opacity-100 transition-opacity duration-700 blur-sm"></div>
                    <div class="absolute inset-[-100%] bg-gradient-to-r from-transparent via-white/40 to-transparent animate-[spin_3s_linear_infinite] group-hover:opacity-100 opacity-0 transition-opacity"></div>
                    
                    <div class="relative bg-slate-900/95 backdrop-blur-3xl rounded-[2rem] h-full p-6 text-slate-100">
                        <h3 class="text-[11px] font-black uppercase tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-neon-cyan to-brand-400 mb-6 flex items-center gap-3">
                            <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-neon-cyan opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-neon-cyan shadow-[0_0_10px_rgba(34,211,238,0.8)]"></span>
                            </span>
                            AI Insights Hub
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Cover Letter -->
                            <button wire:click="openCoverLetterModal" class="relative overflow-hidden w-full flex items-center justify-between p-4 bg-white/5 hover:bg-emerald-500/10 rounded-2xl border border-white/10 hover:border-emerald-500/30 transition-all duration-300 text-left group/btn hover:-translate-y-1 shadow-[0_0_15px_rgba(0,0,0,0.2)] hover:shadow-[0_0_20px_rgba(16,185,129,0.2)]">
                                <div class="flex items-center">
                                    <div class="p-2.5 bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 rounded-xl mr-4 group-hover/btn:bg-emerald-500 group-hover/btn:text-white group-hover/btn:border-emerald-400 transition-all duration-300 shadow-inner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-white mb-0.5 tracking-wide">Cover Letter</div>
                                        <div class="text-[10px] font-bold uppercase tracking-wider {{ $job->cover_letter ? 'text-emerald-400' : 'text-slate-500' }}">
                                            @if($job->cover_letter)
                                                ✓ Ready to view
                                            @else
                                                Generate AI tailored
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-slate-500 group-hover/btn:text-emerald-400 transform group-hover/btn:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                            
                            <!-- Resume Match -->
                            <button wire:click="openResumeMatchModal" class="relative overflow-hidden w-full flex items-center justify-between p-4 bg-white/5 hover:bg-brand-500/10 rounded-2xl border border-white/10 hover:border-brand-500/30 transition-all duration-300 text-left group/btn hover:-translate-y-1 shadow-[0_0_15px_rgba(0,0,0,0.2)] hover:shadow-[0_0_20px_rgba(139,92,246,0.2)]">
                                <div class="flex items-center">
                                    <div class="p-2.5 bg-brand-500/20 border border-brand-500/30 text-brand-400 rounded-xl mr-4 group-hover/btn:bg-brand-500 group-hover/btn:text-white group-hover/btn:border-brand-400 transition-all duration-300 shadow-inner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-white mb-0.5 tracking-wide">Resume Match</div>
                                        <div class="text-[10px] font-bold uppercase tracking-wider {{ $job->resume_feedback ? 'text-brand-400' : 'text-slate-500' }}">
                                            @if($job->resume_feedback)
                                                ✓ Analysis ready
                                            @else
                                                ATS compatibility
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-slate-500 group-hover/btn:text-brand-400 transform group-hover/btn:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>

                            <!-- Interview Prep -->
                            <button wire:click="openInterviewPrepModal" class="relative overflow-hidden w-full flex items-center justify-between p-4 bg-white/5 hover:bg-neon-pink/10 rounded-2xl border border-white/10 hover:border-neon-pink/30 transition-all duration-300 text-left group/btn hover:-translate-y-1 shadow-[0_0_15px_rgba(0,0,0,0.2)] hover:shadow-[0_0_20px_rgba(244,114,182,0.2)]">
                                <div class="flex items-center">
                                    <div class="p-2.5 bg-neon-pink/20 border border-neon-pink/30 text-neon-pink rounded-xl mr-4 group-hover/btn:bg-neon-pink group-hover/btn:text-white group-hover/btn:border-neon-pink transition-all duration-300 shadow-inner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-white mb-0.5 tracking-wide">Interview Prep</div>
                                        <div class="text-[10px] font-bold uppercase tracking-wider {{ $job->interview_prep_notes ? 'text-neon-pink' : 'text-slate-500' }}">
                                            @if($job->interview_prep_notes)
                                                ✓ Notes ready
                                            @else
                                                Questions & tips
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-slate-500 group-hover/btn:text-neon-pink transform group-hover/btn:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Events Timeline -->
                @if($job->events->count() > 0)
                <div class="bg-slate-900/60 backdrop-blur-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] border border-white/10 p-6">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-6">Timeline</h3>
                    <div class="relative border-l-2 border-slate-700 ml-3 space-y-8">
                        @foreach($job->events->sortByDesc('created_at') as $event)
                            <div class="relative pl-6 group">
                                <span class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-slate-900 border-2 border-neon-cyan shadow-[0_0_10px_rgba(34,211,238,0.5)] group-hover:scale-125 transition-transform"></span>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">{{ $event->created_at->format('M d, Y g:i A') }}</p>
                                <p class="text-sm font-black text-slate-200">{{ $event->message }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Cover Letter Modal -->
    <x-modal name="cover-letter-modal" focusable>
        <div class="p-8 max-h-[85vh] overflow-y-auto text-slate-200 bg-slate-900">
            <h2 class="text-2xl font-black text-white tracking-wide mb-6 flex items-center">
                <div class="p-2 bg-emerald-500/20 text-emerald-400 rounded-xl mr-4 border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.3)]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                AI Cover Letter
            </h2>
            
            <div class="mt-4">
                <div wire:loading wire:target="generateCoverLetter" class="w-full h-40 flex flex-col items-center justify-center">
                    <svg class="animate-spin h-10 w-10 text-emerald-500 mb-4 drop-shadow-[0_0_10px_rgba(16,185,129,0.5)]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-xs font-black uppercase tracking-widest text-emerald-400 animate-pulse">
                        @if($isFetchingDetails) Fetching details... @else Generating... @endif
                    </span>
                </div>
                
                <div wire:loading.remove wire:target="generateCoverLetter">
                    @if(!$generatedCoverLetter)
                        <div class="bg-white/5 p-8 rounded-2xl border border-white/10 flex flex-col items-center justify-center text-center shadow-inner">
                            <p class="text-sm text-slate-400 font-bold mb-6">Analyze profile and job description to generate a highly tailored cover letter.</p>
                            <button wire:click="generateCoverLetter" class="bg-emerald-500 text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest text-xs shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:shadow-[0_0_30px_rgba(16,185,129,0.6)] hover:scale-105 hover:bg-emerald-400 transition-all">
                                Generate Letter
                            </button>
                        </div>
                    @else
                        <div class="bg-slate-900 p-6 rounded-2xl border border-emerald-500/30 text-sm text-slate-300 whitespace-pre-wrap font-mono shadow-[inset_0_0_20px_rgba(0,0,0,0.5)] leading-relaxed">{{ $generatedCoverLetter }}</div>
                        @if(str_contains($generatedCoverLetter, 'Error generating'))
                            <div class="mt-4 bg-rose-500/20 border border-rose-500/50 text-rose-300 p-4 rounded-xl text-xs font-bold tracking-wide">
                                Note: Check your Gemini API key in the .env file.
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                @if($generatedCoverLetter)
                <button wire:click="generateCoverLetter" class="bg-emerald-500/20 border border-emerald-500/50 px-5 py-2.5 text-xs font-black uppercase tracking-widest text-emerald-400 hover:bg-emerald-500/30 rounded-xl transition-colors shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                    Regenerate
                </button>
                @endif
                <button x-on:click="$dispatch('close')" class="bg-white/5 px-5 py-2.5 text-xs font-black uppercase tracking-widest text-slate-300 hover:bg-white/10 border border-white/10 rounded-xl transition-colors">
                    Close
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Resume Feedback Modal -->
    <x-modal name="resume-feedback-modal" focusable>
        <div class="p-8 max-h-[85vh] overflow-y-auto text-slate-200 bg-slate-900">
            <h2 class="text-2xl font-black text-white tracking-wide mb-6 flex items-center">
                <div class="p-2 bg-brand-500/20 text-brand-400 rounded-xl mr-4 border border-brand-500/30 shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                Resume Match Analysis
            </h2>
            
            <div class="mt-4">
                <div wire:loading wire:target="analyzeMatch" class="w-full h-40 flex flex-col items-center justify-center">
                    <svg class="animate-spin h-10 w-10 text-brand-500 mb-4 drop-shadow-[0_0_10px_rgba(139,92,246,0.5)]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-xs font-black uppercase tracking-widest text-brand-400 animate-pulse">
                        @if($isFetchingDetails) Fetching details... @else Analyzing... @endif
                    </span>
                </div>
                
                <div wire:loading.remove wire:target="analyzeMatch">
                    @if(!$generatedFeedback)
                        <div class="bg-white/5 p-8 rounded-2xl border border-white/10 flex flex-col items-center justify-center text-center shadow-inner">
                            <p class="text-sm text-slate-400 font-bold mb-6">Scan your resume against this job description to get an ATS compatibility score.</p>
                            <button wire:click="analyzeMatch" class="bg-brand-500 text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest text-xs shadow-[0_0_20px_rgba(139,92,246,0.4)] hover:shadow-[0_0_30px_rgba(139,92,246,0.6)] hover:scale-105 hover:bg-brand-400 transition-all">
                                Analyze Match
                            </button>
                        </div>
                    @else
                        <div class="bg-slate-900 p-6 rounded-2xl border border-brand-500/30 text-sm text-slate-300 font-sans prose prose-invert prose-brand max-w-none shadow-[inset_0_0_20px_rgba(0,0,0,0.5)] leading-relaxed">{!! Str::markdown($generatedFeedback) !!}</div>
                    @endif
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                @if($generatedFeedback)
                <button wire:click="analyzeMatch" class="bg-brand-500/20 border border-brand-500/50 px-5 py-2.5 text-xs font-black uppercase tracking-widest text-brand-400 hover:bg-brand-500/30 rounded-xl transition-colors shadow-[0_0_15px_rgba(139,92,246,0.2)]">
                    Regenerate
                </button>
                @endif
                <button x-on:click="$dispatch('close')" class="bg-white/5 px-5 py-2.5 text-xs font-black uppercase tracking-widest text-slate-300 hover:bg-white/10 border border-white/10 rounded-xl transition-colors">
                    Close
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Interview Prep Modal -->
    <x-modal name="interview-prep-modal" focusable>
        <div class="p-8 max-h-[85vh] overflow-y-auto text-slate-200 bg-slate-900">
            <h2 class="text-2xl font-black text-white tracking-wide mb-6 flex items-center">
                <div class="p-2 bg-neon-pink/20 text-neon-pink rounded-xl mr-4 border border-neon-pink/30 shadow-[0_0_15px_rgba(244,114,182,0.3)]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                Interview Preparation
            </h2>
            
            <div class="mt-4 max-h-[60vh] overflow-y-auto pr-2">
                <div wire:loading wire:target="generateInterviewPrep" class="w-full h-40 flex flex-col items-center justify-center">
                    <svg class="animate-spin h-10 w-10 text-neon-pink mb-4 drop-shadow-[0_0_10px_rgba(244,114,182,0.5)]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-xs font-black uppercase tracking-widest text-neon-pink animate-pulse">
                        @if($isFetchingDetails) Fetching details... @else Preparing... @endif
                    </span>
                </div>
                
                <div wire:loading.remove wire:target="generateInterviewPrep">
                    @if(!isset($generatedInterviewPrep) || !$generatedInterviewPrep)
                        <div class="bg-white/5 p-8 rounded-2xl border border-white/10 flex flex-col items-center justify-center text-center shadow-inner">
                            <p class="text-sm text-slate-400 font-bold mb-6">Generate likely interview questions and behavioral prep based on this role.</p>
                            <button wire:click="generateInterviewPrep" class="bg-neon-pink text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest text-xs shadow-[0_0_20px_rgba(244,114,182,0.4)] hover:shadow-[0_0_30px_rgba(244,114,182,0.6)] hover:scale-105 hover:bg-pink-400 transition-all">
                                Generate Prep Notes
                            </button>
                        </div>
                    @else
                        <div class="bg-slate-900 p-6 rounded-2xl border border-neon-pink/30 text-sm text-slate-300 font-sans prose prose-invert prose-pink max-w-none shadow-[inset_0_0_20px_rgba(0,0,0,0.5)] leading-relaxed">{!! Str::markdown($generatedInterviewPrep) !!}</div>
                    @endif
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                @if($generatedInterviewPrep)
                <button wire:click="generateInterviewPrep" class="bg-neon-pink/20 border border-neon-pink/50 px-5 py-2.5 text-xs font-black uppercase tracking-widest text-neon-pink hover:bg-neon-pink/30 rounded-xl transition-colors shadow-[0_0_15px_rgba(244,114,182,0.2)]">
                    Regenerate
                </button>
                @endif
                <button x-on:click="$dispatch('close')" class="bg-white/5 px-5 py-2.5 text-xs font-black uppercase tracking-widest text-slate-300 hover:bg-white/10 border border-white/10 rounded-xl transition-colors">
                    Close
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Schedule Interview Modal -->
    <x-modal name="schedule-interview-modal" focusable>
        <form wire:submit.prevent="saveScheduledInterview" class="p-8 bg-slate-900 text-slate-200">
            <h2 class="text-2xl font-black text-white tracking-wide mb-2 flex items-center">
                <div class="p-2 bg-neon-cyan/20 text-neon-cyan rounded-xl mr-4 border border-neon-cyan/30 shadow-[0_0_15px_rgba(34,211,238,0.3)]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                Schedule & Alert
            </h2>
            <p class="text-xs font-bold text-slate-400 mb-8 ml-14">Configure alerts for Slack and WhatsApp.</p>
            
            <div class="space-y-5">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Date & Time</label>
                    <input type="datetime-local" wire:model="interview_scheduled_at" required class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan shadow-inner">
                    @error('interview_scheduled_at') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Round</label>
                    <select wire:model="interview_round" required class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan shadow-inner">
                        <option value="Round 1" class="bg-slate-800">Round 1</option>
                        <option value="Round 2" class="bg-slate-800">Round 2</option>
                        <option value="Round 3" class="bg-slate-800">Round 3</option>
                        <option value="Final Round" class="bg-slate-800">Final Round</option>
                        <option value="Other" class="bg-slate-800">Other</option>
                    </select>
                    @error('interview_round') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Format</label>
                    <select wire:model="interview_type" required class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan shadow-inner">
                        <option value="HR Phone Screen" class="bg-slate-800">HR Phone Screen</option>
                        <option value="Technical Interview" class="bg-slate-800">Technical Interview</option>
                        <option value="System Design" class="bg-slate-800">System Design</option>
                        <option value="Managerial / Behavioral" class="bg-slate-800">Managerial / Behavioral</option>
                        <option value="Take-home Assessment" class="bg-slate-800">Take-home Assessment</option>
                    </select>
                    @error('interview_type') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Meeting Link</label>
                    <input type="url" wire:model="interview_meeting_link" placeholder="https://meet.google.com/..." class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white placeholder-slate-600 focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan shadow-inner">
                    @error('interview_meeting_link') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Notes</label>
                    <textarea wire:model="interview_notes" rows="3" placeholder="Topics to review..." class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white placeholder-slate-600 focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan shadow-inner"></textarea>
                    @error('interview_notes') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <button type="button" x-on:click="$dispatch('close')" class="bg-white/5 px-5 py-2.5 text-xs font-black uppercase tracking-widest text-slate-300 hover:bg-white/10 border border-white/10 rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" wire:loading.attr="disabled" class="bg-neon-cyan text-slate-900 px-6 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl shadow-[0_0_20px_rgba(34,211,238,0.4)] hover:shadow-[0_0_30px_rgba(34,211,238,0.6)] hover:bg-cyan-400 transition-all flex items-center">
                    <span wire:loading.remove wire:target="saveScheduledInterview">Save & Alert</span>
                    <span wire:loading wire:target="saveScheduledInterview">Dispatching...</span>
                </button>
            </div>
        </form>
    </x-modal>
</div>
