@extends('layouts.dashboard')
@section('content')
<div class="container-fluid py-4">

    {{-- PAGE HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-brand-primary">My Service Requests</h3>
            <p class="text-muted mb-0">Track all your dynamic service applications online.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('student.services.create') }}" class="btn btn-primary">+ Request  Services</a>
        </div>
    </div>

    {{-- FILTERS --}}
    <form action="{{ route('student.myservices') }}" method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-6">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search by Request ID or Service Type">
                </div>
                <div class="col-lg-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="All Status" {{ request('status') == 'All Status' ? 'selected' : '' }}>All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-lg-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </div>
    </form>

    {{-- RECORDS TABLE --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">Service Records</h5>
            <span class="badge bg-primary">Total: {{ $services->count() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Request ID</th>
                            <th>Service Type</th>
                            <th>Status</th>
                            <th>Submission Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td class="fw-bold text-primary">{{ $service->service_id }}</td>
                                <td>{{ $service->service_type }}</td>
                                <td>
                                    @if(strtolower($service->status) == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif(strtolower($service->status) == 'approved' || strtolower($service->status) == 'resolved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $service->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('student.services.show', $service->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No service requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection