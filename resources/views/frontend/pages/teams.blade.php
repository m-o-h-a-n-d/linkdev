@extends('frontend.layouts.app')

@section('title', 'Teams & Clubs — Handball Hub')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="section-title" style="margin-bottom: 30px;">Teams</h1>

        <div class="teams-grid">

            <!-- Team 1: Zamalek HC -->
            <div class="team-card">
                <div class="team-card-header">
                    <div class="team-logo">ZAM</div>
                    <div>
                        <div class="team-name">Zamalek HC</div>
                        <div class="team-location">Cairo &middot; est. 1911</div>
                    </div>
                </div>
                <div class="team-coach">Head coach: H. Farouk</div>
                <div class="team-stats">
                    <div class="team-stat"><div class="team-stat-number">3</div><div class="team-stat-label">P</div></div>
                    <div class="team-stat"><div class="team-stat-number">3</div><div class="team-stat-label">W</div></div>
                    <div class="team-stat"><div class="team-stat-number">0</div><div class="team-stat-label">D</div></div>
                    <div class="team-stat"><div class="team-stat-number">0</div><div class="team-stat-label">L</div></div>
                </div>
                <div class="team-goals">Goals 81 : 65</div>
            </div>

            <!-- Team 2: Al Ahly HC -->
            <div class="team-card">
                <div class="team-card-header">
                    <div class="team-logo">AHL</div>
                    <div>
                        <div class="team-name">Al Ahly HC</div>
                        <div class="team-location">Cairo &middot; est. 1907</div>
                    </div>
                </div>
                <div class="team-coach">Head coach: M. Sayed</div>
                <div class="team-stats">
                    <div class="team-stat"><div class="team-stat-number">3</div><div class="team-stat-label">P</div></div>
                    <div class="team-stat"><div class="team-stat-number">1</div><div class="team-stat-label">W</div></div>
                    <div class="team-stat"><div class="team-stat-number">0</div><div class="team-stat-label">D</div></div>
                    <div class="team-stat"><div class="team-stat-number">2</div><div class="team-stat-label">L</div></div>
                </div>
                <div class="team-goals">Goals 76 : 70</div>
            </div>

        </div>
    </div>
</section>
@endsection
