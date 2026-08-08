@extends('backend.layouts.app')

@section('title', 'Competitions Directory | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-trophy text-primary mr-2"></i>Competitions Directory</h1>
    <a href="{{ route('admin.competitions.create') }}" class="btn btn-primary btn-sm shadow-sm"><i class="fas fa-plus mr-1"></i> Create Competition</a>
</div>

<!-- Competitions Table -->
<div class="card mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-gray-800">All Competitions Table</h6>
        <span class="badge badge-primary font-weight-bold">2 Active</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Competition Name</th>
                        <th>Season</th>
                        <th>Type</th>
                        <th>Teams / Matches</th>
                        <th>Status</th>
                        <th>Start - End Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-weight-bold">
                            <a href="{{ route('admin.competitions.show') }}" class="text-primary font-weight-bold">EHF Champions League 2025/2026</a>
                            <div class="text-muted small mt-1">ehf-champions-league-2025</div>
                        </td>
                        <td class="font-weight-medium">2025/2026</td>
                        <td><span class="badge badge-primary">Mixed</span></td>
                        <td><span class="font-weight-bold text-gray-800">16 Teams</span> <span class="text-muted">/ 48 Matches</span></td>
                        <td><span class="badge badge-success"><i class="fas fa-play mr-1"></i>Ongoing</span></td>
                        <td class="text-muted">Sep 15, 2025 - May 30, 2026</td>
                        <td class="text-right">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.competitions.show') }}"><i class="fas fa-eye mr-1"></i> View</a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.competitions.edit') }}"><i class="fas fa-edit mr-1"></i> Edit</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">
                            <a href="{{ route('admin.competitions.show') }}" class="text-primary font-weight-bold">Egyptian Handball Premier League</a>
                            <div class="text-muted small mt-1">egyptian-premier-league-2025</div>
                        </td>
                        <td class="font-weight-medium">2025/2026</td>
                        <td><span class="badge badge-info">League</span></td>
                        <td><span class="font-weight-bold text-gray-800">12 Teams</span> <span class="text-muted">/ 66 Matches</span></td>
                        <td><span class="badge badge-success"><i class="fas fa-play mr-1"></i>Ongoing</span></td>
                        <td class="text-muted">Oct 01, 2025 - Jun 15, 2026</td>
                        <td class="text-right">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.competitions.show') }}"><i class="fas fa-eye mr-1"></i> View</a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.competitions.edit') }}"><i class="fas fa-edit mr-1"></i> Edit</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
