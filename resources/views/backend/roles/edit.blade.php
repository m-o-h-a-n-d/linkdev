@extends('backend.layouts.app')

@section('title', 'Edit Role & Permissions | Handball System')

@section('content')
<!-- Page Header & Breadcrumb -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><i class="fas fa-edit text-warning mr-2"></i>Edit Role & Update Permissions</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}" class="text-muted"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}" class="text-muted">Roles Directory</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Edit Role</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold px-3">
        <i class="fas fa-arrow-left mr-1"></i> Back to Roles Directory
    </a>
</div>

<form action="{{ route('admin.roles.index') }}" method="GET" id="editRoleForm">

    <!-- BASIC ROLE INFO CARD -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-header bg-warning text-dark py-3">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-id-card mr-2"></i>Edit Role: Competition Manager</h6>
        </div>
        <div class="card-body p-4">
            <div class="form-row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold small text-gray-800">Role Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom" value="Competition Manager" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold small text-gray-800">Role Key / Slug <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom" value="competition-manager" required>
                </div>
            </div>
            <div class="form-group mb-0">
                <label class="font-weight-bold small text-gray-800">Role Description</label>
                <textarea class="form-control form-control-custom" rows="2">Manages handball competitions, match scheduling, standings calculations, and live match control room operations.</textarea>
            </div>
        </div>
    </div>

    <!-- PERMISSIONS SELECTOR MATRIX -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-key mr-2"></i>Update Assigned Permissions</h6>
            <div>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill font-weight-bold px-3 mr-2" id="selectAllBtn">
                    <i class="fas fa-check-double mr-1"></i> Select All
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill font-weight-bold px-3" id="deselectAllBtn">
                    Deselect All
                </button>
            </div>
        </div>
        <div class="card-body p-4">

            <!-- MODULE 1: COMPETITIONS -->
            <div class="permission-module-box mb-4 p-3 bg-light rounded-lg border">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div class="font-weight-bold text-primary h6 mb-0">
                        <i class="fas fa-trophy mr-2"></i>Competitions Module
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input select-module-all" id="moduleCompAll" checked>
                        <label class="custom-control-label font-weight-bold text-muted small" for="moduleCompAll">Select Module All</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check" id="perm_comp_view" checked>
                            <label class="custom-control-label font-weight-bold small" for="perm_comp_view">View Competitions</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check" id="perm_comp_create" checked>
                            <label class="custom-control-label font-weight-bold small" for="perm_comp_create">Create Competition</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check" id="perm_comp_edit" checked>
                            <label class="custom-control-label font-weight-bold small" for="perm_comp_edit">Edit Competition</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check" id="perm_comp_delete" checked>
                            <label class="custom-control-label font-weight-bold small text-danger" for="perm_comp_delete">Delete Competition</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODULE 2: MATCHES & LIVE SCOREBOARD -->
            <div class="permission-module-box mb-4 p-3 bg-light rounded-lg border">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div class="font-weight-bold text-info h6 mb-0">
                        <i class="fas fa-running mr-2"></i>Matches & Live Scoreboard
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input select-module-all" id="moduleMatchesAll" checked>
                        <label class="custom-control-label font-weight-bold text-muted small" for="moduleMatchesAll">Select Module All</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check" id="perm_match_view" checked>
                            <label class="custom-control-label font-weight-bold small" for="perm_match_view">View Matches</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check" id="perm_match_schedule" checked>
                            <label class="custom-control-label font-weight-bold small" for="perm_match_schedule">Schedule Matches</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check" id="perm_match_live" checked>
                            <label class="custom-control-label font-weight-bold small text-danger" for="perm_match_live">Operate Live Center</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check" id="perm_match_score" checked>
                            <label class="custom-control-label font-weight-bold small" for="perm_match_score">Edit Scores & Results</label>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-light rounded-pill font-weight-bold px-4 mr-2">Cancel</a>
            <button type="submit" class="btn btn-warning rounded-pill font-weight-bold px-4 text-dark">
                <i class="fas fa-sync-alt mr-1"></i> Update Role & Permissions
            </button>
        </div>
    </div>

</form>
@endsection
