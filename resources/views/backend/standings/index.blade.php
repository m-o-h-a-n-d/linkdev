@extends('backend.layouts.app')

@section('title', 'Group Standings | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
        <i class="fas fa-list-ol text-primary mr-2"></i>Competition Group Standings
    </h1>
    <div>
        @can('matches.view')
        <a href="{{ route('admin.matches.index') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-running mr-1"></i> Match Fixtures
        </a>
        @endcan
    </div>
</div>

<!-- Competition Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.standings.index') }}" class="form-inline">
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

@if($groupStandings->isNotEmpty())
    @foreach($groupStandings as $groupName => $standings)
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-dark text-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-trophy mr-1"></i> {{ $groupName }} - Standings Table</h6>
                <span class="badge badge-warning text-dark font-weight-bold">Handball Points System (Win: 2pt, Draw: 1pt)</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 text-center">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-left"># Pos</th>
                                <th class="text-left">Team Name</th>
                                <th>P (Played)</th>
                                <th>W (Won)</th>
                                <th>D (Draw)</th>
                                <th>L (Lost)</th>
                                <th>GF (Goals For)</th>
                                <th>GA (Goals Against)</th>
                                <th>GD (Goal Diff)</th>
                                <th class="font-weight-bold text-primary">PTS (Points)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($standings as $standing)
                                @php
                                    $rankNum = $loop->iteration;
                                    $rowStyle = match($rankNum) {
                                        1 => 'background: rgba(245, 158, 11, 0.1); border-left: 3px solid #f59e0b;',
                                        2 => 'background: rgba(148, 163, 184, 0.1); border-left: 3px solid #94a3b8;',
                                        default => '',
                                    };
                                @endphp
                                <tr style="{{ $rowStyle }}">
                                    <td class="text-left font-weight-bold">
                                        @if($rankNum == 1)
                                            <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #f59e0b; border: 1px solid #f59e0b; padding: 6px 12px; border-radius: 20px; font-weight: 800;">1st 🥇</span>
                                        @elseif($rankNum == 2)
                                            <span class="badge" style="background: rgba(148, 163, 184, 0.2); color: #cbd5e1; border: 1px solid #94a3b8; padding: 6px 12px; border-radius: 20px; font-weight: 800;">2nd 🥈</span>
                                        @elseif($rankNum == 3)
                                            <span class="badge" style="background: rgba(180, 83, 9, 0.2); color: #d97706; border: 1px solid #b45309; padding: 6px 12px; border-radius: 20px; font-weight: 800;">3rd 🥉</span>
                                        @else
                                            <span class="badge" style="background: #1e293b; color: #94a3b8; border: 1px solid #334155; padding: 6px 12px; border-radius: 20px; font-weight: 700;">{{ $rankNum }}th</span>
                                        @endif
                                    </td>
                                    <td class="text-left font-weight-bold text-white">
                                        {{ $standing->team->name ?? 'Team' }} ({{ $standing->team->short_name ?? '' }})
                                    </td>
                                    <td>{{ $standing->played }}</td>
                                    <td class="text-success font-weight-bold">{{ $standing->won }}</td>
                                    <td class="text-warning font-weight-bold">{{ $standing->draw }}</td>
                                    <td class="text-danger font-weight-bold">{{ $standing->lost }}</td>
                                    <td>{{ $standing->goals_for }}</td>
                                    <td>{{ $standing->goals_against }}</td>
                                    <td class="font-weight-bold {{ $standing->goal_difference >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $standing->goal_difference > 0 ? '+' : '' }}{{ $standing->goal_difference }}
                                    </td>
                                    <td class="font-weight-extrabold text-primary" style="font-size: 1.1rem;">
                                        {{ $standing->points }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="card shadow p-5 text-center text-muted mb-4">
        <i class="fas fa-trophy fa-3x mb-3 text-gray-300"></i>
        <h5 class="font-weight-bold">No Group Standings Available</h5>
        <p>Standings will be calculated automatically once matches in the group are finished.</p>
    </div>
@endif
@endsection
