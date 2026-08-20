<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Resumes') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-6">
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Manage Your Resumes</h3>
                <p class="text-sm text-gray-500">Create tailored resumes for different types of jobs.</p>
            </div>
            
            <form wire:submit.prevent="createResume" class="flex gap-2 w-full md:w-auto">
                <input type="text" wire:model="newResumeTitle" placeholder="e.g. Frontend Developer" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm flex-1">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded whitespace-nowrap transition-colors">
                    Create Resume
                </button>
            </form>
            @error('newResumeTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        @if($profile && $profile->resume_path)
        <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-6 flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-100 p-3 rounded-full text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-800">Uploaded Resume (From Profile)</h4>
                    <p class="text-sm text-gray-600">This resume will be used as a fallback if no specific AI resume is selected.</p>
                </div>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <a href="{{ route('resume.view') }}" target="_blank" class="text-indigo-600 bg-white border border-indigo-200 hover:bg-indigo-50 font-semibold py-2 px-4 rounded transition-colors text-sm">
                    View Uploaded Resume
                </a>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($resumes as $resume)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col hover:shadow-md transition-shadow">
                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="text-xl font-bold text-gray-800 line-clamp-2">{{ $resume->name }}</h4>
                            @if($resume->is_default)
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full whitespace-nowrap">Default</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Last updated {{ $resume->updated_at->diffForHumans() }}</p>
                        <p class="text-xs text-gray-400">{{ $resume->sections()->count() }} sections</p>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                        <a href="{{ route('resumes.builder', $resume->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                            Edit Resume
                        </a>
                        <button wire:click="deleteResume({{ $resume->id }})" class="text-red-500 hover:text-red-700" title="Delete">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center text-gray-500 border border-dashed border-gray-300">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-lg font-medium text-gray-900 mb-1">No resumes found</p>
                    <p>Create your first resume to get started.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
