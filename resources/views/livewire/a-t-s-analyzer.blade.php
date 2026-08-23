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
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                {{ __('ATS Resume Analyzer') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-6 animate-fade-in-up">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Setup Column -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-slate-900/60 backdrop-blur-2xl overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] hud-border p-6 relative group transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-500/10 to-neon-cyan/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-white tracking-wide mb-6 flex items-center">
                            <div class="p-2 bg-brand-500/20 text-brand-400 rounded-xl mr-3 shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            Analysis Setup
                        </h3>
                        
                        <form wire:submit.prevent="analyze" class="space-y-6">
                            <div class="p-5 bg-white/5 border border-white/10 rounded-2xl relative overflow-hidden group/card hover:border-white/20 transition-colors">
                                <div class="absolute right-0 top-0 w-32 h-32 bg-neon-cyan/10 rounded-bl-full -mr-10 -mt-10 blur-xl"></div>
                                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center relative z-10">
                                    <svg class="w-4 h-4 mr-2 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Resume Source
                                </h4>
                                <p class="text-[13px] text-slate-300 relative z-10 leading-relaxed font-bold">Your resume will be automatically pulled from your <a href="{{ route('profile') }}" class="text-neon-cyan hover:text-cyan-300 transition-colors">Profile</a>. If missing, it uses your default from the <a href="{{ route('resumes.index') }}" class="text-neon-cyan hover:text-cyan-300 transition-colors">AI Builder</a>.</p>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Job Source</label>
                                <div class="flex flex-col space-y-3 mb-5">
                                    <label class="relative flex items-center p-3 border rounded-xl cursor-pointer transition-all {{ $mode === 'job_id' ? 'border-brand-500 bg-brand-500/10 shadow-[0_0_15px_rgba(139,92,246,0.2)]' : 'border-white/10 hover:bg-white/5' }}">
                                        <input type="radio" wire:model.live="mode" value="job_id" class="sr-only">
                                        <div class="flex items-center justify-center w-5 h-5 rounded-full border-2 mr-3 {{ $mode === 'job_id' ? 'border-brand-500' : 'border-slate-500' }}">
                                            @if($mode === 'job_id') <div class="w-2.5 h-2.5 rounded-full bg-brand-500 shadow-[0_0_8px_rgba(139,92,246,0.8)]"></div> @endif
                                        </div>
                                        <span class="text-sm font-black tracking-wide {{ $mode === 'job_id' ? 'text-white' : 'text-slate-400' }}">Saved Job</span>
                                    </label>
                                    <label class="relative flex items-center p-3 border rounded-xl cursor-pointer transition-all {{ $mode === 'manual' ? 'border-brand-500 bg-brand-500/10 shadow-[0_0_15px_rgba(139,92,246,0.2)]' : 'border-white/10 hover:bg-white/5' }}">
                                        <input type="radio" wire:model.live="mode" value="manual" class="sr-only">
                                        <div class="flex items-center justify-center w-5 h-5 rounded-full border-2 mr-3 {{ $mode === 'manual' ? 'border-brand-500' : 'border-slate-500' }}">
                                            @if($mode === 'manual') <div class="w-2.5 h-2.5 rounded-full bg-brand-500 shadow-[0_0_8px_rgba(139,92,246,0.8)]"></div> @endif
                                        </div>
                                        <span class="text-sm font-black tracking-wide {{ $mode === 'manual' ? 'text-white' : 'text-slate-400' }}">Paste JD</span>
                                    </label>
                                    <label class="relative flex items-center p-3 border rounded-xl cursor-pointer transition-all {{ $mode === 'none' ? 'border-brand-500 bg-brand-500/10 shadow-[0_0_15px_rgba(139,92,246,0.2)]' : 'border-white/10 hover:bg-white/5' }}">
                                        <input type="radio" wire:model.live="mode" value="none" class="sr-only">
                                        <div class="flex items-center justify-center w-5 h-5 rounded-full border-2 mr-3 {{ $mode === 'none' ? 'border-brand-500' : 'border-slate-500' }}">
                                            @if($mode === 'none') <div class="w-2.5 h-2.5 rounded-full bg-brand-500 shadow-[0_0_8px_rgba(139,92,246,0.8)]"></div> @endif
                                        </div>
                                        <span class="text-sm font-black tracking-wide {{ $mode === 'none' ? 'text-white' : 'text-slate-400' }}">General Review (No Job)</span>
                                    </label>
                                </div>

                                @if($mode === 'job_id')
                                    <select wire:model="jobId" class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 shadow-inner transition-colors cursor-pointer text-sm font-bold">
                                        <option value="" class="bg-slate-800 text-slate-400">-- Select a saved job --</option>
                                        @foreach($jobs as $job)
                                            <option value="{{ $job->id }}" class="bg-slate-800">{{ $job->job_title }} at {{ $job->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('jobId') <span class="text-neon-pink text-xs mt-2 block font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                                @elseif($mode === 'manual')
                                    <textarea wire:model="jobDescription" rows="5" class="block w-full rounded-xl bg-slate-800/50 border border-white/10 text-white placeholder-slate-500 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 shadow-inner transition-colors text-sm font-bold" placeholder="Paste the job description here..."></textarea>
                                    @error('jobDescription') <span class="text-neon-pink text-xs mt-2 block font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                                @endif
                            </div>

                            <div class="pt-4">
                                <button type="submit" wire:loading.attr="disabled" class="w-full bg-gradient-to-r from-brand-600 to-neon-cyan/80 hover:from-brand-500 hover:to-neon-cyan text-white font-black py-4 px-4 rounded-xl shadow-[0_0_20px_rgba(139,92,246,0.4)] hover:shadow-[0_0_30px_rgba(34,211,238,0.5)] uppercase tracking-widest text-xs transition-all disabled:opacity-70 disabled:cursor-wait flex items-center justify-center">
                                    <svg wire:loading.remove wire:target="analyze" class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    <svg wire:loading wire:target="analyze" class="animate-spin w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4V2m0 20v-2m8-8h2M2 12h2m15.364-6.364l1.414-1.414M4.222 19.778l1.414-1.414m12.728 12.728l-1.414-1.414M4.222 4.222l1.414 1.414"></path></svg>
                                    <span wire:loading.remove wire:target="analyze">Run Analysis</span>
                                    <span wire:loading wire:target="analyze">Analyzing...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Results Column -->
            <div class="lg:col-span-2 space-y-6">
                @if($isAnalyzing)
                    <div class="bg-slate-900/60 backdrop-blur-2xl overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] hud-border p-10 flex flex-col items-center justify-center text-center h-full min-h-[500px] relative">
                        <div class="absolute inset-0 bg-brand-500/10 rounded-[2rem] animate-pulse pointer-events-none"></div>
                        <div class="relative z-10 flex flex-col items-center">
                            <!-- AI Mascot Avatar -->
                            <div class="w-32 h-32 rounded-full mb-8 relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-brand-500 to-neon-cyan rounded-full blur-xl opacity-50 animate-pulse"></div>
                                <img src="{{ asset('images/ai-mascot.jpg') }}" alt="AI Assistant" class="w-full h-full object-cover rounded-full border-4 border-slate-900 shadow-[0_0_30px_rgba(139,92,246,0.6)] relative z-10 animate-float">
                                <!-- Scanning Line -->
                                <div class="absolute top-0 left-0 right-0 h-1 bg-neon-cyan/80 z-20 shadow-[0_0_10px_rgba(34,211,238,1)] animate-scan rounded-full"></div>
                            </div>

                            <p class="text-3xl font-black text-white tracking-tight drop-shadow-md">Aria is scanning...</p>
                            <p class="text-[13px] font-bold text-brand-300 mt-3 max-w-md uppercase tracking-widest">Checking keywords, matching skills, and evaluating ATS compatibility across systems.</p>
                        </div>
                    </div>
                @elseif($analysisResult)
                    <!-- Mascot Message -->
                    <div class="bg-slate-900/60 backdrop-blur-2xl rounded-3xl hud-border p-6 flex items-start gap-5 shadow-[0_10px_40px_rgba(0,0,0,0.5)]">
                        <div class="w-16 h-16 rounded-full shrink-0 relative">
                            <div class="absolute inset-0 bg-brand-500/50 rounded-full blur-md"></div>
                            <img src="{{ asset('images/ai-mascot.jpg') }}" alt="Aria" class="w-full h-full object-cover rounded-full border-2 border-brand-400 relative z-10">
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-black text-white tracking-wide flex items-center gap-2">
                                Aria <span class="px-2 py-0.5 rounded-full bg-brand-500/20 text-[10px] text-brand-400 uppercase tracking-widest border border-brand-500/30">AI Assistant</span>
                            </h4>
                            <p class="text-sm text-slate-300 mt-2 font-bold leading-relaxed">
                                I've finished scanning your resume against the provided criteria. Check out the match score below and review my suggestions to optimize your ATS visibility!
                            </p>
                        </div>
                    </div>

                    <!-- Score Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-slate-900/60 backdrop-blur-2xl overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] hud-border p-6 relative group transition-all duration-500">
                            <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center drop-shadow-md">
                                <div class="w-2.5 h-2.5 rounded-full bg-brand-500 mr-3 shadow-[0_0_8px_rgba(139,92,246,0.8)]"></div>
                                Overall ATS Score
                            </h4>
                            <div class="flex justify-center mb-2">
                                <div class="relative w-40 h-40">
                                    <svg class="w-full h-full transform -rotate-90 drop-shadow-[0_0_10px_rgba(255,255,255,0.1)]" viewBox="0 0 100 100">
                                        <!-- Background Circle -->
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8" class="text-white/5"></circle>
                                        <!-- Progress Circle -->
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8" 
                                                stroke-linecap="round"
                                                class="{{ $analysisResult['ats_score'] >= 80 ? 'text-neon-cyan' : ($analysisResult['ats_score'] >= 50 ? 'text-amber-400' : 'text-neon-pink') }} transition-all duration-1000 ease-out" 
                                                style="filter: drop-shadow(0 0 8px currentColor);"
                                                stroke-dasharray="283" 
                                                stroke-dashoffset="{{ 283 - (283 * $analysisResult['ats_score']) / 100 }}"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center flex-col rounded-full m-5 bg-slate-900 border border-white/5 shadow-inner">
                                        <span class="text-4xl font-black text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]">{{ $analysisResult['ats_score'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] uppercase tracking-widest font-black {{ $analysisResult['ats_score'] >= 80 ? 'bg-neon-cyan/20 text-neon-cyan border border-neon-cyan/30 shadow-[0_0_15px_rgba(34,211,238,0.3)]' : ($analysisResult['ats_score'] >= 50 ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30 shadow-[0_0_15px_rgba(245,158,11,0.2)]' : 'bg-neon-pink/20 text-neon-pink border border-neon-pink/30 shadow-[0_0_15px_rgba(255,42,133,0.3)]') }}">
                                    {{ $analysisResult['ats_score'] >= 80 ? 'Excellent Match' : ($analysisResult['ats_score'] >= 50 ? 'Good Potential' : 'Needs Improvement') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="bg-slate-900/60 backdrop-blur-2xl overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] hud-border p-6 relative group transition-all duration-500">
                            <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center drop-shadow-md">
                                <div class="w-2.5 h-2.5 rounded-full bg-neon-cyan mr-3 shadow-[0_0_8px_rgba(34,211,238,0.8)]"></div>
                                Keyword Match
                            </h4>
                            <div class="flex justify-center mb-2">
                                <div class="relative w-40 h-40">
                                    <svg class="w-full h-full transform -rotate-90 drop-shadow-[0_0_10px_rgba(255,255,255,0.1)]" viewBox="0 0 100 100">
                                        <!-- Background Circle -->
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8" class="text-white/5"></circle>
                                        <!-- Progress Circle -->
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8" 
                                                stroke-linecap="round"
                                                class="{{ $analysisResult['keyword_match_score'] >= 80 ? 'text-neon-cyan' : ($analysisResult['keyword_match_score'] >= 50 ? 'text-amber-400' : 'text-neon-pink') }} transition-all duration-1000 ease-out" 
                                                style="filter: drop-shadow(0 0 8px currentColor);"
                                                stroke-dasharray="283" 
                                                stroke-dashoffset="{{ 283 - (283 * $analysisResult['keyword_match_score']) / 100 }}"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center flex-col rounded-full m-5 bg-slate-900 border border-white/5 shadow-inner">
                                        <span class="text-4xl font-black text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]">{{ $analysisResult['keyword_match_score'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] uppercase tracking-widest font-black {{ $analysisResult['keyword_match_score'] >= 80 ? 'bg-neon-cyan/20 text-neon-cyan border border-neon-cyan/30 shadow-[0_0_15px_rgba(34,211,238,0.3)]' : ($analysisResult['keyword_match_score'] >= 50 ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30 shadow-[0_0_15px_rgba(245,158,11,0.2)]' : 'bg-neon-pink/20 text-neon-pink border border-neon-pink/30 shadow-[0_0_15px_rgba(255,42,133,0.3)]') }}">
                                    {{ $analysisResult['keyword_match_score'] >= 80 ? 'Highly Relevant' : ($analysisResult['keyword_match_score'] >= 50 ? 'Partially Relevant' : 'Low Relevance') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="bg-slate-900/60 backdrop-blur-2xl overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] hud-border p-6 md:p-8 space-y-10 relative">
                        <!-- Neon decoration -->
                        <div class="absolute right-0 top-0 w-64 h-64 bg-brand-500/10 rounded-bl-full -mr-20 -mt-20 blur-3xl pointer-events-none"></div>

                        <div class="relative z-10">
                            <h4 class="text-xl font-black text-white mb-6 flex items-center drop-shadow-md">
                                <div class="p-2 bg-neon-pink/20 text-neon-pink rounded-xl mr-4 shadow-[0_0_15px_rgba(255,42,133,0.3)] border border-neon-pink/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                Missing Keywords
                            </h4>
                            @if(count($analysisResult['missing_keywords']) > 0)
                                <div class="flex flex-wrap gap-3">
                                    @foreach($analysisResult['missing_keywords'] as $keyword)
                                        <span class="px-4 py-2 bg-neon-pink/10 text-neon-pink text-xs font-black uppercase tracking-widest rounded-xl border border-neon-pink/20 shadow-[0_0_10px_rgba(255,42,133,0.1)] hover:shadow-[0_0_20px_rgba(255,42,133,0.3)] hover:scale-105 transition-all cursor-default">
                                            {{ $keyword }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex items-center p-5 bg-neon-cyan/10 rounded-2xl border border-neon-cyan/30 shadow-[0_0_15px_rgba(34,211,238,0.1)]">
                                    <svg class="w-6 h-6 text-neon-cyan mr-3 drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-neon-cyan font-black text-sm uppercase tracking-wide">Great job! No major missing keywords identified.</p>
                                </div>
                            @endif
                        </div>

                        <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent relative z-10"></div>

                        <div class="relative z-10">
                            <h4 class="text-xl font-black text-white mb-6 flex items-center drop-shadow-md">
                                <div class="p-2 bg-amber-500/20 text-amber-400 rounded-xl mr-4 shadow-[0_0_15px_rgba(245,158,11,0.3)] border border-amber-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                </div>
                                Suggestions for Improvement
                            </h4>
                            @if(count($analysisResult['suggestions']) > 0)
                                <ul class="space-y-4">
                                    @foreach($analysisResult['suggestions'] as $suggestion)
                                        <li class="flex items-start bg-white/5 p-5 rounded-2xl border border-white/10 hover:border-amber-500/30 hover:bg-amber-500/5 transition-all group shadow-sm">
                                            <div class="p-1.5 bg-amber-500/20 text-amber-400 rounded-lg mr-4 shrink-0 mt-0.5 group-hover:shadow-[0_0_10px_rgba(245,158,11,0.5)] transition-shadow">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            </div>
                                            <span class="text-slate-300 font-bold text-[14px] leading-relaxed">{{ $suggestion }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="flex items-center p-5 bg-neon-cyan/10 rounded-2xl border border-neon-cyan/30 shadow-[0_0_15px_rgba(34,211,238,0.1)]">
                                    <svg class="w-6 h-6 text-neon-cyan mr-3 drop-shadow-[0_0_8px_rgba(34,211,238,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-neon-cyan font-black text-sm uppercase tracking-wide">Your resume looks perfect for this role.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-slate-900/60 backdrop-blur-2xl overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[2rem] hud-border p-10 text-center flex flex-col justify-center items-center h-full min-h-[500px] relative group transition-colors duration-500">
                        <div class="absolute inset-0 bg-brand-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                        <div class="relative z-10 flex flex-col items-center">
                            <!-- Inactive Mascot avatar -->
                            <div class="w-24 h-24 rounded-full mb-6 bg-slate-800 border-4 border-slate-700 relative flex items-center justify-center shadow-inner overflow-hidden">
                                <img src="{{ asset('images/ai-mascot.jpg') }}" alt="Aria" class="w-full h-full object-cover opacity-30 grayscale group-hover:grayscale-0 group-hover:opacity-80 transition-all duration-700">
                            </div>
                            
                            <p class="text-2xl font-black text-white tracking-tight mb-3 drop-shadow-md">Awaiting Instructions</p>
                            <p class="text-[13px] font-bold text-slate-400 max-w-sm mx-auto uppercase tracking-widest leading-relaxed">Select a resume and job description on the left to initiate the ATS scan sequence.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
