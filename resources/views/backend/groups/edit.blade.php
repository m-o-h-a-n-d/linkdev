@extends('backend.layouts.app')

@section('title', 'Edit Group | Handball System')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-edit text-warning mr-2"></i>Edit Group Details
        </h1>
        <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i>
            Back to Groups</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-warning text-dark">
            <h6 class="m-0 font-weight-bold">Edit {{ $group->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.groups.update', $group->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="font-weight-bold">Select Competition</label>
                    <select name="competition_id" class="form-control @error('competition_id') is-invalid @enderror"
                        required>
                        @foreach ($competitions as $competition)
                            <option value="{{ $competition->id }}"
                                {{ old('competition_id', $group->competition_id) == $competition->id ? 'selected' : '' }}>
                                {{ $competition->name }}</option>
                        @endforeach
                    </select>
                    @error('competition_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Group Title</label>
                    <input name="name" value="{{ old('name', $group->name) }}"
                        class="form-control @error('name') is-invalid @enderror" type="text" required>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Display Order</label>
                    <input name="display_order" value="{{ old('display_order', $group->display_order) }}"
                        class="form-control @error('display_order') is-invalid @enderror" type="number" min="1">
                    @error('display_order')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-sync-alt mr-1"></i> Update
                    Group</button>
                <a href="{{ route('admin.groups.index') }}" class="btn btn-light ml-2">Cancel</a>
            </form>
        </div>
    </div>
@endsection
