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

                    <span class="status-pill {{ $pillClass }}" style="font-size: 0.85rem; padding: 6px 14px; border-radius: 20px;">
                        {{ $statusDisplay }}
                    </span>
                </div>

                <!-- Teams & Score Display -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 32px; text-align: center;">

                    <!-- Home Team -->
                    <div style="flex: 1;">
                        @if (!empty($match->homeTeam->logo))
                            <img src="{{ asset($match->homeTeam->logo) }}" alt="{{ $match->homeTeam->name }}"
                                style="width: 72px; height: 72px; object-fit: contain; margin: 0 auto 12px auto; display: block;">
                        @else
                            <div style="width: 72px; height: 72px; background: #070c14; border: 1px solid #1e293b; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #ea580c; font-size: 1.2rem; margin: 0 auto 12px auto;">
                                {{ strtoupper(substr($match->homeTeam->short_name ?? $match->homeTeam->name ?? 'HOM', 0, 3)) }}
                            </div>
                        @endif
                        <h2 style="font-size: 1.3rem; color: #fff; margin: 0 0 6px 0;">
                            {{ $match->homeTeam->name ?? 'Home Team' }}
                        </h2>
                        <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">HOME</span>
                    </div>

                    <!-- Score / VS Center Area -->
                    <div style="padding: 0 20px;">
                        @if(in_array($rawStatus, ['finished', 'live']))
                            <div style="font-size: 3rem; font-weight: 900; color: #fff; letter-spacing: 2px; line-height: 1;">
                                {{ $match->home_score }} <span style="color: #ea580c;">:</span> {{ $match->away_score }}
                            </div>
                        @else
                            <div style="font-size: 2rem; font-weight: 900; color: #ea580c; background: rgba(234, 88, 12, 0.1); border: 1px solid rgba(234, 88, 12, 0.2); padding: 10px 24px; border-radius: 12px; display: inline-block;">
                                VS
                            </div>
                        @endif

                        <div style="color: #94a3b8; font-size: 0.85rem; margin-top: 12px; font-weight: 600;">
                            {{ $match->scheduled_at ? $match->scheduled_at->format('D d M Y, H:i') : 'TBD' }}
                        </div>
                    </div>

                    <!-- Away Team -->
                    <div style="flex: 1;">
                        @if (!empty($match->awayTeam->logo))
                            <img src="{{ asset($match->awayTeam->logo) }}" alt="{{ $match->awayTeam->name }}"
                                style="width: 72px; height: 72px; object-fit: contain; margin: 0 auto 12px auto; display: block;">
                        @else
                            <div style="width: 72px; height: 72px; background: #070c14; border: 1px solid #1e293b; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #ea580c; font-size: 1.2rem; margin: 0 auto 12px auto;">
                                {{ strtoupper(substr($match->awayTeam->short_name ?? $match->awayTeam->name ?? 'AWY', 0, 3)) }}
                            </div>
                        @endif
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
                        <div style="font-size: 1.2rem; color: #ea580c; font-weight: 800; margin-top: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $match->winnerTeam->name ?? ($rawStatus === 'finished' ? 'Draw / None' : 'Pending') }}
                        </div>
                    </div>

                    <div style="background: #070c14; padding: 18px; border-radius: 10px; border: 1px solid #1e293b;">
                        <div style="color: #64748b; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">
                            Start Time
                        </div>
                        <div style="font-size: 1.1rem; color: #fff; font-weight: 800; margin-top: 4px;">
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
