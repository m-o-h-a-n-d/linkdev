@extends('backend.layouts.app')

@section('title', 'Users & Admins Directory | Handball System')

@section('content')
    <!-- Page Header & Control Bar -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Admins List</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted"><i
                                class="fas fa-home mr-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Admins List</li>
                </ol>
            </nav>
        </div>
        @can('admins.create')
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary shadow-sm px-4 font-weight-bold"
            style="border-radius: 10px;">
            <i class="fas fa-plus mr-2"></i>Add New Admin
        </a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-lg border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Bar Card -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-md-3 d-flex align-items-center mb-2 mb-md-0">
                    <span class="mr-2 text-muted small font-weight-bold">Total</span>
                    <span class="badge badge-primary font-weight-bold px-3 py-2"
                        style="border-radius: 8px;">{{ $admins->total() }} Admins</span>
                </div>
                <div class="col-md-9">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 bg-light small" placeholder="Search admins..."
                            style="border-radius: 20px 0 0 20px; padding-left: 20px;" data-handball-search="adminCardsGrid">
                        <div class="input-group-append">
                            <button class="btn btn-danger px-3" type="button" style="border-radius: 0 20px 20px 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RESPONSIVE ADMIN CARDS GRID -->
    <div class="row" id="adminCardsGrid">
        @forelse ($admins as $index => $admin)
            @php
                $gradients = [
                    'admin-card-header-gradient-1',
                    'admin-card-header-gradient-2',
                    'admin-card-header-gradient-3',
                    'admin-card-header-gradient-4',
                    'admin-card-header-gradient-5',
                    'admin-card-header-gradient-6',
                    'admin-card-header-gradient-7',
                    'admin-card-header-gradient-8',
                ];
                $gradientClass = $gradients[$index % count($gradients)];

                $avatarUrl = asset('assets/img/avatar-placeholder.png');
                if (!empty($admin->admin?->image) && $admin->admin->image !== 'defaults/avatar.png') {
                    $avatarUrl = filter_var($admin->admin->image, FILTER_VALIDATE_URL)
                        ? $admin->admin->image
                        : asset('storage/' . $admin->admin->image);
                }
            @endphp

            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="admin-card">
                    <div class="admin-card-header {{ $gradientClass }}">
                        <div class="dropdown">
                            @canany(['admins.view', 'admins.edit', 'admins.delete'])
                            <button class="admin-card-options" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                @can('admins.view')
                                <a class="dropdown-item" href="{{ route('admin.admins.show', $admin->id) }}"><i
                                        class="fas fa-user text-primary mr-2"></i>View Profile</a>
                                @endcan
                                @can('admins.edit')
                                <a class="dropdown-item" href="{{ route('admin.admins.edit', $admin->id) }}"><i
                                        class="fas fa-edit text-warning mr-2"></i>Edit Profile</a>
                                @endcan
                                @can('admins.delete')
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="dropdown-item text-danger border-0 bg-transparent w-100 text-left">
                                        <i class="fas fa-trash mr-2"></i>Delete
                                    </button>
                                </form>
                                @endcan
                            </div>
                            @endcanany
                        </div>
                    </div>
                    <div class="admin-avatar-wrapper">
                        <img src="{{ $avatarUrl }}" alt="{{ $admin->name }}" class="admin-avatar-circle"
                            style="object-fit: cover;">
                    </div>
                    <div class="admin-card-body">
                        <div class="admin-name text-truncate" title="{{ $admin->name }}">{{ $admin->name }}</div>
                        <div class="admin-email text-truncate" title="{{ $admin->email }}">{{ $admin->email }}</div>

                        <div class="admin-info-pill-box">
                            <div class="admin-info-col">
                                <div class="admin-info-label text-truncate">{{ $admin->admin?->phone ?? 'N/A' }}</div>
                                <div class="admin-info-value">Phone</div>
                            </div>
                            <div class="admin-info-col">
                                <div class="admin-info-label text-truncate">
                                    {{ $admin->roles->first()?->name ? ucfirst($admin->roles->first()->name) : 'Admin' }}
                                </div>
                                <div class="admin-info-value">Role</div>
                            </div>
                        </div>

                        @can('admins.view')
                        <a href="{{ route('admin.admins.show', $admin->id) }}" class="admin-view-link">
                            View Profile <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center p-5" style="border-radius: 16px;">
                    <div class="py-4">
                        <i class="fas fa-user-shield fa-4x text-gray-300 mb-3"></i>
                        <h5 class="font-weight-bold text-gray-800">No Admins Found</h5>
                        <p class="text-muted small">No admin users are registered in the system yet.</p>
                        @can('admins.create')
                        <a href="{{ route('admin.admins.create') }}"
                            class="btn btn-primary font-weight-bold rounded-pill px-4 mt-2">
                            <i class="fas fa-plus mr-1"></i> Create First Admin
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    @if ($admins->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $admins->links('pagination::bootstrap-4') }}
        </div>
    @endif

@endsection
