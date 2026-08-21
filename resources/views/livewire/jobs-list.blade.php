<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header and Actions -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-neon-cyan/10 border border-neon-cyan/30 text-neon-cyan text-xs font-black mb-3 shadow-[0_0_10px_rgba(34,211,238,0.2)] tracking-widest uppercase">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Job Discovery
            </div>
            <h2 class="text-4xl font-black text-white tracking-tight drop-shadow-sm">All Jobs Discovered</h2>
            <p class="mt-2 text-sm text-slate-400 font-bold max-w-2xl">Manage, filter, and review all your gathered job opportunities in one place.</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Export Button -->
            <button wire:click="exportCSV" wire:loading.attr="disabled" class="h-11 inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-md px-6 rounded-xl text-sm font-bold text-white border border-white/20 hover:bg-white/20 hover:shadow-[0_0_15px_rgba(255,255,255,0.2)] hover:scale-105 transition-all shadow-lg disabled:opacity-50 group">
                <svg wire:loading.remove wire:target="exportCSV" class="w-4 h-4 text-white group-hover:text-neon-cyan transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <svg wire:loading wire:target="exportCSV" class="animate-spin w-4 h-4 text-neon-cyan" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span>Export CSV</span>
            </button>
        </div>
    </div>

    <!-- Advanced Filter Bar -->
    <div class="bg-slate-900/60 backdrop-blur-2xl p-2 rounded-2xl border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] flex flex-col xl:flex-row xl:items-center gap-3">
        <!-- Search -->
        <div class="relative flex-grow min-w-0">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by job title, company, or keywords..." class="h-12 bg-transparent border-0 text-white text-sm font-bold rounded-xl focus:ring-2 focus:ring-brand-500/50 block w-full pl-12 pr-4 placeholder:text-slate-500">
            
            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none hidden sm:flex">
                <span class="inline-flex items-center justify-center px-2 py-1 text-[10px] font-black text-slate-400 bg-white/5 rounded-md border border-white/10">⌘K</span>
            </div>
        </div>

        <div class="w-full xl:w-px xl:h-8 bg-white/10 hidden xl:block"></div>
        <div class="w-full h-px bg-white/10 xl:hidden block my-1"></div>

        <!-- Filters Container -->
        <div class="flex flex-col sm:flex-row flex-wrap items-center gap-2 p-1">
            <!-- Sort Filter -->
            <div class="relative w-full sm:w-auto flex group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-neon-cyan transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </div>
                <select wire:model.live="sortField" class="appearance-none h-10 bg-white/5 border border-white/10 text-white text-sm font-bold rounded-l-xl focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 focus:z-10 block w-full sm:w-auto pl-9 pr-8 cursor-pointer hover:bg-white/10 hover:border-white/20 transition-all">
                    <option value="created_at" class="bg-slate-800 text-white">Date Added</option>
                    <option value="job_title" class="bg-slate-800 text-white">Job Title</option>
                    <option value="company_name" class="bg-slate-800 text-white">Company Name</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                </div>
            </div>
            
            <div class="relative w-full sm:w-auto flex -ml-2 group">
                <select wire:model.live="sortDirection" class="appearance-none h-10 bg-white/5 border border-white/10 text-white text-sm font-bold rounded-r-xl focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 focus:z-10 block w-full sm:w-auto pl-4 pr-8 cursor-pointer hover:bg-white/10 hover:border-white/20 transition-all">
                    <option value="desc" class="bg-slate-800 text-white">Desc</option>
                    <option value="asc" class="bg-slate-800 text-white">Asc</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <!-- Source Filter -->
            <div class="relative w-full sm:w-auto group">
                <select wire:model.live="filterSource" class="appearance-none h-10 bg-white/5 border border-white/10 text-white text-sm font-bold rounded-xl focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 block w-full sm:w-auto pl-4 pr-9 cursor-pointer hover:bg-white/10 hover:border-white/20 transition-all">
                    <option value="" class="bg-slate-800 text-white">All Sources</option>
                    @foreach($sources as $source)
                        <option value="{{ $source->value }}" class="bg-slate-800 text-white">{{ str_replace('_', ' ', $source->name) }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-neon-cyan transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="relative w-full sm:w-auto group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <div class="w-2 h-2 rounded-full bg-slate-500 group-hover:bg-brand-400 transition-colors shadow-[0_0_5px_currentColor]"></div>
                </div>
                <select wire:model.live="filterStatus" class="appearance-none h-10 bg-white/5 border border-white/10 text-white text-sm font-bold rounded-xl focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 block w-full sm:w-auto pl-8 pr-9 cursor-pointer hover:bg-white/10 hover:border-white/20 transition-all">
                    <option value="" class="bg-slate-800 text-white">All Statuses</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" class="bg-slate-800 text-white">{{ str_replace('_', ' ', $status->name) }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-neon-cyan transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters Summary -->
    @if($filterSource || $filterStatus || $search)
    <div class="flex flex-wrap items-center gap-2 animate-fade-in">
        <span class="text-xs font-black text-slate-400 mr-1 uppercase tracking-wider">Active Filters:</span>
        
        @if($search)
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 border border-white/20 text-xs font-black text-white shadow-[0_0_10px_rgba(255,255,255,0.1)]">
            Search: <span class="text-brand-300">{{ $search }}</span>
            <button wire:click="$set('search', '')" class="text-slate-400 hover:text-neon-pink focus:outline-none transition-colors"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </span>
        @endif

        @if($filterSource)
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 border border-white/20 text-xs font-black text-white shadow-[0_0_10px_rgba(255,255,255,0.1)]">
            Source: <span class="text-brand-300">{{ str_replace('_', ' ', $filterSource) }}</span>
            <button wire:click="$set('filterSource', '')" class="text-slate-400 hover:text-neon-pink focus:outline-none transition-colors"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </span>
        @endif

        @if($filterStatus)
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 border border-white/20 text-xs font-black text-white shadow-[0_0_10px_rgba(255,255,255,0.1)]">
            Status: <span class="text-brand-300">{{ str_replace('_', ' ', $filterStatus) }}</span>
            <button wire:click="$set('filterStatus', '')" class="text-slate-400 hover:text-neon-pink focus:outline-none transition-colors"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </span>
        @endif
        
        <button wire:click="$set('search', ''); $set('filterSource', ''); $set('filterStatus', '')" class="text-xs font-black text-slate-400 hover:text-white transition-colors ml-2 underline decoration-slate-500 hover:decoration-white underline-offset-2">
            Clear All
        </button>
    </div>
    @endif

    <!-- Table Section -->
    <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.3)] overflow-hidden relative transition-colors duration-500">
        
        <div wire:loading.flex wire:target="filterSource, filterStatus, search, sortField, sortDirection, gotoPage, previousPage, nextPage" class="absolute inset-0 bg-slate-900/40 z-20 flex items-center justify-center backdrop-blur-[2px]">
            <div class="w-12 h-12 rounded-full border-4 border-brand-500 border-t-transparent animate-spin shadow-[0_0_15px_rgba(139,92,246,0.5)]"></div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/5">
                <thead class="bg-white/5 backdrop-blur-md">
                    <tr>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Job Details</th>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest hidden md:table-cell">Source</th>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest hidden lg:table-cell">Discovered</th>
                        <th scope="col" class="px-6 py-5 text-right text-[11px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 bg-transparent">
                    @forelse ($jobs as $job)
                        <tr class="{{ $job->is_read ? 'bg-transparent hover:bg-white/5' : 'bg-brand-500/10 hover:bg-brand-500/20' }} transition-colors group relative border-b border-white/5">
                            <!-- Unread Indicator Line -->
                            @if(!$job->is_read)
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-brand-500 rounded-r-full shadow-[0_0_10px_rgba(139,92,246,0.8)]"></div>
                            @endif

                            <td class="px-6 py-5 whitespace-nowrap">
                                <a href="{{ route('jobs.show', $job->id) }}" wire:navigate class="block">
                                    <div class="flex items-center gap-4">
                                        <!-- Company Logo / Avatar -->
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-white/10 to-white/5 border border-white/10 flex items-center justify-center shadow-sm shrink-0 group-hover:shadow-[0_0_15px_rgba(255,255,255,0.1)] transition-all">
                                            <span class="text-sm font-black text-white">{{ substr($job->company_name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <div class="text-[15px] font-black {{ $job->is_read ? 'text-slate-200' : 'text-white drop-shadow-md' }} group-hover:text-brand-300 transition-colors">{{ Str::limit($job->job_title, 45) }}</div>
                                                @if(!$job->is_read)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-black bg-brand-500/30 text-brand-200 uppercase tracking-widest border border-brand-500/50 shadow-[0_0_8px_rgba(139,92,246,0.4)] animate-pulse">New</span>
                                                @endif
                                            </div>
                                            <div class="text-sm font-bold text-slate-400 flex items-center gap-1.5 mt-1">
                                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                {{ Str::limit($job->company_name, 35) }}
                                                
                                                @if($job->location)
                                                <span class="text-slate-600 mx-1">&bull;</span>
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
                                        'DISCOVERED' => ['bg' => 'bg-white/10', 'text' => 'text-slate-300', 'border' => 'border-white/20', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'shadow' => 'shadow-[0_0_10px_rgba(255,255,255,0.1)]'],
                                        'APPLIED' => ['bg' => 'bg-neon-cyan/20', 'text' => 'text-neon-cyan', 'border' => 'border-neon-cyan/50', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'shadow' => 'shadow-[0_0_10px_rgba(34,211,238,0.3)]'],
                                        'PENDING_REVIEW' => ['bg' => 'bg-amber-500/20', 'text' => 'text-amber-300', 'border' => 'border-amber-500/50', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'shadow' => 'shadow-[0_0_10px_rgba(245,158,11,0.3)]'],
                                        'INTERVIEW_REQUESTED' => ['bg' => 'bg-brand-500/20', 'text' => 'text-brand-300', 'border' => 'border-brand-500/50', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'shadow' => 'shadow-[0_0_10px_rgba(139,92,246,0.3)]'],
                                        'REJECTED' => ['bg' => 'bg-neon-pink/20', 'text' => 'text-neon-pink', 'border' => 'border-neon-pink/50', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z', 'shadow' => 'shadow-[0_0_10px_rgba(244,114,182,0.3)]'],
                                        default => ['bg' => 'bg-white/10', 'text' => 'text-slate-300', 'border' => 'border-white/20', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'shadow' => 'shadow-[0_0_10px_rgba(255,255,255,0.1)]']
                                    };
                                @endphp
                                <div class="flex flex-col items-start gap-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black tracking-widest border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }} {{ $statusConfig['shadow'] }} uppercase">
                                        <svg class="w-3.5 h-3.5 mr-1.5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusConfig['icon'] }}"></path></svg>
                                        {{ str_replace('_', ' ', $job->status->name) }}
                                    </span>
                                    
                                    @if(in_array($job->status->value, ['DISCOVERED', 'PENDING_REVIEW', 'READY_TO_APPLY']))
                                    <div class="flex items-center text-[9px] text-brand-300 font-black tracking-widest bg-brand-500/20 px-2.5 py-1 rounded-md border border-brand-500/30 uppercase shadow-[0_0_8px_rgba(139,92,246,0.2)]" title="This job is ready to be processed by the Auto-Apply Bot">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Bot Ready
                                    </div>
                                    @elseif(in_array($job->status->value, ['FAILED']))
                                    <div class="flex items-center text-[9px] text-rose-300 font-black tracking-widest bg-rose-500/20 px-2.5 py-1 rounded-md border border-rose-500/30 uppercase shadow-[0_0_8px_rgba(244,63,94,0.2)]" title="{{ $job->failure_reason ?? 'The bot attempted to apply but failed.' }}">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Bot Failed
                                    </div>
                                    @elseif(in_array($job->status->value, ['EXTERNAL_APPLICATION', 'COMPANY_WEBSITE', 'MANUAL_REQUIRED']))
                                    <div class="flex items-center text-[9px] text-amber-300 font-black tracking-widest bg-amber-500/20 px-2.5 py-1 rounded-md border border-amber-500/30 uppercase shadow-[0_0_8px_rgba(245,158,11,0.2)]" title="This job redirects externally and requires manual application.">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Manual Apply
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap hidden md:table-cell">
                                <div class="flex items-center text-sm font-bold text-slate-300">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-500 mr-2 shadow-[0_0_5px_rgba(100,116,139,0.5)]"></span>
                                    {{ str_replace('_', ' ', $job->application_source->name) }}
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap hidden lg:table-cell">
                                <div class="text-sm font-bold text-slate-300 flex flex-col">
                                    <span>{{ $job->created_at->format('M j, Y') }}</span>
                                    <span class="text-[11px] text-slate-500 font-black uppercase tracking-widest mt-0.5">{{ $job->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <button wire:click="toggleSaveJob({{ $job->id }})" class="p-2.5 rounded-xl border {{ $job->is_saved ? 'bg-amber-500/20 border-amber-500/50 text-amber-400 shadow-[0_0_10px_rgba(245,158,11,0.3)]' : 'bg-white/5 border-white/10 text-slate-400 hover:text-amber-400 hover:border-amber-500/50 hover:bg-amber-500/10 hover:shadow-[0_0_10px_rgba(245,158,11,0.2)]' }} transition-all focus:outline-none" title="{{ $job->is_saved ? 'Remove from Saved' : 'Save Job' }}">
                                        <svg class="w-4 h-4 {{ $job->is_saved ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                    </button>
                                    
                                    <a href="{{ route('jobs.show', $job->id) }}" wire:navigate class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white hover:bg-white/20 hover:border-neon-cyan/50 hover:shadow-[0_0_15px_rgba(34,211,238,0.3)] font-black uppercase tracking-wider text-[10px] transition-all">
                                        View
                                        <svg class="w-3.5 h-3.5 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-24 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-24 h-24 bg-white/5 rounded-3xl flex items-center justify-center mb-6 border border-white/10 shadow-[0_0_30px_rgba(255,255,255,0.05)]">
                                        <span class="text-4xl animate-float">✨</span>
                                    </div>
                                    <h3 class="text-xl font-black text-white tracking-wide">No signals detected</h3>
                                    <p class="mt-2 text-sm text-slate-400 font-bold leading-relaxed">
                                        @if($search || $filterSource || $filterStatus)
                                            No job matches your current filter matrix. Adjust parameters and try again.
                                        @else
                                            Your job pipeline is empty. Jobs will appear here once the scraper finishes running.
                                        @endif
                                    </p>
                                    @if($search || $filterSource || $filterStatus)
                                        <button wire:click="$set('search', ''); $set('filterSource', ''); $set('filterStatus', '')" class="mt-6 px-6 py-3 bg-neon-cyan/20 text-neon-cyan hover:bg-neon-cyan/30 font-black tracking-widest uppercase text-[10px] rounded-xl transition-all shadow-[0_0_15px_rgba(34,211,238,0.2)] border border-neon-cyan/30 hover:shadow-[0_0_20px_rgba(34,211,238,0.4)]">
                                            Reset Filters
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
        <div class="px-6 py-4 border-t border-white/10 bg-white/5 backdrop-blur-md">
            {{ $jobs->links(data: ['scrollTo' => false]) }}
        </div>
        @endif
    </div>
</div>
