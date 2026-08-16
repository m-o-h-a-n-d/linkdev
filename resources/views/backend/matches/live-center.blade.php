@extends('backend.layouts.app')

@section('title', 'Live Score Engine | Handball System')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-broadcast-tower text-danger mr-2"></i>Live Score Engine & Control Center
        </h1>
        <div class="d-flex align-items-center">
            <span class="badge badge-success px-3 py-2 mr-3 font-weight-bold shadow-sm d-flex align-items-center">
                <i class="fas fa-bolt text-warning mr-1 animate-pulse"></i> Real-Time Connected
            </span>
            <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to Matches
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row" id="liveMatchesRow">
        @forelse($liveMatches as $match)
            <div class="col-lg-6 mb-4" id="match-card-{{ $match->id }}" data-match-id="{{ $match->id }}" data-is-knockout="{{ $match->group_id === null ? '1' : '0' }}">
                <div class="card border-left-{{ $match->status === 'live' ? 'danger' : 'primary' }} shadow h-100 py-2 match-card-box">
                    <div class="card-body">
                        <!-- Match Meta -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge badge-dark font-weight-bold match-comp-name">
                                {{ $match->competition->name ?? 'Handball Competition' }}
                            </span>
                            <div id="match-status-badge-{{ $match->id }}">
                                @if ($match->status === 'live')
                                    <span class="badge badge-danger text-uppercase px-3 py-1 font-weight-bold animate-pulse">
                                        <i class="fas fa-circle mr-1" style="font-size: 8px;"></i> LIVE
                                    </span>
                                @elseif($match->status === 'finished')
                                    <span class="badge badge-secondary text-uppercase px-3 py-1 font-weight-bold">
                                        FINISHED
                                    </span>
                                @else
                                    <span class="badge badge-primary text-uppercase px-3 py-1 font-weight-bold">
                                        SCHEDULED
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Teams & Scores -->
                        <div class="row align-items-center text-center my-4">
                            <div class="col-5">
                                <div class="mb-2">
                                    <img src="{{ $match->homeTeam?->logo_url ?? asset('backend/img/undraw_profile.svg') }}" 
                                         alt="{{ $match->homeTeam?->name }}" 
                                         style="width: 48px; height: 48px; object-fit: contain; border-radius: 8px; background: rgba(255,255,255,0.06); padding: 4px; border: 1px solid rgba(255,255,255,0.1);"
                                         onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                                </div>
                                <h5 class="font-weight-bold text-white mb-1 match-home-name" style="font-size: 1.15rem; letter-spacing: 0.3px;">
                                    {{ $match->homeTeam->name ?? 'Home Team' }}
                                </h5>
                                <span class="badge badge-primary px-2 py-1" style="font-size: 0.72rem; font-weight: 800;">HOME</span>
                                <div class="display-3 font-weight-extrabold text-primary mt-2 score-display" id="home-score-{{ $match->id }}">
                                    {{ $match->home_score }}
                                </div>
                            </div>

                            <div class="col-2 text-center">
                                <div class="h4 font-weight-bold text-gray-400">VS</div>
                                <div class="small text-muted font-weight-bold mt-2 match-round-name">
                                    {{ $match->group->name ?? 'Round ' . $match->round_number }}
                                </div>
                                <div id="match-timer-container-{{ $match->id }}">
                                    @if ($match->status === 'live')
                                        <div class="badge badge-dark text-warning font-weight-bold mt-2 px-2 py-1 match-live-timer"
                                            style="font-size: 0.9rem;"
                                            id="timer-{{ $match->id }}"
                                            data-started="{{ $match->started_at ? $match->started_at->toIso8601String() : now()->toIso8601String() }}">
                                            {{ $match->formatted_timer }}
                                        </div>
                                    @elseif($match->status === 'finished')
                                        <div class="badge badge-secondary font-weight-bold mt-2 px-2 py-1" style="font-size: 0.85rem;" id="timer-{{ $match->id }}">
                                            FULL TIME
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-5">
                                <div class="mb-2">
                                    <img src="{{ $match->awayTeam?->logo_url ?? asset('backend/img/undraw_profile.svg') }}" 
                                         alt="{{ $match->awayTeam?->name }}" 
                                         style="width: 48px; height: 48px; object-fit: contain; border-radius: 8px; background: rgba(255,255,255,0.06); padding: 4px; border: 1px solid rgba(255,255,255,0.1);"
                                         onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                                </div>
                                <h5 class="font-weight-bold text-white mb-1 match-away-name" style="font-size: 1.15rem; letter-spacing: 0.3px;">
                                    {{ $match->awayTeam->name ?? 'Away Team' }}
                                </h5>
                                <span class="badge badge-danger px-2 py-1" style="font-size: 0.72rem; font-weight: 800;">AWAY</span>
                                <div class="display-3 font-weight-extrabold text-danger mt-2 score-display" id="away-score-{{ $match->id }}">
                                    {{ $match->away_score }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Control Buttons -->
                        <div class="border-top pt-3" id="match-actions-{{ $match->id }}">
                            @can('matches.live-center')
                                @if ($match->status === 'scheduled')
                                    <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" class="ajax-match-action">
                                        @csrf
                                        <input type="hidden" name="action" value="start_live">
                                        <button type="submit" class="btn btn-success btn-block font-weight-bold shadow-sm">
                                            <i class="fas fa-play mr-1"></i> Start Match Now (Go LIVE)
                                        </button>
                                    </form>
                                @elseif($match->status === 'live')
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="btn-group w-100" role="group">
                                                <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" class="w-50 ajax-match-action">
                                                    @csrf
                                                    <input type="hidden" name="action" value="decrement_home">
                                                    <button type="submit" class="btn btn-outline-danger btn-block font-weight-bold">- 1</button>
                                                </form>
                                                <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" class="w-50 ajax-match-action">
                                                    @csrf
                                                    <input type="hidden" name="action" value="increment_home">
                                                    <button type="submit" class="btn btn-primary btn-block font-weight-bold">+ Goal</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="btn-group w-100" role="group">
                                                <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" class="w-50 ajax-match-action">
                                                    @csrf
                                                    <input type="hidden" name="action" value="decrement_away">
                                                    <button type="submit" class="btn btn-outline-danger btn-block font-weight-bold">- 1</button>
                                                </form>
                                                <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" class="w-50 ajax-match-action">
                                                    @csrf
                                                    <input type="hidden" name="action" value="increment_away">
                                                    <button type="submit" class="btn btn-danger btn-block font-weight-bold">+ Goal</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" class="ajax-match-action"
                                        onsubmit="return confirm('Finish this match and recalculate standings?');">
                                        @csrf
                                        <input type="hidden" name="action" value="finish_match">
                                        <button type="submit" class="btn btn-dark btn-block font-weight-bold shadow-sm">
                                            <i class="fas fa-flag-checkered mr-1"></i> End Match & Recalculate Standings
                                        </button>
                                    </form>
                                @else
                                    <div class="text-center text-muted font-weight-bold py-2">
                                        <i class="fas fa-check-circle text-success mr-1"></i> Match Finished
                                    </div>
                                @endif
                            @else
                                <div class="text-center text-muted small py-2">
                                    <i class="fas fa-lock mr-1"></i> View Only (No Live Score Permissions)
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12" id="noMatchesPlaceholder">
                <div class="card shadow p-5 text-center text-muted">
                    <i class="fas fa-broadcast-tower fa-3x mb-3 text-gray-400"></i>
                    <h4 class="font-weight-bold">No Active or Scheduled Matches</h4>
                    <p>Schedule new matches or generate group fixtures to use the Live Engine.</p>
                    <div>
                        @can('matches.create')
                        <a href="{{ route('admin.matches.create') }}" class="btn btn-primary btn-sm">Schedule Match Now</a>
                        @endcan
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Hidden dynamic template for live match card insertion -->
    <template id="matchCardTemplate">
        <div class="col-lg-6 mb-4" id="match-card-__ID__" data-match-id="__ID__" style="animation: fadeInUp 0.5s ease-out;">
            <div class="card border-left-danger shadow h-100 py-2 match-card-box">
                <div class="card-body">
                    <!-- Match Meta -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge badge-dark font-weight-bold match-comp-name">__COMPETITION__</span>
                        <div id="match-status-badge-__ID__">
                            <span class="badge badge-danger text-uppercase px-3 py-1 font-weight-bold animate-pulse">
                                <i class="fas fa-circle mr-1" style="font-size: 8px;"></i> LIVE
                            </span>
                        </div>
                    </div>

                    <!-- Teams & Scores -->
                    <div class="row align-items-center text-center my-4">
                        <div class="col-5">
                            <h5 class="font-weight-bold text-gray-900 mb-1 match-home-name">__HOME_TEAM__</h5>
                            <span class="badge badge-secondary">HOME</span>
                            <div class="display-3 font-weight-extrabold text-primary mt-2 score-display" id="home-score-__ID__">__HOME_SCORE__</div>
                        </div>

                        <div class="col-2 text-center">
                            <div class="h4 font-weight-bold text-gray-400">VS</div>
                            <div class="small text-muted font-weight-bold mt-2 match-round-name">__GROUP_NAME__</div>
                            <div id="match-timer-container-__ID__">
                                <div class="badge badge-dark text-warning font-weight-bold mt-2 px-2 py-1 match-live-timer"
                                    style="font-size: 0.9rem;"
                                    id="timer-__ID__"
                                    data-started="__STARTED_AT__">
                                    __TIMER__
                                </div>
                            </div>
                        </div>

                        <div class="col-5">
                            <h5 class="font-weight-bold text-gray-900 mb-1 match-away-name">__AWAY_TEAM__</h5>
                            <span class="badge badge-secondary">AWAY</span>
                            <div class="display-3 font-weight-extrabold text-danger mt-2 score-display" id="away-score-__ID__">__AWAY_SCORE__</div>
                        </div>
                    </div>

                    <!-- Action Control Buttons -->
                    <div class="border-top pt-3" id="match-actions-__ID__">
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="btn-group w-100" role="group">
                                    <form action="__UPDATE_URL__" method="POST" class="w-50 ajax-match-action">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="action" value="decrement_home">
                                        <button type="submit" class="btn btn-outline-danger btn-block font-weight-bold">- 1</button>
                                    </form>
                                    <form action="__UPDATE_URL__" method="POST" class="w-50 ajax-match-action">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="action" value="increment_home">
                                        <button type="submit" class="btn btn-primary btn-block font-weight-bold">+ Goal</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="btn-group w-100" role="group">
                                    <form action="__UPDATE_URL__" method="POST" class="w-50 ajax-match-action">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="action" value="decrement_away">
                                        <button type="submit" class="btn btn-outline-danger btn-block font-weight-bold">- 1</button>
                                    </form>
                                    <form action="__UPDATE_URL__" method="POST" class="w-50 ajax-match-action">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="action" value="increment_away">
                                        <button type="submit" class="btn btn-danger btn-block font-weight-bold">+ Goal</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <form action="__UPDATE_URL__" method="POST" class="ajax-match-action"
                            onsubmit="return confirm('Finish this match and recalculate standings?');">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="action" value="finish_match">
                            <button type="submit" class="btn btn-dark btn-block font-weight-bold shadow-sm">
                                <i class="fas fa-flag-checkered mr-1"></i> End Match & Recalculate Standings
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ------------------------------------------------------------------------
    // Helper: Trigger Flash Score Animation
    // ------------------------------------------------------------------------
    function flashScore(el) {
        if (!el) return;
        el.classList.remove('score-flash');
        void el.offsetWidth;
        el.classList.add('score-flash');
    }

    // ------------------------------------------------------------------------
    // 1. AJAX Handler for Match Action Buttons (Zero-Refresh)
    // ------------------------------------------------------------------------
    document.addEventListener('submit', function (e) {
        var form = e.target.closest('.ajax-match-action');
        if (!form) return;

        e.preventDefault();

        var submitBtn = form.querySelector('button[type="submit"]');
        var originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
        var formData = new FormData(form);
        var url = form.getAttribute('action');
        var action = formData.get('action');
        var card = form.closest('[data-match-id]');
        var isKnockout = card && card.getAttribute('data-is-knockout') === '1';

        if (action === 'finish_match' && isKnockout) {
            var matchId = card.getAttribute('data-match-id');
            var homeScore = parseInt(document.getElementById('home-score-' + matchId)?.innerText || '0');
            var awayScore = parseInt(document.getElementById('away-score-' + matchId)?.innerText || '0');

            if (homeScore === awayScore) {
                alert('⚠️ مباريات الأدوار الإقصائية (خروج المغلوب) لا يمكن أن تنتهي بالتعادل (' + homeScore + ' - ' + awayScore + ')!\n\nيرجى تسجيل هدف الحسم / ركلات الترجيح لأحد الفريقين قبل إنهاء المباراة لحسم التأهل.');
                return;
            }
        }

        if (!url) {
            console.error('Form action URL missing');
            return;
        }

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.7';
        }

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.innerHTML = originalBtnHtml;
            }

            if (data.success === false) {
                alert('⚠️ ' + (data.message || 'حدث خطأ أثناء حفظ المباراة.'));
                return;
            }

            if (data.success && data.match) {
                var m = data.match;
                var homeScoreEl = document.getElementById('home-score-' + m.id);
                var awayScoreEl = document.getElementById('away-score-' + m.id);

                if (homeScoreEl && parseInt(homeScoreEl.innerText) !== m.home_score) {
                    homeScoreEl.innerText = m.home_score;
                    flashScore(homeScoreEl);
                }
                if (awayScoreEl && parseInt(awayScoreEl.innerText) !== m.away_score) {
                    awayScoreEl.innerText = m.away_score;
                    flashScore(awayScoreEl);
                }

                // 1. If match status changed to LIVE (Instant Zero-Refresh Switch)
                if (m.status === 'live') {
                    var statusBadge = document.getElementById('match-status-badge-' + m.id);
                    if (statusBadge) {
                        statusBadge.innerHTML = '<span class="badge badge-danger text-uppercase px-3 py-1 font-weight-bold animate-pulse"><i class="fas fa-circle mr-1" style="font-size: 8px;"></i> LIVE</span>';
                    }

                    var timerContainer = document.getElementById('match-timer-container-' + m.id);
                    if (timerContainer) {
                        timerContainer.innerHTML = '<div class="badge badge-dark text-warning font-weight-bold mt-2 px-2 py-1 match-live-timer" style="font-size: 0.9rem;" id="timer-' + m.id + '" data-started="' + new Date().toISOString() + '">' + (m.formatted_timer || '00:00') + '</div>';
                    }

                    var cardBox = document.getElementById('match-card-' + m.id);
                    if (cardBox) {
                        var cardInner = cardBox.querySelector('.card');
                        if (cardInner) {
                            cardInner.classList.remove('border-left-primary');
                            cardInner.classList.add('border-left-danger');
                        }
                    }

                    var actionsContainer = document.getElementById('match-actions-' + m.id);
                    if (actionsContainer) {
                        actionsContainer.innerHTML = 
                            '<div class="row mb-3">' +
                                '<div class="col-6">' +
                                    '<div class="btn-group w-100" role="group">' +
                                        '<form action="' + url + '" method="POST" class="w-50 ajax-match-action">' +
                                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                            '<input type="hidden" name="action" value="decrement_home">' +
                                            '<button type="submit" class="btn btn-outline-danger btn-block font-weight-bold">- 1</button>' +
                                        '</form>' +
                                        '<form action="' + url + '" method="POST" class="w-50 ajax-match-action">' +
                                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                            '<input type="hidden" name="action" value="increment_home">' +
                                            '<button type="submit" class="btn btn-primary btn-block font-weight-bold">+ Goal</button>' +
                                        '</form>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                    '<div class="btn-group w-100" role="group">' +
                                        '<form action="' + url + '" method="POST" class="w-50 ajax-match-action">' +
                                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                            '<input type="hidden" name="action" value="decrement_away">' +
                                            '<button type="submit" class="btn btn-outline-danger btn-block font-weight-bold">- 1</button>' +
                                        '</form>' +
                                        '<form action="' + url + '" method="POST" class="w-50 ajax-match-action">' +
                                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                            '<input type="hidden" name="action" value="increment_away">' +
                                            '<button type="submit" class="btn btn-danger btn-block font-weight-bold">+ Goal</button>' +
                                        '</form>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<form action="' + url + '" method="POST" class="ajax-match-action" onsubmit="return confirm(\'Finish this match and recalculate standings?\');">' +
                                '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                '<input type="hidden" name="action" value="finish_match">' +
                                '<button type="submit" class="btn btn-dark btn-block font-weight-bold shadow-sm">' +
                                    '<i class="fas fa-flag-checkered mr-1"></i> End Match & Recalculate Standings' +
                                '</button>' +
                            '</form>';
                    }
                }

                // 2. If match status changed to finished
                if (m.status === 'finished') {
                    var statusBadge = document.getElementById('match-status-badge-' + m.id);
                    if (statusBadge) {
                        statusBadge.innerHTML = '<span class="badge badge-secondary text-uppercase px-3 py-1 font-weight-bold">FINISHED</span>';
                    }
                    var timerEl = document.getElementById('timer-' + m.id);
                    if (timerEl) {
                        timerEl.className = 'badge badge-secondary font-weight-bold mt-2 px-2 py-1';
                        timerEl.innerText = 'FULL TIME';
                    }
                    var actionsContainer = document.getElementById('match-actions-' + m.id);
                    if (actionsContainer) {
                        actionsContainer.innerHTML = '<div class="text-center text-muted font-weight-bold py-2"><i class="fas fa-check-circle text-success mr-1"></i> Match Finished</div>';
                    }
                }
            }
        })
        .catch(function (err) {
            console.error('Match update request failed:', err);
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.innerHTML = originalBtnHtml;
            }
        });
    });

    // ------------------------------------------------------------------------
    // 2. Real-Time Laravel Echo Listeners (WebSocket from Reverb)
    // ------------------------------------------------------------------------
    if (typeof window.Echo !== 'undefined') {
        window.Echo.channel('live-matches')
            // Real-Time Match Started Live (Insert or Update)
            .listen('.MatchStartedLive', function (data) {
                var match = data.match || data;
                var card = document.getElementById('match-card-' + match.id);

                // If card does not exist, build and prepend it
                if (!card) {
                    var placeholder = document.getElementById('noMatchesPlaceholder');
                    if (placeholder) placeholder.style.display = 'none';

                    var tpl = document.getElementById('matchCardTemplate').innerHTML;
                    var rendered = tpl
                        .replace(/__ID__/g, match.id)
                        .replace(/__COMPETITION__/g, match.competition_name || 'Handball Competition')
                        .replace(/__HOME_TEAM__/g, match.home_team_name || 'Home Team')
                        .replace(/__AWAY_TEAM__/g, match.away_team_name || 'Away Team')
                        .replace(/__HOME_SCORE__/g, match.home_score ?? 0)
                        .replace(/__AWAY_SCORE__/g, match.away_score ?? 0)
                        .replace(/__GROUP_NAME__/g, match.group_name || ('Round ' + (match.round_number || 1)))
                        .replace(/__STARTED_AT__/g, match.started_at || new Date().toISOString())
                        .replace(/__TIMER__/g, match.formatted_timer || '00:00')
                        .replace(/__UPDATE_URL__/g, match.update_score_url || ('/admin/matches/' + match.id + '/update-score'));

                    var row = document.getElementById('liveMatchesRow');
                    if (row) {
                        row.insertAdjacentHTML('afterbegin', rendered);
                    }
                } else {
                    // Update existing card from Scheduled to Live
                    var statusBadge = document.getElementById('match-status-badge-' + match.id);
                    if (statusBadge) {
                        statusBadge.innerHTML = '<span class="badge badge-danger text-uppercase px-3 py-1 font-weight-bold animate-pulse"><i class="fas fa-circle mr-1" style="font-size: 8px;"></i> LIVE</span>';
                    }
                    var timerContainer = document.getElementById('match-timer-container-' + match.id);
                    if (timerContainer) {
                        timerContainer.innerHTML = '<div class="badge badge-dark text-warning font-weight-bold mt-2 px-2 py-1 match-live-timer" style="font-size: 0.9rem;" id="timer-' + match.id + '" data-started="' + (match.started_at || new Date().toISOString()) + '">' + (match.formatted_timer || '00:00') + '</div>';
                    }
                    var actionsContainer = document.getElementById('match-actions-' + match.id);
                    if (actionsContainer && match.update_score_url) {
                        actionsContainer.innerHTML = '<div class="row mb-3">' +
                            '<div class="col-6">' +
                                '<div class="btn-group w-100" role="group">' +
                                    '<form action="' + match.update_score_url + '" method="POST" class="w-50 ajax-match-action">' +
                                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                        '<input type="hidden" name="action" value="decrement_home">' +
                                        '<button type="submit" class="btn btn-outline-danger btn-block font-weight-bold">- 1</button>' +
                                    '</form>' +
                                    '<form action="' + match.update_score_url + '" method="POST" class="w-50 ajax-match-action">' +
                                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                        '<input type="hidden" name="action" value="increment_home">' +
                                        '<button type="submit" class="btn btn-primary btn-block font-weight-bold">+ Goal</button>' +
                                    '</form>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-6">' +
                                '<div class="btn-group w-100" role="group">' +
                                    '<form action="' + match.update_score_url + '" method="POST" class="w-50 ajax-match-action">' +
                                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                        '<input type="hidden" name="action" value="decrement_away">' +
                                        '<button type="submit" class="btn btn-outline-danger btn-block font-weight-bold">- 1</button>' +
                                    '</form>' +
                                    '<form action="' + match.update_score_url + '" method="POST" class="w-50 ajax-match-action">' +
                                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                        '<input type="hidden" name="action" value="increment_away">' +
                                        '<button type="submit" class="btn btn-danger btn-block font-weight-bold">+ Goal</button>' +
                                    '</form>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<form action="' + match.update_score_url + '" method="POST" class="ajax-match-action" onsubmit="return confirm(\'Finish this match and recalculate standings?\');">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="action" value="finish_match">' +
                            '<button type="submit" class="btn btn-dark btn-block font-weight-bold shadow-sm">' +
                                '<i class="fas fa-flag-checkered mr-1"></i> End Match & Recalculate Standings' +
                            '</button>' +
                        '</form>';
                    }
                }
            })
            // Real-Time Score Update (Increment / Decrement from any admin)
            .listen('.MatchScoreUpdated', function (data) {
                var homeScoreEl = document.getElementById('home-score-' + data.match_id);
                var awayScoreEl = document.getElementById('away-score-' + data.match_id);

                if (homeScoreEl && parseInt(homeScoreEl.innerText) !== data.home_score) {
                    homeScoreEl.innerText = data.home_score;
                    flashScore(homeScoreEl);
                }

                if (awayScoreEl && parseInt(awayScoreEl.innerText) !== data.away_score) {
                    awayScoreEl.innerText = data.away_score;
                    flashScore(awayScoreEl);
                }

                var timerEl = document.getElementById('timer-' + data.match_id);
                if (timerEl && data.formatted_timer) {
                    timerEl.innerText = data.formatted_timer;
                }
            })
            // Real-Time Match Finished / Status Changed
            .listen('.MatchStatusUpdated', function (data) {
                var statusBadge = document.getElementById('match-status-badge-' + data.match_id);
                if (statusBadge && data.status === 'finished') {
                    statusBadge.innerHTML = '<span class="badge badge-secondary text-uppercase px-3 py-1 font-weight-bold">FINISHED</span>';
                }

                var timerEl = document.getElementById('timer-' + data.match_id);
                if (timerEl && data.status === 'finished') {
                    timerEl.className = 'badge badge-secondary font-weight-bold mt-2 px-2 py-1';
                    timerEl.innerText = 'FULL TIME';
                }

                var actionsContainer = document.getElementById('match-actions-' + data.match_id);
                if (actionsContainer && data.status === 'finished') {
                    actionsContainer.innerHTML = '<div class="text-center text-muted font-weight-bold py-2"><i class="fas fa-check-circle text-success mr-1"></i> Match Finished</div>';
                }
            });
    }

    // ------------------------------------------------------------------------
    // 3. Client-Side Live Match Timer Ticker (Ticks every second)
    // ------------------------------------------------------------------------
    setInterval(function () {
        document.querySelectorAll('.match-live-timer').forEach(function (el) {
            var startedStr = el.getAttribute('data-started');
            if (!startedStr) return;
            var start = new Date(startedStr).getTime();
            var now = Date.now();
            var diff = Math.max(0, Math.floor((now - start) / 1000));
            var mins = Math.floor(diff / 60);
            var secs = diff % 60;
            el.innerText = (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
        });
    }, 1000);
});
</script>

<style>
@keyframes scorePulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); color: #10b981 !important; text-shadow: 0 0 15px rgba(16, 185, 129, 0.6); }
    100% { transform: scale(1); }
}
.score-flash {
    animation: scorePulse 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 30px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>
@endpush
