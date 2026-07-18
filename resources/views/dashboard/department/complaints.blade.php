@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid px-4 py-3">
        <div class="card section-card">
            <div class="card-header section-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-brand-primary  fw-semibold">All Assigned Complaints</h5>
            </div>

            <div class="p-3 bg-light border-bottom">
                <form action="{{ route('department.complaints') }}" method="GET" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control form-control-sm" placeholder="Search ID, Category, Name, Reg No...">
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
                    {{-- <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
                </div> --}}
                    <div class="col-12 col-md-2 d-flex gap-1 justify-content-end">
                        <button type="submit"
                            class="btn btn-primary bg-brand-primary border-0 w-100 text-sm fw-semibold">Filter</button>
                        <a href="{{ route('department.complaints') }}" class="btn btn-light border text-sm"><i
                                class="bi bi-arrow-counterclockwise"></i>Reset</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead  class="bg-brand-primary text-white">
                        <tr>
                            <th>Complaint ID</th>
                            <th>Student Name</th>
                            <th>Registration No</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Date Assigned</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $c)
                            <tr>
                                <td class="fw-semibold">{{ $c->complaint_id }}</td>
                                <td class="fw-bold">{{ $c->user->studentMaster->name ?? '—' }}</td>
                                <td><span
                                        class="badge bg-secondary opacity-75">{{ $c->user->studentMaster->registration_no ?? '—' }}</span>
                                </td>
                                <td>{{ $c->category }}</td>
                                <td><span
                                        class="status-badge badge-{{ strtolower(str_replace(' ', '-', $c->status)) }}">{{ $c->status }}</span>
                                </td>
                                <td class="text-muted small">{{ $c->created_at->format('d M Y') }}</td>
                                <td class="">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('department.complaints.show', $c->id) }}"
                                            class="btn btn-sm btn-primary">View</a>
                                        @if ($c->status !== 'rejected')
                                            {{-- <form action="{{ route('department.complaints.quick-reject', $c->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Reject</button>
                                        </form> --}}
                                            <form id="reject-form-{{ $c->id }}"
                                                action="{{ route('department.complaints.quick-reject', $c->id) }}"
                                                method="POST" class="d-none">
                                                @csrf
                                            </form>

                                            <button type="button" class="btn btn-sm btn-outline-danger btn-reject-action"
                                                data-form-id="reject-form-{{ $c->id }}">
                                                Reject
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No records found matching your
                                    conditions.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">
                {{ $complaints->links() }}
            </div>
        </div>
    </div>
      @push('scripts')
        @vite(['resources/js/global.js'])
    @endpush
@endsection
