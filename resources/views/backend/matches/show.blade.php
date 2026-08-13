@extends('backend.layouts.app')

@section('title', 'Match Details | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-eye text-primary mr-2"></i>Match Details</h1>
    <div>
        <a href="{{ route('admin.matches.edit', $match->id) }}" class="btn btn-warning btn-sm shadow-sm mr-1"><i class="fas fa-edit mr-1"></i> Edit Match</a>
        <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary btn-sm shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Matches</a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">{{ $match->competition->name ?? 'Competition' }} - {{ $match->group->name ?? 'Round ' . $match->round_number }}</h6>
        <span class="badge badge-dark px-3 py-2 text-uppercase">{{ $match->status }}</span>
    </div>
    <div class="card-body">
        <div class="row align-items-center text-center my-4">
            <div class="col-md-5">
                <h3 class="font-weight-bold text-gray-900">{{ $match->homeTeam->name ?? 'TBD' }}</h3>
                <span class="badge badge-primary font-weight-bold">HOME TEAM</span>
            </div>
            <div class="col-md-2 my-3 my-md-0">
                <div class="display-4 font-weight-bold text-danger">{{ $match->home_score }} - {{ $match->away_score }}</div>
                <div class="small text-muted font-weight-bold mt-1">
                    Scheduled: {{ $match->scheduled_at ? $match->scheduled_at->format('M d, Y H:i') : 'TBD' }}
                </div>
            </div>
            <div class="col-md-5">
                <h3 class="font-weight-bold text-gray-900">{{ $match->awayTeam->name ?? 'TBD' }}</h3>
                <span class="badge badge-secondary font-weight-bold">AWAY TEAM</span>
            </div>
        </div>

        <hr>

        <div class="row text-muted">
            <div class="col-md-4">
                <strong>Venue / Notes:</strong> {{ $match->notes ?? 'Cairo Indoor Sports Hall' }}
            </div>
            <div class="col-md-4">
                <strong>Started At:</strong> {{ $match->started_at ? $match->started_at->format('H:i:s') : 'N/A' }}
            </div>
            <div class="col-md-4">
                <strong>Winner:</strong> {{ $match->winnerTeam->name ?? 'None / Draw' }}
            </div>
        </div>
    </div>
</div>
@endsection
