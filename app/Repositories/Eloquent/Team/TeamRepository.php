<?php

namespace App\Repositories\Eloquent\Team;

use App\Data\Team\CreateTeamData;
use App\Data\Team\UpdateTeamData;
use App\Models\Team;
use App\Repositories\Contracts\Team\TeamRepositoryInterface;
use App\Utility\Enums\TeamStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository implements TeamRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Team::latest()->paginate($perPage);
    }

    public function all(): Collection
    {
        return Team::all();
    }

    public function find(int $id): ?Team
    {
        return Team::find($id);
    }

    public function create(CreateTeamData $data, ?string $logoPath = null): Team
    {
        $payload = array_filter($data->toArray(), function ($value) {
            return $value !== null;
        });

        if ($logoPath) {
            $payload['logo'] = $logoPath;
        } elseif (empty($payload['logo'])) {
            $payload['logo'] = 'defaults/team-crest.png';
        }

        return Team::create($payload);
    }

    public function update(Team $team, UpdateTeamData $data, ?string $logoPath = null): Team
    {
        $payload = array_filter($data->toArray(), function ($value) {
            return $value !== null;
        });

        if ($logoPath) {
            $payload['logo'] = $logoPath;
        }

        $team->update($payload);
        return $team->fresh();
    }

    public function updateStatus(Team $team, string $status, ?string $reason = null): Team
    {
        $team->update([
            'status'           => $status,
            'rejection_reason' => $status === TeamStatus::REJECTED->value ? $reason : null,
        ]);

        return $team->fresh();
    }

    public function getPendingTeams(): Collection
    {
        return Team::where('status', TeamStatus::PENDING->value)->get();
    }

    public function delete(Team $team): bool
    {
        return $team->delete();
    }
}
