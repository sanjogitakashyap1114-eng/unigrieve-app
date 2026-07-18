@extends('layouts.auth')

@section('content')
<div class="fluid-container auth-container">
    <div class="row auth-wrapper">

        <div class="col-lg-6 auth-left">
            <a href="/" class="btn btn-outline-light mb-4">
                <i class="bi bi-arrow-left"></i> Back to Home
            </a>

            <h2>One Platform for Services and Support</h2>
            <p>
                Create an account to submit requests, manage complaints,
                and access all platform services from a centralized dashboard.
            </p>
        </div>

        <div class="col-lg-6 auth-right">
            <h3 class="mb-4">Student Registration</h3>
            <p class="mb-3">
                Create your account using your Registration ID
            </p>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="global-validate-form" novalidate>
                @csrf

                {{-- Registration ID --}}
                <div class="mb-3 position-relative">
                    <label for="regId" class="form-label">Register No<span class="text-danger">*</label></span>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input id="regId" type="text" name="regId" value="{{ old('regId') }}" required class="form-control @error('regId') is-invalid @enderror">
                    </div>
                    @error('regId')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3 position-relative">
                    <label for="email" class="form-label">Email<span class="text-danger">*</label></span>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control @error('email') is-invalid @enderror">
                    </div>
                    @error('email')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Password<span class="text-danger">*</label></span>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input id="password" type="password" name="password" minlength="6" required class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                    </div>
                    @error('password')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3 position-relative">
                    <label for="password-confirm" class="form-label">Confirm Password   <span class="text-danger">*</label></span>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input id="password-confirm" type="password" name="password_confirmation" data-match="password" required class="form-control" autocomplete="new-password">
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </div>

                <div class="text-center">
                    Already have an account? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>

    </div>
</div>

@push('scripts')
    @vite(['resources/js/global.js'])
@endpush
@endsection