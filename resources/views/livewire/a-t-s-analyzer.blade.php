<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ATS Resume Analyzer') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Setup Column -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Analysis Setup</h3>
                    
                    <form wire:submit.prevent="analyze" class="space-y-4">
                        
                        <div class="mb-6 p-4 bg-slate-50 border border-slate-200 rounded-lg">
                            <h4 class="text-sm font-bold text-slate-700 mb-1 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Resume Source
                            </h4>
                            <p class="text-xs text-slate-500">Your resume will be automatically pulled from your <a href="{{ route('profile') }}" class="text-indigo-600 font-semibold hover:underline">Profile</a>. If you haven't uploaded one, it will use your default resume from the <a href="{{ route('resumes.index') }}" class="text-indigo-600 font-semibold hover:underline">AI Builder</a>.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Job Source</label>
                            <div class="flex flex-wrap gap-4 mb-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" wire:model.live="mode" value="job_id" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">Saved Job</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" wire:model.live="mode" value="manual" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">Paste JD</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" wire:model.live="mode" value="none" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">General Review (No Job)</span>
                                </label>
                            </div>

                            @if($mode === 'job_id')
                                <select wire:model="jobId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Select a saved job --</option>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->id }}">{{ $job->job_title }} at {{ $job->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('jobId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @elseif($mode === 'manual')
                                <textarea wire:model="jobDescription" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Paste job description here..."></textarea>
                                @error('jobDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @endif
                        </div>

                        <div class="pt-2">
                            <button type="submit" wire:loading.attr="disabled" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded inline-flex items-center justify-center transition-colors">
                                <svg wire:loading.remove wire:target="analyze" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                <svg wire:loading wire:target="analyze" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4V2m0 20v-2m8-8h2M2 12h2m15.364-6.364l1.414-1.414M4.222 19.778l1.414-1.414m12.728 12.728l-1.414-1.414M4.222 4.222l1.414 1.414"></path></svg>
                                <span wire:loading.remove wire:target="analyze">Run Analysis</span>
                                <span wire:loading wire:target="analyze">Analyzing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Column -->
            <div class="lg:col-span-2 space-y-6">
                @if($isAnalyzing)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col items-center justify-center text-center h-full min-h-[300px]">
                        <svg class="animate-spin h-10 w-10 text-indigo-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-lg font-medium text-gray-900">AI is analyzing your resume...</p>
                        <p class="text-sm text-gray-500">Checking keywords, skills, and overall match.</p>
                    </div>
                @elseif($analysisResult)
                    <!-- Score Overview -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-indigo-500">
                            <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Overall ATS Score</h4>
                            <div class="flex items-end">
                                <span class="text-5xl font-black {{ $analysisResult['ats_score'] >= 80 ? 'text-emerald-500' : ($analysisResult['ats_score'] >= 50 ? 'text-amber-500' : 'text-rose-500') }}">
                                    {{ $analysisResult['ats_score'] }}
                                </span>
                                <span class="text-xl text-gray-400 font-bold ml-1 pb-1">/100</span>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-blue-500">
                            <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Keyword Match</h4>
                            <div class="flex items-end">
                                <span class="text-5xl font-black {{ $analysisResult['keyword_match_score'] >= 80 ? 'text-emerald-500' : ($analysisResult['keyword_match_score'] >= 50 ? 'text-amber-500' : 'text-rose-500') }}">
                                    {{ $analysisResult['keyword_match_score'] }}
                                </span>
                                <span class="text-xl text-gray-400 font-bold ml-1 pb-1">/100</span>
                            </div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-rose-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Missing Keywords
                        </h4>
                        @if(count($analysisResult['missing_keywords']) > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($analysisResult['missing_keywords'] as $keyword)
                                    <span class="px-3 py-1 bg-rose-50 text-rose-700 text-sm font-medium rounded-lg border border-rose-100">
                                        {{ $keyword }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-emerald-600 font-medium">Great job! No major missing keywords identified.</p>
                        @endif
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            Suggestions for Improvement
                        </h4>
                        @if(count($analysisResult['suggestions']) > 0)
                            <ul class="space-y-3">
                                @foreach($analysisResult['suggestions'] as $suggestion)
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-amber-400 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        <span class="text-gray-700">{{ $suggestion }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-emerald-600 font-medium">Your resume looks perfect for this role.</p>
                        @endif
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center text-gray-500 border border-dashed border-gray-300 h-full flex flex-col justify-center">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <p class="text-lg font-medium text-gray-900 mb-1">Awaiting Analysis</p>
                        <p>Select a resume and job description to see how well you match.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
