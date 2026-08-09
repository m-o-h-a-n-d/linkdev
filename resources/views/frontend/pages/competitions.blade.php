@extends('frontend.layouts.app')

@section('title', 'Competitions — Handball Hub')

@section('content')
<section class="section">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 class="section-title" style="margin: 0;">Competitions</h1>
                <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 4px;">Active tournaments, groups, and championship stages.</p>
            </div>
            <span style="font-size: 0.9rem; color: #ea580c; font-weight: 700; background: rgba(234, 88, 12, 0.1); padding: 8px 16px; border-radius: 20px; border: 1px solid rgba(234, 88, 12, 0.2);">
                Total Competitions: {{ isset($competitions) ? $competitions->count() : 0 }}
            </span>
        </div>

        <div class="competitions-grid">
            @forelse($competitions ?? [] as $competition)
                <div class="competition-card" style="background: #0e1626; border: 1px solid #1e293b; border-radius: 12px; padding: 24px; position: relative;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <h3 style="color: #ffffff; margin: 0; font-size: 1.25rem;">{{ $competition->name }}</h3>
                        <span class="competition-status status-{{ strtolower($competition->status ?? 'ongoing') }}">
                            {{ ucfirst($competition->status ?? 'Ongoing') }}
                        </span>
                    </div>

                    <p class="competition-meta" style="font-size: 0.85rem; color: #94a3b8; margin-bottom: 20px;">
                        {{ $competition->teams_count ?? 0 }} Teams &middot; {{ $competition->matches_count ?? 0 }} Matches Played
                    </p>

                    <div class="competition-stats" style="margin-bottom: 20px;">
                        <div class="competition-stat">
                            <span class="competition-stat-label" style="display: block; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Leader</span>
                            <span class="competition-stat-value" style="color: #ea580c; font-weight: 700; font-size: 1rem;">
                                {{ $competition->leader->name ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('competitions.show', $competition->id) }}" style="display: inline-block; width: 100%; text-align: center; padding: 10px; background: rgba(234, 88, 12, 0.15); border: 1px solid #ea580c; color: #ea580c; border-radius: 6px; font-weight: 700; text-decoration: none; font-size: 0.85rem; transition: background 0.2s;">
                            View Competition Details &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #0e1626; border: 1px dashed #334155; border-radius: 12px; color: #94a3b8;">
                    <div style="font-size: 2.5rem; margin-bottom: 12px;">🏆</div>
                    <h3 style="color: #ffffff; margin-bottom: 8px;">No Competitions Found</h3>
                    <p style="font-size: 0.9rem;">There are currently no active competitions available in the system.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
