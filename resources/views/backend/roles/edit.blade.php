@extends('backend.layouts.app')

@section('title', 'Edit Role & Permissions | Handball System')

@push('styles')
    <style>
        .permission-module-box {
            background-color: #0b1328 !important;
            border: 1px solid #1e293b !important;
            border-radius: 14px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .permission-card-item {
            background-color: #111c38 !important;
            border: 1px solid #1e293b !important;
            border-radius: 10px !important;
            padding: 10px 14px !important;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .permission-card-item:hover {
            border-color: #f97316 !important;
            background-color: #18264c !important;
            box-shadow: 0 4px 16px rgba(249, 115, 22, 0.2);
            transform: translateY(-2px);
        }

        .permission-label-text {
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            cursor: pointer !important;
        }

        .permission-code-text {
            color: #94a3b8 !important;
            font-weight: 500 !important;
            font-size: 11px !important;
            display: block !important;
            margin-top: 2px;
        }

        .module-header-title {
            color: #f97316 !important;
            font-weight: 700 !important;
            font-size: 16px !important;
        }

        .select-all-label {
            color: #cbd5e1 !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            cursor: pointer !important;
        }
    </style>
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><i class="fas fa-edit text-primary mr-2"></i>Edit Role &
                Permissions</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted"><i
                                class="fas fa-home mr-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}" class="text-muted">Roles
                            Directory</a></li>
                    <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Edit Role</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.roles.index') }}"
            class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold px-3">
            <i class="fas fa-arrow-left mr-1"></i> Back to Roles Directory
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" id="editRoleForm">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
            <div class="card-header bg-primary text-white py-3"
                style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-id-card mr-2"></i>Role Details</h6>
            </div>
            <div class="card-body p-4">
                <div class="form-group mb-0">
                    <label class="font-weight-bold small text-gray-800">Role Title / Name <span
                            class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $role->name) }}"
                        class="form-control form-control-custom @error('name') is-invalid @enderror" required>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
            <div class="card-header py-3 d-flex justify-content-between align-items-center"
                style="border-top-left-radius: 16px; border-top-right-radius: 16px; border-bottom: 1px solid #1e293b;">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-key mr-2"></i>Assign Module Permissions</h6>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill font-weight-bold px-3 mr-2"
                        id="selectAllBtn">
                        <i class="fas fa-check-double mr-1"></i> Select All
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill font-weight-bold px-3"
                        id="deselectAllBtn">
                        Deselect All
                    </button>
                </div>
            </div>
            <div class="card-body p-4">

                @foreach ($modules as $moduleKey => $moduleData)
                    <div class="permission-module-box mb-4 p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom"
                            style="border-color: #1e293b !important;">
                            <div class="module-header-title">
                                <i
                                    class="fas fa-shield-alt mr-2 text-warning"></i>{{ $moduleData['label'] ?? ucfirst($moduleKey) }}
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input select-module-all"
                                    id="module_{{ $moduleKey }}">
                                <label class="custom-control-label select-all-label" for="module_{{ $moduleKey }}">Select
                                    Module All</label>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($moduleData['permissions'] ?? [] as $permissionName)
                                <div class="col-md-3 mb-3">
                                    <div class="permission-card-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="permissions[]" value="{{ $permissionName }}"
                                                class="custom-control-input perm-check"
                                                id="perm_{{ Str::slug($permissionName) }}"
                                                {{ in_array($permissionName, $rolePermissions) ? 'checked' : '' }}>
                                            <label class="custom-control-label permission-label-text pl-1"
                                                for="perm_{{ Str::slug($permissionName) }}">
                                                {{ ucwords(str_replace(['-', '_'], ' ', Str::afterLast($permissionName, '.'))) }}
                                                <span class="permission-code-text">({{ $permissionName }})</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="card-footer py-3 border-top d-flex justify-content-end"
                style="background-color: #0e1626 !important; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; border-color: #1e293b !important;">
                <a href="{{ route('admin.roles.index') }}"
                    class="btn btn-light rounded-pill font-weight-bold px-4 mr-2">Cancel</a>
                <button type="submit" class="btn btn-primary rounded-pill font-weight-bold px-4">
                    <i class="fas fa-save mr-1"></i> Update Role
                </button>
            </div>
        </div>

    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
