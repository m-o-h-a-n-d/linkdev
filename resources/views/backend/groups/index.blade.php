@extends('backend.layouts.app')

@section('title', 'Groups Management | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-white font-weight-bold"><i class="fas fa-layer-group text-primary mr-2"></i>Groups Directory Table</h1>
    <a href="{{ route('admin.groups.create') }}" class="btn btn-primary btn-sm font-weight-bold shadow-sm" style="background: #ea580c; border: none;"><i class="fas fa-plus mr-1"></i> Add Group</a>
</div>

<!-- Groups Grid / Table -->
<div class="row">
    <!-- Group A -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-lg border-0" style="background: #0e1626; border-radius: 16px; border: 1px solid #1e293b;">
            <div class="card-header py-3 text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-layer-group mr-2"></i>Group A • EHF Champions League</h6>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.groups.edit') }}" class="btn btn-sm text-white font-weight-bold mr-2" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 8px;"><i class="fas fa-edit mr-1"></i> Edit</a>
                    <span class="badge font-weight-extrabold shadow-sm px-3 py-2" style="background: #ffffff !important; color: #0f172a !important; font-size: 0.82rem; border-radius: 20px;"><i class="fas fa-users mr-1"></i> 4 Teams</span>
                </div>
            </div>
            <div class="card-body p-3">
                <ul class="list-group list-group-flush mb-0" style="border-radius: 12px; overflow: hidden;">
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3" style="background: #070c14 !important; border-color: #1e293b !important;">
                        <div>
                            <span class="badge badge-primary mr-2">BAR</span>
                            <strong class="text-white">FC Barcelona</strong>
                            <span class="text-muted small ml-1">(Spain)</span>
                        </div>
                        <span class="badge badge-success"><i class="fas fa-medal mr-1"></i>Rank 1</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3" style="background: #0e1626 !important; border-color: #1e293b !important;">
                        <div>
                            <span class="badge badge-danger mr-2">VES</span>
                            <strong class="text-white">Veszprém HC</strong>
                            <span class="text-muted small ml-1">(Hungary)</span>
                        </div>
                        <span class="badge badge-success"><i class="fas fa-award mr-1"></i>Rank 2</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
