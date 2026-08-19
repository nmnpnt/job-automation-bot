<div class="space-y-8 animate-fade-in-up">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between bg-white/60 backdrop-blur-xl p-6 rounded-3xl border border-slate-200/60 shadow-sm relative overflow-hidden transition-colors duration-500">
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500/20 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        
        <div class="min-w-0 flex-1 relative z-10">
            <h2 class="text-3xl font-extrabold leading-9 text-slate-900 tracking-tight flex items-center">
                <svg class="w-8 h-8 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Manage Interviews
            </h2>
            <p class="mt-1 text-sm text-slate-500 font-medium ml-11">Stay prepared for your upcoming technical and behavioral rounds.</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-sm overflow-hidden transition-colors duration-500">
        <div class="overflow-x-auto relative">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50/50 backdrop-blur-sm transition-colors duration-500">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Job Role & Company</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Interview Details</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-transparent transition-colors duration-500">
                    @forelse ($interviews as $interview)
                        <tr class="hover:bg-purple-50/30 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('jobs.show', $interview->id) }}" wire:navigate class="block">
                                    <div class="text-sm font-bold text-slate-900 group-hover:text-purple-600 transition-colors">{{ Str::limit($interview->job_title, 40) }}</div>
                                    <div class="text-xs font-semibold text-slate-500 mt-0.5">{{ Str::limit($interview->company_name, 30) }}</div>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="p-2 rounded-xl {{ \Carbon\Carbon::parse($interview->interview_scheduled_at)->isPast() ? 'bg-amber-100 text-amber-600' : 'bg-purple-100 text-purple-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-700">
                                            {{ $interview->interview_scheduled_at ? $interview->interview_scheduled_at->format('M d, Y') : 'N/A' }}
                                        </div>
                                        <div class="text-xs font-semibold text-slate-500">
                                            {{ $interview->interview_scheduled_at ? $interview->interview_scheduled_at->format('h:i A') : '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-700">{{ $interview->interview_type ?? 'Technical Interview' }}</span>
                                    <span class="text-xs text-slate-500">{{ $interview->interview_round ?? 'Round 1' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($interview->status->value === 'INTERVIEW_COMPLETED')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border bg-emerald-50 text-emerald-700 border-emerald-200">
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border bg-purple-50 text-purple-700 border-purple-200">
                                        Scheduled
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-1.5">
                                    <!-- Join Link -->
                                    @if($interview->interview_meeting_link)
                                    <a href="{{ $interview->interview_meeting_link }}" target="_blank" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-bold text-xs transition-colors shadow-sm border border-transparent" title="Join Meeting">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Join
                                    </a>
                                    @endif

                                    <!-- Edit -->
                                    <button wire:click="editInterview({{ $interview->id }})" wire:loading.attr="disabled" class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-50 text-slate-600 hover:bg-slate-200 transition-colors shadow-sm" title="Edit Interview">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>

                                    <!-- Actions Dropdown -->
                                    <div class="relative ml-1" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-50 text-slate-500 hover:bg-slate-200 transition-colors shadow-sm">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                        </button>
                                        <div x-show="open" x-cloak class="absolute right-0 mt-2 w-40 rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 z-50 overflow-hidden divide-y divide-slate-100">
                                            @if($interview->status->value !== 'INTERVIEW_COMPLETED')
                                            <button wire:click="markDone({{ $interview->id }})" class="w-full text-left px-4 py-2 text-sm text-emerald-700 hover:bg-emerald-50 flex items-center transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Mark Done
                                            </button>
                                            @endif
                                            
                                            <button wire:click="markRejected({{ $interview->id }})" class="w-full text-left px-4 py-2 text-sm text-rose-700 hover:bg-rose-50 flex items-center transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Mark Rejected
                                            </button>
                                            
                                            <button x-data @click="if(confirm('Are you sure you want to cancel this interview? It will be moved back to the review stage.')) $wire.cancelInterview({{ $interview->id }})" class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 flex items-center transition-colors">
                                                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Cancel Interview
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-900">No interviews scheduled</h3>
                                    <p class="mt-1 text-sm text-slate-500">Interviews you schedule from your jobs list will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($interviews->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
            {{ $interviews->links() }}
        </div>
        @endif
    </div>

    <!-- Edit Interview Modal -->
    <x-modal name="edit-interview-modal" focusable>
        <form wire:submit.prevent="saveInterview" class="p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-1 flex items-center">
                <div class="p-2 bg-purple-100 text-purple-600 rounded-xl mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
                Edit Interview
            </h2>
            <p class="text-xs text-slate-500 mb-5">Update the details for this scheduled interview.</p>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Interview Date & Time</label>
                    <input type="datetime-local" wire:model="interview_scheduled_at" required class="block w-full rounded-xl border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                    @error('interview_scheduled_at') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Interview Round</label>
                    <select wire:model="interview_round" required class="block w-full rounded-xl border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="Round 1">Round 1</option>
                        <option value="Round 2">Round 2</option>
                        <option value="Round 3">Round 3</option>
                        <option value="Final Round">Final Round</option>
                        <option value="Other">Other</option>
                    </select>
                    @error('interview_round') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Interview Format</label>
                    <select wire:model="interview_type" required class="block w-full rounded-xl border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="HR Phone Screen">HR Phone Screen</option>
                        <option value="Technical Interview">Technical Interview</option>
                        <option value="System Design">System Design</option>
                        <option value="Managerial / Behavioral">Managerial / Behavioral</option>
                        <option value="Take-home Assessment">Take-home Assessment</option>
                    </select>
                    @error('interview_type') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Meeting Link (Google Meet / Zoom / Teams)</label>
                    <input type="url" wire:model="interview_meeting_link" placeholder="https://meet.google.com/..." class="block w-full rounded-xl border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                    @error('interview_meeting_link') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Preparation Notes / Instructions</label>
                    <textarea wire:model="interview_notes" rows="3" placeholder="Topics to review, interviewer names, coding focus..." class="block w-full rounded-xl border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                    @error('interview_notes') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" x-on:click="$dispatch('close')" class="bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 border border-slate-300 rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" wire:loading.attr="disabled" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-5 py-2 text-sm font-bold rounded-xl shadow-md hover:from-purple-700 hover:to-indigo-700 transition-all flex items-center">
                    <span wire:loading.remove wire:target="saveInterview">Save Changes</span>
                    <span wire:loading wire:target="saveInterview">Saving...</span>
                </button>
            </div>
        </form>
    </x-modal>
</div>
