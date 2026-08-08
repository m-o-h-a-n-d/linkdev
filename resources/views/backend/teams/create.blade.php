@extends('backend.layouts.app')

@section('title', 'Register Team | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-plus-circle text-success mr-2"></i>Register New Handball Team</h1>
    <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Teams</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-success text-white">
        <h6 class="m-0 font-weight-bold">Team Registration Form</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.teams.index') }}" method="GET">
            <div class="form-group">
                <label class="font-weight-bold">Team Full Name</label>
                <input class="form-control" type="text" placeholder="e.g. Al Ahly Handball Club" required>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold">Short Code / Abbreviation</label>
                    <input class="form-control" type="text" placeholder="AHL" maxlength="4" required>
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold">City</label>
                    <input class="form-control" type="text" placeholder="Cairo" required>
                </div>
            </div>
            <div class="form-group mb-4">
                <label class="font-weight-bold">Country</label>
                <input class="form-control" type="text" placeholder="Egypt" required>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Register Team</button>
            <a href="{{ route('admin.teams.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
