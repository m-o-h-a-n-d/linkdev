<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Services\Competition\CompetitionService;
use Illuminate\View\View;

class CompetitionController extends Controller
{
    public function __construct(
        protected readonly CompetitionService $competitionService
    ) {}

    public function index(): View
    {
        // Fetch strictly Competition model data
        $competitions = $this->competitionService->all();

        return view('frontend.pages.competitions', compact('competitions'));
    }

    public function show(int $id): View
    {
        // Fetch strictly single Competition model data
        $competition = $this->competitionService->findOrFail($id);

        return view('frontend.pages.competition-detail', compact('competition'));
    }
}
