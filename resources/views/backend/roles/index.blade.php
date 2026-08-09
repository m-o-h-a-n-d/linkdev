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

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Roles Overview KPI Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-primary shadow-sm h-100 py-2" style="border-radius: 14px;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total System Roles</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($roles) }} Defined Roles</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>
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
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="rolesTable">
                <thead>
                    <tr>
                        <th style="width: 240px;">Role Name</th>
                        <th>Assigned Permissions</th>
                        <th class="text-right" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td class="align-middle">
                                <div class="font-weight-bold text-dark mb-1" style="font-size: 14px;">
                                    <i class="fas fa-shield-alt text-primary mr-1.5"></i> {{ $role->name }}
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex flex-wrap" style="gap: 4px;">
                                    @forelse ($role->permissions as $perm)
                                        <span class="badge badge-info">{{ $perm->name }}</span>
                                    @empty
                                        <span class="badge badge-secondary">No permissions assigned</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="text-right align-middle">
                                <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                    <a class="btn btn-warning btn-sm" href="{{ route('admin.roles.edit', $role->id) }}"><i class="fas fa-edit mr-1"></i> Edit</a>
                                    @if ($role->name !== 'super-admin')
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash mr-1"></i> Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
