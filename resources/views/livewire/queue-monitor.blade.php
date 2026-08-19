<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-white/60 backdrop-blur-xl p-6 rounded-3xl border border-slate-200/60 shadow-sm relative overflow-hidden transition-colors duration-500">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-rose-500/10 rounded-full blur-3xl -ml-32 -mb-32 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-extrabold leading-9 text-slate-900 tracking-tight">
                Background Queue
            </h2>
            <p class="mt-1 text-sm text-slate-500 font-medium">Monitor and manage automated tasks in real-time.</p>
        </div>
        
        <div class="mt-4 flex md:ml-4 md:mt-0 relative z-10">
            <button wire:click="$refresh" class="inline-flex items-center rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50:bg-slate-600 transition-colors">
                <svg wire:loading.class="animate-spin" class="-ml-0.5 mr-1.5 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                Refresh
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center shadow-sm animate-fade-in-up" role="alert">
            <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline font-medium text-sm">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Stats Summary Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 p-6 flex items-center shadow-sm transition-colors duration-500 hover:-translate-y-1 transform">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mr-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Pending Jobs</p>
                <p class="text-2xl font-black text-slate-900">{{ $pendingJobs->count() }}</p>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 p-6 flex items-center shadow-sm transition-colors duration-500 hover:-translate-y-1 transform">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mr-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Successfully Completed</p>
                <p class="text-2xl font-black text-slate-900">{{ $successCount }}</p>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 p-6 flex items-center shadow-sm transition-colors duration-500 hover:-translate-y-1 transform">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mr-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Failed Jobs</p>
                <p class="text-2xl font-black text-slate-900">{{ $failedJobs->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Tabbed Lists -->
    <div x-data="{ activeTab: 'failed' }" class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-sm overflow-hidden transition-colors duration-500">
        <div class="flex border-b border-slate-100">
            <button @click="activeTab = 'failed'" :class="{ 'border-b-2 border-rose-500 text-rose-600': activeTab === 'failed', 'text-slate-500 hover:text-slate-700:text-slate-300': activeTab !== 'failed' }" class="px-6 py-4 font-bold text-sm outline-none transition-colors">
                Failed Jobs
                @if($failedJobs->count() > 0)
                    <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800">{{ $failedJobs->count() }}</span>
                @endif
            </button>
            <button @click="activeTab = 'pending'" :class="{ 'border-b-2 border-amber-500 text-amber-600': activeTab === 'pending', 'text-slate-500 hover:text-slate-700:text-slate-300': activeTab !== 'pending' }" class="px-6 py-4 font-bold text-sm outline-none transition-colors">
                Pending Jobs
                @if($pendingJobs->count() > 0)
                    <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800">{{ $pendingJobs->count() }}</span>
                @endif
            </button>
        </div>

        <div class="p-0 overflow-y-auto max-h-[600px] custom-scrollbar">
            
            <!-- Failed Jobs Tab -->
            <div x-show="activeTab === 'failed'" x-cloak>
                @if($failedJobs->count() > 0)
                    <ul role="list" class="divide-y divide-slate-100">
                        @foreach ($failedJobs as $fjob)
                            <li class="px-6 py-5 hover:bg-slate-50/50:bg-slate-700/30 transition-colors" x-data="{ open: false }">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                                    <div class="mb-4 md:mb-0">
                                        <p class="text-sm font-bold text-slate-900 flex items-center">
                                            Job #{{ $fjob->id }}
                                            <span class="ml-2 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500 border border-slate-200">{{ $fjob->queue }}</span>
                                        </p>
                                        <p class="mt-1 flex items-center text-xs text-rose-500 font-medium">
                                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Failed {{ \Carbon\Carbon::parse($fjob->failed_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <button @click="open = !open" class="text-xs text-slate-500 hover:text-slate-700:text-slate-200 underline font-medium mr-2">
                                            <span x-show="!open">Show Error</span>
                                            <span x-show="open">Hide Error</span>
                                        </button>
                                        <button wire:click="retryJob('{{ $fjob->uuid }}')" wire:loading.attr="disabled" wire:target="retryJob('{{ $fjob->uuid }}')" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center justify-center rounded-xl bg-white px-3 py-1.5 text-xs font-bold text-slate-700 shadow-sm border border-slate-200 hover:bg-indigo-50:bg-indigo-500/20 hover:text-indigo-600:text-indigo-300 transition-colors focus:outline-none">
                                            <svg wire:loading.remove wire:target="retryJob('{{ $fjob->uuid }}')" class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            <svg wire:loading wire:target="retryJob('{{ $fjob->uuid }}')" class="animate-spin w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Retry
                                        </button>
                                        <button x-data x-on:click="$dispatch('ask-confirm', { message: 'Are you sure you want to delete this failed job?', onConfirm: () => $wire.deleteFailedJob('{{ $fjob->uuid }}') })" wire:loading.attr="disabled" wire:target="deleteFailedJob('{{ $fjob->uuid }}')" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center justify-center rounded-xl bg-white px-3 py-1.5 text-xs font-bold text-rose-600 shadow-sm border border-rose-200 hover:bg-rose-50:bg-rose-500/20 hover:text-rose-700:text-rose-300 transition-colors focus:outline-none">
                                            <svg wire:loading.remove wire:target="deleteFailedJob('{{ $fjob->uuid }}')" class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <svg wire:loading wire:target="deleteFailedJob('{{ $fjob->uuid }}')" class="animate-spin w-3.5 h-3.5 mr-1 text-rose-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                            Del
                                        </button>
                                    </div>
                                </div>
                                <div x-show="open" x-cloak class="mt-4 bg-slate-900 rounded-lg p-4 overflow-x-auto shadow-inner border border-slate-700">
                                    <pre class="text-xs text-rose-300 font-mono whitespace-pre-wrap break-words leading-relaxed">{{ substr($fjob->exception, 0, 1500) }}{{ strlen($fjob->exception) > 1500 ? '...' : '' }}</pre>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center h-64 text-center">
                        <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mb-4 shadow-sm">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">All clear</h3>
                        <p class="mt-1 text-sm text-slate-500">No failed jobs to display.</p>
                    </div>
                @endif
            </div>

            <!-- Pending Jobs Tab -->
            <div x-show="activeTab === 'pending'" x-cloak>
                @if($pendingJobs->count() > 0)
                    <ul role="list" class="divide-y divide-slate-100">
                        @foreach ($pendingJobs as $job)
                            <li class="px-6 py-5 hover:bg-slate-50/50:bg-slate-700/30 transition-colors">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 flex items-center">
                                            Job #{{ $job->id }}
                                            <span class="ml-2 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-700 border border-amber-200">{{ $job->queue }}</span>
                                        </p>
                                        <p class="mt-1 flex items-center text-xs text-slate-500 font-medium">
                                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Created {{ \Carbon\Carbon::createFromTimestamp($job->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-slate-900 font-bold">{{ $job->attempts }}</p>
                                        <p class="text-xs text-slate-500 font-medium">Attempts</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center h-64 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 shadow-sm border border-slate-100">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">Queue is clear</h3>
                        <p class="mt-1 text-sm text-slate-500">No pending jobs in the queue.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
    </style>
</div>
