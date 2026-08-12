@extends('backend.layouts.app')

@section('title', 'Competition Details | Handball System')

@section('content')
    @php
        $statusClass = match ($competition->status) {
            'ongoing' => 'badge-success',
            'upcoming' => 'badge-info',
            'completed' => 'badge-secondary',
            'cancelled' => 'badge-danger',
            default => 'badge-light',
        };
    @endphp

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-trophy text-primary mr-2"></i>Competition Details
        </h1>
        <div class="d-flex align-items-center" style="gap: 8px;">
            <a href="{{ route('admin.competitions.edit', $competition->id) }}" class="btn btn-warning btn-sm shadow-sm"><i
                    class="fas fa-edit mr-1"></i> Edit Settings</a>
            <a href="{{ route('admin.competitions.index') }}" class="btn btn-secondary btn-sm"><i
                    class="fas fa-arrow-left mr-1"></i> Back to Competitions</a>
        </div>
    </div>

    <div class="card shadow mb-4 border-left-primary">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary text-white mr-3 p-3">
                            <i class="fas fa-trophy fa-2x"></i>
                        </div>
                        <div>
                            <h2 class="h4 font-weight-bold text-gray-800 mb-1">{{ $competition->name }}</h2>
                            <div class="small">
                                <span class="badge {{ $statusClass }} mr-1"><i
                                        class="fas fa-play mr-1"></i>{{ ucfirst($competition->status) }}</span>
                                <span class="badge badge-primary mr-1">Season {{ $competition->season }}</span>
                                <span class="text-muted ml-2"><i class="fas fa-calendar-alt mr-1"></i>
                                    {{ $competition->start_date?->format('M d, Y') }} -
                                    {{ $competition->end_date?->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">Competition Overview</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-gray-700">
                        {{ $competition->description ?: 'No description available for this competition.' }}
                    </p>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">Groups and Teams</h6>
                </div>
                <div class="card-body">
                    @if ($competition->groups->isNotEmpty())
                        @foreach ($competition->groups as $group)
                            <div class="mb-4 border rounded p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="m-0 font-weight-bold text-gray-800">{{ $group->name }}</h6>
                                    <span class="badge badge-info">Order #{{ $group->display_order }}</span>
                                </div>

                                @if ($group->teams->isNotEmpty())
                                    <div class="list-group">
                                        @foreach ($group->teams as $team)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $team->name }}</strong>
                                                    <div class="small text-muted">{{ $team->city }},
                                                        {{ $team->country }}</div>
                                                </div>
                                                <span class="badge badge-primary">{{ $team->short_name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-muted">No teams assigned to this group yet.</div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted">No groups created for this competition yet.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">Competition Info</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Slug</span>
                            <strong>{{ $competition->slug }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Season</span>
                            <strong>{{ $competition->season }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Status</span>
                            <strong>{{ ucfirst($competition->status) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Dates</span>
                            <strong>{{ $competition->start_date?->format('d M Y') }} -
                                {{ $competition->end_date?->format('d M Y') }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
