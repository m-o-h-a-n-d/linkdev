<nav class="navbar">
    <div class="container navbar-container">
        <a href="{{ url('/') }}" class="navbar-brand">
            @if(isset($siteSettings) && $siteSettings->icon)
                <img src="{{ $siteSettings->icon_url }}" alt="Logo" style="height: 38px; width: 38px; object-fit: cover; border-radius: 8px;">
            @else
                <div class="logo-circle">H</div>
            @endif
            <span>HANDBALL HUB</span>
        </a>
        <div class="navbar-nav">
            <a href="{{ url('/competitions') }}" class="{{ request()->is('competitions*') ? 'active' : '' }}">Competitions</a>
            <a href="{{ url('/matches') }}" class="{{ request()->is('matches*') ? 'active' : '' }}">Matches</a>
            <a href="{{ url('/teams') }}" class="{{ request()->is('teams*') ? 'active' : '' }}">Teams</a>
            @auth
                @can('dashboard.access')
                    <a href="{{ route('admin.dashboard') }}" style="color: #ea580c; font-weight: 700;">ADMIN PANEL</a>
                @endcan
                <a href="{{ route('account.index') }}" class="btn-nav-account {{ request()->routeIs('account.*') ? 'active' : '' }}">ACCOUNT</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav-signin {{ request()->routeIs('login') ? 'active' : '' }}">SIGN IN</a>
            @endauth
        </div>
        <button class="mobile-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>
