<?php

namespace App\Repositories\Eloquent\Competition;

use App\Data\Competition\CreateCompetitionData;
use App\Data\Competition\UpdateCompetitionData;
use App\Models\Competition as CompetitionModel;
use App\Repositories\Contracts\Competition\CompetitionRepositoryInterface;
use App\Utility\Enums\TeamStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CompetitionRepository implements CompetitionRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return CompetitionModel::with(['winnerTeam'])->paginate($perPage);
    }

    public function all(): Collection
    {
        return CompetitionModel::with(['groups', 'groups.teams', 'winnerTeam'])->get();
    }

    public function allWithRelations(array $relations = []): Collection
    {
        return CompetitionModel::with($relations)->get();
    }

    public function find(string|int $id): ?CompetitionModel
    {
        $query = CompetitionModel::with([
            'winnerTeam',
            'teams',
            'groups.teams',
            'groups.standings' => function ($q) {
                $q->orderBy('points', 'desc')->orderBy('goal_difference', 'desc')->orderBy('goals_for', 'desc');
            },
            'groups.standings.team',
            'statistics' => function ($q) {
                $q->orderBy('points', 'desc')->orderBy('goal_difference', 'desc');
            },
            'statistics.team',
            'matches.homeTeam',
            'matches.awayTeam',
            'matches.winnerTeam',
            'matches.group',
        ]);

        // DB::listen(function ($query) {
        //     dump($query->sql , $query->bindings, $query->time);
        // });

        return $query->where('id', $id)->first();
    }

    public function findBySlug(string $slug): ?CompetitionModel
    {
        $competitionId = CompetitionModel::query()
            ->select(['id', 'name'])
            ->orderBy('id')
            ->cursor()
            ->first(fn (CompetitionModel $competition) => $competition->slug === $slug)?->id;

        if (! $competitionId) {
            return null;
        }

        return $this->find($competitionId);
    }

    public function create(CreateCompetitionData $data): CompetitionModel
    {
        return CompetitionModel::create($data->toArray());
    }

    public function update(CompetitionModel $competition, UpdateCompetitionData $data): CompetitionModel
    {
        $competition->update($data->toArray());

        return $competition;
    }

    public function delete(CompetitionModel $competition): bool
    {
        return $competition->delete();
    }

    public function getTeamsByCompetitionId(int $competitionId): Collection
    {
        $competition = CompetitionModel::with(['teams' => function ($query) {
            $query->where('status', TeamStatus::ACCEPTED);
        }])->find($competitionId);

        return $competition ? $competition->teams : new Collection();
    }
}

