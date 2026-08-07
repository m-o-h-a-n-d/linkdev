<?php

namespace App\Repositories\Contracts\Competition;

use App\Data\Competition\CreateCompetitionData;
use App\Data\Competition\UpdateCompetitionData;
use App\Models\Competition;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CompetitionRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function all(): Collection;

    public function find(int $id): ?Competition;

    public function create(CreateCompetitionData $data): Competition;

    public function update(Competition $competition, UpdateCompetitionData $data): Competition;

    public function delete(Competition $competition): bool;
}
