@extends('backend.layouts.app')

@section('title', 'Edit Competition | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-edit text-warning mr-2"></i>Edit Competition Details</h1>
    <a href="{{ route('admin.competitions.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Competitions</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-warning text-dark">
        <h6 class="m-0 font-weight-bold">Edit Form - EHF Champions League 2025/2026</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.competitions.index') }}" method="GET">
            <div class="form-group">
                <label class="font-weight-bold">Competition Full Title</label>
                <input class="form-control" type="text" value="EHF Champions League 2025/2026" required>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold">Season</label>
                    <input class="form-control" type="text" value="2025/2026" required>
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold">Tournament Format</label>
                    <select class="form-control">
                        <option value="league">League Table</option>
                        <option value="knockout">Knockout Brackets</option>
                        <option value="mixed" selected>Group Stage + Knockout</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-sync-alt mr-1"></i> Update Competition</button>
            <a href="{{ route('admin.competitions.index') }}" class="btn btn-light ml-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
