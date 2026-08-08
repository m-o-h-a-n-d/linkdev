@extends('backend.layouts.app')

@section('title', 'Users & Admins Directory | Handball System')

@section('content')
<!-- Page Header & Control Bar -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Admins List</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}" class="text-muted"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Admins List</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary shadow-sm px-4 font-weight-bold" style="border-radius: 10px;">
        <i class="fas fa-plus mr-2"></i>Add New Admin
    </a>
</div>

<!-- Filter Bar Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-md-3 d-flex align-items-center mb-2 mb-md-0">
                <span class="mr-2 text-muted small font-weight-bold">Show</span>
                <select class="form-control form-control-sm w-auto d-inline-block border-0 bg-light font-weight-bold" style="border-radius: 8px;">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <input type="text" class="form-control border-0 bg-light small" placeholder="Search" style="border-radius: 20px 0 0 20px; padding-left: 20px;" data-handball-search="adminCardsGrid">
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

<!-- 4-COLUMN RESPONSIVE ADMIN CARDS GRID -->
<div class="row" id="adminCardsGrid">

    <!-- Card 1 -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="admin-card">
            <div class="admin-card-header admin-card-header-gradient-1">
                <div class="dropdown">
                    <button class="admin-card-options" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                        <a class="dropdown-item" href="{{ route('admin.admins.show') }}"><i class="fas fa-user text-primary mr-2"></i>View Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.admins.edit') }}"><i class="fas fa-edit text-warning mr-2"></i>Edit Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#!"><i class="fas fa-trash mr-2"></i>Delete</a>
                    </div>
                </div>
            </div>
            <div class="admin-avatar-wrapper">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80" alt="Robiul Hasan" class="admin-avatar-circle">
            </div>
            <div class="admin-card-body">
                <div class="admin-name">Robiul Hasan</div>
                <div class="admin-email">ifrandom@gmail.com</div>

                <div class="admin-info-pill-box">
                    <div class="admin-info-col">
                        <div class="admin-info-label">Design</div>
                        <div class="admin-info-value">Department</div>
                    </div>
                    <div class="admin-info-col">
                        <div class="admin-info-label">UI UX Designer</div>
                        <div class="admin-info-value">Designation</div>
                    </div>
                </div>

                <a href="{{ route('admin.admins.show') }}" class="admin-view-link">
                    View Profile <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="admin-card">
            <div class="admin-card-header admin-card-header-gradient-2">
                <div class="dropdown">
                    <button class="admin-card-options" type="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <a class="dropdown-item" href="{{ route('admin.admins.show') }}"><i class="fas fa-user text-primary mr-2"></i>View Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.admins.edit') }}"><i class="fas fa-edit text-warning mr-2"></i>Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="admin-avatar-wrapper">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=80" alt="Darrell Steward" class="admin-avatar-circle">
            </div>
            <div class="admin-card-body">
                <div class="admin-name">Darrell Steward</div>
                <div class="admin-email">ifrandom@gmail.com</div>

                <div class="admin-info-pill-box">
                    <div class="admin-info-col">
                        <div class="admin-info-label">Design</div>
                        <div class="admin-info-value">Department</div>
                    </div>
                    <div class="admin-info-col">
                        <div class="admin-info-label">UI UX Designer</div>
                        <div class="admin-info-value">Designation</div>
                    </div>
                </div>

                <a href="{{ route('admin.admins.show') }}" class="admin-view-link">
                    View Profile <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="admin-card">
            <div class="admin-card-header admin-card-header-gradient-3">
                <div class="dropdown">
                    <button class="admin-card-options" type="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <a class="dropdown-item" href="{{ route('admin.admins.show') }}"><i class="fas fa-user text-primary mr-2"></i>View Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.admins.edit') }}"><i class="fas fa-edit text-warning mr-2"></i>Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="admin-avatar-wrapper">
                <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=300&q=80" alt="Jerome Bell" class="admin-avatar-circle">
            </div>
            <div class="admin-card-body">
                <div class="admin-name">Jerome Bell</div>
                <div class="admin-email">ifrandom@gmail.com</div>

                <div class="admin-info-pill-box">
                    <div class="admin-info-col">
                        <div class="admin-info-label">Design</div>
                        <div class="admin-info-value">Department</div>
                    </div>
                    <div class="admin-info-col">
                        <div class="admin-info-label">UI UX Designer</div>
                        <div class="admin-info-value">Designation</div>
                    </div>
                </div>

                <a href="{{ route('admin.admins.show') }}" class="admin-view-link">
                    View Profile <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="admin-card">
            <div class="admin-card-header admin-card-header-gradient-4">
                <div class="dropdown">
                    <button class="admin-card-options" type="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <a class="dropdown-item" href="{{ route('admin.admins.show') }}"><i class="fas fa-user text-primary mr-2"></i>View Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.admins.edit') }}"><i class="fas fa-edit text-warning mr-2"></i>Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="admin-avatar-wrapper">
                <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=300&q=80" alt="Eleanor Pena" class="admin-avatar-circle">
            </div>
            <div class="admin-card-body">
                <div class="admin-name">Eleanor Pena</div>
                <div class="admin-email">ifrandom@gmail.com</div>

                <div class="admin-info-pill-box">
                    <div class="admin-info-col">
                        <div class="admin-info-label">Design</div>
                        <div class="admin-info-value">Department</div>
                    </div>
                    <div class="admin-info-col">
                        <div class="admin-info-label">UI UX Designer</div>
                        <div class="admin-info-value">Designation</div>
                    </div>
                </div>

                <a href="{{ route('admin.admins.show') }}" class="admin-view-link">
                    View Profile <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card 5 -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="admin-card">
            <div class="admin-card-header admin-card-header-gradient-5">
                <div class="dropdown">
                    <button class="admin-card-options" type="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <a class="dropdown-item" href="{{ route('admin.admins.show') }}"><i class="fas fa-user text-primary mr-2"></i>View Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.admins.edit') }}"><i class="fas fa-edit text-warning mr-2"></i>Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="admin-avatar-wrapper">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80" alt="Ralph Edwards" class="admin-avatar-circle">
            </div>
            <div class="admin-card-body">
                <div class="admin-name">Ralph Edwards</div>
                <div class="admin-email">ifrandom@gmail.com</div>

                <div class="admin-info-pill-box">
                    <div class="admin-info-col">
                        <div class="admin-info-label">Referees</div>
                        <div class="admin-info-value">Department</div>
                    </div>
                    <div class="admin-info-col">
                        <div class="admin-info-label">Head Referee</div>
                        <div class="admin-info-value">Designation</div>
                    </div>
                </div>

                <a href="{{ route('admin.admins.show') }}" class="admin-view-link">
                    View Profile <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card 6 -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="admin-card">
            <div class="admin-card-header admin-card-header-gradient-6">
                <div class="dropdown">
                    <button class="admin-card-options" type="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <a class="dropdown-item" href="{{ route('admin.admins.show') }}"><i class="fas fa-user text-primary mr-2"></i>View Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.admins.edit') }}"><i class="fas fa-edit text-warning mr-2"></i>Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="admin-avatar-wrapper">
                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80" alt="Annette Black" class="admin-avatar-circle">
            </div>
            <div class="admin-card-body">
                <div class="admin-name">Annette Black</div>
                <div class="admin-email">ifrandom@gmail.com</div>

                <div class="admin-info-pill-box">
                    <div class="admin-info-col">
                        <div class="admin-info-label">Medical</div>
                        <div class="admin-info-value">Department</div>
                    </div>
                    <div class="admin-info-col">
                        <div class="admin-info-label">Physiotherapist</div>
                        <div class="admin-info-value">Designation</div>
                    </div>
                </div>

                <a href="{{ route('admin.admins.show') }}" class="admin-view-link">
                    View Profile <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card 7 -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="admin-card">
            <div class="admin-card-header admin-card-header-gradient-7">
                <div class="dropdown">
                    <button class="admin-card-options" type="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <a class="dropdown-item" href="{{ route('admin.admins.show') }}"><i class="fas fa-user text-primary mr-2"></i>View Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.admins.edit') }}"><i class="fas fa-edit text-warning mr-2"></i>Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="admin-avatar-wrapper">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80" alt="Robert Fox" class="admin-avatar-circle">
            </div>
            <div class="admin-card-body">
                <div class="admin-name">Robert Fox</div>
                <div class="admin-email">ifrandom@gmail.com</div>

                <div class="admin-info-pill-box">
                    <div class="admin-info-col">
                        <div class="admin-info-label">Administration</div>
                        <div class="admin-info-value">Department</div>
                    </div>
                    <div class="admin-info-col">
                        <div class="admin-info-label">System Admin</div>
                        <div class="admin-info-value">Designation</div>
                    </div>
                </div>

                <a href="{{ route('admin.admins.show') }}" class="admin-view-link">
                    View Profile <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card 8 -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="admin-card">
            <div class="admin-card-header admin-card-header-gradient-8">
                <div class="dropdown">
                    <button class="admin-card-options" type="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <a class="dropdown-item" href="{{ route('admin.admins.show') }}"><i class="fas fa-user text-primary mr-2"></i>View Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.admins.edit') }}"><i class="fas fa-edit text-warning mr-2"></i>Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="admin-avatar-wrapper">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80" alt="Albert Flores" class="admin-avatar-circle">
            </div>
            <div class="admin-card-body">
                <div class="admin-name">Albert Flores</div>
                <div class="admin-email">ifrandom@gmail.com</div>

                <div class="admin-info-pill-box">
                    <div class="admin-info-col">
                        <div class="admin-info-label">Technical</div>
                        <div class="admin-info-value">Department</div>
                    </div>
                    <div class="admin-info-col">
                        <div class="admin-info-label">Match Analyst</div>
                        <div class="admin-info-value">Designation</div>
                    </div>
                </div>

                <a href="{{ route('admin.admins.show') }}" class="admin-view-link">
                    View Profile <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
