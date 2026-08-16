<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="save">
            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Profile Information</h3>
                
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" wire:model="first_name" id="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" wire:model="last_name" id="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" wire:model="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" wire:model="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                        <input type="text" wire:model="linkedin_url" id="linkedin_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div class="col-span-6 sm:col-span-2">
                        <label for="github_url" class="block text-sm font-medium text-gray-700">GitHub URL</label>
                        <input type="text" wire:model="github_url" id="github_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <label for="portfolio_url" class="block text-sm font-medium text-gray-700">Portfolio URL</label>
                        <input type="text" wire:model="portfolio_url" id="portfolio_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="col-span-6">
                        <label for="resume" class="block text-sm font-medium text-gray-700">Resume (PDF)</label>
                        <input type="file" wire:model="resume" id="resume" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @if (\App\Models\Profile::where('user_id', auth()->id())->first()?->resume_path)
                            <p class="mt-2 text-sm text-green-600">Resume currently uploaded.</p>
                        @endif
                        @error('resume') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-6 mt-4">
                        <h4 class="text-md font-medium text-gray-900 border-b pb-2">Job Search Preferences</h4>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="target_roles" class="block text-sm font-medium text-gray-700">Target Roles (comma separated)</label>
                        <input type="text" wire:model="target_roles" id="target_roles" placeholder="e.g. Software Engineer, Frontend Developer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('target_roles') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="target_locations" class="block text-sm font-medium text-gray-700">Target Locations (comma separated)</label>
                        <input type="text" wire:model="target_locations" id="target_locations" placeholder="e.g. San Francisco, London, Remote" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('target_locations') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-6">
                        <div class="flex items-start">
                            <div class="flex h-5 items-center">
                                <input id="remote_only" wire:model="remote_only" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remote_only" class="font-medium text-gray-700">Remote Only</label>
                                <p class="text-gray-500">Only fetch jobs that are strictly remote.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                @if($saved)
                    <span class="text-sm text-green-600 mr-3">Saved.</span>
                @endif
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Save
                </button>
            </div>
        </form>
    </div>

    <!-- Platform Integrations Section -->
    <div class="mt-8 md:col-span-2">
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Platform Integrations</h3>
            <p class="text-sm text-gray-500 mb-4">Authenticate your accounts so the bot can fetch jobs and apply on your behalf.</p>
            
            @if (session()->has('message'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="mb-4 text-sm font-medium text-red-600">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="space-y-4">
                @php
                    $platforms = ['LinkedIn', 'Naukri', 'Uplers', 'Unstop', 'Hirist', 'Cutshort'];
                    $userId = auth()->id();
                @endphp
                @foreach($platforms as $platform)
                    @php
                        $sessionDir = storage_path("app/bot-sessions/{$userId}/" . strtolower($platform));
                        $isAuthenticated = file_exists($sessionDir) && is_dir($sessionDir) && count(scandir($sessionDir)) > 2;
                    @endphp
                    <div class="flex items-center justify-between p-4 border rounded-md">
                        <div>
                            <h4 class="text-md font-medium text-gray-900">{{ $platform }}</h4>
                            @if($isAuthenticated)
                                <p class="text-sm text-green-600 font-semibold">Authenticated</p>
                            @else
                                <p class="text-sm text-gray-500">Not authenticated</p>
                            @endif
                        </div>
                        <button type="button" wire:click="authenticatePlatform('{{ $platform }}')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ $isAuthenticated ? 'Re-Authenticate' : 'Authenticate' }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
