<?php

namespace App\Services\Competition;

use App\Data\Competition\CreateCompetitionData;
use App\Data\Competition\UpdateCompetitionData;
use App\Repositories\Contracts\Competition\CompetitionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Competition;

class CompetitionService
{
    public function __construct(
        protected CompetitionRepositoryInterface $competitionRepository
    ) {}

    public function all(): Collection
    {
        return $this->competitionRepository->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->competitionRepository->paginate($perPage);
    }

    public function findOrFail(string|int $id): Competition
    {
        $competition = $this->competitionRepository->find($id);

        if (! $competition) {
            throw new ModelNotFoundException('Competition not found.');
        }

        return $competition;
    }

    public function findBySlugOrFail(string $slug): Competition
    {
        $competition = $this->competitionRepository->findBySlug($slug);

        if (! $competition) {
            throw new ModelNotFoundException('Competition not found.');
        }

        return $competition;
    }

    public function store(CreateCompetitionData $data): Competition
    {
        return $this->competitionRepository->create($data);
    }

    public function update(int $id, UpdateCompetitionData $data): Competition
    {
        $competition = $this->findOrFail($id);

        return $this->competitionRepository->update($competition, $data);
    }

    public function destroy(int $id): bool
    {
        $competition = $this->findOrFail($id);

        return $this->competitionRepository->delete($competition);
    }

    public function allWithRelations(array $relations): Collection
    {
        return $this->competitionRepository->allWithRelations($relations);
    }
}
