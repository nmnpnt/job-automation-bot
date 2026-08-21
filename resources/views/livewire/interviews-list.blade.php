<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-slate-900/60 backdrop-blur-2xl p-6 md:p-8 rounded-[2rem] border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.5)] relative overflow-hidden transition-colors duration-500">
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500/20 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-neon-cyan/20 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl md:text-4xl font-black leading-9 text-white tracking-tight flex items-center drop-shadow-md">
                <div class="p-2.5 bg-brand-500/20 text-brand-400 rounded-2xl mr-5 shadow-[0_0_15px_rgba(139,92,246,0.3)] border border-brand-500/30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                Manage Interviews
            </h2>
            <p class="mt-2 text-sm text-slate-400 font-bold ml-16 max-w-2xl">Stay prepared for your upcoming technical and behavioral rounds.</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.5)] overflow-hidden transition-colors duration-500">
        <div class="overflow-x-auto relative">
            <table class="min-w-full divide-y divide-white/5">
                <thead class="bg-white/5 backdrop-blur-md">
                    <tr>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Job Role & Company</th>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Date & Time</th>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Interview Details</th>
                        <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th scope="col" class="px-6 py-5 text-right text-[11px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 bg-transparent transition-colors duration-500">
                    @forelse ($interviews as $interview)
                        <tr class="hover:bg-brand-500/10 transition-colors group border-b border-white/5">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <a href="{{ route('jobs.show', $interview->id) }}" wire:navigate class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shadow-inner shrink-0 group-hover:shadow-[0_0_15px_rgba(255,255,255,0.1)] transition-all">
                                        <span class="text-sm font-black text-white">{{ substr($interview->company_name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-[15px] font-black text-slate-200 group-hover:text-brand-300 transition-colors">{{ Str::limit($interview->job_title, 40) }}</div>
                                        <div class="text-sm font-bold text-slate-400 mt-1 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            {{ Str::limit($interview->company_name, 30) }}
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-4">
                                    <div class="p-2.5 rounded-xl border {{ \Carbon\Carbon::parse($interview->interview_scheduled_at)->isPast() && $interview->status->value !== 'INTERVIEW_COMPLETED' ? 'bg-amber-500/20 text-amber-400 border-amber-500/30 shadow-[0_0_10px_rgba(245,158,11,0.2)]' : 'bg-brand-500/20 text-brand-400 border-brand-500/30 shadow-[0_0_10px_rgba(139,92,246,0.2)]' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-[14px] font-black text-slate-200">
                                            {{ $interview->interview_scheduled_at ? $interview->interview_scheduled_at->format('M d, Y') : 'N/A' }}
                                        </div>
                                        <div class="text-[11px] font-bold text-slate-500 mt-1 uppercase tracking-widest">
                                            {{ $interview->interview_scheduled_at ? $interview->interview_scheduled_at->format('h:i A') : '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex flex-col gap-1.5">
                                    <span class="inline-flex items-center text-sm font-bold text-slate-300">
                                        <span class="w-2.5 h-2.5 rounded-full bg-neon-cyan mr-3 shadow-[0_0_5px_rgba(34,211,238,0.5)]"></span>
                                        {{ $interview->interview_type ?? 'Technical Interview' }}
                                    </span>
                                    <span class="text-[11px] font-black text-slate-500 ml-5 uppercase tracking-widest">{{ $interview->interview_round ?? 'Round 1' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($interview->status->value === 'INTERVIEW_COMPLETED')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black border bg-emerald-500/20 text-emerald-400 border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.2)] uppercase tracking-widest">
                                        <svg class="w-3.5 h-3.5 mr-1.5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black border bg-brand-500/20 text-brand-400 border-brand-500/30 shadow-[0_0_10px_rgba(139,92,246,0.2)] uppercase tracking-widest">
                                        <svg class="w-3.5 h-3.5 mr-1.5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Scheduled
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <!-- Join Link -->
                                    @if($interview->interview_meeting_link)
                                    <a href="{{ $interview->interview_meeting_link }}" target="_blank" class="inline-flex items-center px-4 py-2 rounded-xl bg-neon-cyan/20 text-neon-cyan hover:bg-neon-cyan/30 font-black uppercase tracking-widest text-[10px] transition-all shadow-[0_0_10px_rgba(34,211,238,0.2)] border border-neon-cyan/30 hover:shadow-[0_0_15px_rgba(34,211,238,0.4)] hover:scale-105" title="Join Meeting">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Join
                                    </a>
                                    @endif

                                    <!-- Edit -->
                                    <button wire:click="editInterview({{ $interview->id }})" wire:loading.attr="disabled" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white hover:bg-white/10 hover:border-white/20 transition-all shadow-sm" title="Edit Interview">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>

                                    <!-- Actions Dropdown -->
                                    <div class="relative ml-1" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white hover:bg-white/10 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                        </button>
                                        <div x-show="open" x-cloak class="absolute right-0 mt-2 w-56 rounded-2xl bg-slate-900/90 backdrop-blur-xl shadow-[0_10px_40px_rgba(0,0,0,0.8)] ring-1 ring-white/10 z-50 overflow-hidden p-2 border border-white/10">
                                            @if($interview->status->value !== 'INTERVIEW_COMPLETED')
                                            <button wire:click="markDone({{ $interview->id }})" class="w-full text-left px-4 py-2.5 text-[11px] uppercase tracking-widest font-black rounded-xl text-emerald-400 hover:bg-emerald-500/20 flex items-center transition-colors">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Mark Done
                                            </button>
                                            @endif
                                            
                                            <button wire:click="markRejected({{ $interview->id }})" class="w-full text-left px-4 py-2.5 text-[11px] uppercase tracking-widest font-black rounded-xl text-neon-pink hover:bg-neon-pink/20 flex items-center transition-colors">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Mark Rejected
                                            </button>
                                            
                                            <div class="h-px bg-white/10 my-2 mx-2"></div>

                                            <button x-data @click="if(confirm('Are you sure you want to cancel this interview? It will be moved back to the review stage.')) $wire.cancelInterview({{ $interview->id }})" class="w-full text-left px-4 py-2.5 text-[11px] uppercase tracking-widest font-black rounded-xl text-slate-400 hover:bg-white/5 hover:text-white flex items-center transition-colors">
                                                <svg class="w-4 h-4 mr-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Cancel Interview
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-24 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 bg-white/5 rounded-3xl flex items-center justify-center mb-6 border border-white/10 shadow-[0_0_30px_rgba(255,255,255,0.05)]">
                                        <span class="text-4xl animate-float" style="animation-delay: 0.5s;">📅</span>
                                    </div>
                                    <h3 class="text-xl font-black text-white tracking-wide">No active interviews</h3>
                                    <p class="mt-2 text-sm text-slate-400 font-bold max-w-sm mx-auto whitespace-normal">Interviews you schedule from your job details will appear here. Keep applying!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($interviews->hasPages())
        <div class="px-6 py-4 border-t border-white/10 bg-white/5 backdrop-blur-md">
            {{ $interviews->links(data: ['scrollTo' => false]) }}
        </div>
        @endif
    </div>

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
