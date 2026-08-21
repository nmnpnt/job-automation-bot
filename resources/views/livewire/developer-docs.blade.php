<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-slate-900/60 backdrop-blur-2xl p-6 rounded-[2rem] border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-neon-cyan/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-neon-pink/10 rounded-full blur-3xl -ml-32 -mb-32 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10 flex items-center">
            <div class="p-3 bg-neon-cyan/20 text-neon-cyan rounded-2xl mr-4 border border-neon-cyan/30 shadow-[0_0_15px_rgba(34,211,238,0.3)]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
            </div>
            <div>
                <h2 class="text-3xl font-black leading-9 text-white tracking-wide uppercase drop-shadow-md">
                    Developer Documentation
                </h2>
                <p class="mt-1 text-sm text-slate-400 font-bold">A complete guide to understanding the internals of the Job Automation System.</p>
            </div>
        </div>
    </div>

        <!-- 1. System Overview -->
        <div class="mb-16">
            <div class="flex items-center mb-6">
                <div class="bg-brand-500/20 border border-brand-500/30 p-3 rounded-xl shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                    <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-white ml-4 uppercase tracking-widest">1. System Overview</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-black/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-8 shadow-inner transition-all duration-300 hover:border-brand-500/30 group">
                    <h3 class="text-xl font-black text-white mb-3 group-hover:text-neon-cyan transition-colors">The Laravel Backend</h3>
                    <p class="text-slate-400 font-medium leading-relaxed">
                        The core engine is built on <strong class="text-white">Laravel 11</strong>. It handles HTTP requests, authentication, and orchestrates the database (`sqlite`). It exposes <strong class="text-white">Livewire components</strong> to render reactive UI without needing a complex SPA framework.
                    </p>
                </div>

                <div class="bg-black/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-8 shadow-inner transition-all duration-300 hover:border-neon-pink/30 group">
                    <h3 class="text-xl font-black text-white mb-3 group-hover:text-neon-pink transition-colors">The Puppeteer Bot Layer</h3>
                    <p class="text-slate-400 font-medium leading-relaxed">
                        The scraping and auto-application features are powered by <strong class="text-white">Node.js + Puppeteer Extra</strong>. Laravel calls these Node scripts via the Symfony Process component, passing parameters via JSON arguments.
                    </p>
                </div>
            </div>
        </div>

        <!-- 2. Where Things Live -->
        <div class="mb-16">
            <div class="flex items-center mb-6">
                <div class="bg-emerald-500/20 border border-emerald-500/30 p-3 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.3)]">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-white ml-4 uppercase tracking-widest">2. Where Things Live (File Structure)</h2>
            </div>

            <div class="bg-black/40 backdrop-blur-xl rounded-[2rem] shadow-[inset_0_2px_10px_rgba(0,0,0,0.2)] overflow-hidden border border-white/5">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/5">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Directory / File</th>
                            <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Purpose</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-neon-cyan font-black">app/Livewire/</td>
                            <td class="px-6 py-4 text-sm text-slate-300 font-medium">Contains the PHP controller logic for the reactive frontend pages (e.g. `Dashboard.php`, `JobsList.php`, `NotificationSettings.php`, `AutomationsHub.php`).</td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-brand-400 font-black">resources/views/livewire/</td>
                            <td class="px-6 py-4 text-sm text-slate-300 font-medium">Contains the Blade templates for the Livewire components using Tailwind CSS and Premium Cyber-Anime Glassmorphism.</td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-emerald-400 font-black">bot/</td>
                            <td class="px-6 py-4 text-sm text-slate-300 font-medium">Contains the Node.js automation scripts: `fetch_jobs.js` (Scraper) and `apply.js` (Auto-Applier).</td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-neon-pink font-black">app/Console/Commands/</td>
                            <td class="px-6 py-4 text-sm text-slate-300 font-medium">Contains Laravel Artisan commands (e.g. `ScrapeJobsCommand.php`, `CheckEmails.php`, `SimulateActivity.php`) that run as scheduled or manual background tasks.</td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-amber-400 font-black">app/Models/</td>
                            <td class="px-6 py-4 text-sm text-slate-300 font-medium">Database models. `Application` tracks jobs, `Profile` tracks user settings for auto-apply, `NotificationPreference` handles Slack webhook configurations, and `ApplicationEvent` tracks history logs.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. The Lifecycle of a Job Scrape -->
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-neon-pink/20 border border-neon-pink/30 p-3 rounded-xl shadow-[0_0_15px_rgba(255,42,133,0.3)]">
                    <svg class="w-6 h-6 text-neon-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-white ml-4 uppercase tracking-widest">3. Automation Lifecycle</h2>
            </div>

            <div class="relative bg-slate-900/80 backdrop-blur-2xl rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.4)] p-8 overflow-hidden border border-white/10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-neon-pink/20 rounded-full blur-[80px] -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-neon-cyan/20 rounded-full blur-[80px] -ml-20 -mb-20"></div>
                
                <div class="relative z-10 space-y-8">
                    <div class="flex group">
                        <div class="flex-shrink-0 mr-5">
                            <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-brand-500/20 text-brand-400 border border-brand-500/30 font-black shadow-[0_0_15px_rgba(139,92,246,0.3)] group-hover:scale-110 transition-transform">1</span>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-white uppercase tracking-wider mb-2">Trigger</h4>
                            <p class="text-slate-400 font-medium">A task is triggered either by the Laravel Scheduler (cron) or manually via the Automations Hub. The task runs in a background Queue Worker (`php artisan queue:work`).</p>
                        </div>
                    </div>
                    
                    <div class="flex group">
                        <div class="flex-shrink-0 mr-5">
                            <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-neon-pink/20 text-neon-pink border border-neon-pink/30 font-black shadow-[0_0_15px_rgba(255,42,133,0.3)] group-hover:scale-110 transition-transform">2</span>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-white uppercase tracking-wider mb-2">Orchestration</h4>
                            <p class="text-slate-400 font-medium">An Artisan Command (like `ScrapeJobsCommand`) fetches the user's settings from the DB, formats the arguments as JSON, and spawns a Node process using `Symfony\Component\Process\Process`.</p>
                        </div>
                    </div>

                    <div class="flex group">
                        <div class="flex-shrink-0 mr-5">
                            <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 font-black shadow-[0_0_15px_rgba(16,185,129,0.3)] group-hover:scale-110 transition-transform">3</span>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-white uppercase tracking-wider mb-2">Execution & Parsing</h4>
                            <p class="text-slate-400 font-medium">The `bot/fetch_jobs.js` script launches Puppeteer, performs the heavy lifting invisibly, and prints its final output to STDOUT as JSON. The Laravel command captures this JSON, decodes it, and persists the jobs into the `applications` table.</p>
                        </div>
                    </div>

                    <div class="flex group">
                        <div class="flex-shrink-0 mr-5">
                            <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/30 font-black shadow-[0_0_15px_rgba(245,158,11,0.3)] group-hover:scale-110 transition-transform">4</span>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-white uppercase tracking-wider mb-2">Notification & Event Dispatch</h4>
                            <p class="text-slate-400 font-medium">Once a process succeeds, fails, or completes, it checks `NotificationPreference` and dispatches alerts via a global `notifyChannels` logic (supporting Slack Webhooks and CallMeBot WhatsApp). It also triggers `ActivityLogged` events that are broadcasted via WebSockets (Laravel Reverb) to the dashboard's live feed.</p>
                        </div>
                    </div>

                    <div class="flex group">
                        <div class="flex-shrink-0 mr-5">
                            <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-neon-cyan/20 text-neon-cyan border border-neon-cyan/30 font-black shadow-[0_0_15px_rgba(34,211,238,0.3)] group-hover:scale-110 transition-transform">5</span>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-white uppercase tracking-wider mb-2">Monitoring & Logs</h4>
                            <p class="text-slate-400 font-medium">Queue workers monitor the queue and run tasks asynchronously. Any errors are caught and logged into `storage/logs/laravel.log`. The `LogViewer` allows reading these files and Node.js scraper logs directly from the frontend.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
