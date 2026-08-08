@extends('backend.layouts.app')

@section('title', 'Roles & Permissions Management | Handball System')

@section('content')
<!-- Page Header & Control Bar -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><i class="fas fa-user-shield text-primary mr-2"></i>Roles & Permissions Directory</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}" class="text-muted"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Roles & Permissions</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary shadow-sm font-weight-bold px-4" style="border-radius: 10px;">
        <i class="fas fa-plus mr-2"></i>Create New Role
    </a>
</div>

<!-- Roles Overview KPI Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-primary shadow-sm h-100 py-2" style="border-radius: 14px;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total System Roles</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">5 Defined Roles</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-success shadow-sm h-100 py-2" style="border-radius: 14px;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active System Permissions</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">24 System Modules</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-key fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Roles Table Card -->
<div class="card mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-gray-800"><i class="fas fa-user-shield text-primary mr-2"></i>System Roles Table</h6>
        <div class="input-group input-group-sm w-auto">
            <input type="text" class="form-control" placeholder="Search role..." data-handball-search="rolesTable">
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="rolesTable">
                <thead>
                    <tr>
                        <th style="width: 240px;">Role Name</th>
                        <th>Assigned Permissions Preview</th>
                        <th class="text-center" style="width: 130px;">Users Count</th>
                        <th class="text-right" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-middle">
                            <div class="font-weight-bold text-white mb-1" style="font-size: 14px;"><i class="fas fa-crown text-warning mr-1.5"></i> Super Administrator</div>
                            <div class="text-muted small">Full system access & control</div>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex flex-wrap" style="gap: 4px;">
                                <span class="badge badge-success">All Permissions (*)</span>
                                <span class="badge badge-info">System Settings</span>
                                <span class="badge badge-primary">User Management</span>
                            </div>
                        </td>
                        <td class="text-center align-middle"><span class="badge badge-primary">2 Users</span></td>
                        <td class="text-right align-middle">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.show') }}"><i class="fas fa-eye mr-1"></i> View</a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.roles.edit') }}"><i class="fas fa-edit mr-1"></i> Edit</a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="align-middle">
                            <div class="font-weight-bold text-white mb-1" style="font-size: 14px;"><i class="fas fa-trophy text-info mr-1.5"></i> Competition Manager</div>
                            <div class="text-muted small">Manages leagues & fixtures</div>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex flex-wrap" style="gap: 4px;">
                                <span class="badge badge-primary">Competitions (CRUD)</span>
                                <span class="badge badge-info">Matches (CRUD)</span>
                                <span class="badge badge-warning">Standings (Edit)</span>
                                <span class="badge badge-success">Live Center</span>
                            </div>
                        </td>
                        <td class="text-center align-middle"><span class="badge badge-info">5 Users</span></td>
                        <td class="text-right align-middle">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.show') }}"><i class="fas fa-eye mr-1"></i> View</a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.roles.edit') }}"><i class="fas fa-edit mr-1"></i> Edit</a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="align-middle">
                            <div class="font-weight-bold text-white mb-1" style="font-size: 14px;"><i class="fas fa-user-tie text-warning mr-1.5"></i> Referee Manager</div>
                            <div class="text-muted small">Assigns match officials</div>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex flex-wrap" style="gap: 4px;">
                                <span class="badge badge-info">Admins (CRUD)</span>
                                <span class="badge badge-secondary">Matches (View)</span>
                                <span class="badge badge-success">Match Reports</span>
                            </div>
                        </td>
                        <td class="text-center align-middle"><span class="badge badge-secondary">3 Users</span></td>
                        <td class="text-right align-middle">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.show') }}"><i class="fas fa-eye mr-1"></i> View</a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.roles.edit') }}"><i class="fas fa-edit mr-1"></i> Edit</a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="align-middle">
                            <div class="font-weight-bold text-white mb-1" style="font-size: 14px;"><i class="fas fa-shield-alt text-success mr-1.5"></i> Team Administrator</div>
                            <div class="text-muted small">Manages club rosters</div>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex flex-wrap" style="gap: 4px;">
                                <span class="badge badge-success">Teams (Edit)</span>
                                <span class="badge badge-secondary">Players (CRUD)</span>
                                <span class="badge badge-secondary">Fixtures (View)</span>
                            </div>
                        </td>
                        <td class="text-center align-middle"><span class="badge badge-success">12 Users</span></td>
                        <td class="text-right align-middle">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.show') }}"><i class="fas fa-eye mr-1"></i> View</a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.roles.edit') }}"><i class="fas fa-edit mr-1"></i> Edit</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
