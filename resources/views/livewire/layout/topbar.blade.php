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

<div class="flex items-center gap-4">
    <!-- Notification Bell -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" @click.outside="open = false" class="relative flex items-center gap-2 px-3 py-2 text-sm font-semibold text-slate-700 hover:text-indigo-600 hover:bg-slate-100 rounded-xl transition-colors" title="Notifications">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute top-1 right-2 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ auth()->user()->unreadNotifications->count() }}</span>
            @endif
        </button>

        <!-- Dropdown -->
        <div x-show="open" x-transition.opacity style="display: none;" class="absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 overflow-hidden">
            <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-sm font-bold text-slate-800">Notifications</h3>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <button wire:click="$refresh" onclick="fetch('{{ route('notifications.markAllRead') }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}}).then(() => Livewire.dispatch('$refresh'))" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">Mark all as read</button>
                @endif
            </div>
            <div class="max-h-96 overflow-y-auto">
                @forelse(auth()->user()->unreadNotifications as $notification)
                    <div class="px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition-colors">
                        <p class="text-sm text-slate-700 font-medium">{!! $notification->data['message'] ?? 'New notification' !!}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="px-4 py-6 text-center text-sm text-slate-500">
                        No new notifications.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Profile -->
    <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-slate-700 hover:text-indigo-600 hover:bg-slate-100 rounded-xl transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        <span class="hidden sm:inline">{{ __('Profile') }}</span>
    </a>

    <!-- Logout -->
    <button wire:click="logout" class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-slate-700 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Log Out">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
        <span class="hidden sm:inline">{{ __('Log Out') }}</span>
    </button>
</div>
