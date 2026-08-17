<div class="space-y-8 animate-fade-in-up">
    
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-white/60 backdrop-blur-xl p-6 rounded-3xl border border-slate-200/60 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/20 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-purple-500/10 rounded-full blur-[60px] transform -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-extrabold leading-9 text-slate-900 tracking-tight">
                Automations Hub
            </h2>
            <p class="mt-1 text-sm text-slate-500 font-medium">Monitor and manually trigger the background tasks that power your job automation system.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-8 p-4 bg-emerald-500/90 backdrop-blur-sm text-white rounded-2xl shadow-lg flex items-center font-semibold border border-emerald-400" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Job Scraper Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border border-slate-200 shadow-sm hover:shadow-lg hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-indigo-400 to-indigo-600"></div>
            <div class="flex items-center justify-between mb-6 relative z-10">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform duration-300 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 ml-4">Job Scraper</h3>
                </div>
            </div>
            
            <p class="text-slate-600 mb-6 leading-relaxed relative z-10 text-sm">
                <strong>Command:</strong> <code class="text-xs bg-slate-100 text-indigo-600 px-2 py-1 rounded font-mono font-bold">jobs:scrape</code><br><br>
                This task reads your Profile preferences and spawns an invisible Chrome browser (Puppeteer) to scrape LinkedIn, Naukri, and other job boards for matching positions. 
            </p>

            <div class="bg-slate-50/80 rounded-2xl p-4 mb-6 text-sm text-slate-500 border border-slate-100 relative z-10">
                Runs automatically: <strong>Every Hour</strong>
            </div>

            <div class="relative z-10 flex flex-wrap gap-2">
                <button wire:click="triggerScrape" wire:loading.attr="disabled" class="flex-1 min-w-[100px] flex justify-center py-2 px-3 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-slate-900 hover:bg-indigo-600 focus:outline-none transition-all duration-200 disabled:opacity-50">
                    <span wire:loading.remove wire:target="triggerScrape">All Platforms</span>
                    <span wire:loading wire:target="triggerScrape" class="flex items-center">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </span>
                </button>
                @foreach(['LINKEDIN', 'INDEED', 'NAUKRI', 'UPLERS', 'UNSTOP', 'HIRIST', 'CUTSHORT'] as $plat)
                    <button wire:click="triggerScrape('{{ $plat }}')" wire:loading.attr="disabled" class="flex-1 min-w-[100px] flex justify-center py-2 px-3 border border-slate-200 rounded-xl shadow-sm text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition-all duration-200 disabled:opacity-50">
                        <span wire:loading.remove wire:target="triggerScrape('{{ $plat }}')">{{ ucfirst(strtolower($plat)) }}</span>
                        <span wire:loading wire:target="triggerScrape('{{ $plat }}')" class="flex items-center">
                            <svg class="animate-spin h-4 w-4 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Email Parser Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border border-slate-200 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-emerald-400 to-emerald-600"></div>
            <div class="flex items-center justify-between mb-6 relative z-10">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform duration-300 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 ml-4">Email Parser</h3>
                </div>
            </div>
            
            <p class="text-slate-600 mb-6 leading-relaxed relative z-10 text-sm">
                <strong>Command:</strong> <code class="text-xs bg-slate-100 text-emerald-600 px-2 py-1 rounded font-mono font-bold">app:check-emails</code><br><br>
                Connects to your configured IMAP inbox to scan for job application updates. It parses incoming emails to detect rejections, interview requests, and offers.
            </p>

            <div class="bg-slate-50/80 rounded-2xl p-4 mb-6 text-sm text-slate-500 border border-slate-100 relative z-10">
                Runs automatically: <strong>Every Hour</strong>
            </div>

            <button wire:click="triggerEmailCheck" wire:loading.attr="disabled" class="relative z-10 w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-slate-900 hover:bg-emerald-600 focus:outline-none transition-all duration-200 disabled:opacity-50">
                <span wire:loading.remove wire:target="triggerEmailCheck">Run Email Parser Now</span>
                <span wire:loading wire:target="triggerEmailCheck" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Queueing...
                </span>
            </button>
        </div>

        <!-- Activity Simulator Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border border-slate-200 shadow-sm hover:shadow-lg hover:border-amber-200 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group md:col-span-2 lg:col-span-1">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-amber-400 to-amber-600"></div>
            <div class="flex items-center justify-between mb-6 relative z-10">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform duration-300 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 ml-4">Activity Simulator</h3>
                </div>
            </div>
            
            <p class="text-slate-600 mb-6 leading-relaxed relative z-10 text-sm">
                <strong>Command:</strong> <code class="text-xs bg-slate-100 text-amber-600 px-2 py-1 rounded font-mono font-bold">app:simulate-activity</code><br><br>
                Generates random, mock status updates (like moving a job to "Interviewing" or "Rejected") and populates the Live Activity Feed. Useful for testing UI reactivity.
            </p>

            <div class="bg-slate-50/80 rounded-2xl p-4 mb-6 text-sm text-slate-500 border border-slate-100 relative z-10">
                Runs automatically: <strong>Never (Manual Only)</strong>
            </div>

            <button wire:click="triggerSimulateActivity" wire:loading.attr="disabled" class="relative z-10 w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-slate-900 hover:bg-amber-500 focus:outline-none transition-all duration-200 disabled:opacity-50">
                <span wire:loading.remove wire:target="triggerSimulateActivity">Simulate Activity</span>
                <span wire:loading wire:target="triggerSimulateActivity" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Queueing...
                </span>
            </button>
        </div>

    </div>
</div>
