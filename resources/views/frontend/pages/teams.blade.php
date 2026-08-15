@extends('frontend.layouts.app')

@section('title', 'Teams & Clubs — Handball Hub')

@section('content')
<section class="section">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 class="section-title" style="margin: 0;">Teams & Clubs</h1>
                <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 4px;">Registered handball clubs and competition participants.</p>
            </div>
            <span style="font-size: 0.9rem; color: #ea580c; font-weight: 700; background: rgba(234, 88, 12, 0.1); padding: 8px 16px; border-radius: 20px; border: 1px solid rgba(234, 88, 12, 0.2);">
                Total Teams: {{ count($teams) }}
            </span>
        </div>

        <div class="teams-grid">
            @forelse($teams as $team)
                <div class="team-card">
                    <div class="team-card-header">
                        <img src="{{ $team->logo_url }}" alt="{{ $team->name }}" referrerpolicy="no-referrer" style="width: 52px; height: 52px; object-fit: contain; border-radius: 8px; background: rgba(255,255,255,0.05); padding: 4px;" onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                        <div>
                            <div class="team-name">{{ $team->name }}</div>
                            <div class="team-location">{{ $team->city ?? 'City' }} &middot; {{ $team->country ?? 'Egypt' }}</div>
                        </div>
                    </div>
                    
                    <div class="team-coach" style="margin: 12px 0;">
                        Short Code: <strong style="color: #ffffff;">{{ $team->short_name ?? 'N/A' }}</strong>
                    </div>

                    <div>
                        <a href="{{ route('teams.show', $team->id) }}" style="display: inline-block; width: 100%; text-align: center; padding: 10px; background: rgba(234, 88, 12, 0.15); border: 1px solid #ea580c; color: #ea580c; border-radius: 6px; font-weight: 700; text-decoration: none; font-size: 0.85rem; transition: background 0.2s;">
                            View Team Profile &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #0e1626; border: 1px dashed #334155; border-radius: 12px; color: #94a3b8;">
                    <div style="font-size: 2.5rem; margin-bottom: 12px;">🛡️</div>
                    <h3 style="color: #ffffff; margin-bottom: 8px;">No Teams Found</h3>
                    <p style="font-size: 0.9rem;">There are currently no registered teams available in the system.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
