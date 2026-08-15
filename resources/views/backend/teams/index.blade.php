@extends('backend.layouts.app')

@section('title', 'Teams Directory | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-shield-alt text-primary mr-2"></i>Handball Teams Directory</h1>
    <div class="d-flex align-items-center" style="gap: 8px;">
        @can('teams.create')
        <a href="{{ route('admin.teams.create') }}" class="btn btn-success btn-sm shadow-sm font-weight-bold"><i class="fas fa-plus mr-1"></i> Register Team</a>
        @endcan
        <button type="button" class="btn btn-primary btn-sm shadow-sm font-weight-bold" onclick="copyPublicTeamRegistrationLink()" id="linkFormBtn">
            <i class="fas fa-link mr-1"></i> Copy Form Link
        </button>
        <a href="{{ route('team-registration.public') }}" target="_blank" class="btn btn-outline-primary btn-sm shadow-sm font-weight-bold" title="Open Public Coach Registration Form">
            <i class="fas fa-external-link-alt mr-1"></i> Open Public Form
        </a>
    </div>
</div>

<!-- Session Alerts -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert" style="border-radius: 12px; border-left: 5px solid #10b981; background: #064e3b; color: #a7f3d0;">
    <i class="fas fa-check-circle mr-2 text-success"></i> <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Success Alert for Link Copy -->
<div id="copySuccessAlert" class="alert alert-success alert-dismissible fade show d-none mb-4 shadow-sm" role="alert" style="border-radius: 12px; border-left: 5px solid #10b981; background: #064e3b; color: #a7f3d0;">
    <i class="fas fa-check-circle mr-2 text-success"></i> <strong>Public Registration Link Copied!</strong> Share this link with team coaches: <code id="copiedUrlText" class="px-2 py-1 rounded text-warning font-weight-bold ml-1" style="background: #022c22;"></code>
    <button type="button" class="close text-white" onclick="document.getElementById('copySuccessAlert').classList.add('d-none')">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Teams Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-white">Registered Handball Teams</h6>
        <span class="badge badge-primary font-weight-bold px-3 py-2" style="border-radius: 20px;">{{ $teams->total() }} Total Teams</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="py-3">Team & Crest</th>
                        <th class="py-3">Short Code</th>
                        <th class="py-3">Contact Email & Manager</th>
                        <th class="py-3">Location</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Registered Date</th>
                        <th class="py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teams as $team)
                    <tr>
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <div class="team-crest-wrapper mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 12px; background: rgba(234, 88, 12, 0.1); border: 1px solid rgba(234, 88, 12, 0.25); overflow: hidden; padding: 3px;">
                                    <img src="{{ $team->logo_url }}" alt="{{ $team->name }}" referrerpolicy="no-referrer" style="width: 100%; height: 100%; object-fit: contain;" onerror="this.src='{{ asset('backend/img/undraw_profile.svg') }}'">
                                </div>
                                <div>
                                    <a href="{{ route('admin.teams.show', $team->id) }}" class="font-weight-bold text-white h6 mb-0">{{ $team->name }}</a>
                                    @if($team->arena)
                                        <div class="text-muted small"><i class="fas fa-warehouse mr-1"></i>{{ $team->arena }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-3"><span class="badge badge-secondary px-3 py-1 font-weight-bold" style="border-radius: 20px;">{{ $team->short_name }}</span></td>
                        <td class="py-3">
                            <div class="font-weight-medium text-white small">{{ $team->manager_name ?? 'N/A' }}</div>
                            <div class="text-muted small"><i class="fas fa-envelope mr-1 text-primary"></i>{{ $team->email ?? 'N/A' }}</div>
                        </td>
                        <td class="py-3">
                            <div class="font-weight-medium text-white small">{{ $team->city }}</div>
                            <div class="text-muted small">{{ $team->country }}</div>
                        </td>
                        <td class="py-3">
                            @if($team->isPending())
                                <span class="badge badge-warning px-3 py-2 font-weight-bold" style="border-radius: 20px; font-size: 0.8rem;"><i class="fas fa-clock mr-1"></i> Pending</span>
                            @elseif($team->isAccepted())
                                <span class="badge badge-success px-3 py-2 font-weight-bold" style="border-radius: 20px; font-size: 0.8rem;"><i class="fas fa-check-circle mr-1"></i> Accepted</span>
                            @elseif($team->isRejected())
                                <span class="badge badge-danger px-3 py-2 font-weight-bold" style="border-radius: 20px; font-size: 0.8rem;" data-toggle="tooltip" title="Reason: {{ $team->rejection_reason ?? 'No reason specified' }}">
                                    <i class="fas fa-times-circle mr-1"></i> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="py-3 text-muted small">{{ $team->created_at ? $team->created_at->format('M d, Y') : 'N/A' }}</td>
                        <td class="py-3 text-right">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <!-- Accept / Reject Status Actions -->
                                @can('teams.edit')
                                    @if(!$team->isAccepted())
                                        <form action="{{ route('admin.teams.accept', $team->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm font-weight-bold px-2 py-1" title="Accept Team & Send Email">
                                                <i class="fas fa-check"></i> Accept
                                            </button>
                                        </form>
                                    @endif

                                    @if(!$team->isRejected())
                                        <button type="button" class="btn btn-danger btn-sm font-weight-bold px-2 py-1" data-toggle="modal" data-target="#rejectModal{{ $team->id }}" title="Reject Team & Send Email">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    @endif
                                @endcan

                                @can('teams.view')
                                <a class="btn btn-info btn-sm rounded-lg font-weight-bold px-2 py-1" href="{{ route('admin.teams.show', $team->id) }}" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan

                                @can('teams.edit')
                                <a class="btn btn-warning btn-sm rounded-lg font-weight-bold px-2 py-1" href="{{ route('admin.teams.edit', $team->id) }}" title="Edit Details">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('teams.delete')
                                <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this team?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm font-weight-bold px-2 py-1" title="Delete Team">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>

                            <!-- Reject Reason Modal -->
                            @can('teams.edit')
                            <div class="modal fade text-left" id="rejectModal{{ $team->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $team->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="background: #0e1626; border: 1px solid #1e293b;">
                                        <form action="{{ route('admin.teams.reject', $team->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title font-weight-bold" id="rejectModalLabel{{ $team->id }}">Reject Team - {{ $team->name }}</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-gray-300">Please specify the reason for rejecting this team request. An email notification with this reason will be sent to <strong>{{ $team->email ?? 'the team contact' }}</strong>.</p>
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-gray-300">Rejection Reason (Optional)</label>
                                                    <textarea name="rejection_reason" class="form-control" rows="4" placeholder="e.g. Missing required official documentation or incomplete squad details..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top: 1px solid #1e293b;">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger font-weight-bold"><i class="fas fa-paper-plane mr-1"></i> Confirm Rejection & Send Mail</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endcan

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 text-gray-400"></i>
                            <p class="h6 mb-0 text-gray-300">No teams found in the database.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($teams->hasPages())
    <div class="card-footer py-3 d-flex justify-content-between align-items-center" style="background: #162238; border-top: 1px solid #1e293b;">
        <div class="small text-muted">
            Showing {{ $teams->firstItem() }} to {{ $teams->lastItem() }} of {{ $teams->total() }} teams
        </div>
        <div>
            {{ $teams->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function copyPublicTeamRegistrationLink() {
        const publicFormUrl = "{{ route('team-registration.public') }}";
        const fullUrl = window.location.origin + publicFormUrl;

        navigator.clipboard.writeText(fullUrl).then(function() {
            const alertBox = document.getElementById('copySuccessAlert');
            const urlText = document.getElementById('copiedUrlText');
            if (urlText && alertBox) {
                urlText.innerText = fullUrl;
                alertBox.classList.remove('d-none');
            }
            const btn = document.getElementById('linkFormBtn');
            if (btn) {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
                btn.classList.replace('btn-primary', 'btn-success');
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.classList.replace('btn-success', 'btn-primary');
                }, 3000);
            }
        }).catch(function(err) {
            alert('Form Link: ' + window.location.origin + publicFormUrl);
        });
    }
</script>
@endpush
@endsection
