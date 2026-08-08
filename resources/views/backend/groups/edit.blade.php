@extends('backend.layouts.app')

@section('title', 'Edit Group | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-edit text-warning mr-2"></i>Edit Group Details</h1>
    <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Groups</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-warning text-dark">
        <h6 class="m-0 font-weight-bold">Edit Group A</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.groups.index') }}" method="GET">
            <div class="form-group">
                <label class="font-weight-bold">Group Title</label>
                <input class="form-control" type="text" value="Group A" required>
            </div>
            <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-sync-alt mr-1"></i> Update Group</button>
            <a href="{{ route('admin.groups.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
