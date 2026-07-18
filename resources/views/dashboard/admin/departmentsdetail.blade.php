@extends('layouts.dashboard')

@section('content')
  
    <div class="container-fluid p-3 p-md-4">

        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm">
                <h1 class="h4 page-title mb-1 text-brand-primary letter-spacing-tight">
                    Department Overview
                </h1>
                <p class="text-muted small mb-0 fw-medium">Monitor active unit capacity, oversee assigned staff layers, and
                    optimize workload parameters.</p>
            </div>
            <div class="col-sm-auto">
                <button
                    class="btn btn-primary fw-semibold text-sm modal-action-submit filter-input-height px-3 shadow-sm border-0 rounded-3"
                    data-bs-toggle="modal" data-bs-target="#createDepartmentModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Department
                </button>
            </div>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-dark mb-3 text-sm text-uppercase tracking-wider">Operational Live Workload
                            Metrics</h6>
                        <div class="row g-3">
                            @forelse($departments->take(4) as $dept)
                                @php
                                    $total_complaints =
                                        $dept->pending_count + $dept->progress_count + $dept->resolved_count;
                                    $active_load =
                                        $total_complaints > 0
                                            ? round(
                                                (($dept->pending_count + $dept->progress_count) / $total_complaints) *
                                                    100,
                                            )
                                            : 0;
                                @endphp
                                <div class="col-12 col-md-3">
                                    <div class="p-2 border rounded bg-light">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-semibold text-dark text-xs text-truncate"
                                                style="max-width: 150px;">{{ $dept->name }} Load</span>
                                            <span
                                                class="badge bg-brand-primary rounded-pill text-xs fw-bold">{{ $active_load }}%</span>
                                        </div>
                                        <div class="progress metric-progress-height">
                                            <div class="progress-bar bg-brand-primary" role="progressbar"
                                                style="width: {{ $active_load }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-muted text-xs ps-3">No operational parameters loaded in system
                                    registry memory.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="table-responsive w-100">
                        <table class="table table-hover align-middle mb-0 table-min-width">
                            <thead class="modal-header-custom text-white">
                                <tr>
                                    <th class="ps-3 text-uppercase small">Department</th>
                                    <th class="text-uppercase small">Staff Count</th>
                                    <th class="text-uppercase small">Pending</th>
                                    <th class="text-uppercase small">In Progress</th>
                                    <th class="text-uppercase small">Resolved</th>
                                    {{-- <th class="text-uppercase small">Avg Resolution Time</th>
                                    <th class="text-uppercase small">Status</th> --}}
                                    <th class="text-end pe-3 text-uppercase small">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-muted text-sm">
                                @forelse($departments as $dept)
                                    <tr class="table-row-border">
                                        <td class="ps-3 fw-bold text-dark">
                                            {{ $dept->name }}
                                            <span class="d-block text-xs text-muted fw-normal">Head:
                                                {{ $dept->head_name ?? ($dept->head ?? 'N/A') }}</span>
                                        </td>
                                        <td class="fw-medium text-secondary">{{ $dept->staff_count }}</td>
                                        <td class="text-danger fw-semibold">{{ $dept->pending_count }}</td>
                                        <td class="text-warning fw-semibold">{{ $dept->progress_count }}</td>
                                        <td class="text-success fw-semibold">{{ $dept->resolved_count }}</td>
                                        {{-- <td class="fw-medium">2.4 Days</td>
                                        <td>
                                            <span
                                                class="badge rounded px-2 py-0.5 text-xs {{ ($dept->status ?? 'Active') == 'Active' ? 'badge-active' : 'badge-disabled' }}">
                                                {{ $dept->status ?? 'Active' }}
                                            </span>
                                        </td> --}}
                                        <td class="text-end pe-3">
                                            <a href="{{ route('departments.show', $dept->id) }}"
                                                class="btn btn-sm btn-manage-action py-1 px-3 fw-semibold">
                                                Manage
                                            </a>
                                            <form action="{{ route('departments.destroy', $dept->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this entire department structure?');"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-danger py-1 px-2 fw-semibold text-white   btn-remove-dept">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-xs text-muted">
                                            No active department configurations found in system architecture repositories.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 @push('scripts')
        @vite(['resources/js/admin.js'])
    @endpush
@endsection
