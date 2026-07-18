@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

            <div>
                <h3 class="fw-bold mb-1 text-brand-primary">My Complaints</h3>
                <p class="text-muted mb-0">
                    View and track all your submitted complaints.
                </p>
            </div>

            <div class="mt-3 mt-md-0">
                <a href="{{ route('complaints.create') }}" class="btn btn-primary">
                    + Create Complaint
                </a>
            </div>

        </div>

        {{-- FILTERS --}}
        {{-- FILTERS --}}
        <form action="{{ route('student.mycomplaint') }}" method="GET" class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-lg-5">
                        <label class="form-label fw-semibold">Search</label>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                            placeholder="Search by Complaint ID or Title">
                    </div>

                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="All Status" {{ request('status') == 'All Status' ? 'selected' : '' }}>All Status
                            </option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved
                            </option>
                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="category" class="form-select">
                            <option value="All Categories" {{ request('category') == 'All Categories' ? 'selected' : '' }}>
                                All Categories</option>
                            <option value="Academic" {{ request('category') == 'Academic' ? 'selected' : '' }}>Academic
                            </option>
                            <option value="Hostel" {{ request('category') == 'Hostel' ? 'selected' : '' }}>Hostel</option>
                            <option value="Fees" {{ request('category') == 'Fees' ? 'selected' : '' }}>Fees</option>
                            <option value="Administration" {{ request('category') == 'Administration' ? 'selected' : '' }}>
                                Administration</option>
                            <option value="IT Support" {{ request('category') == 'IT Support' ? 'selected' : '' }}>IT
                                Support</option>
                        </select>
                    </div>

                    <div class="col-lg-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Go</button>
                    </div>

                </div>
            </div>
        </form>
        {{-- COMPLAINT TABLE --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-semibold">
                        Complaint Records
                    </h5>

                    <span class="badge bg-primary">
                        Total: {{ $complaints->count() }}
                    </span>

                </div>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Complaint ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Submission Date</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>
                            @forelse($complaints as $complaint)
                                <tr>
                                    <td>{{$complaint->complaint_id}}</td>

                                    <td>{{ $complaint->title }}</td>

                                    <td>{{ $complaint->category }}</td>

                                    <td>
                                        @if (strtolower($complaint->status) == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif(strtolower($complaint->status) == 'in progress' || strtolower($complaint->status) == 'in_progress')
                                            <span class="badge bg-primary">In Progress</span>
                                        @elseif(strtolower($complaint->status) == 'resolved')
                                            <span class="badge bg-success">Resolved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>

                                    <td>{{ $complaint->created_at->format('d M Y') }}</td>

                                    <td>
                                        <a href="{{ route('student.complaints.show', $complaint->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No complaints found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
