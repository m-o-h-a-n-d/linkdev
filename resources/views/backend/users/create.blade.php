@extends('backend.layouts.app')

@section('title', 'Add System User | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-user-plus text-primary mr-2"></i>Create System User</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Users</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h6 class="m-0 font-weight-bold">User Account Form</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.index') }}" method="GET">
            <div class="form-group">
                <label class="font-weight-bold">Full Name</label>
                <input class="form-control" type="text" placeholder="John Doe" required>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Email Address</label>
                <input class="form-control" type="email" placeholder="john@example.com" required>
            </div>
            <div class="form-group mb-4">
                <label class="font-weight-bold">Role</label>
                <select class="form-control">
                    <option value="admin">Administrator</option>
                    <option value="manager" selected>Competition Manager</option>
                    <option value="viewer">Viewer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
