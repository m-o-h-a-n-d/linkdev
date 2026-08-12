@extends('backend.layouts.app')

@section('title', 'Group Details | Handball System')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i
                class="fas fa-layer-group text-primary mr-2"></i>{{ $group->name }} Overview</h1>
        <div class="d-flex align-items-center" style="gap: 8px;">
            <a href="{{ route('admin.groups.edit', $group->id) }}" class="btn btn-warning btn-sm"><i
                    class="fas fa-edit mr-1"></i>
                Edit Group</a>
            <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary btn-sm"><i
                    class="fas fa-arrow-left mr-1"></i> Back</a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold text-white">{{ $group->name }} Details</h6>
        </div>
        <div class="card-body">
            <p><strong>Competition:</strong> {{ $group->competition?->name ?? 'N/A' }}</p>
            <p><strong>Display Order:</strong> {{ $group->display_order }}</p>
            <p><strong>Created At:</strong> {{ $group->created_at?->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-gray-800">Teams in this group</h6>
        </div>
        <div class="card-body">
            @if ($group->teams->isNotEmpty())
                <div class="list-group">
                    @foreach ($group->teams as $team)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $team->name }}</strong>
                                <div class="small text-muted">{{ $team->city }}, {{ $team->country }}</div>
                            </div>
                            <span class="badge badge-primary">{{ $team->short_name }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-muted">No teams assigned to this group yet.</div>
            @endif
        </div>
    </div>
@endsection
