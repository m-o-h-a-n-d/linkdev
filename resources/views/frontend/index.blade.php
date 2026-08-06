@extends('frontend.layouts.app')

@section('title', 'Handball Hub — Live Scores, Fixtures & Standings')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <span class="hero-label">Season 2025/26</span>
        <h1>Every throw, every save, every point.</h1>
        <p class="hero-description">
            The public portal for handball competitions &mdash; follow live matches, group standings, and team form as the season unfolds.
        </p>
        <div class="stats">
            <div class="stat-item">
                <div class="stat-number">3</div>
                <div class="stat-label">Competitions</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">8</div>
                <div class="stat-label">Teams</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">12</div>
                <div class="stat-label">Matches</div>
            </div>
        </div>
    </div>
</section>

<!-- Live Score Bar -->
<div class="live-bar">
    <div class="container">
        <a href="{{ url('/matches') }}" class="live-bar-inner">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="live-badge"><span class="dot"></span> Live</span>
                <span class="live-bar-group">Group B</span>
            </div>
            <div class="live-bar-teams">
                <span>HELIOPOLIS</span>
                <div class="live-bar-score">29 : 23</div>
                <span>MANSOURA HC</span>
            </div>
            <div class="live-bar-venue">Mansoura Sports Hall</div>
        </a>
    </div>
</div>

<!-- Competitions Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Competitions</h2>
        </div>
        <div class="competitions-grid">

            <!-- Ongoing Competition -->
            <a href="{{ url('/competitions') }}" class="competition-card">
                <span class="competition-status status-ongoing">ONGOING</span>
                <h3>NATIONAL HANDBALL LEAGUE</h3>
                <p class="competition-meta">2025/26 &middot; Cairo Indoor Arena</p>
                <div class="competition-stats">
                    <div class="competition-stat">
                        <span class="competition-stat-label">Teams</span>
                        <span class="competition-stat-value">8</span>
                    </div>
                    <div class="competition-stat">
                        <span class="competition-stat-label">Groups</span>
                        <span class="competition-stat-value">2</span>
                    </div>
                </div>
            </a>

            <!-- Upcoming Competition -->
            <a href="{{ url('/competitions') }}" class="competition-card">
                <span class="competition-status status-upcoming">UPCOMING</span>
                <h3>DELTA CHAMPIONSHIP CUP</h3>
                <p class="competition-meta">2026 &middot; Mansoura Sports Hall</p>
                <div class="competition-stats">
                    <div class="competition-stat">
                        <span class="competition-stat-label">Teams</span>
                        <span class="competition-stat-value">4</span>
                    </div>
                    <div class="competition-stat">
                        <span class="competition-stat-label">Groups</span>
                        <span class="competition-stat-value">1</span>
                    </div>
                </div>
            </a>

            <!-- Finished Competition -->
            <a href="{{ url('/competitions') }}" class="competition-card">
                <span class="competition-status status-finished">FINISHED</span>
                <h3>WINTER SHIELD</h3>
                <p class="competition-meta">2025 &middot; Alexandria Dome</p>
                <div class="competition-stats">
                    <div class="competition-stat">
                        <span class="competition-stat-label">Teams</span>
                        <span class="competition-stat-value">4</span>
                    </div>
                    <div class="competition-stat">
                        <span class="competition-stat-label">Groups</span>
                        <span class="competition-stat-value">1</span>
                    </div>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- Next Up Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">NEXT UP</h2>
            <a href="{{ url('/matches') }}" class="section-link">ALL MATCHES</a>
        </div>
        <div class="matches-container">

            <div class="match-row">
                <div class="match-date">Tue 28 Jul, 17:00</div>
                <div class="match-teams">
                    <span class="match-team home">PORT SAID HC</span>
                    <span class="vs">VS</span>
                    <span class="match-team away">ASWAN HC</span>
                </div>
                <div class="match-venue">Cairo Indoor Arena</div>
            </div>

            <div class="match-row">
                <div class="match-date">Tue 28 Jul, 18:00</div>
                <div class="match-teams">
                    <span class="match-team home">PORT SAID HC</span>
                    <span class="vs">VS</span>
                    <span class="match-team away">MANSOURA HC</span>
                </div>
                <div class="match-venue">Alexandria Dome</div>
            </div>

            <div class="match-row">
                <div class="match-date">Tue 28 Jul, 19:00</div>
                <div class="match-teams">
                    <span class="match-team home">ASWAN HC</span>
                    <span class="vs">VS</span>
                    <span class="match-team away">MANSOURA HC</span>
                </div>
                <div class="match-venue">Mansoura Sports Hall</div>
            </div>

        </div>
    </div>
</section>
@endsection
