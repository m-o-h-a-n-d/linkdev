@extends('backend.layouts.app')

@section('title', 'Dashboard | Handball Competition Management System')

@section('content')
<!-- Page Heading Banner -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><i class="fas fa-chart-line text-primary mr-2"></i>Handball Competition Management Panel</h1>
        <p class="text-muted small mb-0">Overview of active handball leagues, live match scores, standings, and team statistics.</p>
    </div>
    <div class="mt-3 mt-sm-0">
        <a href="{{ route('admin.matches.create') }}" class="d-none d-sm-inline-block btn btn-sm font-weight-bold shadow-sm mr-2 text-white" style="background: #ea580c; border: none;"><i class="fas fa-calendar-plus fa-sm text-white-50 mr-1"></i> Schedule Match</a>
        <a href="{{ route('admin.matches.live-center') }}" class="d-none d-sm-inline-block btn btn-sm btn-danger font-weight-bold shadow-sm"><i class="fas fa-broadcast-tower fa-sm text-white-50 mr-1"></i> Live Scoreboard</a>
    </div>
</div>

<!-- 4 COMPACT KPI CARDS (MATCHING LOGIN DESIGN SYSTEM) -->
<div class="row">

    <!-- 1. Total Competitions -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Competitions</div>
                        <div class="h4 mb-1 font-weight-bold text-gray-800">12</div>
                        <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>Active Leagues</span>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-trophy fa-2x text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Ongoing Competitions -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ongoing Competitions</div>
                        <div class="h4 mb-1 font-weight-bold text-gray-800">3</div>
                        <span class="badge badge-success"><i class="fas fa-play-circle mr-1"></i>In Progress</span>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-spinner fa-spin fa-2x text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Upcoming Competitions -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Upcoming Competitions</div>
                        <div class="h4 mb-1 font-weight-bold text-gray-800">4</div>
                        <span class="badge badge-info"><i class="fas fa-calendar-alt mr-1"></i>Starting Soon</span>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Registered Teams -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Registered Teams</div>
                        <div class="h4 mb-1 font-weight-bold text-gray-800">32</div>
                        <span class="badge badge-warning"><i class="fas fa-shield-alt mr-1"></i>Registered Clubs</span>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users-cog fa-2x text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- CONTENT ROW: LIVE SCOREBOARD & STANDINGS PREVIEW -->
<div class="row">

    <!-- Active Live Matches Card -->
    <div class="col-lg-7 mb-4">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-white" style="background: #162238 !important; border-bottom: 1px solid #1e293b !important;">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-broadcast-tower mr-2 text-danger animate-pulse"></i>Active Live Handball Scoreboard</h6>
                <a class="btn btn-sm font-weight-bold text-white" href="{{ route('admin.matches.live-center') }}" style="background: #ea580c; border: none; border-radius: 8px;">Live Center <i class="fas fa-chevron-right ml-1"></i></a>
            </div>
            <div class="card-body">
                <!-- Live Match 1 -->
                <div class="p-3 mb-3 rounded" style="background: #070c14; border: 1px solid #1e293b;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge badge-primary"><i class="fas fa-trophy mr-1"></i>Egyptian Premier League • Group A</span>
                        <span class="badge badge-danger animate-pulse">2nd Half - 48:15</span>
                    </div>
                    <div class="row align-items-center text-center my-2">
                        <div class="col-4">
                            <div class="p-1 rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.15);">
                                <img src="{{ asset('backend/img/ahly.svg') }}" alt="Al Ahly SC" style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                            <div class="font-weight-bold text-white">Al Ahly SC</div>
                            <span class="small text-muted">Egypt</span>
                        </div>
                        <div class="col-4">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="live-score-text text-white mr-2" id="homeScore1" style="font-size: 32px; font-weight: 800;">26</span>
                                <span class="h4 text-muted mb-0">:</span>
                                <span class="live-score-text text-white ml-2" id="awayScore1" style="font-size: 32px; font-weight: 800;">24</span>
                            </div>
                            <span class="badge badge-success mt-2"><i class="fas fa-bolt mr-1"></i>Live Action</span>
                        </div>
                        <div class="col-4">
                            <div class="p-1 rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.15);">
                                <img src="{{ asset('backend/img/zamalek.svg') }}" alt="Zamalek SC" style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                            <div class="font-weight-bold text-white">Zamalek SC</div>
                            <span class="small text-muted">Egypt</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3 pt-3" style="border-top: 1px solid #1e293b;">
                        <button class="btn btn-primary btn-sm mr-2 font-weight-bold" data-score-btn="homeScore1" data-action="plus" style="background: #ea580c; border-color: #ea580c;"><i class="fas fa-plus mr-1"></i> Goal Ahly</button>
                        <button class="btn btn-danger btn-sm mr-2 font-weight-bold" data-score-btn="awayScore1" data-action="plus"><i class="fas fa-plus mr-1"></i> Goal Zamalek</button>
                        <a class="btn btn-secondary btn-sm" href="{{ route('admin.matches.index') }}"><i class="fas fa-eye mr-1"></i> Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Standings Widget -->
    <div class="col-lg-5 mb-4">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list-ol text-warning mr-2"></i>EHF Champions League Standings</h6>
                <a href="{{ route('admin.standings.index') }}" class="small font-weight-bold text-primary">Full Table <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 small">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Team</th>
                                <th class="text-center">P</th>
                                <th class="text-center">W</th>
                                <th class="text-center">GD</th>
                                <th class="text-right">PTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="font-weight-bold">
                                <td>🥇 1</td>
                                <td><span class="badge badge-primary mr-1">BAR</span> FC Barcelona</td>
                                <td class="text-center">8</td>
                                <td class="text-center">7</td>
                                <td class="text-center text-success">+34</td>
                                <td class="text-right text-primary font-weight-bold">15</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
