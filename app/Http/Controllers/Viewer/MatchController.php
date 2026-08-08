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
        // Fetch strictly Match model data
        $matches = $this->matchService->all();

        return view('frontend.pages.matches', compact('matches'));
    }

    public function show(int $id): View
    {
        // Fetch strictly single Match model data
        $match = $this->matchService->findOrFail($id);

        return view('frontend.pages.match-detail', compact('match'));
    }
}
