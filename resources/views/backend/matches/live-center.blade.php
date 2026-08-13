@extends('backend.layouts.app')

@section('title', 'Live Score Engine | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
        <i class="fas fa-broadcast-tower text-danger mr-2"></i>Live Score Engine & Control Center
    </h1>
    <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Back to Matches
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    @forelse($liveMatches as $match)
        <div class="col-lg-6 mb-4">
            <div class="card border-left-{{ $match->status === 'live' ? 'danger' : 'primary' }} shadow h-100 py-2">
                <div class="card-body">
                    <!-- Match Meta -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge badge-dark font-weight-bold">
                            {{ $match->competition->name ?? 'Handball Competition' }}
                        </span>
                        @if($match->status === 'live')
                            <span class="badge badge-danger text-uppercase px-3 py-1 font-weight-bold animate-pulse">
                                <i class="fas fa-circle mr-1" style="font-size: 8px;"></i> LIVE
                            </span>
                        @else
                            <span class="badge badge-primary text-uppercase px-3 py-1 font-weight-bold">
                                SCHEDULED
                            </span>
                        @endif
                    </div>

                    <!-- Teams & Scores -->
                    <div class="row align-items-center text-center my-4">
                        <div class="col-5">
                            <h5 class="font-weight-bold text-gray-900 mb-1">{{ $match->homeTeam->name ?? 'Home Team' }}</h5>
                            <span class="badge badge-secondary">HOME</span>
                            <div class="display-3 font-weight-extrabold text-primary mt-2">
                                {{ $match->home_score }}
                            </div>
                        </div>

                        <div class="col-2 text-center">
                            <div class="h4 font-weight-bold text-gray-400">VS</div>
                            <div class="small text-muted font-weight-bold mt-2">
                                {{ $match->group->name ?? 'Round ' . $match->round_number }}
                            </div>
                            @if($match->status === 'live')
                                <div class="badge badge-dark text-warning font-weight-bold mt-2 px-2 py-1" style="font-size: 0.9rem;" data-match-timer="{{ $match->started_at ? $match->started_at->toIso8601String() : now()->toIso8601String() }}">
                                    {{ $match->formatted_timer }}
                                </div>
                            @endif
                        </div>

                        <div class="col-5">
                            <h5 class="font-weight-bold text-gray-900 mb-1">{{ $match->awayTeam->name ?? 'Away Team' }}</h5>
                            <span class="badge badge-secondary">AWAY</span>
                            <div class="display-3 font-weight-extrabold text-danger mt-2">
                                {{ $match->away_score }}
                            </div>
                        </div>
                    </div>

                    <!-- Action Control Buttons -->
                    <div class="border-top pt-3">
                        @if($match->status === 'scheduled')
                            <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="start_live">
                                <button type="submit" class="btn btn-success btn-block font-weight-bold">
                                    <i class="fas fa-play mr-1"></i> Start Match Now (Go LIVE)
                                </button>
                            </form>
                        @elseif($match->status === 'live')
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="btn-group w-100" role="group">
                                        <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" class="w-50">
                                            @csrf
                                            <input type="hidden" name="action" value="decrement_home">
                                            <button type="submit" class="btn btn-outline-danger btn-block font-weight-bold">- 1</button>
                                        </form>
                                        <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" class="w-50">
                                            @csrf
                                            <input type="hidden" name="action" value="increment_home">
                                            <button type="submit" class="btn btn-primary btn-block font-weight-bold">+ Goal</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="btn-group w-100" role="group">
                                        <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" class="w-50">
                                            @csrf
                                            <input type="hidden" name="action" value="decrement_away">
                                            <button type="submit" class="btn btn-outline-danger btn-block font-weight-bold">- 1</button>
                                        </form>
                                        <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" class="w-50">
                                            @csrf
                                            <input type="hidden" name="action" value="increment_away">
                                            <button type="submit" class="btn btn-danger btn-block font-weight-bold">+ Goal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('admin.matches.update-score', $match->id) }}" method="POST" onsubmit="return confirm('Finish this match and recalculate standings?');">
                                @csrf
                                <input type="hidden" name="action" value="finish_match">
                                <button type="submit" class="btn btn-dark btn-block font-weight-bold">
                                    <i class="fas fa-flag-checkered mr-1"></i> End Match & Recalculate Standings
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card shadow p-5 text-center text-muted">
                <i class="fas fa-broadcast-tower fa-3x mb-3 text-gray-400"></i>
                <h4 class="font-weight-bold">No Active or Scheduled Matches</h4>
                <p>Schedule new matches or generate group fixtures to use the Live Engine.</p>
                <div>
                    <a href="{{ route('admin.matches.create') }}" class="btn btn-primary btn-sm">Schedule Match Now</a>
                </div>
            </div>
        </div>
    @endforelse
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timerElements = document.querySelectorAll('[data-match-timer]');
        
        if (timerElements.length === 0) return;

        setInterval(function() {
            timerElements.forEach(function(el) {
                const startTimeStr = el.getAttribute('data-match-timer');
                if (!startTimeStr) return;

                const startTime = new Date(startTimeStr);
                const now = new Date();
                const diffSeconds = Math.max(0, Math.floor((now - startTime) / 1000));

                const mins = String(Math.floor(diffSeconds / 60)).padStart(2, '0');
                const secs = String(diffSeconds % 60).padStart(2, '0');

                el.textContent = mins + ':' + secs;
            });
        }, 1000);
    });
</script>
@endpush
@endsection
