<!DOCTYPE html>
<html lang="en">

@include('backend.partials.head')

<body id="page-top" class="sidebar-toggled preload-sidebar">

    <!-- Page Wrapper -->
    <div id="wrapper" class="toggled">

        <!-- Sidebar Navigation -->
        @include('backend.partials.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('backend.partials.topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('backend.partials.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modals -->
    @include('backend.partials.modals')

    <!-- Scripts -->
    @include('backend.partials.scripts')

    <!-- Synchronous State Sync (Prevent Animation Flash on Navigation) -->
    <script>
        (function() {
            var state = localStorage.getItem('sidebarState');
            var body = document.body;
            var sidebar = document.getElementById('accordionSidebar');
            var wrapper = document.getElementById('wrapper');

            if (state === 'expanded') {
                body.classList.remove('sidebar-toggled');
                if (sidebar) sidebar.classList.remove('toggled');
                if (wrapper) wrapper.classList.remove('toggled');
            } else {
                body.classList.add('sidebar-toggled');
                if (sidebar) sidebar.classList.add('toggled');
                if (wrapper) wrapper.classList.add('toggled');
            }
        })();
    </script>
</body>

</html>
