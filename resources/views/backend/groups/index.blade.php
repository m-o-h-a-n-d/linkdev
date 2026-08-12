@extends('backend.layouts.app')

@section('title', 'Groups Directory | Handball System')

@section('content')
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-white font-weight-bold d-flex align-items-center">
            <span class="p-2 rounded mr-2 d-inline-flex align-items-center justify-content-center" style="background: rgba(234, 88, 12, 0.2); color: #ea580c; width: 38px; height: 38px;">
                <i class="fas fa-layer-group"></i>
            </span>
            Groups Directory Table
        </h1>
        <a href="{{ route('admin.groups.create') }}" class="btn btn-primary btn-sm shadow-sm font-weight-bold px-3 py-2" style="border-radius: 8px;">
            <i class="fas fa-plus mr-1"></i> Add Group
        </a>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 10px;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 10px;">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Groups Grid / List -->
    <div class="row">
        @forelse ($groups as $group)
            <div class="col-12 col-xl-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background-color: #0b1329; border-radius: 16px; overflow: hidden; border: 1px solid #1e293b;">
                    <!-- Card Header (Vibrant Orange Banner) -->
                    <div class="card-header border-0 d-flex align-items-center justify-content-between px-4 py-3" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important; color: #ffffff !important;">
                        <div class="d-flex align-items-center overflow-hidden mr-2">
                            <i class="fas fa-layer-group text-white mr-2" style="font-size: 1.1rem; flex-shrink: 0;"></i>
                            <a href="{{ route('admin.groups.show', $group->id) }}" class="h5 mb-0 font-weight-bold text-white text-truncate text-decoration-none" title="{{ $group->name }} • {{ $group->competition?->name ?? 'No Competition' }}">
                                {{ $group->name }} <span style="opacity: 0.9; font-weight: 500;">• {{ $group->competition?->name ?? 'No Competition' }}</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 8px; flex-shrink: 0;">
                            <a href="{{ route('admin.groups.edit', $group->id) }}" class="btn btn-sm btn-outline-light font-weight-bold shadow-sm px-3" style="border-radius: 8px; background: rgba(0, 0, 0, 0.15) !important; border-color: rgba(255, 255, 255, 0.4) !important; color: #ffffff !important;">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.groups.show', $group->id) }}" class="btn btn-sm btn-light font-weight-bold shadow-sm px-3 py-1" style="border-radius: 20px; font-size: 0.85rem; background-color: #ffffff !important; color: #0f172a !important; border: none !important;">
                                <i class="fas fa-users mr-1" style="color: #ea580c !important;"></i> {{ $group->teams->count() }} Teams
                            </a>
                            <form action="{{ route('admin.groups.destroy', $group->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this group?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger font-weight-bold shadow-sm px-2" style="border-radius: 8px;" title="Delete Group">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Card Body (Teams List) -->
                    <div class="card-body p-3 p-md-4" style="background-color: #0b1329;">
                        @if ($group->teams->isNotEmpty())
                            <div class="d-flex flex-column" style="gap: 10px;">
                                @foreach ($group->teams as $index => $team)
                                    <div class="d-flex align-items-center justify-content-between p-3" style="background-color: #070d18; border-radius: 12px; border: 1px solid #1e293b;">
                                        <div class="d-flex align-items-center overflow-hidden mr-2">
                                            <span class="badge mr-3 px-2 py-1" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; font-weight: 700; min-width: 44px; text-align: center; font-size: 0.8rem;">
                                                {{ $team->short_name ?? strtoupper(substr($team->name, 0, 3)) }}
                                            </span>
                                            <strong class="text-white font-weight-bold mr-2 text-truncate" style="font-size: 0.95rem;">{{ $team->name }}</strong>
                                            <span class="text-muted text-truncate" style="font-size: 0.85rem;">({{ $team->country ?? ($team->city ?? 'N/A') }})</span>
                                        </div>
                                        <div style="flex-shrink: 0;">
                                            <span class="badge px-3 py-2" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 20px; font-weight: 600; font-size: 0.85rem;">
                                                <i class="fas fa-award mr-1"></i> Rank {{ $index + 1 }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 text-muted" style="background-color: #070d18; border-radius: 12px; border: 1px dashed #1e293b;">
                                <i class="fas fa-folder-open fa-2x mb-2 text-gray-600 d-block"></i>
                                No teams added to this group yet.
                                <a href="{{ route('admin.groups.show', $group->id) }}" class="text-primary font-weight-bold ml-1">Manage Teams</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow p-5 text-center text-muted" style="background-color: #0b1329; border-radius: 16px; border: 1px dashed #1e293b;">
                    <i class="fas fa-layer-group fa-3x mb-3 text-gray-600"></i>
                    <h5 class="text-white font-weight-bold">No Groups Found</h5>
                    <p class="mb-3">Get started by creating your first competition group.</p>
                    <div>
                        <a href="{{ route('admin.groups.create') }}" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px;">
                            <i class="fas fa-plus mr-1"></i> Add New Group
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links if available -->
    @if(method_exists($groups, 'links'))
        <div class="d-flex justify-content-center mt-3">
            {{ $groups->links() }}
        </div>
    @endif
@endsection

