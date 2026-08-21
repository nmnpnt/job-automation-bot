<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-slate-900/60 backdrop-blur-2xl p-6 rounded-[2rem] border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.5)] relative overflow-hidden group hover:border-brand-500/30 transition-all duration-500">
        <div class="absolute top-0 right-0 w-64 h-64 bg-neon-cyan/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-neon-pink/10 rounded-full blur-3xl -ml-32 -mb-32 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-black leading-9 text-white tracking-tight drop-shadow-md">
                System Architecture
            </h2>
            <p class="mt-2 text-[13px] text-slate-300 font-bold uppercase tracking-widest">A deep dive into how the Job Automation System works, from the UI down to the Puppeteer scraping bots.</p>
        </div>
    </div>

        <!-- Flow Diagram Section -->
        <div class="bg-slate-900/60 backdrop-blur-2xl border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] p-8 mb-16 relative overflow-hidden group hover:border-brand-500/30 transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-500/5 to-neon-cyan/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            <h2 class="text-2xl font-black text-white mb-8 border-b border-white/10 pb-4 relative z-10 flex items-center">
                <div class="w-2.5 h-2.5 rounded-full bg-brand-500 mr-3 shadow-[0_0_8px_rgba(139,92,246,0.8)]"></div>
                Data Flow Overview
            </h2>
            
            <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0 md:space-x-4 relative z-10">
                
                <!-- Frontend -->
                <div class="flex flex-col items-center bg-slate-800/50 p-6 rounded-2xl border border-white/10 w-full md:w-1/4 relative z-10 hover:border-neon-cyan/50 hover:shadow-[0_0_20px_rgba(34,211,238,0.2)] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-neon-cyan/20 text-neon-cyan p-3 rounded-xl mb-4 shadow-[0_0_15px_rgba(34,211,238,0.3)] border border-neon-cyan/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-black text-white text-lg mb-1">Frontend</h3>
                    <p class="text-[12px] font-black tracking-wider uppercase text-neon-cyan text-center mb-2">Livewire & Tailwind UI</p>
                    <p class="text-[10px] text-center text-slate-400 mt-2 uppercase tracking-widest font-bold">Trigger Scraper, View Dashboards, Poll status</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex flex-col items-center justify-center text-slate-500 relative z-10">
                    <svg class="w-8 h-8 text-brand-500/50 drop-shadow-[0_0_5px_rgba(139,92,246,0.5)] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest mt-2">HTTP / Livewire</span>
                </div>

                <!-- Backend -->
                <div class="flex flex-col items-center bg-slate-800/50 p-6 rounded-2xl border border-white/10 w-full md:w-1/4 relative z-10 hover:border-brand-500/50 hover:shadow-[0_0_20px_rgba(139,92,246,0.2)] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-brand-500/20 text-brand-400 p-3 rounded-xl mb-4 shadow-[0_0_15px_rgba(139,92,246,0.3)] border border-brand-500/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="font-black text-white text-lg mb-1">Backend</h3>
                    <p class="text-[12px] font-black tracking-wider uppercase text-brand-400 text-center mb-2">Laravel Framework</p>
                    <p class="text-[10px] text-center text-slate-400 mt-2 uppercase tracking-widest font-bold">Job Queues, Auth, Services Orchestration</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex flex-col items-center justify-center text-slate-500 relative z-10">
                    <svg class="w-8 h-8 text-brand-500/50 drop-shadow-[0_0_5px_rgba(139,92,246,0.5)] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest mt-2">Executes CLI</span>
                </div>

                <!-- Bot Layer -->
                <div class="flex flex-col items-center bg-slate-800/50 p-6 rounded-2xl border border-white/10 w-full md:w-1/4 relative z-10 hover:border-neon-pink/50 hover:shadow-[0_0_20px_rgba(255,42,133,0.2)] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-neon-pink/20 text-neon-pink p-3 rounded-xl mb-4 shadow-[0_0_15px_rgba(255,42,133,0.3)] border border-neon-pink/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="font-black text-white text-lg mb-1">Bot / Scraper</h3>
                    <p class="text-[12px] font-black tracking-wider uppercase text-neon-pink text-center mb-2">Node.js & Puppeteer</p>
                    <p class="text-[10px] text-center text-slate-400 mt-2 uppercase tracking-widest font-bold">Headless browser interaction, scraping DOM</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex flex-col items-center justify-center text-slate-500 relative z-10">
                    <svg class="w-8 h-8 text-brand-500/50 drop-shadow-[0_0_5px_rgba(139,92,246,0.5)] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest mt-2">Saves to</span>
                </div>

                <!-- Database -->
                <div class="flex flex-col items-center bg-slate-800/50 p-6 rounded-2xl border border-white/10 w-full md:w-1/4 relative z-10 hover:border-amber-400/50 hover:shadow-[0_0_20px_rgba(251,191,36,0.2)] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-amber-400/20 text-amber-400 p-3 rounded-xl mb-4 shadow-[0_0_15px_rgba(251,191,36,0.3)] border border-amber-400/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    </div>
                    <h3 class="font-black text-white text-lg mb-1">Database</h3>
                    <p class="text-[12px] font-black tracking-wider uppercase text-amber-400 text-center mb-2">SQLite</p>
                    <p class="text-[10px] text-center text-slate-400 mt-2 uppercase tracking-widest font-bold">Stores applications, logs, and queue state</p>
                </div>

            </div>
        </div>

        <!-- Detailed Layers -->
        <div class="space-y-10">
            
            <!-- Layer 1 -->
            <div class="bg-slate-900/60 backdrop-blur-2xl border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] rounded-[2rem] p-8 border-l-4 border-l-neon-cyan hover:-translate-y-1 hover:border-neon-cyan/50 hover:shadow-[0_0_30px_rgba(34,211,238,0.15)] transition-all duration-300 group">
                <div class="flex items-center mb-6">
                    <div class="bg-neon-cyan/20 p-3 rounded-xl mr-5 border border-neon-cyan/30 shadow-[0_0_15px_rgba(34,211,238,0.3)]">
                        <svg class="w-6 h-6 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-white">Layer 1: Frontend (User Interface)</h3>
                </div>
                <div class="prose prose-invert max-w-none text-slate-300 font-medium leading-relaxed">
                    <p>The frontend is powered by <strong class="text-white font-black">Laravel Livewire</strong> and styled with <strong class="text-white font-black">Tailwind CSS</strong>. This allows us to create dynamic, React-like reactive interfaces without writing complex JavaScript.</p>
                    <ul class="space-y-3 mt-4">
                        <li class="flex items-start">
                            <span class="text-neon-cyan mr-3 mt-1">✦</span>
                            <span><strong class="text-neon-cyan font-black">Live Polling:</strong> Pages like the Dashboard (Activity Feed) and Queue Monitor use <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">wire:poll</code> to automatically request fresh data from the server every few seconds. This gives the illusion of a real-time web socket connection, keeping you up-to-date as the bots work in the background.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-neon-cyan mr-3 mt-1">✦</span>
                            <span><strong class="text-neon-cyan font-black">Interactive Components:</strong> You can start scraping jobs directly from the browser by clicking a button. This triggers a Livewire method that dispatches a background task.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Layer 2 -->
            <div class="bg-slate-900/60 backdrop-blur-2xl border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] rounded-[2rem] p-8 border-l-4 border-l-brand-500 hover:-translate-y-1 hover:border-brand-500/50 hover:shadow-[0_0_30px_rgba(139,92,246,0.15)] transition-all duration-300 group">
                <div class="flex items-center mb-6">
                    <div class="bg-brand-500/20 p-3 rounded-xl mr-5 border border-brand-500/30 shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                        <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-white">Layer 2: Backend (Core Engine)</h3>
                </div>
                <div class="prose prose-invert max-w-none text-slate-300 font-medium leading-relaxed">
                    <p>The core engine is built on the <strong class="text-white font-black">Laravel PHP Framework</strong>. It is responsible for business logic, processing queues, and orchestrating the different moving parts of the automation system.</p>
                    <ul class="space-y-3 mt-4">
                        <li class="flex items-start">
                            <span class="text-brand-400 mr-3 mt-1">✦</span>
                            <span><strong class="text-brand-400 font-black">Service Classes:</strong> The <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">app/Services</code> directory contains dedicated classes like <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">PuppeteerOrchestrator</code> (to launch Node.js scripts) and <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">JobApplicationEngine</code> (to manage the state of an application).</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-brand-400 mr-3 mt-1">✦</span>
                            <span><strong class="text-brand-400 font-black">Queues:</strong> When you request a job scrape, Laravel doesn't do it instantly. It creates a <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">RunScraperJob</code> and puts it into the database queue. A separate background worker picks this up, meaning your browser never freezes while waiting for the scraper.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Layer 3 -->
            <div class="bg-slate-900/60 backdrop-blur-2xl border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] rounded-[2rem] p-8 border-l-4 border-l-neon-pink hover:-translate-y-1 hover:border-neon-pink/50 hover:shadow-[0_0_30px_rgba(255,42,133,0.15)] transition-all duration-300 group">
                <div class="flex items-center mb-6">
                    <div class="bg-neon-pink/20 p-3 rounded-xl mr-5 border border-neon-pink/30 shadow-[0_0_15px_rgba(255,42,133,0.3)]">
                        <svg class="w-6 h-6 text-neon-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-white">Layer 3: Bot / Scraper Engine</h3>
                </div>
                <div class="prose prose-invert max-w-none text-slate-300 font-medium leading-relaxed">
                    <p>This is where the actual automation happens. Located in the <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">bot/</code> folder, these scripts are written in <strong class="text-white font-black">Node.js</strong> and use <strong class="text-white font-black">Puppeteer</strong> to control a real Chromium browser.</p>
                    <ul class="space-y-3 mt-4">
                        <li class="flex items-start">
                            <span class="text-neon-pink mr-3 mt-1">✦</span>
                            <span><strong class="text-neon-pink font-black">Execution:</strong> Laravel uses the Symfony Process component to run these scripts via the command line (e.g., <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">node bot/fetch_jobs.js</code>).</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-neon-pink mr-3 mt-1">✦</span>
                            <span><strong class="text-neon-pink font-black">Communication:</strong> The bots write their progress to the standard output (STDOUT) in JSON format. The Laravel <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">PuppeteerOrchestrator</code> reads this JSON stream in real-time, parsing log messages, job discoveries, and screenshots.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-neon-pink mr-3 mt-1">✦</span>
                            <span><strong class="text-neon-pink font-black">Session Management:</strong> Browser cookies and sessions are saved inside <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">storage/app/bot-sessions</code> so you don't have to log into LinkedIn every time it runs.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Layer 4 -->
            <div class="bg-slate-900/60 backdrop-blur-2xl border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] rounded-[2rem] p-8 border-l-4 border-l-emerald-500 hover:-translate-y-1 hover:border-emerald-500/50 hover:shadow-[0_0_30px_rgba(16,185,129,0.15)] transition-all duration-300 group">
                <div class="flex items-center mb-6">
                    <div class="bg-emerald-500/20 p-3 rounded-xl mr-5 border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.3)]">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-white">Layer 4: Notifications & Event Dispatching</h3>
                </div>
                <div class="prose prose-invert max-w-none text-slate-300 font-medium leading-relaxed">
                    <p>Keeping you in the loop across multiple channels, this layer handles all outbound communication generated by the background processes.</p>
                    <ul class="space-y-3 mt-4">
                        <li class="flex items-start">
                            <span class="text-emerald-400 mr-3 mt-1">✦</span>
                            <span><strong class="text-emerald-400 font-black">Preferences Engine:</strong> Integrated via the <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">NotificationPreference</code> database model. You have granular control over what events (e.g. <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">notify_on_interview</code>, <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">notify_on_failed</code>) and what channels (e.g. <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">channel_slack</code>, <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">channel_whatsapp</code>) trigger alerts via the dedicated Settings page.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-400 mr-3 mt-1">✦</span>
                            <span><strong class="text-emerald-400 font-black">Multi-Channel Integrations:</strong> A unified helper <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">notifyChannels()</code> on the <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">User</code> model bridges all our backend workers—from the Puppeteer scraper to the IMAP email parser—to push instantaneous rich-text updates straight to your Slack workspace and WhatsApp (via CallMeBot API).</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-400 mr-3 mt-1">✦</span>
                            <span><strong class="text-emerald-400 font-black">WebSockets / Events:</strong> The <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">ActivityLogged</code> event automatically broadcasts UI updates, populating the Live Activity Feed on your dashboard without page reloads.</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
</div>
