<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-[#0B1F3A]">{{ __('Reset your password') }}</h2>
        <p class="mt-2 text-sm text-[#64748b]">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Email Password Reset Link') }}
        </x-primary-button>

        <p class="text-center text-sm text-[#64748b]">
            <a href="{{ route('login') }}" class="font-semibold text-[#087EA4] hover:text-[#065f7a]">
                {{ __('Back to sign in') }}
            </a>
        </p>
    </form>
</x-guest-layout>
