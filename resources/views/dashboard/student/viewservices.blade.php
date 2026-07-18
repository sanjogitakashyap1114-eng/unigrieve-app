@extends('layouts.dashboard')
@section('content')
<div class="container-fluid py-4">

    {{-- BACK LINK --}}
    <div class="mb-3">
        <a href="{{ route('student.myservices') }}" class="btn btn-sm btn-light border text-secondary fw-semibold px-3">
            ← Back to List
        </a>
    </div>

    {{-- WARNING ALERT --}}
    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center p-3 mb-4">
        <div class="me-2 fs-4">⚠️</div>
        <div>
            <strong class="d-block text-warning-emphasis">Notice: Request locks after submission.</strong>
            <span class="text-muted small">Modifications or data tuning are prohibited at this stage.</span>
        </div>
    </div>

    {{-- MAIN CARD --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <span class="text-uppercase text-muted fw-bold small">Service Application</span>
                <h4 class="fw-bold text-dark mb-0 mt-1">{{ $service->service_id }}</h4>
            </div>
            <div>
                @if(strtolower($service->status) == 'pending')
                    <span class="badge bg-warning text-dark px-3 py-2 fs-6">Pending</span>
                @elseif(strtolower($service->status) == 'approved')
                    <span class="badge bg-success px-3 py-2 fs-6">Approved</span>
                @else
                    <span class="badge bg-danger px-3 py-2 fs-6">Rejected</span>
                @endif
            </div>
        </div>

        <div class="card-body p-4">

            {{-- SECTION 1: STUDENT PROFILE --}}
            <div class="mb-4">
                <h5 class=" fw-bold mb-3"><span class="section-number">1</span> Student Profile & Academic Details</h5>
                <div class="row g-3 bg-light p-3 rounded border">
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block text-uppercase architecture-label">Student Name</small>
                        <span class="fw-semibold text-dark fs-6">{{ auth()->user()->studentMaster->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block text-uppercase architecture-label">Registration No</small>
                        <span class="fw-semibold text-dark fs-6">{{ auth()->user()->studentMaster->registration_no ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block text-uppercase architecture-label">Department</small>
                        <span class="fw-semibold text-dark fs-6">{{ auth()->user()->studentMaster->department ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block text-uppercase architecture-label">Contact No</small>
                        <span class="fw-semibold text-dark fs-6">{{ auth()->user()->studentMaster->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-6 mt-2">
                        <small class="text-muted d-block text-uppercase architecture-label">Email</small>
                        <span class="fw-semibold text-dark fs-6">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="col-md-6 mt-2">
                        <small class="text-muted d-block text-uppercase architecture-label">Submission Date</small>
                        <span class="fw-semibold text-dark fs-6">{{ $service->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                </div>
            </div>

            <hr class="my-4 opacity-25">

            {{-- SECTION 2: SERVICE DETAILS --}}
            <div class="mb-4">
                <h5 class=" fw-bold mb-3"><span class="badge bg-primary-subtle text-primary me-2">2</span>Technical & Core Specifications</h5>

                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase small fw-bold mb-1">Requested Service Type</small>
                    <span class="badge bg-dark px-3 py-2">{{ $service->service_type }}</span>
                </div>

                {{-- Additional Details JSON --}}
                @if(!empty($service->additional_details))
                    @php
                        $details = is_array($service->additional_details)
                            ? $service->additional_details
                            : json_decode($service->additional_details, true);
                    @endphp
                    @if($details)
                    <div class="row g-3 bg-light p-3 rounded border mb-3">
                        @foreach($details as $key => $value)
                            <div class="col-md-4">
                                <small class="text-muted d-block text-uppercase architecture-label fw-bold">{{ str_replace('_', ' ', ucfirst($key)) }}</small>
                                <span class="fw-bold text-secondary-emphasis">{{ $value ?? 'N/A' }}</span>
                            </div>
                        @endforeach
                    </div>
                    @endif
                @endif

                <div class="mb-0">
                    <small class="text-muted d-block text-uppercase small fw-bold mb-1">Student Statement / Purpose</small>
                    <div class="p-3 bg-white border rounded text-secondary">
                        {{ $service->description }}
                    </div>
                </div>
            </div>

            <hr class="my-4 opacity-25">

            {{-- SECTION 3: EVIDENCE DOCUMENTS --}}
            <div>
                <h5 class=" fw-bold mb-3"><span class="badge bg-primary-subtle  me-2">3</span>Uploaded Validation Documents</h5>
                <div class="bg-light p-4 rounded border">
                    @if($service->evidence)
                        @php
                            $docs = is_array($service->evidence)
                                ? $service->evidence
                                : json_decode($service->evidence, true);
                        @endphp

                        @if($docs && count($docs) > 0)
                            <div class="row g-3">
                                @foreach($docs as $doc)
                                    @php
                                        $ext = strtolower(pathinfo($doc['path'], PATHINFO_EXTENSION));
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="border rounded bg-white p-3 shadow-sm">
                                            <small class="text-muted d-block fw-bold text-uppercase mb-2">
                                                {{ $doc['label'] ?? 'Document' }}
                                            </small>

                                            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                <img src="{{ asset('storage/' . $doc['path']) }}"
                                                    class="img-fluid rounded mb-2"
                                                    style="max-height: 200px; object-fit: contain;"
                                                    alt="{{ $doc['label'] ?? 'Document' }}">
                                                <div>
                                                    <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary px-3">🔍 View</a>
                                                </div>

                                            @elseif($ext === 'pdf')
                                                <div class="mb-2">
                                                    <embed src="{{ asset('storage/' . $doc['path']) }}"
                                                        type="application/pdf" width="100%" height="200px" class="rounded"/>
                                                </div>
                                                <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary me-2">👁️ Open</a>
                                                <a href="{{ asset('storage/' . $doc['path']) }}" download
                                                    class="btn btn-sm btn-primary">📥 Download</a>

                                            @else
                                                <div class="text-center py-2">
                                                    <span class="fs-2">📄</span>
                                                    <p class="mb-2 text-muted small text-truncate">{{ basename($doc['path']) }}</p>
                                                    <a href="{{ asset('storage/' . $doc['path']) }}" download
                                                        class="btn btn-sm btn-primary px-3">📥 Download</a>
                                                </div>
                                            @endif

                                            <small class="text-muted d-block mt-2" style="font-size:0.7rem;">
                                                Uploaded: {{ $doc['uploaded_at'] ?? '' }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-3 text-muted text-center">
                                <span class="fs-3 d-block mb-1">📁</span>
                                <span class="small">No documents uploaded.</span>
                            </div>
                        @endif
                    @else
                        <div class="py-3 text-muted text-center">
                            <span class="fs-3 d-block mb-1">📁</span>
                            <span class="small">No mandatory documents uploaded for verification.</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .architecture-label { font-size: 0.72rem; letter-spacing: 0.5px; }
    small.text-muted { font-size: 0.75rem; }
</style>
@endsection