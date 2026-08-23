<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-slate-900/60 backdrop-blur-2xl p-6 rounded-[2rem] border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.5)] relative overflow-hidden group hover:border-brand-500/30 transition-all duration-500">
        <div class="absolute top-0 right-0 w-64 h-64 bg-neon-cyan/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-neon-pink/10 rounded-full blur-3xl -ml-32 -mb-32 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-black leading-9 text-white tracking-tight drop-shadow-md">
                System Architecture
            </h2>
            <p class="mt-2 text-[13px] text-slate-300 font-bold uppercase tracking-widest">A deep dive into how the Job Automation System works, from the UI down to AI integrations and Python bots.</p>
        </div>
    </div>

        <!-- Flow Diagram Section -->
        <div class="bg-slate-900/60 backdrop-blur-2xl border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] p-8 mb-16 relative overflow-hidden group hover:border-brand-500/30 transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-500/5 to-neon-cyan/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            <h2 class="text-2xl font-black text-white mb-8 border-b border-white/10 pb-4 relative z-10 flex items-center">
                <div class="w-2.5 h-2.5 rounded-full bg-brand-500 mr-3 shadow-[0_0_8px_rgba(139,92,246,0.8)]"></div>
                Data Flow Overview
            </h2>
            
            <div class="flex flex-col lg:flex-row items-center justify-between space-y-6 lg:space-y-0 lg:space-x-4 relative z-10">
                
                <!-- Frontend -->
                <div class="flex flex-col items-center bg-slate-800/50 p-6 rounded-2xl border border-white/10 w-full lg:w-1/5 relative z-10 hover:border-neon-cyan/50 hover:shadow-[0_0_20px_rgba(34,211,238,0.2)] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-neon-cyan/20 text-neon-cyan p-3 rounded-xl mb-4 shadow-[0_0_15px_rgba(34,211,238,0.3)] border border-neon-cyan/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-black text-white text-lg mb-1">Frontend</h3>
                    <p class="text-[12px] font-black tracking-wider uppercase text-neon-cyan text-center mb-2">Livewire & Glass UI</p>
                    <p class="text-[10px] text-center text-slate-400 mt-2 uppercase tracking-widest font-bold">Dashboards, AI Feedback, Kanbans</p>
                </div>

                <!-- Arrow -->
                <div class="hidden lg:flex flex-col items-center justify-center text-slate-500 relative z-10">
                    <svg class="w-8 h-8 text-brand-500/50 drop-shadow-[0_0_5px_rgba(139,92,246,0.5)] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest mt-2">Livewire</span>
                </div>

                <!-- Backend -->
                <div class="flex flex-col items-center bg-slate-800/50 p-6 rounded-2xl border border-white/10 w-full lg:w-1/5 relative z-10 hover:border-brand-500/50 hover:shadow-[0_0_20px_rgba(139,92,246,0.2)] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-brand-500/20 text-brand-400 p-3 rounded-xl mb-4 shadow-[0_0_15px_rgba(139,92,246,0.3)] border border-brand-500/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="font-black text-white text-lg mb-1">Backend</h3>
                    <p class="text-[12px] font-black tracking-wider uppercase text-brand-400 text-center mb-2">Laravel Framework</p>
                    <p class="text-[10px] text-center text-slate-400 mt-2 uppercase tracking-widest font-bold">SQLite WAL, Queues, Services</p>
                </div>

                <!-- Arrow -->
                <div class="hidden lg:flex flex-col items-center justify-center text-slate-500 relative z-10">
                    <svg class="w-8 h-8 text-brand-500/50 drop-shadow-[0_0_5px_rgba(139,92,246,0.5)] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest mt-2">Delegates to</span>
                </div>

                <!-- Engines Layer -->
                <div class="flex flex-col items-center bg-slate-800/50 p-6 rounded-2xl border border-white/10 w-full lg:w-1/5 relative z-10 hover:border-neon-pink/50 hover:shadow-[0_0_20px_rgba(255,42,133,0.2)] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-neon-pink/20 text-neon-pink p-3 rounded-xl mb-4 shadow-[0_0_15px_rgba(255,42,133,0.3)] border border-neon-pink/30 flex space-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <h3 class="font-black text-white text-lg mb-1">Engines</h3>
                    <p class="text-[12px] font-black tracking-wider uppercase text-neon-pink text-center mb-2">Bots, AI & IMAP</p>
                    <p class="text-[10px] text-center text-slate-400 mt-2 uppercase tracking-widest font-bold">Python (HTTPX/Playwright), Gemini API</p>
                </div>

                <!-- Arrow -->
                <div class="hidden lg:flex flex-col items-center justify-center text-slate-500 relative z-10">
                    <svg class="w-8 h-8 text-brand-500/50 drop-shadow-[0_0_5px_rgba(139,92,246,0.5)] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest mt-2">Saves to</span>
                </div>

                <!-- Database -->
                <div class="flex flex-col items-center bg-slate-800/50 p-6 rounded-2xl border border-white/10 w-full lg:w-1/5 relative z-10 hover:border-amber-400/50 hover:shadow-[0_0_20px_rgba(251,191,36,0.2)] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-amber-400/20 text-amber-400 p-3 rounded-xl mb-4 shadow-[0_0_15px_rgba(251,191,36,0.3)] border border-amber-400/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    </div>
                    <h3 class="font-black text-white text-lg mb-1">Database</h3>
                    <p class="text-[12px] font-black tracking-wider uppercase text-amber-400 text-center mb-2">SQLite (WAL)</p>
                    <p class="text-[10px] text-center text-slate-400 mt-2 uppercase tracking-widest font-bold">Applications, Logs, Interviews</p>
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
                    <p>The frontend is powered by <strong class="text-white font-black">Laravel Livewire</strong> and styled with <strong class="text-white font-black">Tailwind CSS (Glassmorphism theme)</strong>. This allows us to create dynamic, React-like reactive interfaces without writing complex JavaScript.</p>
                    <ul class="space-y-3 mt-4">
                        <li class="flex items-start">
                            <span class="text-neon-cyan mr-3 mt-1">✦</span>
                            <span><strong class="text-neon-cyan font-black">Live Polling & Reactivity:</strong> Pages like the Dashboard, Queue Monitor, and Interviews Kanban use <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">wire:poll</code> to automatically request fresh data from the server. This gives a real-time feel to queue processing and incoming emails.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-neon-cyan mr-3 mt-1">✦</span>
                            <span><strong class="text-neon-cyan font-black">Interactive UX:</strong> High-end Kanban boards with horizontal scrolling, ATS Resume analysis modals, and interactive metric cards are designed to keep complex job tracking clean and beautiful.</span>
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
                    <p>The core engine is built on the <strong class="text-white font-black">Laravel PHP Framework</strong> with <strong class="text-white font-black">SQLite WAL Mode</strong> to handle high-concurrency read/writes.</p>
                    <ul class="space-y-3 mt-4">
                        <li class="flex items-start">
                            <span class="text-brand-400 mr-3 mt-1">✦</span>
                            <span><strong class="text-brand-400 font-black">Service Classes:</strong> The <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">app/Services</code> directory contains dedicated classes: <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">ScraperOrchestrator</code> (spawns the Python bot), <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">AIService</code> / <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">GeminiResumeAnalyzerService</code> (for AI), and <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">EmailParserService</code> (for IMAP email).</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-brand-400 mr-3 mt-1">✦</span>
                            <span><strong class="text-brand-400 font-black">Queues & Concurrency:</strong> Web requests are never blocked. Background workers (via <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">php artisan queue:work --queue=scraper,default</code>) process all heavy lifting. The <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">ScraperOrchestrator</code> spawns <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">bot/fetch_jobs.py</code> as a subprocess, passing the user's config as JSON via stdin and reading job results from stdout in real-time. Database lock issues are prevented by SQLite's WAL configuration.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Layer 3 -->
            <div class="bg-slate-900/60 backdrop-blur-2xl border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] rounded-[2rem] p-8 border-l-4 border-l-neon-pink hover:-translate-y-1 hover:border-neon-pink/50 hover:shadow-[0_0_30px_rgba(255,42,133,0.15)] transition-all duration-300 group">
                <div class="flex items-center mb-6">
                    <div class="bg-neon-pink/20 p-3 rounded-xl mr-5 border border-neon-pink/30 shadow-[0_0_15px_rgba(255,42,133,0.3)] flex space-x-2">
                        <svg class="w-6 h-6 text-neon-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-white">Layer 3: Bots, AI, & Scraping</h3>
                </div>
                <div class="prose prose-invert max-w-none text-slate-300 font-medium leading-relaxed">
                    <p>This is where the intelligence and automation live, powered by a unified Python bot, Gemini AI, and IMAP email parsing.</p>
                    <ul class="space-y-3 mt-4">
                        <li class="flex items-start">
                            <span class="text-neon-pink mr-3 mt-1">✦</span>
                            <span><strong class="text-neon-pink font-black">Unified Python Scraper (<code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">bot/fetch_jobs.py</code>):</strong> A single Python script handles <em>all</em> platforms — no Node.js or Puppeteer. It uses <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">httpx</code> for high-speed REST API extraction (Cutshort, Unstop, Hirist) and <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">Playwright</code> with <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">--headless=new</code> to scrape JS-heavy and WAF-protected platforms (LinkedIn, Indeed, Naukri, Uplers). The <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">--headless=new</code> flag is key to bypassing Akamai on Naukri without requiring paid proxy services. Laravel reads the stdout JSON stream line-by-line in real-time.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-neon-pink mr-3 mt-1">✦</span>
                            <span><strong class="text-neon-pink font-black">Gemini AI / ATS Analyzer:</strong> The app leverages Google's Gemini API via <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">AIService</code> and <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">GeminiResumeAnalyzerService</code> to read parsed resumes, analyze job descriptions, and provide a 0–100% "ATS Match Score" along with resume improvement suggestions.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-neon-pink mr-3 mt-1">✦</span>
                            <span><strong class="text-neon-pink font-black">IMAP Email Parsing:</strong> The <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">artisan app:imap-parser</code> command connects to your email server, downloads and parses emails for interview invites or rejections via <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">EmailParserService</code>, and links them back to specific job applications using AI-driven context matching.</span>
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
                            <span><strong class="text-emerald-400 font-black">Preferences Engine:</strong> Granular control over events (e.g. <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">notify_on_interview</code>, <code class="bg-white/10 px-1.5 py-0.5 rounded text-white text-sm border border-white/20">notify_on_failed</code>) and channels via the Settings page.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-400 mr-3 mt-1">✦</span>
                            <span><strong class="text-emerald-400 font-black">Multi-Channel Integrations:</strong> A unified helper pushes instantaneous rich-text updates straight to your Slack workspace and WhatsApp (via CallMeBot API).</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
</div>
