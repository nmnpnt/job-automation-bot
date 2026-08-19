<div class="py-6 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="relative rounded-2xl overflow-hidden mb-8 bg-gradient-to-r from-teal-500 via-emerald-500 to-green-600 shadow-md">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-32 h-32 bg-teal-200 opacity-20 rounded-full blur-2xl"></div>
            <div class="relative px-6 py-6 text-white z-10 flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight mb-1 drop-shadow-sm">Notification Settings</h1>
                    <p class="text-sm text-emerald-50 max-w-2xl font-medium">
                        Configure how and when you want to be alerted about your job applications.
                    </p>
                </div>
                <div class="mt-4 md:mt-0 p-3 bg-white/20 rounded-xl backdrop-blur-md border border-white/30 shadow-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Event Triggers Column -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-blue-500 to-indigo-600"></div>
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Event Triggers</h3>
                        <p class="text-sm text-gray-500 mb-5">Select the specific events you want the bot to notify you about.</p>
                        
                        <div class="space-y-3">
                            <!-- Toggle Item -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition-all">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Auto-Application Submitted</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Get alerted instantly when the bot successfully submits an application.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="notify_on_submitted" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition-all">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Redirected to External Board</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Alert me if a job posting links out to another site (e.g., Workday).</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="notify_on_external" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition-all">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Company Website Application</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Notify me if the bot encounters a direct company careers page.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="notify_on_company_website" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition-all">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Manual Intervention Required</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Alert me if a captcha, custom assessment, or unhandled question blocks the bot.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="notify_on_manual_required" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition-all">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Application Failed</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Get notified if the bot encounters a crash or error while applying.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="notify_on_failed" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition-all">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Interview Scheduled</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Receive immediate high-priority alerts when an interview is requested or scheduled.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="notify_on_interview" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition-all">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Already Applied</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Log an alert if the bot skips a job because you have already applied to it.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="notify_on_duplicate" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Channels Column -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-purple-500 via-emerald-500 to-pink-500"></div>
                        <h3 class="text-xl font-bold text-gray-800 mb-1 mt-1">Channels</h3>
                        <p class="text-sm text-gray-500 mb-5">Choose how you want to receive your alerts.</p>
                        
                        <div class="space-y-4">
                            <!-- In-App -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">In-App Notifications</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Show alerts in the Live Activity Feed.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-4">
                                    <input type="checkbox" wire:model="channel_in_app" class="sr-only peer">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                                </label>
                            </div>

                            <!-- Slack -->
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="p-1.5 bg-white rounded shadow-sm">
                                            <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 24 24"><path d="M12.234 1.332C12.155 1.3 12.078 1.3 12 1.3c-.078 0-.155.03-.234.032l-9.336 4.668c-.28.14-.43.43-.43.74v7.527c0 3.86 2.37 7.42 5.92 9.09l4 1.884c.07.034.15.05.23.05s.16-.016.23-.05l4-1.884c3.55-1.67 5.92-5.23 5.92-9.09V6.74c0-.31-.15-.6-.43-.74l-9.666-4.668zM12 21.055l-3.328-1.567A8.995 8.995 0 014 11.597V7.527l8-4 8 4v4.07c0 3.33-1.89 6.42-4.672 8.35L12 21.055zm.6-11.455v2.8h2.8c0 1.54-1.26 2.8-2.8 2.8s-2.8-1.26-2.8-2.8 1.26-2.8 2.8-2.8V7.8c-2.54 0-4.6 2.06-4.6 4.6s2.06 4.6 4.6 4.6 4.6-2.06 4.6-4.6v-2.8h-4.6z"/></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-800">Slack Integration</h4>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                                        <input type="checkbox" wire:model="channel_slack" class="sr-only peer">
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#4A154B]"></div>
                                    </label>
                                </div>
                                <div x-data="{ expanded: @entangle('channel_slack') }" x-show="expanded" x-collapse>
                                    <div class="pt-3 border-t border-gray-200 space-y-2">
                                        <label for="slack_url" class="block text-xs font-medium text-gray-700">Slack Webhook URL</label>
                                        <input type="text" id="slack_url" wire:model="slack_webhook_url" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-xs px-3 py-2 bg-white" placeholder="https://hooks.slack.com/services/...">
                                        @error('slack_webhook_url') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                        
                                        <div class="pt-1 flex items-center justify-between">
                                            <button type="button" wire:click="testSlack" wire:loading.attr="disabled" class="inline-flex items-center text-xs font-semibold px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-all">
                                                <span wire:loading.remove wire:target="testSlack">⚡ Send Test Slack Message</span>
                                                <span wire:loading wire:target="testSlack">Sending...</span>
                                            </button>
                                        </div>
                                        @if($testSlackStatus)
                                            <div class="text-xs p-2 rounded-lg {{ $testSlackStatus['success'] ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                                {{ $testSlackStatus['message'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp Integration -->
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="p-1.5 bg-white rounded shadow-sm text-emerald-600">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-800">WhatsApp Alerts</h4>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                                        <input type="checkbox" wire:model="channel_whatsapp" class="sr-only peer">
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                                    </label>
                                </div>
                                <div x-data="{ expanded: @entangle('channel_whatsapp') }" x-show="expanded" x-collapse>
                                    <div class="pt-3 border-t border-gray-200 space-y-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Provider</label>
                                            <select wire:model="whatsapp_provider" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs px-3 py-2 bg-white">
                                                <option value="callmebot">CallMeBot (Free WhatsApp API)</option>
                                                <option value="custom_webhook">Custom Webhook / Gateway</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Phone Number (with Country Code)</label>
                                            <input type="text" wire:model="whatsapp_phone_number" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs px-3 py-2 bg-white" placeholder="+919876543210">
                                            @error('whatsapp_phone_number') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                                {{ $whatsapp_provider === 'callmebot' ? 'CallMeBot API Key' : 'Webhook URL' }}
                                            </label>
                                            <input type="text" wire:model="whatsapp_api_key" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs px-3 py-2 bg-white" placeholder="{{ $whatsapp_provider === 'callmebot' ? 'Enter your CallMeBot API key' : 'https://api.twilio.com/...' }}">
                                            @if($whatsapp_provider === 'callmebot')
                                                <p class="text-[10px] text-gray-500 mt-1">Get your free key in 10s: Send "I allow callmebot to send me messages" on WhatsApp to <strong>+34 941 07 43 00</strong>.</p>
                                            @endif
                                            @error('whatsapp_api_key') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="pt-1 flex items-center justify-between">
                                            <button type="button" wire:click="testWhatsApp" wire:loading.attr="disabled" class="inline-flex items-center text-xs font-semibold px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-800 rounded-lg transition-all">
                                                <span wire:loading.remove wire:target="testWhatsApp">💬 Send Test WhatsApp</span>
                                                <span wire:loading wire:target="testWhatsApp">Sending...</span>
                                            </button>
                                        </div>
                                        @if($testWhatsAppStatus)
                                            <div class="text-xs p-2 rounded-lg {{ $testWhatsAppStatus['success'] ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                                {{ $testWhatsAppStatus['message'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Save Action -->
                    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2 text-emerald-600 font-medium text-sm" x-data="{ show: @entangle('saved') }" x-show="show" x-init="$watch('show', value => { if(value) setTimeout(() => $wire.set('saved', false), 3000) })" x-transition>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Settings Saved</span>
                        </div>
                        <button type="submit" class="ml-auto inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 py-2.5 px-6 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                            Save Preferences
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
