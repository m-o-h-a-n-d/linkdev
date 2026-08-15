@extends('backend.layouts.app')

@section('title', 'Edit Team | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-edit text-warning mr-2"></i>Edit Team Details</h1>
    <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Teams</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-warning text-dark">
        <h6 class="m-0 font-weight-bold">Edit Team - {{ $team->name }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="font-weight-bold text-gray-700">Team Full Name *</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $team->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Short Code / Abbreviation *</label>
                    <input class="form-control @error('short_name') is-invalid @enderror" type="text" name="short_name" value="{{ old('short_name', $team->short_name) }}" maxlength="20" required>
                    @error('short_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">City *</label>
                    <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" value="{{ old('city', $team->city) }}" required>
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Country *</label>
                    <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" value="{{ old('country', $team->country) }}" required>
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Home Sports Hall / Arena</label>
                    <input class="form-control @error('arena') is-invalid @enderror" type="text" name="arena" value="{{ old('arena', $team->arena) }}">
                    @error('arena')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Manager / Head Coach Name</label>
                    <input class="form-control @error('manager_name') is-invalid @enderror" type="text" name="manager_name" value="{{ old('manager_name', $team->manager_name) }}">
                    @error('manager_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Contact Email Address</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $team->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Phone / WhatsApp</label>
                    <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone', $team->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold text-gray-700">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="pending" {{ old('status', $team->status->value) == 'pending' ? 'selected' : '' }}>Pending Review</option>
                        <option value="accepted" {{ old('status', $team->status->value) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ old('status', $team->status->value) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="font-weight-bold text-gray-700">Rejection Reason (If Status is Rejected)</label>
                <textarea name="rejection_reason" class="form-control @error('rejection_reason') is-invalid @enderror" rows="3" placeholder="Reason for rejection...">{{ old('rejection_reason', $team->rejection_reason) }}</textarea>
                @error('rejection_reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <div class="mb-2">
                    <img src="{{ $team->logo_url }}" alt="Current Logo" style="height: 50px; object-fit: contain;" class="rounded border p-1" onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                </div>
                <input type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror" accept="image/*">
                @error('logo')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-warning font-weight-bold px-4"><i class="fas fa-sync-alt mr-1"></i> Update Team</button>
            <a href="{{ route('admin.teams.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
