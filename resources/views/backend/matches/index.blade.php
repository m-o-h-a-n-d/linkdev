@extends('backend.layouts.app')

@section('title', 'Match Fixtures & Results | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-running text-primary mr-2"></i>Match Fixtures & Results Table</h1>
    <div>
        <button type="button" class="btn btn-success btn-sm shadow-sm mr-1" data-toggle="modal" data-target="#generateFixturesModal">
            <i class="fas fa-magic mr-1"></i> Auto-Generate Fixtures
        </button>
        <a href="{{ route('admin.matches.create') }}" class="btn btn-primary btn-sm shadow-sm mr-1"><i class="fas fa-plus mr-1"></i> Schedule Match</a>
        <a href="{{ route('admin.matches.live-center') }}" class="btn btn-danger btn-sm shadow-sm"><i class="fas fa-broadcast-tower mr-1"></i> Live Score Engine</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Filters Bar -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.matches.index') }}" class="form-inline" id="matchesFilterForm">
            <label class="mr-2 font-weight-bold text-gray-700">Filter By:</label>
            <select name="competition_id" id="filter_competition_id" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                <option value="">All Competitions</option>
                @foreach($competitions as $comp)
                    <option value="{{ $comp->id }}" {{ request('competition_id') == $comp->id ? 'selected' : '' }}>
                        {{ $comp->name }}
                    </option>
                @endforeach
            </select>

            <select name="group_id" id="filter_group_id" class="form-control form-control-sm mr-2" onchange="this.form.submit()" style="{{ !request('competition_id') ? 'display: none;' : '' }}">
                <option value="">All Groups</option>
                @foreach($groups as $grp)
                    @if(!request('competition_id') || $grp->competition_id == request('competition_id'))
                        <option value="{{ $grp->id }}" {{ request('group_id') == $grp->id ? 'selected' : '' }}>
                            {{ $grp->name }}
                        </option>
                    @endif
                @endforeach
            </select>

            <select name="status" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="live" {{ request('status') == 'live' ? 'selected' : '' }}>Live</option>
                <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finished</option>
                <option value="postponed" {{ request('status') == 'postponed' ? 'selected' : '' }}>Postponed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-undo mr-1"></i> Reset</a>
        </form>
    </div>
</div>

<!-- Matches Table -->
<div class="card mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-gray-800">Matches Fixtures & Results</h6>
        <span class="badge badge-primary font-weight-bold">Total: {{ $matches->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Competition</th>
                        <th>Group / Round</th>
                        <th>Date & Time</th>
                        <th>Home Team</th>
                        <th class="text-center">Score</th>
                        <th>Away Team</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matches as $match)
                        @php
                            $badgeClass = match($match->status) {
                                'live' => 'badge-danger animated pulse infinite',
                                'finished' => 'badge-success',
                                'postponed' => 'badge-warning',
                                'cancelled' => 'badge-dark',
                                default => 'badge-info',
                            };
                        @endphp
                        <tr>
                            <td class="font-weight-bold text-gray-800">{{ $match->competition->name ?? 'N/A' }}</td>
                            <td class="text-muted">
                                {{ $match->group->name ?? 'Round ' . $match->round_number }}
                            </td>
                            <td class="text-muted">
                                {{ $match->scheduled_at ? $match->scheduled_at->format('M d, Y • H:i') : 'TBD' }}
                            </td>
                            <td class="font-weight-bold text-primary">{{ $match->homeTeam->name ?? 'TBD' }}</td>
                            <td class="text-center">
                                <span class="badge badge-dark font-weight-bold px-3 py-2" style="font-size: 0.95rem;">
                                    {{ $match->home_score }} - {{ $match->away_score }}
                                </span>
                            </td>
                            <td class="font-weight-bold text-gray-800">{{ $match->awayTeam->name ?? 'TBD' }}</td>
                            <td>
                                <span class="badge {{ $badgeClass }} text-uppercase px-2 py-1">
                                    {{ $match->status }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                    <a class="btn btn-info btn-sm" href="{{ route('admin.matches.show', $match->id) }}"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-warning btn-sm" href="{{ route('admin.matches.edit', $match->id) }}"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.matches.destroy', $match->id) }}" method="POST" onsubmit="return confirm('Delete this match?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle mr-1"></i> No matches found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($matches->hasPages())
        <div class="card-footer">
            {{ $matches->links() }}
        </div>
    @endif
</div>

<!-- Modal for Auto-generating Fixtures -->
<div class="modal fade" id="generateFixturesModal" tabindex="-1" role="dialog" aria-labelledby="generateFixturesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('admin.matches.generate-fixtures') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="generateFixturesModalLabel"><i class="fas fa-magic mr-1"></i> Auto-Generate Group Fixtures</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Select a competition group to generate Round-Robin match fixtures automatically for all assigned teams.</p>
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Select Group:</label>
                        <select name="group_id" class="form-control" required>
                            <option value="">-- Choose Competition Group --</option>
                            @foreach($groups as $grp)
                                <option value="{{ $grp->id }}">{{ $grp->competition->name ?? '' }} - {{ $grp->name }} ({{ $grp->teams_count ?? count($grp->teams) }} Teams)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-play mr-1"></i> Generate Fixtures</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
