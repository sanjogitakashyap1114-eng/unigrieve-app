@extends('layouts.dashboard')
@section('content')
<div class="container-fluid py-4">

    {{-- BACK LINK --}}
    <div class="mb-3">
        <a href="{{ route('student.mycomplaint') }}" class="btn btn-sm btn-light border text-secondary fw-semibold px-3">
            <i class="bi bi-arrow-left"></i> ← Back to List
        </a>
    </div>

    {{-- WARNING ALERT ON TOP --}}
    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center p-3 mb-4" role="alert">
        <div class="me-2 fs-4 text-warning">⚠️</div>
        <div>
            <strong class="d-block text-warning-emphasis">Notice: This complaint has already been submitted.</strong>
            <span class="text-muted small">You cannot edit or alter any details of this grievance record.</span>
        </div>
    </div>

    {{-- MAIN PROFESSIONAL SINGLE CARD --}}
    <div class="card border-0 shadow-sm custom-complaint-card">
        
        {{-- CARD HEADER WITH STATUS BADGE --}}
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <span class="text-uppercase text-muted fw-bold tracking-wider small">Grievance Record</span>
                <h4 class="fw-bold text-dark mb-0 mt-1">{{$complaint->complaint_id}}</h4>
            </div>
            <div>
                @if(strtolower($complaint->status) == 'pending')
                    <span class="badge status-badge bg-warning text-dark px-3 py-2 fw-semibold">Pending</span>
                @elseif(strtolower($complaint->status) == 'in progress' || strtolower($complaint->status) == 'in_progress')
                    <span class="badge status-badge bg-primary text-white px-3 py-2 fw-semibold">In Progress</span>
                @elseif(strtolower($complaint->status) == 'resolved')
                    <span class="badge status-badge bg-success text-white px-3 py-2 fw-semibold">Resolved</span>
                @else
                    <span class="badge status-badge bg-danger text-white px-3 py-2 fw-semibold">Rejected</span>
                @endif
            </div>
        </div>

        <div class="card-body p-4">
            

{{-- SECTION 1: STUDENT PROFILE & ACADEMIC DETAILS --}}
<div class="complaint-section mb-4">
    <h6 class="section-title  fw-bold mb-3">
        <span class="section-number">1</span> Student Profile & Academic Details
    </h6>
    <div class="row g-3 bg-light p-3 rounded border">
        <div class="col-md-3 col-sm-6">
            <small class="text-muted d-block text-uppercase architecture-label">Student Name</small>
            <span class="fw-semibold text-dark fs-6">
                {{ auth()->user()->studentMaster->name ?? 'N/A' }}
            </span>
        </div>
        <div class="col-md-3 col-sm-6">
            <small class="text-muted d-block text-uppercase architecture-label">Registration / Roll No</small>
            <span class="fw-semibold text-dark fs-6">
                {{ auth()->user()->studentMaster->registration_no ?? 'N/A' }}
            </span>
        </div>
        <div class="col-md-3 col-sm-6">
            <small class="text-muted d-block text-uppercase architecture-label">Department / Branch</small>
            <span class="fw-semibold text-dark fs-6">
                {{ auth()->user()->studentMaster->department ?? 'N/A' }}
            </span>
        </div>
        <div class="col-md-3 col-sm-6">
            <small class="text-muted d-block text-uppercase architecture-label">Contact No</small>
            <span class="fw-semibold text-dark fs-6">
                {{ auth()->user()->studentMaster->phone ?? 'Not Updated' }}
            </span>
        </div>
        <div class="col-md-6 mt-2">
            <small class="text-muted d-block text-uppercase architecture-label">Official Email</small>
            <span class="fw-semibold text-dark fs-6">
                {{ auth()->user()->studentMaster->email ?? auth()->user()->email }}
            </span>
        </div>
        <div class="col-md-6 mt-2">
            <small class="text-muted d-block text-uppercase architecture-label">Submission Date & Time</small>
            <span class="fw-semibold text-dark fs-6">
                {{ $complaint->created_at->format('d M Y, h:i A') }}
            </span>
        </div>
    </div>
</div>

            <hr class="my-4 text-muted opacity-25">

            {{-- SECTION 2: COMPLAINT INFORMATION --}}
            <div class="complaint-section mb-4">
                <h5 class="section-title  fw-bold mb-3">
                    <span class="section-number">2</span> Complaint Information
                </h5>
                
                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase mb-1">Grievance Category</small>
                    <span class="badge bg-secondary px-2.5 py-1.5 font-medium">{{ $complaint->category }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase mb-1">Complaint Title</small>
                    <h5 class="fw-bold text-dark-emphasis">{{ $complaint->title }}</h5>
                </div>

                <div class="mb-0">
                    <small class="text-muted d-block text-uppercase mb-2">Detailed Description</small>
                    <div class="description-box p-3 bg-white border rounded text-secondary shadow-inner">
                        {{ $complaint->description ?? 'No written statement provided.' }}
                    </div>
                </div>
            </div>

            <hr class="my-4 text-muted opacity-25">
{{-- SECTION 3: ATTACHED EVIDENCE / DOCUMENTS --}}
<div class="complaint-section">
    <h5 class="section-title  fw-bold mb-3">
        <span class="section-number">3</span> Attached Evidence / Documents
    </h5>

    <div class="bg-light p-4 rounded border text-center shadow-inner">
       @if($complaint->evidence)
    @php
        $docs = is_array($complaint->evidence) 
            ? $complaint->evidence 
            : json_decode($complaint->evidence, true);
    @endphp

    @if($docs && count($docs) > 0)
        <div class="row g-3">
            @foreach($docs as $doc)
                @php
                    $ext = strtolower(pathinfo($doc['path'], PATHINFO_EXTENSION));
                @endphp
                <div class="col-md-6">
                    <div class="border rounded bg-white p-3 shadow-sm">
                        {{-- Label --}}
                        <small class="text-muted d-block fw-bold text-uppercase mb-2">{{ $doc['label'] ?? 'Document' }}</small>

                        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <img src="{{ asset('storage/' . $doc['path']) }}" class="img-fluid rounded mb-2" style="max-height: 200px; object-fit: contain;" alt="{{ $doc['label'] }}">
                            <div>
                                <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary px-3">🔍 View</a>
                            </div>

                        @elseif($ext === 'pdf')
                            <div class="mb-2">
                                <embed src="{{ asset('storage/' . $doc['path']) }}" type="application/pdf" width="100%" height="200px" class="rounded"/>
                            </div>
                            <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">👁️ Open</a>
                            <a href="{{ asset('storage/' . $doc['path']) }}" download class="btn btn-sm btn-primary">📥 Download</a>

                        @else
                            <div class="text-center py-2">
                                <span class="fs-2">📄</span>
                                <p class="mb-2 text-muted small text-truncate">{{ basename($doc['path']) }}</p>
                                <a href="{{ asset('storage/' . $doc['path']) }}" download class="btn btn-sm btn-primary px-3">📥 Download</a>
                            </div>
                        @endif

                        <small class="text-muted d-block mt-2" style="font-size:0.7rem;">Uploaded: {{ $doc['uploaded_at'] ?? '' }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@else
    <div class="py-3 text-muted text-center">
        <span class="fs-3 d-block mb-1">📁</span>
        <span class="small">No supporting documents uploaded.</span>
    </div>
@endif
    </div>
</div>
            

        </div>
    </div>
</div>

{{-- CUSTOM PROFESSIONAL CSS STYLING --}}
<style>
   
</style>
@endsection