@extends('backend.layouts.app')

@section('title', 'Groups Directory | Handball System')

@push('styles')
    <style>
        .group-card {
            background-color: #0b1329;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #1e293b;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .group-card:hover {
            border-color: rgba(234, 88, 12, 0.4);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .team-row-item {
            background-color: #070d18;
            border-radius: 12px;
            border: 1px solid #1e293b;
            padding: 10px 14px;
            transition: all 0.2s ease;
        }

        .team-row-item:hover {
            background-color: #0e1628;
            border-color: #334155;
            transform: translateX(2px);
        }

        .team-code-badge {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 8px;
            font-weight: 700;
            min-width: 48px;
            text-align: center;
            font-size: 0.78rem;
            padding: 3px 6px;
            display: inline-block;
        }

        .team-country-badge {
            background: rgba(148, 163, 184, 0.1);
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 6px;
            font-size: 0.75rem;
            padding: 2px 8px;
            font-weight: 500;
        }
    </style>
@endpush

@section('content')
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-white font-weight-bold d-flex align-items-center">
                <span class="p-2 rounded mr-2 d-inline-flex align-items-center justify-content-center" style="background: rgba(234, 88, 12, 0.2); color: #ea580c; width: 38px; height: 38px; border-radius: 10px;">
                    <i class="fas fa-layer-group"></i>
                </span>
                Groups Directory
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Competition Groups</li>
                </ol>
            </nav>
        </div>
        @can('groups.create')
        <a href="{{ route('admin.groups.create') }}" class="btn btn-primary shadow-sm font-weight-bold px-4 py-2" style="border-radius: 10px;">
            <i class="fas fa-plus mr-2"></i> Add Group
        </a>
        @endcan
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

    <!-- Groups Grid -->
    <div class="row">
        @forelse ($groups as $group)
            <div class="col-12 col-xl-6 mb-4">
                <div class="card border-0 shadow-lg h-100 group-card">
                    <!-- Card Header -->
                    <div class="card-header border-0 px-4 py-3" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important; color: #ffffff !important;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                            <!-- Group Title & Competition -->
                            <div class="d-flex align-items-center flex-grow-1 min-width-0">
                                <div class="mr-3" style="width: 38px; height: 38px; border-radius: 10px; background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-layer-group text-white" style="font-size: 1.1rem;"></i>
                                </div>
                                <div class="text-truncate">
                                    <h5 class="mb-0 font-weight-bold text-white text-truncate">
                                        @can('groups.view')
                                        <a href="{{ route('admin.groups.show', $group->id) }}" class="text-white text-decoration-none">
                                            {{ $group->name }}
                                        </a>
                                        @else
                                        {{ $group->name }}
                                        @endcan
                                    </h5>
                                    <span class="small font-weight-bold" style="color: #fed7aa; opacity: 0.95;">
                                        <i class="fas fa-trophy mr-1 text-warning small"></i> {{ $group->competition?->name ?? 'No Competition Assigned' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Actions & Teams Counter -->
                            <div class="d-flex align-items-center" style="gap: 6px; flex-shrink: 0;">
                                @can('groups.view')
                                <a href="{{ route('admin.groups.show', $group->id) }}" class="btn btn-sm font-weight-bold shadow-sm px-3 py-1" style="border-radius: 20px; font-size: 0.8rem; background-color: #ffffff !important; color: #ea580c !important; border: none !important;">
                                    <i class="fas fa-users mr-1"></i> {{ $group->teams->count() }} Teams
                                </a>
                                @endcan

                                @can('groups.edit')
                                <a href="{{ route('admin.groups.edit', $group->id) }}" class="btn btn-sm btn-outline-light font-weight-bold shadow-sm px-2 py-1" style="border-radius: 8px; background: rgba(0, 0, 0, 0.2) !important; border-color: rgba(255, 255, 255, 0.4) !important; color: #ffffff !important;" title="Edit Group">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('groups.delete')
                                <form action="{{ route('admin.groups.destroy', $group->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this group?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm font-weight-bold shadow-sm px-2 py-1" style="border-radius: 8px; background: rgba(220, 38, 38, 0.8); color: #fff; border: 1px solid rgba(255,255,255,0.2);" title="Delete Group">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <!-- Card Body (Teams List) -->
                    <div class="card-body p-3 p-md-4" style="background-color: #0b1329;">
                        @if ($group->teams->isNotEmpty())
                            <div class="d-flex flex-column" style="gap: 8px;">
                                @foreach ($group->teams as $team)
                                    <div class="d-flex align-items-center justify-content-between team-row-item">
                                        <div class="d-flex align-items-center text-truncate mr-2">
                                            <img src="{{ $team->logo_url }}" alt="{{ $team->name }}" referrerpolicy="no-referrer" style="width: 30px; height: 30px; object-fit: contain; background: #070d18; border-radius: 6px; padding: 2px;" class="mr-2 flex-shrink-0" onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                                            <span class="team-code-badge mr-2">
                                                {{ $team->short_name ?? strtoupper(substr($team->name, 0, 3)) }}
                                            </span>
                                            <strong class="text-white font-weight-bold text-truncate" style="font-size: 0.92rem;">{{ $team->name }}</strong>
                                        </div>
                                        @if($team->country || $team->city)
                                            <span class="team-country-badge flex-shrink-0 ml-2">
                                                {{ $team->country ?? $team->city }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 text-muted" style="background-color: #070d18; border-radius: 12px; border: 1px dashed #1e293b;">
                                <i class="fas fa-folder-open fa-2x mb-2 text-gray-600 d-block"></i>
                                No teams added to this group yet.
                                @can('groups.view')
                                <a href="{{ route('admin.groups.show', $group->id) }}" class="text-primary font-weight-bold ml-1">Manage Teams</a>
                                @endcan
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
                        @can('groups.create')
                        <a href="{{ route('admin.groups.create') }}" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px;">
                            <i class="fas fa-plus mr-1"></i> Add New Group
                        </a>
                        @endcan
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
