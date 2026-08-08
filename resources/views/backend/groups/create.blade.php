@extends('backend.layouts.app')

@section('title', 'Add Group | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-layer-group text-primary mr-2"></i>Add New Group</h1>
    <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Groups</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h6 class="m-0 font-weight-bold">Group Creation Form</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.groups.index') }}" method="GET">
            <div class="form-group">
                <label class="font-weight-bold">Select Competition</label>
                <select class="form-control">
                    <option>EHF Champions League 2025/2026</option>
                    <option>Egyptian Premier League 2025/2026</option>
                </select>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Group Title</label>
                <input class="form-control" type="text" placeholder="e.g. Group C" required>
            </div>
            <div class="form-group mb-4">
                <label class="font-weight-bold">Display Order</label>
                <input class="form-control" type="number" value="1" min="1">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Group</button>
            <a href="{{ route('admin.groups.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
