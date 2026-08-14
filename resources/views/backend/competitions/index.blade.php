@extends('backend.layouts.app')

@section('title', 'Competitions Directory | Handball System')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-trophy text-primary mr-2"></i>Competitions
            Directory</h1>
        <a href="{{ route('admin.competitions.create') }}" class="btn btn-primary btn-sm shadow-sm"><i
                class="fas fa-plus mr-1"></i> Create Competition</a>
    </div>

    <!-- Competitions Table -->
    <div class="card mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-gray-800">All Competitions Table</h6>
            <span class="badge badge-primary font-weight-bold">{{ $competitions->count() }} Active</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Competition Name</th>
                            <th>Season</th>
                            <th>Status</th>
                            <th>Start - End Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($competitions as $competition)
                            <tr>
                                <td class="font-weight-bold">
                                    <a href="{{ route('admin.competitions.show', $competition->id) }}"
                                        class="text-primary font-weight-bold">
                                        {{ $competition->name }}
                                    </a>
                                    @if ($competition->winnerTeam)
                                        <div class="mt-1">
                                            <span class="badge badge-warning text-dark font-weight-bold" style="font-size: 0.8rem;">
                                                <i class="fas fa-crown mr-1"></i> Champion: {{ $competition->winnerTeam->name }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="font-weight-medium">{{ $competition->season }}</td>
                                <td>
                                    @php
                                        $statusClass = match ($competition->status) {
                                            'ongoing' => 'badge-success',
                                            'upcoming' => 'badge-info',
                                            'completed' => 'badge-secondary',
                                            'cancelled' => 'badge-danger',
                                            default => 'badge-light',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}"><i
                                            class="fas fa-play mr-1"></i>{{ ucfirst($competition->status) }}</span>
                                </td>
                                <td class="text-muted">
                                    {{ $competition->start_date?->format('M d, Y') }} -
                                    {{ $competition->end_date?->format('M d, Y') }}
                                </td>
                                <td class="text-right">
                                    <div class="d-inline-flex align-items-center" style="gap: 6px;">
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('admin.competitions.show', $competition->id) }}"><i
                                                class="fas fa-eye mr-1"></i> View</a>
                                        <a class="btn btn-warning btn-sm"
                                            href="{{ route('admin.competitions.edit', $competition->id) }}"><i
                                                class="fas fa-edit mr-1"></i> Edit</a>
                                        <form action="{{ route('admin.competitions.destroy', $competition->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this competition?')"><i
                                                    class="fas fa-trash-alt mr-1"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No competitions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($competitions, 'hasPages') && $competitions->hasPages())
            <div class="card-footer py-3 d-flex justify-content-between align-items-center" style="background: #162238; border-top: 1px solid #1e293b;">
                <div class="small text-muted">
                    Showing {{ $competitions->firstItem() }} to {{ $competitions->lastItem() }} of {{ $competitions->total() }} competitions
                </div>
                <div>
                    {{ $competitions->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
@endsection
