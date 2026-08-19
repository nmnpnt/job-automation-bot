<div class="space-y-6 transition-colors duration-300">
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:truncate sm:text-3xl sm:tracking-tight transition-colors duration-300">
                System Logs
            </h2>
            <p class="mt-1 text-sm text-slate-500 transition-colors duration-300">View and monitor Laravel application and scraper logs.</p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            <select wire:model.live="selectedLog" class="block w-full rounded-lg border-0 py-1.5 pl-3 pr-10 text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-all duration-300">
                @foreach($availableLogs as $log)
                    <option value="{{ $log }}">{{ $log }}</option>
                @endforeach
            </select>
            <button wire:click="loadLogContent" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50:bg-slate-700 transition-all duration-300 disabled:opacity-50">
                <span wire:loading.remove wire:target="loadLogContent" class="flex items-center">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Refresh
                </span>
                <span wire:loading wire:target="loadLogContent" class="flex items-center">
                    <svg class="animate-spin -ml-0.5 mr-1.5 h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Loading...
                </span>
            </button>
            <button x-data x-on:click="$dispatch('ask-confirm', { message: 'Are you sure you want to clear this log file? This cannot be undone.', onConfirm: () => $wire.clearLog() })" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-600 transition-all duration-300 disabled:opacity-50 border border-transparent">
                <span wire:loading.remove wire:target="clearLog" class="flex items-center">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Clear
                </span>
                <span wire:loading wire:target="clearLog" class="flex items-center">
                    <svg class="animate-spin -ml-0.5 mr-1.5 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Clearing...
                </span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="rounded-lg bg-emerald-50 p-4 border border-emerald-100 shadow-sm transition-colors duration-300">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-emerald-800">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-slate-900/90 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-700/50 overflow-hidden transition-colors duration-300">
        <div class="px-4 py-3 border-b border-slate-700/50 bg-slate-800/80 flex justify-between items-center transition-colors duration-300">
            <span class="text-sm font-mono text-slate-300">storage/logs/{{ $selectedLog }}</span>
            <span class="text-xs text-slate-400">Showing last 1000 lines</span>
        </div>
        <div class="p-4 overflow-x-auto overflow-y-auto max-h-[70vh]">
            <pre class="text-sm font-mono text-slate-300 whitespace-pre-wrap break-words leading-relaxed">{{ $logContent }}</pre>
        </div>
    </div>
</div>
