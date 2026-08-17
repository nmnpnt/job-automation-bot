<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-white/60 backdrop-blur-xl p-6 rounded-3xl border border-slate-200/60 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-rose-500/10 rounded-full blur-3xl -ml-32 -mb-32 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-extrabold leading-9 text-slate-900 tracking-tight">
                System Architecture
            </h2>
            <p class="mt-1 text-sm text-slate-500 font-medium">A deep dive into how the Job Automation System works, from the UI down to the Puppeteer scraping bots.</p>
        </div>
    </div>

        <!-- Flow Diagram Section -->
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200 shadow-sm rounded-3xl p-8 mb-16 relative overflow-hidden">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 border-b pb-4">Data Flow Overview</h2>
            
            <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0 md:space-x-4">
                
                <!-- Frontend -->
                <div class="flex flex-col items-center bg-blue-50 p-6 rounded-lg border-2 border-blue-200 w-full md:w-1/4 relative z-10 hover:shadow-md transition">
                    <div class="bg-blue-500 text-white p-3 rounded-full mb-3 shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-blue-900 text-lg mb-1">Frontend</h3>
                    <p class="text-sm text-center text-blue-700">Livewire & Tailwind UI</p>
                    <p class="text-xs text-center text-blue-500 mt-2">Trigger Scraper, View Dashboards, Poll status</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <span class="text-xs font-semibold mt-1">HTTP / Livewire</span>
                </div>

                <!-- Backend -->
                <div class="flex flex-col items-center bg-indigo-50 p-6 rounded-lg border-2 border-indigo-200 w-full md:w-1/4 relative z-10 hover:shadow-md transition">
                    <div class="bg-indigo-500 text-white p-3 rounded-full mb-3 shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="font-bold text-indigo-900 text-lg mb-1">Backend</h3>
                    <p class="text-sm text-center text-indigo-700">Laravel Framework</p>
                    <p class="text-xs text-center text-indigo-500 mt-2">Job Queues, Auth, Services Orchestration</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <span class="text-xs font-semibold mt-1">Executes CLI</span>
                </div>

                <!-- Bot Layer -->
                <div class="flex flex-col items-center bg-emerald-50 p-6 rounded-lg border-2 border-emerald-200 w-full md:w-1/4 relative z-10 hover:shadow-md transition">
                    <div class="bg-emerald-500 text-white p-3 rounded-full mb-3 shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="font-bold text-emerald-900 text-lg mb-1">Bot / Scraper</h3>
                    <p class="text-sm text-center text-emerald-700">Node.js & Puppeteer</p>
                    <p class="text-xs text-center text-emerald-500 mt-2">Headless browser interaction, scraping DOM</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <span class="text-xs font-semibold mt-1">Saves to</span>
                </div>

                <!-- Database -->
                <div class="flex flex-col items-center bg-gray-100 p-6 rounded-lg border-2 border-gray-300 w-full md:w-1/4 relative z-10 hover:shadow-md transition">
                    <div class="bg-gray-600 text-white p-3 rounded-full mb-3 shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-1">Database</h3>
                    <p class="text-sm text-center text-gray-700">SQLite</p>
                    <p class="text-xs text-center text-gray-500 mt-2">Stores applications, logs, and queue state</p>
                </div>

            </div>
        </div>

        <!-- Detailed Layers -->
        <div class="space-y-12">
            
            <!-- Layer 1 -->
            <div class="bg-white/80 backdrop-blur-xl border border-slate-200 shadow-sm rounded-2xl p-8 border-l-4 border-l-blue-500 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-2 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Layer 1: Frontend (User Interface)</h3>
                </div>
                <div class="prose max-w-none text-gray-600">
                    <p>The frontend is powered by <strong>Laravel Livewire</strong> and styled with <strong>Tailwind CSS</strong>. This allows us to create dynamic, React-like reactive interfaces without writing complex JavaScript.</p>
                    <ul>
                        <li><strong>Live Polling:</strong> Pages like the Dashboard (Activity Feed) and Queue Monitor use <code>wire:poll</code> to automatically request fresh data from the server every few seconds. This gives the illusion of a real-time web socket connection, keeping you up-to-date as the bots work in the background.</li>
                        <li><strong>Interactive Components:</strong> You can start scraping jobs directly from the browser by clicking a button. This triggers a Livewire method that dispatches a background task.</li>
                    </ul>
                </div>
            </div>

            <!-- Layer 2 -->
            <div class="bg-white/80 backdrop-blur-xl border border-slate-200 shadow-sm rounded-2xl p-8 border-l-4 border-l-indigo-500 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 p-2 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Layer 2: Backend (Core Engine)</h3>
                </div>
                <div class="prose max-w-none text-gray-600">
                    <p>The core engine is built on the <strong>Laravel PHP Framework</strong>. It is responsible for business logic, processing queues, and orchestrating the different moving parts of the automation system.</p>
                    <ul>
                        <li><strong>Service Classes:</strong> The <code>app/Services</code> directory contains dedicated classes like <code>PuppeteerOrchestrator</code> (to launch Node.js scripts) and <code>JobApplicationEngine</code> (to manage the state of an application).</li>
                        <li><strong>Queues:</strong> When you request a job scrape, Laravel doesn't do it instantly. It creates a <code>RunScraperJob</code> and puts it into the database queue. A separate background worker picks this up, meaning your browser never freezes while waiting for the scraper.</li>
                    </ul>
                </div>
            </div>

            <!-- Layer 3 -->
            <div class="bg-white/80 backdrop-blur-xl border border-slate-200 shadow-sm rounded-2xl p-8 border-l-4 border-l-emerald-500 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-emerald-100 p-2 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Layer 3: Bot / Scraper Engine</h3>
                </div>
                <div class="prose max-w-none text-gray-600">
                    <p>This is where the actual automation happens. Located in the <code>bot/</code> folder, these scripts are written in <strong>Node.js</strong> and use <strong>Puppeteer</strong> to control a real Chromium browser.</p>
                    <ul>
                        <li><strong>Execution:</strong> Laravel uses the Symfony Process component to run these scripts via the command line (e.g., <code>node bot/fetch_jobs.js</code>).</li>
                        <li><strong>Communication:</strong> The bots write their progress to the standard output (STDOUT) in JSON format. The Laravel <code>PuppeteerOrchestrator</code> reads this JSON stream in real-time, parsing log messages, job discoveries, and screenshots.</li>
                        <li><strong>Session Management:</strong> Browser cookies and sessions are saved inside <code>storage/app/bot-sessions</code> so you don't have to log into LinkedIn every time it runs.</li>
                    </ul>
                </div>
            </div>

            <!-- Layer 4 -->
            <div class="bg-white/80 backdrop-blur-xl border border-slate-200 shadow-sm rounded-2xl p-8 border-l-4 border-l-purple-500 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 p-2 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Layer 4: Notifications & Event Dispatching</h3>
                </div>
                <div class="prose max-w-none text-gray-600">
                    <p>Keeping you in the loop across multiple channels, this layer handles all outbound communication generated by the background processes.</p>
                    <ul>
                        <li><strong>Preferences Engine:</strong> Integrated via the `NotificationPreference` database model. You have granular control over what events (e.g. `notify_on_interview`, `notify_on_failed`) and what channels (e.g. `channel_slack`, `channel_in_app`) trigger alerts via the dedicated Settings page.</li>
                        <li><strong>Slack Integration:</strong> A unified helper `sendSlackNotification()` on the `User` model bridges all our backend workers—from the Puppeteer scraper to the IMAP email parser—to push instantaneous rich-text updates straight to your Slack workspace.</li>
                        <li><strong>WebSockets / Events:</strong> The `ActivityLogged` event automatically broadcasts UI updates, populating the Live Activity Feed on your dashboard without page reloads.</li>
                    </ul>
                </div>
            </div>

        </div>
</div>
