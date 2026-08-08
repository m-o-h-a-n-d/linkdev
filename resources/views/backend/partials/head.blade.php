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
    <link href="{{ asset('backend/css/staff-cards.css') }}?v={{ time() }}" rel="stylesheet">

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
