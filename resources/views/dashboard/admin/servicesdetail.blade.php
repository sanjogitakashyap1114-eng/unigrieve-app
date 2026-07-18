@extends('layouts.dashboard')

@section('content')

    @php
        // Relational Chain: service_requests (student_id) -> users (student_master_id) -> student_masters (id)
        $userAccount = $requestDetails->student ?? null;
        $studentProfile = $userAccount->studentMaster ?? null;
    @endphp

    <div class="container-fluid p-3 p-md-4">

        <div class="mb-3">
            <a href="{{route('services.index')}}" class="btn btn-sm btn-light border text-muted text-xs fw-semibold">
                &larr; Back to Service Registry
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <span class="small fw-semibold">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-brand-primary text-white py-3">
                        <h2 class="h6 mb-0 fw-bold">Service Request Details ({{ $requestDetails->service_id }})</h2>
                    </div>
                    <div class="card-body p-4 text-dark">

                        <h3 class="h6 border-bottom pb-2 fw-bold text-brand-primary text-uppercase text-xs mb-3">Student
                            Master Information</h3>
                        @if ($studentProfile)
                            <div class="row g-3 mb-4 text-sm">
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Student Full Name</span>
                                    <span class="fw-bold text-dark fs-6">{{ $studentProfile->name }}</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Registration Number</span>
                                    <span
                                        class="font-monospace fw-bold text-dark fs-6">{{ $studentProfile->registration_no }}</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Email Address</span>
                                    <span>{{ $studentProfile->email }}</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Phone / Contact</span>
                                    <span>{{ $studentProfile->phone ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Department</span>
                                    <span><span
                                            class="badge bg-secondary text-white">{{ $studentProfile->department }}</span></span>
                                </div>
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Course & Batch</span>
                                    <span>{{ $studentProfile->course }} (Batch: {{ $studentProfile->batch }})</span>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning text-xs p-3 mb-4 rounded border-0 shadow-sm">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> User account exists, but no linked
                                profile found in the Student Master Table.
                            </div>
                        @endif

                        <h3 class="h6 border-bottom pb-2 fw-bold text-brand-primary text-uppercase text-xs mb-3">Service
                            Parameters</h3>
                        <div class="mb-4 text-sm">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Service Type</span>
                                    <span class="fw-bold text-brand-primary fs-5">{{ $requestDetails->service_type }}</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Current Status</span>
                                    <span
                                        class="badge bg-warning text-dark px-2 py-1 rounded text-xs fw-bold">{{ $requestDetails->status }}</span>
                                </div>
                            </div>
                            @if (!empty($requestDetails->additional_details))
                                @php
                                    $addDetails = is_array($requestDetails->additional_details)
                                        ? $requestDetails->additional_details
                                        : json_decode($requestDetails->additional_details, true);
                                @endphp
                                <div class="mb-3 p-3 bg-light rounded border">
                                    <span class="detail-card-label d-block mb-2">Additional Specifications (Form
                                        Properties)</span>
                                    <div class="row g-2">
                                        @foreach ($addDetails as $key => $value)
                                            <div class="col-6 col-sm-4 text-xs">
                                                <strong
                                                    class="text-secondary text-uppercase">{{ str_replace('_', ' ', $key) }}:</strong>
                                                <span
                                                    class="text-dark fw-medium">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-2">
                                <span class="detail-card-label d-block">Description / Student Remarks</span>
                                <p class="text-muted bg-light p-3 rounded border small mb-0">
                                    {{ $requestDetails->description ?? 'No explanation entries specified.' }}</p>
                            </div>
                        </div>

                        <h3 class="h6 border-bottom pb-2 fw-bold text-brand-primary text-uppercase text-xs mb-3">Uploaded
                            Verification Evidence</h3>
                        @if (!empty($requestDetails->evidence))
                            @php
                                $docs = is_array($requestDetails->evidence)
                                    ? $requestDetails->evidence
                                    : json_decode($requestDetails->evidence, true);
                            @endphp

                            @if ($docs && count($docs) > 0)
                                <div class="row g-3">
                                    @foreach ($docs as $doc)
                                        @php $ext = strtolower(pathinfo($doc['path'], PATHINFO_EXTENSION)); @endphp
                                        <div class="col-12">
                                            <div
                                                class="border rounded bg-light p-3 d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="fs-4">
                                                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                            🖼️
                                                        @elseif($ext === 'pdf')
                                                            📄
                                                        @else
                                                            📎
                                                        @endif
                                                    </span>
                                                    <div>
                                                        <span
                                                            class="d-block fw-semibold text-dark small">{{ $doc['label'] ?? 'Document' }}</span>
                                                        <span class="text-muted font-monospace"
                                                            style="font-size:0.7rem;">{{ basename($doc['path']) }}</span>
                                                        <span class="text-muted d-block"
                                                            style="font-size:0.7rem;">{{ $doc['uploaded_at'] ?? '' }}</span>
                                                    </div>
                                                </div>
                                                <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank"
                                                    class="btn btn-sm btn-primary bg-brand-primary border-0 text-xs px-3 fw-bold">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="alert alert-secondary py-2 text-xs mb-0 border-0">
                                No files or verification proofs uploaded with this request.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom py-3">
                        <h2 class="h6 mb-0 fw-bold text-dark">Management Controls</h2>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('services.update', $requestDetails->id) }}" method="POST"
                            class="d-flex flex-column gap-3">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="form-label text-xs fw-bold text-uppercase text-muted mb-1">Reassign Department
                                    Unit</label>
                                <select name="department_id" class="form-select text-sm" required>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ $requestDetails->department_id == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit"
                                class="btn btn-primary bg-brand-primary border-0 w-100 text-sm fw-semibold py-2 mt-2">
                                Reassign Department
                            </button>
                        </form>
                       @if ($requestDetails->status !== 'Rejected')
    <div class="mt-3 pt-3 border-top">

        {{-- Hidden Form --}}
        <form id="reject-form-{{ $requestDetails->id }}"
              action="{{ route('services.reject', $requestDetails->id) }}"
              method="POST" class="d-none">
            @csrf
            @method('PATCH')
        </form>

        {{-- Button --}}
        <button type="button"
                class="btn btn-outline-danger w-100 text-xs py-2 fw-semibold btn-reject-action"
                data-form-id="reject-form-{{ $requestDetails->id }}">
            Reject Application File
        </button>

    </div>
@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
    @vite(['resources/js/global.js'])
@endpush
@endsection
