<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Standing\StandingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StandingController extends Controller
{
    public function __construct(
        protected StandingService $standingService
    ) {}

    /**
     * Display Group Standings only.
     */
    public function index(Request $request): View
    {
        $data = $this->standingService->getGroupStandingsData(
            $request->filled('competition_id') ? (int) $request->get('competition_id') : null
        );

        return view('backend.standings.index', $data);
    }

    /**
     * Display Competition Team Statistics only.
     */
    public function statistics(Request $request): View
    {
        $data = $this->standingService->getTeamStatisticsData(
            $request->filled('competition_id') ? (int) $request->get('competition_id') : null
        );

        return view('backend.statistics.index', $data);
    }
}
