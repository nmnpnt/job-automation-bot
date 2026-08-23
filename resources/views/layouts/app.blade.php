<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#030014] transition-colors duration-500">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CareerFlow') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
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
                background-color: #334155;
                border-radius: 20px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background-color: #475569;
            }
            * {
                scrollbar-width: thin;
                scrollbar-color: #334155 transparent;
            }
        </style>
    </head>
    <body class="h-full antialiased text-white bg-[#030014] selection:bg-brand-500 selection:text-white transition-colors duration-500 overflow-hidden" 
          x-data="{ 
              sidebarOpen: true, 
              mobileSidebarOpen: false
          }">
        
        <!-- Global Animated Background -->
        <div class="fixed inset-0 z-0 bg-[#030014] pointer-events-none">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150 mix-blend-overlay"></div>
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-brand-600/30 blur-[120px] animate-pulse-glow"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-neon-cyan/20 blur-[150px] animate-pulse-glow" style="animation-delay: 2s;"></div>
            <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] rounded-full bg-neon-pink/20 blur-[100px] animate-pulse-glow" style="animation-delay: 4s;"></div>
        </div>
        
        <div class="flex h-full relative z-10">
            
            <!-- Mobile Sidebar Backdrop -->
            <div x-show="mobileSidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-sm lg:hidden" @click="mobileSidebarOpen = false" x-cloak></div>

            <!-- Sidebar Component -->
            <livewire:layout.navigation />

            <!-- Main Content Area -->
            <div class="flex flex-col flex-1 min-w-0 h-full overflow-hidden transition-all duration-300 ease-in-out" 
                 :class="{
                     'lg:ml-72': sidebarOpen,
                     'lg:ml-20': !sidebarOpen
                 }">
                
                <!-- Global Header -->
                <header class="bg-slate-900/60 backdrop-blur-xl border-b border-white/10 sticky top-0 z-20 flex-shrink-0 transition-all duration-300">
                    <div class="px-4 lg:px-6 py-3 flex items-center justify-between">
                        
                        <!-- Left Side: Toggles and Slot -->
                        <div class="flex items-center gap-4">
                            <!-- Desktop Toggle -->
                            <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block p-2 text-slate-400 hover:text-brand-400 rounded-lg hover:bg-white/5 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            <!-- Mobile Toggle -->
                            <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="lg:hidden p-2 -ml-2 text-slate-400 hover:text-brand-400 rounded-lg hover:bg-white/5 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>

                            @if (isset($header))
                                <div class="hidden sm:block text-white">
                                    {{ $header }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- Right Side: Topbar -->
                        <livewire:layout.topbar />

                    </div>
                </header>

                <!-- Page Content (Scrollable) -->
                <main class="flex-1 overflow-y-auto overflow-x-hidden relative">
                    
                    @if(isset($header))
                        <!-- Mobile Header Injection -->
                        <div class="sm:hidden px-4 pt-6 pb-2 relative z-10 text-white">
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
             @activity-logged.window="show = true; message = $event.detail.message; title = $event.detail.title; setTimeout(() => show = false, 4000);"
             class="fixed bottom-6 right-6 z-50">
             
            <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 sm:scale-100" x-transition:leave-end="opacity-0 sm:scale-95" style="display: none;" class="bg-slate-900/90 backdrop-blur-2xl text-white p-4 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] max-w-sm border border-brand-500/30 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-brand-900/50 to-neon-cyan/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <button @click="show = false" class="absolute top-3 right-3 text-slate-400 hover:text-white transition-colors z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="flex items-start relative z-10">
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="w-8 h-8 rounded-full bg-brand-500/20 flex items-center justify-center border border-brand-500/50 shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                            <svg class="w-5 h-5 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="ml-3 pr-6 w-full">
                        <h4 class="font-bold text-sm text-white" x-text="title"></h4>
                        <p class="text-sm mt-1 text-slate-300 font-medium" x-text="message"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Global Confirmation Modal -->
        <div x-data="{ 
            showConfirm: false, 
            message: '', 
            onConfirm: null,
            askConfirm(event) {
                this.message = event.detail.message;
                this.onConfirm = event.detail.onConfirm;
                this.showConfirm = true;
            },
            confirm() {
                if (typeof this.onConfirm === 'function') {
                    this.onConfirm();
                }
                this.showConfirm = false;
            }
        }" @ask-confirm.window="askConfirm($event)" class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
            <div x-show="showConfirm" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity"></div>
            <div x-show="showConfirm" class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="showConfirm" @click.away="showConfirm = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-[2rem] bg-slate-900/80 backdrop-blur-2xl text-left shadow-[0_10px_50px_rgba(0,0,0,0.5)] transition-all sm:my-8 sm:w-full sm:max-w-md border border-white/10">
                        <div class="bg-transparent px-4 pb-4 pt-5 sm:p-6 sm:pb-4 relative z-10">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-rose-500/20 sm:mx-0 sm:h-12 sm:w-12 shadow-[0_0_15px_rgba(244,63,94,0.3)] border border-rose-500/30">
                                    <svg class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-lg font-black leading-6 text-white" id="modal-title">Please Confirm</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-slate-400 font-semibold" x-text="message"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white/5 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-white/10 relative z-10">
                            <button @click="confirm()" type="button" class="inline-flex w-full justify-center rounded-xl bg-rose-600 px-5 py-3 text-sm font-black uppercase tracking-wider text-white shadow-[0_0_15px_rgba(225,29,72,0.4)] hover:bg-rose-500 sm:ml-3 sm:w-auto transition-all focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 focus:ring-offset-slate-900">Yes, confirm</button>
                            <button @click="showConfirm = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white/10 px-5 py-3 text-sm font-black uppercase tracking-wider text-white hover:bg-white/20 sm:mt-0 sm:w-auto transition-all focus:outline-none border border-white/20">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
