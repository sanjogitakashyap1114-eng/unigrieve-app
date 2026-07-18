@extends('layouts.dashboard')

@section('content')
<div class="container-fluid p-3 p-md-4">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <span class="small fw-semibold">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row align-items-center mb-4 g-3">
        <div class="col-sm">
            <h1 class="h4 page-title mb-1 text-brand-primary letter-spacing-tight">Registered Students</h1>
            <p class="text-muted small mb-0 fw-medium">Core workspace displaying registered student metrics and files.</p>
        </div>
        <div class="col-sm-auto">
            <span class="badge px-3 py-2 rounded-3 fw-bold text-white shadow-sm bg-brand-primary badge-active-tracker">
                Total Students: {{ $students->count() }}
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ request()->url() }}" method="GET" class="row g-2 align-items-end">
                <div class="col-12 col-md-10">
                    <label class="form-label text-uppercase text-secondary mb-1 filter-label-header fw-bold">Search Directory</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-0 text-sm filter-input-height" placeholder="Search by Reg No, Name, or Email Address...">
                </div>
                <div class="col-12 col-md-2 d-flex gap-1 ms-auto justify-content-end">
                    <button type="submit" class="btn btn-primary fw-semibold text-sm modal-action-submit filter-input-height w-100 border-0">Search</button>
                    <a href="{{ request()->url() }}" class="btn btn-light border text-sm d-flex align-items-center justify-content-center filter-input-height text-secondary" title="Reset">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive w-100">
            <table class="table table-hover align-middle mb-0 table-min-width">
                <thead class="modal-header-custom text-white">
                    <tr>
                        <th class="ps-3 text-uppercase small">Reg NO</th>
                        <th class="text-uppercase small">Name</th>
                        <th class="text-uppercase small">Email</th>
                        <th class="text-uppercase small">Phone</th>
                        <th class="text-uppercase small">Batch</th>
                        <th class="text-uppercase small">Course</th>
                        <th class="text-end pe-3 text-uppercase small">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-muted text-sm">
                    @forelse($students as $student)
                        <tr class="table-row-border">
                            <td class="ps-3 font-monospace fw-bold text-dark text-xs">{{ $student->studentMaster->registration_no ?? 'N/A' }}</td>
                            <td><div class="fw-semibold text-dark">{{ $student->name }}</div></td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->studentMaster->phone ?? 'N/A' }}</td>
                            <td><span class="badge bg-light text-dark border px-2 py-1 text-xs">{{ $student->studentMaster->batch ?? 'N/A' }}</span></td>
                            <td class="fw-medium text-secondary">{{ $student->studentMaster->course ?? 'N/A' }}</td>
                            <td class="text-end pe-3">
                                <a href="" class="btn btn-sm btn-outline-primary py-1 px-2 text-xs fw-semibold">Edit Profile</a>
                            </td>
                            {{-- {{ route('admin.students.edit', $student->id) }} --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted border-0">No registered students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection