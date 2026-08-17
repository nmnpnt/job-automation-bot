<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Job Automation System') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Inter', sans-serif; }
            .glass-nav {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            }
        </style>
    </head>
    <body class="antialiased text-slate-900 bg-slate-50 selection:bg-indigo-500 selection:text-white">

        <!-- Navigation -->
        <nav class="fixed top-0 inset-x-0 z-50 glass-nav transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center gap-3 group">
                            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/20 group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-xl font-black tracking-tight text-slate-900">Job<span class="text-indigo-600">Auto</span></span>
                        </a>
                    </div>
                    
                    <!-- Auth Links -->
                    <div class="flex items-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold leading-6 text-slate-900 hover:text-indigo-600 transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-slate-900 hover:text-indigo-600 transition-colors hidden sm:block">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-600/30 hover:bg-indigo-500 hover:-translate-y-0.5 transition-all duration-200">Start Automating</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative isolate pt-14">
            <!-- Background Gradients -->
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80 pointer-events-none" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>

            <div class="py-24 sm:py-32 lg:pb-40">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                            <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-slate-600 ring-1 ring-slate-900/10 hover:ring-slate-900/20 transition-all bg-white/50 backdrop-blur-sm cursor-default">
                                Announcing JobAuto v2.0. <span class="font-semibold text-indigo-600">The smart way to get hired.</span>
                            </div>
                        </div>
                        <h1 class="text-4xl font-black tracking-tight text-slate-900 sm:text-6xl mb-6">
                            Automate your job search. <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Land more interviews.</span>
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-slate-600">
                            Stop manually filling out applications. Set your preferences, start the bot, and watch the interviews roll in while you sleep, work, or learn new skills.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-xl bg-indigo-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/30 hover:bg-indigo-500 hover:-translate-y-1 transition-all duration-300">
                                    Get started for free
                                </a>
                            @endif
                            <a href="#features" class="text-sm font-semibold leading-6 text-slate-900 group">
                                Learn more <span class="inline-block transition-transform group-hover:translate-x-1" aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Dashboard Preview Image/Mockup -->
                    <div class="mt-16 flow-root sm:mt-24">
                        <div class="-m-2 rounded-2xl bg-slate-900/5 p-2 ring-1 ring-inset ring-slate-900/10 lg:-m-4 lg:rounded-3xl lg:p-4">
                            <div class="relative rounded-xl bg-white shadow-2xl overflow-hidden ring-1 ring-slate-900/10">
                                <!-- Fake macOS Window Header -->
                                <div class="bg-slate-100 border-b border-slate-200 px-4 py-3 flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                </div>
                                <!-- Mockup Content -->
                                <div class="bg-slate-50 p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-6 h-[400px] overflow-hidden">
                                    <div class="col-span-1 space-y-4">
                                        <div class="text-lg font-bold text-slate-900 mb-2">Overview</div>
                                        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition-shadow">
                                            <div class="text-sm font-medium text-slate-500 mb-1">Total Applications</div>
                                            <div class="text-3xl font-black text-indigo-600">342</div>
                                        </div>
                                        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition-shadow">
                                            <div class="text-sm font-medium text-slate-500 mb-1">Interviews Scheduled</div>
                                            <div class="text-3xl font-black text-purple-600">8</div>
                                        </div>
                                        <div class="bg-indigo-50 rounded-xl border border-indigo-100 p-4">
                                            <div class="flex items-center gap-3">
                                                <div class="relative flex h-3 w-3">
                                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                                                </div>
                                                <div class="text-xs font-semibold text-indigo-700">Bot is actively applying...</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-1 md:col-span-2 flex flex-col">
                                        <div class="text-lg font-bold text-slate-900 mb-4">Recent Activity</div>
                                        <div class="space-y-3 flex-1 overflow-hidden relative">
                                            <!-- Gradient mask for bottom fading -->
                                            <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-slate-50 to-transparent z-10 pointer-events-none"></div>
                                            
                                            <div class="bg-white border border-slate-100 rounded-lg shadow-sm p-4 flex items-center justify-between">
                                                <div>
                                                    <div class="font-bold text-slate-900 text-sm">Senior Laravel Developer</div>
                                                    <div class="text-xs text-slate-500 mt-1">TechCorp Inc. &bull; Remote</div>
                                                </div>
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Applied</span>
                                            </div>
                                            <div class="bg-white border border-slate-100 rounded-lg shadow-sm p-4 flex items-center justify-between">
                                                <div>
                                                    <div class="font-bold text-slate-900 text-sm">Backend Engineer</div>
                                                    <div class="text-xs text-slate-500 mt-1">StartupX &bull; New York, NY</div>
                                                </div>
                                                <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-600/20">Interview</span>
                                            </div>
                                            <div class="bg-white border border-slate-100 rounded-lg shadow-sm p-4 flex items-center justify-between">
                                                <div>
                                                    <div class="font-bold text-slate-900 text-sm">PHP Developer</div>
                                                    <div class="text-xs text-slate-500 mt-1">WebSolutions &bull; Hybrid</div>
                                                </div>
                                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">Processing</span>
                                            </div>
                                            <div class="bg-white border border-slate-100 rounded-lg shadow-sm p-4 flex items-center justify-between">
                                                <div>
                                                    <div class="font-bold text-slate-900 text-sm">Full Stack Developer</div>
                                                    <div class="text-xs text-slate-500 mt-1">Agency LLC &bull; London</div>
                                                </div>
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Applied</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Gradient -->
            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)] pointer-events-none" aria-hidden="true">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
        </main>
        
        <!-- Features Section -->
        <section id="features" class="py-24 sm:py-32 bg-white relative z-10 border-t border-slate-100">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center mb-16">
                    <h2 class="text-base font-bold leading-7 text-indigo-600 uppercase tracking-widest">Work Smarter, Not Harder</h2>
                    <p class="mt-2 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">Everything you need to land your next job</p>
                    <p class="mt-6 text-lg leading-8 text-slate-600">Set up your profile once and let our advanced automation bots handle the tedious work of finding and applying to jobs.</p>
                </div>
                
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-3">
                        <!-- Feature 1 -->
                        <div class="flex flex-col bg-slate-50 rounded-3xl p-10 border border-slate-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/30">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0 1 12 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2m4 6h.01M5 20h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z" /></svg>
                            </div>
                            <dt class="flex items-center gap-x-3 text-2xl font-bold leading-7 text-slate-900">
                                Exact Match Scraping
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-600">
                                <p class="flex-auto">Our headless Puppeteer bots scan LinkedIn, Naukri, and more, strictly matching your desired roles and locations to find the perfect fit.</p>
                            </dd>
                        </div>
                        
                        <!-- Feature 2 -->
                        <div class="flex flex-col bg-slate-50 rounded-3xl p-10 border border-slate-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-600 text-white shadow-lg shadow-purple-600/30">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.438 4.438 0 0 0 2.94 2.94 4.493 4.493 0 0 0 4.306-1.758q.26-.4.463-.831V10.743Z" /></svg>
                            </div>
                            <dt class="flex items-center gap-x-3 text-2xl font-bold leading-7 text-slate-900">
                                Smart Auto-Apply
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-600">
                                <p class="flex-auto">Attach your resume and fill your profile. The bot will automatically inject your answers into application forms and submit them on your behalf.</p>
                            </dd>
                        </div>
                        
                        <!-- Feature 3 -->
                        <div class="flex flex-col bg-slate-50 rounded-3xl p-10 border border-slate-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/30">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" /></svg>
                            </div>
                            <dt class="flex items-center gap-x-3 text-2xl font-bold leading-7 text-slate-900">
                                Real-time Alerts
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-600">
                                <p class="flex-auto">Get notified immediately when an application succeeds or requires your manual intervention, via Email or the Live Activity Feed.</p>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 mt-20">
            <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
                <div class="mt-8 md:order-1 md:mt-0">
                    <p class="text-center text-xs leading-5 text-slate-500">&copy; {{ date('Y') }} JobAuto System. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </body>
</html>
