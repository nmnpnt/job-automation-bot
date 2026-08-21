<div class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.2)] overflow-hidden transition-colors duration-500">
    <div class="px-6 py-5 border-b border-white/10 flex items-center justify-between bg-white/5">
        <h2 class="text-lg font-black text-white uppercase tracking-wider flex items-center">
            <svg class="w-5 h-5 mr-3 text-neon-cyan drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Pending Review Queue
        </h2>
    </div>

    <div class="p-6">
        @if($pendingJobs->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mb-6 border border-white/10 shadow-[inset_0_2px_10px_rgba(0,0,0,0.3)]">
                    <svg class="w-10 h-10 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-black text-white tracking-wide">No jobs pending review</h3>
                <p class="mt-2 text-sm text-slate-400 font-bold max-w-md">Your AI matcher has not flagged any new jobs for manual review at this time.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($pendingJobs as $job)
                    <div class="bg-black/30 rounded-xl border border-white/5 p-5 flex flex-col md:flex-row justify-between items-start md:items-center hover:bg-white/5 hover:border-brand-500/30 transition-all duration-300 group">
                        <div class="mb-4 md:mb-0 flex-1 pr-4">
                            <div class="flex items-center mb-2">
                                <span class="inline-flex items-center justify-center px-3 py-1 text-[10px] font-black uppercase tracking-widest text-brand-300 bg-brand-500/20 rounded-full mr-3 border border-brand-500/30 shadow-[0_0_10px_rgba(139,92,246,0.2)]">
                                    {{ $job->match_score }}% Match
                                </span>
                                <h3 class="text-lg font-black text-white group-hover:text-neon-cyan transition-colors">{{ $job->job_title ?? 'Unknown Title' }}</h3>
                            </div>
                            <p class="text-sm font-bold text-slate-400 mt-1">
                                <span class="text-slate-300">{{ $job->company_name ?? 'Unknown Company' }}</span> &bull; 
                                <a href="{{ $job->original_job_url }}" target="_blank" class="text-brand-400 hover:text-brand-300 transition-colors drop-shadow-[0_0_5px_rgba(139,92,246,0.5)] ml-1">View Job Posting</a>
                            </p>
                            <p class="text-xs text-slate-500 font-medium mt-3 italic border-l-2 border-slate-700 pl-3">"{{ Str::limit($job->match_reason, 150) }}"</p>
                        </div>
                        
                        <div class="flex space-x-3 w-full md:w-auto shrink-0 mt-2 md:mt-0">
                            <button wire:click="approve({{ $job->id }})" class="flex-1 md:flex-none inline-flex justify-center items-center px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 rounded-xl font-black text-[10px] text-white uppercase tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] transition-all duration-300 border border-emerald-400/20">
                                Approve
                            </button>
                            <button wire:click="reject({{ $job->id }})" class="flex-1 md:flex-none inline-flex justify-center items-center px-5 py-2.5 bg-white/5 hover:bg-white/10 rounded-xl font-black text-[10px] text-slate-300 uppercase tracking-widest border border-white/10 hover:border-white/20 hover:text-white transition-all duration-300">
                                Skip
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
