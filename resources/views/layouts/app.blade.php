<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }
            
            /* Premium Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 20px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background-color: #94a3b8;
            }
            * {
                scrollbar-width: thin;
                scrollbar-color: #cbd5e1 transparent;
            }
        </style>
    </head>
    <body class="h-full antialiased text-slate-800 overflow-hidden" x-data="{ sidebarOpen: true, mobileSidebarOpen: false }">
        
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="mobileSidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-sm lg:hidden" @click="mobileSidebarOpen = false" x-cloak></div>

        <div class="flex h-full">
            
            <!-- Sidebar Component -->
            <livewire:layout.navigation />

            <!-- Main Content Area -->
            <div class="flex flex-col flex-1 min-w-0 h-full overflow-hidden transition-all duration-300 ease-in-out" 
                 :class="{
                     'lg:ml-72': sidebarOpen,
                     'lg:ml-20': !sidebarOpen
                 }">
                
                <!-- Global Header -->
                <header class="bg-white/70 backdrop-blur-xl border-b border-slate-200/60 sticky top-0 z-20 flex-shrink-0 transition-all duration-300">
                    <div class="px-4 lg:px-6 py-3 flex items-center justify-between">
                        
                        <!-- Left Side: Toggles and Slot -->
                        <div class="flex items-center gap-4">
                            <!-- Desktop Toggle -->
                            <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block p-2 text-slate-500 hover:text-indigo-600 rounded-lg hover:bg-slate-100 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            <!-- Mobile Toggle -->
                            <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="lg:hidden p-2 -ml-2 text-slate-500 hover:text-indigo-600 rounded-lg hover:bg-slate-100 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>

                            @if (isset($header))
                                <div class="hidden sm:block text-slate-800">
                                    {{ $header }}
                                </div>
                            @endif
                        </div>
                        

                    </div>
                </header>

                <!-- Page Content (Scrollable) -->
                <main class="flex-1 overflow-y-auto overflow-x-hidden bg-slate-50 relative">
                    <!-- Vibrant Decorative Background -->
                    <div class="fixed top-0 left-0 right-0 h-screen bg-gradient-to-br from-indigo-100/50 via-purple-50/50 to-emerald-50/30 -z-10 pointer-events-none"></div>
                    <div class="fixed top-0 left-1/4 w-[500px] h-[500px] bg-pink-400/10 rounded-full blur-[100px] pointer-events-none mix-blend-multiply animate-pulse" style="animation-duration: 8s;"></div>
                    <div class="fixed bottom-0 right-1/4 w-[500px] h-[500px] bg-indigo-400/10 rounded-full blur-[100px] pointer-events-none mix-blend-multiply animate-pulse" style="animation-duration: 10s; animation-direction: reverse;"></div>
                    
                    @if(isset($header))
                        <!-- Mobile Header Injection -->
                        <div class="sm:hidden px-4 pt-6 pb-2 relative z-10 text-slate-800">
                            {{ $header }}
                        </div>
                    @endif

                    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8 relative z-10 min-h-screen">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Global Toast Notification -->
        <div x-data="{ show: false, message: '', title: '' }" 
             @activity-logged.window="show = true; message = $event.detail.message; title = $event.detail.title; setTimeout(() => show = false, 4000)"
             class="fixed bottom-6 right-6 z-50">
             
            <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 sm:scale-100" x-transition:leave-end="opacity-0 sm:scale-95" style="display: none;" class="bg-slate-900 text-white p-4 rounded-2xl shadow-2xl max-w-sm border border-slate-700 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <button @click="show = false" class="absolute top-3 right-3 text-slate-400 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    <div class="ml-3 pr-6 w-full">
                        <h4 class="font-bold text-sm text-white" x-text="title"></h4>
                        <p class="text-sm mt-1 text-slate-300" x-text="message"></p>
                    </div>
                </div>
                <!-- Progress bar -->
                <div class="absolute bottom-0 left-0 h-1 bg-indigo-500 rounded-b-2xl" style="animation: shrink 4s linear forwards;"></div>
            </div>
            <style>
                @keyframes shrink { from { width: 100%; } to { width: 0%; } }
            </style>
        </div>
    </body>
</html>
