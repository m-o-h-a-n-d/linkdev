<?php

namespace App\Repositories\Eloquent\CompetitionGroup;

use App\Data\CompetitionGroup\CreateCompetitionGroupData;
use App\Data\CompetitionGroup\UpdateCompetitionGroupData;
use App\Models\CompetitionGroup;
use App\Models\Team;
use App\Repositories\Contracts\CompetitionGroup\CompetitionGroupRepositoryInterface;
use App\Utility\Enums\TeamStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CompetitionGroupRepository implements CompetitionGroupRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return CompetitionGroup::with(['competition', 'teams'])
            ->orderBy('competition_id')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function all(): Collection
    {
        return CompetitionGroup::with(['competition', 'teams'])
            ->orderBy('competition_id')
            ->orderBy('name')
            ->get();
    }

    public function find(int $id): ?CompetitionGroup
    {
        return CompetitionGroup::with(['competition', 'teams'])->find($id);
    }

    public function create(CreateCompetitionGroupData $data): CompetitionGroup
    {
        return CompetitionGroup::create($data->toArray());
    }

    public function update(CompetitionGroup $group, UpdateCompetitionGroupData $data): CompetitionGroup
    {
        $group->update($data->toArray());

        return $group->fresh();
    }

    public function delete(CompetitionGroup $group): bool
    {
        return $group->delete();
    }

    public function attachTeam(CompetitionGroup $group, int $teamId): void
    {
        $group->teams()->syncWithoutDetaching([$teamId]);
    }

    public function detachTeam(CompetitionGroup $group, int $teamId): void
    {
        $group->teams()->detach($teamId);
    }

    public function getAvailableTeamsForGroup(CompetitionGroup $group): Collection
    {
        $assignedTeamIdsInCompetition = DB::table('group_team') // ابدأ من Pivot
            ->join('competition_groups', 'group_team.group_id', '=', 'competition_groups.id') // اعرف الـ Group التابعة لأنهي Competition
            ->where('competition_groups.competition_id', $group->competition_id)
            ->whereNull('competition_groups.deleted_at') // تأكد أن الجروب غير محذوف
            ->pluck('group_team.team_id') // هات الـ Team ID
            ->toArray(); // خليهم Array

        return Team::where('status', TeamStatus::ACCEPTED->value) // اختار اللي متأكد
            ->whereNotIn('id', $assignedTeamIdsInCompetition) // مش موجودين في الـ Array اللي فوق
            ->get(); // وهات اللي طلع
    }

    public function isTeamInCompetitionGroup(int $competitionId, int $teamId): bool
    {
        return DB::table('group_team')
            ->join('competition_groups', 'group_team.group_id', '=', 'competition_groups.id')
            ->where('competition_groups.competition_id', $competitionId)
            ->whereNull('competition_groups.deleted_at')
            ->where('group_team.team_id', $teamId)
            ->exists();
    }
}
