<?php

namespace App\Http\Controllers\Admin;

use App\Data\CompetitionGroup\CreateCompetitionGroupData;
use App\Data\CompetitionGroup\UpdateCompetitionGroupData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompetitionGroup\AttachTeamToGroupRequest;
use App\Http\Requests\Admin\CompetitionGroup\CreateCompetitionGroupRequest;
use App\Http\Requests\Admin\CompetitionGroup\UpdateCompetitionGroupRequest;
use App\Models\Competition;
use App\Services\Competition\CompetitionService;
use App\Services\CompetitionGroup\CompetitionGroupService;
use App\Services\Team\TeamService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CompetitionGroupController extends Controller
{
    public function __construct(
        protected CompetitionGroupService $competitionGroupService,
        protected CompetitionService $competitionService,
        protected TeamService $teamService,
    ) {}

    public function index(): View
    {
        $groups = $this->competitionGroupService->paginate(12);

        return view('backend.groups.index', compact('groups'));
    }

    public function create(): View
    {
        $competitions = $this->competitionService->all();

        return view('backend.groups.create', compact('competitions'));
    }

    public function store(CreateCompetitionGroupRequest $request): RedirectResponse
    {
        $groupData = CreateCompetitionGroupData::from($request);

        $this->competitionGroupService->store($groupData);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Group created successfully!');
    }

    public function show(int $id): View
    {
        $group = $this->competitionGroupService->findOrFail($id);
        $availableTeams = $this->competitionGroupService->getAvailableTeams($id);

        return view('backend.groups.show', compact('group', 'availableTeams'));
    }

    public function edit(int $id): View
    {
        $group = $this->competitionGroupService->findOrFail($id);
        $competitions = $this->competitionService->all();

        return view('backend.groups.edit', compact('group', 'competitions'));
    }

    public function update(UpdateCompetitionGroupRequest $request, int $id): RedirectResponse
    {
        $groupData = UpdateCompetitionGroupData::from($request);

        $this->competitionGroupService->update($id, $groupData);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Group updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->competitionGroupService->destroy($id);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Group deleted successfully!');
    }

    public function attachTeam(AttachTeamToGroupRequest $request, int $id): RedirectResponse
    {
        $this->competitionGroupService->attachTeam($id, (int) $request->input('team_id'));

        return redirect()->route('admin.groups.show', $id)
            ->with('success', 'Team added to group successfully!');
    }

    public function detachTeam(int $id, int $teamId): RedirectResponse
    {
        $this->competitionGroupService->detachTeam($id, $teamId);

        return redirect()->route('admin.groups.show', $id)
            ->with('success', 'Team removed from group successfully!');
    }
}
