@extends('backend.layouts.app')

@section('title', 'Roles & Permissions Management | Handball System')

@push('styles')
    <style>
        .role-badge-title {
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            letter-spacing: 0.2px;
        }

        .custom-perm-badge {
            background-color: rgba(56, 189, 248, 0.1) !important;
            color: #38bdf8 !important;
            border: 1px solid rgba(56, 189, 248, 0.25) !important;
            border-radius: 8px !important;
            padding: 3px 10px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            margin: 3px !important;
            transition: all 0.2s ease;
        }

        .custom-perm-badge:hover {
            background-color: rgba(56, 189, 248, 0.2) !important;
            border-color: #38bdf8 !important;
            transform: translateY(-1px);
        }

        .custom-perm-badge-all {
            background: linear-gradient(135deg, rgba(234, 88, 12, 0.15) 0%, rgba(245, 158, 11, 0.15) 100%) !important;
            color: #f59e0b !important;
            border: 1px solid rgba(245, 158, 11, 0.35) !important;
            border-radius: 8px !important;
            padding: 5px 14px !important;
            font-size: 12.5px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .custom-perm-badge-more {
            background-color: rgba(148, 163, 184, 0.12) !important;
            color: #94a3b8 !important;
            border: 1px solid rgba(148, 163, 184, 0.25) !important;
            border-radius: 8px !important;
            padding: 3px 10px !important;
            font-size: 11.5px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            margin: 3px !important;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .custom-perm-badge-more:hover {
            background-color: rgba(148, 163, 184, 0.22) !important;
            color: #ffffff !important;
        }

        .perm-count-badge {
            background-color: rgba(234, 88, 12, 0.15) !important;
            color: #f97316 !important;
            border: 1px solid rgba(234, 88, 12, 0.3) !important;
            font-weight: 700;
            border-radius: 6px;
            padding: 2px 7px;
            font-size: 11px;
            margin-top: 3px;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <!-- Page Header & Control Bar -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><i class="fas fa-user-shield text-primary mr-2"></i>Roles &
                Permissions Directory</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted"><i
                                class="fas fa-home mr-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Roles & Permissions
                    </li>
                </ol>
            </nav>
        </div>
        @can('roles.create')
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary shadow-sm font-weight-bold px-4"
            style="border-radius: 10px;">
            <i class="fas fa-plus mr-2"></i>Create New Role
        </a>
        @endcan
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

    <!-- Roles Table Card -->
    <div class="card mb-4" style="border-radius: 16px;">
        <div class="card-header py-3 d-flex justify-content-between align-items-center"
            style="border-top-left-radius: 16px; border-top-right-radius: 16px; border-bottom: 1px solid #1e293b;">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-shield mr-2"></i>System Roles & Permissions Matrix</h6>
            <span class="badge badge-primary px-3 py-1 font-weight-bold" style="border-radius: 10px;">{{ count($roles) }} Defined Roles</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="rolesTable">
                    <thead>
                        <tr>
                            <th style="width: 240px; padding-left: 20px;">Role Name</th>
                            <th>Assigned Permissions</th>
                            <th class="text-right" style="width: 220px; padding-right: 20px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td class="align-middle" style="padding-left: 20px;">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3" style="width: 36px; height: 36px; border-radius: 10px; background: rgba(234, 88, 12, 0.12); display: flex; align-items: center; justify-content: center;">
                                            @if($role->name === 'super-admin')
                                                <i class="fas fa-crown text-warning"></i>
                                            @elseif($role->id === 2)
                                                <i class="fas fa-user-tie text-primary"></i>
                                            @else
                                                <i class="fas fa-shield-alt text-primary"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="role-badge-title">
                                                {{ $role->name }}
                                                @if($role->id === 2)
                                                    <span class="badge badge-secondary ml-1" style="font-size: 10px;">Default</span>
                                                @endif
                                            </div>
                                            <span class="perm-count-badge">{{ count($role->permissions) }} Permissions</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex flex-wrap align-items-center">
                                        @if($role->name === 'super-admin')
                                            <span class="custom-perm-badge-all">
                                                <i class="fas fa-crown"></i>
                                                <span>Full Super Admin Access (All Permissions Granted)</span>
                                            </span>
                                        @else
                                            @forelse ($role->permissions->take(4) as $perm)
                                                <span class="custom-perm-badge" title="{{ $perm->name }}">
                                                    <i class="fas fa-check-circle text-success" style="font-size: 11px;"></i>
                                                    <span>{{ ucwords(str_replace(['.', '-', '_'], ' ', $perm->name)) }}</span>
                                                </span>
                                            @empty
                                                <span class="badge badge-secondary py-1 px-3" style="border-radius: 12px;">No permissions assigned</span>
                                            @endforelse

                                            @if ($role->permissions->count() > 4)
                                                @php
                                                    $remainingPerms = $role->permissions->slice(4)->map(fn($p) => ucwords(str_replace(['.', '-', '_'], ' ', $p->name)))->implode(' &#10;• ');
                                                @endphp
                                                <span class="custom-perm-badge-more" data-toggle="tooltip" data-html="true" title="• {{ $remainingPerms }}">
                                                    <i class="fas fa-plus mr-1" style="font-size: 9px;"></i> {{ $role->permissions->count() - 4 }} More...
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td class="text-right align-middle text-nowrap" style="padding-right: 20px; white-space: nowrap;">
                                    <div class="d-inline-flex align-items-center justify-content-end" style="gap: 8px;">
                                        @if ($role->id === 1)
                                            <span class="badge px-3 py-2"
                                                style="background: rgba(148, 163, 184, 0.12); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.25); border-radius: 8px; font-weight: 600;">
                                                <i class="fas fa-lock mr-1"></i> Protected
                                            </span>
                                        @else
                                            @can('roles.edit')
                                            <a class="btn btn-sm btn-outline-warning font-weight-bold px-3 d-inline-flex align-items-center"
                                                style="border-radius: 8px;"
                                                href="{{ route('admin.roles.edit', $role->id) }}">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            @endcan

                                            @if ($role->id !== 2)
                                                @can('roles.delete')
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this role?');"
                                                    class="d-inline m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger font-weight-bold px-3 d-inline-flex align-items-center"
                                                        style="border-radius: 8px;">
                                                        <i class="fas fa-trash mr-1"></i> Delete
                                                    </button>
                                                </form>
                                                @endcan
                                            @endif
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
