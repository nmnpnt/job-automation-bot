<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Job Automation System') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { 
                font-family: 'Outfit', sans-serif; 
                background-color: #030712; /* Deep dark background */
                color: #f8fafc;
                overflow-x: hidden;
            }
            .glass-nav {
                background: rgba(3, 7, 18, 0.5);
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }
            .glass-card {
                background: rgba(17, 24, 39, 0.6);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(139, 92, 246, 0.2);
            }
            .text-gradient {
                background: linear-gradient(135deg, #a78bfa 0%, #38bdf8 50%, #f472b6 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
        </style>
    </head>
    <body class="antialiased selection:bg-brand-500 selection:text-white">

        <!-- Animated Background Elements -->
        <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] rounded-full bg-brand-600/20 blur-[120px] animate-blob mix-blend-screen"></div>
            <div class="absolute top-[20%] right-[-10%] w-[60%] h-[60%] rounded-full bg-neon-cyan/15 blur-[120px] animate-blob mix-blend-screen" style="animation-delay: 2s;"></div>
            <div class="absolute bottom-[-20%] left-[20%] w-[40%] h-[40%] rounded-full bg-neon-pink/15 blur-[120px] animate-blob mix-blend-screen" style="animation-delay: 4s;"></div>
            
            <!-- Sparkles -->
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white rounded-full shadow-[0_0_10px_white] animate-sparkle" style="animation-delay: 0s;"></div>
            <div class="absolute top-1/3 right-1/4 w-3 h-3 bg-neon-cyan rounded-full shadow-[0_0_15px_#22d3ee] animate-sparkle" style="animation-delay: 1.5s;"></div>
            <div class="absolute bottom-1/3 left-1/2 w-2 h-2 bg-neon-pink rounded-full shadow-[0_0_10px_#f472b6] animate-sparkle" style="animation-delay: 0.7s;"></div>
            <div class="absolute top-1/2 right-1/3 w-1.5 h-1.5 bg-brand-400 rounded-full shadow-[0_0_8px_#a78bfa] animate-sparkle" style="animation-delay: 2.2s;"></div>
        </div>

        <!-- Navigation -->
        <nav class="fixed top-0 inset-x-0 z-50 glass-nav transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center gap-3 group">
                            <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-neon-pink rounded-xl flex items-center justify-center shadow-[0_0_20px_rgba(139,92,246,0.4)] group-hover:shadow-[0_0_30px_rgba(139,92,246,0.6)] group-hover:scale-105 transition-all duration-300 relative overflow-hidden">
                                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                <span class="text-white text-xl animate-float" style="animation-duration: 3s;">✨</span>
                            </div>
                            <span class="text-2xl font-black tracking-tight text-white group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-white group-hover:to-brand-200 transition-all duration-300">
                                Career<span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-neon-cyan">Flow</span>
                            </span>
                        </a>
                    </div>
                    
                    <!-- Auth Links -->
                    <div class="flex items-center gap-6">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-slate-300 hover:text-white hover:text-shadow-glow transition-all">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-300 hover:text-white hover:text-shadow-glow transition-all hidden sm:block">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="relative inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-neon-purple px-5 py-2.5 text-sm font-bold text-white shadow-[0_0_20px_rgba(139,92,246,0.4)] hover:shadow-[0_0_30px_rgba(244,114,182,0.6)] hover:from-brand-500 hover:to-neon-pink transition-all duration-300 hover:-translate-y-0.5 overflow-hidden group">
                                        <div class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-500 skew-x-[-20deg]"></div>
                                        <span>Initialize Link Start 🚀</span>
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative pt-32 pb-16 lg:pt-40 lg:pb-24 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Text Content -->
                    <div class="flex flex-col z-10 text-center lg:text-left">
                        <div class="inline-flex items-center justify-center lg:justify-start gap-2 mb-6">
                            <span class="relative inline-flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-neon-cyan opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-neon-cyan"></span>
                            </span>
                            <span class="text-sm font-bold tracking-widest uppercase text-neon-cyan drop-shadow-[0_0_8px_rgba(34,211,238,0.5)]">System v2.0 Online</span>
                        </div>
                        
                        <h1 class="text-5xl lg:text-7xl font-black tracking-tight text-white mb-6 leading-[1.1]">
                            Automate your <br class="hidden lg:block"/>
                            <span class="text-gradient drop-shadow-[0_0_20px_rgba(139,92,246,0.4)]">Job Search.</span>
                        </h1>
                        
                        <p class="text-lg lg:text-xl text-slate-400 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                            Step into the future of career growth. Set your parameters, deploy the automated bots, and watch the interview requests materialize in your holographic dashboard.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="relative w-full sm:w-auto inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 via-neon-purple to-neon-pink px-8 py-4 text-base font-black text-white shadow-[0_0_30px_rgba(139,92,246,0.4)] hover:shadow-[0_0_40px_rgba(244,114,182,0.6)] transition-all duration-300 hover:-translate-y-1 overflow-hidden group">
                                    <div class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 skew-x-[-20deg]"></div>
                                    <span class="flex items-center gap-2">
                                        Deploy Agent <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                    </span>
                                </a>
                            @endif
                            <a href="#features" class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl px-8 py-4 text-base font-bold text-white glass-card hover:bg-white/10 hover:shadow-[0_0_20px_rgba(255,255,255,0.1)] transition-all duration-300 hover:-translate-y-1">
                                View Specs
                            </a>
                        </div>
                    </div>

                    <!-- Image / Illustration Content -->
                    <div class="relative z-10 w-full max-w-lg mx-auto lg:max-w-none animate-float" style="animation-duration: 6s;">
                        <!-- Glowing Backing -->
                        <div class="absolute inset-0 bg-gradient-to-br from-brand-500/30 to-neon-cyan/30 rounded-3xl blur-2xl transform rotate-3"></div>
                        
                        <div class="relative rounded-3xl overflow-hidden glass-card p-2 shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/10">
                            <!-- Floating UI Elements on top of image -->
                            <div class="absolute top-4 left-[-20px] bg-slate-900/80 backdrop-blur-md border border-neon-cyan/50 rounded-xl p-3 flex items-center gap-3 shadow-[0_0_20px_rgba(34,211,238,0.2)] animate-float" style="animation-duration: 4s; animation-delay: 1s;">
                                <div class="w-10 h-10 rounded-full bg-neon-cyan/20 flex items-center justify-center text-neon-cyan">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Status</p>
                                    <p class="text-sm text-white font-black">Application Sent</p>
                                </div>
                            </div>
                            
                            <div class="absolute bottom-10 right-[-20px] bg-slate-900/80 backdrop-blur-md border border-neon-pink/50 rounded-xl p-3 flex items-center gap-3 shadow-[0_0_20px_rgba(244,114,182,0.2)] animate-float" style="animation-duration: 5s; animation-delay: 2s;">
                                <div class="w-10 h-10 rounded-full bg-neon-pink/20 flex items-center justify-center text-neon-pink animate-pulse">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Incoming</p>
                                    <p class="text-sm text-white font-black">Interview Request</p>
                                </div>
                            </div>

                            <img src="{{ asset('images/hero-anime.jpg') }}" alt="Anime styled professional with holographic interfaces" class="w-full h-auto rounded-2xl object-cover relative z-[-1]">
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Features Section -->
        <section id="features" class="py-24 sm:py-32 relative z-10 border-t border-white/5 bg-slate-900/50 backdrop-blur-xl">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center mb-20">
                    <h2 class="text-sm font-black leading-7 text-neon-cyan uppercase tracking-[0.2em] mb-4 drop-shadow-[0_0_8px_rgba(34,211,238,0.5)]">System Modules</h2>
                    <p class="text-4xl lg:text-5xl font-black tracking-tight text-white mb-6">Upgraded Arsenal for your Career</p>
                    <p class="text-lg text-slate-400 font-medium">Equip yourself with the ultimate automation toolkit and dominate the tech job market.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="glass-card rounded-3xl p-8 hover:bg-white/5 transition-all duration-500 transform hover:-translate-y-3 group">
                        <div class="mb-8 relative w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-600 to-neon-purple flex items-center justify-center text-white shadow-[0_0_20px_rgba(139,92,246,0.3)] group-hover:shadow-[0_0_30px_rgba(139,92,246,0.6)] transition-all">
                            <div class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <svg class="h-8 w-8 relative z-10" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0 1 12 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2m4 6h.01M5 20h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z" /></svg>
                        </div>
                        <h3 class="text-2xl font-black text-white mb-4 group-hover:text-brand-300 transition-colors">Precision Scraping</h3>
                        <p class="text-slate-400 leading-relaxed font-medium">
                            Our advanced Headless Puppeteer algorithms scan the cybernetic landscape (LinkedIn, Naukri) to locate the exact roles that match your skill tree.
                        </p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="glass-card rounded-3xl p-8 hover:bg-white/5 transition-all duration-500 transform hover:-translate-y-3 group">
                        <div class="mb-8 relative w-16 h-16 rounded-2xl bg-gradient-to-br from-neon-pink to-rose-500 flex items-center justify-center text-white shadow-[0_0_20px_rgba(244,114,182,0.3)] group-hover:shadow-[0_0_30px_rgba(244,114,182,0.6)] transition-all">
                            <div class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <svg class="h-8 w-8 relative z-10" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.438 4.438 0 0 0 2.94 2.94 4.493 4.493 0 0 0 4.306-1.758q.26-.4.463-.831V10.743Z" /></svg>
                        </div>
                        <h3 class="text-2xl font-black text-white mb-4 group-hover:text-neon-pink transition-colors">Smart Injection</h3>
                        <p class="text-slate-400 leading-relaxed font-medium">
                            Upload your credentials once. The bot seamlessly bypasses manual entry, injecting your data directly into corporate mainframes (application forms).
                        </p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="glass-card rounded-3xl p-8 hover:bg-white/5 transition-all duration-500 transform hover:-translate-y-3 group">
                        <div class="mb-8 relative w-16 h-16 rounded-2xl bg-gradient-to-br from-neon-cyan to-blue-500 flex items-center justify-center text-white shadow-[0_0_20px_rgba(34,211,238,0.3)] group-hover:shadow-[0_0_30px_rgba(34,211,238,0.6)] transition-all">
                            <div class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <svg class="h-8 w-8 relative z-10" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" /></svg>
                        </div>
                        <h3 class="text-2xl font-black text-white mb-4 group-hover:text-neon-cyan transition-colors">HUD Alerts</h3>
                        <p class="text-slate-400 leading-relaxed font-medium">
                            Stay connected to the matrix. Receive real-time holographic notifications (via UI or Email) whenever a corporate entity responds to your ping.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer class="border-t border-white/10 relative z-10 bg-slate-950/80 backdrop-blur-md">
            <div class="mx-auto max-w-7xl px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-white text-lg">✨</span>
                    <span class="text-lg font-black tracking-tight text-white">
                        Career<span class="text-brand-400">Flow</span>
                    </span>
                </div>
                <p class="text-sm font-medium text-slate-500">&copy; {{ date('Y') }} Job Automation System v2.0. All rights reserved.</p>
            </div>
        </footer>

    </body>
</html>
