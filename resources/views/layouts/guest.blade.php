<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CareerFlow') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="text-white antialiased overflow-hidden selection:bg-brand-500 selection:text-white bg-[#030014]">
        
        <!-- Global Animated Background -->
        <div class="fixed inset-0 z-0 bg-[#030014]">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150 mix-blend-overlay"></div>
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-brand-600/30 blur-[120px] animate-pulse-glow"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-neon-cyan/20 blur-[150px] animate-pulse-glow" style="animation-delay: 2s;"></div>
            <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] rounded-full bg-neon-pink/20 blur-[100px] animate-pulse-glow" style="animation-delay: 4s;"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <div>
                <a href="/" wire:navigate class="flex flex-col items-center group relative">
                    <!-- Glow behind logo -->
                    <div class="absolute inset-0 bg-brand-500/50 blur-xl rounded-full scale-110 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative w-20 h-20 bg-slate-900/80 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(139,92,246,0.3)] border border-white/10 group-hover:scale-105 group-hover:border-brand-500/50 group-hover:shadow-[0_0_30px_rgba(139,92,246,0.6)] transition-all duration-300">
                        <svg class="w-12 h-12 text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="mt-5 text-3xl font-black text-white tracking-tight drop-shadow-md">Career<span class="text-transparent bg-clip-text bg-gradient-to-r from-neon-cyan to-brand-400">Flow</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-10 px-8 py-10 bg-slate-900/60 backdrop-blur-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] border border-white/10 sm:rounded-[2rem] relative group/card">
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-[2rem] pointer-events-none group-hover/card:border-brand-500/30 transition-colors duration-500 border border-transparent"></div>
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>
            
            <p class="mt-8 text-xs font-bold text-slate-500 uppercase tracking-widest drop-shadow-md">
                Automate your career trajectory.
            </p>
        </div>
    </body>
</html>
