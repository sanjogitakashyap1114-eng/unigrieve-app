<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">
            UniGrieve
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link custom-pill-hover text-warning active" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  custom-pill-hover" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  custom-pill-hover" href="#">Raise Complaint</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link custom-pill-hover" href="{{ route('public.departments') }}">Departments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  custom-pill-hover" href="#">Contact</a>
                </li>
            </ul>
            <div class="nav-link">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-white btn-warning   login-btn">Login</a>

                    <a href="{{ route('register') }}" class="btn btn-warning">Register</a>
                </div>
            @endguest
            @auth
                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-warning">Dashboard</a>
                @elseif(auth()->user()->role == 'department')
                    <a href="{{ route('department.dashboard') }}" class="btn btn-outline-warning">Dashboard</a>
                @elseif(auth()->user()->role == 'student')
                    <a href="{{ route('student.dashboard') }}" class="btn btn-outline-warning">Dashboard</a>
                @endif
                <a href="{{ route('logout') }}" class="btn  btn-warning"
                    onclick="event.preventDefault();document.getElementById('navbar-logout-form').submit();">Logout</a>
                <form id="navbar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endauth
        </div>
    </div>
</nav>
<!-- Navbar End -->
