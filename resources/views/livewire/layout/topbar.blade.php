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
    
    public function markAllRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function clearNotification($id): void
    {
        auth()->user()->unreadNotifications()->where('id', $id)->first()?->markAsRead();
    }
}; ?>

<div class="flex items-center gap-4">
    <!-- Notification Bell -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" @click.outside="open = false" class="relative flex items-center justify-center w-10 h-10 text-slate-300 hover:text-neon-cyan hover:bg-slate-800/60 hover:shadow-[0_0_10px_rgba(34,211,238,0.3)] rounded-xl transition-all duration-300 border border-transparent hover:border-neon-cyan/30" title="Notifications">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute top-1.5 right-1.5 inline-flex items-center justify-center min-w-[1.125rem] h-[1.125rem] px-1 text-[10px] font-bold leading-none text-white bg-neon-pink border border-slate-900 rounded-full shadow-[0_0_8px_rgba(244,114,182,0.8)] animate-pulse">{{ auth()->user()->unreadNotifications->count() }}</span>
            @endif
        </button>

        <!-- Dropdown -->
        <div x-show="open" x-transition.opacity style="display: none;" class="fixed left-4 right-4 top-16 sm:absolute sm:inset-auto sm:right-0 sm:mt-2 sm:w-96 bg-slate-900/90 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] z-50 overflow-hidden origin-top sm:origin-top-right">
            <div class="px-4 py-3 bg-gradient-to-r from-brand-900/50 to-transparent border-b border-white/10 flex justify-between items-center gap-4">
                <h3 class="text-sm font-black text-white bg-clip-text text-transparent bg-gradient-to-r from-brand-400 to-neon-cyan">Notifications</h3>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <button wire:click="markAllRead" class="text-xs text-brand-400 hover:text-neon-cyan font-bold whitespace-nowrap transition-colors">Mark all as read</button>
                @endif
            </div>
            <div class="max-h-96 overflow-y-auto custom-scrollbar">
                @forelse(auth()->user()->unreadNotifications as $notification)
                    <div class="px-4 py-3 border-b border-white/5 hover:bg-slate-800/60 transition-colors flex justify-between items-start gap-3 group">
                        <div class="flex-1">
                            <p class="text-sm text-slate-300 font-medium">{!! $notification->data['message'] ?? 'New notification' !!}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        <button wire:click="clearNotification('{{ $notification->id }}')" class="opacity-0 group-hover:opacity-100 p-1 text-slate-500 hover:text-neon-pink hover:bg-neon-pink/10 rounded-lg transition-all" title="Clear">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @empty
                    <div class="px-4 py-8 flex flex-col items-center text-center">
                        <span class="text-3xl mb-2">✨</span>
                        <p class="text-sm text-slate-500 font-medium">You're all caught up!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Profile -->
    <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 text-sm font-bold text-slate-300 hover:text-brand-400 hover:bg-slate-800/60 hover:shadow-[0_0_10px_rgba(139,92,246,0.2)] rounded-xl transition-all duration-300 border border-transparent hover:border-brand-500/30">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        <span class="hidden sm:inline">{{ __('Profile') }}</span>
    </a>

    <!-- Logout -->
    <button wire:click="logout" class="flex items-center gap-2 px-3 py-2 text-sm font-bold text-slate-300 hover:text-neon-pink hover:bg-neon-pink/10 hover:shadow-[0_0_10px_rgba(244,114,182,0.2)] rounded-xl transition-all duration-300 border border-transparent hover:border-neon-pink/30" title="Log Out">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
        <span class="hidden sm:inline">{{ __('Log Out') }}</span>
    </button>
</div>
