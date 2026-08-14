@extends('backend.layouts.app')

@section('title', 'Dashboard | Handball Competition Management System')

@section('content')
    <!-- Page Heading Banner -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><i class="fas fa-chart-line text-primary mr-2"></i>Handball
                Competition Management Panel</h1>
            <p class="text-muted small mb-0">Overview of active handball leagues, live match scores, standings, and team
                statistics.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="{{ route('admin.matches.create') }}"
                class="d-none d-sm-inline-block btn btn-sm font-weight-bold shadow-sm mr-2 text-white"
                style="background: #ea580c; border: none;"><i class="fas fa-calendar-plus fa-sm text-white-50 mr-1"></i>
                Schedule Match</a>
            <a href="{{ route('admin.matches.live-center') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-danger font-weight-bold shadow-sm"><i
                    class="fas fa-broadcast-tower fa-sm text-white-50 mr-1"></i> Live Scoreboard</a>
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
                            <div class="h4 mb-1 font-weight-bold text-gray-800">{{ $competitions->count() }}</div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ongoing Competitions
                            </div>
                            <div class="h4 mb-1 font-weight-bold text-gray-800">
                                {{ $competitions->where('status', 'ongoing')->count() }}</div>
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
                            <div class="h4 mb-1 font-weight-bold text-gray-800">
                                {{ $competitions->where('status', 'upcoming')->count() }}</div>
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
                            <div class="h4 mb-1 font-weight-bold text-gray-800">{{ $teams->count() }}</div>
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
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between flex-wrap text-white"
                    style="background: #162238 !important; border-bottom: 1px solid #1e293b !important; gap: 10px;">
                    <h6 class="m-0 font-weight-bold text-white"><i
                            class="fas fa-broadcast-tower mr-2 text-danger animate-pulse"></i>Active Live Handball
                        Scoreboard</h6>

                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                        <form method="GET" class="m-0">
                            <select name="competition_id" class="form-control form-control-sm" onchange="this.form.submit()"
                                style="min-width: 170px; background: #fff; border: none; border-radius: 6px; color: #212529;">
                                @foreach ($competitions as $competition)
                                    <option value="{{ $competition->id }}"
                                        {{ (string) $selectedCompetitionId === (string) $competition->id ? 'selected' : '' }}>
                                        {{ $competition->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <a class="btn btn-sm font-weight-bold text-white" href="{{ route('admin.matches.live-center') }}"
                            style="background: #ea580c; border: none; border-radius: 8px;">Live Center <i
                                class="fas fa-chevron-right ml-1"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3 small text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Preview only: this panel shows the latest 2 live matches for the selected competition.
                    </div>
                    @if ($liveMatches->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-broadcast-tower fa-2x mb-3 d-block"></i>
                            <div class="font-weight-bold">No live or scheduled matches</div>
                            <small>There are no active games to display right now.</small>
                        </div>
                    @else
                        @foreach ($liveMatches->take(2) as $match)
                            <div class="p-3 mb-3 rounded" style="background: #070c14; border: 1px solid #1e293b;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge badge-primary">
                                        <i class="fas fa-trophy mr-1"></i>
                                        {{ $match->competition->name ?? 'Competition' }} •
                                        {{ $match->group->name ?? 'Match Group' }}
                                    </span>
                                    <span
                                        class="badge {{ $match->status === 'live' ? 'badge-danger animate-pulse' : 'badge-secondary' }}">
                                        {{ $match->status === 'live' ? $match->formatted_timer ?? 'LIVE' : ($match->scheduled_at ? $match->scheduled_at->format('H:i') : 'Scheduled') }}
                                    </span>
                                </div>

                                <div class="row align-items-center text-center my-2">
                                    <div class="col-4">
                                        <div class="p-1 rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 48px; height: 48px; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.15);">
                                            <span class="text-white font-weight-bold">
                                                {{ strtoupper(substr($match->homeTeam->name ?? 'Home', 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="font-weight-bold text-white">
                                            {{ $match->homeTeam->name ?? 'Home Team' }}</div>
                                        <span class="small text-muted">Home</span>
                                    </div>

                                    <div class="col-4">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="live-score-text text-white mr-2"
                                                style="font-size: 32px; font-weight: 800;">{{ $match->home_score }}</span>
                                            <span class="h4 text-muted mb-0">:</span>
                                            <span class="live-score-text text-white ml-2"
                                                style="font-size: 32px; font-weight: 800;">{{ $match->away_score }}</span>
                                        </div>
                                        <span class="badge badge-success mt-2"><i
                                                class="fas fa-bolt mr-1"></i>{{ $match->status === 'live' ? 'Live Action' : 'Scheduled' }}</span>
                                    </div>

                                    <div class="col-4">
                                        <div class="p-1 rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 48px; height: 48px; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.15);">
                                            <span class="text-white font-weight-bold">
                                                {{ strtoupper(substr($match->awayTeam->name ?? 'Away', 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="font-weight-bold text-white">
                                            {{ $match->awayTeam->name ?? 'Away Team' }}</div>
                                        <span class="small text-muted">Away</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center mt-3 pt-3"
                                    style="border-top: 1px solid #1e293b;">
                                    <a class="btn btn-secondary btn-sm" href="{{ route('admin.matches.live-center') }}">
                                        <i class="fas fa-eye mr-1"></i> Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Standings Widget -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">

                <!-- Header -->
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap"
                    style="
                background: #162238 !important;
                border-bottom: 1px solid #1e293b !important;
                padding: 15px 18px;
                gap: 10px;
             ">

                    <!-- Title -->
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-list-ol mr-2 text-info"></i>
                        {{ $selectedCompetition ? $selectedCompetition->name . ' Standings' : 'Competition Standings Preview' }}
                    </h6>

                    <!-- Actions -->
                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">

                        <!-- Competition Filter -->
                        <form method="GET" class="m-0">
                            <select name="competition_id" class="form-control form-control-sm"
                                onchange="this.form.submit()"
                                style="
                            min-width: 170px;
                            background: #ffffff;
                            border: none;
                            border-radius: 6px;
                            color: #212529;
                        ">
                                @foreach ($competitions as $competition)
                                    <option value="{{ $competition->id }}"
                                        {{ (string) $selectedCompetitionId === (string) $competition->id ? 'selected' : '' }}>
                                        {{ $competition->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <!-- View All -->
                        <a href="{{ route('admin.standings.index') }}" class="btn btn-sm font-weight-bold text-white"
                            style="
                        background: #ea580c;
                        border: none;
                        border-radius: 6px;
                        padding: 6px 12px;
                        white-space: nowrap;
                    ">
                            View All
                            <i class="fas fa-chevron-right ml-1"></i>
                        </a>

                    </div>
                </div>

                <!-- Body -->
                <div class="card-body p-0">

                    <div class="px-3 pt-3 small text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Preview only: this table shows the first 4 teams in the standings, not the full competition table.
                    </div>

                    @if ($teamStatistics->isEmpty())

                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-info-circle fa-2x mb-3 d-block"></i>

                            <div class="font-weight-bold">
                                No standings available
                            </div>

                            <small>
                                Select a competition to view standings.
                            </small>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table mb-0 standings-table">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Team</th>
                                        <th>P</th>
                                        <th>W</th>
                                        <th>D</th>
                                        <th>L</th>
                                        <th>GF</th>
                                        <th>GA</th>
                                        <th>GD</th>
                                        <th>Pts</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($teamStatistics as $index => $team)
                                        <tr>

                                            <td class="font-weight-bold">
                                                {{ $index + 1 }}
                                            </td>

                                            <td class="team-name">
                                                {{ $team->team?->name ?? 'Unknown Team' }}
                                            </td>

                                            <td>{{ $team->matches_played }}</td>
                                            <td>{{ $team->wins }}</td>
                                            <td>{{ $team->draws }}</td>
                                            <td>{{ $team->losses }}</td>
                                            <td>{{ $team->goals_for }}</td>
                                            <td>{{ $team->goals_against }}</td>
                                            <td
                                                class="{{ $team->goal_difference >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                                                {{ $team->goal_difference > 0 ? '+' : '' }}{{ $team->goal_difference }}
                                            </td>
                                            <td class="font-weight-bold points">
                                                {{ $team->points }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    @endif

                </div>
            </div>
        </div>

    </div>
@endsection
