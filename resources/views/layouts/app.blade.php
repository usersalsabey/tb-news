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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Page Specific Styles -->
    @stack('styles')
</head>
<body>
    
    <!-- Main Content -->
    @yield('content')
    
    <!-- Scripts -->
    @stack('scripts')

    @include('partials.chatbot')
    
</body>
</html>