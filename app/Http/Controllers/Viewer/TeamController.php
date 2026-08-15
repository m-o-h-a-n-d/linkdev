<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Services\Team\TeamService;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function __construct(
        protected readonly TeamService $teamService
    ) {}

    public function index(): View
    {
        // Fetch strictly Team model data
        $teams = $this->teamService->all();

        return view('frontend.pages.teams', compact('teams'));
    }

    public function show(int $id): View
    {
        // Fetch strictly single Team model data
        $team = $this->teamService->findOrFail($id);
        $team->loadMissing('competitions');

        return view('frontend.pages.team-detail', compact('team'));
    }
}
