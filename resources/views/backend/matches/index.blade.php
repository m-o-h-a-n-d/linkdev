@extends('backend.layouts.app')

@section('title', 'Match Fixtures & Results | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-running text-primary mr-2"></i>Match Fixtures & Results Table</h1>
    <div>
        <a href="{{ route('admin.matches.create') }}" class="btn btn-primary btn-sm shadow-sm mr-1"><i class="fas fa-plus mr-1"></i> Schedule Match</a>
        <a href="{{ route('admin.matches.live-center') }}" class="btn btn-danger btn-sm shadow-sm"><i class="fas fa-broadcast-tower mr-1"></i> Live Score Engine</a>
    </div>
</div>

<!-- Matches Table -->
<div class="card mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-gray-800">Matches Fixtures & Results</h6>
        <span class="badge badge-primary font-weight-bold">Live Engine Active</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Competition</th>
                        <th>Group / Round</th>
                        <th>Date & Time</th>
                        <th>Home Team</th>
                        <th class="text-center">Score</th>
                        <th>Away Team</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-weight-bold text-gray-800">Egyptian Premier League</td>
                        <td class="text-muted">Group A • Round 8</td>
                        <td class="text-muted">Oct 24, 2025 • 18:00</td>
                        <td class="font-weight-bold text-primary">Al Ahly SC</td>
                        <td class="text-center"><span class="badge badge-primary font-weight-bold">28 - 26</span></td>
                        <td class="font-weight-bold text-gray-800">Sporting Club</td>
                        <td><span class="badge badge-success"><i class="fas fa-check mr-1"></i>Finished</span></td>
                        <td class="text-right">
                            <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.matches.show') }}"><i class="fas fa-eye mr-1"></i> View</a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.matches.edit') }}"><i class="fas fa-edit mr-1"></i> Edit</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
