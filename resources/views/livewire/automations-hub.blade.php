<div class="space-y-8 animate-fade-in-up">
    
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-slate-900/60 backdrop-blur-2xl p-6 rounded-[2rem] border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.2)] relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500/20 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-blob mix-blend-screen"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-neon-cyan/20 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none mix-blend-screen" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-neon-pink/10 rounded-full blur-[60px] transform -translate-x-1/2 -translate-y-1/2 pointer-events-none mix-blend-screen"></div>
        
        <div class="min-w-0 flex-1 relative z-10 flex items-center">
            <div class="p-3 bg-gradient-to-br from-brand-500/20 to-neon-cyan/20 text-brand-400 rounded-2xl mr-4 border border-brand-500/30 shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
            <div>
                <h2 class="text-3xl font-black leading-9 text-white tracking-tight">
                    Automations Hub
                </h2>
                <p class="mt-1 text-sm text-slate-400 font-bold tracking-wide">Monitor and manually trigger the background tasks that power your job automation system.</p>
            </div>
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
        <div class="bg-slate-900/60 backdrop-blur-xl rounded-[2rem] p-8 border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] hover:shadow-[0_10px_40px_rgba(34,211,238,0.2)] hover:border-neon-cyan/50 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-neon-cyan/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-neon-cyan to-brand-500"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-neon-cyan/10 rounded-full blur-2xl group-hover:bg-neon-cyan/20 transition-colors pointer-events-none"></div>
            <div class="flex items-center justify-between mb-6 relative z-10">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-2xl bg-neon-cyan/10 flex items-center justify-center text-neon-cyan group-hover:scale-110 group-hover:bg-neon-cyan/20 transition-all duration-300 shadow-[0_0_15px_rgba(34,211,238,0.2)] border border-neon-cyan/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-white ml-4">Job Scraper</h3>
                </div>
            </div>
            
            <p class="text-slate-400 mb-6 leading-relaxed relative z-10 text-sm font-medium">
                <strong class="text-white">Command:</strong> <code class="text-xs bg-black/50 text-neon-cyan px-2 py-1 rounded-md font-mono font-bold border border-neon-cyan/20">jobs:scrape</code><br><br>
                This task reads your Profile preferences and spawns an invisible Chrome browser (Puppeteer) to scrape LinkedIn, Naukri, and other job boards for matching positions. 
            </p>

            <div class="bg-black/40 rounded-xl p-4 mb-6 text-sm text-slate-400 border border-white/5 relative z-10 font-bold tracking-wide">
                Runs automatically: <strong class="text-neon-cyan uppercase tracking-widest text-xs">Every Hour</strong>
            </div>

            <div class="relative z-10 flex flex-wrap gap-2">
                <button wire:click="triggerScrape" wire:loading.attr="disabled" class="flex-1 min-w-[100px] flex justify-center py-2 px-3 border border-transparent rounded-xl shadow-[0_0_15px_rgba(34,211,238,0.3)] text-sm font-black uppercase tracking-wider text-black bg-neon-cyan hover:bg-neon-cyan/80 focus:outline-none transition-all duration-200 disabled:opacity-50">
                    <span wire:loading.remove wire:target="triggerScrape">All Platforms</span>
                    <span wire:loading wire:target="triggerScrape" class="flex items-center">
                        <svg class="animate-spin h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </span>
                </button>
                @foreach(['LINKEDIN', 'INDEED', 'NAUKRI', 'UPLERS', 'UNSTOP', 'HIRIST', 'CUTSHORT'] as $plat)
                    <button wire:click="triggerScrape('{{ $plat }}')" wire:loading.attr="disabled" class="flex-1 min-w-[100px] flex justify-center py-2 px-3 border border-white/10 rounded-xl shadow-sm text-xs font-bold text-slate-300 bg-white/5 hover:bg-white/10 hover:border-brand-500/50 hover:text-white hover:shadow-[0_0_15px_rgba(139,92,246,0.2)] focus:outline-none transition-all duration-200 disabled:opacity-50">
                        <span wire:loading.remove wire:target="triggerScrape('{{ $plat }}')">{{ ucfirst(strtolower($plat)) }}</span>
                        <span wire:loading wire:target="triggerScrape('{{ $plat }}')" class="flex items-center">
                            <svg class="animate-spin h-4 w-4 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Email Parser Card -->
        <div class="bg-slate-900/60 backdrop-blur-xl rounded-[2rem] p-8 border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] hover:shadow-[0_10px_40px_rgba(139,92,246,0.2)] hover:border-brand-500/50 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-brand-400 to-brand-600"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-brand-500/10 rounded-full blur-2xl group-hover:bg-brand-500/20 transition-colors pointer-events-none"></div>
            <div class="flex items-center justify-between mb-6 relative z-10">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-2xl bg-brand-500/10 flex items-center justify-center text-brand-400 group-hover:scale-110 group-hover:bg-brand-500/20 transition-transform duration-300 shadow-[0_0_15px_rgba(139,92,246,0.2)] border border-brand-500/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-white ml-4">Email Parser</h3>
                </div>
            </div>
            
            <p class="text-slate-400 mb-6 leading-relaxed relative z-10 text-sm font-medium">
                <strong class="text-white">Command:</strong> <code class="text-xs bg-black/50 text-brand-400 px-2 py-1 rounded-md font-mono font-bold border border-brand-500/20">app:check-emails</code><br><br>
                Connects to your configured IMAP inbox to scan for job application updates. It parses incoming emails to detect rejections, interview requests, and offers.
            </p>

            <div class="bg-black/40 rounded-xl p-4 mb-6 text-sm text-slate-400 border border-white/5 relative z-10 font-bold tracking-wide">
                Runs automatically: <strong class="text-brand-400 uppercase tracking-widest text-xs">Every Hour</strong>
            </div>

            <button wire:click="triggerEmailCheck" wire:loading.attr="disabled" class="relative z-10 w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-[0_0_15px_rgba(139,92,246,0.3)] text-sm font-black uppercase tracking-wider text-white bg-brand-600 hover:bg-brand-500 focus:outline-none transition-all duration-200 disabled:opacity-50">
                <span wire:loading.remove wire:target="triggerEmailCheck">Run Email Parser Now</span>
                <span wire:loading wire:target="triggerEmailCheck" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Queueing...
                </span>
            </button>
        </div>

        <!-- Activity Simulator Card -->
        <div class="bg-slate-900/60 backdrop-blur-xl rounded-[2rem] p-8 border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] hover:shadow-[0_10px_40px_rgba(244,114,182,0.2)] hover:border-neon-pink/50 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group md:col-span-2 lg:col-span-1">
            <div class="absolute inset-0 bg-gradient-to-br from-neon-pink/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-neon-pink to-brand-500"></div>
            <div class="absolute -right-12 -top-12 w-32 h-32 bg-neon-pink/10 rounded-full blur-2xl group-hover:bg-neon-pink/20 transition-colors pointer-events-none"></div>
            <div class="flex items-center justify-between mb-6 relative z-10">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-2xl bg-neon-pink/10 flex items-center justify-center text-neon-pink group-hover:scale-110 group-hover:bg-neon-pink/20 transition-transform duration-300 shadow-[0_0_15px_rgba(244,114,182,0.2)] border border-neon-pink/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-white ml-4">Activity Simulator</h3>
                </div>
            </div>
            
            <p class="text-slate-400 mb-6 leading-relaxed relative z-10 text-sm font-medium">
                <strong class="text-white">Command:</strong> <code class="text-xs bg-black/50 text-neon-pink px-2 py-1 rounded-md font-mono font-bold border border-neon-pink/20">app:simulate-activity</code><br><br>
                Generates random, mock status updates (like moving a job to "Interviewing" or "Rejected") and populates the Live Activity Feed. Useful for testing UI reactivity.
            </p>

            <div class="bg-black/40 rounded-xl p-4 mb-6 text-sm text-slate-400 border border-white/5 relative z-10 font-bold tracking-wide">
                Runs automatically: <strong class="text-neon-pink uppercase tracking-widest text-xs">Never (Manual Only)</strong>
            </div>

            <button wire:click="triggerSimulateActivity" wire:loading.attr="disabled" class="relative z-10 w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-[0_0_15px_rgba(244,114,182,0.3)] text-sm font-black uppercase tracking-wider text-black bg-neon-pink hover:bg-neon-pink/80 focus:outline-none transition-all duration-200 disabled:opacity-50">
                <span wire:loading.remove wire:target="triggerSimulateActivity">Simulate Activity</span>
                <span wire:loading wire:target="triggerSimulateActivity" class="flex items-center text-black">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Queueing...
                </span>
            </button>
        </div>

    </div>
</div>
