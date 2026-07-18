@extends('layouts.dashboard')

@section('content')
     <div class="container-fluid px-0">
        <div class="row g-4">
            
            {{-- LEFT SIDE: PROFILE OVERVIEW --}}
            <div class="col-12 col-lg-4">
                <!-- Profile Header Card -->
                <div class="card card-custom border-0 shadow-sm bg-white overflow-hidden mb-4">
                    <div class="profile-cover"></div>
                    <div class="profile-avatar-wrapper d-flex align-items-end mb-3">
                        <div class="profile-avatar rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                            <i class="fas fa-user-shield fa-3x text-secondary"></i>
                        </div>
                        <div class="ms-3 mb-2">
                            <h5 class="fw-bold text-dark mb-0">{{ Auth::user()->name ?? 'Administrator' }}</h5>
                            <span class="badge bg-primary-subtle text-primary rounded-pill fw-semibold small px-2 py-1">
                                <i class="fas fa-crown me-1"></i> System Admin
                            </span>
                        </div>
                    </div>
                    <div class="card-body pt-0 px-4">
                        <hr class="text-muted opacity-25 my-3">
                        
                        <!-- Minimal Information Fields -->
                        <div class="mb-3">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Email Address</label>
                            <span class="text-dark fw-medium">{{ Auth::user()->email ?? 'admin@university.edu' }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Role Permissions</label>
                            <span class="text-secondary small"><i class="fas fa-check-circle text-success me-1"></i> Full Read/Write Access</span>
                        </div>

                        <div class="mb-2">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Account Created</label>
                            <span class="text-secondary small">
                                <i class="fas fa-calendar-alt me-1"></i> 
                                {{ Auth::user()->created_at ? Auth::user()->created_at->format('M d, Y') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Admin Responsibility Highlights (Fills Up Space Professionally) -->
                <div class="card card-custom border-0 shadow-sm bg-white">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3">System Overview</h6>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="mini-stat-box text-center">
                                    <span class="text-muted small d-block mb-1">Total Complaints</span>
                                    <h4 class="fw-bold text-dark mb-0">{{ $totalComplaints ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mini-stat-box text-center">
                                    <span class="text-muted small d-block mb-1">Total Services</span>
                                    <h4 class="fw-bold text-dark mb-0">{{ $totalServices ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE: SETTINGS & FORMS --}}
            <div class="col-12 col-lg-8">
                <!-- Account Settings Form Box -->
                <div class="card card-custom border-0 shadow-sm bg-white mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark mb-1">
                            <i class="fas fa-sliders-h text-primary me-2"></i> Account Settings
                        </h5>
                        <p class="text-muted small mb-0">Update your account identity details below.</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="#" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name ?? '' }}" required style="border-radius: 8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="{{ Auth::user()->email ?? '' }}" required style="border-radius: 8px;">
                                </div>
                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 8px;">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password Form Box -->
                <div class="card card-custom border-0 shadow-sm bg-white">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark mb-1">
                            <i class="fas fa-lock text-warning me-2"></i> Update Password
                        </h5>
                        <p class="text-muted small mb-0">Ensure your admin account stays highly secure.</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="#" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-medium">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" placeholder="••••••••" required style="border-radius: 8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">New Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters" required style="border-radius: 8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type new password" required style="border-radius: 8px;">
                                </div>
                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-outline-dark px-4" style="border-radius: 8px;">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection