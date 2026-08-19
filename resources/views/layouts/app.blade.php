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
                        
                        <!-- Right Side: Topbar -->
                        <livewire:layout.topbar />

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
             @activity-logged.window="show = true; message = $event.detail.message; title = $event.detail.title;"
             class="fixed bottom-6 right-6 z-50">
             
            <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 sm:scale-100" x-transition:leave-end="opacity-0 sm:scale-95" style="display: none;" class="bg-slate-900 text-white p-4 rounded-2xl shadow-2xl max-w-sm border border-slate-700 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <button @click="show = false" class="absolute top-3 right-3 text-slate-400 hover:text-white transition-colors z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="flex items-start relative z-10">
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
            <div x-show="showConfirm" x-transition.opacity class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>
            <div x-show="showConfirm" class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="showConfirm" @click.away="showConfirm = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-3xl bg-white/90 backdrop-blur-2xl text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-white/50">
                        <div class="bg-transparent px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-rose-100 sm:mx-0 sm:h-12 sm:w-12 shadow-sm">
                                    <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-lg font-black leading-6 text-slate-900" id="modal-title">Please Confirm</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-slate-600 font-semibold" x-text="message"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50/50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-200/50">
                            <button @click="confirm()" type="button" class="inline-flex w-full justify-center rounded-2xl bg-rose-600 px-5 py-3 text-sm font-bold text-white shadow-md shadow-rose-500/20 hover:bg-rose-500 sm:ml-3 sm:w-auto transition-colors">Yes, confirm</button>
                            <button @click="showConfirm = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-2xl bg-white px-5 py-3 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
