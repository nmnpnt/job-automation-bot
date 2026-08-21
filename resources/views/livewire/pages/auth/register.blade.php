<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        // Redirect to profile setup instead of dashboard
        $this->redirect(route('profile', absolute: false), navigate: true);
    }
}; ?>

<div class="animate-fade-in-up">
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-white tracking-tight drop-shadow-md">Create your account</h2>
        <p class="mt-2 text-sm text-slate-400 font-bold">Join the platform to automate your job search.</p>
    </div>

    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <div>
            <label for="name" class="block text-[11px] uppercase tracking-widest font-black text-slate-400 mb-2">{{ __('Full Name') }}</label>
            <div class="relative rounded-xl shadow-inner group/input">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500 group-focus-within/input:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input wire:model="name" id="name" type="text" required autofocus autocomplete="name" class="block w-full rounded-xl bg-slate-900/50 border border-white/10 py-3 pl-12 text-white placeholder-slate-600 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm font-bold transition-all duration-300" placeholder="Shinji Ikari">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-neon-pink font-bold text-xs uppercase tracking-wide" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[11px] uppercase tracking-widest font-black text-slate-400 mb-2">{{ __('Email address') }}</label>
            <div class="relative rounded-xl shadow-inner group/input">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500 group-focus-within/input:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input wire:model="email" id="email" type="email" required autocomplete="username" class="block w-full rounded-xl bg-slate-900/50 border border-white/10 py-3 pl-12 text-white placeholder-slate-600 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm font-bold transition-all duration-300" placeholder="pilot@careerflow.ai">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-neon-pink font-bold text-xs uppercase tracking-wide" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[11px] uppercase tracking-widest font-black text-slate-400 mb-2">{{ __('Password') }}</label>
            <div class="relative rounded-xl shadow-inner group/input">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500 group-focus-within/input:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input wire:model="password" id="password" type="password" required autocomplete="new-password" class="block w-full rounded-xl bg-slate-900/50 border border-white/10 py-3 pl-12 text-white placeholder-slate-600 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm font-bold transition-all duration-300" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-neon-pink font-bold text-xs uppercase tracking-wide" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-[11px] uppercase tracking-widest font-black text-slate-400 mb-2">{{ __('Confirm Password') }}</label>
            <div class="relative rounded-xl shadow-inner group/input">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500 group-focus-within/input:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <input wire:model="password_confirmation" id="password_confirmation" type="password" required autocomplete="new-password" class="block w-full rounded-xl bg-slate-900/50 border border-white/10 py-3 pl-12 text-white placeholder-slate-600 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm font-bold transition-all duration-300" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-neon-pink font-bold text-xs uppercase tracking-wide" />
        </div>

        <div class="mt-8">
            <button type="submit" class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-neon-cyan/80 hover:from-brand-500 hover:to-neon-cyan px-4 py-3.5 text-xs font-black uppercase tracking-widest text-white shadow-[0_0_20px_rgba(139,92,246,0.4)] hover:shadow-[0_0_30px_rgba(34,211,238,0.5)] transition-all duration-300 group">
                {{ __('Create Account') }}
                <svg class="ml-2 w-4 h-4 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
        
        <p class="mt-8 text-center text-sm font-bold text-slate-400">
            Already registered?
            <a href="{{ route('login') }}" wire:navigate class="text-brand-400 hover:text-brand-300 transition-colors drop-shadow-[0_0_5px_rgba(139,92,246,0.5)] ml-1">Sign in here</a>
        </p>
    </form>
</div>
