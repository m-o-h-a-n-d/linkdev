@php
    $comp = $competition ?? \App\Models\Competition::where('status', '!=', 'cancelled')->latest()->first();
    $knockoutMatches = $comp ? $comp->matches()->whereNull('group_id')->with(['homeTeam', 'awayTeam', 'winnerTeam'])->orderBy('round_number', 'asc')->orderBy('id', 'asc')->get() : collect();
    $groupedKnockout = $knockoutMatches->groupBy('round_number');
    $champion = $comp?->winnerTeam;
@endphp

<div class="tournament-bracket-card">
    <div class="bracket-header-bar">
        <div class="bracket-title-wrap">
            <span class="bracket-badge-pill">🏆 PLAYOFFS & KNOCKOUT BRACKET</span>
            <h3 class="bracket-main-title">{{ $comp->name ?? 'Handball Championship' }}{{ $comp && $comp->season && !str_contains($comp->name, $comp->season) ? ' (' . $comp->season . ')' : '' }}</h3>
        </div>
        @if($champion)
            <div class="bracket-champion-badge">
                <span class="trophy-icon">🏆</span>
                <div>
                    <span class="champion-label">TOURNAMENT CHAMPION</span>
                    <strong class="champion-name">{{ $champion->name }} ({{ $champion->short_name }})</strong>
                </div>
            </div>
        @elseif($comp && $comp->status === 'ongoing')
            <div class="bracket-live-indicator">
                <span class="pulse-dot"></span>
                <span>TOURNAMENT IN PROGRESS</span>
            </div>
        @endif
    </div>

    @if($knockoutMatches->isNotEmpty())
        <div class="bracket-tree-wrapper">
            @foreach($groupedKnockout as $roundNum => $matchesInRound)
                @php
                    $count = $matchesInRound->count();
                    $roundTitle = match($count) {
                        1 => 'CHAMPIONSHIP FINAL',
                        2 => 'SEMI-FINALS',
                        4 => 'QUARTER-FINALS',
                        default => 'ROUND ' . $roundNum,
                    };
                @endphp
                <div class="bracket-column">
                    <div class="bracket-column-header">
                        <span class="round-number-badge">STAGE {{ $roundNum }}</span>
                        <h4 class="round-title">{{ $roundTitle }}</h4>
                    </div>

                    <div class="bracket-matches-stack">
                        @foreach($matchesInRound as $match)
                            @php
                                $isLive = $match->status === 'live';
                                $isFinished = $match->status === 'finished';
                                $homeWon = $isFinished && $match->winner_team_id === $match->home_team_id;
                                $awayWon = $isFinished && $match->winner_team_id === $match->away_team_id;
                            @endphp
                            <div class="bracket-fixture-node {{ $isLive ? 'is-live' : '' }} {{ $isFinished ? 'is-finished' : '' }}">
                                <div class="node-top-bar">
                                    <span class="node-date">
                                        {{ $match->scheduled_at ? $match->scheduled_at->format('M d, H:i') : 'TBA' }}
                                    </span>
                                    <span class="node-status-badge status-{{ $match->status }}">
                                        @if($isLive)
                                            <span class="mini-live-dot"></span> LIVE
                                        @elseif($isFinished)
                                            FT
                                        @else
                                            UPCOMING
                                        @endif
                                    </span>
                                </div>

                                <!-- Home Team Row -->
                                <div class="node-team-row {{ $homeWon ? 'winner-highlight' : '' }}">
                                    <div class="team-meta">
                                        <img src="{{ $match->homeTeam?->logo_url ?? asset('backend/img/undraw_profile.svg') }}" 
                                             alt="{{ $match->homeTeam?->name }}" 
                                             class="team-logo-small"
                                             onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                                        <span class="team-title" title="{{ $match->homeTeam?->name }}">
                                            {{ $match->homeTeam?->name ?? 'TBA' }}
                                        </span>
                                    </div>
                                    <div class="team-score-box {{ $homeWon ? 'score-winner' : '' }}">
                                        {{ in_array($match->status, ['finished', 'live']) ? $match->home_score : '-' }}
                                    </div>
                                </div>

                                <!-- Away Team Row -->
                                <div class="node-team-row {{ $awayWon ? 'winner-highlight' : '' }}">
                                    <div class="team-meta">
                                        <img src="{{ $match->awayTeam?->logo_url ?? asset('backend/img/undraw_profile.svg') }}" 
                                             alt="{{ $match->awayTeam?->name }}" 
                                             class="team-logo-small"
                                             onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                                        <span class="team-title" title="{{ $match->awayTeam?->name }}">
                                            {{ $match->awayTeam?->name ?? 'TBA' }}
                                        </span>
                                    </div>
                                    <div class="team-score-box {{ $awayWon ? 'score-winner' : '' }}">
                                        {{ in_array($match->status, ['finished', 'live']) ? $match->away_score : '-' }}
                                    </div>
                                </div>

                                @if($match->notes)
                                    <div class="node-footer-note">
                                        {{ $match->notes }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Champion Podium Column -->
            <div class="bracket-column champion-column">
                <div class="bracket-column-header">
                    <span class="round-number-badge gold-badge">WINNER</span>
                    <h4 class="round-title gold-title">CHAMPION 🏆</h4>
                </div>

                <div class="champion-podium-card {{ $champion ? 'crowned' : 'pending' }}">
                    <div class="trophy-glow-wrapper">
                        <div class="large-trophy-icon">🏆</div>
                    </div>
                    @if($champion)
                        <img src="{{ $champion->logo_url }}" 
                             alt="{{ $champion->name }}" 
                             class="champion-podium-logo"
                             onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                        <h4 class="champion-podium-name">{{ $champion->name }}</h4>
                        <span class="champion-podium-tag">CHAMPION 2026</span>
                    @else
                        <div class="pending-podium-text">
                            <span>Awaiting Final</span>
                            <small>Winner of Championship Final</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- No Knockout Matches Yet (Preview State) -->
        @if(isset($siteSettings) && $siteSettings->matches_image)
            <div class="bracket-image-container" style="width: 100%; text-align: center; margin: 0 auto 20px;">
                <img src="{{ $siteSettings->matches_image_url }}" 
                     alt="Official Tournament Bracket Chart" 
                     style="width: 100%; max-width: 100%; height: auto; display: block; margin: 0 auto; border-radius: 14px; border: 1px solid #1e293b; box-shadow: 0 16px 40px rgba(0,0,0,0.6);">
            </div>
            @if($comp && $comp->groups->isNotEmpty())
                <div class="empty-bracket-groups" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 12px; margin-top: 16px;">
                    @foreach($comp->groups as $grp)
                        <span class="group-preview-pill" style="background: #162238; border: 1px solid #1e293b; color: #cbd5e1; font-size: 0.85rem; font-weight: 700; padding: 8px 18px; border-radius: 20px;">
                            <i class="fas fa-layer-group text-warning mr-1"></i> {{ $grp->name }} ({{ $grp->teams->count() }} Teams)
                        </span>
                    @endforeach
                </div>
            @endif
        @else
            <div class="bracket-preview-empty">
                <div class="empty-bracket-icon">🤾‍♂️</div>
                <h4>Knockout Stage Bracket</h4>
                <p>
                    Semi-Finals and Final fixtures will be automatically generated and populated here in real-time as soon as all group stage matches finish!
                </p>
                @if($comp && $comp->groups->isNotEmpty())
                    <div class="empty-bracket-groups">
                        @foreach($comp->groups as $grp)
                            <span class="group-preview-pill">
                                <i class="fas fa-layer-group"></i> {{ $grp->name }} ({{ $grp->teams->count() }} Teams)
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    @endif
</div>
