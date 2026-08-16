<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h2 class="text-lg font-semibold mb-4">Notification Settings</h2>
        
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Event Triggers -->
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-3 uppercase tracking-wide">Event Triggers</h3>
                <div class="space-y-3">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="preference.notify_on_submitted" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Auto-Application Submitted</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="preference.notify_on_external" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Redirected to External Board</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="preference.notify_on_company_website" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Company Website Application</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="preference.notify_on_manual_required" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Manual Intervention Required</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="preference.notify_on_failed" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Application Failed</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="preference.notify_on_duplicate" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Already Applied</span>
                    </label>
                </div>
            </div>

            <hr class="border-gray-200">

            <!-- Notification Channels -->
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-3 uppercase tracking-wide">Channels & Summaries</h3>
                <div class="space-y-3">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="preference.channel_in_app" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">In-App Notifications (Dashboard)</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="preference.channel_email" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Email Alerts</span>
                    </label>
                    <label class="flex items-center cursor-pointer mt-4">
                        <input type="checkbox" wire:model.live="preference.daily_summary" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700 font-medium">Receive Daily Summary Email</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
