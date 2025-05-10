@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white text-center border-0 py-4">
                    <h3 class="fw-bold">{{ __('Login to Your Account') }}</h3>
                </div>

                <div class="card-body px-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <div class="position-relative">
                                <i class="bi bi-envelope-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                                <input id="email" type="email"
                                    class="form-control ps-5 rounded-pill shadow-sm @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="you@example.com">
                            </div>
                            @error('email')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                            <div class="position-relative">
                                <i class="bi bi-lock-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                                <input id="password" type="password"
                                    class="form-control ps-5 pe-5 rounded-pill shadow-sm @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password"
                                    placeholder="Enter your password">
                                <i class="bi bi-eye-slash toggle-password position-absolute top-50 end-0 translate-middle-y me-3 text-secondary"
                                    style="cursor: pointer;" onclick="togglePassword()"></i>
                            </div>
                            @error('password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <script>
                            function togglePassword() {
                                const passwordInput = document.getElementById('password');
                                const icon = document.querySelector('.toggle-password');
                                
                                if (passwordInput.type === 'password') {
                                    passwordInput.type = 'text';
                                    icon.classList.remove('bi-eye-slash');
                                    icon.classList.add('bi-eye');
                                } else {
                                    passwordInput.type = 'password';
                                    icon.classList.remove('bi-eye');
                                    icon.classList.add('bi-eye-slash');
                                }
                            }
                        </script>

                        {{-- Remember Me --}}
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Login') }}
                            </button>
                        </div>

                        {{-- Forgot Password --}}
                        @if (Route::has('password.request'))
                        <div class="text-center mt-4">
                            <a class="text-decoration-none" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                        @endif
                    </form>

                    <div class="mt-4 text-center">
                        <small>{{ __('Already have an account?') }}
                            <a href="{{ route('register') }}" class="text-decoration-none">{{ __('Register') }}</a>
                        </small>
                    </div>
                    <div class="text-center my-3">
                        <span class="text-muted">or login with</span>
                        <hr>
                    </div>

                    <div class="mb-4 text-center">
                        <p class="text-muted small mt-3">hoặc đăng nhập bằng</p>
                        <a href="{{-- {{ route('auth.google') }} --}}" class="btn btn-outline-danger rounded-pill px-4 me-2">
                            <i class="bi bi-google me-1"></i> Google
                        </a>
                        <a href="{{-- {{ route('auth.facebook') }} --}}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="bi bi-facebook me-1"></i> Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
