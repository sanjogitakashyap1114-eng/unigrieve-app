<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student System</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN Link -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    {{-- Your CSS --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}"> --}}
    @vite(['resources/css/main.css'])
</head>

<body>

    <div class="d-flex" id="wrapper">

        {{-- SIDEBAR --}}
        <div id="sidebar-wrapper">
            @include('partials.dashboardsidebar')
        </div>
        {{-- ===== PAGE CONTENT ===== --}}

        <div id="page-content-wrapper" class="main-content-wrapper flex-grow-1">

            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-3">
                @include('partials.dashboardnav')
            </nav>

            {{-- MAIN CONTENT --}}
            <div class="container-fluid py-4">
                @yield('content')
            </div>

        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    {{-- Bootstrap JS --}}
    {{-- YOUR TOGGLE SCRIPT — must be last --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar-wrapper');

            if (!toggleBtn || !sidebar) {
                console.warn('Sidebar toggle: button or sidebar not found');
                return; // ← this will tell you immediately if ID is wrong
            }

            const isMobile = () => window.innerWidth < 992;

            const backdrop = document.createElement('div');
            backdrop.className = 'sidebar-backdrop';
            backdrop.style.display = 'none';
            document.body.appendChild(backdrop);

            toggleBtn.addEventListener('click', function() {
                if (isMobile()) {
                    const isOpen = sidebar.classList.toggle('open');
                    backdrop.style.display = isOpen ? 'block' : 'none';
                } else {
                    sidebar.classList.toggle('collapsed');
                }
            });

            backdrop.addEventListener('click', function() {
                sidebar.classList.remove('open');
                backdrop.style.display = 'none';
            });

            window.addEventListener('resize', function() {
                if (!isMobile()) {
                    sidebar.classList.remove('open');
                    backdrop.style.display = 'none';
                }
            });

        });
    </script>
</body>

</html>
