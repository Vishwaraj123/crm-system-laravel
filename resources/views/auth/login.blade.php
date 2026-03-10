<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark">{{ __('Welcome Back') }}</h4>
        <p class="text-muted small">{{ __('Please enter your credentials to access your account.') }}</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success border-0 mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label small fw-bold text-muted">{{ __('Email Address') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="las la-envelope fs-5"></i>
                </span>
                <input id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                    type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    placeholder="name@company.com" />
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label small fw-bold text-muted">{{ __('Password') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="las la-lock fs-5"></i>
                </span>
                <input id="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                    type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label small text-muted" for="remember_me">
                    {{ __('Remember me') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-decoration-none small fw-bold text-primary" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="d-grid mt-4">
            <button type="submit"
                class="btn btn-primary d-flex align-items-center justify-content-center gap-3 py-3 fw-bold shadow-sm border-0"
                style="font-size: 1.1rem;">
                <span>{{ __('Log in') }}</span>
                <i class="las la-sign-in-alt fs-4"></i>
            </button>
        </div>

        {{-- @if (Route::has('register'))
            <div class="mt-4 text-center">
                <p class="small text-muted mb-0">{{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}"
                        class="text-primary fw-bold text-decoration-none">{{ __('Register Now') }}</a>
                </p>
            </div>
        @endif --}}
    </form>
</x-guest-layout>
