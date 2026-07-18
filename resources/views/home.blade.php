@extends('layouts.dashboard')
@section('title')
Dashboard
@endsection
@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <button class="btn btn-primary">Primary Button</button>
    <button class="btn btn-success">Success Button</button>

    <div class="alert alert-danger mt-3">
        Bootstrap is working correctly.
    </div>
</div> --}}
@endsection
