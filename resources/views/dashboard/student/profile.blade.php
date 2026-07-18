@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">

    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- TOTAL PROFILE WRAPPED IN ONE SINGLE CARD --}}
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        
        {{-- INTEGRATED HEADER SECTION INSIDE THE MAIN CARD --}}
        <div class="card-header bg-white py-4 px-4 border-bottom d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
            <div>
                <span class="badge bg-primary text-white px-3 py-1.5 fw-semibold mb-2 text-uppercase" style="font-size: 0.75rem;">Student Dashboard</span>
                <h3 class="fw-bold mb-1 text-dark">{{ auth()->user()->studentMaster->name ?? 'Student Name' }}</h3>
                <p class="text-muted mb-0"><i class="bi bi-mortarboard me-1"></i> {{ auth()->user()->studentMaster->course ?? 'N/A' }} | Registration No: {{ auth()->user()->studentMaster->registration_no ?? 'N/A' }}</p>
            </div>
            {{-- DATA TARGET AND TOGGLE ARE 100% CORRECT NOW --}}
            <button type="button" class="btn btn-primary fw-semibold px-4 py-2 mt-3 mt-sm-0 shadow-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                ✏️ Edit Profile
            </button>
        </div>

        <div class="card-body p-4">
            
            {{-- SUB-SECTION 1: PERSONAL DETAILS (CLEAN ROWS LIKE BEFORE) --}}
            <div class="mb-5">
                <h5 class="text-primary fw-bold text-uppercase mb-3" style="font-size: 0.9rem; letter-spacing: 0.5px;"><i class="bi bi-person me-1"></i> Personal Details</h5>
                
                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Full Name</div>
                    <div class="col-md-8 fw-bold text-dark fs-6">{{ auth()->user()->studentMaster->name ?? 'N/A' }}</div>
                </div>

                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Father's Name</div>
                    <div class="col-md-8 fw-semibold text-secondary fs-6">{{ auth()->user()->studentMaster->father_name ?? 'N/A' }}</div>
                </div>

                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Gender</div>
                    <div class="col-md-8 fw-semibold text-capitalize text-secondary fs-6">{{ auth()->user()->studentMaster->gender ?? 'N/A' }}</div>
                </div>

                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Date of Birth</div>
                    <div class="col-md-8 fw-semibold text-secondary fs-6">
                        {{ auth()->user()->studentMaster->date_of_birth ? date('d M Y', strtotime(auth()->user()->studentMaster->date_of_birth)) : 'N/A' }}
                    </div>
                </div>
            </div>

            {{-- SUB-SECTION 2: EDUCATIONAL DETAILS --}}
            <div class="mb-5">
                <h5 class="text-success fw-bold text-uppercase mb-3" style="font-size: 0.9rem; letter-spacing: 0.5px;"><i class="bi bi-book me-1"></i> Educational Information</h5>
                
                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Registration Number</div>
                    <div class="col-md-8 fw-bold text-dark fs-6">{{ auth()->user()->studentMaster->registration_no ?? 'N/A' }}</div>
                </div>

                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Course / Degree</div>
                    <div class="col-md-8 fw-semibold text-secondary fs-6">{{ auth()->user()->studentMaster->course ?? 'N/A' }}</div>
                </div>

                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Department</div>
                    <div class="col-md-8 fw-semibold text-secondary fs-6">{{ auth()->user()->studentMaster->department ?? 'N/A' }}</div>
                </div>

                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Batch Session</div>
                    <div class="col-md-8 fw-semibold text-secondary fs-6">{{ auth()->user()->studentMaster->batch ?? 'N/A' }}</div>
                </div>
            </div>

            {{-- SUB-SECTION 3: CONTACT & LOCATION --}}
            <div class="mb-2">
                <h5 class="text-warning fw-bold text-uppercase mb-3" style="font-size: 0.9rem; letter-spacing: 0.5px;"><i class="bi bi-geo-alt me-1"></i> Contact & Location</h5>
                
                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Current Semester</div>
                    <div class="col-md-8"><span class="badge bg-dark px-3 py-2">Semester {{ auth()->user()->studentMaster->semester ?? '1' }}</span></div>
                </div>

                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Email Address</div>
                    <div class="col-md-8 fw-semibold text-dark text-break fs-6">{{ auth()->user()->studentMaster->email ?? 'N/A' }}</div>
                </div>

                <div class="row profile-row py-2.5 border-bottom align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Phone Number</div>
                    <div class="col-md-8 fw-semibold text-dark fs-6">{{ auth()->user()->studentMaster->phone ?? 'Not Updated' }}</div>
                </div>

                <div class="row profile-row py-2.5 align-items-center mx-0">
                    <div class="col-md-4 text-muted fw-semibold uppercase-label">Permanent Address</div>
                    <div class="col-md-8 fw-semibold text-secondary fs-6 lh-base">{{ auth()->user()->studentMaster->address ?? 'N/A' }}</div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- EDIT PROFILE MODAL (FIXED STRIP & BOOTSTRAP CLASSES) --}}
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3">
                <h5 class="modal-title fw-bold text-dark" id="editProfileModalLabel">⚙️ Update Profile Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('student.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body p-4">
                    <div class="alert alert-warning border-0 small mb-4 py-2" role="alert">
                        <i class="bi bi-info-circle-fill me-1"></i> Locked fields are non-editable and synced with corporate registers.
                    </div>
                    
                    <div class="row g-3">
                        {{-- --- LOCKED/DISABLED FIELDS --- --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">Full Name</label>
                            <input type="text" class="form-control bg-light text-muted" value="{{ auth()->user()->studentMaster->name ?? '' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">Father's Name</label>
                            <input type="text" class="form-control bg-light text-muted" value="{{ auth()->user()->studentMaster->father_name ?? '' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">Gender</label>
                            <input type="text" class="form-control bg-light text-muted text-capitalize" value="{{ auth()->user()->studentMaster->gender ?? '' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">Date of Birth</label>
                            <input type="text" class="form-control bg-light text-muted" value="{{ auth()->user()->studentMaster->date_of_birth ?? '' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">Registration / Roll No</label>
                            <input type="text" class="form-control bg-light text-muted" value="{{ auth()->user()->studentMaster->registration_no ?? '' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">Course</label>
                            <input type="text" class="form-control bg-light text-muted" value="{{ auth()->user()->studentMaster->course ?? '' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">Department</label>
                            <input type="text" class="form-control bg-light text-muted" value="{{ auth()->user()->studentMaster->department ?? '' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">Batch</label>
                            <input type="text" class="form-control bg-light text-muted" value="{{ auth()->user()->studentMaster->batch ?? '' }}" disabled>
                        </div>

                        <div class="col-12"><hr class="my-2 text-muted opacity-25"></div>

                        {{-- --- EDITABLE FIELDS --- --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', auth()->user()->studentMaster->email ?? '') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', auth()->user()->studentMaster->phone ?? '') }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Current Semester <span class="text-danger">*</span></label>
                            <select name="semester" class="form-select" required>
                                @for ($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ (optional(auth()->user()->studentMaster)->semester == $i) ? 'selected' : '' }}>
                                        Semester {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark small mb-1">Permanent Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', auth()->user()->studentMaster->address ?? '') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .uppercase-label { 
        font-size: 0.78rem; 
        letter-spacing: 0.4px; 
        text-transform: uppercase; 
    }
    .profile-row:last-child { 
        border-bottom: 0 !important; 
    }
</style>
@endsection