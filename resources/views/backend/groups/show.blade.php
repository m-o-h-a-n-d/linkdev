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
                    <p><strong>Display Order:</strong> <span class="badge badge-secondary">#{{ $group->display_order }}</span></p>
                    <p><strong>Total Teams:</strong> <span class="badge badge-success">{{ $group->teams->count() }} Team(s)</span></p>
                    <p class="mb-0"><strong>Created At:</strong> {{ $group->created_at?->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Add Team Section with Searchable Select -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-user-plus mr-2"></i>إضافة فريق إلى المجموعة (Add Team)</h6>
                </div>
                <div class="card-body">
                    @if ($availableTeams->isNotEmpty())
                        <form action="{{ route('admin.groups.attach-team', $group->id) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="team_id" class="font-weight-bold text-gray-800">اختر الفريق (Search by Team Name):</label>
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
                                <i class="fas fa-plus-circle mr-1"></i> إضافة الفريق للمجموعة
                            </button>
                        </form>
                    @else
                        <div class="text-muted p-2">
                            <i class="fas fa-info-circle mr-1 text-info"></i> جميع الأفرقة المتاحة تم إضافتها لهذه المجموعة بالفعل.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Teams in Group List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-dark text-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-users mr-2"></i>الأفرقة المسجلة في هذه المجموعة ({{ $group->teams->count() }})</h6>
        </div>
        <div class="card-body p-0">
            @if ($group->teams->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>اسم الفريق (Team Name)</th>
                                <th>الرمز (Short Name)</th>
                                <th>المدينة/الدولة (Location)</th>
                                <th class="text-center" style="width: 150px;">إجراءات (Action)</th>
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
                                        <form action="{{ route('admin.groups.detach-team', [$group->id, $team->id]) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من إزالة فريق {{ $team->name }} من هذه المجموعة؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm shadow-sm" title="حذف من المجموعة">
                                                <i class="fas fa-trash-alt mr-1"></i> حذف
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
                    لا يوجد أي أفرقة مضافة لهذه المجموعة حالياً.
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

    <script>
        $(document).ready(function() {
            $('.select2-teams').select2({
                theme: 'bootstrap4',
                placeholder: '-- اختر أو ابحث عن اسم الفريق --',
                allowClear: true,
                language: {
                    noResults: function() {
                        return "لم يتم العثور على نتائج";
                    }
                }
            });
        });
    </script>
@endpush

