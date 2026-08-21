<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="animate-fade-in-up">
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-white tracking-tight drop-shadow-md">Welcome back</h2>
        <p class="mt-2 text-sm text-slate-400 font-bold">Enter your credentials to access your dashboard.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[11px] uppercase tracking-widest font-black text-slate-400 mb-2">{{ __('Email address') }}</label>
            <div class="relative rounded-xl shadow-inner group/input">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500 group-focus-within/input:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input wire:model="form.email" id="email" type="email" required autofocus autocomplete="username" class="block w-full rounded-xl bg-slate-900/50 border border-white/10 py-3 pl-12 text-white placeholder-slate-600 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm font-bold transition-all duration-300" placeholder="pilot@careerflow.ai">
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-neon-pink font-bold text-xs uppercase tracking-wide" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-[11px] uppercase tracking-widest font-black text-slate-400">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <div class="text-[11px] font-bold">
                        <a href="{{ route('password.request') }}" wire:navigate class="text-neon-cyan hover:text-cyan-300 transition-colors drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]">Forgot password?</a>
                    </div>
                @endif
            </div>
            <div class="relative rounded-xl shadow-inner group/input">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500 group-focus-within/input:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input wire:model="form.password" id="password" type="password" required autocomplete="current-password" class="block w-full rounded-xl bg-slate-900/50 border border-white/10 py-3 pl-12 text-white placeholder-slate-600 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm font-bold transition-all duration-300" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-neon-pink font-bold text-xs uppercase tracking-wide" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember" class="inline-flex items-center group/check cursor-pointer">
                <div class="relative flex items-center justify-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="peer appearance-none w-5 h-5 border border-white/20 rounded-md bg-slate-900/50 checked:bg-brand-500 checked:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:ring-offset-0 transition-all cursor-pointer shadow-inner">
                    <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="ml-3 text-sm font-bold text-slate-400 group-hover/check:text-slate-300 transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-8">
            <button type="submit" class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-neon-cyan/80 hover:from-brand-500 hover:to-neon-cyan px-4 py-3.5 text-xs font-black uppercase tracking-widest text-white shadow-[0_0_20px_rgba(139,92,246,0.4)] hover:shadow-[0_0_30px_rgba(34,211,238,0.5)] transition-all duration-300 group">
                {{ __('Sign In') }}
                <svg class="ml-2 w-4 h-4 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
        
        <p class="mt-8 text-center text-sm font-bold text-slate-400">
            Not a member?
            <a href="{{ route('register') }}" wire:navigate class="text-brand-400 hover:text-brand-300 transition-colors drop-shadow-[0_0_5px_rgba(139,92,246,0.5)] ml-1">Start automated applying</a>
        </p>
    </form>
</div>
