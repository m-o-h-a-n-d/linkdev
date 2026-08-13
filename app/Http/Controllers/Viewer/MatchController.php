<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Services\Match\MatchService;
use Illuminate\View\View;

class MatchController extends Controller
{
    public function __construct(
        protected readonly MatchService $matchService
    ) {}

    public function index(): View
    {
        $matches = $this->matchService->all();
        $competition = \App\Models\Competition::with(['matches.homeTeam', 'matches.awayTeam', 'matches.winnerTeam', 'matches.group', 'teams'])->latest()->first();

        return view('frontend.pages.matches', compact('matches', 'competition'));
    }

    public function show(int $id): View
    {
        // Fetch strictly single Match model data
        $match = $this->matchService->findOrFail($id);

        return view('frontend.pages.match-detail', compact('match'));
    }
}
