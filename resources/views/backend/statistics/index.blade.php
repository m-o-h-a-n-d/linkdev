@extends('backend.layouts.app')

@section('title', 'Team Statistics | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-chart-bar text-primary mr-2"></i>Competition Team Performance Analytics</h1>
</div>

<div class="row">
    <!-- Top Offense -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-fire mr-2"></i>Top Offensive Teams (Goals Scored)</h6>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">FC Barcelona <span class="float-right">348 Goals (33.0 / match)</span></h4>
                <div class="progress mb-4"><div class="progress-bar bg-primary" role="progressbar" style="width: 95%"></div></div>

                <h4 class="small font-weight-bold">Al Ahly SC <span class="float-right">312 Goals (31.2 / match)</span></h4>
                <div class="progress mb-4"><div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div></div>
            </div>
        </div>
    </div>

    <!-- Best Defense -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 bg-success text-white">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-shield-alt mr-2"></i>Best Defensive Teams (Lowest Conceded)</h6>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">THW Kiel <span class="float-right">220 Goals Conceded</span></h4>
                <div class="progress mb-4"><div class="progress-bar bg-success" role="progressbar" style="width: 90%"></div></div>
            </div>
        </div>
    </div>
</div>
@endsection
