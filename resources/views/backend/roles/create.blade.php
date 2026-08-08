@extends('backend.layouts.app')

@section('title', 'Create Role & Permissions | Handball System')

@section('content')
<!-- Page Header & Breadcrumb -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><i class="fas fa-plus-circle text-primary mr-2"></i>Create New Role & Assign Permissions</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}" class="text-muted"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}" class="text-muted">Roles Directory</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Create Role</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold px-3">
        <i class="fas fa-arrow-left mr-1"></i> Back to Roles Directory
    </a>
</div>

<form action="{{ route('admin.roles.index') }}" method="GET" id="createRoleForm">

    <!-- ROLE BASIC INFORMATION CARD -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-id-card mr-2"></i>Role Basic Details</h6>
        </div>
        <div class="card-body p-4">
            <div class="form-row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold small text-gray-800">Role Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom" placeholder="e.g. Competition Manager" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold small text-gray-800">Role Slug / Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom" placeholder="e.g. competition-manager" required>
                </div>
            </div>
            <div class="form-group mb-0">
                <label class="font-weight-bold small text-gray-800">Role Description</label>
                <textarea class="form-control form-control-custom" rows="2" placeholder="Describe the responsibilities and access scope of this role..."></textarea>
            </div>
        </div>
    </div>

    <!-- PERMISSIONS SELECTOR MATRIX -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-key mr-2"></i>Assign Module Permissions</h6>
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
                        <input type="checkbox" class="custom-control-input select-module-all" id="moduleCompAll">
                        <label class="custom-control-label font-weight-bold text-muted small" for="moduleCompAll">Select Module All</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-comp" id="perm_comp_view" checked>
                            <label class="custom-control-label font-weight-bold small" for="perm_comp_view">View Competitions</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-comp" id="perm_comp_create">
                            <label class="custom-control-label font-weight-bold small" for="perm_comp_create">Create Competition</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-comp" id="perm_comp_edit">
                            <label class="custom-control-label font-weight-bold small" for="perm_comp_edit">Edit Competition</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-comp" id="perm_comp_delete">
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
                        <input type="checkbox" class="custom-control-input select-module-all" id="moduleMatchesAll">
                        <label class="custom-control-label font-weight-bold text-muted small" for="moduleMatchesAll">Select Module All</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-matches" id="perm_match_view" checked>
                            <label class="custom-control-label font-weight-bold small" for="perm_match_view">View Matches</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-matches" id="perm_match_schedule">
                            <label class="custom-control-label font-weight-bold small" for="perm_match_schedule">Schedule Matches</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-matches" id="perm_match_live">
                            <label class="custom-control-label font-weight-bold small text-danger" for="perm_match_live">Operate Live Center</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-matches" id="perm_match_score">
                            <label class="custom-control-label font-weight-bold small" for="perm_match_score">Edit Scores & Results</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODULE 3: TEAMS & CLUBS -->
            <div class="permission-module-box mb-4 p-3 bg-light rounded-lg border">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div class="font-weight-bold text-success h6 mb-0">
                        <i class="fas fa-shield-alt mr-2"></i>Teams & Clubs Management
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input select-module-all" id="moduleTeamsAll">
                        <label class="custom-control-label font-weight-bold text-muted small" for="moduleTeamsAll">Select Module All</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-teams" id="perm_team_view" checked>
                            <label class="custom-control-label font-weight-bold small" for="perm_team_view">View Teams</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-teams" id="perm_team_create">
                            <label class="custom-control-label font-weight-bold small" for="perm_team_create">Register Team</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-teams" id="perm_team_edit">
                            <label class="custom-control-label font-weight-bold small" for="perm_team_edit">Edit Team Details</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-teams" id="perm_team_delete">
                            <label class="custom-control-label font-weight-bold small text-danger" for="perm_team_delete">Delete Team</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODULE 4: ADMINS & REFEREES -->
            <div class="permission-module-box mb-4 p-3 bg-light rounded-lg border">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div class="font-weight-bold text-warning h6 mb-0">
                        <i class="fas fa-user-tie mr-2"></i>Admins & Match Officials
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input select-module-all" id="moduleAdminAll">
                        <label class="custom-control-label font-weight-bold text-muted small" for="moduleAdminAll">Select Module All</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-admin" id="perm_admin_view" checked>
                            <label class="custom-control-label font-weight-bold small" for="perm_admin_view">View Admins Directory</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-admin" id="perm_admin_create">
                            <label class="custom-control-label font-weight-bold small" for="perm_admin_create">Register Admin</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-admin" id="perm_admin_edit">
                            <label class="custom-control-label font-weight-bold small" for="perm_admin_edit">Edit Admin Profile</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-admin" id="perm_admin_delete">
                            <label class="custom-control-label font-weight-bold small text-danger" for="perm_admin_delete">Delete Admin Member</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODULE 5: SYSTEM USERS & ROLES -->
            <div class="permission-module-box p-3 bg-light rounded-lg border">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div class="font-weight-bold text-dark h6 mb-0">
                        <i class="fas fa-user-shield mr-2"></i>Users & Roles Administration
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input select-module-all" id="moduleUsersAll">
                        <label class="custom-control-label font-weight-bold text-muted small" for="moduleUsersAll">Select Module All</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-users" id="perm_users_view">
                            <label class="custom-control-label font-weight-bold small" for="perm_users_view">View Users & Roles</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-users" id="perm_users_manage">
                            <label class="custom-control-label font-weight-bold small" for="perm_users_manage">Manage Roles</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input perm-check module-users" id="perm_users_logs">
                            <label class="custom-control-label font-weight-bold small" for="perm_users_logs">View Activity Logs</label>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-light rounded-pill font-weight-bold px-4 mr-2">Cancel</a>
            <button type="submit" class="btn btn-primary rounded-pill font-weight-bold px-4">
                <i class="fas fa-save mr-1"></i> Save & Assign Role
            </button>
        </div>
    </div>

</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Select / Deselect All
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deselectAllBtn = document.getElementById('deselectAllBtn');
    const allCheckboxes = document.querySelectorAll('.perm-check');

    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            allCheckboxes.forEach(cb => cb.checked = true);
            document.querySelectorAll('.select-module-all').forEach(cb => cb.checked = true);
        });
    }

    if (deselectAllBtn) {
        deselectAllBtn.addEventListener('click', function() {
            allCheckboxes.forEach(cb => cb.checked = false);
            document.querySelectorAll('.select-module-all').forEach(cb => cb.checked = false);
        });
    }

    // Module Select All toggles
    document.querySelectorAll('.select-module-all').forEach(moduleHeaderCb => {
        moduleHeaderCb.addEventListener('change', function() {
            const moduleBox = this.closest('.permission-module-box');
            if (moduleBox) {
                moduleBox.querySelectorAll('.perm-check').forEach(cb => {
                    cb.checked = this.checked;
                });
            }
        });
    });
});
</script>
@endpush
