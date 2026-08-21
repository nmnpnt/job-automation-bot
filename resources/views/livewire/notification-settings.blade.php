<div class="py-6 min-h-screen transition-colors duration-300">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="relative rounded-[2rem] overflow-hidden mb-8 bg-slate-900/60 backdrop-blur-2xl border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.3)]">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-neon-cyan/20 rounded-full blur-[80px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-32 h-32 bg-brand-500/20 rounded-full blur-[80px] pointer-events-none"></div>
            <div class="relative px-6 py-6 text-white z-10 flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 bg-brand-500/20 rounded-2xl mr-4 border border-brand-500/30 shadow-[0_0_15px_rgba(139,92,246,0.3)]">
                        <svg class="w-8 h-8 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black tracking-tight mb-1">Notification Settings</h1>
                        <p class="text-sm text-slate-400 font-bold tracking-wide">
                            Configure how and when you want to be alerted about your job applications.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Event Triggers Column -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-slate-900/60 backdrop-blur-xl rounded-[2rem] p-8 shadow-[0_10px_30px_rgba(0,0,0,0.3)] border border-white/10 relative overflow-hidden group transition-colors duration-300">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-brand-500 to-neon-cyan"></div>
                        <h3 class="text-2xl font-black text-white mb-2">Event Triggers</h3>
                        <p class="text-sm text-slate-400 font-bold mb-6">Select the specific events you want the bot to notify you about.</p>
                        
                        <div class="space-y-4">
                            <!-- Toggle Item -->
                            <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 hover:border-brand-500/30 transition-all duration-300">
                                <div>
                                    <h4 class="text-sm font-black text-white uppercase tracking-wider">Scraper Completed</h4>
                                    <p class="text-xs text-slate-400 font-medium mt-1">Get a summary alert when the bot finishes scraping jobs.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="daily_summary" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500 shadow-[inset_0_2px_4px_rgba(0,0,0,0.6)]"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 hover:border-brand-500/30 transition-all duration-300">
                                <div>
                                    <h4 class="text-sm font-black text-white uppercase tracking-wider">Duplicate Skipped</h4>
                                    <p class="text-xs text-slate-400 font-medium mt-1">Log an alert if the bot skips a job because it was already discovered previously.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="notify_on_duplicate" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500 shadow-[inset_0_2px_4px_rgba(0,0,0,0.6)]"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Channels Column -->
                <div class="space-y-6">
                    <div class="bg-slate-900/60 backdrop-blur-xl rounded-[2rem] p-8 shadow-[0_10px_30px_rgba(0,0,0,0.3)] border border-white/10 relative overflow-hidden group transition-colors duration-300">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-neon-pink via-brand-500 to-neon-cyan"></div>
                        <h3 class="text-2xl font-black text-white mb-2 mt-2">Channels</h3>
                        <p class="text-sm text-slate-400 font-bold mb-6">Choose how you want to receive your alerts.</p>
                        
                        <div class="space-y-4">
                            <!-- In-App -->
                            <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 transition-colors duration-300 hover:border-white/20">
                                <div>
                                    <h4 class="text-sm font-black text-white uppercase tracking-wider">In-App</h4>
                                    <p class="text-xs text-slate-400 font-medium mt-1">Show alerts in Activity Feed.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="channel_in_app" class="sr-only peer">
                                    <div class="w-9 h-5 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-500 shadow-[inset_0_2px_4px_rgba(0,0,0,0.6)]"></div>
                                </label>
                            </div>

                            <!-- Slack -->
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/5 space-y-4 transition-colors duration-300 hover:border-[#4A154B]/50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-white/10 rounded-xl shadow-sm">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12.234 1.332C12.155 1.3 12.078 1.3 12 1.3c-.078 0-.155.03-.234.032l-9.336 4.668c-.28.14-.43.43-.43.74v7.527c0 3.86 2.37 7.42 5.92 9.09l4 1.884c.07.034.15.05.23.05s.16-.016.23-.05l4-1.884c3.55-1.67 5.92-5.23 5.92-9.09V6.74c0-.31-.15-.6-.43-.74l-9.666-4.668zM12 21.055l-3.328-1.567A8.995 8.995 0 014 11.597V7.527l8-4 8 4v4.07c0 3.33-1.89 6.42-4.672 8.35L12 21.055zm.6-11.455v2.8h2.8c0 1.54-1.26 2.8-2.8 2.8s-2.8-1.26-2.8-2.8 1.26-2.8 2.8-2.8V7.8c-2.54 0-4.6 2.06-4.6 4.6s2.06 4.6 4.6 4.6 4.6-2.06 4.6-4.6v-2.8h-4.6z"/></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-black text-white uppercase tracking-wider">Slack</h4>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                                        <input type="checkbox" wire:model="channel_slack" class="sr-only peer">
                                        <div class="w-9 h-5 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#4A154B] shadow-[inset_0_2px_4px_rgba(0,0,0,0.6)]"></div>
                                    </label>
                                </div>
                                <div x-data="{ expanded: @entangle('channel_slack') }" x-show="expanded" x-collapse>
                                    <div class="pt-4 border-t border-white/10 space-y-3">
                                        <label for="slack_url" class="block text-xs font-bold text-slate-400">Slack Webhook URL</label>
                                        <input type="text" id="slack_url" wire:model="slack_webhook_url" class="block w-full rounded-xl border-white/10 bg-black/30 shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)] focus:border-brand-500 focus:ring-brand-500 text-white text-xs px-3 py-3" placeholder="https://hooks.slack.com/services/...">
                                        @error('slack_webhook_url') <span class="text-neon-pink text-xs font-bold block">{{ $message }}</span> @enderror
                                        
                                        <div class="pt-2 flex items-center justify-between">
                                            <button type="button" wire:click="testSlack" wire:loading.attr="disabled" class="inline-flex items-center justify-center text-xs font-black uppercase tracking-wider px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-all duration-300 shadow-sm border border-white/20 hover:border-brand-500/50">
                                                <span wire:loading.remove wire:target="testSlack">⚡ Test Slack</span>
                                                <span wire:loading wire:target="testSlack" class="flex items-center">
                                                    <svg class="animate-spin -ml-1 mr-2 h-3.5 w-3.5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                    Sending...
                                                </span>
                                            </button>
                                        </div>
                                        @if($testSlackStatus)
                                            <div class="text-xs p-3 rounded-xl border font-bold {{ $testSlackStatus['success'] ? 'bg-neon-cyan/10 border-neon-cyan/30 text-neon-cyan' : 'bg-neon-pink/10 border-neon-pink/30 text-neon-pink' }}">
                                                {{ $testSlackStatus['message'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp Integration -->
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/5 space-y-4 transition-colors duration-300 hover:border-[#25D366]/50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-[#25D366]/20 rounded-xl shadow-sm text-[#25D366] border border-[#25D366]/30">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-black text-white uppercase tracking-wider">WhatsApp</h4>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                                        <input type="checkbox" wire:model="channel_whatsapp" class="sr-only peer">
                                        <div class="w-9 h-5 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#25D366] shadow-[inset_0_2px_4px_rgba(0,0,0,0.6)]"></div>
                                    </label>
                                </div>
                                <div x-data="{ expanded: @entangle('channel_whatsapp') }" x-show="expanded" x-collapse>
                                    <div class="pt-4 border-t border-white/10 space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 mb-2">Provider</label>
                                            <select wire:model="whatsapp_provider" class="block w-full rounded-xl border-white/10 shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)] bg-black/30 text-white focus:border-brand-500 focus:ring-brand-500 text-xs px-3 py-3">
                                                <option value="callmebot">CallMeBot (Free WhatsApp API)</option>
                                                <option value="custom_webhook">Custom Webhook / Gateway</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 mb-2">Phone Number (with Country Code)</label>
                                            <input type="text" wire:model="whatsapp_phone_number" class="block w-full rounded-xl border-white/10 shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)] bg-black/30 text-white focus:border-brand-500 focus:ring-brand-500 text-xs px-3 py-3" placeholder="+919876543210">
                                            @error('whatsapp_phone_number') <span class="text-neon-pink text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 mb-2">
                                                {{ $whatsapp_provider === 'callmebot' ? 'CallMeBot API Key' : 'Webhook URL' }}
                                            </label>
                                            <input type="text" wire:model="whatsapp_api_key" class="block w-full rounded-xl border-white/10 shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)] bg-black/30 text-white focus:border-brand-500 focus:ring-brand-500 text-xs px-3 py-3" placeholder="{{ $whatsapp_provider === 'callmebot' ? 'Enter your CallMeBot API key' : 'https://api.twilio.com/...' }}">
                                            @if($whatsapp_provider === 'callmebot')
                                                <p class="text-[10px] text-slate-500 mt-2 font-medium">Get your free key in 10s: Send "I allow callmebot to send me messages" on WhatsApp to <strong class="text-white">+34 941 07 43 00</strong>.</p>
                                            @endif
                                            @error('whatsapp_api_key') <span class="text-neon-pink text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="pt-2 flex items-center justify-between">
                                            <button type="button" wire:click="testWhatsApp" wire:loading.attr="disabled" class="inline-flex items-center justify-center text-xs font-black uppercase tracking-wider px-4 py-2 bg-[#25D366]/20 hover:bg-[#25D366]/30 text-[#25D366] rounded-xl transition-all duration-300 shadow-[0_0_10px_rgba(37,211,102,0.2)] border border-[#25D366]/30">
                                                <span wire:loading.remove wire:target="testWhatsApp">💬 Test WhatsApp</span>
                                                <span wire:loading wire:target="testWhatsApp" class="flex items-center">
                                                    <svg class="animate-spin -ml-1 mr-2 h-3.5 w-3.5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                    Sending...
                                                </span>
                                            </button>
                                        </div>
                                        @if($testWhatsAppStatus)
                                            <div class="text-xs p-3 rounded-xl border font-bold mt-2 {{ $testWhatsAppStatus['success'] ? 'bg-neon-cyan/10 border-neon-cyan/30 text-neon-cyan' : 'bg-neon-pink/10 border-neon-pink/30 text-neon-pink' }}">
                                                {{ $testWhatsAppStatus['message'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Save Action -->
                    <div class="bg-slate-900/60 backdrop-blur-xl rounded-[2rem] p-5 shadow-[0_10px_30px_rgba(0,0,0,0.3)] border border-white/10 flex items-center justify-between transition-colors duration-300">
                        <div class="flex items-center space-x-2 text-neon-cyan font-bold text-sm" x-data="{ show: @entangle('saved') }" x-show="show" x-init="$watch('show', value => { if(value) setTimeout(() => $wire.set('saved', false), 3000) })" x-transition>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Settings Saved</span>
                        </div>
                        <button type="submit" wire:loading.attr="disabled" class="ml-auto inline-flex justify-center items-center rounded-xl border border-transparent bg-brand-600 hover:bg-brand-500 py-3 px-8 text-sm font-black uppercase tracking-wider text-white shadow-[0_0_15px_rgba(139,92,246,0.3)] focus:outline-none transition-all duration-300 disabled:opacity-75 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="save">Save Preferences</span>
                            <span wire:loading wire:target="save" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
