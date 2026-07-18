@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid p-3 p-md-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <span class="small fw-semibold">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm">
                <h1 class="h4 page-title mb-1 text-brand-primary letter-spacing-tight">
                    Service Management
                </h1>
                <p class="text-muted small mb-0 fw-medium">Review, assign, and monitor student service requests across
                    departments.</p>
            </div>
            <div class="col-sm-auto d-flex gap-2 align-items-center">
                <span class="badge px-3 py-2 rounded-3 fw-bold text-white shadow-sm bg-brand-primary badge-active-tracker">
                    Total services Requests: {{ $services->count() }}
                </span>
            </div>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-dark mb-3 text-sm text-uppercase tracking-wider">Service Workload Overview
                        </h6>
                        <p>Monitor request volume and workload distribution across service types.</p>
                        <div class="row g-3">
                            @forelse($workloads->take(4) as $workload)
                                <div class="col-12 col-md-3">
                                    <div class="p-2 border rounded bg-light">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-semibold text-dark text-xs truncate-text"
                                                title="{{ $workload->service_type }}">{{ $workload->service_type }}</span>
                                            <span
                                                class="badge bg-brand-primary rounded-pill text-xs fw-bold">{{ $workload->percentage }}%</span>
                                        </div>
                                        <div class="progress metric-progress-height">
                                            <div class="progress-bar bg-brand-primary" role="progressbar"
                                                style="width: {{ $workload->percentage }}%"></div>

                                        </div>
                                        <small class="text-muted">
                                            {{ $workload->total }} Services Requests
                                        </small>

                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-muted small py-2">No active metric benchmarks found.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <form action="{{ request()->url() }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-12 col-md-4 col-xl-4">
                        <label class="form-label text-uppercase text-secondary mb-1 filter-label-header fw-bold">Search
                            Service</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control bg-light border-0 text-sm filter-input-height"
                            placeholder="Service Module Name...">
                    </div>
                    <div class="col-6 col-md-3 col-xl-3">
                        <label class="form-label text-uppercase text-secondary mb-1 filter-label-header fw-bold">Linked
                            Group</label>
                        <select name="group" class="form-select bg-light border-0 text-sm filter-input-height">
                            <option value="">Departments</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('group') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3 col-xl-3">
                        <label
                            class="form-label text-uppercase text-secondary mb-1 filter-label-header fw-bold">Status</label>
                        <select name="status" class="form-select bg-light border-0 text-sm filter-input-height">
                            <option value="">All Statuses</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved
                            </option>
                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                    <div class="col-12 col-md-auto d-flex gap-1 ms-auto justify-content-end">
                        <button type="submit"
                            class="btn btn-primary fw-semibold text-sm modal-action-submit filter-input-height filter-btn-compact border-0">Filter</button>
                        <a href="{{ request()->url() }}"
                            class="btn btn-light border text-sm d-flex align-items-center justify-content-center filter-input-height text-secondary"
                            title="Reset Filters">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="table-responsive w-100">
                        <table class="table table-hover align-middle mb-0 table-min-width">
                            <thead class="modal-header-custom text-white">
                                <tr>
                                    <th class="ps-3 text-uppercase small">Service NO</th>
                                    <th class="text-uppercase small">Student Name</th>
                                    <th class="text-uppercase small">Registration NO</th>
                                    <th class="text-uppercase small">Service Category</th>
                                    <th class="text-uppercase small">Assign Department</th>
                                    <th class="text-uppercase small">Status</th>
                                    <th class="text-end pe-3 text-uppercase small">Inspect</th>
                                </tr>
                            </thead>
                            <tbody class="text-muted text-sm">
                                @forelse($services as $service)
                                    @php

                                        $studentProfile = $service->student->studentMaster ?? null;
                                    @endphp
                                    <tr class="table-row-border">
                                        <td class="ps-3 font-monospace fw-bold text-dark text-xs">
                                            {{ $service->service_id }}</td>
                                        <td>
                                            <div class="fw-semibold text-dark">
                                                {{ $studentProfile ? $studentProfile->name : 'Unknown Profile' }}
                                            </div>
                                        </td>
                                        <td class="font-monospace text-xs">
                                            {{ $studentProfile ? $studentProfile->registration_no : 'N/A' }}</td>
                                        <td class="fw-medium text-secondary">{{ $service->service_type }}</td>
                                        <td><span
                                                class="px-2 py-0.5 rounded text-xs border bg-table-badge">{{ $service->department->name ?? 'Unallocated' }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded px-2 py-1 text-xs badge-status-{{ $service->status ?? 'Pending' }}">
                                                {{ $service->status ?? 'Pending' }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="{{ route('services.show', $service->id) }}"
                                                    class="btn btn-sm btn-outline-primary py-1 px-2 text-xs fw-semibold">View
                                                    Detail</a>
                                                @if ($service->status !== 'Rejected')
                                                    {{-- <form action="{{ route('services.reject', $service->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger py-1 px-2 text-xs">Reject</button>
                                                    </form> --}}
                                                    <form id="reject-form-{{ $service->id }}"
                                                        action="{{ route('services.reject', $service->id) }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                        @method('PATCH')
                                                    </form>

                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger py-1 px-2 text-xs btn-reject-action"
                                                        data-form-id="reject-form-{{ $service->id }}">
                                                        Reject
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted border-0">No record found.
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
        @vite(['resources/js/global.js'])
    @endpush
@endsection
