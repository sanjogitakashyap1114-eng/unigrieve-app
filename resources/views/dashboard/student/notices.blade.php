@extends('layouts.dashboard')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>

                <h3 class="fw-bold mb-1">

                    <i class="fas fa-bullhorn text-danger me-2"></i>

                    Department Notices

                </h3>

                <p class="text-muted mb-0">

                    Stay updated with the latest announcements published by all university departments.

                </p>

            </div>

            <a href="{{ route('student.dashboard') }}"
               class="btn btn-outline-secondary">

                <i class="fas fa-arrow-left me-2"></i>

                Back

            </a>

        </div>

    </div>

    {{-- Notices --}}

    @forelse($notices as $notice)

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <h5 class="fw-bold">

                            {{ $notice->title }}

                        </h5>

                        <small class="text-primary">

                            Published :
                            {{ $notice->created_at->format('d M Y') }}

                        </small>

                    </div>

                    @if($notice->last_date)

                        <span class="badge bg-danger align-self-start">

                            Last Date :
                            {{ \Carbon\Carbon::parse($notice->last_date)->format('d M Y') }}

                        </span>

                    @endif

                </div>

                <hr>

                <p class="mb-3">

                    {{ $notice->description }}

                </p>

                @if($notice->attachment)

                    <a href="{{ asset('storage/'.$notice->attachment) }}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm">

                        <i class="fas fa-paperclip me-2"></i>

                        View Attachment

                    </a>

                @endif

            </div>

        </div>

    @empty

        <div class="card shadow-sm">

            <div class="card-body text-center py-5">

                <i class="fas fa-bullhorn fa-4x text-secondary mb-3"></i>

                <h4>

                    No Notices Available

                </h4>

                <p class="text-muted">

                    There are currently no published notices.

                </p>

            </div>

        </div>

    @endforelse

    <div class="mt-4">

        {{ $notices->links() }}

    </div>

</div>

@endsection