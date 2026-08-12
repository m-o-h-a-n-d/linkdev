@extends('backend.layouts.app')

@section('title', 'Group Details | Handball System')

@section('content')
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-layer-group text-primary mr-2"></i>{{ $group->name }} Overview
        </h1>
        <div class="d-flex align-items-center" style="gap: 8px;">
            <a href="{{ route('admin.groups.edit', $group->id) }}" class="btn btn-warning btn-sm shadow-sm">
                <i class="fas fa-edit mr-1"></i> Edit Group
            </a>
            <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Group Details Card -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-info-circle mr-2"></i>{{ $group->name }} Info</h6>
                </div>
                <div class="card-body">
                    <p><strong>Competition:</strong> <span class="badge badge-info">{{ $group->competition?->name ?? 'N/A' }}</span></p>
                    <p><strong>Total Teams:</strong> <span class="badge badge-success">{{ $group->teams->count() }} Team(s)</span></p>
                    <p class="mb-0"><strong>Created At:</strong> {{ $group->created_at?->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Add Team Section with Searchable Select -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-user-plus mr-2"></i>Add Team to Group</h6>
                </div>
                <div class="card-body">
                    @if ($availableTeams->isNotEmpty())
                        <form action="{{ route('admin.groups.attach-team', $group->id) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="team_id" class="font-weight-bold text-gray-800">Select Team (Search by Name):</label>
                                <select name="team_id" id="team_id" class="form-control select2-teams" style="width: 100%;" required>
                                    <option value=""></option>
                                    @foreach ($availableTeams as $team)
                                        <option value="{{ $team->id }}">
                                            {{ $team->name }} ({{ $team->short_name ?? ($team->city ?? 'N/A') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success font-weight-bold shadow-sm">
                                <i class="fas fa-plus-circle mr-1"></i> Add Team to Group
                            </button>
                        </form>
                    @else
                        <div class="text-muted p-2">
                            <i class="fas fa-info-circle mr-1 text-info"></i> All available teams have already been assigned to this group.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Teams in Group List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-dark text-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-users mr-2"></i>Registered Teams in Group ({{ $group->teams->count() }})</h6>
        </div>
        <div class="card-body p-0">
            @if ($group->teams->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Team Name</th>
                                <th>Short Name</th>
                                <th>Location</th>
                                <th class="text-center" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group->teams as $index => $team)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($team->logo)
                                                <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="rounded-circle mr-2" style="width: 32px; height: 32px; object-fit: cover;" onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                                            @else
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-2" style="width: 32px; height: 32px; font-weight: bold; font-size: 12px;">
                                                    {{ strtoupper(substr($team->name, 0, 2)) }}
                                                </div>
                                            @endif
                                            <strong class="text-gray-800">{{ $team->name }}</strong>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-primary px-2 py-1">{{ $team->short_name ?? '-' }}</span></td>
                                    <td class="text-muted">{{ $team->city ?? '-' }}, {{ $team->country ?? '-' }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.groups.detach-team', [$group->id, $team->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove {{ addslashes($team->name) }} from this group?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm shadow-sm" title="Remove from group">
                                                <i class="fas fa-trash-alt mr-1"></i> Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 text-center text-muted">
                    <i class="fas fa-folder-open fa-2x mb-2 text-gray-400 d-block"></i>
                    No teams assigned to this group yet.
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Select2 CDN JS & CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        /* Select2 Dark Theme Visibility Fixes */
        .select2-container--bootstrap4 .select2-selection--single {
            background-color: #1e293b !important;
            border: 1px solid #334155 !important;
            color: #f8fafc !important;
            height: calc(2.25rem + 2px) !important;
            border-radius: 0.375rem !important;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            color: #f8fafc !important;
            line-height: 2.25rem !important;
            padding-left: 0.75rem !important;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__placeholder {
            color: #94a3b8 !important;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow b {
            border-color: #94a3b8 transparent transparent transparent !important;
        }

        /* Dropdown Box Styling */
        .select2-dropdown {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
            z-index: 9999 !important;
        }

        /* Search Input inside Dropdown */
        .select2-search--dropdown {
            background-color: #0f172a !important;
            padding: 8px !important;
        }

        .select2-search--dropdown .select2-search__field {
            background-color: #1e293b !important;
            border: 1px solid #475569 !important;
            color: #ffffff !important;
            border-radius: 4px !important;
            padding: 6px 10px !important;
        }

        .select2-search--dropdown .select2-search__field:focus {
            border-color: #3b82f6 !important;
            outline: none !important;
        }

        /* Option Items Styling */
        .select2-results__option {
            background-color: #0f172a !important;
            color: #f1f5f9 !important; /* Bright clear white/slate text */
            padding: 8px 12px !important;
            font-size: 14px !important;
        }

        .select2-results__option--highlighted[aria-selected] {
            background-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 600 !important;
        }

        .select2-results__option[aria-selected=true] {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
        }

        .select2-results__message {
            color: #94a3b8 !important;
            background-color: #0f172a !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('.select2-teams').select2({
                theme: 'bootstrap4',
                placeholder: '-- Select or Search for Team Name --',
                allowClear: true,
                language: {
                    noResults: function() {
                        return "No matching teams found";
                    }
                }
            });
        });
    </script>
@endpush


