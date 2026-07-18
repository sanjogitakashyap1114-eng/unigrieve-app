@extends('layouts.dashboard')

@section('content')
<div class="dept-dashboard">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- ── LEFT COL ─────────────────────────────────────────── --}}
        <div class="col-lg-4">

            {{-- Staff Account Card --}}
            <div class="card section-card mb-4">
                <div class="card-header section-header">
                    <h5 class="mb-0">My Account</h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="avatar-circle mx-auto mb-3">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
                        <div class="text-muted small">{{ $user->email }}</div>
                        <span class="type-badge type-service mt-2 d-inline-block">Department Staff</span>
                    </div>

                    <form action="{{ route('department.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label detail-label">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label detail-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save me-1"></i> Save Changes
                        </button>
                    </form>
                </div>
            </div>

            {{-- Change Password Card --}}
            <div class="card section-card">
                <div class="card-header section-header">
                    <h5 class="mb-0">Change Password</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('department.profile.password') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label detail-label">Current Password</label>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="Enter current password">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label detail-label">New Password</label>
                            <input type="password" name="new_password"
                                   class="form-control @error('new_password') is-invalid @enderror"
                                   placeholder="Min 8 characters">
                            @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label detail-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation"
                                   class="form-control"
                                   placeholder="Repeat new password">
                        </div>

                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-shield-lock me-1"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- ── RIGHT COL: Department Info ───────────────────────── --}}
        <div class="col-lg-8">
            <div class="card section-card">
                <div class="card-header section-header">
                    <h5 class="mb-0">Department Information</h5>
                </div>
                <div class="card-body p-4">

                    @if($department)
                        <div class="dept-banner mb-4">
                            <div class="dept-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">{{ $department->name }}</h4>
                                @if($department->description)
                                    <p class="text-muted mb-0">{{ $department->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="info-item">
                                    <div class="detail-label">Department Head</div>
                                    <div class="detail-value">
                                        <i class="bi bi-person-badge me-1 text-muted"></i>
                                        {{ $department->head_name ?? '—' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-item">
                                    <div class="detail-label">Official Email</div>
                                    <div class="detail-value">
                                        <i class="bi bi-envelope me-1 text-muted"></i>
                                        {{ $department->email ?? '—' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-item">
                                    <div class="detail-label">Phone</div>
                                    <div class="detail-value">
                                        <i class="bi bi-telephone me-1 text-muted"></i>
                                        {{ $department->phone ?? '—' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-item">
                                    <div class="detail-label">Department Since</div>
                                    <div class="detail-value">
                                        <i class="bi bi-calendar3 me-1 text-muted"></i>
                                        {{ $department->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Quick stats for this department --}}
                        <div class="row g-3">
                            <div class="col-4">
                                <div class="mini-stat">
                                    <div class="mini-stat-value text-primary">
                                        {{ \App\Models\Complaint::where('department_id', $department->id)->count() }}
                                    </div>
                                    <div class="mini-stat-label">Total Complaints</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mini-stat">
                                    <div class="mini-stat-value text-success">
                                        {{ \App\Models\Complaint::where('department_id', $department->id)->where('status','Resolved')->count() }}
                                    </div>
                                    <div class="mini-stat-label">Resolved</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mini-stat">
                                    <div class="mini-stat-value text-info">
                                        {{ \App\Models\ServiceRequest::where('department_id', $department->id)->count() }}
                                    </div>
                                    <div class="mini-stat-label">Service Requests</div>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-building fs-1 d-block mb-2 opacity-25"></i>
                            Department information not found.
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

<style>

</style>
@endsection