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

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; border-top: 1px solid #1e293b; padding-top: 24px;">
                <div style="background: #070c14; padding: 20px; border-radius: 10px; border: 1px solid #1e293b;">
                    <div style="color: #64748b; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">Short Code</div>
                    <div style="font-size: 1.4rem; color: #fff; font-weight: 800; margin-top: 4px;">{{ $team->short_name }}</div>
                </div>

                <div style="background: #070c14; padding: 20px; border-radius: 10px; border: 1px solid #1e293b;">
                    <div style="color: #64748b; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">Location</div>
                    <div style="font-size: 1.4rem; color: #fff; font-weight: 800; margin-top: 4px;">{{ $team->city }}, {{ $team->country }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
