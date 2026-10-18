<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-[#0B1F3A]">{{ __('Create your account') }}</h2>
        <p class="mt-1 text-sm text-[#64748b]">{{ __('Join U-Sea and start supporting local fishermen') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full name')" />
            <x-text-input id="name" class="mt-1.5 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1.5 block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm password')" />
            <x-text-input id="password_confirmation" class="mt-1.5 block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Create account') }}
        </x-primary-button>

        <div class="pt-5 border-t border-[#DDF7F5] text-center">
            <span class="text-sm text-[#64748b]">{{ __('Sudah punya akun?') }}</span>
            <a href="{{ route('login') }}" class="text-sm font-semibold text-[#087EA4] hover:text-[#065f7a] underline underline-offset-2">
                {{ __('Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
