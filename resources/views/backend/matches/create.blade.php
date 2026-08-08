@extends('backend.layouts.app')

@section('title', 'Schedule Match Fixture | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-calendar-plus text-primary mr-2"></i>Schedule Match Fixture</h1>
    <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Matches</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-info text-white">
        <h6 class="m-0 font-weight-bold text-white">Match Fixture Form</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.matches.index') }}" method="GET">
            <div class="form-group">
                <label class="font-weight-bold">Select Competition</label>
                <select class="form-control">
                    <option>Egyptian Premier League 2025/2026</option>
                    <option>EHF Champions League 2025/2026</option>
                </select>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold">Home Team</label>
                    <select class="form-control">
                        <option>Al Ahly SC</option>
                        <option>FC Barcelona</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold">Away Team</label>
                    <select class="form-control">
                        <option>Zamalek SC</option>
                        <option>PSG Handball</option>
                    </select>
                </div>
            </div>
            <div class="form-row mb-4">
                <div class="col-md-6">
                    <label class="font-weight-bold">Date & Time</label>
                    <input class="form-control" type="datetime-local" required>
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold">Round Number</label>
                    <input class="form-control" type="number" value="1" min="1">
                </div>
            </div>
            <button type="submit" class="btn btn-info text-white"><i class="fas fa-save mr-1"></i> Schedule Fixture</button>
            <a href="{{ route('admin.matches.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
