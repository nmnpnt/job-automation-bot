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
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('My Resumes') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-6">
        
        <div class="bg-slate-900/60 backdrop-blur-xl overflow-hidden shadow-[0_0_15px_rgba(0,0,0,0.5)] sm:rounded-2xl hud-border p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-xl font-black text-white">Manage Your Resumes</h3>
                <p class="text-sm text-slate-400">Create tailored resumes for different types of jobs.</p>
            </div>
            
            <form wire:submit.prevent="createResume" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <input type="text" wire:model="newResumeTitle" placeholder="e.g. Frontend Developer" class="bg-slate-800/50 rounded-xl border border-white/10 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-white sm:text-sm flex-1 placeholder-slate-500 min-w-0">
                <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-2 px-4 rounded-xl whitespace-nowrap transition-colors shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                    Create Resume
                </button>
            </form>
            @error('newResumeTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        @if($profile && $profile->resume_path)
        <div class="bg-slate-900/60 backdrop-blur-xl hud-border shadow-[0_0_15px_rgba(0,0,0,0.5)] rounded-2xl p-6 flex flex-col md:flex-row justify-between items-center mb-6 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-brand-500/10 rounded-full blur-2xl"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="bg-brand-500/20 p-3 rounded-xl text-brand-400 border border-brand-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-black text-white">Uploaded Resume (From Profile)</h4>
                    <p class="text-sm text-slate-400">This resume will be used as a fallback if no specific AI resume is selected.</p>
                </div>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3 relative z-10">
                <a href="{{ route('resume.view') }}" target="_blank" class="text-brand-300 bg-brand-500/10 border border-brand-500/30 hover:bg-brand-500/20 hover:text-white font-bold py-2 px-4 rounded-xl transition-colors text-sm shadow-[0_0_10px_rgba(139,92,246,0.2)]">
                    View Uploaded Resume
                </a>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($resumes as $resume)
                <div class="bg-slate-900/60 backdrop-blur-xl overflow-hidden shadow-[0_0_15px_rgba(0,0,0,0.5)] sm:rounded-2xl hud-border flex flex-col hover:shadow-[0_0_20px_rgba(139,92,246,0.3)] transition-all group">
                    <div class="p-6 flex-1 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-20 h-20 bg-brand-500/5 rounded-full blur-xl group-hover:bg-brand-500/10 transition-colors"></div>
                        <div class="flex justify-between items-start mb-4 relative z-10">
                            <h4 class="text-xl font-black text-white line-clamp-2">{{ $resume->name }}</h4>
                            @if($resume->is_default)
                                <span class="px-2 py-1 bg-brand-500/20 text-brand-300 border border-brand-500/30 text-[10px] uppercase font-black tracking-widest rounded-full whitespace-nowrap shadow-[0_0_10px_rgba(139,92,246,0.2)]">Default</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-400 mb-4 relative z-10 font-bold">Last updated {{ $resume->updated_at->diffForHumans() }}</p>
                        <p class="text-xs text-slate-500 relative z-10">{{ $resume->sections()->count() }} sections</p>
                    </div>
                    <div class="bg-white/5 px-6 py-4 border-t border-white/10 flex justify-between items-center group-hover:bg-brand-900/20 transition-colors">
                        <a href="{{ route('resumes.builder', $resume->id) }}" wire:navigate class="text-brand-400 hover:text-brand-300 font-bold text-sm">
                            Edit Resume
                        </a>
                        <button wire:click="deleteResume({{ $resume->id }})" class="text-neon-pink/70 hover:text-neon-pink" title="Delete">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-slate-900/60 backdrop-blur-xl overflow-hidden shadow-[0_0_15px_rgba(0,0,0,0.5)] sm:rounded-2xl p-10 text-center hud-border">
                    <svg class="w-12 h-12 mx-auto text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-lg font-black text-white mb-1">No resumes found</p>
                    <p class="text-slate-400 font-medium">Create your first resume to get started.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
