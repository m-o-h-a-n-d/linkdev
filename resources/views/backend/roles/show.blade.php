@extends('backend.layouts.app')

@section('title', 'Role Details & Permissions | Handball System')

@section('content')
    <!-- Page Header & Breadcrumb -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><i class="fas fa-user-shield text-primary mr-2"></i>Role
                Details & Permissions</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted"><i
                                class="fas fa-home mr-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}" class="text-muted">Roles
                            Directory</a></li>
                    <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Role Overview</li>
                </ol>
            </nav>
        </div>
        <div>
            @if (!in_array($role->name, $protectedRoleNames, true))
                @can('roles.edit')
                <a href="{{ route('admin.roles.edit', $role->id) }}"
                    class="btn btn-warning shadow-sm font-weight-bold px-3 mr-2" style="border-radius: 10px;">
                    <i class="fas fa-edit mr-1"></i> Edit Role
                </a>
                @endcan
            @endif
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary shadow-sm font-weight-bold px-3"
                style="border-radius: 10px;">
                <i class="fas fa-arrow-left mr-1"></i> Back to Roles
            </a>
        </div>
    </div>

    <!-- ROLE OVERVIEW BANNER CARD -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="icon-circle bg-primary text-white mr-3 p-3"
                    style="width: 60px; height: 60px; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-trophy fa-2x"></i>
                </div>
                <div>
                    <h3 class="font-weight-bold text-gray-900 mb-1">Competition Manager</h3>
                    <div class="small">
                        <code
                            class="bg-light text-primary px-2 py-1 rounded font-weight-bold mr-2">competition-manager</code>
                        <span class="badge badge-success px-3 py-1" style="border-radius: 12px;"><i
                                class="fas fa-users mr-1"></i> 5 Assigned System Users</span>
                    </div>
                </div>
            </div>
            <p class="text-muted small mt-3 mb-0 border-top pt-3">
                <strong>Scope & Description:</strong> Responsible for creating competitions, match fixtures, managing
                standings calculations, and controlling the live score engine.
            </p>
        </div>
    </div>

    <!-- ASSIGNED PERMISSIONS GRID -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-check-square mr-2"></i>Assigned Module
                Permissions Matrix</h6>
        </div>
        <div class="card-body p-4">
            <div class="row">

                <!-- Competitions -->
                <div class="col-md-6 mb-4">
                    <div class="p-3 bg-light rounded-lg border h-100">
                        <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-trophy mr-2"></i>Competitions Module
                        </h6>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2 text-success font-weight-bold"><i class="fas fa-check-circle mr-2"></i> View
                                Competitions</li>
                            <li class="mb-2 text-success font-weight-bold"><i class="fas fa-check-circle mr-2"></i> Create
                                Competitions</li>
                            <li class="mb-2 text-success font-weight-bold"><i class="fas fa-check-circle mr-2"></i> Edit
                                Competition Settings</li>
                            <li class="text-muted"><i class="fas fa-times-circle mr-2"></i> Delete Competitions</li>
                        </ul>
                    </div>
                </div>

                <!-- Matches -->
                <div class="col-md-6 mb-4">
                    <div class="p-3 bg-light rounded-lg border h-100">
                        <h6 class="font-weight-bold text-info mb-3"><i class="fas fa-running mr-2"></i>Matches & Live Center
                        </h6>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2 text-success font-weight-bold"><i class="fas fa-check-circle mr-2"></i> View
                                Match Fixtures</li>
                            <li class="mb-2 text-success font-weight-bold"><i class="fas fa-check-circle mr-2"></i> Schedule
                                New Fixtures</li>
                            <li class="mb-2 text-success font-weight-bold"><i class="fas fa-check-circle mr-2"></i> Control
                                Live Score Engine</li>
                            <li class="text-success font-weight-bold"><i class="fas fa-check-circle mr-2"></i> Edit Scores &
                                Results</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
