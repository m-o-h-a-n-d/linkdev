@extends('frontend.layouts.app')

@section('title', 'Handball Hub — Live Scores, Fixtures & Standings')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <span class="hero-label">{{ $siteSettings->session ?? 'Season 2025/26' }}</span>
            <h1>{{ $siteSettings->header ?? 'Every throw, every save, every point.' }}</h1>
            <p class="hero-description">
                {{ $siteSettings->description ?? 'The public portal for handball competitions — follow live matches, group standings, and team form as the season unfolds.' }}
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
    <div id="frontend-live-bars-wrapper">
        @if ($liveMatches->isNotEmpty())
            @foreach ($liveMatches as $liveMatch)
                <div class="live-bar" id="live-bar-{{ $liveMatch->id }}">
                    <div class="container">
                        <a href="{{ url('/matches/' . $liveMatch->id) }}" class="live-bar-inner">

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span class="live-badge" id="live-bar-badge-{{ $liveMatch->id }}">
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

                                <div class="live-bar-score" id="live-bar-score-{{ $liveMatch->id }}">
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
    </div>

    <!-- Competitions Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Competitions</h2>
            </div>
            <div class="competitions-grid">
                @forelse($competitions ?? [] as $competition)
                    <a href="{{ route('competitions.show', ['slug' => $competition->slug]) }}" class="competition-card">
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
                    @php
                        $rawMatchStatus = strtolower($match->status ?? 'upcoming');
                        $pillClass = match($rawMatchStatus) {
                            'live' => 'pill-live',
                            'finished' => 'pill-fulltime',
                            'postponed' => 'pill-postponed',
                            'cancelled' => 'pill-cancelled',
                            default => 'pill-upcoming',
                        };
                    @endphp
                    <a href="{{ route('matches.show', $match->id) }}" class="match-card-link" id="home-match-link-{{ $match->id }}">
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

                                <div class="score-badge" id="home-match-score-{{ $match->id }}">
                                    @if(in_array($rawMatchStatus, ['live', 'finished']))
                                        {{ $match->home_score }} : {{ $match->away_score }}
                                    @else
                                        VS
                                    @endif
                                </div>

                                <span class="team-name away">{{ $match->awayTeam->name ?? 'N/A' }}</span>
                            </div>

                            <div class="match-badge-wrap">
                                <span class="status-pill {{ $pillClass }}" id="home-match-status-{{ $match->id }}">
                                    {{ strtoupper($match->status ?? 'upcoming') }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="no-matches">
                        <div class="no-matches-icon">🤾‍♂️</div>
                        <h3>No Matches Found</h3>
                        <p>There are currently no upcoming matches available in the system.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.Echo && typeof window.Echo.channel === 'function') {
        window.Echo.channel('live-matches')
            .listen('.MatchScoreUpdated', function (data) {
                // Update live score bar if visible
                var liveBarScore = document.getElementById('live-bar-score-' + data.match_id);
                if (liveBarScore) {
                    liveBarScore.innerText = data.home_score + ' : ' + data.away_score;
                    liveBarScore.classList.remove('score-flash');
                    void liveBarScore.offsetWidth;
                    liveBarScore.classList.add('score-flash');
                }

                // Update next up cards if present
                var nextUpScore = document.getElementById('home-match-score-' + data.match_id);
                if (nextUpScore) {
                    nextUpScore.innerText = data.home_score + ' : ' + data.away_score;
                    nextUpScore.classList.remove('score-flash');
                    void nextUpScore.offsetWidth;
                    nextUpScore.classList.add('score-flash');
                }

                var nextUpStatus = document.getElementById('home-match-status-' + data.match_id);
                if (nextUpStatus && data.status) {
                    nextUpStatus.innerText = data.status.toUpperCase();
                    if (data.status === 'live') {
                        nextUpStatus.className = 'status-pill pill-live';
                    }
                }
            })
            .listen('.MatchStartedLive', function (data) {
                var match = data.match || data;
                var wrapper = document.getElementById('frontend-live-bars-wrapper');
                var existingBar = document.getElementById('live-bar-' + match.id);

                // Dynamically inject live bar if not present on page
                if (!existingBar && wrapper) {
                    var homeName = match.home_team_name || (match.home_team ? match.home_team.name : 'Home Team');
                    var awayName = match.away_team_name || (match.away_team ? match.away_team.name : 'Away Team');
                    var groupName = match.group_name || (match.group ? match.group.name : 'Match Group');
                    var homeScore = match.home_score ?? 0;
                    var awayScore = match.away_score ?? 0;

                    var barHtml = '<div class="live-bar" id="live-bar-' + match.id + '" style="animation: scoreGoalPulse 0.8s ease;">' +
                        '<div class="container">' +
                            '<a href="/matches/' + match.id + '" class="live-bar-inner">' +
                                '<div style="display: flex; align-items: center; gap: 10px;">' +
                                    '<span class="live-badge" id="live-bar-badge-' + match.id + '">' +
                                        '<span class="dot"></span> Live' +
                                    '</span>' +
                                    '<span class="live-bar-group">' + groupName + '</span>' +
                                '</div>' +
                                '<div class="live-bar-teams">' +
                                    '<span>' + homeName + '</span>' +
                                    '<div class="live-bar-score score-flash" id="live-bar-score-' + match.id + '">' +
                                        homeScore + ' : ' + awayScore +
                                    '</div>' +
                                    '<span>' + awayName + '</span>' +
                                '</div>' +
                                '<div class="live-bar-venue">Venue TBA</div>' +
                            '</a>' +
                        '</div>' +
                    '</div>';

                    wrapper.insertAdjacentHTML('afterbegin', barHtml);
                }

                // Update Next Up card if present
                var nextUpStatus = document.getElementById('home-match-status-' + match.id);
                if (nextUpStatus) {
                    nextUpStatus.className = 'status-pill pill-live';
                    nextUpStatus.innerText = 'LIVE';
                }
                var nextUpScore = document.getElementById('home-match-score-' + match.id);
                if (nextUpScore) {
                    nextUpScore.innerText = (match.home_score ?? 0) + ' : ' + (match.away_score ?? 0);
                    nextUpScore.classList.remove('score-flash');
                    void nextUpScore.offsetWidth;
                    nextUpScore.classList.add('score-flash');
                }
            })
            .listen('.MatchStatusUpdated', function (data) {
                var nextUpStatus = document.getElementById('home-match-status-' + data.match_id);
                if (nextUpStatus && data.status === 'finished') {
                    nextUpStatus.className = 'status-pill pill-fulltime';
                    nextUpStatus.innerText = 'FULL TIME';
                }
                var liveBarBadge = document.getElementById('live-bar-badge-' + data.match_id);
                if (liveBarBadge && data.status === 'finished') {
                    liveBarBadge.innerHTML = 'Full Time';
                    liveBarBadge.style.borderColor = '#10b981';
                    liveBarBadge.style.color = '#10b981';
                }
            });
    }
});
</script>
@endpush
