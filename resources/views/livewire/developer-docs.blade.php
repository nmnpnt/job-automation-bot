<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-white/60 backdrop-blur-xl p-6 rounded-3xl border border-slate-200/60 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -ml-32 -mb-32 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-extrabold leading-9 text-slate-900 tracking-tight">
                Developer Documentation
            </h2>
            <p class="mt-1 text-sm text-slate-500 font-medium">A complete guide to understanding the internals of the Job Automation System.</p>
        </div>
    </div>

        <!-- 1. System Overview -->
        <div class="mb-16">
            <div class="flex items-center mb-6">
                <div class="bg-indigo-600 p-3 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 ml-4">1. System Overview</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-2xl p-8 shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <h3 class="text-xl font-bold text-indigo-900 mb-3">The Laravel Backend</h3>
                    <p class="text-gray-600 leading-relaxed">
                        The core engine is built on <strong>Laravel 11</strong>. It handles HTTP requests, authentication, and orchestrates the database (`sqlite`). It exposes <strong>Livewire components</strong> to render reactive UI without needing a complex SPA framework.
                    </p>
                </div>

                <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-2xl p-8 shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <h3 class="text-xl font-bold text-indigo-900 mb-3">The Puppeteer Bot Layer</h3>
                    <p class="text-gray-600 leading-relaxed">
                        The scraping and auto-application features are powered by <strong>Node.js + Puppeteer Extra</strong>. Laravel calls these Node scripts via the Symfony Process component, passing parameters via JSON arguments.
                    </p>
                </div>
            </div>
        </div>

        <!-- 2. Where Things Live -->
        <div class="mb-16">
            <div class="flex items-center mb-6">
                <div class="bg-emerald-500 p-3 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 ml-4">2. Where Things Live (File Structure)</h2>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Directory / File</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Purpose</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-indigo-600 font-medium">app/Livewire/</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Contains the PHP controller logic for the reactive frontend pages (e.g. `Dashboard.php`, `JobsList.php`, `NotificationSettings.php`, `AutomationsHub.php`).</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-indigo-600 font-medium">resources/views/livewire/</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Contains the Blade templates for the Livewire components using Tailwind CSS and Premium Glassmorphism.</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-emerald-600 font-medium">bot/</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Contains the Node.js automation scripts: `fetch_jobs.js` (Scraper) and `apply.js` (Auto-Applier).</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-indigo-600 font-medium">app/Console/Commands/</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Contains Laravel Artisan commands (e.g. `ScrapeJobsCommand.php`, `CheckEmails.php`, `SimulateActivity.php`) that run as scheduled or manual background tasks.</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-indigo-600 font-medium">app/Models/</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Database models. `Application` tracks jobs, `Profile` tracks user settings for auto-apply, `NotificationPreference` handles Slack webhook configurations, and `ApplicationEvent` tracks history logs.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. The Lifecycle of a Job Scrape -->
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-pink-500 p-3 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 ml-4">3. Automation Lifecycle</h2>
            </div>

            <div class="relative bg-gray-900 rounded-2xl shadow-xl p-8 overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -ml-20 -mb-20"></div>
                
                <div class="relative z-10 text-gray-300 space-y-6">
                    <div class="flex">
                        <div class="flex-shrink-0 mr-4 mt-1">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-500 text-white font-bold">1</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white">Trigger</h4>
                            <p>A task is triggered either by the Laravel Scheduler (cron) or manually via the Automations Hub. The task runs in a background Queue Worker (`php artisan queue:work`).</p>
                        </div>
                    </div>
                    
                    <div class="flex">
                        <div class="flex-shrink-0 mr-4 mt-1">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-pink-500 text-white font-bold">2</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white">Orchestration</h4>
                            <p>An Artisan Command (like `ScrapeJobsCommand`) fetches the user's settings from the DB, formats the arguments as JSON, and spawns a Node process using `Symfony\Component\Process\Process`.</p>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-shrink-0 mr-4 mt-1">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white font-bold">3</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white">Execution & Parsing</h4>
                            <p>The `bot/fetch_jobs.js` script launches Puppeteer, performs the heavy lifting invisibly, and prints its final output to STDOUT as JSON. The Laravel command captures this JSON, decodes it, and persists the jobs into the `applications` table.</p>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-shrink-0 mr-4 mt-1">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-purple-500 text-white font-bold">4</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white">Notification & Event Dispatch</h4>
                            <p>Once a process succeeds, fails, or completes, it checks `NotificationPreference` and dispatches alerts via a global `sendSlackNotification` helper. It also triggers `ActivityLogged` events that are broadcasted via WebSockets (Laravel Reverb) to the dashboard's live feed.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
