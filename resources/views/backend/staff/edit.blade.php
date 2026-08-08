@extends('backend.layouts.app')

@section('title', 'View & Edit Profile | Handball System')

@section('content')
<!-- Page Header & Breadcrumb -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">View Profile & Settings</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}" class="text-muted"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.staff.index') }}" class="text-muted">Staff List</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">View Profile</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold px-3">
        <i class="fas fa-arrow-left mr-1"></i> Back to Staff Directory
    </a>
</div>

<div class="row">

    <!-- LEFT COLUMN: PROFILE PREVIEW CARD (MATCHING SCREENSHOT 3) -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
            <div class="staff-card-header staff-card-header-gradient-1"></div>
            <div class="text-center" style="margin-top: -50px;">
                <div class="d-inline-block position-relative">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80" alt="Robiul Hasan" class="staff-avatar-circle" id="previewAvatarImg" style="width: 100px; height: 100px;">
                </div>
                <div class="p-3">
                    <h5 class="font-weight-bold text-dark mb-1" id="previewName">Robiul Hasan</h5>
                    <p class="text-muted small mb-3" id="previewEmail">ifrandom@gmail.com</p>

                    <div class="dropdown-divider mb-3"></div>

                    <!-- Personal Info List -->
                    <div class="text-left small">
                        <h6 class="font-weight-bold text-gray-800 mb-3">Personal Info</h6>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Full Name</div>
                            <div class="col-7 text-dark font-weight-bold" id="previewInfoName">: Robiul Hasan</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Email</div>
                            <div class="col-7 text-dark" id="previewInfoEmail" style="word-break: break-all;">: robiulhasan9559@gmail.com</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Phone Number</div>
                            <div class="col-7 text-dark" id="previewInfoPhone">: (1) 2536 2561 2365</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Department</div>
                            <div class="col-7 text-dark" id="previewInfoDept">: Development</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Designation</div>
                            <div class="col-7 text-dark" id="previewInfoDesignation">: Front End Developer</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Languages</div>
                            <div class="col-7 text-dark" id="previewInfoLang">: English</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold text-muted">Bio</div>
                            <div class="col-7 text-muted" id="previewInfoBio" style="font-size: 0.8rem;">: Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: EDIT PROFILE TABS & FORM WITH LIVE JS BINDING -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <ul class="nav profile-nav-tabs" id="profileTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="edit-profile-tab" data-toggle="tab" href="#editProfile" role="tab">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="change-pass-tab" data-toggle="tab" href="#changePass" role="tab">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="notification-tab" data-toggle="tab" href="#notificationTab" role="tab">Notification Settings</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content" id="profileTabContent">

                    <!-- TAB 1: EDIT PROFILE -->
                    <div class="tab-pane fade show active" id="editProfile" role="tabpanel">
                        <form action="{{ route('admin.staff.index') }}" method="GET" id="editProfileForm">

                            <!-- Profile Image Upload Circle -->
                            <div class="mb-4 text-center text-md-left">
                                <label class="font-weight-bold small text-gray-700 d-block mb-2">Profile Image</label>
                                <div class="d-inline-flex align-items-center">
                                    <div class="avatar-upload-container mr-3">
                                        <div class="avatar-upload-circle" id="formAvatarCircle">
                                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80" alt="Avatar" id="formAvatarImg">
                                        </div>
                                        <label for="profileImageInputEdit" class="avatar-upload-icon mb-0" title="Change Photo">
                                            <i class="fas fa-camera fa-sm"></i>
                                        </label>
                                        <input type="file" id="profileImageInputEdit" accept="image/*" class="d-none">
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold px-3 mr-2" onclick="document.getElementById('profileImageInputEdit').click();">
                                            Upload Photo
                                        </button>
                                        <button type="button" class="btn btn-light btn-sm rounded-pill font-weight-bold text-muted" id="resetPhotoBtnEdit">
                                            Remove
                                        </button>
                                        <div class="text-muted text-xs mt-1">PNG, JPG or JPEG (Max 2MB)</div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2-COLUMN FORM FIELDS -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold small text-gray-700">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-custom" id="inputFullName" value="Robiul Hasan" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold small text-gray-700">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-custom" id="inputEmail" value="robiulhasan9559@gmail.com" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold small text-gray-700">Phone</label>
                                    <input type="text" class="form-control form-control-custom" id="inputPhone" value="(1) 2536 2561 2365">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold small text-gray-700">Department <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-custom" id="inputDepartment">
                                        <option value="Development" selected>Development</option>
                                        <option value="Design">Design</option>
                                        <option value="Referees">Referees</option>
                                        <option value="Medical">Medical</option>
                                        <option value="Administration">Administration</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold small text-gray-700">Designation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-custom" id="inputDesignation" value="Front End Developer">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold small text-gray-700">Language <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-custom" id="inputLanguage">
                                        <option value="English" selected>English</option>
                                        <option value="Arabic">Arabic</option>
                                        <option value="French">French</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold small text-gray-700">Description</label>
                                <textarea class="form-control form-control-custom" id="inputBio" rows="4">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</textarea>
                            </div>

                            <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                                <a href="{{ route('admin.staff.index') }}" class="btn btn-light rounded-pill font-weight-bold px-4 mr-2">Cancel</a>
                                <button type="submit" class="btn btn-danger rounded-pill font-weight-bold px-4">
                                    Update Profile Settings
                                </button>
                            </div>

                        </form>
                    </div>

                    <!-- TAB 2: CHANGE PASSWORD -->
                    <div class="tab-pane fade" id="changePass" role="tabpanel">
                        <form onsubmit="event.preventDefault(); showHandballToast('Success', 'Password updated successfully!');">
                            <div class="form-group">
                                <label class="font-weight-bold small text-gray-700">Current Password</label>
                                <input type="password" class="form-control form-control-custom" placeholder="Enter current password">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold small text-gray-700">New Password</label>
                                    <input type="password" class="form-control form-control-custom" placeholder="Enter new password">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold small text-gray-700">Confirm New Password</label>
                                    <input type="password" class="form-control form-control-custom" placeholder="Confirm new password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger rounded-pill font-weight-bold px-4 mt-3">Change Password</button>
                        </form>
                    </div>

                    <!-- TAB 3: NOTIFICATION SETTINGS -->
                    <div class="tab-pane fade" id="notificationTab" role="tabpanel">
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="notifEmail" checked>
                            <label class="custom-control-label font-weight-bold text-gray-800" for="notifEmail">Email Match Alerts</label>
                        </div>
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="notifLive" checked>
                            <label class="custom-control-label font-weight-bold text-gray-800" for="notifLive">Live Score Updates</label>
                        </div>
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
    // Inputs
    const inputFullName = document.getElementById('inputFullName');
    const inputEmail = document.getElementById('inputEmail');
    const inputPhone = document.getElementById('inputPhone');
    const inputDepartment = document.getElementById('inputDepartment');
    const inputDesignation = document.getElementById('inputDesignation');
    const inputLanguage = document.getElementById('inputLanguage');
    const inputBio = document.getElementById('inputBio');
    const profileImageInputEdit = document.getElementById('profileImageInputEdit');
    const resetPhotoBtnEdit = document.getElementById('resetPhotoBtnEdit');

    // Previews
    const previewName = document.getElementById('previewName');
    const previewEmail = document.getElementById('previewEmail');
    const previewInfoName = document.getElementById('previewInfoName');
    const previewInfoEmail = document.getElementById('previewInfoEmail');
    const previewInfoPhone = document.getElementById('previewInfoPhone');
    const previewInfoDept = document.getElementById('previewInfoDept');
    const previewInfoDesignation = document.getElementById('previewInfoDesignation');
    const previewInfoLang = document.getElementById('previewInfoLang');
    const previewInfoBio = document.getElementById('previewInfoBio');
    const previewAvatarImg = document.getElementById('previewAvatarImg');
    const formAvatarImg = document.getElementById('formAvatarImg');

    function bindInput(input, callback) {
        if (!input) return;
        ['input', 'keyup', 'change'].forEach(evt => {
            input.addEventListener(evt, callback);
        });
    }

    bindInput(inputFullName, function() {
        const val = inputFullName.value.trim() || 'Robiul Hasan';
        previewName.textContent = val;
        previewInfoName.textContent = ': ' + val;
    });

    bindInput(inputEmail, function() {
        const val = inputEmail.value.trim() || 'robiulhasan9559@gmail.com';
        previewEmail.textContent = val;
        previewInfoEmail.textContent = ': ' + val;
    });

    bindInput(inputPhone, function() {
        const val = inputPhone.value.trim() || '(1) 2536 2561 2365';
        previewInfoPhone.textContent = ': ' + val;
    });

    bindInput(inputDepartment, function() {
        const val = inputDepartment.value.trim() || 'Development';
        previewInfoDept.textContent = ': ' + val;
    });

    bindInput(inputDesignation, function() {
        const val = inputDesignation.value.trim() || 'Front End Developer';
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

    if (profileImageInputEdit) {
        profileImageInputEdit.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const imgUrl = evt.target.result;
                    if (previewAvatarImg) previewAvatarImg.src = imgUrl;
                    if (formAvatarImg) formAvatarImg.src = imgUrl;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush
