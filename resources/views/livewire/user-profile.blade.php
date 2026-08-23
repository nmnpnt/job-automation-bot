<div class="space-y-8 animate-fade-in-up" x-data="{ tab: 'identity' }">
    <!-- Profile Header (Glassmorphism) -->
    <div class="md:flex md:items-center md:justify-between bg-slate-900/60 backdrop-blur-2xl p-8 rounded-[2rem] border border-white/10 shadow-[0_10px_30px_rgba(0,0,0,0.3)] relative overflow-hidden">
        <!-- Abstract gradient blobs -->
        <div class="absolute -top-32 -right-32 w-[30rem] h-[30rem] bg-brand-500/20 rounded-full blur-[100px] pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-32 -left-32 w-[30rem] h-[30rem] bg-neon-cyan/20 rounded-full blur-[100px] pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite reverse;"></div>
        
        <div class="min-w-0 flex-1 relative z-10 flex items-center space-x-6">
            <div class="w-28 h-28 rounded-[1.5rem] bg-gradient-to-br from-brand-500 to-neon-pink flex items-center justify-center text-5xl text-white font-black shadow-[0_0_25px_rgba(255,42,133,0.4)] transform hover:-rotate-3 hover:scale-105 transition-all duration-300 border border-white/20">
                <span x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name.charAt(0).toUpperCase()"></span>
            </div>
            <div>
                <h2 class="text-4xl font-black leading-9 text-white tracking-wide uppercase drop-shadow-md" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name">
                </h2>
                <p class="mt-2 text-sm text-slate-400 font-bold flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ auth()->user()->email }}
                </p>
                <div class="mt-3 flex gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-neon-cyan/20 text-neon-cyan text-xs font-black uppercase tracking-widest border border-neon-cyan/30 shadow-[0_0_10px_rgba(34,211,238,0.2)]">
                        <span class="w-1.5 h-1.5 rounded-full bg-neon-cyan mr-1.5 animate-pulse"></span>
                        Active Job Seeker
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-brand-500/20 text-brand-300 text-xs font-black uppercase tracking-widest border border-brand-500/30 shadow-[0_0_10px_rgba(139,92,246,0.2)]">
                        Pro Plan
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="flex flex-col lg:flex-row gap-8 items-start relative z-10">
        
        <!-- Sidebar Navigation -->
        <div class="w-full lg:w-1/4 flex-shrink-0 flex flex-col space-y-2 bg-black/40 backdrop-blur-2xl rounded-[2rem] p-4 border border-white/10 shadow-[0_5px_20px_rgba(0,0,0,0.3)] sticky top-8">
            <button type="button" @click="tab = 'identity'" :class="tab === 'identity' ? 'bg-gradient-to-r from-brand-600 to-brand-500 text-white shadow-[0_0_15px_rgba(139,92,246,0.4)] border border-brand-400/50' : 'text-slate-400 hover:bg-white/5 hover:text-white border border-transparent'" class="w-full text-left px-5 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all duration-300 flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Identity & Resume
            </button>
            <button type="button" @click="tab = 'preferences'" :class="tab === 'preferences' ? 'bg-gradient-to-r from-neon-pink to-rose-500 text-white shadow-[0_0_15px_rgba(255,42,133,0.4)] border border-neon-pink/50' : 'text-slate-400 hover:bg-white/5 hover:text-white border border-transparent'" class="w-full text-left px-5 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all duration-300 flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Job Preferences
            </button>
            <button type="button" @click="tab = 'automation'" :class="tab === 'automation' ? 'bg-gradient-to-r from-purple-500 to-indigo-500 text-white shadow-[0_0_15px_rgba(139,92,246,0.4)] border border-purple-500/50' : 'text-slate-400 hover:bg-white/5 hover:text-white border border-transparent'" class="w-full text-left px-5 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all duration-300 flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Automation & Scheduling
            </button>
            <button type="button" @click="tab = 'links'" :class="tab === 'links' ? 'bg-gradient-to-r from-neon-cyan to-blue-500 text-white shadow-[0_0_15px_rgba(34,211,238,0.4)] border border-neon-cyan/50' : 'text-slate-400 hover:bg-white/5 hover:text-white border border-transparent'" class="w-full text-left px-5 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all duration-300 flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                Targeting & Links
            </button>
            <button type="button" @click="tab = 'integrations'" :class="tab === 'integrations' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-[0_0_15px_rgba(16,185,129,0.4)] border border-emerald-500/50' : 'text-slate-400 hover:bg-white/5 hover:text-white border border-transparent'" class="w-full text-left px-5 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all duration-300 flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Bot Integrations
            </button>
            <button type="button" @click="tab = 'api'" :class="tab === 'api' ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-[0_0_15px_rgba(245,158,11,0.4)] border border-amber-500/50' : 'text-slate-400 hover:bg-white/5 hover:text-white border border-transparent'" class="w-full text-left px-5 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all duration-300 flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                API Tokens
            </button>
        </div>

        <!-- Main Content Area -->
        <div class="w-full lg:w-3/4 flex-1">
            <div class="bg-black/40 backdrop-blur-2xl rounded-[2rem] border border-white/10 shadow-[inset_0_2px_15px_rgba(0,0,0,0.5)] overflow-hidden relative group h-full min-h-[500px]">
                <!-- Profile Information Form -->
                <form wire:submit.prevent="save" class="h-full flex flex-col">
                    <div class="p-8 md:p-12 flex-1">
                        
                        <!-- TAB: Identity -->
                        <div x-show="tab === 'identity'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                            <div class="mb-8">
                                <h3 class="text-2xl font-black text-white uppercase tracking-widest">Identity Info</h3>
                                <p class="text-sm text-slate-400 mt-1 font-bold">Basic details used by the AI engine when filling out forms.</p>
                            </div>
                            
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="relative group/input">
                                        <label for="first_name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-neon-cyan">First Name</label>
                                        <input type="text" wire:model="first_name" id="first_name" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white font-bold shadow-sm focus:border-neon-cyan focus:ring-neon-cyan sm:text-sm transition-all duration-200">
                                        @error('first_name') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="relative group/input">
                                        <label for="last_name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-neon-cyan">Last Name</label>
                                        <input type="text" wire:model="last_name" id="last_name" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white font-bold shadow-sm focus:border-neon-cyan focus:ring-neon-cyan sm:text-sm transition-all duration-200">
                                        @error('last_name') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="relative group/input">
                                    <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-neon-cyan">Email Address</label>
                                    <input type="email" wire:model="email" id="email" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white font-bold shadow-sm focus:border-neon-cyan focus:ring-neon-cyan sm:text-sm transition-all duration-200">
                                    @error('email') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="relative group/input">
                                    <label for="phone" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-neon-cyan">Phone Number</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        </div>
                                        <input type="text" wire:model="phone" id="phone" class="block w-full rounded-xl border border-white/10 bg-black/50 pl-11 pr-4 py-3 text-white font-bold shadow-sm focus:border-neon-cyan focus:ring-neon-cyan sm:text-sm transition-all duration-200">
                                    </div>
                                    @error('phone') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="pt-4">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Resume (PDF)</label>
                                    <div class="mt-1 flex justify-center px-6 pt-6 pb-8 border-2 border-white/10 border-dashed rounded-[1.5rem] bg-black/20 hover:border-brand-500/50 hover:bg-brand-500/5 transition-all duration-300 relative group/file">
                                        <div class="space-y-2 text-center">
                                            <div class="flex text-sm text-slate-400 items-center justify-center">
                                                <label for="resume" class="relative cursor-pointer rounded-md font-bold focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-500 focus-within:ring-offset-slate-900">
                                                    <span class="px-5 py-2.5 bg-brand-500/20 text-brand-300 border border-brand-500/30 backdrop-blur-sm rounded-xl inline-flex items-center group-hover/file:bg-brand-500 group-hover/file:text-white transition-all shadow-[0_0_15px_rgba(139,92,246,0.2)]">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                        Upload Resume
                                                    </span>
                                                    <input id="resume" wire:model="resume" type="file" class="sr-only">
                                                </label>
                                            </div>
                                            <p class="text-xs text-slate-500 font-bold tracking-wide">PDF up to 5MB</p>
                                        </div>
                                    </div>
                                    @if (\App\Models\Profile::where('user_id', auth()->id())->first()?->resume_path)
                                        <div class="flex items-center space-x-3 mt-4">
                                            <span class="text-xs font-black uppercase tracking-widest text-emerald-400 flex items-center bg-emerald-500/10 border border-emerald-500/20 px-3 py-1.5 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.2)]">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Resume Active
                                            </span>
                                            <a href="{{ route('resume.view') }}" target="_blank" class="inline-flex items-center justify-center rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-xs font-black uppercase tracking-widest text-slate-300 shadow-sm hover:bg-white/10 hover:text-white hover:border-white/20 transition-all duration-200">
                                                <svg class="h-3 w-3 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                View PDF
                                            </a>
                                        </div>
                                    @endif
                                    @error('resume') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- TAB: Preferences -->
                        <div x-show="tab === 'preferences'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                            <div class="mb-8">
                                <h3 class="text-2xl font-black text-white uppercase tracking-widest">Job Preferences</h3>
                                <p class="text-sm text-slate-400 mt-1 font-bold">Filter the jobs the bot will apply to on your behalf.</p>
                            </div>

                            <div class="space-y-6">
                                <div class="relative group/input">
                                    <label for="target_roles" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-neon-pink">Target Roles</label>
                                    <input type="text" wire:model="target_roles" id="target_roles" placeholder="e.g. Software Engineer, Frontend Developer" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white font-bold shadow-sm focus:border-neon-pink focus:ring-neon-pink sm:text-sm transition-all duration-200">
                                    <p class="text-[10px] text-slate-500 mt-2 font-bold uppercase tracking-wider">Comma separated list of job titles you want.</p>
                                    @error('target_roles') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="relative group/input">
                                    <label for="target_locations" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-neon-pink">Target Locations</label>
                                    <input type="text" wire:model="target_locations" id="target_locations" placeholder="e.g. San Francisco, New York, Remote" class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-3 text-white font-bold shadow-sm focus:border-neon-pink focus:ring-neon-pink sm:text-sm transition-all duration-200">
                                    @error('target_locations') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                                    <div class="relative group/input">
                                        <label for="max_job_age_days" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-neon-pink">Freshness</label>
                                        <div class="relative">
                                            <select wire:model="max_job_age_days" id="max_job_age_days" class="appearance-none block w-full rounded-xl border border-white/10 bg-black/50 pl-4 pr-10 py-3 text-white font-bold shadow-sm focus:border-neon-pink focus:ring-neon-pink sm:text-sm transition-all duration-200">
                                                <option value="" class="bg-slate-900">Any time</option>
                                                <option value="1" class="bg-slate-900">Past 24 hours</option>
                                                <option value="7" class="bg-slate-900">Past week</option>
                                                <option value="30" class="bg-slate-900">Past month</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>
                                        @error('max_job_age_days') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="relative group/input">
                                        <label for="remote_preference" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-neon-pink">Remote</label>
                                        <div class="relative">
                                            <select id="remote_preference" wire:model="remote_preference" class="appearance-none block w-full rounded-xl border border-white/10 bg-black/50 pl-4 pr-10 py-3 text-white font-bold shadow-sm focus:border-neon-pink focus:ring-neon-pink sm:text-sm transition-all duration-200">
                                                <option value="none" class="bg-slate-900">No Remote</option>
                                                <option value="include" class="bg-slate-900">Include Remote</option>
                                                <option value="only" class="bg-slate-900">Only Remote</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>
                                        @error('remote_preference') <span class="text-rose-500 text-xs mt-1 absolute -bottom-5 left-1 font-medium">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="relative mt-4">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 transition-colors group-focus-within/input:text-neon-pink">Target Platforms</label>
                                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                        @php
                                            $platforms = [
                                                'LINKEDIN' => ['color' => '#38bdf8', 'icon' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>'],
                                                'INDEED' => ['color' => '#60a5fa', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>'],
                                                'NAUKRI' => ['color' => '#818cf8', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>'],
                                                'UPLERS' => ['color' => '#34d399', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>'],
                                                'UNSTOP' => ['color' => '#fbbf24', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>'],
                                                'HIRIST' => ['color' => '#a78bfa', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>'],
                                                'CUTSHORT' => ['color' => '#f472b6', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>']
                                            ];
                                        @endphp
                                        @foreach($platforms as $platform => $data)
                                        <label class="relative flex flex-col items-center justify-center p-4 rounded-2xl border border-white/10 bg-white/5 cursor-pointer hover:border-brand-500/50 hover:bg-brand-500/10 transition-all duration-300 has-[:checked]:bg-brand-500/20 has-[:checked]:border-brand-500 has-[:checked]:shadow-[0_0_15px_rgba(139,92,246,0.3)] hover:-translate-y-1">
                                            <input type="checkbox" wire:model="target_platforms" value="{{ $platform }}" class="peer sr-only">
                                            
                                            <!-- Checkmark Badge -->
                                            <div class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-brand-500 text-white flex items-center justify-center shadow-[0_0_10px_rgba(139,92,246,0.5)] opacity-0 peer-checked:opacity-100 transition-opacity duration-300 scale-75 peer-checked:scale-100 border border-white/20">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                            </div>

                                            <div class="w-10 h-10 mb-2 rounded-xl flex items-center justify-center shadow-[0_0_10px_rgba(0,0,0,0.5)] peer-checked:scale-110 transition-transform duration-300 border border-white/10" style="background-color: {{ $data['color'] }}20; color: {{ $data['color'] }};">
                                                <svg class="w-5 h-5" fill="{{ $platform == 'LINKEDIN' ? 'currentColor' : 'none' }}" stroke="{{ $platform == 'LINKEDIN' ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">{!! $data['icon'] !!}</svg>
                                            </div>
                                            <span class="text-xs font-black uppercase tracking-widest text-slate-400 peer-checked:text-white transition-colors">{{ ucfirst(strtolower($platform)) }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @error('target_platforms') <span class="text-rose-500 text-xs mt-2 block font-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- TAB: Targeting & Links -->
                        <div x-show="tab === 'links'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                            <div class="mb-8">
                                <h3 class="text-2xl font-black text-white uppercase tracking-widest">Professional Links</h3>
                                <p class="text-sm text-slate-400 mt-1 font-bold">Add your links here for applications requiring a portfolio or profile.</p>
                            </div>

                            <div class="space-y-6">
                                <div class="relative group/input">
                                    <label for="linkedin_url" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-[#38bdf8]">LinkedIn URL</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-500 group-focus-within/input:text-[#38bdf8] transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                        </div>
                                        <input type="text" wire:model="linkedin_url" id="linkedin_url" class="block w-full rounded-xl border border-white/10 bg-black/50 pl-11 pr-4 py-3 text-white font-bold shadow-sm focus:border-[#38bdf8] focus:ring-[#38bdf8] sm:text-sm transition-all duration-200">
                                    </div>
                                </div>
                                
                                <div class="relative group/input">
                                    <label for="github_url" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-white">GitHub URL</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-500 group-focus-within/input:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                                        </div>
                                        <input type="text" wire:model="github_url" id="github_url" class="block w-full rounded-xl border border-white/10 bg-black/50 pl-11 pr-4 py-3 text-white font-bold shadow-sm focus:border-white focus:ring-white sm:text-sm transition-all duration-200">
                                    </div>
                                </div>
                                
                                <div class="relative group/input">
                                    <label for="portfolio_url" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within/input:text-emerald-400">Portfolio URL</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-500 group-focus-within/input:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                        </div>
                                        <input type="text" wire:model="portfolio_url" id="portfolio_url" class="block w-full rounded-xl border border-white/10 bg-black/50 pl-11 pr-4 py-3 text-white font-bold shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-all duration-200">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- End of padding container -->

                    <!-- Fixed Save Bar for form tabs only (identity, preferences, links) -->
                    <div x-show="['identity', 'preferences', 'links'].includes(tab)" class="mt-auto px-8 py-5 bg-black/60 backdrop-blur-3xl border-t border-white/10 flex items-center justify-between">
                        <div>
                            @if ($errors->any())
                                <span class="text-[10px] font-black uppercase tracking-widest text-rose-400 flex items-center bg-rose-500/10 border border-rose-500/20 px-4 py-2 rounded-xl" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Please check tabs for errors
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center">
                            @if($saved)
                                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-400 mr-5 flex items-center bg-emerald-500/10 border border-emerald-500/20 px-4 py-2 rounded-xl shadow-[0_0_10px_rgba(16,185,129,0.2)]" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition>
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Profile Updated
                                </span>
                            @endif
                            <button type="submit" wire:loading.attr="disabled" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center justify-center rounded-xl border border-neon-cyan/50 bg-gradient-to-r from-neon-cyan to-blue-500 px-6 py-2.5 text-xs font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(34,211,238,0.4)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] focus:outline-none transition-all duration-300 hover:-translate-y-0.5">
                                Save Changes
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- TAB: Automation & Scheduling (Non-form, embeds a livewire component) -->
                <div x-show="tab === 'automation'" class="h-full flex flex-col p-8 md:p-12" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <livewire:profile.automation-scheduler />
                </div>

                <!-- TAB: Integrations (Non-form) -->
                <div x-show="tab === 'integrations'" class="h-full flex flex-col p-8 md:p-12" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="mb-8">
                        <h3 class="text-2xl font-black text-white uppercase tracking-widest">Platform Integrations</h3>
                        <p class="text-sm text-slate-400 mt-1 font-bold">Connect external platforms to enable the automation bot.</p>
                    </div>

                    @if (session()->has('message'))
                        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 text-xs font-black uppercase tracking-widest text-emerald-400 border border-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.2)] flex items-center">
                            <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="mb-6 p-4 rounded-xl bg-rose-500/10 text-xs font-black uppercase tracking-widest text-rose-400 border border-rose-500/20 shadow-[0_0_15px_rgba(244,63,94,0.2)] flex items-center">
                            <svg class="w-5 h-5 mr-3 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                        @php
                            $platforms = [
                                'LinkedIn' => ['color' => '#38bdf8', 'icon' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>'],
                                'Naukri' => ['color' => '#818cf8', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>'],
                                'Uplers' => ['color' => '#34d399', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>'],
                                'Unstop' => ['color' => '#fbbf24', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>'],
                                'Hirist' => ['color' => '#a78bfa', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>'],
                                'Cutshort' => ['color' => '#f472b6', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                                'Indeed' => ['color' => '#60a5fa', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>']
                            ];
                            $userId = auth()->id();
                        @endphp
                        @foreach($platforms as $platform => $data)
                            @php
                                $sessionDir = storage_path("app/bot-sessions/{$userId}/" . strtolower($platform));
                                $cookiesFile = $sessionDir . '/cookies.json';
                                $isAuthenticated = file_exists($cookiesFile);
                            @endphp
                            <div class="flex flex-col justify-center p-5 bg-white/5 border border-white/10 rounded-[1.5rem] hover:bg-white/10 hover:border-white/20 transition-all duration-300 group/item hover:-translate-y-1 shadow-[0_5px_15px_rgba(0,0,0,0.2)]">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 shadow-sm border border-white/5" style="background-color: {{ $data['color'] }}20; color: {{ $data['color'] }};">
                                            <svg class="w-6 h-6" fill="{{ $platform == 'LinkedIn' ? 'currentColor' : 'none' }}" stroke="{{ $platform == 'LinkedIn' ? 'none' : 'currentColor' }}" viewBox="0 0 24 24">{!! $data['icon'] !!}</svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-black text-white uppercase tracking-wider">{{ $platform }}</h4>
                                            <div class="flex items-center mt-1">
                                                <div class="w-1.5 h-1.5 rounded-full mr-2 {{ $isAuthenticated ? 'bg-neon-cyan shadow-[0_0_8px_rgba(34,211,238,0.8)] animate-pulse' : 'bg-slate-500' }}"></div>
                                                <p class="text-[10px] font-black uppercase tracking-widest {{ $isAuthenticated ? 'text-neon-cyan' : 'text-slate-500' }}">{{ $isAuthenticated ? 'Active Connection' : 'Disconnected' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-5 pt-4 border-t border-white/10">
                                    <form wire:submit.prevent="savePlatformCookies('{{ $platform }}')" class="flex flex-col gap-3">
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Paste Cookies JSON</label>
                                            <textarea wire:model="platform_cookies.{{ $platform }}" placeholder='[{"domain": ".{{ strtolower($platform) }}.com", "name": "...", "value": "..."}]' required class="block w-full rounded-xl border border-white/10 bg-black/50 px-4 py-2.5 text-white shadow-inner focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-all duration-200 min-h-[80px] font-mono text-[10px]" spellcheck="false"></textarea>
                                            @error('platform_cookies.'.$platform) <span class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <p class="text-[9px] font-bold text-slate-500 uppercase tracking-wider leading-relaxed flex-1 mr-3">Get your cookies as a JSON array using the <a href="https://chromewebstore.google.com/detail/editthiscookie/fngmhnnpilhplaeedifhccceomclgfbg" target="_blank" class="text-brand-400 hover:text-brand-300 underline">EditThisCookie</a> extension while logged into {{ $platform }}.</p>
                                            <button type="submit" wire:loading.attr="disabled" class="disabled:opacity-50 flex-shrink-0 disabled:cursor-wait inline-flex items-center px-4 py-2 border border-brand-500/50 bg-brand-500/20 text-brand-300 hover:bg-brand-500 hover:text-white shadow-[0_0_15px_rgba(139,92,246,0.2)] text-[10px] font-black uppercase tracking-widest rounded-xl transition-all duration-200">
                                                Save Session
                                            </button>
                                        </div>
                                        @if (session()->has("cookie_message_{$platform}"))
                                            <div class="mt-2 text-[10px] font-black uppercase tracking-widest text-emerald-400 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                {{ session("cookie_message_{$platform}") }}
                                            </div>
                                        @endif
                                        @if (session()->has("cookie_error_{$platform}"))
                                            <div class="mt-2 text-[10px] font-black uppercase tracking-widest text-rose-400 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ session("cookie_error_{$platform}") }}
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- TAB: API Token (Non-form) -->
                <div x-show="tab === 'api'" class="h-full flex flex-col p-8 md:p-12" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="mb-8 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 text-white rounded-xl flex items-center justify-center mr-5 shadow-[0_0_20px_rgba(245,158,11,0.4)] transform -rotate-3 border border-amber-400/50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-widest">API Access Token</h3>
                            <p class="text-sm text-slate-400 mt-1 font-bold">Extension & CLI connectivity.</p>
                        </div>
                    </div>

                    <div class="bg-amber-500/10 rounded-2xl p-6 border border-amber-500/20 mb-8 shadow-inner">
                        <p class="text-sm text-amber-400 font-bold leading-relaxed">Generate a secure API token to connect your Chrome Extension to this backend instance. The extension uses this to sync discovered jobs to your dashboard autonomously.</p>
                    </div>

                    @if (session()->has('token_message'))
                        <div class="mb-8 p-6 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                            <p class="text-sm font-black uppercase tracking-widest text-emerald-400 flex items-center">
                                <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ session('token_message') }}
                            </p>
                            @if($api_token)
                                <div class="mt-5 p-5 bg-black/60 border border-emerald-500/50 rounded-xl break-all font-mono text-base text-neon-cyan font-bold shadow-inner relative group/token hover:border-emerald-400 transition-colors cursor-copy" onclick="navigator.clipboard.writeText('{{ $api_token }}'); alert('Token copied to clipboard!')">
                                    {{ $api_token }}
                                    <div class="absolute inset-0 bg-black/80 opacity-0 group-hover/token:opacity-100 transition-opacity rounded-xl flex items-center justify-center backdrop-blur-[2px]">
                                        <span class="bg-emerald-500 text-white text-xs font-black uppercase tracking-widest px-4 py-2 rounded-lg shadow-[0_0_15px_rgba(16,185,129,0.5)] flex items-center transform scale-95 group-hover/token:scale-100 transition-transform">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            Click to copy
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-5 flex items-start">
                                    <svg class="w-5 h-5 text-amber-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <p class="text-xs font-bold text-amber-400/80 uppercase tracking-wide leading-relaxed">Please copy this token now. For security reasons, you will not be able to see it again.</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="mt-auto pt-8 border-t border-white/10">
                        <button type="button" x-data x-on:click="if(confirm('Generating a new token will revoke your existing token immediately. Proceed?')) $wire.generateApiToken()" wire:loading.attr="disabled" class="disabled:opacity-50 disabled:cursor-wait inline-flex items-center justify-center rounded-xl border border-amber-500/50 bg-amber-500/20 px-8 py-3.5 text-[11px] font-black uppercase tracking-widest text-amber-400 shadow-[0_0_15px_rgba(245,158,11,0.2)] hover:bg-amber-500 hover:text-white hover:shadow-[0_0_25px_rgba(245,158,11,0.5)] focus:outline-none transition-all duration-300 hover:-translate-y-0.5">
                            <div class="w-5 h-5 rounded-full bg-amber-400/20 flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 currentColor" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            </div>
                            Generate New Token
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
