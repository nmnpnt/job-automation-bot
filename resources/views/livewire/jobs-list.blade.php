<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-white/60 backdrop-blur-xl p-6 rounded-3xl border border-slate-200/60 shadow-sm relative overflow-hidden transition-colors duration-500">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/20 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-purple-500/10 rounded-full blur-[60px] transform -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-extrabold leading-9 text-slate-900 tracking-tight">
                All Jobs Discovered
            </h2>
            <p class="mt-1 text-sm text-slate-500 font-medium">A complete list of jobs gathered across all configured portals.</p>
        </div>
        
        <div class="mt-6 md:mt-0 md:ml-4 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4 relative z-10">
            <button wire:click="exportCSV" wire:loading.attr="disabled" class="w-full md:w-auto flex items-center justify-center space-x-2 bg-white/80 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-sm border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-white:bg-slate-600 hover:text-indigo-600:text-indigo-400 transition-colors disabled:opacity-50 disabled:cursor-wait">
                <svg wire:loading.remove wire:target="exportCSV" class="w-5 h-5 text-slate-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <svg wire:loading wire:target="exportCSV" class="animate-spin w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span>Export CSV</span>
            </button>
            <div class="flex items-center space-x-3 bg-white/80 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-sm border border-slate-200 w-full md:w-auto">
                <svg wire:loading.remove wire:target="filterSource" class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <svg wire:loading wire:target="filterSource" class="animate-spin w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                
                <select wire:model.live="filterSource" id="filterSource" class="bg-transparent border-0 focus:ring-0 text-sm font-semibold text-slate-700 py-0 pl-1 pr-8 cursor-pointer appearance-none w-full md:w-auto">
                    <option value="" class="">All Portals</option>
                    @foreach($sources as $source)
                        <option value="{{ $source->value }}" class="">{{ str_replace('_', ' ', $source->name) }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            <div class="flex items-center space-x-3 bg-white/80 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-sm border border-slate-200 w-full md:w-auto">
                <svg wire:loading.remove wire:target="filterStatus" class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                <svg wire:loading wire:target="filterStatus" class="animate-spin w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                
                <select wire:model.live="filterStatus" id="filterStatus" class="bg-transparent border-0 focus:ring-0 text-sm font-semibold text-slate-700 py-0 pl-1 pr-8 cursor-pointer appearance-none w-full md:w-auto">
                    <option value="" class="">All Statuses</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" class="">{{ str_replace('_', ' ', $status->name) }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-sm overflow-hidden transition-colors duration-500">
        <div class="overflow-x-auto relative">
            <div wire:loading.class="absolute inset-0 bg-slate-50/50 z-10 flex items-center justify-center backdrop-blur-[1px]" wire:target="filterSource, gotoPage, previousPage, nextPage" class="hidden">
                <div class="w-12 h-12 rounded-full border-4 border-indigo-500 border-t-transparent animate-spin"></div>
            </div>
            
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50/50 backdrop-blur-sm transition-colors duration-500">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Job Title</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Company</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Portal</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Discovered</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-transparent transition-colors duration-500">
                    @forelse ($jobs as $job)
                        <tr class="{{ $job->is_read ? 'bg-transparent' : 'bg-indigo-50/40 border-l-4 border-indigo-500' }} hover:bg-indigo-50/30:bg-slate-700/30 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('jobs.show', $job->id) }}" wire:navigate class="block">
                                    <div class="flex items-center gap-2">
                                        @if(!$job->is_read)
                                            <span class="flex w-2 h-2 rounded-full bg-indigo-600"></span>
                                        @endif
                                        <div class="text-sm font-bold {{ $job->is_read ? 'text-slate-700' : 'text-slate-900' }} group-hover:text-indigo-600:text-indigo-400 transition-colors">{{ Str::limit($job->job_title, 40) }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-slate-100 text-slate-500 rounded-lg flex items-center justify-center mr-3 font-bold text-xs shadow-sm">
                                        {{ substr($job->company_name, 0, 1) }}
                                    </div>
                                    <div class="text-sm font-semibold text-slate-600">{{ Str::limit($job->company_name, 30) }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-slate-100 text-slate-700">
                                    {{ $job->application_source->value }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColor = match($job->status->value) {
                                        'DISCOVERED' => 'bg-slate-100 text-slate-700 border-slate-200',
                                        'APPLIED' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'PENDING_REVIEW' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'INTERVIEW_REQUESTED' => 'bg-violet-50 text-violet-700 border-violet-200',
                                        'REJECTED' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        default => 'bg-indigo-50 text-indigo-700 border-indigo-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusColor }}">
                                    {{ str_replace('_', ' ', $job->status->name) }}
                                </span>
                                @if(in_array($job->status->value, ['DISCOVERED', 'PENDING_REVIEW', 'READY_TO_APPLY']))
                                <div class="mt-1.5 flex items-center text-[10px] text-indigo-500 font-semibold" title="This job is ready to be processed by the Auto-Apply Bot">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Bot Ready
                                </div>
                                @elseif(in_array($job->status->value, ['FAILED']))
                                <div class="mt-1.5 flex items-center text-[10px] text-rose-500 font-semibold" title="{{ $job->failure_reason ?? 'The bot attempted to apply but failed.' }}">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Bot Failed
                                </div>
                                @elseif(in_array($job->status->value, ['EXTERNAL_APPLICATION', 'COMPANY_WEBSITE', 'MANUAL_REQUIRED']))
                                <div class="mt-1.5 flex items-center text-[10px] text-amber-500 font-semibold" title="This job redirects externally and requires manual application.">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Manual Apply Required
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-500">
                                {{ $job->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-1.5">
                                    <!-- Apply on Portal (External Link) -->
                                    <a href="{{ $job->original_job_url }}" target="_blank" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100:bg-indigo-500/20 font-bold text-xs transition-colors shadow-sm border border-transparent" title="Apply directly on portal">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Apply
                                    </a>

                                    <!-- Mark as Applied (Toggle) -->
                                    @if(in_array($job->status->value, ['DISCOVERED', 'MATCHED', 'READY_TO_APPLY']))
                                    <button wire:click="markAsApplied({{ $job->id }})" wire:loading.attr="disabled" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center px-2.5 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100:bg-emerald-500/20 font-bold text-xs transition-colors shadow-sm border border-transparent" title="Mark as Applied">
                                        <svg wire:loading.remove wire:target="markAsApplied({{ $job->id }})" class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <svg wire:loading wire:target="markAsApplied({{ $job->id }})" class="animate-spin w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        Mark Applied
                                    </button>
                                    @elseif(in_array($job->status->value, ['APPLIED', 'PENDING_REVIEW', 'INTERVIEW_REQUESTED', 'OFFER_RECEIVED', 'HIRED']))
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-emerald-100 text-emerald-800 text-xs font-bold border border-transparent" title="Application has been submitted">
                                        ✓ Applied
                                    </span>
                                    @endif

                                    <!-- Schedule Interview Button -->
                                    <button wire:click="openScheduleModal({{ $job->id }})" wire:loading.attr="disabled" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center px-2.5 py-1.5 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-100:bg-purple-500/20 font-bold text-xs transition-colors shadow-sm border border-transparent" title="Schedule Interview & Send Notifications">
                                        <svg wire:loading.remove wire:target="openScheduleModal({{ $job->id }})" class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <svg wire:loading wire:target="openScheduleModal({{ $job->id }})" class="animate-spin w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Interview
                                    </button>

                                    <!-- Action Dots (AI Tools) -->
                                    <div class="relative ml-2" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-50 text-slate-500 hover:bg-slate-100:bg-slate-600 transition-colors shadow-sm">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                        </button>
                                        <div x-show="open" x-cloak class="absolute right-0 mt-2 w-48 rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 z-50 overflow-hidden divide-y divide-slate-100">
                                            <!-- AI Cover Letter -->
                                            <button wire:click="generateCoverLetter({{ $job->id }})" wire:loading.attr="disabled" class="w-full text-left px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50:bg-slate-700 hover:text-indigo-600:text-indigo-400 flex items-center transition-colors">
                                                <svg wire:loading.remove wire:target="generateCoverLetter({{ $job->id }})" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                                <svg wire:loading wire:target="generateCoverLetter({{ $job->id }})" class="animate-spin w-4 h-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                                AI Cover Letter
                                            </button>

                                            <!-- AI Resume Match -->
                                            <button wire:click="analyzeMatch({{ $job->id }})" wire:loading.attr="disabled" class="w-full text-left px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50:bg-slate-700 hover:text-indigo-600:text-indigo-400 flex items-center transition-colors">
                                                <svg wire:loading.remove wire:target="analyzeMatch({{ $job->id }})" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                                <svg wire:loading wire:target="analyzeMatch({{ $job->id }})" class="animate-spin w-4 h-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                                Resume Match
                                            </button>

                                            <!-- AI Interview Prep -->
                                            <button wire:click="generateInterviewPrep({{ $job->id }})" wire:loading.attr="disabled" class="w-full text-left px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50:bg-slate-700 hover:text-indigo-600:text-indigo-400 flex items-center transition-colors">
                                                <svg wire:loading.remove wire:target="generateInterviewPrep({{ $job->id }})" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                <svg wire:loading wire:target="generateInterviewPrep({{ $job->id }})" class="animate-spin w-4 h-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                Interview Prep
                                            </button>

                                            <!-- Delete Job -->
                                            <button x-data @click="$dispatch('ask-confirm', { message: 'Are you sure you want to completely remove this job from your lists? This action cannot be undone.', onConfirm: () => $wire.deleteJob({{ $job->id }}) })" class="w-full text-left px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50:bg-rose-500/10 flex items-center transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Remove Job
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-900">No jobs discovered yet</h3>
                                    <p class="mt-1 text-sm text-slate-500">Jobs will appear here once the scraper finishes running.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($jobs->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
            {{ $jobs->links() }}
        </div>
        @endif
    </div>

    <!-- Cover Letter Modal -->
    <x-modal name="cover-letter-modal" focusable>
        <div class="p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                AI Generated Cover Letter
            </h2>
            
            <div class="mt-4">
                <div wire:loading wire:target="generateCoverLetter" class="w-full h-32 flex items-center justify-center">
                    <svg class="animate-spin h-8 w-8 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                
                @if($generatedCoverLetter)
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-sm text-slate-700 whitespace-pre-wrap font-mono">{{ $generatedCoverLetter }}</div>
                @endif
            </div>

            <div class="mt-6 flex justify-end">
                <button x-on:click="$dispatch('close')" class="bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 border border-slate-300 rounded-lg shadow-sm transition-colors">
                    Close
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Resume Feedback Modal -->
    <x-modal name="resume-feedback-modal" focusable>
        <div class="p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                AI Resume Analysis
            </h2>
            
            <div class="mt-4">
                <div wire:loading wire:target="analyzeMatch" class="w-full h-32 flex items-center justify-center">
                    <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                
                @if($generatedFeedback)
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-sm text-slate-700 whitespace-pre-wrap font-sans prose prose-slate max-w-none">{!! Str::markdown($generatedFeedback) !!}</div>
                @endif
            </div>

            <div class="mt-6 flex justify-end">
                <button x-on:click="$dispatch('close')" class="bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 border border-slate-300 rounded-lg shadow-sm transition-colors">
                    Close
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Interview Prep Modal -->
    <x-modal name="interview-prep-modal" focusable>
        <div class="p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-violet-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                AI Interview Prep
            </h2>
            
            <div class="mt-4 max-h-[60vh] overflow-y-auto">
                <div wire:loading wire:target="generateInterviewPrep" class="w-full h-32 flex items-center justify-center">
                    <svg class="animate-spin h-8 w-8 text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                
                @if(isset($generatedInterviewPrep) && $generatedInterviewPrep)
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-sm text-slate-700 whitespace-pre-wrap font-sans prose prose-slate max-w-none">{!! Str::markdown($generatedInterviewPrep) !!}</div>
                @endif
            </div>

            <div class="mt-6 flex justify-end">
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
