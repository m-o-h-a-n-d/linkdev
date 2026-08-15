@extends('frontend.layouts.app')

@section('title', (($match->homeTeam->name ?? 'Team A') . ' vs ' . ($match->awayTeam->name ?? 'Team B')) . ' — Handball Hub')

@section('content')
    <section class="section">
        <div class="container" style="max-width: 900px;">
            <!-- Back Button -->
            <div style="margin-bottom: 24px;">
                <a href="{{ route('matches.index') }}"
                    style="color: #ea580c; text-decoration: none; font-weight: 700; font-size: 0.9rem;">
                    &larr; Back to Match Centre
                </a>
            </div>

            @php
                $rawStatus = strtolower($match->status ?? 'scheduled');

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

            <!-- Main Scoreboard Card -->
            <div style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.5); margin-bottom: 30px;">

                <!-- Match Header Meta -->
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 30px; border-bottom: 1px solid #1e293b; padding-bottom: 16px;">
                    <div>
                        <span style="color: #ea580c; font-weight: 700; font-size: 0.9rem;">
                            {{ $match->competition->name ?? 'Competition' }}
                        </span>
                        <span style="color: #64748b; margin: 0 8px;">&middot;</span>
                        <span style="color: #94a3b8; font-size: 0.9rem;">
                            {{ $match->group->name ?? 'Round ' . ($match->round_number ?? '1') }}
                        </span>
                    </div>

                    <span id="detail-status-{{ $match->id }}" class="status-pill {{ $pillClass }}" style="font-size: 0.85rem; padding: 6px 14px; border-radius: 20px;">
                        {{ $statusDisplay }}
                    </span>
                </div>

                <!-- Teams & Score Display -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 32px; text-align: center;">

                    <!-- Home Team -->
                    <div style="flex: 1;">
                        <img src="{{ $match->homeTeam?->logo_url ?? asset('backend/img/undraw_profile.svg') }}" alt="{{ $match->homeTeam->name ?? 'Home' }}" referrerpolicy="no-referrer"
                            style="width: 72px; height: 72px; object-fit: contain; margin: 0 auto 12px auto; display: block; background: rgba(255,255,255,0.05); padding: 6px; border-radius: 12px;"
                            onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                        <h2 style="font-size: 1.3rem; color: #fff; margin: 0 0 6px 0;">
                            {{ $match->homeTeam->name ?? 'Home Team' }}
                        </h2>
                        <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">HOME</span>
                    </div>

                    <!-- Score / VS Center Area -->
                    <div style="padding: 0 20px;">
                        <div id="detail-score-box-{{ $match->id }}">
                            @if(in_array($rawStatus, ['finished', 'live']))
                                <div id="detail-score-{{ $match->id }}" class="match-score-text" style="font-size: 3rem; font-weight: 900; color: #fff; letter-spacing: 2px; line-height: 1;">
                                    <span id="detail-home-score-{{ $match->id }}">{{ $match->home_score }}</span> <span style="color: #ea580c;">:</span> <span id="detail-away-score-{{ $match->id }}">{{ $match->away_score }}</span>
                                </div>
                            @else
                                <div id="detail-score-{{ $match->id }}" style="font-size: 2rem; font-weight: 900; color: #ea580c; background: rgba(234, 88, 12, 0.1); border: 1px solid rgba(234, 88, 12, 0.2); padding: 10px 24px; border-radius: 12px; display: inline-block;">
                                    VS
                                </div>
                            @endif
                        </div>

                        <div style="color: #94a3b8; font-size: 0.85rem; margin-top: 12px; font-weight: 600;">
                            {{ $match->scheduled_at ? $match->scheduled_at->format('D d M Y, H:i') : 'TBD' }}
                        </div>
                    </div>

                    <!-- Away Team -->
                    <div style="flex: 1;">
                        <img src="{{ $match->awayTeam?->logo_url ?? asset('backend/img/undraw_profile.svg') }}" alt="{{ $match->awayTeam->name ?? 'Away' }}" referrerpolicy="no-referrer"
                            style="width: 72px; height: 72px; object-fit: contain; margin: 0 auto 12px auto; display: block; background: rgba(255,255,255,0.05); padding: 6px; border-radius: 12px;"
                            onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                        <h2 style="font-size: 1.3rem; color: #fff; margin: 0 0 6px 0;">
                            {{ $match->awayTeam->name ?? 'Away Team' }}
                        </h2>
                        <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">AWAY</span>
                    </div>

                </div>

                <!-- Match Quick Stats Grid -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; border-top: 1px solid #1e293b; padding-top: 24px;">

                    <div style="background: #070c14; padding: 18px; border-radius: 10px; border: 1px solid #1e293b;">
                        <div style="color: #64748b; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">
                            Round Number
                        </div>
                        <div style="font-size: 1.3rem; color: #fff; font-weight: 800; margin-top: 4px;">
                            Round {{ $match->round_number ?? 1 }}
                        </div>
                    </div>

                    <div style="background: #070c14; padding: 18px; border-radius: 10px; border: 1px solid #1e293b;">
                        <div style="color: #64748b; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">
                            Winner Team
                        </div>
                        <div id="detail-winner-{{ $match->id }}" style="font-size: 1.2rem; color: #ea580c; font-weight: 800; margin-top: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $match->winnerTeam->name ?? ($rawStatus === 'finished' ? 'Draw / None' : 'Pending') }}
                        </div>
                    </div>

                    <div style="background: #070c14; padding: 18px; border-radius: 10px; border: 1px solid #1e293b;">
                        <div style="color: #64748b; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">
                            Start Time
                        </div>
                        <div id="detail-started-{{ $match->id }}" style="font-size: 1.1rem; color: #fff; font-weight: 800; margin-top: 4px;">
                            {{ $match->started_at ? $match->started_at->format('H:i') : 'Not Started' }}
                        </div>
                    </div>

                </div>
            </div>

            <!-- Notes or Extra Details Section -->
            @if(!empty($match->notes))
                <div style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; padding: 30px;">
                    <h3 style="color: #fff; margin-top: 0; margin-bottom: 16px; font-size: 1.2rem; border-bottom: 1px solid #1e293b; padding-bottom: 12px;">
                        Match Notes
                    </h3>
                    <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin: 0;">
                        {{ $match->notes }}
                    </p>
                </div>
            @endif

        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const matchId = {{ $match->id }};

    function updateScore(home, away) {
        var scoreBox = document.getElementById('detail-score-box-' + matchId);
        if (scoreBox) {
            scoreBox.innerHTML = '<div id="detail-score-' + matchId + '" class="match-score-text score-flash" style="font-size: 3rem; font-weight: 900; color: #fff; letter-spacing: 2px; line-height: 1;">' +
                                 '<span id="detail-home-score-' + matchId + '">' + home + '</span> <span style="color: #ea580c;">:</span> <span id="detail-away-score-' + matchId + '">' + away + '</span>' +
                                 '</div>';
        }
    }

    function updateStatus(status) {
        var statusEl = document.getElementById('detail-status-' + matchId);
        if (statusEl) {
            var s = status.toLowerCase();
            if (s === 'live') {
                statusEl.className = 'status-pill pill-live';
                statusEl.innerText = 'LIVE';
            } else if (s === 'finished') {
                statusEl.className = 'status-pill pill-fulltime';
                statusEl.innerText = 'FULL TIME';
            } else if (s === 'postponed') {
                statusEl.className = 'status-pill pill-postponed';
                statusEl.innerText = 'POSTPONED';
            } else {
                statusEl.className = 'status-pill pill-upcoming';
                statusEl.innerText = status.toUpperCase();
            }
        }
    }

    if (window.Echo && typeof window.Echo.channel === 'function') {
        // Listen on specific match channel
        window.Echo.channel('match.' + matchId)
            .listen('.MatchScoreUpdated', function (data) {
                if (data.match_id == matchId) {
                    updateScore(data.home_score, data.away_score);
                    if (data.status) {
                        updateStatus(data.status);
                    }
                }
            })
            .listen('.MatchStartedLive', function (data) {
                var m = data.match || data;
                if (m.id == matchId) {
                    updateStatus('live');
                    updateScore(m.home_score ?? 0, m.away_score ?? 0);
                }
            })
            .listen('.MatchStatusUpdated', function (data) {
                if (data.match_id == matchId) {
                    updateStatus(data.status);
                    if (data.home_score !== undefined && data.away_score !== undefined) {
                        updateScore(data.home_score, data.away_score);
                    }
                    if (data.winner_name) {
                        var winnerEl = document.getElementById('detail-winner-' + matchId);
                        if (winnerEl) {
                            winnerEl.innerText = data.winner_name;
                        }
                    }
                }
            });

        // Also listen on global live-matches channel
        window.Echo.channel('live-matches')
            .listen('.MatchScoreUpdated', function (data) {
                if (data.match_id == matchId) {
                    updateScore(data.home_score, data.away_score);
                }
            })
            .listen('.MatchStartedLive', function (data) {
                var m = data.match || data;
                if (m.id == matchId) {
                    updateStatus('live');
                    updateScore(m.home_score ?? 0, m.away_score ?? 0);
                }
            })
            .listen('.MatchStatusUpdated', function (data) {
                if (data.match_id == matchId) {
                    updateStatus(data.status);
                }
            });
    }
});
</script>
@endpush
