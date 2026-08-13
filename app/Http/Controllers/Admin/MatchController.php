<?php

namespace App\Http\Controllers\Admin;

use App\Data\Match\CreateMatchData;
use App\Data\Match\UpdateMatchData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Match\CreateMatchRequest;
use App\Http\Requests\Admin\Match\GenerateFixturesRequest;
use App\Http\Requests\Admin\Match\UpdateMatchRequest;
use App\Http\Requests\Admin\Match\UpdateMatchScoreRequest;
use App\Services\Match\MatchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MatchController extends Controller
{
    public function __construct(
        protected MatchService $matchService
    ) {}

    public function index(Request $request): View
    {
        $matches = $this->matchService->getPaginatedMatches($request->all());
        $filterData = $this->matchService->getFilterData();

        return view('backend.matches.index', array_merge(['matches' => $matches], $filterData));
    }

    public function create(): View
    {
        $formData = $this->matchService->getFormData();

        return view('backend.matches.create', $formData);
    }

    public function store(CreateMatchRequest $request): RedirectResponse
    {
        $matchData = CreateMatchData::from($request);
        $this->matchService->store($matchData);

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match created and scheduled successfully!');
    }

    public function generateFixtures(GenerateFixturesRequest $request): RedirectResponse
    {
        $createdMatches = $this->matchService->generateFixtures($request->group_id);

        if ($createdMatches->isEmpty()) {
            return redirect()->back()->with('error', 'Not enough teams in this group to generate fixtures.');
        }

        return redirect()->route('admin.matches.index')
            ->with('success', "Generated {$createdMatches->count()} fixtures successfully!");
    }

    public function show(int $id): View
    {
        $details = $this->matchService->getShowDetails($id);

        return view('backend.matches.show', $details);
    }

    public function edit(int $id): View
    {
        $match = $this->matchService->findOrFail($id);
        $formData = $this->matchService->getFormData();

        return view('backend.matches.edit', array_merge(['match' => $match], $formData));
    }

    public function update(UpdateMatchRequest $request, int $id): RedirectResponse
    {
        $matchData = UpdateMatchData::from($request);
        $this->matchService->updateMatch($id, $matchData);

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match updated and standings recalculated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->matchService->destroyMatch($id);

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match deleted successfully.');
    }

    public function liveCenter(Request $request): View
    {
        $liveMatches = $this->matchService->getLiveCenterMatches();

        return view('backend.matches.live-center', compact('liveMatches'));
    }

    public function updateScore(UpdateMatchScoreRequest $request, int $id): RedirectResponse
    {
        $this->matchService->updateScore($id, $request->action);

        return redirect()->back()->with('success', 'Match updated successfully!');
    }

    public function getGroupsByCompetition(int $id): \Illuminate\Http\JsonResponse
    {
        $groups = $this->matchService->getGroupsByCompetition($id);

        return response()->json($groups);
    }

    public function getTeamsByGroup(int $id): \Illuminate\Http\JsonResponse
    {
        $teams = $this->matchService->getTeamsByGroup($id);

        return response()->json($teams);
    }

    public function getTeamsByCompetition(int $id): \Illuminate\Http\JsonResponse
    {
        $teams = $this->matchService->getTeamsByCompetition($id);

        return response()->json($teams);
    }
}


