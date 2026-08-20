<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('jobs.index') }}" wire:navigate class="mr-4 p-2 rounded-xl bg-white shadow-sm border border-slate-200 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    {{ __('Job Details') }}
                </h2>
            </div>
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                    {{ $job->status->value }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header Card -->
        <div class="bg-white/70 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-3xl border border-white/50 p-6 md:p-10 relative group">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-purple-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">{{ $job->job_title }}</h1>
                    <div class="mt-2 text-lg text-slate-600 font-medium flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $job->company_name }}
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3 text-sm font-medium text-slate-500">
                        @if($job->location)
                            <div class="flex items-center gap-1.5 bg-slate-100 px-3 py-1 rounded-lg">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $job->location }}
                            </div>
                        @endif
                        @if($job->salary_info)
                            <div class="flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $job->salary_info }}
                            </div>
                        @endif
                        @if($job->employment_type)
                            <div class="flex items-center gap-1.5 bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $job->employment_type }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col gap-3 shrink-0">
                    <a href="{{ $job->original_job_url }}" target="_blank" class="inline-flex justify-center items-center px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-slate-900/20">
                        View Original Posting
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    
                    @if(in_array($job->status->value, ['DISCOVERED', 'MATCHED', 'READY_TO_APPLY']))
                    <button wire:click="markAsApplied" wire:loading.attr="disabled" class="disabled:opacity-50 disabled:cursor-wait inline-flex justify-center items-center px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-emerald-500/20">
                        <svg wire:loading.remove wire:target="markAsApplied" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <svg wire:loading wire:target="markAsApplied" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        Mark as Applied
                    </button>
                    @endif

                    <button wire:click="openScheduleModal" wire:loading.attr="disabled" class="disabled:opacity-50 disabled:cursor-wait inline-flex justify-center items-center px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-purple-500/20">
                        <svg wire:loading.remove wire:target="openScheduleModal" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <svg wire:loading wire:target="openScheduleModal" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Schedule Interview
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Job Description Section -->
                <div class="bg-white/70 backdrop-blur-xl shadow-sm rounded-3xl border border-white/50 p-6 md:p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-black text-slate-900 flex items-center">
                            <div class="p-1.5 bg-indigo-100 text-indigo-600 rounded-lg mr-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                            </div>
                            Job Description
                        </h3>
                        <div class="flex items-center space-x-2">
                            <button wire:click="manualFetchDescription" wire:loading.attr="disabled" class="disabled:opacity-50 inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 text-sm font-semibold rounded-lg transition-colors">
                                <svg wire:loading.remove wire:target="manualFetchDescription" class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                <svg wire:loading wire:target="manualFetchDescription" class="animate-spin w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Fetch
                            </button>
                            <button wire:click="editDescription" class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 text-sm font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </button>
                        </div>
                    </div>

                    @if($isEditingDescription)
                        <div class="mt-2">
                            <textarea wire:model="editDescriptionText" rows="12" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-mono"></textarea>
                            <div class="mt-3 flex justify-end space-x-3">
                                <button wire:click="$set('isEditingDescription', false)" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-semibold rounded-lg hover:bg-slate-50 transition-colors">Cancel</button>
                                <button wire:click="saveDescription" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">Save Description</button>
                            </div>
                        </div>
                    @else
                        @if($job->description || $job->job_description)
                            <div class="prose prose-slate prose-sm sm:prose-base max-w-none">
                                {!! nl2br(e($job->description ?? $job->job_description)) !!}
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-500">
                                <p class="mb-2">Detailed description not available.</p>
                                <button wire:click="manualFetchDescription" class="text-indigo-600 font-medium hover:underline">Click to fetch from URL</button>
                            </div>
                        @endif
                    @endif
                </div>

                @if($job->responsibilities || $job->skills_required || $job->qualifications)
                <!-- Requirements Section -->
                <div class="bg-white/70 backdrop-blur-xl shadow-sm rounded-3xl border border-white/50 p-6 md:p-8 space-y-8">
                    @if($job->responsibilities)
                    <div>
                        <h3 class="text-lg font-black text-slate-900 mb-4 flex items-center">
                            <div class="p-1.5 bg-emerald-100 text-emerald-600 rounded-lg mr-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            Responsibilities
                        </h3>
                        <div class="prose prose-slate prose-sm sm:prose-base max-w-none text-slate-600">
                            {!! nl2br(e($job->responsibilities)) !!}
                        </div>
                    </div>
                    @endif

                    @if($job->skills_required)
                    <div>
                        <h3 class="text-lg font-black text-slate-900 mb-4 flex items-center">
                            <div class="p-1.5 bg-amber-100 text-amber-600 rounded-lg mr-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            Required Skills
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $job->skills_required) as $skill)
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg border border-slate-200">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($job->qualifications || $job->experience_required)
                    <div>
                        <h3 class="text-lg font-black text-slate-900 mb-4 flex items-center">
                            <div class="p-1.5 bg-rose-100 text-rose-600 rounded-lg mr-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            </div>
                            Qualifications & Experience
                        </h3>
                        @if($job->experience_required)
                            <p class="text-slate-700 font-medium mb-2">Experience: <span class="text-slate-500 font-normal">{{ $job->experience_required }}</span></p>
                        @endif
                        @if($job->qualifications)
                            <div class="prose prose-slate prose-sm max-w-none text-slate-600">
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
                <div class="bg-white/70 backdrop-blur-xl shadow-sm rounded-3xl border border-white/50 p-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4">Job Info</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <div class="p-2 bg-slate-100 rounded-lg text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-semibold">Source Platform</p>
                                <p class="text-sm text-slate-800 font-medium">{{ $job->application_source->value ?? 'Unknown' }}</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="p-2 bg-slate-100 rounded-lg text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-semibold">Discovered On</p>
                                <p class="text-sm text-slate-800 font-medium">{{ $job->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </li>
                        @if($job->posted_at)
                        <li class="flex items-center gap-3">
                            <div class="p-2 bg-slate-100 rounded-lg text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-semibold">Posted Date</p>
                                <p class="text-sm text-slate-800 font-medium">{{ $job->posted_at->format('M d, Y') }}</p>
                            </div>
                        </li>
                        @endif
                        @if($job->application_deadline)
                        <li class="flex items-center gap-3">
                            <div class="p-2 bg-rose-50 rounded-lg text-rose-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-rose-500 font-semibold">Deadline</p>
                                <p class="text-sm text-rose-700 font-bold">{{ $job->application_deadline->format('M d, Y') }}</p>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>

                <!-- AI Analysis Card -->
                <!-- AI Analysis Card -->
                <div class="relative bg-slate-900 rounded-3xl p-[1px] overflow-hidden group shadow-xl">
                    <!-- Animated gradient border -->
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-500 to-emerald-500 opacity-30 group-hover:opacity-100 transition-opacity duration-700 blur-md"></div>
                    <div class="absolute inset-[-100%] bg-gradient-to-r from-transparent via-white/20 to-transparent animate-[spin_4s_linear_infinite] group-hover:opacity-100 opacity-0 transition-opacity"></div>
                    
                    <div class="relative bg-slate-900/90 backdrop-blur-2xl rounded-3xl h-full p-6 text-slate-100">
                        <h3 class="text-sm font-black uppercase tracking-widest text-indigo-400 mb-6 flex items-center gap-3">
                            <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                            </span>
                            AI Insights Hub
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Cover Letter -->
                            <button wire:click="openCoverLetterModal" class="relative overflow-hidden w-full flex items-center justify-between p-4 bg-white/5 hover:bg-emerald-500/10 rounded-2xl border border-white/10 hover:border-emerald-500/30 transition-all duration-300 text-left group/btn hover:-translate-y-1">
                                <div class="flex items-center">
                                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-xl mr-4 group-hover/btn:bg-emerald-500 group-hover/btn:text-white transition-colors duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-white mb-0.5">Cover Letter</div>
                                        <div class="text-xs font-medium {{ $job->cover_letter ? 'text-emerald-400' : 'text-slate-400' }}">
                                            @if($job->cover_letter)
                                                ✓ Ready to view
                                            @else
                                                Generate AI tailored letter
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-slate-500 group-hover/btn:text-emerald-400 transform group-hover/btn:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                            
                            <!-- Resume Match -->
                            <div class="relative overflow-hidden w-full flex flex-col p-4 bg-white/5 hover:bg-purple-500/10 rounded-2xl border border-white/10 hover:border-purple-500/30 transition-all duration-300 group/btn hover:-translate-y-1">
                                <button wire:click="openResumeMatchModal" class="flex items-center justify-between w-full text-left outline-none focus:outline-none">
                                    <div class="flex items-center">
                                        <div class="p-2.5 bg-purple-500/20 text-purple-400 rounded-xl mr-4 group-hover/btn:bg-purple-500 group-hover/btn:text-white transition-colors duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-white mb-0.5">Resume Match</div>
                                            <div class="text-xs font-medium {{ $job->resume_feedback ? 'text-purple-400' : 'text-slate-400' }}">
                                                @if($job->resume_feedback)
                                                    ✓ Analysis ready
                                                @else
                                                    ATS compatibility score
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-500 group-hover/btn:text-purple-400 transform group-hover/btn:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>

                            <!-- Interview Prep -->
                            <div class="relative overflow-hidden w-full flex flex-col p-4 bg-white/5 hover:bg-amber-500/10 rounded-2xl border border-white/10 hover:border-amber-500/30 transition-all duration-300 group/btn hover:-translate-y-1">
                                <button wire:click="openInterviewPrepModal" class="flex items-center justify-between w-full text-left outline-none focus:outline-none">
                                    <div class="flex items-center">
                                        <div class="p-2.5 bg-amber-500/20 text-amber-400 rounded-xl mr-4 group-hover/btn:bg-amber-500 group-hover/btn:text-white transition-colors duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-white mb-0.5">Interview Prep</div>
                                            <div class="text-xs font-medium {{ $job->interview_prep_notes ? 'text-amber-400' : 'text-slate-400' }}">
                                                @if($job->interview_prep_notes)
                                                    ✓ Notes ready to view
                                                @else
                                                    Questions & tips
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-500 group-hover/btn:text-amber-400 transform group-hover/btn:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                
                <!-- Events Timeline -->
                @if($job->events->count() > 0)
                <div class="bg-white/70 backdrop-blur-xl shadow-sm rounded-3xl border border-white/50 p-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4">Application Timeline</h3>
                    <div class="relative border-l border-slate-200 ml-3 space-y-6">
                        @foreach($job->events->sortByDesc('created_at') as $event)
                            <div class="relative pl-6">
                                <span class="absolute -left-[5px] top-1.5 w-2.5 h-2.5 rounded-full bg-indigo-500 ring-4 ring-white"></span>
                                <p class="text-xs font-semibold text-slate-400 mb-1">{{ $event->created_at->format('M d, Y g:i A') }}</p>
                                <p class="text-sm font-medium text-slate-800">{{ $event->message }}</p>
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
        <div class="p-6 max-h-[85vh] overflow-y-auto">
            <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                AI Generated Cover Letter
            </h2>
            
            <div class="mt-4">
                <div wire:loading wire:target="generateCoverLetter" class="w-full h-32 flex flex-col items-center justify-center">
                    <svg class="animate-spin h-8 w-8 text-emerald-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-slate-500">
                        @if($isFetchingDetails) Fetching missing job details... @else Generating Cover Letter... @endif
                    </span>
                </div>
                
                <div wire:loading.remove wire:target="generateCoverLetter">
                    @if(!$generatedCoverLetter)
                        <div class="bg-emerald-50 p-6 rounded-xl border border-emerald-100 flex flex-col items-center justify-center text-center">
                            <p class="text-sm text-emerald-800 mb-4">Click below to generate a tailored cover letter based on your profile and this job description.</p>
                            <button wire:click="generateCoverLetter" class="bg-emerald-500 text-white px-5 py-2 rounded-lg font-bold shadow-sm hover:bg-emerald-600 transition-colors inline-flex items-center">
                                Generate Cover Letter
                            </button>
                        </div>
                    @else
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-sm text-slate-700 whitespace-pre-wrap font-mono">{{ $generatedCoverLetter }}</div>
                        @if(str_contains($generatedCoverLetter, 'Error generating'))
                            <div class="mt-3 bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg text-xs font-semibold">
                                Note: Make sure your Gemini API key is correctly configured in your .env file.
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                @if($generatedCoverLetter)
                <button wire:click="generateCoverLetter" class="bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600 rounded-lg shadow-sm transition-colors inline-flex items-center">
                    Regenerate
                </button>
                @endif
                <button x-on:click="$dispatch('close')" class="bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 border border-slate-300 rounded-lg shadow-sm transition-colors">
                    Close
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Resume Feedback Modal -->
    <x-modal name="resume-feedback-modal" focusable>
        <div class="p-6 max-h-[85vh] overflow-y-auto">
            <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                AI Resume Analysis
            </h2>
            
            <div class="mt-4">
                <div wire:loading wire:target="analyzeMatch" class="w-full h-32 flex flex-col items-center justify-center">
                    <svg class="animate-spin h-8 w-8 text-blue-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-slate-500">
                        @if($isFetchingDetails) Fetching missing job details... @else Analyzing Match... @endif
                    </span>
                </div>
                
                <div wire:loading.remove wire:target="analyzeMatch">
                    @if(!$generatedFeedback)
                        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 flex flex-col items-center justify-center text-center">
                            <p class="text-sm text-blue-800 mb-4">Click below to analyze how well your profile matches this job description.</p>
                            <button wire:click="analyzeMatch" class="bg-blue-500 text-white px-5 py-2 rounded-lg font-bold shadow-sm hover:bg-blue-600 transition-colors">
                                Analyze Resume Match
                            </button>
                        </div>
                    @else
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-sm text-slate-700 whitespace-pre-wrap font-sans prose prose-slate max-w-none">{!! Str::markdown($generatedFeedback) !!}</div>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                @if($generatedFeedback)
                <button wire:click="analyzeMatch" class="bg-blue-500 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600 rounded-lg shadow-sm transition-colors inline-flex items-center">
                    Regenerate
                </button>
                @endif
                <button x-on:click="$dispatch('close')" class="bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 border border-slate-300 rounded-lg shadow-sm transition-colors">
                    Close
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Interview Prep Modal -->
    <x-modal name="interview-prep-modal" focusable>
        <div class="p-6 max-h-[85vh] overflow-y-auto">
            <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-violet-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                AI Interview Prep
            </h2>
            
            <div class="mt-4 max-h-[60vh] overflow-y-auto">
                <div wire:loading wire:target="generateInterviewPrep" class="w-full h-32 flex flex-col items-center justify-center">
                    <svg class="animate-spin h-8 w-8 text-violet-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-slate-500">
                        @if($isFetchingDetails) Fetching missing job details... @else Preparing Interview Materials... @endif
                    </span>
                </div>
                
                <div wire:loading.remove wire:target="generateInterviewPrep">
                    @if(!isset($generatedInterviewPrep) || !$generatedInterviewPrep)
                        <div class="bg-violet-50 p-6 rounded-xl border border-violet-100 flex flex-col items-center justify-center text-center">
                            <p class="text-sm text-violet-800 mb-4">Click below to generate custom interview questions and tips based on this job description.</p>
                            <button wire:click="generateInterviewPrep" class="bg-violet-500 text-white px-5 py-2 rounded-lg font-bold shadow-sm hover:bg-violet-600 transition-colors">
                                Generate Interview Prep
                            </button>
                        </div>
                    @else
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-sm text-slate-700 whitespace-pre-wrap font-sans prose prose-slate max-w-none">{!! Str::markdown($generatedInterviewPrep) !!}</div>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                @if($generatedInterviewPrep)
                <button wire:click="generateInterviewPrep" class="bg-violet-500 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-600 rounded-lg shadow-sm transition-colors inline-flex items-center">
                    Regenerate
                </button>
                @endif
                <button x-on:click="$dispatch('close')" class="bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 border border-slate-300 rounded-lg shadow-sm transition-colors">
                    Close
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Schedule Interview Modal -->
    <x-modal name="schedule-interview-modal" focusable>
        <form wire:submit.prevent="saveScheduledInterview" class="p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-1 flex items-center">
                <div class="p-2 bg-purple-100 text-purple-600 rounded-xl mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                Schedule Interview & Send Alert
            </h2>
            <p class="text-xs text-slate-500 mb-5">Set interview details. We will automatically send a notification to your Slack and WhatsApp channels.</p>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Interview Date & Time</label>
                    <input type="datetime-local" wire:model="interview_scheduled_at" required class="block w-full rounded-xl border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                    @error('interview_scheduled_at') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Interview Round</label>
                    <select wire:model="interview_round" required class="block w-full rounded-xl border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="Round 1">Round 1</option>
                        <option value="Round 2">Round 2</option>
                        <option value="Round 3">Round 3</option>
                        <option value="Final Round">Final Round</option>
                        <option value="Other">Other</option>
                    </select>
                    @error('interview_round') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Interview Format</label>
                    <select wire:model="interview_type" required class="block w-full rounded-xl border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="HR Phone Screen">HR Phone Screen</option>
                        <option value="Technical Interview">Technical Interview</option>
                        <option value="System Design">System Design</option>
                        <option value="Managerial / Behavioral">Managerial / Behavioral</option>
                        <option value="Take-home Assessment">Take-home Assessment</option>
                    </select>
                    @error('interview_type') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Meeting Link (Google Meet / Zoom / Teams)</label>
                    <input type="url" wire:model="interview_meeting_link" placeholder="https://meet.google.com/..." class="block w-full rounded-xl border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                    @error('interview_meeting_link') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Preparation Notes / Instructions</label>
                    <textarea wire:model="interview_notes" rows="3" placeholder="Topics to review, interviewer names, coding focus..." class="block w-full rounded-xl border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                    @error('interview_notes') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" x-on:click="$dispatch('close')" class="bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 border border-slate-300 rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" wire:loading.attr="disabled" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-5 py-2 text-sm font-bold rounded-xl shadow-md hover:from-purple-700 hover:to-indigo-700 transition-all flex items-center">
                    <span wire:loading.remove wire:target="saveScheduledInterview">Save & Dispatch Alerts</span>
                    <span wire:loading wire:target="saveScheduledInterview">Saving...</span>
                </button>
            </div>
        </form>
    </x-modal>
</div>
