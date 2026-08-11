@extends('frontend.layouts.app')

@section('title', 'Handball Hub — Live Scores, Fixtures & Standings')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <span class="hero-label">Season 2025/26</span>
            <h1>Every throw, every save, every point.</h1>
            <p class="hero-description">
                The public portal for handball competitions &mdash; follow live matches, group standings, and team form as
                the season unfolds.
            </p>
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $competitions->count() ?? 0 }}</div>
                    <div class="stat-label">Competitions</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $teams->count() ?? 0 }}</div>
                    <div class="stat-label">Teams</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $matches->count() ?? 0 }}</div>
                    <div class="stat-label">Matches</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Score Bar -->
    @if ($liveMatches->isNotEmpty())
        @foreach ($liveMatches as $liveMatch)
            <div class="live-bar">
                <div class="container">
                    <a href="{{ url('/matches/' . $liveMatch->id) }}" class="live-bar-inner">

                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="live-badge">
                                <span class="dot"></span> Live
                            </span>

                            <span class="live-bar-group">
                                {{ $liveMatch->group?->name ?? 'Group' }}
                            </span>
                        </div>

                        <div class="live-bar-teams">
                            <span>
                                {{ $liveMatch->homeTeam->name }}
                            </span>

                            <div class="live-bar-score">
                                {{ $liveMatch->home_score }} : {{ $liveMatch->away_score }}
                            </div>

                            <span>
                                {{ $liveMatch->awayTeam->name }}
                            </span>
                        </div>

                        <div class="live-bar-venue">
                            Venue TBA
                        </div>

                    </a>
                </div>
            </div>
        @endforeach
    @endif

    <!-- Competitions Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Competitions</h2>
            </div>
            <div class="competitions-grid">
                @forelse($competitions ?? [] as $competition)
                    <a href="{{ route('competitions.show', $competition->id) }}" class="competition-card">
                        <span class="competition-status status-{{ strtolower($competition->status ?? 'ongoing') }}">
                            {{ ucfirst($competition->status ?? 'Ongoing') }}
                        </span>
                        <h3>{{ $competition->name }}</h3>
                        <p class="competition-meta">{{ $competition->season ?? 'N/A' }}</p>
                        <div class="competition-stats">
                            <div class="competition-stat">
                                <span class="competition-stat-label">Teams</span>
                                <span class="competition-stat-value">{{ $competition->teams()->count() ?? 0 }}</span>
                            </div>
                            <div class="competition-stat">
                                <span class="competition-stat-label">Groups</span>
                                <span class="competition-stat-value">{{ $competition->groups()->count() ?? 0 }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="no-competitions">
                        <div class="no-competitions-icon">🏆</div>
                        <h3>No Competitions Found</h3>
                        <p>There are currently no active competitions available in the system.</p>
                    </div>
                @endforelse

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
                @forelse($upcomingMatches ?? [] as $match)
                    <a href="{{ route('matches.show', $match->id) }}" class="match-card-link">
                        <div class="match-card">
                            <div class="match-meta">
                                <div class="match-date-str">
                                    {{ $match->scheduled_at ? $match->scheduled_at->format('D d M, H:i') : 'TBD' }}
                                </div>
                                <div class="match-group-str">
                                    {{ $match->group->name ?? 'Round ' . $match->round_number }}
                                </div>
                            </div>

                            <div class="match-center">
                                <span class="team-name home">{{ $match->homeTeam->name ?? 'N/A' }}</span>

                                <div class="score-badge">
                                    VS
                                </div>

                                <span class="team-name away">{{ $match->awayTeam->name ?? 'N/A' }}</span>
                            </div>

                            <div class="match-badge-wrap">
                                <span class="status-pill pill-upcoming">
                                    {{ strtoupper($match->status ?? 'upcoming') }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="no-matches"></div>
                    <div class="no-matches-icon">🤾‍♂️</div>
                    <h3>No Matches Found</h3>
                    <p>There are currently no upcoming matches available in the system.</p>
            </div>
            @endforelse
        </div>
        </div>
    </section>
@endsection
