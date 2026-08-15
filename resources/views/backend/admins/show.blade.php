@extends('backend.layouts.app')

@section('title', 'View Admin Profile | Handball System')

@section('content')
    <!-- Page Header & Breadcrumb -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">View Profile</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted"><i
                                class="fas fa-home mr-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}" class="text-muted">Admins
                            Directory</a></li>
                    <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">{{ $admin->name }}
                    </li>
                </ol>
            </nav>
        </div>
        <div>
            @can('admins.edit')
            <a href="{{ route('admin.admins.edit', $admin->id) }}"
                class="btn btn-warning shadow-sm font-weight-bold px-3 mr-2" style="border-radius: 10px;">
                <i class="fas fa-edit mr-1"></i> Edit Profile
            </a>
            @endcan
            <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary shadow-sm font-weight-bold px-3"
                style="border-radius: 10px;">
                <i class="fas fa-arrow-left mr-1"></i> Back to Directory
            </a>
        </div>
    </div>

    @php
        $avatarUrl = asset('assets/img/avatar-placeholder.png');
        if (!empty($admin->admin?->image) && $admin->admin->image !== 'defaults/avatar.png') {
            $avatarUrl = filter_var($admin->admin->image, FILTER_VALIDATE_URL)
                ? $admin->admin->image
                : asset('storage/' . $admin->admin->image);
        }
        $status = $admin->admin?->status ?? 'active';
        $roleName = $admin->roles->first()?->name ? ucfirst($admin->roles->first()->name) : 'Admin';
    @endphp

    <!-- CENTERED & WIDER PROFILE CARD -->
    <div class="row">
        <div class="col-lg-8 col-xl-7 mx-auto mb-5">

            <div class="profile-card-centered">
                <!-- Top Gradient Header Banner -->
                <div class="profile-card-banner-wide">
                    <div class="d-flex justify-content-between align-items-center p-3 text-white">
                        <span class="badge badge-light text-primary font-weight-bold px-3 py-2"
                            style="border-radius: 20px;">
                            <i class="fas fa-user-shield mr-1"></i> Admin ID: #ADM-{{ $admin->id }}
                        </span>
                        <span
                            class="badge badge-{{ $status === 'active' ? 'success' : ($status === 'banned' ? 'danger' : 'warning') }} font-weight-bold px-3 py-2"
                            style="border-radius: 20px;">
                            <i class="fas fa-check-circle mr-1"></i> {{ ucfirst($status) }} Official
                        </span>
                    </div>
                </div>

                <!-- Avatar Centered Overlapping Banner -->
                <div class="profile-avatar-centered-wrap">
                    <img src="{{ $avatarUrl }}" alt="{{ $admin->name }}" class="profile-avatar-centered"
                        style="object-fit: cover;">
                    <h3 class="font-weight-bold text-white mt-3 mb-1">{{ $admin->name }}</h3>
                    <p class="text-muted small mb-3">{{ $admin->email }}</p>

                    <!-- Role Badge -->
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge font-weight-bold px-3 py-2 mr-2"
                            style="border-radius: 20px; font-size: 0.85rem; background: rgba(234, 88, 12, 0.2) !important; color: #f97316 !important; border: 1px solid rgba(234, 88, 12, 0.4);">
                            <i class="fas fa-user-tag mr-1"></i> Role: {{ $roleName }}
                        </span>
                        <span class="badge font-weight-bold px-3 py-2"
                            style="border-radius: 20px; font-size: 0.85rem; background: rgba(34, 197, 94, 0.2) !important; color: #22c55e !important; border: 1px solid rgba(34, 197, 94, 0.4);">
                            <i class="fas fa-check-double mr-1"></i> Verified:
                            {{ $admin->email_verified_at ? $admin->email_verified_at->format('Y-m-d H:i') : 'Yes' }}
                        </span>
                    </div>
                </div>

                <div class="dropdown-divider mx-4 mb-4" style="border-top-color: #1e293b;"></div>

                <!-- Detailed Personal Info Grid -->
                <div class="px-4 pb-4">
                    <h5 class="font-weight-bold text-white mb-4 border-left-primary pl-3"
                        style="border-left-color: #ea580c !important;">
                        <i class="fas fa-id-card text-primary mr-2"></i>Personal & Contact Details
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-3 rounded-lg" style="background: #162238; border: 1px solid #1e293b;">
                                <div class="text-muted text-xs font-weight-bold text-uppercase mb-1">Full Name</div>
                                <div class="font-weight-bold text-white h6 mb-0">{{ $admin->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 rounded-lg" style="background: #162238; border: 1px solid #1e293b;">
                                <div class="text-muted text-xs font-weight-bold text-uppercase mb-1">Email Address</div>
                                <div class="font-weight-bold text-primary h6 mb-0" style="word-break: break-all;">
                                    {{ $admin->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 rounded-lg" style="background: #162238; border: 1px solid #1e293b;">
                                <div class="text-muted text-xs font-weight-bold text-uppercase mb-1">Phone Number</div>
                                <div class="font-weight-bold text-white h6 mb-0">{{ $admin->admin?->phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 rounded-lg" style="background: #162238; border: 1px solid #1e293b;">
                                <div class="text-muted text-xs font-weight-bold text-uppercase mb-1">National ID</div>
                                <div class="font-weight-bold text-white h6 mb-0">{{ $admin->admin?->national_id ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 rounded-lg" style="background: #162238; border: 1px solid #1e293b;">
                                <div class="text-muted text-xs font-weight-bold text-uppercase mb-1">Gender</div>
                                <div class="font-weight-bold text-white h6 mb-0">{{ $admin->admin?->gender ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 rounded-lg" style="background: #162238; border: 1px solid #1e293b;">
                                <div class="text-muted text-xs font-weight-bold text-uppercase mb-1">Address</div>
                                <div class="font-weight-bold text-white h6 mb-0">{{ $admin->admin?->address ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Footer -->
                    <div class="mt-4 pt-3 d-flex justify-content-between align-items-center"
                        style="border-top: 1px solid #1e293b;">
                        <a href="{{ route('admin.admins.index') }}"
                            class="btn btn-secondary rounded-pill font-weight-bold px-4">
                            <i class="fas fa-chevron-left mr-1"></i> Return to Admins List
                        </a>
                        <a href="{{ route('admin.admins.edit', $admin->id) }}"
                            class="btn btn-primary rounded-pill font-weight-bold px-4"
                            style="background: #ea580c; border: none;">
                            <i class="fas fa-cog mr-1"></i> Edit Profile Settings
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
