@extends('frontend.layouts.app')

@section('title', ($competition->name ?? 'Competition Details') . ' — Handball Hub')

@section('content')
    <section class="section">
        <div class="container" style="max-width: 900px;">
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
                                @if (!empty($team->logo))
                                    <img src="{{ asset($team->logo) }}" alt="{{ $team->name }}"
                                        style="width: 52px; height: 52px; object-fit: contain; border-radius: 8px;">
                                @else
                                    <div class="team-logo">{{ strtoupper(substr($team->short_name ?? $team->name, 0, 3)) }}
                                    </div>
                                @endif
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
        </div>
    </section>
@endsection
