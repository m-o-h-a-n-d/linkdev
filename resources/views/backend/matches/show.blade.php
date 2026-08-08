@extends('backend.layouts.app')

@section('title', 'Match Details | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-eye text-primary mr-2"></i>Match Details</h1>
    <a href="{{ route('admin.matches.edit') }}" class="btn btn-warning btn-sm"><i class="fas fa-edit mr-1"></i> Edit Match</a>
</div>

<div class="card shadow mb-4 border-left-primary">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge badge-primary"><i class="fas fa-trophy mr-1"></i>Egyptian Premier League • Group A</span>
            <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Finished</span>
        </div>
        <div class="row align-items-center text-center my-3">
            <div class="col-md-5">
                <h2 class="font-weight-bold text-primary mb-1">Al Ahly SC</h2>
                <span class="badge badge-success">WINNER</span>
            </div>
            <div class="col-md-2">
                <h1 class="font-weight-extrabold text-dark display-4">28 : 26</h1>
                <span class="small text-muted">Full Time</span>
            </div>
            <div class="col-md-5">
                <h2 class="font-weight-bold text-danger mb-1">Sporting Club</h2>
            </div>
        </div>
    </div>
</div>
@endsection
