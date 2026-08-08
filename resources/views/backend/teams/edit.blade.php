@extends('backend.layouts.app')

@section('title', 'Edit Team | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-edit text-warning mr-2"></i>Edit Team Details</h1>
    <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Teams</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-warning text-dark">
        <h6 class="m-0 font-weight-bold">Edit Team - Al Ahly SC</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.teams.index') }}" method="GET">
            <div class="form-group">
                <label class="font-weight-bold">Team Full Name</label>
                <input class="form-control" type="text" value="Al Ahly Handball SC" required>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold">Short Code</label>
                    <input class="form-control" type="text" value="AHL" maxlength="4" required>
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold">City</label>
                    <input class="form-control" type="text" value="Cairo" required>
                </div>
            </div>
            <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-sync-alt mr-1"></i> Update Team</button>
            <a href="{{ route('admin.teams.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
