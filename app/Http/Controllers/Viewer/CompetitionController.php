<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Competition;
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

    public function show(string $slug): View
    {

        $competition = $this->competitionService->findBySlugOrFail($slug);

        if (! $competition) {
            abort(404);
        }

        return view('frontend.pages.competition-detail', compact('competition'));
    }
}
