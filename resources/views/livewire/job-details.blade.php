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
                    <a href="{{ $job->original_job_url }}" target="_blank" class="inline-flex justify-center items-center px-6 py-3 bg-slate-900 hover:bg-indigo-600 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-indigo-500/20">
                        View Original Posting
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Job Description Section -->
                <div class="bg-white/70 backdrop-blur-xl shadow-sm rounded-3xl border border-white/50 p-6 md:p-8">
                    <h3 class="text-lg font-black text-slate-900 mb-4 flex items-center">
                        <div class="p-1.5 bg-indigo-100 text-indigo-600 rounded-lg mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        </div>
                        Job Description
                    </h3>
                    @if($job->description)
                        <div class="prose prose-slate prose-sm sm:prose-base max-w-none">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    @else
                        <div class="text-center py-8 text-slate-500">
                            <p class="mb-2">Detailed description not available.</p>
                        </div>
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
                @if($job->resume_feedback || $job->interview_prep_notes)
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl shadow-lg p-6 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-indigo-100 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        AI Insights
                    </h3>
                    
                    @if($job->resume_feedback)
                        <div class="mb-4">
                            <p class="text-xs font-bold text-indigo-200 uppercase mb-1">Resume Match</p>
                            <div class="text-sm bg-white/10 rounded-xl p-3 line-clamp-3">
                                {!! nl2br(e($job->resume_feedback)) !!}
                            </div>
                        </div>
                    @endif
                    
                    @if($job->interview_prep_notes)
                        <div>
                            <p class="text-xs font-bold text-indigo-200 uppercase mb-1">Interview Prep</p>
                            <div class="text-sm bg-white/10 rounded-xl p-3 line-clamp-3">
                                {!! nl2br(e($job->interview_prep_notes)) !!}
                            </div>
                        </div>
                    @endif
                </div>
                @endif
                
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
</div>
