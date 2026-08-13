@extends('backend.layouts.app')

@section('title', 'Edit Match | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-edit text-warning mr-2"></i>Edit Match</h1>
    <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary btn-sm shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Matches</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-warning">Edit Match #{{ $match->id }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.matches.update', $match->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Home Team</label>
                    <input type="text" class="form-control" value="{{ $match->homeTeam->name ?? 'TBD' }}" readonly>
                </div>
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Away Team</label>
                    <input type="text" class="form-control" value="{{ $match->awayTeam->name ?? 'TBD' }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Home Score</label>
                    <input type="number" name="home_score" class="form-control" value="{{ old('home_score', $match->home_score) }}" min="0" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Away Score</label>
                    <input type="number" name="away_score" class="form-control" value="{{ old('away_score', $match->away_score) }}" min="0" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Match Status</label>
                    <select name="status" class="form-control" required>
                        <option value="scheduled" {{ $match->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="live" {{ $match->status === 'live' ? 'selected' : '' }}>Live</option>
                        <option value="finished" {{ $match->status === 'finished' ? 'selected' : '' }}>Finished</option>
                        <option value="postponed" {{ $match->status === 'postponed' ? 'selected' : '' }}>Postponed</option>
                        <option value="cancelled" {{ $match->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Scheduled Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ old('scheduled_at', $match->scheduled_at ? $match->scheduled_at->format('Y-m-d\TH:i') : '') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="font-weight-bold text-gray-700">Notes / Stadium Venue</label>
                <input type="text" name="notes" class="form-control" value="{{ old('notes', $match->notes) }}">
            </div>

            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update Match & Recalculate Standings</button>
        </form>
    </div>
</div>
@endsection
