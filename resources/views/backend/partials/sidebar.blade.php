<!-- Sidebar Navigation -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand (Matching Login Page) -->
    <a class="sidebar-brand d-flex align-items-center" href="{{ route('admin.dashboard.index') }}">
        <div class="login-brand-icon">
            <i class="fas fa-volleyball-ball"></i>
        </div>
        <div class="login-brand-text">Admina</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading: COMPETITIONS -->
    <div class="sidebar-heading">
        COMPETITIONS
    </div>

    <li class="nav-item {{ request()->routeIs('admin.competitions*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.competitions.index') }}">
            <i class="fas fa-fw fa-trophy"></i>
            <span>Competitions</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.groups*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.groups.index') }}">
            <i class="fas fa-fw fa-layer-group"></i>
            <span>Groups</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.matches.index') || request()->routeIs('admin.matches.create') || request()->routeIs('admin.matches.edit') || request()->routeIs('admin.matches.show') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.matches.index') }}">
            <i class="fas fa-fw fa-running"></i>
            <span>Matches</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.matches.live-center') ? 'active' : '' }}">
        <a class="nav-link text-danger font-weight-bold" href="{{ route('admin.matches.live-center') }}">
            <i class="fas fa-fw fa-broadcast-tower text-danger animate-pulse"></i>
            <span>Live Match Center</span>
            <span class="badge badge-danger badge-pill ml-1 animate-pulse">LIVE</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.standings*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.standings.index') }}">
            <i class="fas fa-fw fa-list-ol"></i>
            <span>Standings</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading: TEAMS & STATS -->
    <div class="sidebar-heading">
        TEAMS & STATS
    </div>

    <li class="nav-item {{ request()->routeIs('admin.teams*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.teams.index') }}">
            <i class="fas fa-fw fa-shield-alt"></i>
            <span>Teams</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.statistics*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.statistics.index') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Team Statistics</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading: USERS & SYSTEM -->
    <div class="sidebar-heading">
        USERS & SYSTEM
    </div>

    <li class="nav-item {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.roles.index') }}">
            <i class="fas fa-fw fa-user-shield"></i>
            <span>Roles</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.staff*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.staff.index') }}">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Staff Management</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.activity-logs*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.activity-logs.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Activity Logs</span>
        </a>
    </li>


</ul>
<!-- End of Sidebar -->
