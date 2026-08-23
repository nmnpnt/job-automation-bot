<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\ScrapingSchedule;

new #[Layout('layouts.app')] class extends Component {
    use WithPagination;

    public $statusFilter = '';

    public function with()
    {
        return [
            'schedules' => ScrapingSchedule::with('user')
                ->when($this->statusFilter !== '', function ($query) {
                    $query->where('is_active', $this->statusFilter === 'active');
                })
                ->orderBy('next_run_at', 'asc')
                ->paginate(20)
        ];
    }
    
    public function toggleActive($scheduleId)
    {
        $schedule = ScrapingSchedule::find($scheduleId);
        if ($schedule) {
            $schedule->is_active = !$schedule->is_active;
            $schedule->save();
        }
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
            <div class="absolute top-0 right-0 w-96 h-96 bg-neon-pink/10 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-blob mix-blend-screen"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-500/10 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none animate-blob mix-blend-screen" style="animation-delay: 2s;"></div>
            
            <h2 class="relative z-10 text-3xl font-black text-white uppercase tracking-widest drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                {{ __('Global Schedules') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 animate-fade-in-up">
            
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-widest">Automation Queue</h3>
                    <p class="text-sm text-slate-400 mt-1 font-bold">Monitor and manage all user scraping schedules.</p>
                </div>
                <div class="flex space-x-3 w-1/4">
                    <select wire:model.live="statusFilter" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-2 text-white text-sm font-bold shadow-sm focus:border-neon-cyan focus:ring-neon-cyan">
                        <option value="" class="bg-slate-900">All Statuses</option>
                        <option value="active" class="bg-slate-900">Active Only</option>
                        <option value="paused" class="bg-slate-900">Paused Only</option>
                    </select>
                </div>
            </div>

            <!-- Schedules Table -->
            <div class="bg-black/40 backdrop-blur-2xl rounded-[2rem] hud-border shadow-[0_5px_20px_rgba(0,0,0,0.3)] overflow-hidden relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-neon-pink/20 via-brand-500/20 to-neon-cyan/20 blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 pointer-events-none"></div>
                <div class="relative w-full h-full bg-black/40">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/5">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">User</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Frequency</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Time / TZ</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Next Run</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-black text-slate-400 uppercase tracking-widest">Toggle</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 bg-transparent">
                        @forelse ($schedules as $schedule)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 flex-shrink-0 rounded-full bg-gradient-to-br from-brand-600 to-neon-pink flex items-center justify-center text-white text-xs font-bold shadow-[0_0_10px_rgba(255,42,133,0.3)]">
                                            {{ substr($schedule->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <a href="{{ route('admin.users.show', $schedule->user) }}" class="text-sm font-bold text-white hover:text-neon-cyan transition-colors">{{ $schedule->user->name }}</a>
                                            <div class="text-[10px] text-slate-400 font-medium">{{ $schedule->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300 font-bold">
                                    {{ ucfirst($schedule->frequency) }}
                                    @if($schedule->frequency === 'weekly' && is_array($schedule->days))
                                        <div class="text-[10px] text-slate-500 mt-1 font-medium">{{ implode(', ', array_map(fn($d) => substr($d,0,3), $schedule->days)) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-white font-bold">{{ $schedule->time }}</div>
                                    <div class="text-[10px] text-slate-400 font-medium">{{ $schedule->timezone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold {{ $schedule->next_run_at && $schedule->next_run_at->isPast() ? 'text-rose-400' : 'text-neon-cyan' }}">
                                        {{ $schedule->next_run_at ? $schedule->next_run_at->diffForHumans() : 'N/A' }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-medium mt-1">
                                        {{ $schedule->next_run_at ? $schedule->next_run_at->format('M j, H:i') : '' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center rounded-md {{ $schedule->is_active ? 'bg-emerald-500/10 text-emerald-400 ring-emerald-500/20' : 'bg-slate-500/10 text-slate-400 ring-slate-500/20' }} px-2 py-1 text-[10px] font-black uppercase tracking-widest ring-1 ring-inset">
                                        {{ $schedule->is_active ? 'Active' : 'Paused' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button wire:click="toggleActive('{{ $schedule->id }}')" class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $schedule->is_active ? 'bg-emerald-500' : 'bg-slate-700' }}">
                                        <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $schedule->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-bold">
                                    No schedules found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-white/10 bg-white/5">
                    {{ $schedules->links() }}
                </div>
                </div>
            </div>

        </div>
    </div>
</div>
