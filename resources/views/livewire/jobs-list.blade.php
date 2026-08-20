<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header and Actions -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-50 border border-brand-100 text-brand-600 text-xs font-bold mb-3 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Job Discovery
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">All Jobs Discovered</h2>
            <p class="mt-2 text-sm text-slate-500 font-medium max-w-2xl">Manage, filter, and review all your gathered job opportunities in one place.</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Export Button -->
            <button wire:click="exportCSV" wire:loading.attr="disabled" class="h-11 inline-flex items-center justify-center gap-2 bg-white px-5 rounded-xl text-sm font-bold text-slate-700 border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300 transition-all shadow-sm disabled:opacity-50 group">
                <svg wire:loading.remove wire:target="exportCSV" class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <svg wire:loading wire:target="exportCSV" class="animate-spin w-4 h-4 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span>Export CSV</span>
            </button>
        </div>
    </div>

    <!-- Advanced Filter Bar -->
    <div class="bg-white/90 backdrop-blur-xl p-2 rounded-2xl border border-slate-200/60 shadow-sm flex flex-col xl:flex-row xl:items-center gap-3">
        <!-- Search -->
        <div class="relative flex-grow min-w-0">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by job title, company, or keywords..." class="h-12 bg-transparent border-0 text-slate-800 text-sm font-medium rounded-xl focus:ring-0 block w-full pl-12 pr-4 placeholder:text-slate-400">
            
            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none hidden sm:flex">
                <span class="inline-flex items-center justify-center px-2 py-1 text-[10px] font-bold text-slate-400 bg-slate-100 rounded-md border border-slate-200">⌘K</span>
            </div>
        </div>

        <div class="w-full xl:w-px xl:h-8 bg-slate-200/80 hidden xl:block"></div>
        <div class="w-full h-px bg-slate-200/80 xl:hidden block my-1"></div>

        <!-- Filters Container -->
        <div class="flex flex-col sm:flex-row flex-wrap items-center gap-2 p-1">
            <!-- Sort Filter -->
            <div class="relative w-full sm:w-auto flex group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </div>
                <select wire:model.live="sortField" class="appearance-none h-10 bg-slate-50 border border-slate-200/80 text-slate-700 text-sm font-semibold rounded-l-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:z-10 block w-full sm:w-auto pl-9 pr-8 cursor-pointer hover:bg-white hover:border-slate-300 transition-all">
                    <option value="created_at">Date Added</option>
                    <option value="job_title">Job Title</option>
                    <option value="company_name">Company Name</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                </div>
            </div>
            
            <div class="relative w-full sm:w-auto flex -ml-2 group">
                <select wire:model.live="sortDirection" class="appearance-none h-10 bg-slate-50 border border-slate-200/80 text-slate-700 text-sm font-semibold rounded-r-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:z-10 block w-full sm:w-auto pl-4 pr-8 cursor-pointer hover:bg-white hover:border-slate-300 transition-all">
                    <option value="desc">Desc</option>
                    <option value="asc">Asc</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <!-- Source Filter -->
            <div class="relative w-full sm:w-auto group">
                <select wire:model.live="filterSource" class="appearance-none h-10 bg-slate-50 border border-slate-200/80 text-slate-700 text-sm font-semibold rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 block w-full sm:w-auto pl-4 pr-9 cursor-pointer hover:bg-white hover:border-slate-300 transition-all">
                    <option value="">All Sources</option>
                    @foreach($sources as $source)
                        <option value="{{ $source->value }}">{{ str_replace('_', ' ', $source->name) }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="relative w-full sm:w-auto group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <div class="w-2 h-2 rounded-full bg-slate-300 group-hover:bg-brand-400 transition-colors"></div>
                </div>
                <select wire:model.live="filterStatus" class="appearance-none h-10 bg-slate-50 border border-slate-200/80 text-slate-700 text-sm font-semibold rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 block w-full sm:w-auto pl-8 pr-9 cursor-pointer hover:bg-white hover:border-slate-300 transition-all">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}">{{ str_replace('_', ' ', $status->name) }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters Summary (Optional visual enhancement) -->
    @if($filterSource || $filterStatus || $search)
    <div class="flex flex-wrap items-center gap-2 animate-fade-in">
        <span class="text-xs font-semibold text-slate-500 mr-1">Active Filters:</span>
        
        @if($search)
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white border border-slate-200 text-xs font-bold text-slate-700 shadow-sm">
            Search: <span class="text-brand-600 font-medium">{{ $search }}</span>
            <button wire:click="$set('search', '')" class="text-slate-400 hover:text-rose-500 focus:outline-none"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </span>
        @endif

        @if($filterSource)
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white border border-slate-200 text-xs font-bold text-slate-700 shadow-sm">
            Source: <span class="text-brand-600 font-medium">{{ str_replace('_', ' ', $filterSource) }}</span>
            <button wire:click="$set('filterSource', '')" class="text-slate-400 hover:text-rose-500 focus:outline-none"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </span>
        @endif

        @if($filterStatus)
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white border border-slate-200 text-xs font-bold text-slate-700 shadow-sm">
            Status: <span class="text-brand-600 font-medium">{{ str_replace('_', ' ', $filterStatus) }}</span>
            <button wire:click="$set('filterStatus', '')" class="text-slate-400 hover:text-rose-500 focus:outline-none"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </span>
        @endif
        
        <button wire:click="$set('search', ''); $set('filterSource', ''); $set('filterStatus', '')" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors ml-2 underline decoration-slate-300 underline-offset-2">
            Clear All
        </button>
    </div>
    @endif

    <!-- Table Section -->
    <div class="bg-white/90 backdrop-blur-2xl rounded-[2rem] border border-slate-200/80 shadow-sm overflow-hidden relative transition-colors duration-500 ring-1 ring-slate-900/5">
        
        <div wire:loading.flex wire:target="filterSource, filterStatus, search, sortField, sortDirection, gotoPage, previousPage, nextPage" class="absolute inset-0 bg-white/60 z-20 flex items-center justify-center backdrop-blur-[2px]">
            <div class="w-12 h-12 rounded-full border-4 border-brand-500 border-t-transparent animate-spin shadow-lg"></div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/80 backdrop-blur-md">
                    <tr>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-500 uppercase tracking-widest">Job Details</th>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-500 uppercase tracking-widest hidden md:table-cell">Source</th>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-500 uppercase tracking-widest hidden lg:table-cell">Discovered</th>
                        <th scope="col" class="px-6 py-5 text-right text-[11px] font-black text-slate-500 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-transparent">
                    @forelse ($jobs as $job)
                        <tr class="{{ $job->is_read ? 'bg-transparent hover:bg-slate-50/80' : 'bg-brand-50/30 hover:bg-brand-50/60' }} transition-colors group relative">
                            <!-- Unread Indicator Line -->
                            @if(!$job->is_read)
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-brand-500 rounded-r-full"></div>
                            @endif

                            <td class="px-6 py-5 whitespace-nowrap">
                                <a href="{{ route('jobs.show', $job->id) }}" wire:navigate class="block">
                                    <div class="flex items-center gap-4">
                                        <!-- Company Logo / Avatar -->
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-200/80 flex items-center justify-center shadow-sm shrink-0 group-hover:shadow-md transition-shadow">
                                            <span class="text-sm font-black text-slate-600">{{ substr($job->company_name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <div class="text-[15px] font-bold {{ $job->is_read ? 'text-slate-800' : 'text-slate-900' }} group-hover:text-brand-600 transition-colors">{{ Str::limit($job->job_title, 45) }}</div>
                                                @if(!$job->is_read)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-black bg-brand-100 text-brand-700 uppercase tracking-wider">New</span>
                                                @endif
                                            </div>
                                            <div class="text-sm font-semibold text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                {{ Str::limit($job->company_name, 35) }}
                                                
                                                @if($job->location)
                                                <span class="text-slate-300 mx-1">&bull;</span>
                                                <span class="truncate max-w-[120px]">{{ $job->location }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @php
                                    $statusConfig = match($job->status->value) {
                                        'DISCOVERED' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'border' => 'border-slate-200/80', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                                        'APPLIED' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        'PENDING_REVIEW' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        'INTERVIEW_REQUESTED' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-700', 'border' => 'border-violet-200', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                        'REJECTED' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        default => ['bg' => 'bg-brand-50', 'text' => 'text-brand-700', 'border' => 'border-brand-200', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']
                                    };
                                @endphp
                                <div class="flex flex-col items-start gap-1.5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }} shadow-sm">
                                        <svg class="w-3 h-3 mr-1.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusConfig['icon'] }}"></path></svg>
                                        {{ str_replace('_', ' ', $job->status->name) }}
                                    </span>
                                    
                                    @if(in_array($job->status->value, ['DISCOVERED', 'PENDING_REVIEW', 'READY_TO_APPLY']))
                                    <div class="flex items-center text-[10px] text-brand-600 font-bold bg-brand-50/80 px-2 py-0.5 rounded border border-brand-100" title="This job is ready to be processed by the Auto-Apply Bot">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Bot Ready
                                    </div>
                                    @elseif(in_array($job->status->value, ['FAILED']))
                                    <div class="flex items-center text-[10px] text-rose-600 font-bold bg-rose-50/80 px-2 py-0.5 rounded border border-rose-100" title="{{ $job->failure_reason ?? 'The bot attempted to apply but failed.' }}">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Bot Failed
                                    </div>
                                    @elseif(in_array($job->status->value, ['EXTERNAL_APPLICATION', 'COMPANY_WEBSITE', 'MANUAL_REQUIRED']))
                                    <div class="flex items-center text-[10px] text-amber-600 font-bold bg-amber-50/80 px-2 py-0.5 rounded border border-amber-100" title="This job redirects externally and requires manual application.">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Manual Apply
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap hidden md:table-cell">
                                <div class="flex items-center text-sm font-semibold text-slate-600">
                                    <span class="w-2 h-2 rounded-full bg-slate-300 mr-2"></span>
                                    {{ str_replace('_', ' ', $job->application_source->name) }}
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap hidden lg:table-cell">
                                <div class="text-sm font-semibold text-slate-600 flex flex-col">
                                    <span>{{ $job->created_at->format('M j, Y') }}</span>
                                    <span class="text-[11px] text-slate-400 font-medium">{{ $job->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="toggleSaveJob({{ $job->id }})" class="p-2 rounded-xl border {{ $job->is_saved ? 'bg-amber-50 border-amber-200 text-amber-500' : 'bg-white border-slate-200 text-slate-400 hover:text-amber-500 hover:border-amber-200 hover:bg-amber-50/50' }} transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20" title="{{ $job->is_saved ? 'Remove from Saved' : 'Save Job' }}">
                                        <svg class="w-4 h-4 {{ $job->is_saved ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                    </button>
                                    
                                    <a href="{{ route('jobs.show', $job->id) }}" wire:navigate class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-brand-600 hover:border-brand-300 font-bold text-xs transition-all shadow-sm">
                                        View
                                        <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center mb-5 border border-slate-100 shadow-inner">
                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <h3 class="text-base font-extrabold text-slate-900">No jobs found</h3>
                                    <p class="mt-1.5 text-sm text-slate-500 font-medium leading-relaxed">
                                        @if($search || $filterSource || $filterStatus)
                                            We couldn't find any jobs matching your current filters. Try adjusting them or clearing the filters.
                                        @else
                                            Your job pipeline is empty. Jobs will appear here once the scraper finishes running.
                                        @endif
                                    </p>
                                    @if($search || $filterSource || $filterStatus)
                                        <button wire:click="$set('search', ''); $set('filterSource', ''); $set('filterStatus', '')" class="mt-5 px-5 py-2.5 bg-brand-50 text-brand-600 hover:bg-brand-100 font-bold text-sm rounded-xl transition-colors shadow-sm border border-brand-100">
                                            Clear All Filters
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($jobs->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30 backdrop-blur-sm">
            {{ $jobs->links(data: ['scrollTo' => false]) }}
        </div>
        @endif
    </div>
</div>

