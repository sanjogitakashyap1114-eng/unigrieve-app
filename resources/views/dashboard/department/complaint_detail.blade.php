@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="mb-3">
        <a href="{{ route('department.dashboard') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 text-dark fw-bold">Student Profile Information</h5>
                </div>
                <div class="card-body bg-light">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Full Name</label>
                            <span class="fw-bold text-dark fs-6">{{ $complaint->user->studentMaster->name ?? '—' }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Registration / Roll Number</label>
                            <span class="fw-bold text-dark fs-6">{{ $complaint->user->studentMaster->registration_no ?? '—' }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Current Semester / Program</label>
                            <span class="text-dark font-monospace">{{ $complaint->user->studentMaster->semester ?? 'N/A' }} Semester</span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Official Student Email Address</label>
                            <span class="text-dark">{{ $complaint->user->email ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <span class="badge bg-purple-soft float-end px-3 py-2 text-primary fw-bold">{{ $complaint->category }}</span>
                    <h5 class="mb-0 text-dark fw-bold">Complaint Arguments Info & Support Document</h5>
                </div>
                <div class="card-body">
                    <h6 class="text-secondary small fw-bold uppercase tracking-wider mb-2">Additional Detailed Message Log</h6>
                    <p class="text-dark p-3 border rounded bg-light" style="white-space: pre-line;">{{ $complaint->description ?? 'No explicit description logs provided.' }}</p>

                    <h6 class="text-secondary small fw-bold uppercase tracking-wider mt-4 mb-2">Uploaded Evidence / Files Supporting Attachments</h6>
                    @if(!empty($complaint->document_path) || !empty($complaint->attachments))
                        <div class="p-3 border rounded border-dashed d-flex align-items-center bg-light">
                            <i class="bi bi-file-earmark-pdf text-danger fs-2 me-3"></i>
                            <div>
                                <div class="fw-bold text-dark">Submission Attachment Document</div>
                                <span class="text-muted small">File format verified securely</span>
                            </div>
                            <a href="{{ asset('storage/' . ($complaint->document_path ?? $complaint->attachments)) }}" target="_blank" class="btn btn-sm btn-primary ms-auto px-4">
                                <i class="bi bi-download me-1"></i> View / Download Document
                            </a>
                        </div>
                    @else
                        <div class="p-3 border rounded border-dashed text-center text-muted bg-light small">
                            No documentary file attachment uploads verified on this application asset record.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm position-sticky rounded-3" style="top: 20px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 text-dark fw-bold">Resolution Panel Actions</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="text-muted small d-block mb-1">Current File Status</label>
                        <span class="status-badge badge-{{ strtolower(str_replace(' ', '-', $complaint->status)) }} fs-6 px-3 py-1">{{ $complaint->status }}</span>
                    </div>

                    <form action="{{ route('department.complaints.status', $complaint->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="statusSelect" class="form-label small fw-bold text-dark">Modify Workflow State</label>
                            <select id="statusSelect" name="status" class="form-select form-select-sm fw-semibold text-dark">
                                <option value="Pending" {{ $complaint->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $complaint->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Resolved" {{ $complaint->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="Rejected" {{ $complaint->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="remarksTextarea" class="form-label small fw-bold text-dark">Processing Remarks Note (Stored to History Log)</label>
                            <textarea id="remarksTextarea" name="remarks" rows="4" class="form-control small" placeholder="Provide status changes feedback text logs or reason for rejection processing here...">{{ old('remarks', $complaint->remarks) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-save me-1"></i> Cphpommit Status & Remark Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection