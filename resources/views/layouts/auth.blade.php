<!-- resources/views/layouts/auth.blade.php -->
<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/main.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    
    <!-- NO NAVBAR HERE. Just a wrapper for the auth forms -->
    <div class="w-full max-w-md">
        @yield('content')
    </div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@stack('scripts')
</body>
</html>
