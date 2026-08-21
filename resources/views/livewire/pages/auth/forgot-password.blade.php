<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-white tracking-tight drop-shadow-md">Forgot Password</h2>
        <p class="mt-2 text-sm text-slate-400 font-bold">No problem. Just let us know your email address and we will email you a password reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[11px] uppercase tracking-widest font-black text-slate-400 mb-2">{{ __('Email address') }}</label>
            <div class="relative rounded-xl shadow-inner group/input">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500 group-focus-within/input:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input wire:model="email" id="email" type="email" required autofocus class="block w-full rounded-xl bg-slate-900/50 border border-white/10 py-3 pl-12 text-white placeholder-slate-600 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm font-bold transition-all duration-300" placeholder="pilot@careerflow.ai">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-neon-pink font-bold text-xs uppercase tracking-wide" />
        </div>

        <div class="mt-8">
            <button type="submit" class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-neon-cyan/80 hover:from-brand-500 hover:to-neon-cyan px-4 py-3.5 text-xs font-black uppercase tracking-widest text-white shadow-[0_0_20px_rgba(139,92,246,0.4)] hover:shadow-[0_0_30px_rgba(34,211,238,0.5)] transition-all duration-300 group">
                {{ __('Email Password Reset Link') }}
                <svg class="ml-2 w-4 h-4 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
        
        <p class="mt-8 text-center text-sm font-bold text-slate-400">
            Remembered your password?
            <a href="{{ route('login') }}" wire:navigate class="text-brand-400 hover:text-brand-300 transition-colors drop-shadow-[0_0_5px_rgba(139,92,246,0.5)] ml-1">Sign in here</a>
        </p>
    </form>
</div>
