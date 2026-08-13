@extends('backend.layouts.app')

@section('title', 'Schedule Match | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-plus-circle text-primary mr-2"></i>Schedule New Match</h1>
    <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary btn-sm shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Matches</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Match Details Form</h6>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.matches.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Competition <span class="text-danger">*</span></label>
                    <select name="competition_id" class="form-control" required>
                        <option value="">-- Select Competition --</option>
                        @foreach($competitions as $comp)
                            <option value="{{ $comp->id }}" {{ old('competition_id') == $comp->id ? 'selected' : '' }}>
                                {{ $comp->name }} (Season {{ $comp->season }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Group Stage (Optional)</label>
                    <select name="group_id" class="form-control">
                        <option value="">-- Select Group (None for Knockout) --</option>
                        @foreach($groups as $grp)
                            <option value="{{ $grp->id }}" {{ old('group_id') == $grp->id ? 'selected' : '' }}>
                                {{ $grp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Home Team <span class="text-danger">*</span></label>
                    <select name="home_team_id" class="form-control" required>
                        <option value="">-- Select Home Team --</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ old('home_team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }} ({{ $team->short_name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Away Team <span class="text-danger">*</span></label>
                    <select name="away_team_id" class="form-control" required>
                        <option value="">-- Select Away Team --</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ old('away_team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }} ({{ $team->short_name }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Scheduled Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ old('scheduled_at', now()->addHours(2)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Round Number <span class="text-danger">*</span></label>
                    <input type="number" name="round_number" class="form-control" value="{{ old('round_number', 1) }}" min="1" required>
                </div>
            </div>

            <div class="form-group">
                <label class="font-weight-bold text-gray-700">Notes / Stadium Venue</label>
                <input type="text" name="notes" class="form-control" placeholder="e.g. Cairo Stadium Sports Hall" value="{{ old('notes') }}">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Create & Schedule Match</button>
            </div>
        </form>
    </div>
</div>
@endsection
