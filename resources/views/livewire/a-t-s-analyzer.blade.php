<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                {{ __('ATS Resume Analyzer') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Setup Column -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white/70 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-3xl border border-white/50 p-6 relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-50/50 to-accent-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center">
                            <div class="p-1.5 bg-brand-100 text-brand-600 rounded-lg mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            Analysis Setup
                        </h3>
                        
                        <form wire:submit.prevent="analyze" class="space-y-6">
                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl relative overflow-hidden">
                                <div class="absolute right-0 top-0 w-24 h-24 bg-brand-500/5 rounded-bl-full -mr-4 -mt-4"></div>
                                <h4 class="text-sm font-bold text-slate-700 mb-1 flex items-center relative z-10">
                                    <svg class="w-4 h-4 mr-1.5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Resume Source
                                </h4>
                                <p class="text-xs text-slate-500 relative z-10 leading-relaxed mt-2">Your resume will be automatically pulled from your <a href="{{ route('profile') }}" class="text-brand-600 font-bold hover:underline">Profile</a>. If you haven't uploaded one, it uses your default from the <a href="{{ route('resumes.index') }}" class="text-brand-600 font-bold hover:underline">AI Builder</a>.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Job Source</label>
                                <div class="flex flex-col space-y-3 mb-4">
                                    <label class="relative flex items-center p-3 border rounded-xl cursor-pointer transition-all hover:bg-slate-50 {{ $mode === 'job_id' ? 'border-brand-500 bg-brand-50' : 'border-slate-200' }}">
                                        <input type="radio" wire:model.live="mode" value="job_id" class="sr-only">
                                        <div class="flex items-center justify-center w-5 h-5 rounded-full border-2 mr-3 {{ $mode === 'job_id' ? 'border-brand-500' : 'border-slate-300' }}">
                                            @if($mode === 'job_id') <div class="w-2.5 h-2.5 rounded-full bg-brand-500"></div> @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $mode === 'job_id' ? 'text-brand-700' : 'text-slate-600' }}">Saved Job</span>
                                    </label>
                                    <label class="relative flex items-center p-3 border rounded-xl cursor-pointer transition-all hover:bg-slate-50 {{ $mode === 'manual' ? 'border-brand-500 bg-brand-50' : 'border-slate-200' }}">
                                        <input type="radio" wire:model.live="mode" value="manual" class="sr-only">
                                        <div class="flex items-center justify-center w-5 h-5 rounded-full border-2 mr-3 {{ $mode === 'manual' ? 'border-brand-500' : 'border-slate-300' }}">
                                            @if($mode === 'manual') <div class="w-2.5 h-2.5 rounded-full bg-brand-500"></div> @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $mode === 'manual' ? 'text-brand-700' : 'text-slate-600' }}">Paste JD</span>
                                    </label>
                                    <label class="relative flex items-center p-3 border rounded-xl cursor-pointer transition-all hover:bg-slate-50 {{ $mode === 'none' ? 'border-brand-500 bg-brand-50' : 'border-slate-200' }}">
                                        <input type="radio" wire:model.live="mode" value="none" class="sr-only">
                                        <div class="flex items-center justify-center w-5 h-5 rounded-full border-2 mr-3 {{ $mode === 'none' ? 'border-brand-500' : 'border-slate-300' }}">
                                            @if($mode === 'none') <div class="w-2.5 h-2.5 rounded-full bg-brand-500"></div> @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $mode === 'none' ? 'text-brand-700' : 'text-slate-600' }}">General Review (No Job)</span>
                                    </label>
                                </div>

                                @if($mode === 'job_id')
                                    <select wire:model="jobId" class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm font-medium">
                                        <option value="">-- Select a saved job --</option>
                                        @foreach($jobs as $job)
                                            <option value="{{ $job->id }}">{{ $job->job_title }} at {{ $job->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('jobId') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                @elseif($mode === 'manual')
                                    <textarea wire:model="jobDescription" rows="5" class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm placeholder-slate-400" placeholder="Paste the job description here..."></textarea>
                                    @error('jobDescription') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                @endif
                            </div>

                            <div class="pt-2">
                                <button type="submit" wire:loading.attr="disabled" class="w-full bg-gradient-to-r from-accent-600 to-brand-600 hover:from-accent-700 hover:to-brand-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-brand-500/30 inline-flex items-center justify-center transition-all disabled:opacity-70 disabled:cursor-wait">
                                    <svg wire:loading.remove wire:target="analyze" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    <svg wire:loading wire:target="analyze" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4V2m0 20v-2m8-8h2M2 12h2m15.364-6.364l1.414-1.414M4.222 19.778l1.414-1.414m12.728 12.728l-1.414-1.414M4.222 4.222l1.414 1.414"></path></svg>
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
                    <div class="bg-white/70 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-3xl border border-white/50 p-10 flex flex-col items-center justify-center text-center h-full min-h-[400px]">
                        <div class="relative mb-8">
                            <div class="absolute inset-0 bg-brand-500 rounded-full blur-xl opacity-30 animate-pulse"></div>
                            <svg class="animate-spin h-16 w-16 text-brand-600 relative z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <p class="text-2xl font-black text-slate-800 tracking-tight">AI is analyzing your resume...</p>
                        <p class="text-sm font-medium text-slate-500 mt-2">Checking keywords, matching skills, and evaluating ATS compatibility.</p>
                    </div>
                @elseif($analysisResult)
                    <!-- Score Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white/70 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-3xl border border-white/50 p-6 relative group">
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center">
                                <div class="w-2 h-2 rounded-full bg-brand-500 mr-2"></div>
                                Overall ATS Score
                            </h4>
                            <div class="flex justify-center mb-2">
                                <div class="relative w-36 h-36">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                        <!-- Background Circle -->
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8" class="text-slate-100"></circle>
                                        <!-- Progress Circle -->
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8" 
                                                stroke-linecap="round"
                                                class="{{ $analysisResult['ats_score'] >= 80 ? 'text-emerald-500' : ($analysisResult['ats_score'] >= 50 ? 'text-amber-500' : 'text-rose-500') }} transition-all duration-1000 ease-out" 
                                                stroke-dasharray="283" 
                                                stroke-dashoffset="{{ 283 - (283 * $analysisResult['ats_score']) / 100 }}"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center flex-col shadow-inner rounded-full m-4 bg-white/50">
                                        <span class="text-4xl font-black text-slate-800">{{ $analysisResult['ats_score'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $analysisResult['ats_score'] >= 80 ? 'bg-emerald-100 text-emerald-700' : ($analysisResult['ats_score'] >= 50 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                    {{ $analysisResult['ats_score'] >= 80 ? 'Excellent Match' : ($analysisResult['ats_score'] >= 50 ? 'Good Potential' : 'Needs Improvement') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="bg-white/70 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-3xl border border-white/50 p-6 relative group">
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center">
                                <div class="w-2 h-2 rounded-full bg-accent-500 mr-2"></div>
                                Keyword Match
                            </h4>
                            <div class="flex justify-center mb-2">
                                <div class="relative w-36 h-36">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                        <!-- Background Circle -->
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8" class="text-slate-100"></circle>
                                        <!-- Progress Circle -->
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8" 
                                                stroke-linecap="round"
                                                class="{{ $analysisResult['keyword_match_score'] >= 80 ? 'text-emerald-500' : ($analysisResult['keyword_match_score'] >= 50 ? 'text-amber-500' : 'text-rose-500') }} transition-all duration-1000 ease-out" 
                                                stroke-dasharray="283" 
                                                stroke-dashoffset="{{ 283 - (283 * $analysisResult['keyword_match_score']) / 100 }}"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center flex-col shadow-inner rounded-full m-4 bg-white/50">
                                        <span class="text-4xl font-black text-slate-800">{{ $analysisResult['keyword_match_score'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $analysisResult['keyword_match_score'] >= 80 ? 'bg-emerald-100 text-emerald-700' : ($analysisResult['keyword_match_score'] >= 50 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                    {{ $analysisResult['keyword_match_score'] >= 80 ? 'Highly Relevant' : ($analysisResult['keyword_match_score'] >= 50 ? 'Partially Relevant' : 'Low Relevance') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="bg-white/70 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-3xl border border-white/50 p-6 md:p-8 space-y-8">
                        <div>
                            <h4 class="text-lg font-black text-slate-900 mb-4 flex items-center">
                                <div class="p-1.5 bg-rose-100 text-rose-600 rounded-lg mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                Missing Keywords
                            </h4>
                            @if(count($analysisResult['missing_keywords']) > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($analysisResult['missing_keywords'] as $keyword)
                                        <span class="px-3 py-1.5 bg-rose-50 text-rose-700 text-sm font-semibold rounded-xl border border-rose-100">
                                            {{ $keyword }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex items-center p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-emerald-700 font-semibold text-sm">Great job! No major missing keywords identified.</p>
                                </div>
                            @endif
                        </div>

                        <div class="h-px bg-slate-200"></div>

                        <div>
                            <h4 class="text-lg font-black text-slate-900 mb-4 flex items-center">
                                <div class="p-1.5 bg-amber-100 text-amber-600 rounded-lg mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                </div>
                                Suggestions for Improvement
                            </h4>
                            @if(count($analysisResult['suggestions']) > 0)
                                <ul class="space-y-4">
                                    @foreach($analysisResult['suggestions'] as $suggestion)
                                        <li class="flex items-start bg-amber-50/50 p-4 rounded-2xl border border-amber-100/50">
                                            <div class="p-1 bg-amber-100 text-amber-600 rounded-lg mr-3 shrink-0 mt-0.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            </div>
                                            <span class="text-slate-700 font-medium text-sm leading-relaxed">{{ $suggestion }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="flex items-center p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-emerald-700 font-semibold text-sm">Your resume looks perfect for this role.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-white/50 backdrop-blur-sm overflow-hidden shadow-sm sm:rounded-3xl border-2 border-dashed border-slate-300 p-10 text-center text-slate-500 h-full min-h-[400px] flex flex-col justify-center items-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <p class="text-xl font-black text-slate-800 tracking-tight mb-2">Awaiting Analysis</p>
                        <p class="text-sm font-medium text-slate-500 max-w-sm mx-auto">Select a resume and job description to see how well you match.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
