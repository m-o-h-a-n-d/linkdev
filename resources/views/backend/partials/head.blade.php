<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Handball Competition Management System Admin Panel">
    <meta name="author" content="Handball Admin">

    <title>@yield('title', 'Backend | Handball Competition Management System')</title>

    <!-- Custom fonts for SB Admin 2 -->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Google Fonts (Inter font matching Login Page) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom styles for SB Admin 2 -->
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}?v={{ time() }}" rel="stylesheet">

    <!-- Premium Handball Animations & Design -->
    <link href="{{ asset('backend/css/handball-pro.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('backend/css/admin-cards.css') }}?v={{ time() }}" rel="stylesheet">

    <!-- Real-Time WebSockets Config -->
    <meta name="reverb-key" content="{{ config('broadcasting.connections.reverb.key', env('REVERB_APP_KEY', 'ebblun6tzqjoj7nqj3p3')) }}">
    <meta name="reverb-host" content="{{ config('broadcasting.connections.reverb.options.host', env('REVERB_HOST', '127.0.0.1')) }}">
    <meta name="reverb-port" content="{{ config('broadcasting.connections.reverb.options.port', env('REVERB_PORT', 8085)) }}">
    <meta name="reverb-scheme" content="{{ config('broadcasting.connections.reverb.options.scheme', env('REVERB_SCHEME', 'http')) }}">

    <!-- Real-Time WebSockets: Pusher & Laravel Echo Scripts -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
    <script src="{{ asset('backend/js/echo-init.js') }}"></script>

    <!-- Immediate Sidebar State Initialization (Prevent FOUC / Animation Flash) -->
    <script>
        (function() {
            var state = localStorage.getItem('sidebarState');
            if (state === 'expanded') {
                document.documentElement.classList.add('sidebar-init-expanded');
            } else {
                document.documentElement.classList.add('sidebar-init-collapsed');
            }
        })();
    </script>
</head>
