<?php

namespace App\Http\Controllers\Admin;

use App\Data\Competition\CreateCompetitionData;
use App\Data\Competition\UpdateCompetitionData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Competition\CreateCompetitionRequest;
use App\Http\Requests\Admin\Competition\UpdateCompetitionRequest;
use App\Services\Competition\CompetitionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompetitionController extends Controller
{
    public function __construct(
        protected CompetitionService $competitionService
    ) {}

    /**
     * Display a listing of competitions.
     */
    public function index(): View
    {
        $competitions = $this->competitionService->paginate(12);

        return view('backend.competitions.index', compact('competitions'));
    }

    /**
     * Show the form for creating a new competition.
     */
    public function create(): View
    {
        return view('backend.competitions.create');
    }

    /**
     * Store a newly created competition in storage.
     */
    public function store(CreateCompetitionRequest $request): RedirectResponse
    {
        $competitionData = CreateCompetitionData::from($request);

        $this->competitionService->store($competitionData);

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Competition created successfully!');
    }

    /**
     * Display the specified competition.
     */
    public function show(int $id): View
    {
        $competition = $this->competitionService->findOrFail($id);

        return view('backend.competitions.show', compact('competition'));
    }

    public function edit(int $id): View
    {
        $competition = $this->competitionService->findOrFail($id);

        return view('backend.competitions.edit', compact('competition'));
    }

    public function update(UpdateCompetitionRequest $request, int $id): RedirectResponse
    {
        $competitionData = UpdateCompetitionData::from($request);

        $this->competitionService->update($id, $competitionData);

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Competition updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->competitionService->destroy($id);

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Competition deleted successfully!');
    }
}
