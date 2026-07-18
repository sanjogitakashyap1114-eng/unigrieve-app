<div class="d-flex justify-content-between align-items-center w-100">

    {{-- LEFT --}}
    <div class="d-flex align-items-center">

        <button id="sidebarToggle" class="btn btn-outline-secondary me-3">
            ☰
        </button>

        <h5 class="mb-0 fw-semibold">
            Student Dashboard
        </h5>

    </div>

    {{-- RIGHT --}}
    <div class="dropdown">

        <button
            class="btn btn-light border dropdown-toggle"
            data-bs-toggle="dropdown">

            {{-- Dynamic User Name --}}
            👤 {{ auth()->user()->name ?? 'Guest' }}

        </button>

        <ul class="dropdown-menu dropdown-menu-end">

            <li>
                <a class="dropdown-item" href="#">
                    Profile
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="#">
                    Settings
                </a>
            </li>

            <li><hr class="dropdown-divider"></li>

            <li>
                {{-- Example form-based logout for security --}}
                <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">
                    @csrf
                </form>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </li>

        </ul>

    </div>

</div>