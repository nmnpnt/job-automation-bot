<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-slate-900/60 backdrop-blur-2xl p-6 md:p-8 rounded-[2rem] border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.5)] relative overflow-hidden transition-colors duration-500 hud-border">
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500/20 rounded-full blur-[100px] -mr-32 -mt-32 pointer-events-none animate-pulse-glow"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-neon-cyan/20 rounded-full blur-[100px] -ml-32 -mb-32 pointer-events-none animate-pulse-glow" style="animation-delay: 2s;"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl md:text-4xl font-black leading-9 text-white tracking-tight flex items-center drop-shadow-md">
                <div class="p-2.5 bg-brand-500/20 text-brand-400 rounded-2xl mr-5 shadow-[0_0_20px_rgba(139,92,246,0.4)] border border-brand-500/30">
                    <svg class="w-8 h-8 drop-shadow-[0_0_8px_rgba(139,92,246,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                Manage Interviews
            </h2>
            <p class="mt-2 text-sm text-slate-400 font-bold ml-16 max-w-2xl drop-shadow-md">Stay prepared for your upcoming technical and behavioral rounds.</p>
        </div>
    </div>

    <!-- Kanban Board Section -->
    <div x-data="{
            scrollLeft() { $refs.board.scrollBy({ left: -364, behavior: 'smooth' }); },
            scrollRight() { $refs.board.scrollBy({ left: 364, behavior: 'smooth' }); }
        }" 
        class="relative group/board w-full h-[calc(100vh-16rem)] min-h-[400px]"
    >
        <!-- Scroll Left Button -->
        <button @click="scrollLeft" 
                class="hidden md:flex absolute -left-4 top-1/2 -translate-y-1/2 z-40 bg-slate-800/90 text-white p-4 rounded-full backdrop-blur-2xl border border-white/20 shadow-[0_10px_40px_rgba(0,0,0,0.8)] opacity-0 group-hover/board:opacity-100 transition-all hover:bg-brand-500 hover:shadow-[0_0_30px_rgba(139,92,246,0.6)] hover:scale-110 items-center justify-center focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Scrollable Container -->
        <div x-ref="board" class="flex gap-6 overflow-x-auto pb-4 custom-scrollbar w-full h-full" style="scroll-padding-inline: 1rem;">
            @php
            $columns = [
                'APPLIED' => ['title' => 'Applied', 'color' => 'brand-500', 'glow' => 'rgba(139,92,246,0.5)', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                'INTERVIEW_REQUESTED' => ['title' => 'Requested', 'color' => 'amber-400', 'glow' => 'rgba(251,191,36,0.5)', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                'INTERVIEW_COMPLETED' => ['title' => 'Completed', 'color' => 'neon-cyan', 'glow' => 'rgba(34,211,238,0.5)', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                'OFFER_RECEIVED' => ['title' => 'Offer', 'color' => 'emerald-400', 'glow' => 'rgba(52,211,153,0.5)', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                'REJECTED' => ['title' => 'Rejected', 'color' => 'neon-pink', 'glow' => 'rgba(244,114,182,0.5)', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
            $statuses = array_keys($columns);
        @endphp

        @foreach($columns as $status => $col)
            <div class="flex-none w-[340px] flex flex-col h-full">
                <!-- Column Header -->
                <div class="bg-slate-900/90 backdrop-blur-2xl rounded-2xl border border-white/10 p-4 mb-5 shadow-[0_10px_20px_rgba(0,0,0,0.4)] sticky top-0 z-10 flex items-center justify-between group overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-{{ $col['color'] }}/10 to-transparent opacity-50"></div>
                    <div class="absolute bottom-0 left-0 h-[2px] w-full bg-{{ $col['color'] }} shadow-[0_0_10px_{{ $col['glow'] }}]"></div>
                    <div class="flex items-center gap-3 relative z-10">
                        <div class="p-2 rounded-xl bg-{{ $col['color'] }}/20 text-{{ $col['color'] }} shadow-[0_0_15px_{{ $col['glow'] }}] border border-{{ $col['color'] }}/30 transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5 drop-shadow-[0_0_5px_{{ $col['glow'] }}]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $col['icon'] }}"></path></svg>
                        </div>
                        <h3 class="text-[13px] font-black text-white uppercase tracking-widest drop-shadow-md">{{ $col['title'] }}</h3>
                    </div>
                    <span class="bg-{{ $col['color'] }}/20 text-{{ $col['color'] }} border border-{{ $col['color'] }}/30 shadow-[0_0_10px_{{ $col['glow'] }}] text-[11px] font-black px-2.5 py-1 rounded-xl relative z-10">{{ count($kanbanBoard[$status] ?? []) }}</span>
                </div>

                <!-- Column Cards -->
                <div class="flex-1 space-y-4 overflow-y-auto pr-2 custom-scrollbar pb-48 min-h-[300px]">
                    @forelse($kanbanBoard[$status] ?? [] as $job)
                        <div x-data="{ open: false }" :class="open ? 'z-50' : 'z-10'" class="bg-slate-900/60 backdrop-blur-2xl border border-white/10 rounded-[1.5rem] p-5 shadow-[0_10px_30px_rgba(0,0,0,0.3)] hover:shadow-[0_10px_40px_{{ $col['glow'] }}] group/card hover:-translate-y-1 transition-all duration-300 relative">
                            <!-- Inner glow on hover -->
                            <div class="absolute inset-0 rounded-[1.5rem] bg-gradient-to-br from-{{ $col['color'] }}/10 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                            
                            <div class="relative z-10">
                                <div class="flex justify-between items-start mb-4">
                                    <a href="{{ route('jobs.show', $job->id) }}" wire:navigate class="font-black text-white text-[15px] hover:text-{{ $col['color'] }} transition-colors line-clamp-2 leading-tight drop-shadow-md">
                                        {{ $job->job_title }}
                                    </a>
                                    <!-- Actions Dropdown -->
                                    <div class="relative ml-3 shrink-0">
                                        <button @click="open = !open" @click.away="open = false" class="p-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 text-slate-400 hover:text-white transition-all shadow-inner">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                        </button>
                                        <div x-show="open" x-cloak x-transition.opacity class="absolute right-0 mt-2 w-48 rounded-2xl bg-slate-900/90 backdrop-blur-2xl border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.5)] z-50 overflow-hidden py-2 hud-border">
                                            <div class="px-4 py-2 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-white/5 mb-2">Move to:</div>
                                            @foreach($statuses as $s)
                                                @if($s !== $status)
                                                    <button wire:click="changeStatus({{ $job->id }}, '{{ $s }}')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-300 hover:bg-brand-500/20 hover:text-brand-300 transition-colors flex items-center">
                                                        <div class="w-2 h-2 rounded-full bg-{{ $columns[$s]['color'] }} mr-3 shadow-[0_0_8px_{{ $columns[$s]['glow'] }}]"></div>
                                                        {{ $columns[$s]['title'] }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-[13px] font-bold text-slate-400 flex items-center gap-2 mb-5">
                                    <div class="p-1.5 rounded-lg bg-white/5 border border-white/10">
                                        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <span class="truncate">{{ $job->company_name }}</span>
                                </div>

                                @if(in_array($status, ['INTERVIEW_REQUESTED', 'INTERVIEW_COMPLETED']))
                                    <div class="bg-black/40 border border-white/10 rounded-2xl p-4 mb-4 shadow-inner group-hover/card:border-{{ $col['color'] }}/30 transition-colors">
                                        <div class="text-[10px] uppercase font-black text-slate-500 tracking-widest mb-1.5 flex items-center">
                                            <svg class="w-3 h-3 mr-1.5 text-{{ $col['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            Interview Date
                                        </div>
                                        <div class="text-sm font-black text-white drop-shadow-md">
                                            {{ $job->interview_scheduled_at ? $job->interview_scheduled_at->format('M d, Y h:i A') : 'Not scheduled' }}
                                        </div>
                                        <div class="mt-3 flex gap-2 border-t border-white/10 pt-3">
                                            <button wire:click="editInterview({{ $job->id }})" class="flex-1 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl py-1.5 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:text-white transition-all text-center">Edit</button>
                                            @if($job->interview_meeting_link)
                                                <a href="{{ $job->interview_meeting_link }}" target="_blank" class="flex-1 bg-neon-cyan/20 hover:bg-neon-cyan/30 border border-neon-cyan/30 rounded-xl py-1.5 text-[10px] font-black uppercase tracking-widest text-neon-cyan hover:text-cyan-300 shadow-[0_0_10px_rgba(34,211,238,0.3)] transition-all text-center">Join</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between pt-2 border-t border-white/5">
                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $job->updated_at->diffForHumans(null, true, true) }}
                                    </span>
                                    @if($job->match_score)
                                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-black border {{ $job->match_score >= 80 ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.3)]' : ($job->match_score >= 50 ? 'bg-amber-500/20 text-amber-400 border-amber-500/30 shadow-[0_0_10px_rgba(245,158,11,0.3)]' : 'bg-rose-500/20 text-rose-400 border-rose-500/30 shadow-[0_0_10px_rgba(244,63,94,0.3)]') }}">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            {{ $job->match_score }}% Match
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="border border-dashed border-white/20 rounded-[1.5rem] p-8 flex flex-col items-center justify-center text-center opacity-60 bg-white/5">
                            <div class="p-3 bg-white/5 rounded-2xl mb-3 border border-white/10">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest drop-shadow-md">No Apps</span>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
        </div>

        <!-- Scroll Right Button -->
        <button @click="scrollRight" 
                class="hidden md:flex absolute -right-4 top-1/2 -translate-y-1/2 z-40 bg-slate-800/90 text-white p-4 rounded-full backdrop-blur-2xl border border-white/20 shadow-[0_10px_40px_rgba(0,0,0,0.8)] opacity-0 group-hover/board:opacity-100 transition-all hover:bg-brand-500 hover:shadow-[0_0_30px_rgba(139,92,246,0.6)] hover:scale-110 items-center justify-center focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05); 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2); 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3); 
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <!-- Edit Interview Modal -->
    <x-modal name="edit-interview-modal" focusable>
        <form wire:submit.prevent="saveInterview" class="p-8 bg-slate-900 text-slate-200">
            <h2 class="text-2xl font-black text-white tracking-wide mb-2 flex items-center">
                <div class="p-2 bg-brand-500/20 text-brand-400 rounded-xl mr-4 border border-brand-500/30 shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
                Edit Interview
            </h2>
            <p class="text-xs font-bold text-slate-400 mb-8 ml-14">Update the details for this scheduled interview.</p>
            
            <div class="space-y-5">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Date & Time</label>
                    <input type="datetime-local" wire:model="interview_scheduled_at" required class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 shadow-inner transition-colors">
                    @error('interview_scheduled_at') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Round</label>
                    <select wire:model="interview_round" required class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 shadow-inner transition-colors cursor-pointer">
                        <option value="Round 1" class="bg-slate-800">Round 1</option>
                        <option value="Round 2" class="bg-slate-800">Round 2</option>
                        <option value="Round 3" class="bg-slate-800">Round 3</option>
                        <option value="Final Round" class="bg-slate-800">Final Round</option>
                        <option value="Other" class="bg-slate-800">Other</option>
                    </select>
                    @error('interview_round') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Format</label>
                    <select wire:model="interview_type" required class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 shadow-inner transition-colors cursor-pointer">
                        <option value="HR Phone Screen" class="bg-slate-800">HR Phone Screen</option>
                        <option value="Technical Interview" class="bg-slate-800">Technical Interview</option>
                        <option value="System Design" class="bg-slate-800">System Design</option>
                        <option value="Managerial / Behavioral" class="bg-slate-800">Managerial / Behavioral</option>
                        <option value="Take-home Assessment" class="bg-slate-800">Take-home Assessment</option>
                    </select>
                    @error('interview_type') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Meeting Link</label>
                    <input type="url" wire:model="interview_meeting_link" placeholder="https://meet.google.com/..." class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white placeholder-slate-600 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 shadow-inner transition-colors">
                    @error('interview_meeting_link') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Preparation Notes</label>
                    <textarea wire:model="interview_notes" rows="3" placeholder="Topics to review..." class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white placeholder-slate-600 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 shadow-inner transition-colors"></textarea>
                    @error('interview_notes') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <button type="button" x-on:click="$dispatch('close')" class="bg-white/5 px-5 py-2.5 text-xs font-black uppercase tracking-widest text-slate-300 hover:bg-white/10 border border-white/10 rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" wire:loading.attr="disabled" class="bg-brand-500 text-white px-6 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl shadow-[0_0_20px_rgba(139,92,246,0.4)] hover:shadow-[0_0_30px_rgba(139,92,246,0.6)] hover:bg-brand-400 transition-all flex items-center">
                    <span wire:loading.remove wire:target="saveInterview">Save Changes</span>
                    <span wire:loading wire:target="saveInterview">Saving...</span>
                </button>
            </div>
        </form>
    </x-modal>
</div>
