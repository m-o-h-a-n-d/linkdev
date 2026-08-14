@extends('backend.layouts.app')

@section('title', 'Team Statistics | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
        <i class="fas fa-chart-bar text-primary mr-2"></i>Competition Team Performance & Statistics
    </h1>
    <div>
        <a href="{{ route('admin.standings.index') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-list-ol mr-1"></i> Group Standings
        </a>
    </div>
</div>

<!-- Competition Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.statistics.index') }}" class="form-inline">
            <label class="mr-2 font-weight-bold text-gray-700">Select Competition:</label>
            <select name="competition_id" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                @foreach($competitions as $comp)
                    <option value="{{ $comp->id }}" {{ $selectedCompetition?->id == $comp->id ? 'selected' : '' }}>
                        {{ $comp->name }} (Season {{ $comp->season }})
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

@php
    $topScoring = $teamStatistics->sortByDesc('goals_for')->first();
    $bestDefense = $teamStatistics->where('matches_played', '>', 0)->sortBy('goals_against')->first() ?? $teamStatistics->first();
@endphp

@if($teamStatistics->isNotEmpty() && $topScoring && $topScoring->goals_for > 0)
<div class="row mb-4">
    <!-- Top Offensive Team -->
    <div class="col-lg-6 mb-3">
        <div class="card shadow border-left-primary h-100 py-2" style="background: #0e1626; border: 1px solid #1e293b;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <i class="fas fa-fire mr-1 text-warning"></i> Best Offensive Attack
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-white">{{ $topScoring->team->name ?? 'N/A' }}</div>
                        <div class="small text-muted mt-1">
                            <strong>{{ $topScoring->goals_for }} Goals</strong> in {{ $topScoring->matches_played }} Matches 
                            ({{ $topScoring->matches_played > 0 ? number_format($topScoring->goals_for / $topScoring->matches_played, 1) : 0 }} goals/match)
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-futbol fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Best Defensive Team -->
    <div class="col-lg-6 mb-3">
        <div class="card shadow border-left-success h-100 py-2" style="background: #0e1626; border: 1px solid #1e293b;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            <i class="fas fa-shield-alt mr-1 text-success"></i> Solid Defense (Lowest Conceded)
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-white">{{ $bestDefense->team->name ?? 'N/A' }}</div>
                        <div class="small text-muted mt-1">
                            <strong>{{ $bestDefense->goals_against }} Conceded</strong> in {{ $bestDefense->matches_played }} Matches
                            ({{ $bestDefense->matches_played > 0 ? number_format($bestDefense->goals_against / $bestDefense->matches_played, 1) : 0 }} goals/match)
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shield-alt fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Overall Competition Team Statistics Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-dark text-white d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-chart-bar mr-1"></i> Overall Tournament Leaderboard (All Matches)
        </h6>
        <span class="badge badge-primary font-weight-bold px-3 py-1">{{ $teamStatistics->count() }} Teams</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0 text-center">
                <thead class="thead-light">
                    <tr>
                        <th class="text-left"># Rank</th>
                        <th class="text-left">Team Name</th>
                        <th>Matches Played</th>
                        <th>Wins</th>
                        <th>Draws</th>
                        <th>Losses</th>
                        <th>Goals For</th>
                        <th>Goals Against</th>
                        <th>Goal Difference</th>
                        <th class="text-primary font-weight-bold">Total Points</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teamStatistics as $stat)
                        <tr>
                            <td class="text-left font-weight-bold text-muted">
                                #{{ $loop->iteration }}
                            </td>
                            <td class="text-left font-weight-bold text-white">
                                {{ $stat->team->name ?? 'Team' }}
                                @if($stat->team?->short_name)
                                    <span class="badge badge-secondary ml-1">{{ $stat->team->short_name }}</span>
                                @endif
                            </td>
                            <td class="font-weight-bold">{{ $stat->matches_played }}</td>
                            <td class="text-success font-weight-bold">{{ $stat->wins }}</td>
                            <td class="text-warning font-weight-bold">{{ $stat->draws }}</td>
                            <td class="text-danger font-weight-bold">{{ $stat->losses }}</td>
                            <td>{{ $stat->goals_for }}</td>
                            <td>{{ $stat->goals_against }}</td>
                            <td class="font-weight-bold {{ $stat->goal_difference >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $stat->goal_difference > 0 ? '+' : '' }}{{ $stat->goal_difference }}
                            </td>
                            <td class="font-weight-extrabold text-primary" style="font-size: 1.1rem;">
                                {{ $stat->points }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-muted py-5 text-center">
                                <i class="fas fa-chart-bar fa-3x mb-3 text-gray-400"></i>
                                <p class="h6 mb-0 text-gray-300">No team statistics recorded for this competition yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
