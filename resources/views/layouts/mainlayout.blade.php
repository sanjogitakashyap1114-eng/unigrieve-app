<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'UniGrieve')</title>

    @vite(['resources/css/main.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100">

    @include('partials.guestnavbar')

    <main class="container-fluid   p-0">
        @yield('content')
    </main>

    @include('partials.guestfooter')

</body>
</html>