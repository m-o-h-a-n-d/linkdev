@extends('backend.layouts.app')

@section('title', 'Team Profile | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-shield-alt text-primary mr-2"></i>Team Profile & Analytics</h1>
    <a href="{{ route('admin.teams.edit') }}" class="btn btn-warning btn-sm"><i class="fas fa-edit mr-1"></i> Edit Team</a>
</div>

<!-- Team Banner -->
<div class="card shadow mb-4 border-left-danger">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="team-crest-large bg-danger mr-3 shadow">AHL</div>
            <div>
                <h2 class="h4 font-weight-bold text-gray-800 mb-1">Al Ahly Handball SC</h2>
                <div class="small text-muted">
                    <span class="badge badge-danger mr-1">Short Name: AHL</span>
                    <span class="badge badge-light border mr-1">Cairo, Egypt</span>
                    <span>Registered: Jan 15, 2025</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
