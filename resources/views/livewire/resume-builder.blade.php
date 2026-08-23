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
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-white tracking-wide flex items-center gap-3 drop-shadow-md">
                <div class="p-2 bg-brand-500/20 text-brand-400 rounded-xl border border-brand-500/30 shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                {{ __('Resume Builder') }} <span class="text-slate-400 font-bold mx-2">|</span> <span class="text-neon-cyan drop-shadow-[0_0_8px_rgba(34,211,238,0.5)]">{{ $resume->title }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Toolbar -->
        <div class="bg-slate-900/60 backdrop-blur-2xl rounded-[2rem] hud-border p-6 flex justify-between items-center shadow-[0_10px_30px_rgba(0,0,0,0.3)]">
            <div>
                <h3 class="text-xl font-black text-white tracking-wide">Resume Sections</h3>
                <p class="text-sm text-slate-400 font-bold mt-1">Manage the content of your resume.</p>
            </div>
            <div>
                <button wire:click="exportPdf" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-neon-pink to-rose-500 hover:from-rose-500 hover:to-rose-400 px-5 py-2.5 text-xs font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(255,42,133,0.4)] transition-all duration-300 group border border-neon-pink/50">
                    <svg wire:loading.remove wire:target="exportPdf" class="w-4 h-4 mr-2 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <svg wire:loading wire:target="exportPdf" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4V2m0 20v-2m8-8h2M2 12h2m15.364-6.364l1.414-1.414M4.222 19.778l1.414-1.414m12.728 12.728l-1.414-1.414M4.222 4.222l1.414 1.414"></path></svg>
                    Export PDF
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Add Section Form -->
            <div class="bg-black/40 backdrop-blur-xl rounded-[2rem] hud-border p-6 md:col-span-1 h-fit shadow-[inset_0_2px_10px_rgba(0,0,0,0.2)]">
                <h4 class="font-black text-lg text-white mb-6 uppercase tracking-wider flex items-center">
                    <svg class="w-5 h-5 mr-2 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add Section
                </h4>
                
                <form wire:submit.prevent="addSection" class="space-y-5">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Section Type</label>
                        <select wire:model="newSectionType" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200 font-bold">
                            <option value="SUMMARY">Summary</option>
                            <option value="EXPERIENCE">Experience</option>
                            <option value="EDUCATION">Education</option>
                            <option value="SKILLS">Skills</option>
                            <option value="PROJECTS">Projects</option>
                            <option value="CERTIFICATIONS">Certifications</option>
                            <option value="CUSTOM">Custom</option>
                        </select>
                        @error('newSectionType') <span class="text-neon-pink text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Title</label>
                        <input type="text" wire:model="newSectionTitle" placeholder="e.g. Work Experience" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                        @error('newSectionTitle') <span class="text-neon-pink text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    @if(in_array($newSectionType, ['SUMMARY', 'CUSTOM']))
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Content</label>
                            <textarea wire:model="newSectionContent.text" rows="4" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200" placeholder="Enter content..."></textarea>
                        </div>
                    @elseif(in_array($newSectionType, ['EXPERIENCE', 'PROJECTS']))
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">{{ $newSectionType === 'EXPERIENCE' ? 'Company Name' : 'Project Name' }}</label>
                                <input type="text" wire:model="newSectionContent.company" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Role / Title</label>
                                <input type="text" wire:model="newSectionContent.role" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Start Date</label>
                                <input type="text" wire:model="newSectionContent.start_date" placeholder="e.g. Jan 2020" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">End Date</label>
                                <input type="text" wire:model="newSectionContent.end_date" placeholder="e.g. Present" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Description</label>
                                <textarea wire:model="newSectionContent.description" rows="4" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200" placeholder="Describe your responsibilities..."></textarea>
                            </div>
                        </div>
                    @elseif($newSectionType === 'EDUCATION')
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Institution</label>
                                <input type="text" wire:model="newSectionContent.institution" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Degree / Major</label>
                                <input type="text" wire:model="newSectionContent.degree" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Start Date</label>
                                <input type="text" wire:model="newSectionContent.start_date" placeholder="e.g. Sep 2016" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">End Date</label>
                                <input type="text" wire:model="newSectionContent.end_date" placeholder="e.g. May 2020" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Description (Optional)</label>
                                <textarea wire:model="newSectionContent.description" rows="3" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200"></textarea>
                            </div>
                        </div>
                    @elseif($newSectionType === 'SKILLS')
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Skills (Comma separated)</label>
                            <input type="text" wire:model="newSectionContent.skills" placeholder="e.g. JavaScript, PHP, Laravel, TailwindCSS" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                        </div>
                    @elseif($newSectionType === 'CERTIFICATIONS')
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Certification Name</label>
                                <input type="text" wire:model="newSectionContent.name" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Issuer</label>
                                <input type="text" wire:model="newSectionContent.issuer" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Date</label>
                                <input type="text" wire:model="newSectionContent.date" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200">
                            </div>
                        </div>
                    @endif
                    
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Order</label>
                        <input type="number" wire:model="newSectionOrder" class="block w-24 rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 focus:bg-black sm:text-sm transition-all duration-200 font-bold">
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-neon-cyan/80 hover:from-brand-500 hover:to-neon-cyan px-5 py-3 text-xs font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(139,92,246,0.4)] transition-all duration-300 group border border-brand-400/30">
                        Add Section
                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Sections List -->
            <div class="md:col-span-2 space-y-4">
                @forelse($sections as $section)
                    <div class="bg-slate-900/40 backdrop-blur-md rounded-2xl hud-border p-6 relative group hover:shadow-[0_0_20px_rgba(139,92,246,0.15)] transition-all duration-300">
                        <div class="absolute inset-0 bg-brand-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none rounded-2xl"></div>
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                            <button wire:click="deleteSection({{ $section->id }})" class="p-2 bg-rose-500/20 text-rose-400 hover:bg-rose-500 hover:text-white rounded-lg transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                        
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 bg-brand-500/20 border border-brand-500/30 text-brand-300 text-[10px] font-black uppercase tracking-widest rounded-lg shadow-[0_0_10px_rgba(139,92,246,0.2)]">
                                {{ $section->type }}
                            </span>
                            <span class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Order: {{ $section->order_index }}</span>
                        </div>
                        
                        <h4 class="text-xl font-black text-white mb-3 tracking-wide">{{ $section->title }}</h4>
                        
                        <div class="prose prose-sm prose-invert max-w-none text-slate-300 font-medium leading-relaxed">
                            @if(in_array($section->type, ['SUMMARY', 'CUSTOM']) && isset($section->content['text']))
                                {!! nl2br(e($section->content['text'])) !!}
                            @elseif(in_array($section->type, ['EXPERIENCE', 'PROJECTS']) && isset($section->content['company']))
                                <div class="mb-2 text-lg">
                                    <span class="text-neon-cyan font-bold">{{ $section->content['role'] ?? '' }}</span> 
                                    <span class="text-slate-500 mx-1">at</span> 
                                    <span class="text-white font-bold">{{ $section->content['company'] }}</span>
                                </div>
                                <div class="text-xs font-bold text-brand-300 mb-3 tracking-wider uppercase">
                                    {{ $section->content['start_date'] ?? '' }} <span class="mx-1">&mdash;</span> {{ $section->content['end_date'] ?? '' }}
                                </div>
                                <div class="pl-4 border-l-2 border-brand-500/30 text-slate-300">{!! nl2br(e($section->content['description'] ?? '')) !!}</div>
                            @elseif($section->type === 'EDUCATION' && isset($section->content['institution']))
                                <div class="mb-2 text-lg">
                                    <span class="text-neon-cyan font-bold">{{ $section->content['degree'] ?? '' }}</span>
                                </div>
                                <div class="text-base text-white font-bold mb-1">{{ $section->content['institution'] }}</div>
                                <div class="text-xs font-bold text-brand-300 mb-3 tracking-wider uppercase">
                                    {{ $section->content['start_date'] ?? '' }} <span class="mx-1">&mdash;</span> {{ $section->content['end_date'] ?? '' }}
                                </div>
                                <div class="pl-4 border-l-2 border-brand-500/30 text-slate-300">{!! nl2br(e($section->content['description'] ?? '')) !!}</div>
                            @elseif($section->type === 'SKILLS' && isset($section->content['skills']))
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach(explode(',', $section->content['skills']) as $skill)
                                        <span class="px-3 py-1.5 bg-white/5 border border-white/10 rounded-lg text-sm font-bold text-slate-200">{{ trim($skill) }}</span>
                                    @endforeach
                                </div>
                            @elseif($section->type === 'CERTIFICATIONS' && isset($section->content['name']))
                                <div class="mb-1 text-lg"><span class="text-neon-cyan font-bold">{{ $section->content['name'] }}</span></div>
                                <div class="text-base text-white mb-1">{{ $section->content['issuer'] ?? '' }}</div>
                                <div class="text-xs font-bold text-brand-300 tracking-wider uppercase">{{ $section->content['date'] ?? '' }}</div>
                            @else
                                <pre class="text-xs bg-black/50 p-4 rounded-xl border border-white/5 text-neon-pink font-mono overflow-x-auto">{{ json_encode($section->content, JSON_PRETTY_PRINT) }}</pre>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-black/20 rounded-[2rem] hud-border p-12 flex flex-col items-center justify-center text-center shadow-inner">
                        <div class="w-20 h-20 bg-white/5 border border-white/10 rounded-full flex items-center justify-center mb-6 shadow-[inset_0_2px_10px_rgba(0,0,0,0.3)] relative">
                            <div class="absolute inset-0 bg-brand-500/20 rounded-full blur-md"></div>
                            <svg class="w-10 h-10 text-slate-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-white tracking-wide mb-2">No Sections Added</h3>
                        <p class="text-sm font-bold text-slate-400 max-w-sm">Your resume is currently empty. Start building it by adding sections from the left panel.</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>
</div>
