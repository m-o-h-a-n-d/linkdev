@extends('backend.layouts.app')

@section('title', 'Users & Roles | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-user-shield text-primary mr-2"></i>Users & System Roles Table</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm shadow-sm"><i class="fas fa-user-plus mr-1"></i> Add User</a>
</div>

<!-- Users Table -->
<div class="card mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-gray-800">System Users Table</h6>
        <span class="badge badge-primary font-weight-bold">Active System Users</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Email Verification</th>
                        <th>Registered Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-weight-bold">
                            <span class="text-primary font-weight-bold"><i class="fas fa-user-circle mr-1 text-primary"></i> Mohanad Admin</span>
                        </td>
                        <td class="font-weight-medium text-gray-800">mohanad@example.com</td>
                        <td><span class="badge badge-primary">Administrator</span></td>
                        <td><span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>Verified</span></td>
                        <td class="text-muted">Jan 01, 2025</td>
                        <td class="text-right">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.users.edit') }}"><i class="fas fa-edit mr-1"></i> Edit</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
