@extends('frontend.layouts.app')

@section('title', 'Match Centre — Handball Hub')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="page-title" style="margin-bottom: 32px;">MATCH CENTRE</h1>

        <!-- Filter Tabs Bar (UI Only) -->
        <div class="filter-tabs">
            <button class="filter-tab active" type="button">ALL</button>
            <button class="filter-tab" type="button">LIVE</button>
            <button class="filter-tab" type="button">UPCOMING</button>
            <button class="filter-tab" type="button">RESULTS</button>
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
                                @if(in_array($rawStatus, ['finished', 'live']))
                                    {{ $match->home_score }} : {{ $match->away_score }}
                                @else
                                    VS
                                @endif
                            </div>

                            <span class="team-name away">{{ $match->awayTeam->name ?? 'N/A' }}</span>
                        </div>

                        <div class="match-badge-wrap">
                            <span class="status-pill {{ $pillClass }}">
                                {{ $statusDisplay }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div style="text-align: center; padding: 60px 20px; background: #0e1626; border: 1px dashed #334155; border-radius: 12px; color: #94a3b8; width: 100%;">
                    <div style="font-size: 2.5rem; margin-bottom: 12px;">🤾‍♂️</div>
                    <h3 style="color: #ffffff; margin-bottom: 8px;">No Matches Found</h3>
                    <p style="font-size: 0.9rem;">There are no matches available in the match centre at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
