@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1 text-brand-primary">Dashboard</h3>
                <p class="text-muted mb-0">
                    Welcome back, {{ auth()->user()->name }}! Here's an overview of your activity.
                </p>
            </div>
            <div>
                <a href="{{ route('complaints.create') }}" class="btn btn-primary btn-sm btn-md-custom">
                    <i class="bi bi-plus-circle me-1"></i> Create Complaint
                </a>
                <a href="{{ route('student.services.create') }}" class="btn btn-success btn-sm btn-md-custom">
                    <i class="bi bi-plus-circle me-1"></i> Request Services
                </a>
            </div>
        </div>

        {{-- COMPACT IMPORTANT NOTICE --}}
        @if($notices->count())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4 py-2 px-3" role="alert">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center flex-grow-1">
                        <i class="fas fa-bullhorn text-danger me-2"></i>
                        <div class="small text-truncate">
                            <strong class="me-2">Notice:</strong>
                            @foreach($notices as $notice)
                                <span>{{ $notice->title }} - {{ \Illuminate\Support\Str::limit($notice->description, 90) }}</span>
                                @if($notice->last_date)
                                    <span class="text-dark fw-bold ms-1">(Due: {{ \Carbon\Carbon::parse($notice->last_date)->format('d M') }})</span>
                                @endif
                                @if(!$loop->last) | @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <a href="{{ route('student.notices') }}" class="btn btn-light btn-xs py-0 px-2 small">
                            View All
                        </a>
                        <button type="button" class="btn-close position-static p-0 m-0" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        {{-- NEW COMPACT NAVIGATION CARDS --}}
        <div class="row g-3 mb-4">
            {{-- Card 1: My Complaints --}}
            <div class="col-6 col-sm-6 col-xl-3">
                <a href="#submissions-section" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100 table-hover">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary-subtle text-primary p-2 rounded me-3 d-none d-sm-block">
                                    <i class="bi bi-file-earmark-text fs-4"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Manage</p>
                                    <h6 class="fw-bold mb-0">My Complaints</h6>
                                    <span class="badge bg-primary-subtle text-primary px-2 py-1 mt-1 small">{{ $totalComplaints }} Active</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card 2: My Services --}}
            <div class="col-6 col-sm-6 col-xl-3">
                <a href="#submissions-section" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100 table-hover">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-success-subtle text-success p-2 rounded me-3 d-none d-sm-block">
                                    <i class="bi bi-gear fs-4"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Request</p>
                                    <h6 class="fw-bold mb-0">My Services</h6>
                                    <span class="badge bg-success-subtle text-success px-2 py-1 mt-1 small">{{ $totalServices }} Enrolled</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card 3: My Profile --}}
            <div class="col-6 col-sm-6 col-xl-3">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100 table-hover">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-info-subtle text-info p-2 rounded me-3 d-none d-sm-block">
                                    <i class="bi bi-person-circle fs-4"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Account</p>
                                    <h6 class="fw-bold mb-0">My Profile</h6>
                                    <span class="text-muted small d-block mt-1">View Details</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card 4: Notices Shortcut --}}
            <div class="col-6 col-sm-6 col-xl-3">
                <a href="{{ route('student.notices') }}" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100 table-hover">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-warning-subtle text-warning p-2 rounded me-3 d-none d-sm-block">
                                    <i class="bi bi-shield-check fs-4"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">News/Notice</p>
                                    <h6 class="fw-bold mb-0 text-success">View Notices</h6>
                                    <span class="text-muted small d-block mt-1">Check Announcements</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- SINGLE FULL-WIDTH RECENT SUBMISSIONS TABLE --}}
        <div class="row" id="submissions-section">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-list-task text-secondary me-2"></i>Recent Activity & Submissions
                            </h5>
                            <div class="gap-2 d-flex">
                                <a href="{{ route('student.mycomplaint') }}" class="btn btn-sm btn-outline-primary">Complaints</a>
                                <a href="{{ route('student.myservices') }}" class="btn btn-sm btn-outline-success">Services</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentSubmissions as $submission)
                                        <tr>
                                            <td>{{ $submission['display_id'] }}</td>
                                            <td>
                                                @if($submission['type'] == 'complaint')
                                                    <span class="badge bg-primary-subtle text-primary">Complaint</span>
                                                @else
                                                    <span class="badge bg-success-subtle text-success">Service Request</span>
                                                @endif
                                            </td>
                                            <td>{{ $submission['category'] }}</td>
                                            <td>
                                                @if (strtolower($submission['status']) == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif(strtolower($submission['status']) == 'resolved' || strtolower($submission['status']) == 'completed')
                                                    <span class="badge bg-success">Success</span>
                                                @else
                                                    <span class="badge bg-info text-dark">{{ ucfirst($submission['status']) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $submission['date']->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                No recent activity found.
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

    </div>
@endsection