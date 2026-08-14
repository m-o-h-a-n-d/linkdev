@extends('backend.layouts.app')

@section('title', 'Add New Admin | Handball System')

@section('content')
    <!-- Page Header & Breadcrumb -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Add New Admin</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted"><i
                                class="fas fa-home mr-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}" class="text-muted">Admins List</a>
                    </li>
                    <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Add New Admin</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.admins.index') }}"
            class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold px-3">
            <i class="fas fa-arrow-left mr-1"></i> Back to Admins Directory
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-lg border-0 shadow-sm mb-4" role="alert">
            <strong class="d-block mb-1"><i class="fas fa-exclamation-triangle mr-2"></i>Please correct the following
                errors:</strong>
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

    <div class="row">

        <!-- LEFT COLUMN: LIVE REAL-TIME PREVIEW CARD -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
                <div class="admin-card-header admin-card-header-gradient-1"></div>
                <div class="text-center" style="margin-top: -50px;">
                    <div class="d-inline-block position-relative">
                        <div id="previewAvatarBox"
                            class="admin-avatar-placeholder mx-auto overflow-hidden d-flex align-items-center justify-content-center"
                            style="width: 100px; height: 100px; border-radius: 50%; border: 4px solid #fff; background: #f1f5f9;">
                            <i class="fas fa-user fa-2x text-secondary" id="previewPlaceholderIcon"></i>
                            <img id="previewImageTag" src="" alt="Avatar Preview" class="w-100 h-100 d-none"
                                style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="p-3">
                        <h5 class="font-weight-bold text-dark mb-1" id="previewName">Enter Full Name</h5>
                        <p class="text-muted small mb-3" id="previewEmail">email@example.com</p>

                        <div class="dropdown-divider mb-3"></div>

                        <!-- Personal Info List -->
                        <div class="text-left small">
                            <h6 class="font-weight-bold text-gray-800 mb-3">Admin Details</h6>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold text-muted">Full Name</div>
                                <div class="col-7 text-dark font-weight-bold" id="previewInfoName">: Enter Full Name</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold text-muted">Email</div>
                                <div class="col-7 text-dark" id="previewInfoEmail" style="word-break: break-all;">:
                                    email@example.com</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold text-muted">Phone</div>
                                <div class="col-7 text-dark" id="previewInfoPhone">: (---) --- ---</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold text-muted">National ID</div>
                                <div class="col-7 text-dark" id="previewInfoNationalId">: ------------</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold text-muted">Gender</div>
                                <div class="col-7 text-dark" id="previewInfoGender">: Not Selected</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold text-muted">Status</div>
                                <div class="col-7 text-dark" id="previewInfoStatus">: Active</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold text-muted">Role</div>
                                <div class="col-7 text-dark" id="previewInfoRole">: Not Assigned</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 font-weight-bold text-muted">Address</div>
                                <div class="col-7 text-dark" id="previewInfoAddress">: ------------</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: REGISTRATION FORM -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <ul class="nav profile-nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#createProfileTab" role="tab">New Admin
                                Registration</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.admins.store') }}" method="POST" enctype="multipart/form-data"
                        id="createAdminForm">
                        @csrf

                        <!-- Profile Image Upload Circle -->
                        <div class="mb-4 text-center text-md-left">
                            <label class="font-weight-bold small text-gray-700 d-block mb-2">Profile Image</label>
                            <div class="d-inline-flex align-items-center">
                                <div class="avatar-upload-container mr-3 position-relative">
                                    <div class="avatar-upload-circle overflow-hidden d-flex align-items-center justify-content-center"
                                        id="formAvatarCircle"
                                        style="width: 80px; height: 80px; border-radius: 50%; background: #f8fafc; border: 2px dashed #cbd5e1;">
                                        <i class="fas fa-user fa-2x text-gray-400" id="formPlaceholderIcon"></i>
                                        <img id="formImageTag" src="" alt="Avatar" class="w-100 h-100 d-none"
                                            style="object-fit: cover;">
                                    </div>
                                    <label for="imageUploadInput" class="avatar-upload-icon m-0 position-absolute"
                                        style="bottom: 0; right: 0; background: #ea580c; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;"
                                        title="Upload Photo">
                                        <i class="fas fa-camera small"></i>
                                    </label>
                                    <input type="file" name="image" id="imageUploadInput" accept="image/*"
                                        class="d-none">
                                </div>
                                <div>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary font-weight-bold rounded-pill px-3"
                                        onclick="document.getElementById('imageUploadInput').click();">
                                        Choose Photo
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
                                <label for="inputName" class="font-weight-bold small text-gray-700">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control form-control-custom @error('name') is-invalid @enderror"
                                    id="inputName" value="{{ old('name') }}" placeholder="e.g. John Doe" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6 mb-3">
                                <label for="inputEmail" class="font-weight-bold small text-gray-700">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control form-control-custom @error('email') is-invalid @enderror"
                                    id="inputEmail" value="{{ old('email') }}" placeholder="e.g. john@example.com"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label for="inputPassword" class="font-weight-bold small text-gray-700">Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" name="password"
                                    class="form-control form-control-custom @error('password') is-invalid @enderror"
                                    id="inputPassword" placeholder="Minimum 8 characters" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div class="col-md-6 mb-3">
                                <label for="inputPasswordConfirmation"
                                    class="font-weight-bold small text-gray-700">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation"
                                    class="form-control form-control-custom" id="inputPasswordConfirmation"
                                    placeholder="Re-enter password" required>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 mb-3">
                                <label for="inputPhone" class="font-weight-bold small text-gray-700">Phone Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="phone"
                                    class="form-control form-control-custom @error('phone') is-invalid @enderror"
                                    id="inputPhone" value="{{ old('phone') }}" placeholder="e.g. +1234567890" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- National ID -->
                            <div class="col-md-6 mb-3">
                                <label for="inputNationalId" class="font-weight-bold small text-gray-700">National ID
                                    <span class="text-danger">*</span></label>
                                <input type="number" name="national_id"
                                    class="form-control form-control-custom @error('national_id') is-invalid @enderror"
                                    id="inputNationalId" value="{{ old('national_id') }}"
                                    placeholder="e.g. 12345678901234" required>
                                @error('national_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label for="inputGender" class="font-weight-bold small text-gray-700">Gender <span
                                        class="text-danger">*</span></label>
                                <select name="gender"
                                    class="form-control form-control-custom @error('gender') is-invalid @enderror"
                                    id="inputGender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="inputStatus" class="font-weight-bold small text-gray-700">Status <span
                                        class="text-danger">*</span></label>
                                <select name="status"
                                    class="form-control form-control-custom @error('status') is-invalid @enderror"
                                    id="inputStatus" required>
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                    <option value="banned" {{ old('status') == 'banned' ? 'selected' : '' }}>Banned
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="col-md-6 mb-3">
                                <label for="inputRole" class="font-weight-bold small text-gray-700">Role</label>
                                <select name="role"
                                    class="form-control form-control-custom @error('role') is-invalid @enderror"
                                    id="inputRole">
                                    <option value="">Select Role (Optional)</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ old('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-md-6 mb-3">
                                <label for="inputAddress" class="font-weight-bold small text-gray-700">Address <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="address"
                                    class="form-control form-control-custom @error('address') is-invalid @enderror"
                                    id="inputAddress" value="{{ old('address') }}" placeholder="e.g. 123 Main St, City"
                                    required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.admins.index') }}"
                                class="btn btn-light rounded-pill px-4 mr-2 font-weight-bold">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold"
                                style="background: #ea580c; border: none;">
                                <i class="fas fa-check-circle mr-1"></i> Save Admin Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputName = document.getElementById('inputName');
            const inputEmail = document.getElementById('inputEmail');
            const inputPhone = document.getElementById('inputPhone');
            const inputNationalId = document.getElementById('inputNationalId');
            const inputGender = document.getElementById('inputGender');
            const inputStatus = document.getElementById('inputStatus');
            const inputRole = document.getElementById('inputRole');
            const inputAddress = document.getElementById('inputAddress');
            const imageUploadInput = document.getElementById('imageUploadInput');

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

            const previewPlaceholderIcon = document.getElementById('previewPlaceholderIcon');
            const previewImageTag = document.getElementById('previewImageTag');
            const formPlaceholderIcon = document.getElementById('formPlaceholderIcon');
            const formImageTag = document.getElementById('formImageTag');

            function updatePreview() {
                if (inputName) {
                    const val = inputName.value.trim();
                    previewName.textContent = val || 'Enter Full Name';
                    previewInfoName.textContent = ': ' + (val || 'Enter Full Name');
                }
                if (inputEmail) {
                    const val = inputEmail.value.trim();
                    previewEmail.textContent = val || 'email@example.com';
                    previewInfoEmail.textContent = ': ' + (val || 'email@example.com');
                }
                if (inputPhone) {
                    previewInfoPhone.textContent = ': ' + (inputPhone.value.trim() || '(---) --- ---');
                }
                if (inputNationalId) {
                    previewInfoNationalId.textContent = ': ' + (inputNationalId.value.trim() || '------------');
                }
                if (inputGender) {
                    previewInfoGender.textContent = ': ' + (inputGender.value || 'Not Selected');
                }
                if (inputStatus) {
                    previewInfoStatus.textContent = ': ' + (inputStatus.value ? inputStatus.value.charAt(0)
                        .toUpperCase() + inputStatus.value.slice(1) : 'Active');
                }
                if (inputRole) {
                    previewInfoRole.textContent = ': ' + (inputRole.value || 'Not Assigned');
                }
                if (inputAddress) {
                    previewInfoAddress.textContent = ': ' + (inputAddress.value.trim() || '------------');
                }
            }

            [inputName, inputEmail, inputPhone, inputNationalId, inputAddress].forEach(el => {
                if (el) el.addEventListener('input', updatePreview);
            });

            [inputGender, inputStatus, inputRole].forEach(el => {
                if (el) el.addEventListener('change', updatePreview);
            });

            if (imageUploadInput) {
                imageUploadInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            previewPlaceholderIcon.classList.add('d-none');
                            previewImageTag.src = evt.target.result;
                            previewImageTag.classList.remove('d-none');

                            formPlaceholderIcon.classList.add('d-none');
                            formImageTag.src = evt.target.result;
                            formImageTag.classList.remove('d-none');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            updatePreview();
        });
    </script>
@endpush
