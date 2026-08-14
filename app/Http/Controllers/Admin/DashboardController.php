<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupStanding;
use App\Models\TeamStatistic;
use App\Services\HomeService\HomeService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected readonly HomeService $homeService,
    ) {}

    public function index(): View
    {
        $competitions = $this->homeService->getCompetitions();

        $matches = $this->homeService->getMatches();

        $teams = $this->homeService->getTeams();

        $upcomingMatches = $this->homeService->getUpcomingMatches();

        $liveMatches = $this->homeService->getLiveMatches();

        $selectedCompetitionId = request()->get('competition_id', $competitions->first()?->id);
        $selectedCompetition = $competitions->firstWhere('id', $selectedCompetitionId);

        $teamStatistics = TeamStatistic::with('team')
            ->when($selectedCompetitionId, function ($query) use ($selectedCompetitionId) {
                $query->where('competition_id', $selectedCompetitionId);
            })
            ->orderBy('points', 'desc')
            ->orderBy('goal_difference', 'desc')
            ->orderBy('goals_for', 'desc')
            ->take(4)
            ->get();

        return view('backend.dashboard.index', compact(
            'competitions',
            'upcomingMatches',
            'matches',
            'teams',
            'liveMatches',
            'teamStatistics',
            'selectedCompetition',
            'selectedCompetitionId'
        ));
    }
}
