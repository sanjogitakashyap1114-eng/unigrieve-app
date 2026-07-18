@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid p-3 p-md-4">

        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm">
                <h1 class="h4 page-title mb-1 text-brand-primary fw-bold">Complaint Management </h1>
                <p class="text-muted small mb-0">Audit, route, and update core verification parameters for filed student
                    grievances.</p>
            </div>
            <div class="col-sm-auto">
                <span class="badge px-3 py-2 rounded-3 fw-bold text-white shadow-sm bg-brand-primary">
                    Total complaint Registered: {{ $complaints->total() }}
                </span>
            </div>
        </div>
        <div class="row g-3 mb-4">
            @forelse($complaintWorkload->take(4) as $item)
                <div class="col-12 col-md-3">
                    <div class="p-2 border rounded bg-light">

                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-dark text-xs truncate-text" title="{{ $item->category }}">
                                {{ $item->category }}
                            </span>

                            <span class="badge bg-brand-primary rounded-pill text-xs fw-bold">
                                {{ $item->percentage }}%
                            </span>
                        </div>

                        <div class="progress metric-progress-height">
                            <div class="progress-bar bg-brand-primary" style="width: {{ $item->percentage }}%">
                            </div>
                        </div>

                        <small class="text-muted">
                            {{ $item->total }} complaints
                        </small>

                    </div>
                </div>
            @empty
                <div class="col-12 text-muted small py-2">
                    No complaint analytics available.
                </div>
            @endforelse
        </div>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <form action="{{ route('complaints.index') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-12 col-md-4">
                        <label class="form-label text-uppercase text-secondary mb-1 text-xs fw-bold">Search Tracker</label>
                        <input type="text" name="search" class="form-control bg-light border-0 text-sm"
                            placeholder="ID, Subject matter or Name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-uppercase text-secondary mb-1 text-xs fw-bold">Department</label>
                        <select name="department" class="form-select bg-light border-0 text-sm">
                            <option value="">All Departments</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ request('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-uppercase text-secondary mb-1 text-xs fw-bold">Status</label>
                        <select name="status" class="form-select bg-light border-0 text-sm">
                            <option value="">All Statuses</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved
                            </option>
                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-flex gap-1 justify-content-end">
                        <button type="submit"
                            class="btn  bg-brand-primary text-white border-0 w-100 text-sm fw-semibold">Filter</button>
                        <a href="{{ route('complaints.index') }}" class="btn btn-light border text-sm"><i
                                class="bi bi-arrow-counterclockwise"></i>Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-min-width">
                    <thead class="bg-brand-primary text-white">
                        <tr>
                            <th class="ps-3 text-uppercase small">Complaint ID</th>
                            <th class="text-uppercase small">Student Account</th>
                            <th class="text-uppercase small">Grievance Category</th>
                            <th class="text-uppercase small">Assigned Department</th>
                            <th class="text-uppercase small"> Status</th>
                            <th class="text-uppercase small">Created Date</th>
                            <th class="text-end pe-3 text-uppercase small">Inspect</th>
                        </tr>
                    </thead>
                    <tbody class="text-muted text-sm">
                        @forelse($complaints as $complaint)
                            <tr class="border-bottom">
                                <td class="ps-3 font-monospace fw-bold text-dark text-xs">
                                    {{ $complaint->complaint_id ?? '#CMP-' . $complaint->id }}
                                </td>
                                <td>
                                    <span
                                        class="fw-semibold text-dark d-block">{{ $complaint->user->name ?? 'Unregistered user' }}</span>
                                    <span class="text-xs text-muted">{{ $complaint->user->email ?? '' }}</span>
                                </td>
                                <td class="fw-medium text-secondary">{{ $complaint->category }}</td>
                                <td>
                                    <span class="px-2 py-0.5 rounded text-xs border bg-light text-dark">
                                        {{ $complaint->department->name ?? 'Unassigned Core Group' }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge rounded px-2 py-1 text-xs badge-status-{{ str_replace(' ', '', $complaint->status ?? 'Pending') }}">
                                        {{ $complaint->status ?? 'Pending' }}
                                    </span>
                                </td>
                                <td class="text-xs">
                                    {{ $complaint->created_at ? $complaint->created_at->format('M d, Y') : 'N/A' }}
                                </td>
                                {{-- <td class="text-end pe-3">
                                    <a href="{{ route('complaints.show', $complaint->id) }}"
                                        class="btn btn-sm btn-manage-action py-1 px-3 fw-bold">
                                        View Detail
                                    </a>
                                </td> --}}{{-- NAYA --}}
                                <td class="text-end pe-3">

                                    {{-- Hidden Reject Form --}}
                                    {{-- <form id="reject-form-{{ $complaint->id }}"
                                        action="{{ route('admin.complaints.action', $complaint->id) }}" method="POST"
                                        class="d-none">
                                        @csrf
                                        @method('PATCH')
                                    </form> --}}

                                    <form id="reject-form-{{ $complaint->id }}"
                                        action="{{ route('complaints.triage', $complaint->id) }}" method="POST"
                                        class="d-none">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action_type" value="reject">
                                    </form>

                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('complaints.show', $complaint->id) }}"
                                            class="btn btn-sm btn-manage-action py-1 px-3 fw-bold">
                                            View Detail
                                        </a>
                                        @if (($complaint->status ?? 'Pending') !== 'Rejected')
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger py-1 px-2 text-xs btn-reject-action"
                                                data-form-id="reject-form-{{ $complaint->id }}">
                                                Reject
                                            </button>
                                        @endif
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No filed complaint records match
                                    these criteria filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">
            {{ $complaints->links() }}
        </div>
    </div>
    @push('scripts')
        @vite(['resources/js/global.js'])
    @endpush
@endsection
