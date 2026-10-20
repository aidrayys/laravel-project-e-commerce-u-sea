@props(['mode' => 'login'])

<div id="authCard" data-initial-mode="{{ $mode }}">
    {{-- Login Form --}}
    <div id="loginFormContainer" class="auth-form {{ $mode === 'login' ? 'active' : '' }}">
        @if (session('status'))
            <div class="alert alert-success" style="margin-bottom: 1rem;">{{ session('status') }}</div>
        @endif

        <div class="text-center mb-6">
            <h2 class="auth-card-title">{{ __('Welcome back') }}</h2>
            <p class="auth-card-subtitle">{{ __('Sign in to your U-Sea account') }}</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="login_email" class="form-label">{{ __('Email address') }}</label>
                <input id="login_email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus autocomplete="username" placeholder="you@example.com">
                @error('email')
                    <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="login_password" class="form-label">{{ __('Password') }}</label>
                <input id="login_password" type="password" name="password" class="form-input" required autocomplete="current-password" placeholder="••••••••">
                @error('password')
                    <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                <label for="remember_me" class="inline-flex items-center" style="display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input id="remember_me" type="checkbox" name="remember" style="width: 1rem; height: 1rem; accent-color: var(--ocean);">
                    <span style="font-size: 0.875rem; color: var(--navy);">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 0.875rem; font-weight: 700; color: var(--ocean);">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">{{ __('Sign in') }}</button>

            <div class="auth-toggle">
                <span>{{ __('Belum punya akun?') }}</span>
                <button type="button" onclick="switchAuthMode('register')">{{ __('Daftar') }}</button>
            </div>
        </form>
    </div>

    {{-- Register Form --}}
    <div id="registerFormContainer" class="auth-form {{ $mode === 'register' ? 'active' : '' }}">
        <div class="text-center mb-6">
            <h2 class="auth-card-title">{{ __('Create your account') }}</h2>
            <p class="auth-card-subtitle">{{ __('Join U-Sea and start supporting local fishermen') }}</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="register_name" class="form-label">{{ __('Full name') }}</label>
                <input id="register_name" type="text" name="name" value="{{ old('name') }}" class="form-input" required autofocus autocomplete="name" placeholder="Your name">
                @error('name')
                    <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="register_email" class="form-label">{{ __('Email address') }}</label>
                <input id="register_email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autocomplete="username" placeholder="you@example.com">
                @error('email')
                    <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="register_password" class="form-label">{{ __('Password') }}</label>
                <input id="register_password" type="password" name="password" class="form-input" required autocomplete="new-password" placeholder="••••••••">
                @error('password')
                    <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="register_password_confirmation" class="form-label">{{ __('Confirm password') }}</label>
                <input id="register_password_confirmation" type="password" name="password_confirmation" class="form-input" required autocomplete="new-password" placeholder="••••••••">
                @error('password_confirmation')
                    <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">{{ __('Create account') }}</button>

            <div class="auth-toggle">
                <span>{{ __('Sudah punya akun?') }}</span>
                <button type="button" onclick="switchAuthMode('login')">{{ __('Login') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchAuthMode(mode) {
        const loginContainer = document.getElementById('loginFormContainer');
        const registerContainer = document.getElementById('registerFormContainer');

        if (mode === 'login') {
            loginContainer.classList.add('active');
            registerContainer.classList.remove('active');

            const emailInput = document.getElementById('login_email');
            if (emailInput) emailInput.focus();

            if (window.history.replaceState) {
                window.history.replaceState({}, '', '{{ route('login') }}');
            }
        } else {
            loginContainer.classList.remove('active');
            registerContainer.classList.add('active');

            const nameInput = document.getElementById('register_name');
            if (nameInput) nameInput.focus();

            if (window.history.replaceState) {
                window.history.replaceState({}, '', '{{ route('register') }}');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const card = document.getElementById('authCard');
        if (card) {
            switchAuthMode(card.dataset.initialMode);
        }
    });
</script>
