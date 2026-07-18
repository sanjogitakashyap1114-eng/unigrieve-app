@extends('layouts.dashboard')

@section('content')

<div class="container-fluid p-3 p-md-4">

    <!-- Header Action Panel -->
    <div class="row align-items-center mb-4 g-3 border-bottom pb-3">
        <div class="col-sm">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <h1 class="h4 page-title mb-0 text-brand-primary font-weight-bold letter-spacing-tight">
                    {{ $department->name }} Control Panel
                </h1>
                <span class="badge rounded-pill px-2 py-1 text-xs fw-bold badge-active-status">
                    Status: {{ $department->status ?? 'Active' }}
                </span>
            </div>
            <p class="text-muted small mb-0 fw-medium mt-1">Full operational oversight, administrative updates, and active personnel enrollment maps.</p>
        </div>
        
        <div class="col-sm-auto d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm px-3 input-field-height border-brand-primary text-brand-primary fw-semibold d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editDepartmentModal">
                <i class="bi bi-pencil-square"></i> Edit Department
            </button>
            <form action="#" method="POST" onsubmit="return confirm('Are you sure you want to delete this entire department structure?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm px-3 input-field-height fw-semibold d-flex align-items-center gap-1">
                    <i class="bi bi-trash3"></i> Delete Department
                </button>
            </form>
        </div>
    </div>

    <!-- Core Twin Card Dashboard Interface -->
    <div class="row g-4">
        
        <!-- Left Column: Department Profile Data Card (ENLARGED TO col-xl-7) -->
        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-sm height-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-brand-primary mb-4 text-uppercase tracking-wider border-bottom pb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-building"></i> Department Profile Overview
                    </h5>
                    
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label class="text-xs text-uppercase text-secondary fw-bold mb-1 d-block">Department Head Name</label>
                            <p class="text-base text-dark fw-semibold mb-0 p-2 bg-light rounded border-start border-4 border-brand-primary">
                                {{ $department->head_name ?? 'Not Assigned' }}
                            </p>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="text-xs text-uppercase text-secondary fw-bold mb-1 d-block">Department Official Email</label>
                            <p class="text-base text-dark fw-semibold mb-0 p-2 bg-light rounded border-start border-4 border-brand-primary">
                                {{ $department->email ?? 'no-email@domain.com' }}
                            </p>
                        </div>
                        
                        <div class="col-12">
                            <label class="text-xs text-uppercase text-secondary fw-bold mb-1 d-block">Contact Phone Extension</label>
                            <p class="text-base text-dark fw-semibold mb-0 p-2 bg-light rounded border-start border-4 border-brand-primary">
                                {{ $department->phone ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div class="col-12">
                            <label class="text-xs text-uppercase text-secondary fw-bold mb-1 d-block">Operational Jurisdiction & Directives</label>
                            <div class="p-3 bg-light rounded border text-sm text-muted leading-relaxed">
                                {{ $department->description ?? 'No written operational directives logged into system memory architecture profiles.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Staff Enrollment Interactive Card (RESIZED TO col-xl-5) -->
        <div class="col-12 col-xl-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-brand-primary mb-3 text-sm text-uppercase tracking-wider border-bottom pb-2">
                        <i class="bi bi-person-plus me-1"></i> Enroll New Staff Member
                    </h6>
                    
                    <form action="" method="POST" class="row g-3    global-validate-form">
                        @csrf
                        <div class="col-12">
                            <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-1">Full Employee Name *</label>
                            <input type="text" name="staff_name" class="form-control text-sm border input-field-height" placeholder="John Doe" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-1">Official Email Address *</label>
                            <input type="email" name="staff_email" class="form-control text-sm border input-field-height" placeholder="employee@domain.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-1">Contact Mobile / Ext.</label>
                            <input type="text" name="staff_phone" class="form-control text-sm border input-field-height" placeholder="">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-1">System Password *</label>
                            <input type="password" name="password" class="form-control text-sm border input-field-height" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-1">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control text-sm border input-field-height"  data-match="password" required>
                        </div>
                        <div class="col-12 d-grid mt-4">
                            <button type="submit" class="btn btn-primary text-white text-sm fw-semibold btn-action-primary input-field-height border-0">
                                Enroll New  Staff
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Edit Department Modal Architecture -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg overflow-hidden">
            <div class="bg-brand-primary text-white modal-header border-0 rounded-0 p-3">
                <h5 class="modal-title fw-bold fs-6">Modify Department Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) brightness(2);"></button>
            </div>
            <form action="" method="POST">
                @csrf @method('PATCH')
                <div class="modal-body p-3 bg-light">
                    <div class="mb-2">
                        <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-1">Department Name *</label>
                        <input type="text" name="name" class="form-control text-sm border input-field-height" value="{{ $department->name }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-1">Head Identity Name *</label>
                        <input type="text" name="head_name" class="form-control text-sm border input-field-height" value="{{ $department->head_name }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-1">Official Desk Email *</label>
                        <input type="email" name="dept_email" class="form-control text-sm border input-field-height" value="{{ $department->email }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-1">Contact Phone</label>
                        <input type="text" name="phone" class="form-control text-sm border input-field-height" value="{{ $department->phone }}">
                    </div>
                    <div class="mb-0">
                        <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-1">Directives Description</label>
                        <textarea name="description" class="form-control text-sm border" rows="3">{{ $department->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top p-2">
                    <button type="button" class="btn btn-light text-sm input-field-height px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary text-sm btn-action-primary input-field-height px-3 border-0 text-white">Save  Updates</button>
                </div>
            </form>
        </div>
    </div>
</div>
 @push('scripts')
        @vite(['resources/js/admin.js','resources/js/global.js'])
    @endpush
@endsection