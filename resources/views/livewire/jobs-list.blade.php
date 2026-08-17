<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-white/60 backdrop-blur-xl p-6 rounded-3xl border border-slate-200/60 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/20 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-purple-500/10 rounded-full blur-[60px] transform -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-extrabold leading-9 text-slate-900 tracking-tight">
                All Jobs Discovered
            </h2>
            <p class="mt-1 text-sm text-slate-500 font-medium">A complete list of jobs gathered across all configured portals.</p>
        </div>
        
        <div class="mt-6 md:mt-0 md:ml-4 flex items-center space-x-4 relative z-10">
            <div class="flex items-center space-x-3 bg-white/80 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-sm border border-slate-200">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <select wire:model.live="filterSource" id="filterSource" class="bg-transparent border-0 focus:ring-0 text-sm font-semibold text-slate-700 py-0 pl-1 pr-8 cursor-pointer appearance-none">
                    <option value="">All Portals</option>
                    @foreach($sources as $source)
                        <option value="{{ $source->value }}">{{ str_replace('_', ' ', $source->name) }}</option>
                    @endforeach
                </select>
                <!-- Custom chevron for select -->
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50/50 backdrop-blur-sm">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Job Title</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Company</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Portal</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Discovered</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-transparent">
                    @forelse ($jobs as $job)
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ Str::limit($job->job_title, 40) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-slate-100 text-slate-500 rounded-lg flex items-center justify-center mr-3 font-bold text-xs">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-500">
                                {{ $job->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="generateCoverLetter({{ $job->id }})" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 text-emerald-500 hover:bg-emerald-100 hover:text-emerald-700 transition-colors tooltip" title="Generate Cover Letter (Gemini)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                    </button>
                                    <a href="{{ $job->original_job_url }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-indigo-100 hover:text-indigo-600 transition-colors tooltip" title="View Original Job">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
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
</div>
