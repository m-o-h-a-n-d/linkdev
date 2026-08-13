<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\GroupStanding;
use App\Models\TeamStatistic;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StandingController extends Controller
{
    public function index(Request $request): View
    {
        $competitions = Competition::with(['groups.standings.team', 'statistics.team'])->get();

        $selectedCompetitionId = $request->get('competition_id', $competitions->first()?->id);

        $selectedCompetition = $competitions->firstWhere('id', $selectedCompetitionId);

        $groupStandings = GroupStanding::with(['group', 'team'])
            ->when($selectedCompetitionId, function ($query) use ($selectedCompetitionId) {
                $query->whereHas('group', function ($q) use ($selectedCompetitionId) {
                    $q->where('competition_id', $selectedCompetitionId);
                });
            })
            ->orderBy('group_id')
            ->orderBy('points', 'desc')
            ->orderBy('goal_difference', 'desc')
            ->orderBy('goals_for', 'desc')
            ->get()
            ->groupBy('group.name');

        $teamStatistics = TeamStatistic::with('team')
            ->when($selectedCompetitionId, function ($query) use ($selectedCompetitionId) {
                $query->where('competition_id', $selectedCompetitionId);
            })
            ->orderBy('points', 'desc')
            ->orderBy('goal_difference', 'desc')
            ->get();

        return view('backend.standings.index', compact(
            'competitions',
            'selectedCompetition',
            'groupStandings',
            'teamStatistics'
        ));
    }
}
