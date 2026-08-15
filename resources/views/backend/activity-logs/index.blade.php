@extends('backend.layouts.app')

@section('title', 'System Activity & Audit Logs | Handball System')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-white font-weight-bold">
                <i class="fas fa-history text-primary mr-2"></i>System Activity & Audit Logs
            </h1>
            <p class="text-muted mb-0 small">Real-time audit trail and administrative activity tracking across the system.</p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex align-items-center" style="gap: 10px;">
            <span class="badge badge-success px-3 py-2 font-weight-bold shadow-sm" style="border-radius: 20px; background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4);">
                <i class="fas fa-circle mr-1 animate-pulse" style="font-size: 8px;"></i> Live Audit Feed
            </span>

            @if($logs->total() > 0)
                <button type="button" class="btn btn-danger btn-sm font-weight-bold px-3 py-2 shadow-sm" data-toggle="modal" data-target="#clearAllLogsModal" style="border-radius: 10px;">
                    <i class="fas fa-trash-alt mr-1"></i> Delete All Logs
                </button>
            @endif
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

    <!-- KPI Summary Cards Row -->
    <div class="row mb-4">
        <!-- Total Logs Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 py-2" style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; border-left: 4px solid #f97316 !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #94a3b8; letter-spacing: 0.5px;">Total Logs Recorded</div>
                            <div class="h4 mb-0 font-weight-bold text-white">{{ number_format($stats['total_logs'] ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 12px; background: rgba(249, 115, 22, 0.15); color: #f97316;">
                                <i class="fas fa-database fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Activity Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 py-2" style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; border-left: 4px solid #10b981 !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #94a3b8; letter-spacing: 0.5px;">Today's Activities</div>
                            <div class="h4 mb-0 font-weight-bold text-white">{{ number_format($stats['today_logs'] ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); color: #10b981;">
                                <i class="fas fa-calendar-day fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 py-2" style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; border-left: 4px solid #06b6d4 !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #94a3b8; letter-spacing: 0.5px;">Active Performers</div>
                            <div class="h4 mb-0 font-weight-bold text-white">{{ number_format($stats['unique_users'] ?? 0) }} Users</div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 12px; background: rgba(6, 182, 212, 0.15); color: #06b6d4;">
                                <i class="fas fa-users-cog fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Most Frequent Action Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm h-100 py-2" style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; border-left: 4px solid #f59e0b !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #94a3b8; letter-spacing: 0.5px;">Primary Action</div>
                            <div class="h4 mb-0 font-weight-bold text-white text-uppercase">{{ $stats['top_action'] ?? 'N/A' }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); color: #f59e0b;">
                                <i class="fas fa-bolt fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audit Logs Data Table Card -->
    <div class="card shadow-sm mb-4" style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px;">
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background: #162238; border-bottom: 1px solid #1e293b; border-radius: 16px 16px 0 0;">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-list-alt text-primary mr-2"></i>Audit Trail Records
            </h6>
            <span class="badge badge-primary font-weight-bold px-3 py-2" style="border-radius: 20px;">
                {{ $logs->total() }} Total Records
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="py-3">Performer (User)</th>
                            <th class="py-3">Action</th>
                            <th class="py-3">Target Entity</th>
                            <th class="py-3">Description</th>
                            <th class="py-3">Client Info</th>
                            <th class="py-3 text-right">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <!-- Performer -->
                                <td class="py-3 text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 d-flex align-items-center justify-content-center"
                                             style="width: 38px; height: 38px; border-radius: 12px; background: rgba(234, 88, 12, 0.15); border: 1px solid rgba(234, 88, 12, 0.3); color: #f97316;">
                                            <i class="fas fa-user font-weight-bold"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-white" style="font-size: 14px;">{{ $log->user->name ?? 'System' }}</div>
                                            <div class="text-muted small">{{ $log->user->email ?? 'Automated Job' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Action Badge -->
                                <td class="py-3">
                                    <span class="badge px-3 py-2 font-weight-bold text-uppercase"
                                          style="border-radius: 20px; font-size: 11px; letter-spacing: 0.5px; {{ $log->action_badge_style }}">
                                        {{ $log->action }}
                                    </span>
                                </td>

                                <!-- Target Entity -->
                                <td class="py-3 text-nowrap">
                                    <span class="font-weight-bold text-white">{{ $log->entity_type }}</span>
                                    <span class="badge px-2 py-1 ml-1" style="background: #1e293b; color: #f97316; border: 1px solid #334155; border-radius: 8px; font-size: 11px; font-family: monospace;">
                                        #{{ $log->entity_id }}
                                    </span>
                                </td>

                                <!-- Description -->
                                <td class="py-3">
                                    <span class="text-gray-200" style="font-size: 13.5px; line-height: 1.5;">{{ $log->description }}</span>
                                </td>

                                <!-- Client IP / User Agent -->
                                <td class="py-3 text-nowrap">
                                    <div class="d-inline-flex align-items-center px-2 py-1 rounded"
                                         style="background: #162238; border: 1px solid #2a3854; color: #38bdf8; font-size: 12px; font-family: monospace;"
                                         data-toggle="tooltip" title="{{ $log->user_agent }}">
                                        <i class="fas fa-network-wired text-muted mr-1" style="font-size: 11px;"></i>{{ $log->ip_address }}
                                    </div>
                                </td>

                                <!-- Timestamp -->
                                <td class="py-3 text-right text-nowrap">
                                    <div class="font-weight-bold text-white" style="font-size: 13px;">
                                        {{ $log->created_at?->format('M d, Y • H:i') ?? 'N/A' }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $log->created_at?->diffForHumans() }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-gray-400"></i>
                                    <p class="h6 mb-0 text-gray-300">No activity logs recorded yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($logs->hasPages())
            <div class="card-footer py-3 d-flex justify-content-between align-items-center" style="background: #162238; border-top: 1px solid #1e293b; border-radius: 0 0 16px 16px;">
                <div class="small text-muted">
                    Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} logs
                </div>
                <div>
                    {{ $logs->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Confirmation Modal for Delete All Logs -->
<div class="modal fade" id="clearAllLogsModal" tabindex="-1" role="dialog" aria-labelledby="clearAllLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background: #0e1626; border: 1px solid #1e293b; border-radius: 16px;">
            <form action="{{ route('admin.activity-logs.clear-all') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title font-weight-bold" id="clearAllLogsModalLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Clear Audit Trail
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-white mb-2 font-weight-bold">Are you sure you want to permanently delete ALL activity logs?</p>
                    <p class="text-muted small mb-0">This action cannot be undone and will purge all system audit history records.</p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #1e293b;">
                    <button type="button" class="btn btn-secondary font-weight-bold px-3" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-danger font-weight-bold px-3" style="border-radius: 8px;">
                        <i class="fas fa-trash-alt mr-1"></i> Yes, Delete All Logs
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
