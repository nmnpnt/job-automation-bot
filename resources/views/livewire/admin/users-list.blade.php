<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;

new #[Layout('layouts.app')] class extends Component {
    use WithPagination;

    public $search = '';

    public function with()
    {
        return [
            'users' => User::withCount(['scrapingJobs', 'scrapingSchedules'])
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(15)
        ];
    }
}; ?>

<style>
    .hud-border {
        position: relative;
    }
    .hud-border::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        border-radius: inherit;
        padding: 1px;
        background: linear-gradient(135deg, rgba(139,92,246,0.5), rgba(34,211,238,0.5), rgba(244,114,182,0.5));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }
</style>
<div>
    <x-slot name="header">
        <div class="relative bg-white/5 backdrop-blur-2xl p-6 rounded-[2rem] hud-border shadow-[0_10px_40px_rgba(0,0,0,0.2)] overflow-hidden">
            <!-- Animated Background Blobs -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-neon-cyan/10 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-blob mix-blend-screen"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-500/10 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none animate-blob mix-blend-screen" style="animation-delay: 2s;"></div>
            
            <h2 class="relative z-10 text-3xl font-black text-white uppercase tracking-widest drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                {{ __('Users Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 animate-fade-in-up">
            
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-widest">Global Users</h3>
                    <p class="text-sm text-slate-400 mt-1 font-bold">Manage users and view their automation stats.</p>
                </div>
                <div class="flex space-x-3 w-1/3">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or email..." class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-2 text-white text-sm font-bold shadow-sm focus:border-neon-cyan focus:ring-neon-cyan">
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-black/40 backdrop-blur-2xl rounded-[2rem] hud-border shadow-[0_5px_20px_rgba(0,0,0,0.3)] overflow-hidden relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-neon-cyan/20 via-brand-500/20 to-neon-pink/20 blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 pointer-events-none"></div>
                <div class="relative w-full h-full bg-black/40">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/5">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">User</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Email</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-black text-slate-400 uppercase tracking-widest">Schedules</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-black text-slate-400 uppercase tracking-widest">Jobs Run</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Joined</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-black text-slate-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 bg-transparent">
                        @forelse ($users as $user)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gradient-to-br from-brand-600 to-neon-pink flex items-center justify-center text-white font-bold shadow-[0_0_15px_rgba(255,42,133,0.3)]">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-white">{{ $user->name }}</div>
                                            @if($user->is_admin)
                                                <span class="inline-flex items-center rounded-md bg-rose-500/10 px-2 py-0.5 text-[10px] font-black uppercase text-rose-400 ring-1 ring-inset ring-rose-500/20">Admin</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-300 font-medium">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center rounded-md {{ $user->scraping_schedules_count > 0 ? 'bg-emerald-500/10 text-emerald-400 ring-emerald-500/20' : 'bg-slate-500/10 text-slate-400 ring-slate-500/20' }} px-2 py-1 text-xs font-black ring-1 ring-inset">
                                        {{ $user->scraping_schedules_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm font-bold text-white">{{ number_format($user->scraping_jobs_count) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400 font-medium">
                                    {{ $user->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center justify-center rounded-xl border border-neon-cyan/50 bg-gradient-to-r from-neon-cyan to-blue-500 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-white shadow-[0_0_10px_rgba(34,211,238,0.4)] hover:shadow-[0_0_20px_rgba(34,211,238,0.6)] transition-all duration-300">
                                        Dashboard
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-bold">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-white/10 bg-white/5">
                    {{ $users->links() }}
                </div>
                </div>
            </div>

        </div>
    </div>
</div>
