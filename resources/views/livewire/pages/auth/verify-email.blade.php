<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-white tracking-tight drop-shadow-md">Verify Email</h2>
        <p class="mt-2 text-sm text-slate-400 font-bold">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-bold text-sm text-neon-cyan drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-8 flex flex-col space-y-4">
        <button wire:click="sendVerification" class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-neon-cyan/80 hover:from-brand-500 hover:to-neon-cyan px-4 py-3.5 text-xs font-black uppercase tracking-widest text-white shadow-[0_0_20px_rgba(139,92,246,0.4)] hover:shadow-[0_0_30px_rgba(34,211,238,0.5)] transition-all duration-300 group">
            {{ __('Resend Verification Email') }}
            <svg class="ml-2 w-4 h-4 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>

        <button wire:click="logout" type="submit" class="text-sm font-bold text-slate-400 hover:text-white transition-colors underline decoration-slate-600 hover:decoration-white">
            {{ __('Log Out') }}
        </button>
    </div>
</div>
