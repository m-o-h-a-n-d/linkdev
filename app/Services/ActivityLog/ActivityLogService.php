<?php

namespace App\Services\ActivityLog;

use App\Data\ActivityLog\ActivityLogData;
use App\Models\ActivityLog;
use App\Models\User;
use App\Repositories\Contracts\ActivityLog\ActivityLogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ActivityLogService
{
    public function __construct(
        protected ActivityLogRepositoryInterface $activityLogRepository
    ) {}

    /**
     * Get paginated activity logs with filters.
     */
    public function paginateLogs(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->activityLogRepository->paginate($perPage, $filters);
    }

    /**
     * Record a new activity log entry using DTO.
     */
    public function record(ActivityLogData $data): ActivityLog
    {
        return $this->activityLogRepository->create($data);
    }

    /**
     * Fluent helper to log an activity.
     */
    public function log(
        string $action,
        string $entityType,
        int $entityId,
        string $description,
        ?int $userId = null,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): ActivityLog {
        $data = ActivityLogData::make(
            action: $action,
            entityType: $entityType,
            entityId: $entityId,
            description: $description,
            userId: $userId,
            ipAddress: $ipAddress,
            userAgent: $userAgent
        );

        return $this->record($data);
    }

    /**
     * Get recent logs.
     */
    public function getRecentLogs(int $limit = 10): Collection
    {
        return $this->activityLogRepository->getRecent($limit);
    }

    /**
     * Get options for filter dropdowns.
     */
    public function getFilterOptions(): array
    {
        return [
            'actions' => $this->activityLogRepository->getDistinctActions(),
            'entity_types' => $this->activityLogRepository->getDistinctEntityTypes(),
            'users' => User::query()
                ->whereHas('activityLogs')
                ->select('id', 'name', 'email')
                ->orderBy('name')
                ->get(),
        ];
    }

    /**
     * Get activity statistics.
     */
    public function getStats(): array
    {
        return $this->activityLogRepository->getStats();
    }

    /**
     * Clear / Delete all activity logs.
     */
    public function clearAllLogs(): int
    {
        return $this->activityLogRepository->deleteAll();
    }
}
