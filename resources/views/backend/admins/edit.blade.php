@extends('backend.layouts.app')

@section('title', 'Edit Admin Profile | Handball System')

@section('content')
<!-- Page Header & Breadcrumb -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Edit Profile & Settings</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}" class="text-muted"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}" class="text-muted">Admins List</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Edit {{ $admin->name }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.admins.show', $admin->id) }}" class="btn btn-outline-info btn-sm rounded-pill font-weight-bold px-3 mr-2">
            <i class="fas fa-eye mr-1"></i> View Profile
        </a>
        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold px-3">
            <i class="fas fa-arrow-left mr-1"></i> Back to Admins Directory
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-lg border-0 shadow-sm mb-4" role="alert">
        <strong class="d-block mb-1"><i class="fas fa-exclamation-triangle mr-2"></i>Please correct the following errors:</strong>
        <ul class="mb-0 pl-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@php
    $avatarUrl = asset('assets/img/avatar-placeholder.png');
    if (!empty($admin->admin?->image) && $admin->admin->image !== 'defaults/avatar.png') {
        $avatarUrl = filter_var($admin->admin->image, FILTER_VALIDATE_URL)
            ? $admin->admin->image
            : asset('storage/' . $admin->admin->image);
    }
    $currentRole = $admin->roles->first()?->name;
@endphp

<div class="row">

    <!-- LEFT COLUMN: PROFILE PREVIEW CARD -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
            <div class="admin-card-header admin-card-header-gradient-1"></div>
            <div class="text-center" style="margin-top: -50px;">
                <div class="d-inline-block position-relative">
                    <img src="{{ $avatarUrl }}" alt="{{ $admin->name }}" class="admin-avatar-circle" id="previewAvatarImg" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                <div class="p-3">
                    <h5 class="font-weight-bold text-dark mb-1" id="previewName">{{ $admin->name }}</h5>
                    <p class="text-muted small mb-3" id="previewEmail">{{ $admin->email }}</p>

                    <div class="dropdown-divider mb-3"></div>

                    <!-- Personal Info List -->
                    <div class="text-left small">
                        <h6 class="font-weight-bold text-gray-800 mb-3">Admin Info</h6>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Full Name</div>
                            <div class="col-7 text-dark font-weight-bold" id="previewInfoName">: {{ $admin->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Email</div>
                            <div class="col-7 text-dark" id="previewInfoEmail" style="word-break: break-all;">: {{ $admin->email }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Phone Number</div>
                            <div class="col-7 text-dark" id="previewInfoPhone">: {{ $admin->admin?->phone ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">National ID</div>
                            <div class="col-7 text-dark" id="previewInfoNationalId">: {{ $admin->admin?->national_id ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Gender</div>
                            <div class="col-7 text-dark" id="previewInfoGender">: {{ $admin->admin?->gender ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Status</div>
                            <div class="col-7 text-dark" id="previewInfoStatus">: {{ ucfirst($admin->admin?->status ?? 'active') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Role</div>
                            <div class="col-7 text-dark" id="previewInfoRole">: {{ $currentRole ? ucfirst($currentRole) : 'Not Assigned' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Address</div>
                            <div class="col-7 text-dark" id="previewInfoAddress">: {{ $admin->admin?->address ?? 'N/A' }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: EDIT PROFILE FORM -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <ul class="nav profile-nav-tabs" id="profileTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="edit-profile-tab" data-toggle="tab" href="#editProfile" role="tab">Edit Profile</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content" id="profileTabContent">

                    <!-- TAB 1: EDIT PROFILE -->
                    <div class="tab-pane fade show active" id="editProfile" role="tabpanel">
                        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data" id="editProfileForm">
                            @csrf
                            @method('PUT')

                            <!-- Profile Image Upload Circle -->
                            <div class="mb-4 text-center text-md-left">
                                <label class="font-weight-bold small text-gray-700 d-block mb-2">Profile Image</label>
                                <div class="d-inline-flex align-items-center">
                                    <div class="avatar-upload-container mr-3 position-relative">
                                        <div class="avatar-upload-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border-radius: 50%; background: #f8fafc; border: 2px solid #e2e8f0;">
                                            <img src="{{ $avatarUrl }}" alt="{{ $admin->name }}" id="formAvatarImg" class="w-100 h-100" style="object-fit: cover;">
                                        </div>
                                        <label for="editImageUploadInput" class="avatar-upload-icon m-0 position-absolute" style="bottom: 0; right: 0; background: #ea580c; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Change Photo">
                                            <i class="fas fa-camera small"></i>
                                        </label>
                                        <input type="file" name="image" id="editImageUploadInput" accept="image/*" class="d-none">
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold rounded-pill px-3" onclick="document.getElementById('editImageUploadInput').click();">
                                            Change Photo
                                        </button>
                                        <div class="text-muted small mt-1">Allowed JPG, PNG, WEBP. Max size 2MB</div>
                                        @error('image')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Full Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="editName" class="font-weight-bold small text-gray-700">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror" id="editName" value="{{ old('name', $admin->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email Address -->
                                <div class="col-md-6 mb-3">
                                    <label for="editEmail" class="font-weight-bold small text-gray-700">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control form-control-custom @error('email') is-invalid @enderror" id="editEmail" value="{{ old('email', $admin->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="editPhone" class="font-weight-bold small text-gray-700">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control form-control-custom @error('phone') is-invalid @enderror" id="editPhone" value="{{ old('phone', $admin->admin?->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- National ID -->
                                <div class="col-md-6 mb-3">
                                    <label for="editNationalId" class="font-weight-bold small text-gray-700">National ID <span class="text-danger">*</span></label>
                                    <input type="number" name="national_id" class="form-control form-control-custom @error('national_id') is-invalid @enderror" id="editNationalId" value="{{ old('national_id', $admin->admin?->national_id) }}" required>
                                    @error('national_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div class="col-md-6 mb-3">
                                    <label for="editGender" class="font-weight-bold small text-gray-700">Gender <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-control form-control-custom @error('gender') is-invalid @enderror" id="editGender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('gender', $admin->admin?->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $admin->admin?->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label for="editStatus" class="font-weight-bold small text-gray-700">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control form-control-custom @error('status') is-invalid @enderror" id="editStatus" required>
                                        <option value="active" {{ old('status', $admin->admin?->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $admin->admin?->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="banned" {{ old('status', $admin->admin?->status) == 'banned' ? 'selected' : '' }}>Banned</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Role -->
                                <div class="col-md-6 mb-3">
                                    <label for="editRole" class="font-weight-bold small text-gray-700">Role</label>
                                    <select name="role" class="form-control form-control-custom @error('role') is-invalid @enderror" id="editRole">
                                        <option value="">Select Role (Optional)</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ old('role', $currentRole) == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-md-6 mb-3">
                                    <label for="editAddress" class="font-weight-bold small text-gray-700">Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control form-control-custom @error('address') is-invalid @enderror" id="editAddress" value="{{ old('address', $admin->admin?->address) }}" required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- New Password (Optional) -->
                                <div class="col-md-6 mb-3">
                                    <label for="editPassword" class="font-weight-bold small text-gray-700">New Password <span class="text-muted font-weight-normal">(Leave blank to keep unchanged)</span></label>
                                    <input type="password" name="password" class="form-control form-control-custom @error('password') is-invalid @enderror" id="editPassword" placeholder="Minimum 8 characters">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm New Password -->
                                <div class="col-md-6 mb-3">
                                    <label for="editPasswordConfirmation" class="font-weight-bold small text-gray-700">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control form-control-custom" id="editPasswordConfirmation" placeholder="Re-enter new password">
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.admins.index') }}" class="btn btn-light rounded-pill px-4 mr-2 font-weight-bold">Cancel</a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold" style="background: #ea580c; border: none;">
                                    <i class="fas fa-save mr-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editName = document.getElementById('editName');
    const editEmail = document.getElementById('editEmail');
    const editPhone = document.getElementById('editPhone');
    const editNationalId = document.getElementById('editNationalId');
    const editGender = document.getElementById('editGender');
    const editStatus = document.getElementById('editStatus');
    const editRole = document.getElementById('editRole');
    const editAddress = document.getElementById('editAddress');
    const editImageUploadInput = document.getElementById('editImageUploadInput');

    const previewName = document.getElementById('previewName');
    const previewEmail = document.getElementById('previewEmail');
    const previewInfoName = document.getElementById('previewInfoName');
    const previewInfoEmail = document.getElementById('previewInfoEmail');
    const previewInfoPhone = document.getElementById('previewInfoPhone');
    const previewInfoNationalId = document.getElementById('previewInfoNationalId');
    const previewInfoGender = document.getElementById('previewInfoGender');
    const previewInfoStatus = document.getElementById('previewInfoStatus');
    const previewInfoRole = document.getElementById('previewInfoRole');
    const previewInfoAddress = document.getElementById('previewInfoAddress');

    const previewAvatarImg = document.getElementById('previewAvatarImg');
    const formAvatarImg = document.getElementById('formAvatarImg');

    function updatePreview() {
        if (editName) {
            const val = editName.value.trim();
            previewName.textContent = val || 'Full Name';
            previewInfoName.textContent = ': ' + (val || 'Full Name');
        }
        if (editEmail) {
            const val = editEmail.value.trim();
            previewEmail.textContent = val || 'email@example.com';
            previewInfoEmail.textContent = ': ' + (val || 'email@example.com');
        }
        if (editPhone) {
            previewInfoPhone.textContent = ': ' + (editPhone.value.trim() || 'N/A');
        }
        if (editNationalId) {
            previewInfoNationalId.textContent = ': ' + (editNationalId.value.trim() || 'N/A');
        }
        if (editGender) {
            previewInfoGender.textContent = ': ' + (editGender.value || 'N/A');
        }
        if (editStatus) {
            previewInfoStatus.textContent = ': ' + (editStatus.value ? editStatus.value.charAt(0).toUpperCase() + editStatus.value.slice(1) : 'Active');
        }
        if (editRole) {
            previewInfoRole.textContent = ': ' + (editRole.value ? editRole.value.charAt(0).toUpperCase() + editRole.value.slice(1) : 'Not Assigned');
        }
        if (editAddress) {
            previewInfoAddress.textContent = ': ' + (editAddress.value.trim() || 'N/A');
        }
    }

    [editName, editEmail, editPhone, editNationalId, editAddress].forEach(el => {
        if (el) el.addEventListener('input', updatePreview);
    });

    [editGender, editStatus, editRole].forEach(el => {
        if (el) el.addEventListener('change', updatePreview);
    });

    if (editImageUploadInput) {
        editImageUploadInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (evt) {
                    if (previewAvatarImg) previewAvatarImg.src = evt.target.result;
                    if (formAvatarImg) formAvatarImg.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush
