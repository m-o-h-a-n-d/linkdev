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
        <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="font-weight-bold text-gray-700">Team Full Name *</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Al Ahly Handball Club" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Short Code / Abbreviation *</label>
                    <input class="form-control @error('short_name') is-invalid @enderror" type="text" name="short_name" value="{{ old('short_name') }}" placeholder="e.g. AHL" maxlength="20" required>
                    @error('short_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">City *</label>
                    <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" value="{{ old('city') }}" placeholder="e.g. Cairo" required>
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Country *</label>
                    <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" value="{{ old('country', 'Egypt') }}" placeholder="e.g. Egypt" required>
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Home Sports Hall / Arena</label>
                    <input class="form-control @error('arena') is-invalid @enderror" type="text" name="arena" value="{{ old('arena') }}" placeholder="e.g. Al Ahly Sports Hall">
                    @error('arena')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Manager / Head Coach Name</label>
                    <input class="form-control @error('manager_name') is-invalid @enderror" type="text" name="manager_name" value="{{ old('manager_name') }}" placeholder="e.g. Captain David Davis">
                    @error('manager_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Contact Email Address</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="e.g. coach@club.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Phone / WhatsApp</label>
                    <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. +20 100 000 0000">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Initial Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                        <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="font-weight-bold text-gray-700">Team Logo / Crest Image</label>
                <input type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror" accept="image/*">
                <small class="form-text text-muted">Allowed formats: PNG, JPG, JPEG, WEBP. Max size: 2MB.</small>
                @error('logo')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success font-weight-bold px-4"><i class="fas fa-save mr-1"></i> Register Team</button>
            <a href="{{ route('admin.teams.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
