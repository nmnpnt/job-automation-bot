<div class="space-y-6 animate-fade-in-up">
    <!-- Page Header and Filters -->
    <div class="bg-white/80 backdrop-blur-xl p-5 rounded-2xl border border-slate-200/60 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Title area -->
        <div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">All Jobs Discovered</h2>
            <p class="mt-1 text-sm text-slate-500 font-medium">Manage and review your gathered job opportunities.</p>
        </div>

        <!-- Actions and Filters -->
        <div class="flex flex-col lg:flex-row flex-wrap items-center gap-3 w-full lg:w-auto mt-4 md:mt-0 justify-end">
            
            <!-- Search -->
            <div class="relative w-full lg:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search jobs..." class="h-10 bg-white border border-slate-200/80 text-slate-700 text-sm font-medium rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full pl-10 pr-3 transition-shadow shadow-sm hover:border-slate-300">
            </div>

            <div class="flex flex-row flex-wrap items-center gap-2 w-full sm:w-auto">
                <!-- Sort -->
                <div class="flex items-center bg-white border border-slate-200/80 rounded-xl h-10 shadow-sm hover:border-slate-300 overflow-hidden divide-x divide-slate-200/80 transition-shadow">
                    <select wire:model.live="sortField" class="h-10 bg-transparent border-0 focus:ring-0 text-sm font-semibold text-slate-700 py-0 pl-3 pr-8 cursor-pointer hover:bg-slate-50 transition-colors">
                        <option value="created_at">Date Added</option>
                        <option value="job_title">Job Title</option>
                        <option value="company_name">Company</option>
                    </select>
                    <select wire:model.live="sortDirection" class="h-10 bg-transparent border-0 focus:ring-0 text-sm font-semibold text-slate-700 py-0 pl-3 pr-8 cursor-pointer hover:bg-slate-50 transition-colors">
                        <option value="desc">Desc</option>
                        <option value="asc">Asc</option>
                    </select>
                </div>

                <!-- Source Filter -->
                <select wire:model.live="filterSource" class="h-10 bg-white border border-slate-200/80 text-slate-700 text-sm font-semibold rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full sm:w-auto pl-3 pr-9 cursor-pointer transition-shadow shadow-sm hover:border-slate-300">
                    <option value="">All Portals</option>
                    @foreach($sources as $source)
                        <option value="{{ $source->value }}">{{ str_replace('_', ' ', $source->name) }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select wire:model.live="filterStatus" class="h-10 bg-white border border-slate-200/80 text-slate-700 text-sm font-semibold rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full sm:w-auto pl-3 pr-9 cursor-pointer transition-shadow shadow-sm hover:border-slate-300">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}">{{ str_replace('_', ' ', $status->name) }}</option>
                    @endforeach
                </select>

                <!-- Export -->
                <button wire:click="exportCSV" wire:loading.attr="disabled" class="h-10 inline-flex items-center justify-center space-x-2 bg-gradient-to-b from-slate-800 to-slate-900 px-5 rounded-xl text-sm font-bold text-white hover:from-slate-700 hover:to-slate-800 transition-all shadow-sm ring-1 ring-slate-900/10 disabled:opacity-50">
                    <svg wire:loading.remove wire:target="exportCSV" class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <svg wire:loading wire:target="exportCSV" class="animate-spin w-4 h-4 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Export</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-sm overflow-hidden transition-colors duration-500">
        <div class="overflow-x-auto relative">
            <div wire:loading.flex wire:target="filterSource, gotoPage, previousPage, nextPage" class="absolute inset-0 bg-slate-50/70 z-10 flex items-center justify-center backdrop-blur-[2px]">
                <div class="w-12 h-12 rounded-full border-4 border-indigo-500 border-t-transparent animate-spin shadow-lg"></div>
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
                                <div class="flex items-center space-x-2">
                                    <button wire:click="toggleSaveJob({{ $job->id }})" class="inline-flex items-center justify-center w-8 h-8 rounded-lg {{ $job->is_saved ? 'bg-amber-100 text-amber-500 hover:bg-amber-200' : 'bg-white border border-slate-200 text-slate-400 hover:text-amber-500 hover:bg-slate-50' }} transition-colors shadow-sm" title="{{ $job->is_saved ? 'Unsave Job' : 'Save Job' }}">
                                        <svg class="w-4 h-4 {{ $job->is_saved ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                    </button>
                                    
                                    <a href="{{ route('jobs.show', $job->id) }}" wire:navigate class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-indigo-600 font-bold text-xs transition-colors shadow-sm">
                                        View Details
                                    </a>
                                    
                                    @if(in_array($job->status->value, ['DISCOVERED', 'MATCHED', 'READY_TO_APPLY']))
                                    <a href="{{ $job->original_job_url }}" target="_blank" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-bold text-xs transition-colors shadow-sm border border-transparent" title="Apply directly on portal">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Apply
                                    </a>
                                    @endif
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
</div>
