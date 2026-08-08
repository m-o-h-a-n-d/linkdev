@extends('backend.layouts.app')

@section('title', 'Add New User / Staff | Handball System')

@section('content')
<!-- Page Header & Breadcrumb -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Add New User / Staff</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}" class="text-muted"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.staff.index') }}" class="text-muted">Staff List</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Add New User</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold px-3">
        <i class="fas fa-arrow-left mr-1"></i> Back to Staff Directory
    </a>
</div>

<div class="row">

    <!-- LEFT COLUMN: LIVE REAL-TIME PREVIEW CARD (INITIAL PHOTO IS EMPTY) -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
            <div class="staff-card-header staff-card-header-gradient-1"></div>
            <div class="text-center" style="margin-top: -50px;">
                <div class="d-inline-block position-relative">
                    <!-- Photo Card starts EMPTY (silhouette icon) until photo uploaded -->
                    <div id="previewAvatarBox" class="staff-avatar-placeholder mx-auto">
                        <i class="fas fa-user" id="previewPlaceholderIcon"></i>
                    </div>
                </div>
                <div class="p-3">
                    <h5 class="font-weight-bold text-dark mb-1" id="previewName">Enter Full Name</h5>
                    <p class="text-muted small mb-3" id="previewEmail">email@example.com</p>

                    <div class="dropdown-divider mb-3"></div>

                    <!-- Personal Info List -->
                    <div class="text-left small">
                        <h6 class="font-weight-bold text-gray-800 mb-3">Personal Info</h6>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Full Name</div>
                            <div class="col-7 text-dark font-weight-bold" id="previewInfoName">: Enter Full Name</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Email</div>
                            <div class="col-7 text-dark" id="previewInfoEmail" style="word-break: break-all;">: email@example.com</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Phone Number</div>
                            <div class="col-7 text-dark" id="previewInfoPhone">: (---) --- ---</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Department</div>
                            <div class="col-7 text-dark" id="previewInfoDept">: Select Department</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Designation</div>
                            <div class="col-7 text-dark" id="previewInfoDesignation">: Enter Designation</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Languages</div>
                            <div class="col-7 text-dark" id="previewInfoLang">: English</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Bio</div>
                            <div class="col-7 text-muted" id="previewInfoBio" style="font-size: 0.8rem;">: Description will appear here...</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: REGISTRATION FORM WITH REAL-TIME JS BINDING -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <ul class="nav profile-nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#createProfileTab" role="tab">New Profile Registration</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.staff.index') }}" method="GET" id="createStaffForm">

                    <!-- Profile Image Upload Circle -->
                    <div class="mb-4 text-center text-md-left">
                        <label class="font-weight-bold small text-gray-700 d-block mb-2">Profile Image</label>
                        <div class="d-inline-flex align-items-center">
                            <div class="avatar-upload-container mr-3">
                                <div class="avatar-upload-circle" id="formAvatarCircle">
                                    <i class="fas fa-user fa-3x text-gray-300" id="formPlaceholderIcon"></i>
                                </div>
                                <label for="profileImageInput" class="avatar-upload-icon mb-0" title="Upload Photo">
                                    <i class="fas fa-camera fa-sm"></i>
                                </label>
                                <input type="file" id="profileImageInput" accept="image/*" class="d-none">
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold px-3 mr-2" onclick="document.getElementById('profileImageInput').click();">
                                    Upload Photo
                                </button>
                                <button type="button" class="btn btn-light btn-sm rounded-pill font-weight-bold text-muted" id="resetPhotoBtn">
                                    Remove
                                </button>
                                <div class="text-muted text-xs mt-1">PNG, JPG or JPEG (Max 2MB)</div>
                            </div>
                        </div>
                    </div>

                    <!-- 2-COLUMN INPUT FIELDS -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small text-gray-700">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom" id="inputFullName" placeholder="Enter Full Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small text-gray-700">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-custom" id="inputEmail" placeholder="Enter email address" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small text-gray-700">Phone</label>
                            <input type="text" class="form-control form-control-custom" id="inputPhone" placeholder="Enter phone number">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small text-gray-700">Department <span class="text-danger">*</span></label>
                            <select class="form-control form-control-custom" id="inputDepartment">
                                <option value="">Select Department</option>
                                <option value="Design">Design</option>
                                <option value="Referees">Referees</option>
                                <option value="Medical">Medical</option>
                                <option value="Administration">Administration</option>
                                <option value="Technical">Technical</option>
                                <option value="Media & IT">Media & IT</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small text-gray-700">Designation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom" id="inputDesignation" placeholder="Enter Designation Title">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small text-gray-700">Language <span class="text-danger">*</span></label>
                            <select class="form-control form-control-custom" id="inputLanguage">
                                <option value="English">English</option>
                                <option value="Arabic">Arabic</option>
                                <option value="French">French</option>
                                <option value="Spanish">Spanish</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold small text-gray-700">Description / Bio</label>
                        <textarea class="form-control form-control-custom" id="inputBio" rows="4" placeholder="Write description..."></textarea>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                        <a href="{{ route('admin.staff.index') }}" class="btn btn-light rounded-pill font-weight-bold px-4 mr-2">Cancel</a>
                        <button type="submit" class="btn btn-danger rounded-pill font-weight-bold px-4">
                            Save User & Profile
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
document.addEventListener('DOMContentLoaded', function () {
    // Input elements
    const inputFullName = document.getElementById('inputFullName');
    const inputEmail = document.getElementById('inputEmail');
    const inputPhone = document.getElementById('inputPhone');
    const inputDepartment = document.getElementById('inputDepartment');
    const inputDesignation = document.getElementById('inputDesignation');
    const inputLanguage = document.getElementById('inputLanguage');
    const inputBio = document.getElementById('inputBio');
    const profileImageInput = document.getElementById('profileImageInput');
    const resetPhotoBtn = document.getElementById('resetPhotoBtn');

    // Preview elements
    const previewName = document.getElementById('previewName');
    const previewEmail = document.getElementById('previewEmail');
    const previewInfoName = document.getElementById('previewInfoName');
    const previewInfoEmail = document.getElementById('previewInfoEmail');
    const previewInfoPhone = document.getElementById('previewInfoPhone');
    const previewInfoDept = document.getElementById('previewInfoDept');
    const previewInfoDesignation = document.getElementById('previewInfoDesignation');
    const previewInfoLang = document.getElementById('previewInfoLang');
    const previewInfoBio = document.getElementById('previewInfoBio');
    const previewAvatarBox = document.getElementById('previewAvatarBox');
    const formAvatarCircle = document.getElementById('formAvatarCircle');

    // Live JS binding helper
    function bindInput(input, callback) {
        if (!input) return;
        ['input', 'keyup', 'change'].forEach(evt => {
            input.addEventListener(evt, callback);
        });
    }

    bindInput(inputFullName, function() {
        const val = inputFullName.value.trim() || 'Enter Full Name';
        previewName.textContent = val;
        previewInfoName.textContent = ': ' + val;
    });

    bindInput(inputEmail, function() {
        const val = inputEmail.value.trim() || 'email@example.com';
        previewEmail.textContent = val;
        previewInfoEmail.textContent = ': ' + val;
    });

    bindInput(inputPhone, function() {
        const val = inputPhone.value.trim() || '(---) --- ---';
        previewInfoPhone.textContent = ': ' + val;
    });

    bindInput(inputDepartment, function() {
        const val = inputDepartment.value.trim() || 'Select Department';
        previewInfoDept.textContent = ': ' + val;
    });

    bindInput(inputDesignation, function() {
        const val = inputDesignation.value.trim() || 'Enter Designation';
        previewInfoDesignation.textContent = ': ' + val;
    });

    bindInput(inputLanguage, function() {
        const val = inputLanguage.value || 'English';
        previewInfoLang.textContent = ': ' + val;
    });

    bindInput(inputBio, function() {
        const val = inputBio.value.trim() || 'Description will appear here...';
        previewInfoBio.textContent = ': ' + val;
    });

    // Handle Profile Image Upload Live Preview
    if (profileImageInput) {
        profileImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const imgUrl = evt.target.result;
                    previewAvatarBox.innerHTML = `<img src="${imgUrl}" class="staff-avatar-circle" style="width:90px;height:90px;">`;
                    formAvatarCircle.innerHTML = `<img src="${imgUrl}">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    if (resetPhotoBtn) {
        resetPhotoBtn.addEventListener('click', function() {
            if (profileImageInput) profileImageInput.value = '';
            previewAvatarBox.innerHTML = `<i class="fas fa-user" id="previewPlaceholderIcon"></i>`;
            formAvatarCircle.innerHTML = `<i class="fas fa-user fa-3x text-gray-300" id="formPlaceholderIcon"></i>`;
        });
    }
});
</script>
@endpush
