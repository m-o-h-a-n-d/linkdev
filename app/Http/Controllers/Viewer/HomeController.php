<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Services\HomeService\HomeService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected readonly HomeService $homeService
    ) {}

    public function index(): View
    {
        $competitions = $this->homeService->getCompetitions();

        $matches = $this->homeService->getMatches();

        $teams = $this->homeService->getTeams();

        $upcomingMatches = $this->homeService->getUpcomingMatches();

        $liveMatches = $this->homeService->getLiveMatches();

        return view('frontend.index', compact('competitions', 'upcomingMatches', 'matches', 'teams', 'liveMatches'));
    }
}
