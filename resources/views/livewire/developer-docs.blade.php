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
                <p class="mt-1 text-sm text-slate-400 font-bold">A complete guide to understanding the internals and setting up the Job Automation System.</p>
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-black/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-8 shadow-inner transition-all duration-300 hover:border-brand-500/30 group">
                    <h3 class="text-xl font-black text-white mb-3 group-hover:text-neon-cyan transition-colors">Laravel Backend</h3>
                    <p class="text-slate-400 font-medium leading-relaxed">
                        Built on <strong class="text-white">Laravel 11</strong>. Handles HTTP requests, authentication, DB (SQLite with WAL), IMAP email parsing via <strong class="text-white">EmailParserService</strong>, and exposes <strong class="text-white">Livewire components</strong> for a reactive UI.
                    </p>
                </div>

                <div class="bg-black/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-8 shadow-inner transition-all duration-300 hover:border-neon-pink/30 group">
                    <h3 class="text-xl font-black text-white mb-3 group-hover:text-neon-pink transition-colors">Python Bot</h3>
                    <p class="text-slate-400 font-medium leading-relaxed">
                        A single unified script — <strong class="text-white">bot/fetch_jobs.py</strong> — handles all 7 platforms using <strong class="text-white">HTTPX</strong> (API-based) and <strong class="text-white">Playwright</strong> (<code class="text-xs">--headless=new</code> for WAF bypass). Spawned by <strong class="text-white">ScraperOrchestrator</strong> via a dual-queue system.
                    </p>
                </div>

                <div class="bg-black/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-8 shadow-inner transition-all duration-300 hover:border-amber-400/30 group">
                    <h3 class="text-xl font-black text-white mb-3 group-hover:text-amber-400 transition-colors">Gemini AI Engine</h3>
                    <p class="text-slate-400 font-medium leading-relaxed">
                        Integrates the <strong class="text-white">Gemini API</strong> for advanced ATS resume analysis, matching job descriptions to resumes, and categorizing IMAP interview emails.
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

            <div class="bg-black/40 backdrop-blur-xl rounded-[2rem] shadow-[inset_0_2px_10px_rgba(0,0,0,0.2)] overflow-x-auto border border-white/5">
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
                            <td class="px-6 py-4 text-sm text-slate-300 font-medium">PHP controller logic for frontend pages (`ResumesManager.php`, `InterviewsList.php`, etc.).</td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-brand-400 font-black">resources/views/livewire/</td>
                            <td class="px-6 py-4 text-sm text-slate-300 font-medium">Blade templates for Livewire components using Tailwind CSS and Glassmorphism.</td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-emerald-400 font-black">app/Services/</td>
                            <td class="px-6 py-4 text-sm text-slate-300 font-medium">Core logic: <code>ScraperOrchestrator.php</code> (spawns Python bot), <code>AIService.php</code> / <code>GeminiResumeAnalyzerService.php</code> (AI), <code>EmailParserService.php</code> (IMAP).</td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-neon-pink font-black">bot/</td>
                            <td class="px-6 py-4 text-sm text-slate-300 font-medium">Unified Python automation: <code>fetch_jobs.py</code> handles all 7 platforms — <code>httpx</code> for API-based sites, Playwright <code>--headless=new</code> for WAF-protected/SPA sites. No Node.js.</td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-amber-400 font-black">app/Console/Commands/</td>
                            <td class="px-6 py-4 text-sm text-slate-300 font-medium">Artisan commands (`ImapParser.php`, `ScrapeJobsCommand.php`) that run as background tasks.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Local Machine Setup -->
        <div class="mb-16">
            <div class="flex items-center mb-6">
                <div class="bg-blue-500/20 border border-blue-500/30 p-3 rounded-xl shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-white ml-4 uppercase tracking-widest">3. Setup Procedure (Local Machine)</h2>
            </div>
            
            <div class="bg-black/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-8 shadow-inner space-y-6">
                <h3 class="text-lg font-black text-neon-cyan uppercase">Prerequisites</h3>
                <ul class="list-disc list-inside text-slate-300 space-y-2 mb-6 ml-2">
                    <li>PHP 8.2+</li>
                    <li>Composer</li>
                    <li>Python 3.10+</li>
                    <li>Node.js & NPM (for Vite frontend asset bundling only)</li>
                    <li>Git</li>
                </ul>
                
                <h3 class="text-lg font-black text-neon-cyan uppercase mt-8">Steps</h3>
                <div class="space-y-4">
                    <div class="p-4 bg-slate-900/80 rounded-xl border border-white/10">
                        <p class="text-slate-400 text-sm font-bold mb-2">1. Clone & Install Dependencies</p>
                        <pre class="text-brand-300 text-xs font-mono overflow-x-auto">git clone https://github.com/your-repo/job-automation-system.git
cd job-automation-system
composer install
npm install
pip install -r bot/requirements.txt
playwright install chromium</pre>
                    </div>
                    
                    <div class="p-4 bg-slate-900/80 rounded-xl border border-white/10">
                        <p class="text-slate-400 text-sm font-bold mb-2">2. Environment Configuration</p>
                        <pre class="text-brand-300 text-xs font-mono overflow-x-auto">cp .env.example .env
php artisan key:generate</pre>
                        <p class="text-slate-400 text-xs mt-2">Edit <code class="text-white">.env</code> to add your <code class="text-neon-pink">GEMINI_API_KEY</code>, IMAP settings, and Slack/WhatsApp webhooks.</p>
                    </div>

                    <div class="p-4 bg-slate-900/80 rounded-xl border border-white/10">
                        <p class="text-slate-400 text-sm font-bold mb-2">3. Database Setup (SQLite WAL is enabled by default)</p>
                        <pre class="text-brand-300 text-xs font-mono overflow-x-auto">touch database/database.sqlite
php artisan migrate --seed</pre>
                    </div>

                    <div class="p-4 bg-slate-900/80 rounded-xl border border-white/10">
                        <p class="text-slate-400 text-sm font-bold mb-2">4. Run the Application Servers</p>
                        <p class="text-slate-400 text-xs mb-2">You will need three terminal tabs:</p>
                        <pre class="text-brand-300 text-xs font-mono overflow-x-auto"># Tab 1: Laravel Web Server
php artisan serve

# Tab 2: Vite Asset Bundler
npm run dev

# Tab 3: Queue Worker
php artisan queue:work --queue=scraper,default</pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Production Deployment -->
        <div class="mb-16">
            <div class="flex items-center mb-6">
                <div class="bg-red-500/20 border border-red-500/30 p-3 rounded-xl shadow-[0_0_15px_rgba(239,68,68,0.3)]">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-white ml-4 uppercase tracking-widest">4. Production Deployment</h2>
            </div>
            
            <p class="text-slate-400 mb-6 font-medium">Because this app relies on a headless Chromium browser via Playwright for certain platforms, deployment steps differ slightly by OS to ensure dependencies are met.</p>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Linux -->
                <div class="bg-slate-900/80 rounded-2xl p-6 border border-white/10 hover:border-red-500/50 transition-colors">
                    <h3 class="font-black text-white text-lg flex items-center mb-4">
                        <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.604-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0112 6.836c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.138 20.164 22 16.418 22 12c0-5.523-4.477-10-10-10z"></path></svg>
                        Ubuntu / Debian (Recommended)
                    </h3>
                    <ol class="text-sm text-slate-300 space-y-3 list-decimal list-inside">
                        <li>Install PHP, Nginx, Node.js (for Vite), and Python 3.</li>
                        <li>Install Python dependencies & Playwright: <br><code class="text-xs bg-black/50 p-1 rounded mt-1 block overflow-x-auto whitespace-nowrap">pip install -r bot/requirements.txt && playwright install --with-deps chromium</code></li>
                        <li>Configure Nginx to serve the Laravel `public` directory.</li>
                        <li>Use <strong class="text-white">Supervisor</strong> to keep `php artisan queue:work --queue=scraper,default` running continuously in the background.</li>
                        <li>Set up a Cron job for `php artisan schedule:run`.</li>
                    </ol>
                </div>

                <!-- Windows -->
                <div class="bg-slate-900/80 rounded-2xl p-6 border border-white/10 hover:border-blue-500/50 transition-colors">
                    <h3 class="font-black text-white text-lg flex items-center mb-4">
                        <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path></svg>
                        Windows Server / IIS
                    </h3>
                    <ol class="text-sm text-slate-300 space-y-3 list-decimal list-inside">
                        <li>Install PHP (via XAMPP, Laragon, or IIS PHP Manager), Python 3, and Node.js.</li>
                        <li>Run `pip install -r bot/requirements.txt` and `playwright install chromium`.</li>
                        <li>Set up an IIS Site pointing to the `public/` directory. Ensure the AppPool has write permissions to `storage/` and `database/`.</li>
                        <li>Use <strong class="text-white">NSSM (Non-Sucking Service Manager)</strong> to create a Windows Service that runs `php artisan queue:work --queue=scraper,default` so it stays alive after logoffs.</li>
                        <li>Use Windows Task Scheduler to trigger `php artisan schedule:run` every minute.</li>
                    </ol>
                </div>

                <!-- macOS -->
                <div class="bg-slate-900/80 rounded-2xl p-6 border border-white/10 hover:border-slate-300/50 transition-colors">
                    <h3 class="font-black text-white text-lg flex items-center mb-4">
                        <svg class="w-5 h-5 text-slate-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        macOS (Homebrew)
                    </h3>
                    <ol class="text-sm text-slate-300 space-y-3 list-decimal list-inside">
                        <li>Use Laravel Valet: <code class="text-xs bg-black/50 p-1 rounded">brew install php composer node python</code> and <code class="text-xs bg-black/50 p-1 rounded">composer global require laravel/valet</code>.</li>
                        <li>Run <code class="text-xs bg-black/50 p-1 rounded">valet park</code> in your projects directory.</li>
                        <li>Run `pip install -r bot/requirements.txt` and `playwright install chromium`.</li>
                        <li>To keep queues running, you can use <strong class="text-white">PM2</strong>: <code class="text-xs bg-black/50 p-1 rounded">pm2 start "php artisan queue:work --queue=scraper,default" --name laravel-worker</code>.</li>
                        <li>Use standard `crontab -e` to schedule `php artisan schedule:run`.</li>
                    </ol>
                </div>
            </div>
            
            <div class="mt-8 p-4 bg-brand-500/10 border border-brand-500/30 rounded-xl">
                <p class="text-brand-300 text-sm font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Performance Note for all OS
                </p>
                <p class="text-slate-400 text-xs mt-1 ml-7">Ensure <code class="text-white">php artisan optimize</code> and <code class="text-white">npm run build</code> are executed during deployment for maximum speed. Since SQLite WAL is enabled, concurrent queue workers will NOT lock the web application.</p>
            </div>
        </div>

</div>
