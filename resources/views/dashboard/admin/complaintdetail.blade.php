@extends('layouts.dashboard')

@section('content')

    @php
        $userAccount = $complaintDetails->user ?? null;
        $studentProfile = $userAccount->studentMaster ?? null;
    @endphp
    <div class="container-fluid p-3 p-md-4">

        <div class="mb-3">
            <a href="{{ route('complaints.index') }}" class="btn btn-sm btn-light border text-muted text-xs fw-semibold">
                &larr; Back to Complaint Logs
            </a>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-brand-primary text-white py-3">
                        <h2 class="h6 mb-0 fw-bold">Case Record Overview
                            ({{ $complaintDetails->complaint_id ?? $complaintDetails->id }})</h2>
                    </div>
                    <div class="card-body p-4 text-dark">

                        <h3 class="h6 border-bottom pb-2 fw-bold text-brand-primary text-uppercase text-xs mb-3">Student
                            Identity Details</h3>
                        @if ($studentProfile)
                            <div class="row g-3 mb-4 text-sm">
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Student Full Name</span>
                                    <span class="fw-bold text-dark fs-6">{{ $studentProfile->name }}</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Registration Identification No</span>
                                    <span
                                        class="font-monospace fw-bold text-dark fs-6">{{ $studentProfile->registration_no }}</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Email Address</span>
                                    <span>{{ $studentProfile->email }}</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Academic Stream Group</span>
                                    <span><span
                                            class="badge bg-secondary text-white">{{ $studentProfile->department }}</span></span>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-secondary py-2 text-xs mb-4 border-0">
                                User account reference verified: <strong>{{ $userAccount->name ?? 'Guest User' }}</strong>.
                                No matching master structural profile.
                            </div>
                        @endif

                        <h3 class="h6 border-bottom pb-2 fw-bold text-brand-primary text-uppercase text-xs mb-3">Grievance
                            Statement Logs</h3>
                        <div class="mb-4 text-sm">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Grievance Classification Category</span>
                                    <span class="fw-bold text-brand-primary fs-6">{{ $complaintDetails->category }}</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="detail-card-label d-block">Lifecycle Tracking Status</span>
                                    <span
                                        class="badge bg-warning text-dark px-2 py-1 rounded text-xs fw-bold">{{ $complaintDetails->status }}</span>
                                </div>
                            </div>

                            <div class="mb-2">
                                <span class="detail-card-label d-block">Detailed Incident Narrative Description</span>
                                <p class="text-muted bg-light p-3 rounded border small mb-0">
                                    {{ $complaintDetails->description ?? 'No written records logged for this case.' }}</p>
                            </div>
                        </div>

                        <h3 class="h6 border-bottom pb-2 fw-bold text-brand-primary text-uppercase text-xs mb-3">Case Asset
                            Attachments</h3>
                        @if (!empty($complaintDetails->evidence))
                            @php
                                $docs = is_array($complaintDetails->evidence)
                                    ? $complaintDetails->evidence
                                    : json_decode($complaintDetails->evidence, true);
                            @endphp

                            @if ($docs && count($docs) > 0)
                                <div class="row g-3">
                                    @foreach ($docs as $doc)
                                        @php
                                            $ext = strtolower(pathinfo($doc['path'], PATHINFO_EXTENSION));
                                        @endphp
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
                            <div class="alert alert-light border py-2 text-xs mb-0 text-muted">
                                No file attachments uploaded with this complaint.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom py-3">
                        <h2 class="h6 mb-0 fw-bold text-dark">Routing Management Panel</h2>
                    </div>
                    <div class="card-body p-3">

                        <form action="{{ route('complaints.triage', $complaintDetails->id) }}" method="POST"
                            class="d-flex flex-column gap-3">
                            @csrf @method('PATCH')
                            <input type="hidden" name="action_type" value="reassign">

                            <div>
                                <label class="form-label text-xs fw-bold text-uppercase text-muted mb-1">Reassign
                                    Operational Unit</label>
                                <select name="department_id" class="form-select text-sm" required>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ $complaintDetails->department_id == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"
                                class="btn btn-primary bg-brand-primary border-0 w-100 text-xs fw-semibold py-2">
                                Update Assigned Department
                            </button>
                        </form>

                        @if ($complaintDetails->status !== 'Resolved')
                            <div class="mt-3 pt-3 border-top">
                                <form action="{{ route('complaints.triage', $complaintDetails->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="action_type" value="resolve">
                                    <button type="submit"
                                        class="btn btn-success w-100 text-xs py-2 fw-semibold border-0 shadow-sm"
                                        style="background-color: #16a34a;">
                                        Mark Grievance Resolved
                                    </button>
                                </form>
                            </div>
                        @endif
                        {{-- 
                        @if ($complaintDetails->status !== 'Rejected')
                            <div class="mt-2">
                                <form action="{{ route('complaints.triage', $complaintDetails->id) }}" method="POST"
                                    onsubmit="return confirm('Confirm complete invalidation/rejection of this profile archive case?');">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="action_type" value="reject">
                                    <button type="submit" class="btn btn-outline-danger w-100 text-xs py-2 fw-semibold">
                                        Reject & Discard Application
                                    </button>
                                </form>
                            </div>
                        @endif --}}
                        {{-- NAYA --}}
                        @if ($complaintDetails->status !== 'Rejected')
                            <div class="mt-2">

                                {{-- Hidden Form --}}
                                <form id="reject-form-{{ $complaintDetails->id }}"
                                    action="{{ route('complaints.triage', $complaintDetails->id) }}" method="POST"
                                    class="d-none">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action_type" value="reject">
                                </form>

                                {{-- Button --}}
                                <button type="button"
                                    class="btn btn-outline-danger w-100 text-xs py-2 fw-semibold btn-reject-action"
                                    data-form-id="reject-form-{{ $complaintDetails->id }}">
                                    Reject & Discard Application
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
