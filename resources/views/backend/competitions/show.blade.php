@extends('backend.layouts.app')

@section('title', 'Competition Details | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-trophy text-primary mr-2"></i>Competition Details</h1>
    <a href="{{ route('admin.competitions.edit') }}" class="btn btn-warning btn-sm shadow-sm"><i class="fas fa-edit mr-1"></i> Edit Settings</a>
</div>

<!-- Competition Header Banner -->
<div class="card shadow mb-4 border-left-primary">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-primary text-white mr-3 p-3">
                        <i class="fas fa-trophy fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 font-weight-bold text-gray-800 mb-1">EHF Champions League 2025/2026</h2>
                        <div class="small">
                            <span class="badge badge-success mr-1"><i class="fas fa-play mr-1"></i>Ongoing</span>
                            <span class="badge badge-primary mr-1">Season 2025/2026</span>
                            <span class="badge badge-info">Mixed Format</span>
                            <span class="text-muted ml-2"><i class="fas fa-calendar-alt mr-1"></i>Sep 15, 2025 - May 30, 2026</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
