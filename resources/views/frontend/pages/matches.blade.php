@extends('frontend.layouts.app')

@section('title', 'Match Centre — Handball Hub')

@section('content')
<section class="section">
    <div class="container" style="max-width: 1400px; width: 96%; margin: 0 auto;">
        <h1 class="page-title" style="margin-bottom: 32px;">MATCH CENTRE</h1>

        <!-- Tournament Bracket / Waiting Status Component -->
        <div style="margin-bottom: 40px;">
            @include('frontend.partials.bracket', ['competition' => $competition ?? null])
        </div>

        <!-- Filter Tabs Bar -->
        <div class="filter-tabs">
            <button class="filter-tab {{ request('status', 'all') == 'all' ? 'active' : '' }}" data-filter="all" type="button">ALL</button>
            <button class="filter-tab {{ request('status') == 'live' ? 'active' : '' }}" data-filter="live" type="button">LIVE</button>
            <button class="filter-tab {{ in_array(request('status'), ['upcoming', 'scheduled']) ? 'active' : '' }}" data-filter="scheduled" type="button">UPCOMING</button>
            <button class="filter-tab {{ in_array(request('status'), ['results', 'finished']) ? 'active' : '' }}" data-filter="finished" type="button">RESULTS</button>
        </div>

        <!-- Matches Cards List -->
        <div class="matches-cards-list">
            @forelse($matches ?? [] as $match)
                @php
                    $rawStatus = strtolower($match->status);

                    $pillClass = match($rawStatus) {
                        'live' => 'pill-live',
                        'finished' => 'pill-fulltime',
                        'postponed' => 'pill-postponed',
                        'cancelled' => 'pill-cancelled',
                        default => 'pill-upcoming',
                    };

                    $statusDisplay = match($rawStatus) {
                        'finished' => 'FULL TIME',
                        default => strtoupper($rawStatus),
                    };
                @endphp
                <a href="{{ route('matches.show', $match->id) }}" id="viewer-match-{{ $match->id }}" class="match-card-item match-card-link" data-status="{{ $rawStatus }}" style="text-decoration: none;">
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
                            <div class="team-block home" style="display: flex; align-items: center; gap: 10px; justify-content: flex-end; flex: 1;">
                                <span class="team-name home">{{ $match->homeTeam->name ?? 'N/A' }}</span>
                                <img src="{{ $match->homeTeam?->logo_url ?? asset('backend/img/undraw_profile.svg') }}" 
                                     alt="{{ $match->homeTeam?->name }}" 
                                     style="width: 32px; height: 32px; object-fit: contain; border-radius: 6px; background: rgba(255,255,255,0.05); padding: 3px;"
                                     onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                            </div>

                            <div class="score-badge" id="viewer-score-{{ $match->id }}">
                                @if(in_array($rawStatus, ['finished', 'live']))
                                    {{ $match->home_score }} : {{ $match->away_score }}
                                @else
                                    VS
                                @endif
                            </div>

                            <div class="team-block away" style="display: flex; align-items: center; gap: 10px; justify-content: flex-start; flex: 1;">
                                <img src="{{ $match->awayTeam?->logo_url ?? asset('backend/img/undraw_profile.svg') }}" 
                                     alt="{{ $match->awayTeam?->name }}" 
                                     style="width: 32px; height: 32px; object-fit: contain; border-radius: 6px; background: rgba(255,255,255,0.05); padding: 3px;"
                                     onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                                <span class="team-name away">{{ $match->awayTeam->name ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="match-badge-wrap">
                            <span class="status-pill {{ $pillClass }}" id="viewer-status-{{ $match->id }}">
                                {{ $statusDisplay }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
            @endforelse

            <div id="no-matches-message" style="display: none; text-align: center; padding: 60px 20px; background: #0e1626; border: 1px dashed #334155; border-radius: 12px; color: #94a3b8; width: 100%;">
                <div style="font-size: 2.5rem; margin-bottom: 12px;">🤾‍♂️</div>
                <h3 style="color: #ffffff; margin-bottom: 8px;">No Matches Found</h3>
                <p style="font-size: 0.9rem;">There are no matches available matching the selected status filter.</p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.filter-tab');
    const cards = document.querySelectorAll('.match-card-item');
    const noMatchesMsg = document.getElementById('no-matches-message');

    function filterMatches(filter) {
        let visibleCount = 0;

        cards.forEach(card => {
            const status = card.getAttribute('data-status');
            if (filter === 'all') {
                card.style.display = 'block';
                visibleCount++;
            } else if (filter === 'live' && status === 'live') {
                card.style.display = 'block';
                visibleCount++;
            } else if (filter === 'scheduled' && (status === 'scheduled' || status === 'upcoming')) {
                card.style.display = 'block';
                visibleCount++;
            } else if (filter === 'finished' && (status === 'finished' || status === 'results')) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noMatchesMsg) {
            noMatchesMsg.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const filter = this.getAttribute('data-filter');
            filterMatches(filter);
        });
    });

    // Run initial filter based on active tab
    const activeTab = document.querySelector('.filter-tab.active');
    if (activeTab) {
        filterMatches(activeTab.getAttribute('data-filter'));
    }

    // Real-Time Echo Listeners
    if (window.Echo && typeof window.Echo.channel === 'function') {
        window.Echo.channel('live-matches')
            .listen('.MatchScoreUpdated', function (data) {
                var scoreEl = document.getElementById('viewer-score-' + data.match_id);
                if (scoreEl) {
                    scoreEl.innerText = data.home_score + ' : ' + data.away_score;
                    scoreEl.classList.remove('score-flash');
                    void scoreEl.offsetWidth;
                    scoreEl.classList.add('score-flash');
                }
            })
            .listen('.MatchStartedLive', function (data) {
                var match = data.match || data;
                var card = document.getElementById('viewer-match-' + match.id);
                if (card) {
                    card.setAttribute('data-status', 'live');
                    var statusEl = document.getElementById('viewer-status-' + match.id);
                    if (statusEl) {
                        statusEl.className = 'status-pill pill-live';
                        statusEl.innerText = 'LIVE';
                    }
                    var scoreEl = document.getElementById('viewer-score-' + match.id);
                    if (scoreEl) {
                        scoreEl.innerText = (match.home_score ?? 0) + ' : ' + (match.away_score ?? 0);
                        scoreEl.classList.remove('score-flash');
                        void scoreEl.offsetWidth;
                        scoreEl.classList.add('score-flash');
                    }
                    // Re-apply active tab filter so live matches appear immediately if LIVE tab is active
                    var activeTab = document.querySelector('.filter-tab.active');
                    if (activeTab) {
                        filterMatches(activeTab.getAttribute('data-filter'));
                    }
                }
            })
            .listen('.MatchStatusUpdated', function (data) {
                var card = document.getElementById('viewer-match-' + data.match_id);
                if (card) {
                    card.setAttribute('data-status', data.status);
                    var statusEl = document.getElementById('viewer-status-' + data.match_id);
                    if (statusEl) {
                        if (data.status === 'finished') {
                            statusEl.className = 'status-pill pill-fulltime';
                            statusEl.innerText = 'FULL TIME';
                        } else if (data.status === 'live') {
                            statusEl.className = 'status-pill pill-live';
                            statusEl.innerText = 'LIVE';
                        }
                    }
                    var scoreEl = document.getElementById('viewer-score-' + data.match_id);
                    if (scoreEl && data.home_score !== undefined && data.away_score !== undefined) {
                        scoreEl.innerText = data.home_score + ' : ' + data.away_score;
                    }
                    var activeTab = document.querySelector('.filter-tab.active');
                    if (activeTab) {
                        filterMatches(activeTab.getAttribute('data-filter'));
                    }
                }
            });
    }
});
</script>
@endpush
@endsection
