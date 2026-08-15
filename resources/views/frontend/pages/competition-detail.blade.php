@extends('frontend.layouts.app')

@section('title', ($competition->name ?? 'Competition Details') . ' — Handball Hub')

@section('content')
    <section class="section">
        <div class="container" style="max-width: 1400px; width: 96%; margin: 0 auto;">
            <div style="margin-bottom: 24px;">
                <a href="{{ route('competitions.index') }}"
                    style="color: #ea580c; text-decoration: none; font-weight: 700; font-size: 0.9rem;">
                    &larr; Back to All Competitions
                </a>
            </div>

            <div
                style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.5); margin-bottom: 30px;">
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 20px;">
                    <div>
                        <h1 style="font-size: 2.2rem; color: #fff; margin: 0 0 8px 0;">
                            {{ $competition->name ?? 'Group Stage - Group A' }}</h1>
                        <p class="competition-meta" style="font-size: 1rem; margin: 0; color: #94a3b8;">
                            Season {{ $competition->season ?? '2025/26' }} &middot;
                            {{ $competition->venue ?? 'Cairo Indoor Arena' }}
                        </p>
                    </div>
                    <span class="competition-status status-ongoing"
                        style="font-size: 0.85rem; padding: 6px 14px; border-radius: 20px;">
                        {{ $competition->status ?? 'Ongoing' }}
                    </span>
                </div>

                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; border-top: 1px solid #1e293b; padding-top: 24px;">
                    <div style="background: #070c14; padding: 18px; border-radius: 10px; border: 1px solid #1e293b;">
                        <div style="color: #64748b; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">
                            Participating Teams</div>
                        <div style="font-size: 1.5rem; color: #fff; font-weight: 800; margin-top: 4px;">
                            {{ isset($competition->teams) ? count($competition->teams) : 4 }} Teams
                        </div>
                    </div>

                    <div style="background: #070c14; padding: 18px; border-radius: 10px; border: 1px solid #1e293b;">
                        <div style="color: #64748b; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">Matches
                            Played</div>
                        <div style="font-size: 1.5rem; color: #fff; font-weight: 800; margin-top: 4px;">
                            {{ $competition->matches_count ?? 6 }} Matches
                        </div>
                    </div>

                    <div style="background: #070c14; padding: 18px; border-radius: 10px; border: 1px solid #1e293b;">
                        <div style="color: #64748b; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">Current
                            Leader</div>
                        <div
                            style="font-size: 1.3rem; color: #ea580c; font-weight: 800; margin-top: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $competition->leader->name ?? 'Zamalek HC' }}
                        </div>
                    </div>
                </div>
            <!-- Tournament Bracket / Waiting Status Component -->
            <div style="margin-bottom: 30px;">
                @include('frontend.partials.bracket', ['competition' => $competition])
            </div>

            <div style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; padding: 30px;">
                <h3
                    style="color: #fff; margin-top: 0; margin-bottom: 20px; font-size: 1.3rem; border-bottom: 1px solid #1e293b; padding-bottom: 12px;">
                    Participating Teams
                </h3>

                <div class="teams-grid">
                    @forelse($competition->teams ?? [] as $team)
                        <div class="team-card">
                            <div class="team-card-header">
                                <img src="{{ $team->logo_url }}" alt="{{ $team->name }}" referrerpolicy="no-referrer"
                                    style="width: 52px; height: 52px; object-fit: contain; border-radius: 8px; background: rgba(255,255,255,0.05); padding: 4px;"
                                    onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                                <div>
                                    <div class="team-name">{{ $team->name }}</div>
                                    <div class="team-location">{{ $team->city ?? 'Cairo' }} &middot;
                                        {{ $team->country ?? 'Egypt' }}</div>
                                </div>
                            </div>

                            <div class="team-coach" style="margin: 12px 0;">
                                Short Code: <strong style="color: #ffffff;">{{ $team->short_name ?? 'N/A' }}</strong>
                            </div>

                            <div>
                                <a href="{{ route('teams.show', $team->id) }}"
                                    style="display: inline-block; width: 100%; text-align: center; padding: 10px; background: rgba(234, 88, 12, 0.15); border: 1px solid #ea580c; color: #ea580c; border-radius: 6px; font-weight: 700; text-decoration: none; font-size: 0.85rem; transition: background 0.2s;">
                                    View Team Profile &rarr;
                                </a>
                            </div>
                        </div>
                    @empty
                        <div
                            style="grid-column: 1 / -1; text-align: center; padding: 40px 20px; background: #070c14; border: 1px dashed #334155; border-radius: 12px; color: #94a3b8;">
                            <div style="font-size: 2rem; margin-bottom: 8px;">🛡️</div>
                            <h4 style="color: #ffffff; margin-bottom: 4px;">No Teams Assigned</h4>
                            <p style="font-size: 0.85rem; margin: 0;">There are currently no teams participating in this
                                competition group.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Group Standings Tables (Per Group) -->
            @foreach($competition->groups ?? [] as $group)
                <div style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; padding: 30px; margin-top: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #1e293b; padding-bottom: 12px; margin-bottom: 20px;">
                        <h3 style="color: #fff; margin: 0; font-size: 1.3rem;">
                            🏆 {{ $group->name }} — Group Standings
                        </h3>
                        <span style="background: rgba(234, 88, 12, 0.15); border: 1px solid #ea580c; color: #ea580c; font-size: 0.75rem; padding: 4px 12px; border-radius: 12px; font-weight: 700;">
                            Handball Points (Win: 2pt, Draw: 1pt)
                        </span>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: center; color: #ffffff; font-size: 0.9rem;">
                            <thead>
                                <tr style="background: #070c14; border-bottom: 1px solid #1e293b; color: #94a3b8; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">
                                    <th style="padding: 12px; text-align: left;"># POS</th>
                                    <th style="padding: 12px; text-align: left;">Team</th>
                                    <th style="padding: 12px;">P</th>
                                    <th style="padding: 12px;">W</th>
                                    <th style="padding: 12px;">D</th>
                                    <th style="padding: 12px;">L</th>
                                    <th style="padding: 12px;">GF</th>
                                    <th style="padding: 12px;">GA</th>
                                    <th style="padding: 12px;">GD</th>
                                    <th style="padding: 12px; color: #ea580c; font-weight: 800;">PTS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($group->standings ?? [] as $standing)
                                    @php
                                        $rank = $loop->iteration;
                                        $bg = match($rank) {
                                            1 => 'rgba(245, 158, 11, 0.08)',
                                            2 => 'rgba(148, 163, 184, 0.08)',
                                            default => 'transparent',
                                        };
                                    @endphp
                                    <tr style="border-bottom: 1px solid #1e293b; background: {{ $bg }};">
                                        <td style="padding: 12px; text-align: left; font-weight: 800;">
                                            @if($rank == 1)
                                                <span style="background: rgba(245, 158, 11, 0.2); color: #f59e0b; border: 1px solid #f59e0b; padding: 4px 10px; border-radius: 20px; font-weight: 800; font-size: 0.75rem;">1st 🥇</span>
                                            @elseif($rank == 2)
                                                <span style="background: rgba(148, 163, 184, 0.2); color: #cbd5e1; border: 1px solid #94a3b8; padding: 4px 10px; border-radius: 20px; font-weight: 800; font-size: 0.75rem;">2nd 🥈</span>
                                            @elseif($rank == 3)
                                                <span style="background: rgba(180, 83, 9, 0.2); color: #d97706; border: 1px solid #b45309; padding: 4px 10px; border-radius: 20px; font-weight: 800; font-size: 0.75rem;">3rd 🥉</span>
                                            @else
                                                <span style="background: #1e293b; color: #94a3b8; border: 1px solid #334155; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.75rem;">{{ $rank }}th</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px; text-align: left; font-weight: 700; color: #ffffff;">
                                            {{ $standing->team->name ?? 'Team' }}
                                        </td>
                                        <td style="padding: 12px;">{{ $standing->played }}</td>
                                        <td style="padding: 12px; color: #22c55e; font-weight: 700;">{{ $standing->won }}</td>
                                        <td style="padding: 12px; color: #eab308; font-weight: 700;">{{ $standing->draw }}</td>
                                        <td style="padding: 12px; color: #ef4444; font-weight: 700;">{{ $standing->lost }}</td>
                                        <td style="padding: 12px;">{{ $standing->goals_for }}</td>
                                        <td style="padding: 12px;">{{ $standing->goals_against }}</td>
                                        <td style="padding: 12px; font-weight: 700; color: {{ $standing->goal_difference >= 0 ? '#22c55e' : '#ef4444' }};">
                                            {{ $standing->goal_difference > 0 ? '+' : '' }}{{ $standing->goal_difference }}
                                        </td>
                                        <td style="padding: 12px; color: #ea580c; font-weight: 900; font-size: 1.1rem;">
                                            {{ $standing->points }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" style="padding: 24px; color: #64748b;">No standings recorded for {{ $group->name }} yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

            <!-- Overall Competition Statistics Table -->
            @if(isset($competition->statistics) && $competition->statistics->isNotEmpty())
                <div style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; padding: 30px; margin-top: 30px;">
                    <h3 style="color: #fff; margin-top: 0; margin-bottom: 20px; font-size: 1.3rem; border-bottom: 1px solid #1e293b; padding-bottom: 12px;">
                        📊 Competition Overall Team Statistics
                    </h3>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: center; color: #ffffff; font-size: 0.9rem;">
                            <thead>
                                <tr style="background: #070c14; border-bottom: 1px solid #1e293b; color: #94a3b8; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">
                                    <th style="padding: 12px; text-align: left;">Team</th>
                                    <th style="padding: 12px;">Matches Played</th>
                                    <th style="padding: 12px;">Wins</th>
                                    <th style="padding: 12px;">Draws</th>
                                    <th style="padding: 12px;">Losses</th>
                                    <th style="padding: 12px;">GF</th>
                                    <th style="padding: 12px;">GA</th>
                                    <th style="padding: 12px;">GD</th>
                                    <th style="padding: 12px; color: #ea580c; font-weight: 800;">Total PTS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($competition->statistics as $stat)
                                    <tr style="border-bottom: 1px solid #1e293b;">
                                        <td style="padding: 12px; text-align: left; font-weight: 700; color: #ffffff;">
                                            {{ $stat->team->name ?? 'Team' }}
                                        </td>
                                        <td style="padding: 12px;">{{ $stat->matches_played }}</td>
                                        <td style="padding: 12px; color: #22c55e; font-weight: 700;">{{ $stat->wins }}</td>
                                        <td style="padding: 12px; color: #eab308; font-weight: 700;">{{ $stat->draws }}</td>
                                        <td style="padding: 12px; color: #ef4444; font-weight: 700;">{{ $stat->losses }}</td>
                                        <td style="padding: 12px;">{{ $stat->goals_for }}</td>
                                        <td style="padding: 12px;">{{ $stat->goals_against }}</td>
                                        <td style="padding: 12px; font-weight: 700; color: {{ $stat->goal_difference >= 0 ? '#22c55e' : '#ef4444' }};">
                                            {{ $stat->goal_difference > 0 ? '+' : '' }}{{ $stat->goal_difference }}
                                        </td>
                                        <td style="padding: 12px; color: #ea580c; font-weight: 900; font-size: 1.1rem;">
                                            {{ $stat->points }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
