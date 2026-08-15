<?php

namespace App\Repositories\Contracts\ActivityLog;

use App\Data\ActivityLog\ActivityLogData;
use App\Models\ActivityLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ActivityLogRepositoryInterface
{
    /**
     * Get paginated logs with dynamic filters.
     */
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    /**
     * Create a new activity log entry.
     */
    public function create(ActivityLogData $data): ActivityLog;

    /**
     * Find log by ID.
     */
    public function find(int $id): ?ActivityLog;

    /**
     * Get latest logs.
     */
    public function getRecent(int $limit = 10): Collection;

    /**
     * Get distinct actions list for filtering.
     */
    public function getDistinctActions(): array;

    /**
     * Get distinct entity types list for filtering.
     */
    public function getDistinctEntityTypes(): array;

    /**
     * Get statistics summary for activity logs dashboard/view.
     */
    public function getStats(): array;

    /**
     * Delete all activity log records.
     */
    public function deleteAll(): int;
}
