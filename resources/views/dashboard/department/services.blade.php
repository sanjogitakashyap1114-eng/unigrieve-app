@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid px-4 py-3">
        <div class="card section-card">
            <div class="card-header section-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-dark fw-semibold">All Assigned Service Requests</h5>
            </div>

            <!-- Search Filtering Tools UI Header -->
            <div class="p-3 bg-light border-bottom">
                <form action="{{ route('department.services') }}" method="GET" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control form-control-sm" placeholder="Search ID, Service Type, Name, Reg No...">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ request('status') === 'In Progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="Resolved" {{ request('status') === 'Resolved' ? 'selected' : '' }}>Resolved
                            </option>
                            <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1 justify-content-end">
                        <button type="submit" class="btn btn-sm bg-brand-primary    text-white w-100">Filter</button>
                                  <a href="{{ route('department.complaints') }}" class="btn btn-light border text-sm"><i
                                class="bi bi-arrow-counterclockwise"></i>Reset</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Service ID</th>
                            <th>Student Name</th>
                            <th>Registration No</th>
                            <th>Service Type</th>
                            <th>Status</th>
                            <th>Date Assigned</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $s)
                            <tr>
                                <td class="fw-semibold">{{ $s->service_id }}</td>
                                <td class="fw-bold">{{ $s->user->studentMaster->name ?? '—' }}</td>
                                <td><span
                                        class="badge bg-secondary opacity-75">{{ $s->user->studentMaster->registration_no ?? '—' }}</span>
                                </td>
                                <td>{{ $s->service_type }}</td>
                                <td><span
                                        class="status-badge badge-{{ strtolower(str_replace(' ', '-', $s->status)) }}">{{ $s->status }}</span>
                                </td>
                                <td class="text-muted small">{{ $s->created_at->format('d M Y') }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('department.services.show', $s->id) }}"
                                            class="btn btn-sm btn-info text-white">View</a>
                                        @if ($s->status === 'Pending')
                                            {{-- <form action="{{ route('department.services.quick-reject', $s->id) }}" method="POST" onsubmit="return confirm('Quick Reject this service request?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Reject</button>
                                        </form> --}}
                                            <form id="reject-form-{{ $s->id }}"
                                                action="{{ route('department.services.quick-reject', $s->id) }}"
                                                method="POST" class="d-none">
                                                @csrf
                                            </form>

                                            <button type="button" class="btn btn-sm btn-outline-danger btn-reject-action"
                                                data-form-id="reject-form-{{ $s->id }}">
                                                Reject
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No service requests found matching
                                    your conditions.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">
                {{ $services->links() }}
            </div>
        </div>
    </div>

    <style>
    </style>
      @push('scripts')
        @vite(['resources/js/global.js'])
    @endpush
@endsection
