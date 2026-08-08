<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar - Visible on Desktop and Mobile) -->
    <button id="sidebarToggleTop" class="btn btn-light rounded-circle mr-3 border-0 shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; color: #475569; background: #f8fafc;" title="Toggle Sidebar Navigation">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search teams, matches, competitions..." data-handball-search="mainMatchesTable" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Quick Actions Dropdown -->
        <li class="nav-item dropdown no-arrow mx-1 align-self-center mr-2">
            <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle shadow-sm" type="button" id="quickActionBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-plus-circle mr-1"></i> Quick Action
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="quickActionBtn">
                    <a class="dropdown-item" href="{{ route('admin.competitions.create') }}"><i class="fas fa-trophy text-primary mr-2"></i>Create Competition</a>
                    <a class="dropdown-item" href="{{ route('admin.teams.create') }}"><i class="fas fa-shield-alt text-success mr-2"></i>Register Team</a>
                    <a class="dropdown-item" href="{{ route('admin.matches.create') }}"><i class="fas fa-calendar-plus text-info mr-2"></i>Schedule Match</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger font-weight-bold" href="{{ route('admin.matches.live-center') }}"><i class="fas fa-broadcast-tower text-danger mr-2"></i>Live Match Center</a>
                </div>
            </div>
        </li>

        <!-- Notifications Dropdown -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">2</span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header bg-primary border-0">Live Match Alerts</h6>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.matches.live-center') }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-danger text-white animate-pulse">
                            <i class="fas fa-running"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">LIVE NOW</div>
                        <span class="font-weight-bold">Al Ahly SC vs Zamalek SC (26 - 24)</span>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.matches.index') }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning text-white">
                            <i class="fas fa-exclamation"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">2 hours ago</div>
                        Barcelona vs THW Kiel match postponed.
                    </div>
                </a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Profile -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small font-weight-bold">Mohanad Admin</span>
                <img class="img-profile rounded-circle" src="{{ asset('backend/img/undraw_profile.svg') }}">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
                <a class="dropdown-item" href="{{ route('admin.activity-logs.index') }}"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="{{ route('admin.auth.login') }}"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i> Logout</a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
