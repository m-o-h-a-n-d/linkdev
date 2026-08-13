@extends('backend.layouts.app')

@section('title', 'Schedule Match | Handball System')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-plus-circle text-primary mr-2"></i>Schedule New Match</h1>
    <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary btn-sm shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Matches</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Match Details Form</h6>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.matches.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Competition <span class="text-danger">*</span></label>
                    <select name="competition_id" id="competition_id" class="form-control" required>
                        <option value="">-- Select Competition --</option>
                        @foreach($competitions as $comp)
                            <option value="{{ $comp->id }}" {{ old('competition_id') == $comp->id ? 'selected' : '' }}>
                                {{ $comp->name }} (Season {{ $comp->season }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 form-group" id="group_container" style="display: none;">
                    <label class="font-weight-bold text-gray-700">Group Stage (Optional)</label>
                    <select name="group_id" id="group_id" class="form-control">
                        <option value="">-- Select Group (None for Knockout) --</option>
                    </select>
                </div>
            </div>

            <div class="row" id="teams_container" style="display: none;">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Home Team <span class="text-danger">*</span></label>
                    <select name="home_team_id" id="home_team_id" class="form-control" required>
                        <option value="">-- Select Home Team --</option>
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Away Team <span class="text-danger">*</span></label>
                    <select name="away_team_id" id="away_team_id" class="form-control" required>
                        <option value="">-- Select Away Team --</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Scheduled Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ old('scheduled_at', now()->addHours(2)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-gray-700">Round Number <span class="text-danger">*</span></label>
                    <input type="number" name="round_number" class="form-control" value="{{ old('round_number', 1) }}" min="1" required>
                </div>
            </div>

            <div class="form-group">
                <label class="font-weight-bold text-gray-700">Notes / Stadium Venue</label>
                <input type="text" name="notes" class="form-control" placeholder="e.g. Cairo Stadium Sports Hall" value="{{ old('notes') }}">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Create & Schedule Match</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const $competitionSelect = $('#competition_id');
    const $groupSelect = $('#group_id');
    const $homeTeamSelect = $('#home_team_id');
    const $awayTeamSelect = $('#away_team_id');

    const $groupContainer = $('#group_container');
    const $teamsContainer = $('#teams_container');

    const oldGroupId = "{{ old('group_id') }}";
    const oldHomeTeamId = "{{ old('home_team_id') }}";
    const oldAwayTeamId = "{{ old('away_team_id') }}";

    function populateTeams(teams) {
        $homeTeamSelect.empty().append('<option value="">-- Select Home Team --</option>');
        $awayTeamSelect.empty().append('<option value="">-- Select Away Team --</option>');

        if (teams && teams.length > 0) {
            teams.forEach(team => {
                const shortNameStr = team.short_name ? ` (${team.short_name})` : '';
                const homeSelected = (oldHomeTeamId == team.id) ? 'selected' : '';
                const awaySelected = (oldAwayTeamId == team.id) ? 'selected' : '';

                $homeTeamSelect.append(`<option value="${team.id}" ${homeSelected}>${team.name}${shortNameStr}</option>`);
                $awayTeamSelect.append(`<option value="${team.id}" ${awaySelected}>${team.name}${shortNameStr}</option>`);
            });
            $teamsContainer.fadeIn();
        } else {
            $teamsContainer.fadeOut();
        }
    }

    $competitionSelect.on('change', function() {
        const compId = $(this).val();

        // Clear downstream selects
        $groupSelect.empty().append('<option value="">-- Select Group (None for Knockout) --</option>');
        $homeTeamSelect.empty().append('<option value="">-- Select Home Team --</option>');
        $awayTeamSelect.empty().append('<option value="">-- Select Away Team --</option>');

        $groupContainer.hide();
        $teamsContainer.hide();

        if (!compId) {
            return;
        }

        // Fetch Groups for selected competition
        $.ajax({
            url: `{{ url('/admin/api/competitions') }}/${compId}/groups`,
            type: 'GET',
            dataType: 'json',
            success: function(groups) {
                if (groups && groups.length > 0) {
                    groups.forEach(grp => {
                        const isSelected = (oldGroupId == grp.id) ? 'selected' : '';
                        $groupSelect.append(`<option value="${grp.id}" ${isSelected}>${grp.name}</option>`);
                    });
                    $groupContainer.fadeIn();

                    // If an old group was selected, trigger change to load teams
                    if (oldGroupId) {
                        $groupSelect.trigger('change');
                    }
                } else {
                    // Knockout / No groups: fetch competition teams directly
                    $.ajax({
                        url: `{{ url('/admin/api/competitions') }}/${compId}/teams`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(teams) {
                            populateTeams(teams);
                        }
                    });
                }
            }
        });
    });

    $groupSelect.on('change', function() {
        const groupId = $(this).val();
        const compId = $competitionSelect.val();

        if (!groupId) {
            if (compId) {
                // If group unselected but competition chosen, fetch competition teams
                $.ajax({
                    url: `{{ url('/admin/api/competitions') }}/${compId}/teams`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(teams) {
                        populateTeams(teams);
                    }
                });
            } else {
                $teamsContainer.fadeOut();
            }
            return;
        }

        // Fetch teams for selected group
        $.ajax({
            url: `{{ url('/admin/api/groups') }}/${groupId}/teams`,
            type: 'GET',
            dataType: 'json',
            success: function(teams) {
                populateTeams(teams);
            }
        });
    });

    // Initial check if competition already selected (e.g., page reload on error)
    if ($competitionSelect.val()) {
        $competitionSelect.trigger('change');
    }
});
</script>
@endpush

