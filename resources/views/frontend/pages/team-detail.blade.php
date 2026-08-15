@extends('frontend.layouts.app')

@section('title', $team->name . ' — Handball Hub')

@section('content')
<section class="section">
    <div class="container" style="max-width: 800px;">
        <div style="margin-bottom: 24px;">
            <a href="{{ route('teams.index') }}" style="color: #ea580c; text-decoration: none; font-weight: 700; font-size: 0.9rem;">
                &larr; Back to All Teams
            </a>
        </div>

        <div style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
            <div style="display: flex; align-items: center; gap: 24px; margin-bottom: 30px;">
                <img src="{{ $team->logo_url }}" alt="{{ $team->name }}" referrerpolicy="no-referrer" style="width: 80px; height: 80px; object-fit: contain; background: rgba(255,255,255,0.05); padding: 6px; border-radius: 12px;" onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                <div>
                    <h1 style="font-size: 2.2rem; color: #fff; margin: 0 0 6px 0;">{{ $team->name }}</h1>
                    <div style="color: #94a3b8; font-size: 1rem;">
                        {{ $team->city ?? 'Cairo' }} &middot; {{ $team->country ?? 'Egypt' }}
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; border-top: 1px solid #1e293b; padding-top: 24px;">
                <div style="background: #070c14; padding: 20px; border-radius: 10px; border: 1px solid #1e293b;">
                    <div style="color: #ea580c; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">
                        <i class="fas fa-tag mr-1"></i> Short Code
                    </div>
                    <div style="font-size: 1.4rem; color: #fff; font-weight: 800; margin-top: 4px;">{{ $team->short_name }}</div>
                </div>

                <div style="background: #070c14; padding: 20px; border-radius: 10px; border: 1px solid #1e293b;">
                    <div style="color: #ea580c; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">
                        <i class="fas fa-map-marker-alt mr-1"></i> Location
                    </div>
                    <div style="font-size: 1.2rem; color: #fff; font-weight: 800; margin-top: 4px;">{{ $team->city ?? 'N/A' }}, {{ $team->country ?? 'مصر' }}</div>
                </div>

                @if($team->arena)
                <div style="background: #070c14; padding: 20px; border-radius: 10px; border: 1px solid #1e293b;">
                    <div style="color: #ea580c; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">
                        <i class="fas fa-warehouse mr-1"></i> Home Arena
                    </div>
                    <div style="font-size: 1.1rem; color: #fff; font-weight: 700; margin-top: 4px;">{{ $team->arena }}</div>
                </div>
                @endif

                @if($team->manager_name)
                <div style="background: #070c14; padding: 20px; border-radius: 10px; border: 1px solid #1e293b;">
                    <div style="color: #ea580c; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">
                        <i class="fas fa-user-tie mr-1"></i> Head Coach / Manager
                    </div>
                    <div style="font-size: 1.1rem; color: #fff; font-weight: 700; margin-top: 4px;">{{ $team->manager_name }}</div>
                </div>
                @endif
            </div>

            @if($team->competitions && $team->competitions->isNotEmpty())
            <div style="margin-top: 24px; border-top: 1px solid #1e293b; padding-top: 24px;">
                <div style="color: #94a3b8; font-size: 0.85rem; text-transform: uppercase; font-weight: 700; margin-bottom: 12px;">
                    Participating Competitions
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    @foreach($team->competitions as $comp)
                        <span style="background: rgba(234, 88, 12, 0.15); border: 1px solid rgba(234, 88, 12, 0.3); color: #fed7aa; padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 0.85rem;">
                            <i class="fas fa-trophy mr-1 text-warning"></i> {{ $comp->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
