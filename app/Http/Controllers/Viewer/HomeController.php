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
        // Fetch strictly Competition model data
        $competitions = $this->homeService->getCompetitions();
        $upcomingMatches = $this->homeService->getUpcomingMatches();

        return view('frontend.index', compact('competitions', 'upcomingMatches'));
    }
}
