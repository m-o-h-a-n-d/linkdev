<?php

namespace App\Services\Competition;

use App\Data\Competition\CreateCompetitionData;
use App\Data\Competition\UpdateCompetitionData;
use App\Repositories\Contracts\Competition\CompetitionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Competition;

use App\Utility\ActivityLogger;

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
        $competition = $this->competitionRepository->create($data);

        ActivityLogger::log(
            action: 'CREATED',
            entityType: 'Competition',
            entityId: $competition->id,
            description: "Created competition '{$competition->name}' ({$competition->season})."
        );

        return $competition;
    }

    public function update(int $id, UpdateCompetitionData $data): Competition
    {
        $competition = $this->findOrFail($id);

        $updated = $this->competitionRepository->update($competition, $data);

        ActivityLogger::log(
            action: 'UPDATED',
            entityType: 'Competition',
            entityId: $updated->id,
            description: "Updated tournament details for '{$updated->name}'."
        );

        return $updated;
    }

    public function destroy(int $id): bool
    {
        $competition = $this->findOrFail($id);
        $name = $competition->name;
        $compId = $competition->id;

        $deleted = $this->competitionRepository->delete($competition);

        if ($deleted) {
            ActivityLogger::log(
                action: 'DELETED',
                entityType: 'Competition',
                entityId: $compId,
                description: "Deleted competition '{$name}'."
            );
        }

        return $deleted;
    }

    public function allWithRelations(array $relations): Collection
    {
        return $this->competitionRepository->allWithRelations($relations);
    }
}
