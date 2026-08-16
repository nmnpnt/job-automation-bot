<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold mb-6 flex items-center text-gray-800">
        <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        Pending Review Queue
    </h2>

    @if($pendingJobs->isEmpty())
        <div class="text-center py-8 text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <h3 class="text-sm font-medium text-gray-900">No jobs pending review</h3>
            <p class="mt-1 text-sm text-gray-500">Your AI matcher has not flagged any new jobs for manual review.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($pendingJobs as $job)
                <div class="border rounded-lg p-4 bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="mb-4 md:mb-0">
                        <div class="flex items-center">
                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-indigo-100 bg-indigo-600 rounded-full mr-3">
                                {{ $job->match_score }}% Match
                            </span>
                            <h3 class="text-lg font-medium text-gray-900">{{ $job->job_title ?? 'Unknown Title' }}</h3>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $job->company_name ?? 'Unknown Company' }} &bull; <a href="{{ $job->original_job_url }}" target="_blank" class="text-indigo-600 hover:underline">View Job Posting</a></p>
                        <p class="text-sm text-gray-500 mt-2 italic">"{{ Str::limit($job->match_reason, 150) }}"</p>
                    </div>
                    
                    <div class="flex space-x-3 w-full md:w-auto">
                        <button wire:click="approve({{ $job->id }})" class="flex-1 md:flex-none inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Approve
                        </button>
                        <button wire:click="reject({{ $job->id }})" class="flex-1 md:flex-none inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Skip
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
