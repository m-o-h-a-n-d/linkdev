@extends('backend.layouts.app')

@section('title', 'Create Competition | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-plus-circle text-primary mr-2"></i>Create New Competition</h1>
    <a href="{{ route('admin.competitions.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Competitions</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h6 class="m-0 font-weight-bold text-white">Competition Setup Form</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.competitions.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="font-weight-bold" for="name">Competition Full Title</label>
                <input id="name" name="name" class="form-control" type="text" value="{{ old('name') }}" placeholder="e.g. African Handball Champions League 2026" required>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold" for="season">Season</label>
                    <input id="season" name="season" class="form-control" type="text" value="{{ old('season') }}" placeholder="2025/2026" required>
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold" for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold" for="start_date">Start Date</label>
                    <input id="start_date" name="start_date" class="form-control" type="date" value="{{ old('start_date') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold" for="end_date">End Date</label>
                    <input id="end_date" name="end_date" class="form-control" type="date" value="{{ old('end_date') }}" required>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="font-weight-bold" for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="5" placeholder="Describe the competition..." required>{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Competition</button>
            <a href="{{ route('admin.competitions.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
