@extends('backend.layouts.app')

@section('title', 'System Activity Logs | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-history text-primary mr-2"></i>System Audit Trail & Activity Logs Table</h1>
</div>

<!-- Logs Table -->
<div class="card mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-gray-800">Audit Log Feed Table</h6>
        <span class="badge badge-info font-weight-bold">Live Stream</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Entity Type</th>
                        <th>Entity ID</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th class="text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-weight-bold">
                            <span class="text-primary font-weight-bold"><i class="fas fa-user-shield mr-1 text-primary"></i> Mohanad Admin</span>
                        </td>
                        <td><span class="badge badge-success">CREATED</span></td>
                        <td class="font-weight-bold text-gray-800">competitions</td>
                        <td><code class="bg-light text-primary px-2 py-1 rounded" style="font-size: 12px;">#1</code></td>
                        <td class="text-gray-800">EHF Champions League 2025/2026 initialized.</td>
                        <td><code class="bg-light text-muted px-2 py-1 rounded" style="font-size: 12px;">192.168.1.45</code></td>
                        <td class="text-right text-muted">Oct 24, 2025 • 10:15</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">
                            <span class="text-primary font-weight-bold"><i class="fas fa-tasks mr-1 text-info"></i> Sara Hassan</span>
                        </td>
                        <td><span class="badge badge-info">UPDATED</span></td>
                        <td class="font-weight-bold text-gray-800">matches</td>
                        <td><code class="bg-light text-primary px-2 py-1 rounded" style="font-size: 12px;">#24</code></td>
                        <td class="text-gray-800">Al Ahly vs Zamalek score updated live (26-24).</td>
                        <td><code class="bg-light text-muted px-2 py-1 rounded" style="font-size: 12px;">10.0.0.8</code></td>
                        <td class="text-right text-muted">Oct 24, 2025 • 18:45</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
