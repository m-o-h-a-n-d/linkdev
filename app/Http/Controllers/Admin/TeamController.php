<?php

namespace App\Http\Controllers\Admin;

use App\Data\Team\CreateTeamData;
use App\Data\Team\UpdateTeamData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Team\ChangeTeamStatusRequest;
use App\Http\Requests\Admin\Team\CreateTeamRequest;
use App\Http\Requests\Admin\Team\UpdateTeamRequest;
use App\Services\Team\TeamService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function __construct(
        protected TeamService $teamService
    ) {}

    /**
     * Display a listing of teams.
     */
    public function index(): View
    {
        $teams = $this->teamService->paginate(12);

        return view('backend.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new team.
     */
    public function create(): View
    {
        return view('backend.teams.create');
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(CreateTeamRequest $request): RedirectResponse
    {
        $teamData = CreateTeamData::from($request);

        $this->teamService->store($teamData);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team registered successfully!');
    }

    /**
     * Display the specified team.
     */
    public function show(int $id): View
    {
        $team = $this->teamService->findOrFail($id);

        return view('backend.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified team.
     */
    public function edit(int $id): View
    {
        $team = $this->teamService->findOrFail($id);

        return view('backend.teams.edit', compact('team'));
    }

    /**
     * Update the specified team in storage.
     */
    public function update(UpdateTeamRequest $request, int $id): RedirectResponse
    {
        $teamData = UpdateTeamData::from($request);

        $this->teamService->update($id, $teamData);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team updated successfully!');
    }

    /**
     * Remove the specified team from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->teamService->destroy($id);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team deleted successfully!');
    }

    /**
     * Accept a pending team.
     */
    public function accept(int $id): RedirectResponse
    {
        $team = $this->teamService->acceptTeam($id);

        return redirect()->back()
            ->with('success', "Team '{$team->name}' has been ACCEPTED and notification email sent!");
    }

    /**
     * Reject a pending team.
     */
    public function reject(ChangeTeamStatusRequest $request, int $id): RedirectResponse
    {
        $reason = $request->input('rejection_reason');
        $team = $this->teamService->rejectTeam($id, $reason);

        return redirect()->back()
            ->with('success', "Team '{$team->name}' has been REJECTED and notification email sent!");
    }
}
