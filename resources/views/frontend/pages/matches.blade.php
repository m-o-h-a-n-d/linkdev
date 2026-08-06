@extends('frontend.layouts.app')

@section('title', 'Match Centre — Handball Hub')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="page-title" style="margin-bottom: 32px;">MATCH CENTRE</h1>

        <!-- Filter Tabs Bar -->
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">ALL</button>
            <button class="filter-tab" data-filter="live">LIVE</button>
            <button class="filter-tab" data-filter="upcoming">UPCOMING</button>
            <button class="filter-tab" data-filter="results">RESULTS</button>
        </div>

        <!-- Matches Cards List -->
        <div class="matches-cards-list">

            <!-- Match Card 1 -->
            <div class="match-card" data-status="results">
                <div class="match-meta">
                    <div class="match-date-str">Fri 10 Jul, 17:00</div>
                    <div class="match-group-str">Group A</div>
                </div>
                <div class="match-center">
                    <span class="team-name home">ZAMALEK HC</span>
                    <div class="score-badge">22 : 19</div>
                    <span class="team-name away">AL AHLY HC</span>
                </div>
                <div class="match-badge-wrap">
                    <span class="status-pill pill-fulltime">FULL TIME</span>
                </div>
            </div>

            <!-- Match Card 2 -->
            <div class="match-card" data-status="results">
                <div class="match-meta">
                    <div class="match-date-str">Mon 13 Jul, 18:00</div>
                    <div class="match-group-str">Group A</div>
                </div>
                <div class="match-center">
                    <span class="team-name home">ZAMALEK HC</span>
                    <div class="score-badge">27 : 26</div>
                    <span class="team-name away">SPORTING CLUB</span>
                </div>
                <div class="match-badge-wrap">
                    <span class="status-pill pill-fulltime">FULL TIME</span>
                </div>
            </div>

            <!-- Match Card 3 -->
            <div class="match-card" data-status="results">
                <div class="match-meta">
                    <div class="match-date-str">Thu 16 Jul, 19:00</div>
                    <div class="match-group-str">Group A</div>
                </div>
                <div class="match-center">
                    <span class="team-name home">ZAMALEK HC</span>
                    <div class="score-badge">32 : 20</div>
                    <span class="team-name away">SMOUHA HC</span>
                </div>
                <div class="match-badge-wrap">
                    <span class="status-pill pill-fulltime">FULL TIME</span>
                </div>
            </div>

            <!-- Match Card 4 -->
            <div class="match-card" data-status="results">
                <div class="match-meta">
                    <div class="match-date-str">Sun 19 Jul, 17:00</div>
                    <div class="match-group-str">Group A</div>
                </div>
                <div class="match-center">
                    <span class="team-name home">AL AHLY HC</span>
                    <div class="score-badge">26 : 27</div>
                    <span class="team-name away">SPORTING CLUB</span>
                </div>
                <div class="match-badge-wrap">
                    <span class="status-pill pill-fulltime">FULL TIME</span>
                </div>
            </div>

            <!-- Match Card 5 -->
            <div class="match-card" data-status="results">
                <div class="match-meta">
                    <div class="match-date-str">Wed 22 Jul, 18:00</div>
                    <div class="match-group-str">Group A</div>
                </div>
                <div class="match-center">
                    <span class="team-name home">AL AHLY HC</span>
                    <div class="score-badge">31 : 21</div>
                    <span class="team-name away">SMOUHA HC</span>
                </div>
                <div class="match-badge-wrap">
                    <span class="status-pill pill-fulltime">FULL TIME</span>
                </div>
            </div>

            <!-- Match Card 6 -->
            <div class="match-card" data-status="results">
                <div class="match-meta">
                    <div class="match-date-str">Sat 25 Jul, 19:00</div>
                    <div class="match-group-str">Group A</div>
                </div>
                <div class="match-center">
                    <span class="team-name home">SPORTING CLUB</span>
                    <div class="score-badge">25 : 28</div>
                    <span class="team-name away">SMOUHA HC</span>
                </div>
                <div class="match-badge-wrap">
                    <span class="status-pill pill-fulltime">FULL TIME</span>
                </div>
            </div>

            <!-- Match Card 7 -->
            <div class="match-card" data-status="results">
                <div class="match-meta">
                    <div class="match-date-str">Tue 28 Jul, 17:00</div>
                    <div class="match-group-str">Group B</div>
                </div>
                <div class="match-center">
                    <span class="team-name home">HELIOPOLIS</span>
                    <div class="score-badge">30 : 22</div>
                    <span class="team-name away">PORT SAID HC</span>
                </div>
                <div class="match-badge-wrap">
                    <span class="status-pill pill-fulltime">FULL TIME</span>
                </div>
            </div>

            <!-- Match Card 8 -->
            <div class="match-card" data-status="results">
                <div class="match-meta">
                    <div class="match-date-str">Tue 28 Jul, 18:00</div>
                    <div class="match-group-str">Group B</div>
                </div>
                <div class="match-center">
                    <span class="team-name home">HELIOPOLIS</span>
                    <div class="score-badge">24 : 29</div>
                    <span class="team-name away">ASWAN HC</span>
                </div>
                <div class="match-badge-wrap">
                    <span class="status-pill pill-fulltime">FULL TIME</span>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
