@extends('backend.layouts.app')

@section('title', 'Edit Match | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-edit text-warning mr-2"></i>Edit Match Fixture & Score</h1>
    <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Matches</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-warning text-dark">
        <h6 class="m-0 font-weight-bold">Edit Match #24 - Al Ahly vs Zamalek</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.matches.index') }}" method="GET">
            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold">Home Team Score</label>
                    <input class="form-control" type="number" value="28">
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold">Away Team Score</label>
                    <input class="form-control" type="number" value="26">
                </div>
            </div>
            <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-sync-alt mr-1"></i> Update Match Result</button>
            <a href="{{ route('admin.matches.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
