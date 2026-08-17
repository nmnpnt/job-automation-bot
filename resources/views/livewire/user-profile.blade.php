<div class="space-y-8 animate-fade-in-up">
    
    <!-- Profile Header -->
    <div class="md:flex md:items-center md:justify-between bg-white/60 backdrop-blur-xl p-6 rounded-3xl border border-slate-200/60 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/20 rounded-full blur-[80px] -ml-32 -mb-32 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-purple-500/10 rounded-full blur-[60px] transform -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        
        <div class="min-w-0 flex-1 relative z-10 flex items-center space-x-6">
            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-4xl text-white font-black shadow-xl shadow-indigo-500/30 transform hover:rotate-3 hover:scale-105 transition-all duration-300">
                <span x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name.charAt(0).toUpperCase()"></span>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold leading-9 text-slate-900 tracking-tight" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name">
                </h2>
                <p class="mt-1 text-sm text-slate-500 font-medium flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ auth()->user()->email }}
                </p>
            </div>
        </div>
        
        <div class="mt-6 md:mt-0 md:ml-4 flex items-center space-x-4 relative z-10">
            <span class="inline-flex items-center px-4 py-2 rounded-2xl bg-white/80 backdrop-blur-md text-emerald-700 text-sm font-bold border border-slate-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                Active Job Seeker
            </span>
        </div>
    </div>

    <!-- Profile Information Form -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-sm overflow-hidden relative group">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
        <form wire:submit.prevent="save" class="relative z-10">
            <div class="p-8 md:p-10">
                <div class="flex items-center mb-8">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-2xl flex items-center justify-center mr-5 shadow-lg shadow-indigo-500/20 transform -rotate-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight">Personal & Professional Settings</h3>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Fine-tune the details our AI uses to apply on your behalf.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-10">
                    <!-- Personal Details -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-2 border-b border-slate-100 pb-2 mb-6">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            <h4 class="text-sm font-extrabold text-slate-800 uppercase tracking-widest">Identity Info</h4>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-5">
                            <div class="relative group/input">
                                <label for="first_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-indigo-600">First Name</label>
                                <input type="text" wire:model="first_name" id="first_name" class="block w-full rounded-2xl border-slate-200 bg-slate-50/80 px-4 py-3 text-slate-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:bg-white sm:text-sm transition-all duration-200">
                                @error('first_name') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                            </div>
                            <div class="relative group/input">
                                <label for="last_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-indigo-600">Last Name</label>
                                <input type="text" wire:model="last_name" id="last_name" class="block w-full rounded-2xl border-slate-200 bg-slate-50/80 px-4 py-3 text-slate-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:bg-white sm:text-sm transition-all duration-200">
                                @error('last_name') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="relative group/input pt-2">
                            <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-indigo-600">Email Address</label>
                            <input type="email" wire:model="email" id="email" class="block w-full rounded-2xl border-slate-200 bg-slate-50/80 px-4 py-3 text-slate-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:bg-white sm:text-sm transition-all duration-200">
                            @error('email') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group/input pt-2">
                            <label for="phone" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-indigo-600">Phone Number</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <input type="text" wire:model="phone" id="phone" class="block w-full rounded-2xl border-slate-200 bg-slate-50/80 pl-11 pr-4 py-3 text-slate-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:bg-white sm:text-sm transition-all duration-200">
                            </div>
                        </div>

                        <div class="pt-2">
                            <label for="resume" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Resume (PDF)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-2xl hover:border-indigo-400 hover:bg-indigo-50/30 transition-all duration-300 relative group/file">
                                <div class="space-y-1 text-center">
                                    <div class="flex text-sm text-slate-600 items-center justify-center">
                                        <label for="resume" class="relative cursor-pointer rounded-md font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span class="px-4 py-2 bg-indigo-100 rounded-xl inline-flex items-center group-hover/file:bg-indigo-600 group-hover/file:text-white transition-colors">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                Upload Resume
                                            </span>
                                            <input id="resume" wire:model="resume" type="file" class="sr-only">
                                        </label>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-2 font-medium">PDF up to 5MB</p>
                                </div>
                            </div>
                            @if (\App\Models\Profile::where('user_id', auth()->id())->first()?->resume_path)
                                <div class="mt-3 inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 text-xs font-bold text-emerald-700 border border-emerald-100 shadow-sm">
                                    <svg class="w-4 h-4 mr-1.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Resume active and ready
                                </div>
                            @endif
                            @error('resume') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Links & Preferences -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-2 border-b border-slate-100 pb-2 mb-6">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <h4 class="text-sm font-extrabold text-slate-800 uppercase tracking-widest">Targeting & Links</h4>
                        </div>
                        
                        <div class="relative group/input">
                            <label for="linkedin_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-[#0a66c2]">LinkedIn URL</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-focus-within/input:text-[#0a66c2] transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </div>
                                <input type="text" wire:model="linkedin_url" id="linkedin_url" class="block w-full rounded-2xl border-slate-200 bg-slate-50/80 pl-11 pr-4 py-3 text-slate-800 shadow-sm focus:border-[#0a66c2] focus:ring-[#0a66c2] focus:bg-white sm:text-sm transition-all duration-200">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-5 pt-2">
                            <div class="relative group/input">
                                <label for="github_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-slate-900">GitHub URL</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400 group-focus-within/input:text-slate-900 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                                    </div>
                                    <input type="text" wire:model="github_url" id="github_url" class="block w-full rounded-2xl border-slate-200 bg-slate-50/80 pl-10 pr-4 py-3 text-slate-800 shadow-sm focus:border-slate-900 focus:ring-slate-900 focus:bg-white sm:text-sm transition-all duration-200">
                                </div>
                            </div>
                            <div class="relative group/input">
                                <label for="portfolio_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-emerald-600">Portfolio</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400 group-focus-within/input:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                    </div>
                                    <input type="text" wire:model="portfolio_url" id="portfolio_url" class="block w-full rounded-2xl border-slate-200 bg-slate-50/80 pl-10 pr-4 py-3 text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 focus:bg-white sm:text-sm transition-all duration-200">
                                </div>
                            </div>
                        </div>

                        <div class="relative group/input pt-2">
                            <label for="target_roles" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-indigo-600">Target Roles</label>
                            <input type="text" wire:model="target_roles" id="target_roles" placeholder="e.g. Software Engineer, Frontend Developer" class="block w-full rounded-2xl border-slate-200 bg-slate-50/80 px-4 py-3 text-slate-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:bg-white sm:text-sm transition-all duration-200">
                            <p class="text-[10px] text-slate-400 mt-1.5 px-1">Comma separated list of job titles you want.</p>
                            @error('target_roles') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group/input pt-1">
                            <label for="target_locations" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-indigo-600">Target Locations</label>
                            <input type="text" wire:model="target_locations" id="target_locations" placeholder="e.g. San Francisco, New York, Remote" class="block w-full rounded-2xl border-slate-200 bg-slate-50/80 px-4 py-3 text-slate-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:bg-white sm:text-sm transition-all duration-200">
                            @error('target_locations') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-5 pt-3">
                            <div class="relative group/input">
                                <label for="max_job_age_days" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-indigo-600">Freshness</label>
                                <div class="relative">
                                    <select wire:model="max_job_age_days" id="max_job_age_days" class="appearance-none block w-full rounded-2xl border-slate-200 bg-slate-50/80 pl-4 pr-10 py-3 text-slate-800 font-medium shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:bg-white sm:text-sm transition-all duration-200">
                                        <option value="">Any time</option>
                                        <option value="1">Past 24 hours</option>
                                        <option value="7">Past week</option>
                                        <option value="30">Past month</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                @error('max_job_age_days') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                            </div>
                            <div class="relative group/input">
                                <label for="remote_preference" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 transition-colors group-focus-within/input:text-indigo-600">Remote</label>
                                <div class="relative">
                                    <select id="remote_preference" wire:model="remote_preference" class="appearance-none block w-full rounded-2xl border-slate-200 bg-slate-50/80 pl-4 pr-10 py-3 text-slate-800 font-medium shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:bg-white sm:text-sm transition-all duration-200">
                                        <option value="none">No Remote</option>
                                        <option value="include">Include Remote</option>
                                        <option value="only">Only Remote</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                @error('remote_preference') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end px-8 py-5 bg-gradient-to-r from-slate-50 to-indigo-50/30 border-t border-slate-100/60">
                @if($saved)
                    <span class="text-sm font-bold text-emerald-600 mr-5 flex items-center bg-emerald-100/50 px-4 py-1.5 rounded-full" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition>
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Profile Updated
                    </span>
                @endif
                <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-transparent bg-slate-900 px-8 py-3 text-sm font-bold text-white shadow-sm hover:bg-indigo-600 focus:outline-none transition-all duration-200 hover:-translate-y-0.5">
                    Save Changes
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Integrations & APIs Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Platform Integrations Section -->
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200 shadow-sm rounded-3xl p-8 relative overflow-hidden group hover:shadow-lg hover:border-indigo-200 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl -mr-20 -mt-20 group-hover:bg-blue-500/10 transition-colors duration-500 pointer-events-none"></div>
            
            <div class="flex items-center mb-8 relative z-10">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-cyan-500 text-white rounded-2xl flex items-center justify-center mr-5 shadow-lg shadow-blue-500/20 transform rotate-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Platform Sync</h3>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Connect accounts to allow automated applying.</p>
                </div>
            </div>
            
            @if (session()->has('message'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-sm font-bold text-emerald-700 border border-emerald-100 shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-50 text-sm font-bold text-rose-700 border border-rose-100 shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="space-y-4 relative z-10">
                @php
                    $platforms = [
                        'LinkedIn' => ['color' => '#0a66c2', 'icon' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>'],
                        'Naukri' => ['color' => '#0054c2', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>'],
                        'Uplers' => ['color' => '#10b981', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>'],
                        'Unstop' => ['color' => '#f59e0b', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>'],
                        'Hirist' => ['color' => '#8b5cf6', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>'],
                        'Cutshort' => ['color' => '#ec4899', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>']
                    ];
                    $userId = auth()->id();
                @endphp
                @foreach($platforms as $platform => $data)
                    @php
                        $sessionDir = storage_path("app/bot-sessions/{$userId}/" . strtolower($platform));
                        $isAuthenticated = file_exists($sessionDir) && is_dir($sessionDir) && count(scandir($sessionDir)) > 2;
                    @endphp
                    <div class="flex items-center justify-between p-4 bg-slate-50/70 border border-slate-100 rounded-2xl hover:border-slate-300 hover:shadow-md transition-all duration-300 group/item hover:-translate-y-0.5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 shadow-sm" style="background-color: {{ $data['color'] }}15; color: {{ $data['color'] }};">
                                <svg class="w-5 h-5" fill="{{ $platform == 'LinkedIn' ? 'currentColor' : 'none' }}" stroke="{{ $platform == 'LinkedIn' ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">{!! $data['icon'] !!}</svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">{{ $platform }}</h4>
                                <div class="flex items-center mt-0.5">
                                    <div class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $isAuthenticated ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></div>
                                    <p class="text-xs font-semibold {{ $isAuthenticated ? 'text-emerald-600' : 'text-slate-500' }}">{{ $isAuthenticated ? 'Active Connection' : 'Disconnected' }}</p>
                                </div>
                            </div>
                        </div>
                        <button type="button" wire:click="authenticatePlatform('{{ $platform }}')" class="inline-flex items-center px-4 py-2 border {{ $isAuthenticated ? 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900' : 'border-transparent bg-indigo-600 text-white hover:bg-indigo-700 shadow-md shadow-indigo-500/20' }} text-xs font-bold rounded-xl transition-all duration-200">
                            {{ $isAuthenticated ? 'Reconnect' : 'Connect' }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- API Token Section -->
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200 shadow-sm rounded-3xl p-8 flex flex-col relative overflow-hidden group hover:shadow-lg hover:border-amber-200 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl -ml-20 -mb-20 group-hover:bg-amber-500/10 transition-colors duration-500 pointer-events-none"></div>

            <div class="flex items-center mb-6 relative z-10">
                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-500 text-white rounded-2xl flex items-center justify-center mr-5 shadow-lg shadow-amber-500/20 transform -rotate-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">API Access Token</h3>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Extension & CLI connectivity.</p>
                </div>
            </div>
            
            <div class="flex-1 relative z-10">
                <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-100 mb-6">
                    <p class="text-sm text-slate-600 font-medium leading-relaxed">Generate a secure API token to connect your Chrome Extension to this backend instance. The extension uses this to sync discovered jobs to your dashboard autonomously.</p>
                </div>
                
                @if (session()->has('token_message'))
                    <div class="mb-6 p-5 bg-emerald-50 border border-emerald-200 rounded-2xl shadow-sm">
                        <p class="text-sm font-extrabold text-emerald-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('token_message') }}
                        </p>
                        @if($api_token)
                            <div class="mt-4 p-4 bg-white border-2 border-emerald-200 rounded-xl break-all font-mono text-sm text-slate-800 font-bold shadow-inner relative group/token hover:border-emerald-400 transition-colors cursor-copy" onclick="navigator.clipboard.writeText('{{ $api_token }}'); alert('Token copied to clipboard!')">
                                {{ $api_token }}
                                <div class="absolute inset-0 bg-emerald-500/5 opacity-0 group-hover/token:opacity-100 transition-opacity rounded-xl flex items-center justify-center backdrop-blur-[1px]">
                                    <span class="bg-emerald-600 text-white text-xs px-3 py-1.5 rounded-lg shadow-lg flex items-center font-bold">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Click to copy
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3 flex items-start">
                                <svg class="w-4 h-4 text-amber-500 mr-1.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <p class="text-xs font-bold text-amber-700">Please copy this token now. For security reasons, you will not be able to see it again.</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <button type="button" wire:click="generateApiToken" class="relative z-10 inline-flex items-center justify-center w-full rounded-xl border border-slate-200 bg-white px-6 py-3.5 text-sm font-bold text-slate-800 shadow-sm hover:bg-slate-50 hover:border-slate-300 hover:shadow-md focus:outline-none transition-all duration-200">
                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center mr-3 transition-colors">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </div>
                Generate New Token
            </button>
        </div>
    </div>
</div>
