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
        'translate-x-0': mobileSidebarOpen,
        '-translate-x-full': !mobileSidebarOpen,
        'lg:translate-x-0 lg:w-72': sidebarOpen,
        'lg:translate-x-0 lg:w-20': !sidebarOpen
    }" 
    class="fixed inset-y-0 left-0 z-50 bg-slate-900 text-slate-300 transition-all duration-300 ease-in-out flex flex-col shadow-2xl lg:shadow-none border-r border-slate-800 lg:h-screen overflow-hidden group">
    
    <!-- Sidebar Header (Logo) -->
    <div class="flex items-center px-6 h-20 border-b border-slate-800/60 bg-slate-900/50" :class="{'justify-between': sidebarOpen, 'justify-center': !sidebarOpen}">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-indigo-500 rounded-xl flex flex-shrink-0 items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <span x-show="sidebarOpen" x-transition.opacity.duration.300ms class="text-xl font-bold text-white tracking-tight whitespace-nowrap">Job<span class="text-indigo-400">Auto</span></span>
        </a>
        <button x-show="sidebarOpen" @click="mobileSidebarOpen = false" class="lg:hidden p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-6 px-3 space-y-1 overflow-x-hidden">
        
        <div x-show="sidebarOpen" x-transition class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 px-3 whitespace-nowrap">Main</div>
        
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-500/10 text-indigo-400 font-semibold' : 'hover:bg-slate-800 hover:text-white' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Dashboard">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Dashboard') }}</span>
        </a>

        <!-- Activity Feed -->
        <a href="{{ route('activity') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('activity') ? 'bg-indigo-500/10 text-indigo-400 font-semibold' : 'hover:bg-slate-800 hover:text-white' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Activity Feed">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('activity') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Activity Feed') }}</span>
        </a>

        <!-- Jobs -->
        <a href="{{ route('jobs.index') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('jobs.*') ? 'bg-indigo-500/10 text-indigo-400 font-semibold' : 'hover:bg-slate-800 hover:text-white' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Jobs">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('jobs.*') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Jobs') }}</span>
        </a>

        <div x-show="sidebarOpen" x-transition class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-8 px-3 whitespace-nowrap">System & Tools</div>
        <div x-show="!sidebarOpen" class="border-t border-slate-700/50 w-8 mx-auto my-4"></div>

        <!-- Automations Hub -->
        <a href="{{ route('automations') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('automations') ? 'bg-indigo-500/10 text-indigo-400 font-semibold' : 'hover:bg-slate-800 hover:text-white' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Automations">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('automations') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Automations') }}</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('settings') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('settings') ? 'bg-indigo-500/10 text-indigo-400 font-semibold' : 'hover:bg-slate-800 hover:text-white' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Settings">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('settings') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Settings') }}</span>
        </a>

        <!-- Queue Monitor -->
        <a href="{{ route('queue-monitor') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('queue-monitor') ? 'bg-indigo-500/10 text-indigo-400 font-semibold' : 'hover:bg-slate-800 hover:text-white' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Queue Monitor">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('queue-monitor') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Queue Monitor') }}</span>
        </a>

        <div x-show="sidebarOpen" x-transition class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-8 px-3 whitespace-nowrap">Documentation</div>
        <div x-show="!sidebarOpen" class="border-t border-slate-700/50 w-8 mx-auto my-4"></div>

        <!-- Developer Docs -->
        <a href="{{ route('developer-docs') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('developer-docs') ? 'bg-indigo-500/10 text-indigo-400 font-semibold' : 'hover:bg-slate-800 hover:text-white' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Developer Docs">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('developer-docs') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Developer Docs') }}</span>
        </a>

        <!-- Architecture -->
        <a href="{{ route('architecture') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('architecture') ? 'bg-indigo-500/10 text-indigo-400 font-semibold' : 'hover:bg-slate-800 hover:text-white' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Architecture">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('architecture') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Architecture') }}</span>
        </a>

    </div>

    <!-- Bottom User Actions -->
    <div class="p-4 border-t border-slate-800/60 bg-slate-900/30">
        <!-- Profile -->
        <a href="{{ route('profile') }}" wire:navigate class="group flex items-center py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('profile') ? 'bg-indigo-500/10 text-indigo-400 font-semibold' : 'hover:bg-slate-800 hover:text-white' }}" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Profile">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('profile') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-white' }}" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Profile') }}</span>
        </a>

        <!-- Logout -->
        <button wire:click="logout" class="w-full group flex items-center py-2.5 rounded-xl transition-all duration-200 hover:bg-red-500/10 hover:text-red-400 text-slate-400 mt-1" :class="{'px-3': sidebarOpen, 'justify-center': !sidebarOpen}" title="Log Out">
            <svg class="w-5 h-5 flex-shrink-0 group-hover:text-red-400" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">{{ __('Log Out') }}</span>
        </button>
    </div>
</aside>
