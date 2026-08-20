<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resume Builder') }} - {{ $resume->title }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Toolbar -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Resume Sections</h3>
                <p class="text-sm text-gray-500">Manage the content of your resume here.</p>
            </div>
            <div>
                <button wire:click="exportPdf" wire:loading.attr="disabled" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <svg wire:loading.remove wire:target="exportPdf" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <svg wire:loading wire:target="exportPdf" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4V2m0 20v-2m8-8h2M2 12h2m15.364-6.364l1.414-1.414M4.222 19.778l1.414-1.414m12.728 12.728l-1.414-1.414M4.222 4.222l1.414 1.414"></path></svg>
                    Export as PDF
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Add Section Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-1 h-fit">
                <h4 class="font-bold text-gray-800 mb-4">Add New Section</h4>
                
                <form wire:submit.prevent="addSection" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Section Type</label>
                        <select wire:model="newSectionType" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="SUMMARY">Summary</option>
                            <option value="EXPERIENCE">Experience</option>
                            <option value="EDUCATION">Education</option>
                            <option value="SKILLS">Skills</option>
                            <option value="PROJECTS">Projects</option>
                            <option value="CERTIFICATIONS">Certifications</option>
                            <option value="CUSTOM">Custom</option>
                        </select>
                        @error('newSectionType') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" wire:model="newSectionTitle" placeholder="e.g. Work Experience" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('newSectionTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    @if(in_array($newSectionType, ['SUMMARY', 'CUSTOM']))
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea wire:model="newSectionContent.text" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter content..."></textarea>
                        </div>
                    @elseif(in_array($newSectionType, ['EXPERIENCE', 'PROJECTS']))
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">{{ $newSectionType === 'EXPERIENCE' ? 'Company Name' : 'Project Name' }}</label>
                                <input type="text" wire:model="newSectionContent.company" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Role / Title</label>
                                <input type="text" wire:model="newSectionContent.role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="text" wire:model="newSectionContent.start_date" placeholder="e.g. Jan 2020" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="text" wire:model="newSectionContent.end_date" placeholder="e.g. Present" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea wire:model="newSectionContent.description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Describe your responsibilities..."></textarea>
                            </div>
                        </div>
                    @elseif($newSectionType === 'EDUCATION')
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Institution</label>
                                <input type="text" wire:model="newSectionContent.institution" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Degree / Major</label>
                                <input type="text" wire:model="newSectionContent.degree" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="text" wire:model="newSectionContent.start_date" placeholder="e.g. Sep 2016" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="text" wire:model="newSectionContent.end_date" placeholder="e.g. May 2020" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                                <textarea wire:model="newSectionContent.description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                        </div>
                    @elseif($newSectionType === 'SKILLS')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Skills (Comma separated)</label>
                            <input type="text" wire:model="newSectionContent.skills" placeholder="e.g. JavaScript, PHP, Laravel, TailwindCSS" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    @elseif($newSectionType === 'CERTIFICATIONS')
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Certification Name</label>
                                <input type="text" wire:model="newSectionContent.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Issuer</label>
                                <input type="text" wire:model="newSectionContent.issuer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="text" wire:model="newSectionContent.date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Order</label>
                        <input type="number" wire:model="newSectionOrder" class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-2 px-4 rounded transition-colors">
                        Add Section
                    </button>
                </form>
            </div>

            <!-- Sections List -->
            <div class="md:col-span-2 space-y-4">
                @forelse($sections as $section)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative group">
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button wire:click="deleteSection({{ $section->id }})" class="text-red-500 hover:text-red-700 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                        
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded">{{ $section->type }}</span>
                            <span class="text-xs text-slate-400">Order: {{ $section->order_index }}</span>
                        </div>
                        
                        <h4 class="text-lg font-bold text-slate-800 mb-2">{{ $section->title }}</h4>
                        
                        <div class="prose prose-sm text-slate-600 max-w-none">
                            @if(in_array($section->type, ['SUMMARY', 'CUSTOM']) && isset($section->content['text']))
                                {!! nl2br(e($section->content['text'])) !!}
                            @elseif(in_array($section->type, ['EXPERIENCE', 'PROJECTS']) && isset($section->content['company']))
                                <div class="mb-1">
                                    <strong>{{ $section->content['role'] ?? '' }}</strong> at <strong>{{ $section->content['company'] }}</strong>
                                </div>
                                <div class="text-xs text-slate-500 mb-2">
                                    {{ $section->content['start_date'] ?? '' }} - {{ $section->content['end_date'] ?? '' }}
                                </div>
                                <div>{!! nl2br(e($section->content['description'] ?? '')) !!}</div>
                            @elseif($section->type === 'EDUCATION' && isset($section->content['institution']))
                                <div class="mb-1">
                                    <strong>{{ $section->content['degree'] ?? '' }}</strong>
                                </div>
                                <div class="text-sm">{{ $section->content['institution'] }}</div>
                                <div class="text-xs text-slate-500 mb-2">
                                    {{ $section->content['start_date'] ?? '' }} - {{ $section->content['end_date'] ?? '' }}
                                </div>
                                <div>{!! nl2br(e($section->content['description'] ?? '')) !!}</div>
                            @elseif($section->type === 'SKILLS' && isset($section->content['skills']))
                                <p>{{ $section->content['skills'] }}</p>
                            @elseif($section->type === 'CERTIFICATIONS' && isset($section->content['name']))
                                <div class="mb-1"><strong>{{ $section->content['name'] }}</strong></div>
                                <div class="text-sm">{{ $section->content['issuer'] ?? '' }}</div>
                                <div class="text-xs text-slate-500">{{ $section->content['date'] ?? '' }}</div>
                            @else
                                <pre class="text-xs">{{ json_encode($section->content, JSON_PRETTY_PRINT) }}</pre>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        No sections added yet. Create your first section on the left.
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>
</div>
