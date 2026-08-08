@extends('backend.layouts.app')

@section('title', 'Group Standings Table | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-list-ol text-primary mr-2"></i>Group Standings Table</h1>
</div>

<!-- Standings Table -->
<div class="card mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-gray-800">EHF Champions League Standings Table</h6>
        <span class="badge badge-success font-weight-bold">Live Standings</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Rank #</th>
                        <th>Team</th>
                        <th class="text-center">Played (P)</th>
                        <th class="text-center">Won (W)</th>
                        <th class="text-center">Drawn (D)</th>
                        <th class="text-center">Lost (L)</th>
                        <th class="text-center">GF</th>
                        <th class="text-center">GA</th>
                        <th class="text-center">GD</th>
                        <th class="text-right font-weight-bold">Points (PTS)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="font-weight-bold">
                        <td>🥇 1</td>
                        <td><span class="badge badge-primary mr-2">BAR</span> <span class="text-gray-800">FC Barcelona</span></td>
                        <td class="text-center">8</td>
                        <td class="text-center text-success font-weight-bold">7</td>
                        <td class="text-center text-muted">1</td>
                        <td class="text-center text-muted">0</td>
                        <td class="text-center">264</td>
                        <td class="text-center">230</td>
                        <td class="text-center text-success font-weight-bold">+34</td>
                        <td class="text-right text-primary font-weight-bold h6 mb-0">15</td>
                    </tr>
                    <tr class="font-weight-bold">
                        <td>🥈 2</td>
                        <td><span class="badge badge-danger mr-2">VES</span> <span class="text-gray-800">Veszprém HC</span></td>
                        <td class="text-center">8</td>
                        <td class="text-center text-success font-weight-bold">6</td>
                        <td class="text-center text-muted">1</td>
                        <td class="text-center text-muted">1</td>
                        <td class="text-center">250</td>
                        <td class="text-center">228</td>
                        <td class="text-center text-success font-weight-bold">+22</td>
                        <td class="text-right text-primary font-weight-bold h6 mb-0">13</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
