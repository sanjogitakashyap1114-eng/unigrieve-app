<div class="sidebar d-flex flex-column p-3 min-vh-100">

    {{-- BRAND --}}
    <a href="/dashboard" class="d-flex align-items-center mb-4 text-white text-decoration-none">
        <span class="fs-4 fw-bold"> UniGrieve</span>
    </a>

    <hr class="text-secondary">

    @php
        // Picks the right "Dashboard" link based on role instead of
        // always sending everyone to student.dashboard.
        $dashboardRoute = match (auth()->user()->role) {
            'department' => 'department.dashboard',
            'admin' => 'admin.dashboard',
            default => 'student.dashboard',
        };
    @endphp

    {{-- MENU --}}
    <ul class="nav nav-pills flex-column gap-2 flex-grow-1">

        <li class="nav-item">
            <a href="{{ route($dashboardRoute) }}"
                class="nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> <span>Dashboard</span>
            </a>
        </li>

        {{-- STUDENT MENU --}}
        @if (auth()->user()->role == 'student')
            <li>
                <a href="{{ route('student.mycomplaint') }}"
                    class="nav-link {{ request()->routeIs('student.mycomplaint') ? 'active' : '' }}">
                    <i class="fas fa-exclamation-circle me-2"></i> <span>My Complaints</span>
                </a>
            </li>

            <li>
                <a href="{{ route('student.myservices') }}"
                    class="nav-link {{ request()->routeIs('student.myservices') ? 'active' : '' }}">
                    <i class="fas fa-concierge-bell me-2"></i> <span>My Services</span>
                </a>
            </li>

            <li>
                <a href="{{ route('student.profile') }}"
                    class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <i class="fas fa-user-circle me-2"></i> <span>Profile</span>
                </a>
            </li>
        @endif

        {{-- ADMIN MENU --}}
        @if (auth()->user()->role == 'admin')
            <li>
                <a href="{{ route('students.index') }}"
                    class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> <span>Students</span>
                </a>
            </li>
            <li>
                <a href="{{ route('complaints.index') }}"
                    class="nav-link {{ request()->routeIs('complaints.index') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list me-2"></i> <span>Complaints</span>
                </a>
            </li>
            <li>
                <a href="{{ route('services.index') }}"
                    class="nav-link {{ request()->routeIs('services.index') ? 'active' : '' }}">
                    <i class="fas fa-cogs me-2"></i> <span>Services</span>
                </a>
            </li>
            <li>
                {{-- <a href="{{route('departments.index')}}" class="nav-link {{ request()->is('departments.index') ? 'active' : '' }}">
                    <i class="fas fa-building me-2"></i> <span>Departments</span>
                </a> --}}
                <a href="{{ route('departments.index') }}"
                    class="nav-link {{ request()->routeIs('departments.index') ? 'active' : '' }}">
                    <i class="fas fa-building me-2"></i> <span>Departments</span>
                </a>
            </li>
            {{-- <li>
                <a href="route('')" class="nav-link {{ request()->is('admin/reports') ? 'active' : '' }}">
                   <i class="fas fa-chart-bar me-2"></i> <span>Reports</span>
                </a>
            </li> --}}
            <li>
                <a href="{{ route('profile.index') }}"
                    class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                    <i class="fas fa-user-circle me-2"></i><span>Profile</span>
                </a>
            </li>
        @endif

        {{-- DEPARTMENT MENU --}}
        @if (auth()->user()->role == 'department')

            <li>
                <a href="{{ route('department.complaints') }}"
                    class="nav-link {{ request()->routeIs('department.complaints') ? 'active' : '' }}">
                    <i class="fas fa-thumbtack me-2"></i> <span>Assigned Complaints</span>
                </a>
            </li>

            <li>
                <a href="{{ route('department.services') }}"
                    class="nav-link {{ request()->routeIs('department.services') ? 'active' : '' }}">
                    <i class="fas fa-tasks me-2"></i> <span>Assigned Services</span>
                </a>
            </li>

            <li>
                <a href="{{ route('department.notices') }}"
                    class="nav-link {{ request()->routeIs('department.notifications') ? 'active' : '' }}">
                    🔔 <span>Notices</span>
                    @if (($unreadCount ?? 0) > 0)
                        <span class="nav-badge">{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>

            <li>
                <a href="{{ route('department.profile') }}"
                    class="nav-link {{ request()->routeIs('department.profile') ? 'active' : '' }}">
                    <i class="fas fa-user-circle me-2"></i> <span>Profile</span>
                </a>
            </li>

        @endif

    </ul>

    <hr class="text-secondary mt-auto">

    {{-- LOGOUT --}}
    <form method="POST" action="{{ route('logout') }} " class="mt-auto">
        @csrf
        <button type="submit" class="btn btn-danger w-100 logout-btn">
            Logout
        </button>
    </form>

</div>
