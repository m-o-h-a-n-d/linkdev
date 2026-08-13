<?php

namespace App\Repositories\Contracts\Competition;

use App\Data\Competition\CreateCompetitionData;
use App\Data\Competition\UpdateCompetitionData;
use App\Models\Competition as CompetitionModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CompetitionRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function all(): Collection;

    public function allWithRelations(array $relations = []): Collection;

    public function find(string|int $id): ?CompetitionModel;

    public function findBySlug(string $slug): ?CompetitionModel;

    public function create(CreateCompetitionData $data): CompetitionModel;

    public function update(CompetitionModel $competition, UpdateCompetitionData $data): CompetitionModel;

    public function delete(CompetitionModel $competition): bool;
}
