@extends('backend.layouts.app')

@section('title', 'Edit User | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-edit text-warning mr-2"></i>Edit System User</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Users</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-warning text-dark">
        <h6 class="m-0 font-weight-bold">Edit User - Mohanad Admin</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.index') }}" method="GET">
            <div class="form-group">
                <label class="font-weight-bold">Full Name</label>
                <input class="form-control" type="text" value="Mohanad Admin" required>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Email Address</label>
                <input class="form-control" type="email" value="mohanad@example.com" required>
            </div>
            <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-sync-alt mr-1"></i> Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
