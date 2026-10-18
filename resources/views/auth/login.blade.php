<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-[#0B1F3A]">{{ __('Welcome back') }}</h2>
        <p class="mt-1 text-sm text-[#64748b]">{{ __('Sign in to your U-Sea account') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1.5 block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#087EA4] shadow-sm focus:ring-[#087EA4]" name="remember">
                <span class="ms-2 text-sm text-[#0B1F3A]">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-[#087EA4] hover:text-[#065f7a] focus:outline-none focus:ring-2 focus:ring-[#18AEE5] focus:ring-offset-2 rounded" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Sign in') }}
        </x-primary-button>

        <div class="pt-5 border-t border-[#DDF7F5] text-center">
            <span class="text-sm text-[#64748b]">{{ __('Belum punya akun?') }}</span>
            <a href="{{ route('register') }}" class="text-sm font-semibold text-[#087EA4] hover:text-[#065f7a] underline underline-offset-2">
                {{ __('Daftar') }}
            </a>
        </div>
    </form>
</x-guest-layout>
