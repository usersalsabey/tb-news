<!DOCTYPE html>
<html lang="id">
<head>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TB News - Portal Kepolisian Indonesia')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">

    <!-- Page Specific Styles -->
    @stack('styles')
</head>
<body>

    {{-- Navbar global --}}
    @include('partials.navbar')

    <!-- Main Content -->
    @yield('content')

    {{-- Footer global --}}
    @include('partials.footer')

    <!-- Scripts -->
    @stack('scripts')

    @include('partials.chatbot')

</body>
</html>