@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 text-center fw-bold fs-4 rounded-top-4">
                    {{ __('Register') }}
                </div>

                <div class="card-body p-4">
                    {{-- Social login buttons --}}

                    {{-- Registration form --}}
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <div class="form-floating position-relative">
                                <input id="name" type="text"
                                    class="form-control rounded-pill ps-5 @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" placeholder="Full name" required autofocus>
                                <label for="name" class="ps-5">{{ __('Full Name') }}</label>
                                <i class="bi bi-person-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                            </div>
                            @error('name')
                                <div class="text-danger small ms-2 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <div class="form-floating position-relative">
                                <input id="email" type="email"
                                    class="form-control rounded-pill ps-5 @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                                <label for="email" class="ps-5">{{ __('Email Address') }}</label>
                                <i class="bi bi-envelope-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                            </div>
                            @error('email')
                                <div class="text-danger small ms-2 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <div class="form-floating position-relative">
                                <input id="password" type="password"
                                    class="form-control rounded-pill ps-5 @error('password') is-invalid @enderror"
                                    name="password" placeholder="Password" required>
                                <label for="password" class="ps-5">{{ __('Password') }}</label>
                                <i class="bi bi-lock-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                            </div>
                            @error('password')
                                <div class="text-danger small ms-2 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-4">
                            <div class="form-floating position-relative">
                                <input id="password-confirm" type="password"
                                    class="form-control rounded-pill ps-5"
                                    name="password_confirmation" placeholder="Repeat password" required>
                                <label for="password-confirm" class="ps-5">{{ __('Confirm Password') }}</label>
                                <i class="bi bi-shield-lock-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 fs-6">
                                <i class="bi bi-person-plus-fill me-1"></i> {{ __('Register') }}
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <small>{{ __('Already have an account?') }}
                            <a href="{{ route('login') }}" class="text-decoration-none">{{ __('Login') }}</a>
                        </small>
                    </div>

                    <div class="mb-4 text-center">
                        <p class="text-muted small mt-3">hoặc đăng ký bằng email</p>
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
