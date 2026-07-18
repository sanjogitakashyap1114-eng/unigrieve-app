@extends('layouts.dashboard')

@section('content')
    {{-- SYSTEM GREETING HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title text-brand-primary mb-1">Hello, {{ Auth::user()->name ?? 'Admin' }}</h4>
            <p class="text-brand-primary small mb-0">Here's a breakdown of the live system management metrics.</p>
        </div>
    </div>

    {{-- 1. TOP METRIC CARDS ROW --}}
    <div class="row g-4 mb-4">
        {{-- Total Complaints --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-white border-0 py-2">
                <div class="card-body d-flex align-items-center px-4">
                    <div class="stat-icon bg-soft-blue me-3">
                        <i class="fas fa-inbox text-brand-primary"></i>
                    </div>
                    <div>
                        <h3 class="stat-value text-dark mb-0">{{ $totalComplaints }}</h3>
                        <p class="stat-label text-uppercase tracking-wider mb-1">Total Complaints</p>
                        <a href="#" class="text-xs fw-semibold text-decoration-none text-brand-primary">View all &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-white border-0 py-2">
                <div class="card-body d-flex align-items-center px-4">
                    <div class="stat-icon bg-soft-amber me-3">
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                    <div>
                        <h3 class="stat-value text-dark mb-0">{{ $pendingComplaints }}</h3>
                        <p class="stat-label text-uppercase tracking-wider mb-1">Pending Cases</p>
                        <a href="#" class="text-xs fw-semibold text-decoration-none text-brand-primary">View details &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Solved / Resolved --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-white border-0 py-2">
                <div class="card-body d-flex align-items-center px-4">
                    <div class="stat-icon bg-soft-green me-3">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div>
                        <h3 class="stat-value text-dark mb-0">{{ $resolvedComplaints }}</h3>
                        <p class="stat-label text-uppercase tracking-wider mb-1">Resolved Cases</p>
                        <a href="#" class="text-xs fw-semibold text-decoration-none text-brand-primary">View reports &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Services --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-white border-0 py-2">
                <div class="card-body d-flex align-items-center px-4">
                    <div class="stat-icon bg-soft-cyan me-3">
                        <i class="fas fa-tasks text-info"></i>
                    </div>
                    <div>
                        <h3 class="stat-value text-dark mb-0">{{ $totalServices }}</h3>
                        <p class="stat-label text-uppercase tracking-wider mb-1">Total Services</p>
                        <a href="{{ route('services.index') }}" class="text-xs fw-semibold text-decoration-none text-brand-primary">View all &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- 2. MIDDLE GRID BLOCK: [ QUICK ACTIONS | RECENT COMPLAINTS ] --}}
    <div class="row g-4 mb-4 align-items-stretch">
        {{-- LEFT PANEL: QUICK ACTIONS --}}
        <div class="col-12 col-lg-6">
            <div class="card section-card bg-white p-4 h-100">
                <div class="section-header bg-white border-0 p-0 pb-3">
                    <h5 class="text-dark mb-0 text-uppercase tracking-wider text-sm">Quick System Actions</h5>
                </div>
                <div class="card-body p-0 d-flex flex-column gap-3 pt-3">
                    <a href="#" class="btn btn-action-primary text-white shadow-sm px-3 d-flex align-items-center justify-content-start py-2-5 fw-semibold" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                        <i class="fas fa-plus-circle me-2 icon-width-fixed"></i> Add Department
                    </a>
                    <a href="#" class="btn btn-action-primary text-white shadow-sm px-3 d-flex align-items-center justify-content-start py-2-5 fw-semibold" data-bs-toggle="modal" data-bs-target="#importStudentModal">
                        <i class="fas fa-file-import me-2 icon-width-fixed"></i> Import Students
                    </a>
                    <a href="{{ route('services.index') }}" class="btn btn-action-primary text-white shadow-sm px-3 d-flex align-items-center justify-content-start py-2-5 fw-semibold">
                        <i class="fas fa-tasks me-2 icon-width-fixed"></i> Manage Services
                    </a>
                    <a href="{{ route('departments.index') }}" class="btn btn-action-primary text-white shadow-sm px-3 d-flex align-items-center justify-content-start py-2-5 fw-semibold">
                        <i class="fas fa-building me-2 icon-width-fixed"></i> Manage Departments
                    </a>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL: RECENT COMPLAINTS --}}
        <div class="col-12 col-lg-6">
            <div class="card section-card bg-white p-4 h-100">
                <div class="section-header bg-white border-0 d-flex justify-content-between align-items-center p-0 pb-3">
                    <h5 class="text-dark mb-0 text-uppercase tracking-wider text-sm">Recent Complaints</h5>
                    <a href="{{ route('complaints.index') }}" class="text-brand-primary fw-semibold text-decoration-none text-xs">View all</a>
                </div>
                <div class="card-body p-0 pt-3">
                    <div class="d-flex flex-column gap-3">
                        @forelse($recentComplaints as $complaint)
                            <div class="d-flex align-items-center justify-content-between p-2 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon me-3 
                                        {{ $complaint->status == 'Pending' ? 'bg-soft-amber' : '' }}
                                        {{ $complaint->status == 'In Progress' ? 'bg-soft-cyan' : '' }}
                                        {{ $complaint->status == 'Resolved' ? 'bg-soft-green' : '' }}">
                                        
                                        @if($complaint->status == 'Pending')
                                            <i class="fas fa-exclamation-triangle text-warning text-xs"></i>
                                        @elseif($complaint->status == 'In Progress')
                                            <i class="fas fa-minus-square text-info text-xs"></i>
                                        @else
                                            <i class="fas fa-check text-success text-xs"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark text-sm mb-1">{{ $complaint->category }}</h6>
                                        <div class="text-muted text-xs">
                                            <span class="fw-medium text-secondary">{{ $complaint->complaint_id }}</span> &middot; 
                                            <span>{{ $complaint->created_at ? $complaint->created_at->diffForHumans() : 'Recently' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="status-badge 
                                        {{ $complaint->status == 'Pending' ? 'badge-pending' : '' }}
                                        {{ $complaint->status == 'In Progress' ? 'badge-in-progress' : '' }}
                                        {{ $complaint->status == 'Resolved' ? 'badge-resolved' : '' }}">
                                        {{ $complaint->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4 text-sm">No complaints recorded yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </
    {{-- NEW RIGHT PANEL: 3. ANALYTICS & STATISTICS REPORT BLOCK --}}
        {{-- <div class="col-12 col-lg-6">
            <div class="card section-card bg-white p-4 h-100 shadow-sm border-0">
                <div class="section-header bg-white border-0 d-flex justify-content-between align-items-center p-0 pb-3">
                    <div>
                        <h5 class="text-dark mb-0 text-uppercase tracking-wider text-sm">Complaints Breakdown</h5>
                        <p class="text-muted text-xs mb-0">Live distribution matrix across active departments</p>
                    </div>
                    <span class="badge bg-soft-blue text-brand-primary rounded px-2.5 py-1 text-xs fw-semibold">Live Data</span>
                </div>
                 --}}
                {{-- <div class="card-body p-0 pt-4 d-flex flex-column justify-content-between" style="min-height: 240px;"> --}}
                    {{-- Chart Visualization bars --}}
                    {{-- <div class="d-flex align-items-end justify-content-around border-bottom pb-2 pt-4" style="height: 180px;">
                        @forelse($analyticsCharts as $chart)
                            <div class="d-flex flex-column align-items-center w-100" title="{{ $chart['name'] }}: {{ $chart['count'] }} complaints">
                                <span class="text-xs fw-bold text-dark mb-1">{{ $chart['count'] }}</span>
                                <div class="bg-brand-primary rounded-top transition-all" 
                                     style="width: 32px; height: {{ $chart['height'] }}px; background-color: #0d6efd; min-height: 6px;">
                                </div>
                            </div>
                        @empty
                            <div class="w-100 text-center text-muted text-sm pb-5">No historical data available to compile a statistics report.</div>
                        @endforelse
                    </div> --}}
                    
                    {{-- X-Axis Labels --}}
                    {{-- <div class="d-flex justify-content-around text-center pt-2">
                        @foreach($analyticsCharts as $chart)
                            <div class="w-100">
                                <p class="text-muted fw-medium text-truncate text-xs px-1 mb-0" style="max-width: 85px;">
                                    {{ $chart['name'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
        {{-- RIGHT PANEL: RECENT SERVICES --}}
        <div class="col-12 col-lg-6">
            <div class="card section-card bg-white p-4 h-100">
                <div class="section-header bg-white border-0 d-flex justify-content-between align-items-center p-0 pb-3">
                    <h5 class="text-dark mb-0 text-uppercase tracking-wider text-sm">Recent Services</h5>
                    <a href="{{ route('services.index') }}" class="text-brand-primary fw-semibold text-decoration-none text-xs">View all</a>
                </div>
                <div class="card-body p-0 pt-3">
                    <div class="d-flex flex-column gap-3">
                        @forelse($recentServices as $service)
                            <div class="d-flex align-items-center justify-content-between p-2 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-light me-3">
                                        <i class="fas fa-id-card text-secondary text-xs"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark text-sm mb-1">{{ $service->service_type }}</h6>
                                        <div class="text-muted text-xs">
                                            <span class="fw-medium text-secondary">{{ $service->service_id }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="status-badge {{ $service->status == 'Completed' ? 'badge-resolved' : 'badge-in-progress' }}">
                                        {{ $service->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4 text-sm">No active service requests.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- PREMIUM IMPORT STUDENT MODAL --}}
    <div class="modal fade" id="importStudentModal" tabindex="-1" aria-labelledby="importStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0 overflow-hidden">
                <div class="modal-top-accent-line"></div>
                
                <div class="modal-header border-bottom-0 pt-4 px-4 align-items-start">
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-1" id="importStudentModalLabel">Import Student Records</h5>
                        <p class="text-muted small mb-0">Populate system directory using bulk file records</p>
                    </div>
                    <button type="button" class="btn-close shadow-none mt-1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" class="validate-form">
                    @csrf
                    <div class="modal-body px-4 pt-2">
                        <div class="mb-4 text-center p-4 border border-2 border-dashed rounded bg-light position-relative">
                            <div class="py-2">
                                <i class="fas fa-cloud-upload-alt text-brand-primary fs-1 mb-3"></i>
                                <h6 class="fw-bold text-dark mb-1">Choose template file to upload</h6>
                                <p class="text-muted small mb-3">Drag and drop your spreadsheet file here or select file manually</p>
                                <input type="file" class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0 custom-cursor-pointer modal-file-input" id="studentFile" name="file" accept=".csv,.xlsx,.xls" required>
                                <span class="btn btn-sm btn-white border px-3 fw-medium text-dark shadow-sm bg-white">Select File</span>
                            </div>
                        </div>

                        <div class="p-3 bg-light border-0 rounded mb-2 d-flex align-items-start">
                            <i class="fas fa-info-circle text-brand-primary mt-1 me-2 fs-5"></i>
                            <div>
                                <span class="fw-bold text-brand-primary d-block text-xs mb-1">Formatting Specifications</span>
                                <p class="mb-0 text-secondary text-xs">
                                    Verify standard headings match configuration matrices perfectly. Supported formats: <strong>.csv, .xlsx, .xls</strong>.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-top-0 pt-2 pb-4 px-4">
                        <button type="button" class="btn btn-light border fw-medium px-4 me-auto text-dark" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-action-primary text-white fw-semibold px-4">
                            <i class="fas fa-file-import me-1"></i> Start Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ADD DEPARTMENT MODAL --}}
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow border-0">
                <div class="modal-header modal-header-custom pt-4 px-4">
                    <h5 class="modal-title fw-bold" id="addDepartmentModalLabel">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.departments.store') }}" method="POST">
                    @csrf
                    <div class="modal-body px-4 pt-4">
                        <h6 class="text-brand-primary fw-bold text-uppercase text-xs mb-3 tracking-wider">Department Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Department Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. IT Department" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Head Name</label>
                                <input type="text" name="head_name" class="form-control" placeholder="e.g. Mr. Sharma">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department Email</label>
                                <input type="email" name="dept_email" class="form-control" placeholder="e.g. it@university.edu">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="e.g. 9876543210">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Brief description of this department"></textarea>
                            </div>
                        </div>
                        <hr class="my-4 text-muted opacity-25">
                        <h6 class="text-brand-primary fw-bold text-uppercase text-xs mb-3 tracking-wider">Staff Login Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Staff Name <span class="text-danger">*</span></label>
                                <input type="text" name="staff_name" class="form-control" placeholder="e.g. Ravi Kumar" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Staff Email <span class="text-danger">*</span></label>
                                <input type="email" name="staff_email" class="form-control" placeholder="e.g. ravi@university.edu" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Staff Phone <span class="text-danger">*</span></label>
                                <input type="text" name="staff_phone" class="form-control" placeholder="e.g. 9876543210" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Min 8 characters" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pb-4 px-4">
                        <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-action-primary text-white px-4">Add Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/admin.js','resources/js/global.js'])
    @endpush
@endsection