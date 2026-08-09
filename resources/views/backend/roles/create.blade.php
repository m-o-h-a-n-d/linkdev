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

<form action="{{ route('admin.roles.store') }}" method="POST" id="createRoleForm">
    @csrf

    <!-- ROLE BASIC INFORMATION CARD -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-id-card mr-2"></i>Role Basic Details</h6>
        </div>
        <div class="card-body p-4">
            <div class="form-group mb-0">
                <label class="font-weight-bold small text-gray-800">Role Title / Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-custom @error('name') is-invalid @enderror" placeholder="e.g. competition-manager" required>
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

            @foreach ($modules as $moduleKey => $moduleData)
                <div class="permission-module-box mb-4 p-3 bg-light rounded-lg border">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <div class="font-weight-bold text-primary h6 mb-0">
                            <i class="fas fa-shield-alt mr-2"></i>{{ $moduleData['label'] ?? ucfirst($moduleKey) }}
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input select-module-all" id="module_{{ $moduleKey }}">
                            <label class="custom-control-label font-weight-bold text-muted small" for="module_{{ $moduleKey }}">Select Module All</label>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($moduleData['permissions'] ?? [] as $permKey => $permissionName)
                            <div class="col-md-3 mb-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="permissions[]" value="{{ $permissionName }}" class="custom-control-input perm-check" id="perm_{{ Str::slug($permissionName) }}">
                                    <label class="custom-control-label font-weight-bold small" for="perm_{{ Str::slug($permissionName) }}">
                                        {{ ucfirst(str_replace('_', ' ', $permKey)) }} ({{ $permissionName }})
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

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
