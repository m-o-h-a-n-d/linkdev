<?php

namespace App\Services\Standing;

use App\Repositories\Contracts\Competition\CompetitionRepositoryInterface;
use App\Repositories\Contracts\Standing\GroupStandingRepositoryInterface;
use App\Repositories\Contracts\Standing\TeamStatisticRepositoryInterface;

class StandingService
{
    public function __construct(
        protected CompetitionRepositoryInterface $competitionRepository,
        protected GroupStandingRepositoryInterface $groupStandingRepository,
        protected TeamStatisticRepositoryInterface $teamStatisticRepository
    ) {}

    /**
     * Get data required for the Group Standings view.
     */
    public function getGroupStandingsData(?int $competitionId = null): array
    {
        $competitions = $this->competitionRepository->allWithRelations(['groups.standings.team']);

        $selectedCompetitionId = $competitionId ?? $competitions->first()?->id;
        $selectedCompetition = $competitions->firstWhere('id', $selectedCompetitionId);

        $groupStandings = $this->groupStandingRepository->getByCompetitionId($selectedCompetitionId);

        return [
            'competitions' => $competitions,
            'selectedCompetition' => $selectedCompetition,
            'groupStandings' => $groupStandings,
        ];
    }

    /**
     * Get data required for the Competition Team Statistics view.
     */
    public function getTeamStatisticsData(?int $competitionId = null): array
    {
        $competitions = $this->competitionRepository->allWithRelations(['statistics.team']);

        $selectedCompetitionId = $competitionId ?? $competitions->first()?->id;
        $selectedCompetition = $competitions->firstWhere('id', $selectedCompetitionId);

        $teamStatistics = $this->teamStatisticRepository->getByCompetitionId($selectedCompetitionId);

        return [
            'competitions' => $competitions,
            'selectedCompetition' => $selectedCompetition,
            'teamStatistics' => $teamStatistics,
        ];
    }
}
