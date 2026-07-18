@extends('layouts.auth')

@section('title')
Forgot Password
@endsection

@section('content')
<div class="container-fluid auth-container">
    <div class="row auth-wrapper justify-content-center">
        <div class="col-lg-6 auth-right">
            <a href="{{ route('login') }}" class="btn btn-outline-secondary mb-4 btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Login
            </a>
            
            <h3>Forgot Password</h3>
            <p class="text-muted">Enter your details below to receive a password reset link.</p>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus required>
                        
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    {{ __('Send Password Reset Link') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection