@extends('backend.layouts.app')

@section('title', 'Group Details | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-layer-group text-primary mr-2"></i>Group A Overview</h1>
    <a href="{{ route('admin.groups.edit') }}" class="btn btn-warning btn-sm"><i class="fas fa-edit mr-1"></i> Edit Group</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h6 class="m-0 font-weight-bold text-white">Group A Details</h6>
    </div>
    <div class="card-body">
        <p>Participating Teams: FC Barcelona, Veszprém HC, Aalborg Håndbold, SC Magdeburg.</p>
    </div>
</div>
@endsection
