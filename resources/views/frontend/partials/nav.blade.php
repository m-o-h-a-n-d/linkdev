<nav class="navbar">
    <div class="container navbar-container">
        <a href="{{ url('/') }}" class="navbar-brand">
            <div class="logo-circle">H</div>
            <span>HANDBALL HUB</span>
        </a>
        <div class="navbar-nav">
            <a href="{{ url('/competitions') }}" class="{{ request()->is('competitions*') ? 'active' : '' }}">Competitions</a>
            <a href="{{ url('/matches') }}" class="{{ request()->is('matches*') ? 'active' : '' }}">Matches</a>
            <a href="{{ url('/teams') }}" class="{{ request()->is('teams*') ? 'active' : '' }}">Teams</a>
            <a href="{{ route('account.index') }}" class="btn-nav-account {{ request()->routeIs('account.*') ? 'active' : '' }}">ACCOUNT</a>
        </div>
        <button class="mobile-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>
