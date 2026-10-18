<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-[#0B1F3A]">{{ __('Confirm your password') }}</h2>
        <p class="mt-2 text-sm text-[#64748b]">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

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

        <x-primary-button class="w-full justify-center">
            {{ __('Confirm') }}
        </x-primary-button>
    </form>
</x-guest-layout>
