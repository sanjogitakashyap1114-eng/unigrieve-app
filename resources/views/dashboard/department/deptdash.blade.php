@extends('layouts.dashboard')

@section('content')
<div class="dept-dashboard container-fluid px-4 py-3">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- STAT CARDS (CLEAN SOFT PANELS EXACTLY MATCHING image_cfd0de.png) --}}
    <div class="row g-4 mb-4">
        {{-- Total Assigned --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-white border-0 py-2">
                <div class="card-body d-flex align-items-center px-4">
                    <div class="stat-icon bg-soft-blue me-3">
                         <i class="fas fa-inbox text-brand-primary"></i>
                    </div>
                    <div>
                        <h3 class="stat-value text-dark mb-0">{{ $stats['total_complaints'] }}</h3>
                        <p class="stat-label text-uppercase tracking-wider mb-1">Total Assigned</p>
                        <a href="{{ route('department.complaints') }}" class="text-xs fw-semibold text-decoration-none text-brand-primary">View details &rarr;</a>
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
                        <h3 class="stat-value text-dark mb-0">{{ $stats['pending_complaints'] }}</h3>
                        <p class="stat-label text-uppercase tracking-wider mb-1">Pending Complaints</p>
                        <a href="{{ route('department.complaints') }}" class="text-xs fw-semibold text-decoration-none text-brand-primary">View details &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- In Progress --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-white border-0 py-2">
                <div class="card-body d-flex align-items-center px-4">
                    <div class="stat-icon bg-soft-cyan me-3"><i class="fas fa-clock text-warning"></i> </div>
                    <div>
                        <h3 class="stat-value text-dark mb-0">{{ $stats['pending_services'] }}</h3>
                        <p class="stat-label text-uppercase tracking-wider mb-1">Pending Services</p>
                        <a href="{{ route('department.services') }}" class="text-xs fw-semibold text-decoration-none text-brand-primary">View details &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resolved --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-white border-0 py-2">
                <div class="card-body d-flex align-items-center px-4">
                    <div class="stat-icon bg-soft-green me-3">
                               <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div>
                        <h3 class="stat-value text-dark mb-0">{{ $stats['resolved_complaints'] }}</h3>
                        <p class="stat-label text-uppercase tracking-wider mb-1">Resolved</p>
                        <a href="{{ route('department.complaints') }}" class="text-xs fw-semibold text-decoration-none text-brand-primary">View details &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS SECTION PANEL --}}
    <div class="card section-card bg-white p-4 mb-4">
        <div class="section-header bg-white border-0 p-0 pb-2">
            <h5 class="text-dark mb-0 text-uppercase tracking-wider text-sm">Quick Actions</h5>
        </div>
        <div class="row g-3 pt-2">
            <div class="col-12 col-sm-6 col-md-3">
                <a href="{{ route('department.complaints') }}" class="text-decoration-none">
                    <div class="action-item-panel p-3 bg-light rounded h-100">
                        <h6 class="mb-1 text-dark fw-bold text-sm">View Assigned Complaints</h6>
                        <p class="text-muted text-xs mb-0">Track student grievances</p>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <a href="{{ route('department.services') }}" class="text-decoration-none">
                    <div class="action-item-panel p-3 bg-light rounded h-100">
                        <h6 class="mb-1 text-dark fw-bold text-sm">View Assigned Services</h6>
                        <p class="text-muted text-xs mb-0">Manage service operations</p>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <a href="{{ route('department.notices') }}" class="text-decoration-none">
                    <div class="action-item-panel p-3 bg-light rounded h-100">
                        <h6 class="mb-1 text-dark fw-bold text-sm">Create Notice</h6>
                        <p class="text-muted text-xs mb-0">Broadcast public board updates</p>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <a href="{{ route('department.profile') }}" class="text-decoration-none">
                    <div class="action-item-panel p-3 bg-light rounded h-100">
                        <h6 class="mb-1 text-dark fw-bold text-sm">Add Staff</h6>
                        <p class="text-muted text-xs mb-0">Configure workspace access</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- SPLIT DATA PANELS ROW --}}
    <div class="row g-4">
        {{-- RECENT COMPLAINTS PANEL --}}
        <div class="col-12 col-xl-6">
            <div class="card section-card bg-white h-100">
                <div class="card-header section-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark fw-semibold text-sm text-uppercase tracking-wider">Recently Assigned Complaints</h5>
                    <a href="{{ route('department.complaints') }}" class="btn btn-sm btn-manage-action px-3 fw-semibold">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="custom-thead bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Student & Reg No</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentComplaints as $c)
                                <tr class="table-row-border">
                                    <td class="fw-semibold text-secondary text-xs">{{ $c->complaint_id }}</td>
                                    <td>
                                        <div class="fw-bold text-dark text-sm mb-0">{{ $c->user->studentMaster->name ?? '—' }}</div>
                                        <span class="text-muted text-xs">{{ $c->user->studentMaster->registration_no ?? '—' }}</span>
                                    </td>
                                    <td class="text-sm text-secondary">{{ $c->category }}</td>
                                    <td>
                                        <span class="status-badge badge-{{ strtolower(str_replace(' ', '-', $c->status)) }}">{{ $c->status }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('department.complaints.show', $c->id) }}" class="btn btn-sm btn-action-primary text-white text-xs px-2.5 py-1">View</a>
                                            @if($c->status === 'Pending')
                                                <form action="{{ route('department.complaints.quick-reject', $c->id) }}" method="POST" onsubmit="return confirm('Quick Reject this complaint?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger text-xs px-2.5 py-1">Reject</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4 text-sm">No complaints assigned yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RECENT SERVICES PANEL --}}
        <div class="col-12 col-xl-6">
            <div class="card section-card bg-white h-100">
                <div class="card-header section-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark fw-semibold text-sm text-uppercase tracking-wider">Recently Assigned Services</h5>
                    <a href="{{ route('department.services') }}" class="btn btn-sm btn-manage-action px-3 fw-semibold">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="custom-thead bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Student & Reg No</th>
                                <th>Service Type</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentServices as $s)
                                <tr class="table-row-border">
                                    <td class="fw-semibold text-secondary text-xs">{{ $s->service_id }}</td>
                                    <td>
                                        <div class="fw-bold text-dark text-sm mb-0">{{ $s->user->studentMaster->name ?? '—' }}</div>
                                        <span class="text-muted text-xs">{{ $s->user->studentMaster->registration_no ?? '—' }}</span>
                                    </td>
                                    <td class="text-sm text-secondary">{{ $s->service_type }}</td>
                                    <td>
                                        <span class="status-badge badge-{{ strtolower(str_replace(' ', '-', $s->status)) }}">{{ $s->status }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('department.services.show', $s->id) }}" class="btn btn-sm btn-info text-white text-xs px-2.5 py-1">View</a>
                                            @if($s->status === 'Pending')
                                                <form action="{{ route('department.services.quick-reject', $s->id) }}" method="POST" onsubmit="return confirm('Quick Reject this service request?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger text-xs px-2.5 py-1">Reject</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4 text-sm">No service requests assigned yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* Soft base design system matching image blocks exactly */
        .action-item-panel {
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0;
            transition: background-color 0.15s ease, transform 0.15s ease;
        }
        .action-item-panel:hover {
            background-color: #f1f5f9 !important;
            transform: translateY(-1px);
        }
    </style>
@endpush
@endsection