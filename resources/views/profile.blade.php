<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-white tracking-wider uppercase leading-tight bg-clip-text text-transparent bg-gradient-to-r from-brand-400 to-neon-cyan">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:user-profile />
        </div>
    </div>
</x-app-layout>
