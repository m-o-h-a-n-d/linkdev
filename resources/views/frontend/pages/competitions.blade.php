@extends('frontend.layouts.app')

@section('title', 'Competitions — Handball Hub')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">National Handball League</h2>
            <span class="competition-status status-ongoing">Ongoing</span>
        </div>

        <p class="competition-meta" style="font-size: 1rem; margin-bottom: 32px;">Season 2025/26 &middot; Cairo Indoor Arena</p>

        <div class="competitions-grid">

            <div class="competition-card">
                <h3>Group Stage - Group A</h3>
                <p class="competition-meta">4 Teams &middot; 6 Matches Played</p>
                <div class="competition-stats">
                    <div class="competition-stat">
                        <span class="competition-stat-label">Leader</span>
                        <span class="competition-stat-value" style="color: var(--accent-orange);">Zamalek HC</span>
                    </div>
                </div>
            </div>

            <div class="competition-card">
                <h3>Group Stage - Group B</h3>
                <p class="competition-meta">4 Teams &middot; 3 Matches Played</p>
                <div class="competition-stats">
                    <div class="competition-stat">
                        <span class="competition-stat-label">Leader</span>
                        <span class="competition-stat-value" style="color: var(--accent-orange);">Heliopolis</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
