@extends('backend.layouts.app')

@section('title', 'Groups Management | Handball System')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-layer-group text-primary mr-2"></i>Groups Directory
        </h1>
        <a href="{{ route('admin.groups.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus mr-1"></i> Add Group
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4 shadow-sm">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-gray-800">All Groups Table</h6>
            <span class="badge badge-primary font-weight-bold">{{ $groups->count() }} Group(s)</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="text-gray-800">Group Name</th>
                            <th class="text-gray-800">Competition</th>
                            <th class="text-right text-gray-800">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($groups as $group)
                            <tr>
                                <td class="font-weight-bold align-middle">
                                    <a href="{{ route('admin.groups.show', $group->id) }}"
                                        class="text-primary font-weight-bold">
                                        {{ $group->name }}
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-dark px-2 py-2"
                                        style="background-color: #0f172a; color: #ffffff;">
                                        {{ $group->competition?->name ?? 'No Competition' }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('admin.groups.show', $group->id) }}">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                        <a class="btn btn-warning btn-sm"
                                            href="{{ route('admin.groups.edit', $group->id) }}">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.groups.destroy', $group->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this group?')">
                                                <i class="fas fa-trash-alt mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No groups found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
