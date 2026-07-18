@extends('layouts.auth')
@section('title')
    Loginpage
@endsection

@section('content')
    <div class="conatiner-fluid auth-container">
        <div class="row auth-wrapper">
            <div class="col-lg-6 auth-left">
                <a href="/" class="btn btn-outline-light  mb-4">
                    <i class="bi bi-arrow-left"></i> Back to Home
                </a>
                <img src="" alt="">
                <h2>Welcome Back</h2>
                <p>Access all your services, requests, complaints, and updates from one centralized platform.</p>

            </div>
            <div class="col-lg-6    auth-right">
                <h3>Login</h3>
                <form action="{{ route('login') }}" method="POST">
                    @csrf


                    <div class="mb-3">
                        <label for="loginid" class="form-label">{{ __('User  ID') }}<span class="text-danger">*</label></span>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="text" id="regId" name="loginid" class="form-control" autofocus required>
                        </div>
                        @error('loginid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label global-validate-form">{{ __('Password') }}<span class="text-danger">*</label></span>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" class="form-control" autofocus required>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        {{ __('Login') }}
                    </button>
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot Password?</a>
                    </div>
                    <div class="text-center mt-3">
                        Don't have an account?
                        <a href="{{ route('register') }}">
                            Register
                        </a>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @vite(['resources/js/global.js'])
@endpush