@extends('backend.layouts.app')

@section('title', 'Add New User / Admin | Handball System')

@section('content')
<!-- Page Header & Breadcrumb -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Add New User / Admin</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}" class="text-muted"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}" class="text-muted">Admins List</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Add New Admin</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold px-3">
        <i class="fas fa-arrow-left mr-1"></i> Back to Admins Directory
    </a>
</div>

<div class="row">

    <!-- LEFT COLUMN: LIVE REAL-TIME PREVIEW CARD (INITIAL PHOTO IS EMPTY) -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
            <div class="admin-card-header admin-card-header-gradient-1"></div>
            <div class="text-center" style="margin-top: -50px;">
                <div class="d-inline-block position-relative">
                    <!-- Photo Card starts EMPTY (silhouette icon) until photo uploaded -->
                    <div id="previewAvatarBox" class="admin-avatar-placeholder mx-auto">
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
                <form action="{{ route('admin.admins.index') }}" method="GET" id="createAdminForm">

                    <!-- Profile Image Upload Circle -->
                    <div class="mb-4 text-center text-md-left">
                        <label class="font-weight-bold small text-gray-700 d-block mb-2">Profile Image</label>
                        <div class="d-inline-flex align-items-center">
                            <div class="avatar-upload-container mr-3">
                                <div class="avatar-upload-circle" id="formAvatarCircle">
                                    <i class="fas fa-user fa-3x text-gray-300" id="formPlaceholderIcon"></i>
                                </div>
                                <label for="imageUploadInput" class="avatar-upload-icon m-0" title="Upload Photo">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="imageUploadInput" accept="image/*" class="d-none">
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold rounded-pill px-3" onclick="document.getElementById('imageUploadInput').click();">
                                    Choose Photo
                                </button>
                                <div class="text-muted small mt-1">Allowed JPG, PNG. Max size 2MB</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold small text-gray-700">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom" id="inputName" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold small text-gray-700">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-custom" id="inputEmail" placeholder="e.g. john@example.com" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold small text-gray-700">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom" id="inputPhone" placeholder="e.g. +1 234 567 890" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold small text-gray-700">Department <span class="text-danger">*</span></label>
                            <select class="form-control form-control-custom" id="inputDept">
                                <option value="">Select Department</option>
                                <option value="Administration">Administration</option>
                                <option value="Development">Development</option>
                                <option value="Referees">Referees</option>
                                <option value="Medical">Medical</option>
                                <option value="Technical">Technical</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold small text-gray-700">Designation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom" id="inputDesignation" placeholder="e.g. System Admin">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold small text-gray-700">Languages</label>
                            <input type="text" class="form-control form-control-custom" id="inputLang" placeholder="e.g. English, Arabic">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="font-weight-bold small text-gray-700">About & Bio</label>
                            <textarea class="form-control form-control-custom" id="inputBio" rows="3" placeholder="Short description or bio..."></textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-light rounded-pill px-4 mr-2 font-weight-bold">Cancel</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold" style="background: #ea580c; border: none;">
                            <i class="fas fa-check-circle mr-1"></i> Save Admin Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
