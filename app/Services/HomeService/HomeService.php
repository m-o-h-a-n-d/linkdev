<?php

namespace App\Services\HomeService;

use App\Repositories\Contracts\Competition\CompetitionRepositoryInterface;
use App\Repositories\Contracts\Match\MatchRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HomeService
{
    public function __construct(
        protected MatchRepositoryInterface $matchRepository,
        protected CompetitionRepositoryInterface $competitionRepository
    ) {}

    public function getCompetitions(): Collection
    {
        return $this->competitionRepository->all();
    }

    public function getUpcomingMatches(int $limit = 3): Collection
    {
        return $this->matchRepository->getUpcomingMatches($limit);
    }
}
