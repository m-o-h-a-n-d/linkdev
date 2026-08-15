<!-- Sidebar Navigation -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand (Matching Login Page) -->
    <a class="sidebar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
        <div class="login-brand-icon d-flex align-items-center justify-content-center" style="overflow: hidden; padding: 2px;">
            @if(isset($siteSettings) && $siteSettings->icon)
                <img src="{{ $siteSettings->icon_url }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
            @else
                <i class="fas fa-volleyball-ball"></i>
            @endif
        </div>
        <div class="login-brand-text">Admina</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @can('dashboard.access')
    <li class="nav-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    @endcan

    <!-- Divider & Heading: COMPETITIONS -->
    @canany(['competitions.view', 'groups.view', 'matches.view', 'matches.live-center', 'standings.view'])
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        COMPETITIONS
    </div>

    @can('competitions.view')
    <li class="nav-item {{ request()->routeIs('admin.competitions*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.competitions.index') }}">
            <i class="fas fa-fw fa-trophy"></i>
            <span>Competitions</span>
        </a>
    </li>
    @endcan

    @can('groups.view')
    <li class="nav-item {{ request()->routeIs('admin.groups*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.groups.index') }}">
            <i class="fas fa-fw fa-layer-group"></i>
            <span>Groups</span>
        </a>
    </li>
    @endcan

    @can('matches.view')
    <li
        class="nav-item {{ request()->routeIs('admin.matches.index') || request()->routeIs('admin.matches.create') || request()->routeIs('admin.matches.edit') || request()->routeIs('admin.matches.show') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.matches.index') }}">
            <i class="fas fa-fw fa-running"></i>
            <span>Matches</span>
        </a>
    </li>
    @endcan

    @can('matches.live-center')
    <li class="nav-item {{ request()->routeIs('admin.matches.live-center') ? 'active' : '' }}">
        <a class="nav-link text-danger font-weight-bold" href="{{ route('admin.matches.live-center') }}">
            <i class="fas fa-fw fa-broadcast-tower text-danger animate-pulse"></i>
            <span>Live Match Center</span>
            <span class="badge badge-danger badge-pill ml-1 animate-pulse">LIVE</span>
        </a>
    </li>
    @endcan

    @can('standings.view')
    <li class="nav-item {{ request()->routeIs('admin.standings*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.standings.index') }}">
            <i class="fas fa-fw fa-list-ol"></i>
            <span>Standings</span>
        </a>
    </li>
    @endcan
    @endcanany

    <!-- Divider & Heading: TEAMS & STATS -->
    @canany(['teams.view', 'statistics.view'])
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        TEAMS & STATS
    </div>

    @can('teams.view')
    <li class="nav-item {{ request()->routeIs('admin.teams*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.teams.index') }}">
            <i class="fas fa-fw fa-shield-alt"></i>
            <span>Teams</span>
        </a>
    </li>
    @endcan

    @can('statistics.view')
    <li class="nav-item {{ request()->routeIs('admin.statistics*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.statistics.index') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Team Statistics</span>
        </a>
    </li>
    @endcan
    @endcanany

    <!-- Divider & Heading: USERS & SYSTEM -->
    @canany(['users.view', 'roles.view', 'admins.view', 'activity-logs.view', 'settings.view'])
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        USERS & SYSTEM
    </div>

    @can('users.view')
    <li class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>
    @endcan

    @can('roles.view')
    <li class="nav-item {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.roles.index') }}">
            <i class="fas fa-fw fa-user-shield"></i>
            <span>Roles</span>
        </a>
    </li>
    @endcan

    @can('admins.view')
    <li class="nav-item {{ request()->routeIs('admin.admins*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.admins.index') }}">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Admin Management</span>
        </a>
    </li>
    @endcan

    @can('activity-logs.view')
    <li class="nav-item {{ request()->routeIs('admin.activity-logs*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.activity-logs.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Activity Logs</span>
        </a>
    </li>
    @endcan

    @can('settings.view')
    <li class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.settings.edit') }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>System Settings</span>
        </a>
    </li>
    @endcan
    @endcanany


</ul>
<!-- End of Sidebar -->
