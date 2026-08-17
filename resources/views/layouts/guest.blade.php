<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Job Automation System') }}</title>

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
    <body class="text-slate-800 antialiased overflow-hidden selection:bg-indigo-500 selection:text-white">
        <!-- Animated Background -->
        <div class="fixed inset-0 z-0 bg-slate-50">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-500/10 rounded-full blur-[100px] -mr-48 -mt-48 pointer-events-none animate-pulse" style="animation-duration: 8s;"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-[100px] -ml-48 -mb-48 pointer-events-none animate-pulse" style="animation-duration: 10s;"></div>
            <div class="absolute top-1/2 left-1/2 w-[800px] h-[800px] bg-purple-500/5 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <div>
                <a href="/" wire:navigate class="flex flex-col items-center group">
                    <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-xl shadow-indigo-600/30 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="mt-4 text-2xl font-black text-slate-900 tracking-tight">Job<span class="text-indigo-600">Auto</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-10 bg-white/70 backdrop-blur-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white sm:rounded-3xl relative">
                <div class="absolute inset-0 bg-gradient-to-br from-white/60 to-white/20 rounded-3xl pointer-events-none"></div>
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>
            
            <p class="mt-8 text-sm font-medium text-slate-500">
                Automate your career trajectory.
            </p>
        </div>
    </body>
</html>
