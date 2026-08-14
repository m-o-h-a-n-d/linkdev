<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Services\Competition\CompetitionService;
use App\Services\Match\MatchService;
use Illuminate\View\View;

class MatchController extends Controller
{
    public function __construct(
        protected readonly MatchService $matchService,
        protected readonly CompetitionService $competitionService
    ) {}

    public function index(): View
    {
        $matches = $this->matchService->all();
        $competitions = $this->competitionService->allWithRelations([
            'matches.homeTeam',
            'matches.awayTeam',
            'matches.winnerTeam',
            'matches.group',
            'teams',
        ]);
        $competition = $competitions->first();

        return view('frontend.pages.matches', compact('matches', 'competition'));
    }

    public function show(int $id): View
    {
        // Fetch strictly single Match model data
        $match = $this->matchService->findOrFail($id);

        return view('frontend.pages.match-detail', compact('match'));
    }
}
