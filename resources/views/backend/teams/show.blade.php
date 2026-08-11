@extends('backend.layouts.app')

@section('title', 'Team Profile | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-shield-alt text-primary mr-2"></i>Team Profile & Details</h1>
    <div>
        <a href="{{ route('admin.teams.edit', $team->id) }}" class="btn btn-warning btn-sm font-weight-bold mr-2"><i class="fas fa-edit mr-1"></i> Edit Team</a>
        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Teams</a>
    </div>
</div>

<!-- Team Banner Header -->
<div class="card shadow mb-4 border-left-{{ $team->status->badgeClass() === 'badge-success' ? 'success' : ($team->status->badgeClass() === 'badge-warning' ? 'warning' : 'danger') }}">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center">
                <div class="team-crest-large bg-light border mr-3 shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                    @if($team->logo && $team->logo !== 'defaults/team-crest.png')
                        <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" style="width: 50px; height: 50px; object-fit: contain;">
                    @else
                        <span class="font-weight-bold text-primary h4 mb-0">{{ strtoupper(substr($team->short_name, 0, 3)) }}</span>
                    @endif
                </div>
                <div>
                    <h2 class="h4 font-weight-bold text-gray-800 mb-1">{{ $team->name }}</h2>
                    <div class="small text-muted">
                        <span class="badge badge-secondary mr-1 px-2 py-1">Code: {{ $team->short_name }}</span>
                        <span class="badge badge-light border mr-1 px-2 py-1"><i class="fas fa-map-marker-alt mr-1"></i>{{ $team->city }}, {{ $team->country }}</span>
                        <span class="badge {{ $team->status->badgeClass() }} px-3 py-1 font-weight-bold">{{ $team->status->label() }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Status Change Actions -->
            <div class="mt-3 mt-md-0 d-flex align-items-center" style="gap: 8px;">
                @if(!$team->isAccepted())
                    <form action="{{ route('admin.teams.accept', $team->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success font-weight-bold shadow-sm">
                            <i class="fas fa-check-circle mr-1"></i> Accept Team
                        </button>
                    </form>
                @endif

                @if(!$team->isRejected())
                    <button type="button" class="btn btn-danger font-weight-bold shadow-sm" data-toggle="modal" data-target="#rejectModalShow">
                        <i class="fas fa-times-circle mr-1"></i> Reject Team
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Team Information Cards -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-info-circle mr-2"></i>General Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="font-weight-bold text-gray-700" style="width: 40%;">Official Team Name:</td>
                        <td>{{ $team->name }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-gray-700">Abbreviation Code:</td>
                        <td><span class="badge badge-secondary px-2 py-1">{{ $team->short_name }}</span></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-gray-700">Country:</td>
                        <td>{{ $team->country }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-gray-700">City / Location:</td>
                        <td>{{ $team->city }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-gray-700">Home Arena / Hall:</td>
                        <td>{{ $team->arena ?? 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-gray-700">Registration Date:</td>
                        <td>{{ $team->created_at ? $team->created_at->format('F d, Y - h:i A') : 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-info text-white">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-user-tie mr-2"></i>Coach & Manager Contact</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="font-weight-bold text-gray-700" style="width: 40%;">Manager / Coach Name:</td>
                        <td>{{ $team->manager_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-gray-700">Email Address:</td>
                        <td>
                            @if($team->email)
                                <a href="mailto:{{ $team->email }}"><i class="fas fa-envelope mr-1"></i>{{ $team->email }}</a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-gray-700">Phone / WhatsApp:</td>
                        <td>
                            @if($team->phone)
                                <a href="tel:{{ $team->phone }}"><i class="fas fa-phone mr-1"></i>{{ $team->phone }}</a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-gray-700">Status:</td>
                        <td><span class="badge {{ $team->status->badgeClass() }} px-3 py-1 font-weight-bold">{{ $team->status->label() }}</span></td>
                    </tr>
                    @if($team->isRejected() && $team->rejection_reason)
                    <tr>
                        <td class="font-weight-bold text-danger">Rejection Reason:</td>
                        <td class="text-danger font-weight-medium">{{ $team->rejection_reason }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModalShow" tabindex="-1" role="dialog" aria-labelledby="rejectModalShowLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.teams.reject', $team->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title font-weight-bold" id="rejectModalShowLabel">Reject Team - {{ $team->name }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-dark">Please specify the reason for rejecting this team request. An email notification will be sent to <strong>{{ $team->email ?? 'the team contact' }}</strong>.</p>
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Rejection Reason (Optional)</label>
                        <textarea name="rejection_reason" class="form-control" rows="4" placeholder="Enter reason..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger font-weight-bold"><i class="fas fa-paper-plane mr-1"></i> Confirm Rejection & Send Mail</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
