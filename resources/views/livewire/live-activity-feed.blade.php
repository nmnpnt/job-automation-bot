<x-slot name="header">
    <h2 class="text-xl font-bold leading-tight text-slate-800">
        {{ __('Live Activity Feed') }}
    </h2>
</x-slot>

<div wire:poll.10s class="bg-white/80 backdrop-blur-xl border border-slate-200 overflow-hidden shadow-sm rounded-3xl mb-6 relative animate-fade-in-up">
    <!-- Blobs -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-pulse"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/20 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
    
    <div class="p-8 relative z-10 border-b border-slate-100">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mr-4 shadow-inner">
                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Live Activity Feed</h2>
                <p class="text-sm text-slate-500 mt-1">Real-time updates from your automation bots.</p>
            </div>
        </div>
        <div class="space-y-4">
            @forelse($activities as $activity)
                <div class="flex items-start p-5 bg-white/60 backdrop-blur-sm border border-slate-100 rounded-2xl shadow-sm transition-all duration-500 hover:shadow-md hover:-translate-y-0.5">
                    <div class="flex-shrink-0 mr-4">
                        @if($activity['status'] === 'submitted' || $activity['status'] === 'auto_applied')
                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        @elseif($activity['status'] === 'failed' || $activity['status'] === 'requires_manual_intervention')
                            <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        @else
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            @if(!empty($activity['original_job_url']))
                                <a href="{{ $activity['original_job_url'] }}" target="_blank" class="text-indigo-600 hover:underline hover:text-indigo-900">
                                    {{ $activity['job_title'] }} at {{ $activity['company_name'] }}
                                </a>
                            @else
                                {{ $activity['job_title'] }} at {{ $activity['company_name'] }}
                            @endif
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $activity['message'] }}
                        </p>
                        @if($activity['error_screenshot_path'])
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $activity['error_screenshot_path']) }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    View Error Screenshot
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="flex-shrink-0 whitespace-nowrap text-xs text-gray-500 ml-4">
                        {{ \Carbon\Carbon::parse($activity['timestamp'])->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div class="text-gray-500 italic text-center p-4">No recent activity. Monitoring for new jobs...</div>
            @endforelse
        </div>
    </div>
</div>
