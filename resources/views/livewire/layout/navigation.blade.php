<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<aside :class="{
        'translate-x-0 w-72': mobileSidebarOpen,
        '-translate-x-full w-72': !mobileSidebarOpen,
        'lg:translate-x-0 lg:w-72': sidebarOpen,
        'lg:translate-x-0 lg:w-20': !sidebarOpen
    }" 
    class="fixed inset-y-0 left-0 z-50 bg-slate-900/70 backdrop-blur-2xl text-slate-300 transition-all duration-300 ease-in-out flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.3)] lg:shadow-none border-r border-slate-700/50 lg:h-screen overflow-hidden group">
    
    <!-- Sidebar Header (Logo) -->
    <div class="flex items-center px-6 h-20 border-b border-slate-700/50 bg-slate-900/40" :class="{'justify-between': sidebarOpen, 'justify-center': !sidebarOpen}">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-gradient-to-br from-brand-500 via-neon-violet to-neon-cyan rounded-xl flex flex-shrink-0 items-center justify-center shadow-[0_0_15px_rgba(34,211,238,0.4)] group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <span x-show="sidebarOpen" x-transition.opacity.duration.300ms class="text-xl font-black text-white tracking-tight whitespace-nowrap bg-clip-text text-transparent bg-gradient-to-r from-white to-brand-300">Career<span class="text-neon-cyan">Flow</span> ✨</span>
        </a>
        <button x-show="sidebarOpen" @click="mobileSidebarOpen = false" class="lg:hidden p-2 text-slate-400 hover:text-white hover:bg-slate-800/60 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-6 px-3 space-y-1 overflow-x-hidden">
        
        <div x-show="sidebarOpen" x-transition class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 px-3 whitespace-nowrap">Main</div>
        
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Dashboard">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-brand-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Dashboard') }}</span>
        </a>

        <!-- Activity Feed -->
        <a href="{{ route('activity') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('activity') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Activity Feed">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('activity') ? 'text-brand-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Activity Feed') }}</span>
        </a>

        <!-- Jobs -->
        <a href="{{ route('jobs.index') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('jobs.*') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Jobs">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('jobs.*') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Jobs') }}</span>
        </a>

        <!-- Resumes -->
        <a href="{{ route('resumes.index') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('resumes.*') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Resumes">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('resumes.*') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Resumes') }}</span>
        </a>

        <!-- Interviews -->
        <a href="{{ route('interviews.index') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('interviews.*') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Interviews">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('interviews.*') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Interviews') }}</span>
        </a>

        <!-- ATS Analyzer -->
        <a href="{{ route('ats.analyzer') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('ats.analyzer') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="ATS Analyzer">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('ats.analyzer') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('ATS Analyzer') }}</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('settings') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('settings') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Settings">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('settings') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Settings') }}</span>
        </a>

        @if(auth()->user()->is_admin)
        <div x-show="sidebarOpen" x-transition class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-8 px-3 whitespace-nowrap">System & Tools</div>
        <div x-show="!sidebarOpen" class="border-t border-slate-700/50 w-8 mx-auto my-4"></div>

        <!-- Automations Hub -->
        <a href="{{ route('automations') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('automations') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Automations">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('automations') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Automations') }}</span>
        </a>

        <!-- System Logs -->
        <a href="{{ route('logs') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('logs') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="System Logs">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('logs') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('System Logs') }}</span>
        </a>

        <!-- Queue Monitor -->
        <a href="{{ route('queue-monitor') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('queue-monitor') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Queue Monitor">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('queue-monitor') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Queue Monitor') }}</span>
        </a>

        <!-- Global Users -->
        <a href="{{ route('admin.users.index') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Global Users">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Global Users') }}</span>
        </a>

        <!-- Global Schedules -->
        <a href="{{ route('admin.schedules.index') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.schedules.*') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Global Schedules">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.schedules.*') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Global Schedules') }}</span>
        </a>

        <div x-show="sidebarOpen" x-transition class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-8 px-3 whitespace-nowrap">Documentation</div>
        <div x-show="!sidebarOpen" class="border-t border-slate-700/50 w-8 mx-auto my-4"></div>

        <!-- Developer Docs -->
        <a href="{{ route('developer-docs') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('developer-docs') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Developer Docs">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('developer-docs') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Developer Docs') }}</span>
        </a>

        <!-- Architecture -->
        <a href="{{ route('architecture') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('architecture') ? 'bg-gradient-to-r from-brand-500/20 to-transparent border-l-[3px] border-neon-cyan text-brand-100 font-bold shadow-[inset_4px_0_10px_rgba(34,211,238,0.15)]' : 'hover:bg-brand-900/40 hover:text-white text-slate-300 border-l-[3px] border-transparent hover:border-brand-500/50' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Architecture">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('architecture') ? 'text-neon-cyan filter drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]' : 'text-slate-400 group-hover:text-brand-300 group-hover:drop-shadow-[0_0_5px_rgba(167,139,250,0.5)]' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Architecture') }}</span>
        </a>
        @endif


    </div>

</aside>
