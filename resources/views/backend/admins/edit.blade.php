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
                <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}" class="text-muted">Admins List</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">View Profile</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold px-3">
        <i class="fas fa-arrow-left mr-1"></i> Back to Admins Directory
    </a>
</div>

<div class="row">

    <!-- LEFT COLUMN: PROFILE PREVIEW CARD -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
            <div class="admin-card-header admin-card-header-gradient-1"></div>
            <div class="text-center" style="margin-top: -50px;">
                <div class="d-inline-block position-relative">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80" alt="Robiul Hasan" class="admin-avatar-circle" id="previewAvatarImg" style="width: 100px; height: 100px;">
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
                        <form action="{{ route('admin.admins.index') }}" method="GET" id="editProfileForm">

                            <!-- Profile Image Upload Circle -->
                            <div class="mb-4 text-center text-md-left">
                                <label class="font-weight-bold small text-gray-700 d-block mb-2">Profile Image</label>
                                <div class="d-inline-flex align-items-center">
                                    <div class="avatar-upload-container mr-3">
                                        <div class="avatar-upload-circle">
                                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80" alt="Robiul Hasan" id="formAvatarImg">
                                        </div>
                                        <label for="editImageUploadInput" class="avatar-upload-icon m-0" title="Change Photo">
                                            <i class="fas fa-camera"></i>
                                        </label>
                                        <input type="file" id="editImageUploadInput" accept="image/*" class="d-none">
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold rounded-pill px-3" onclick="document.getElementById('editImageUploadInput').click();">
                                            Change Photo
                                        </button>
                                        <div class="text-muted small mt-1">Allowed JPG, PNG. Max size 2MB</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold small text-gray-700">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-custom" id="editName" value="Robiul Hasan" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold small text-gray-700">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-custom" id="editEmail" value="robiulhasan9559@gmail.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold small text-gray-700">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-custom" id="editPhone" value="(1) 2536 2561 2365" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold small text-gray-700">Department <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-custom" id="editDept">
                                        <option value="Development" selected>Development</option>
                                        <option value="Administration">Administration</option>
                                        <option value="Referees">Referees</option>
                                        <option value="Medical">Medical</option>
                                        <option value="Technical">Technical</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold small text-gray-700">Designation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-custom" id="editDesignation" value="Front End Developer">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold small text-gray-700">Languages</label>
                                    <input type="text" class="form-control form-control-custom" id="editLang" value="English">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="font-weight-bold small text-gray-700">About & Bio</label>
                                    <textarea class="form-control form-control-custom" id="editBio" rows="3">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</textarea>
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

                    <!-- TAB 2: CHANGE PASSWORD -->
                    <div class="tab-pane fade" id="changePass" role="tabpanel">
                        <form action="{{ route('admin.admins.index') }}" method="GET">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold small text-gray-700">Current Password</label>
                                <input type="password" class="form-control form-control-custom" placeholder="••••••••">
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold small text-gray-700">New Password</label>
                                <input type="password" class="form-control form-control-custom" placeholder="••••••••">
                            </div>
                            <div class="form-group mb-4">
                                <label class="font-weight-bold small text-gray-700">Confirm New Password</label>
                                <input type="password" class="form-control form-control-custom" placeholder="••••••••">
                            </div>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold" style="background: #ea580c; border: none;">
                                Update Password
                            </button>
                        </form>
                    </div>

                    <!-- TAB 3: NOTIFICATION SETTINGS -->
                    <div class="tab-pane fade" id="notificationTab" role="tabpanel">
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="switchEmail" checked>
                            <label class="custom-control-label font-weight-bold" for="switchEmail">Email Notifications</label>
                        </div>
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="switchSms">
                            <label class="custom-control-label font-weight-bold" for="switchSms">SMS System Alerts</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
