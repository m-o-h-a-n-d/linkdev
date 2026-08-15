<?php

namespace App\Repositories\Eloquent\ActivityLog;

use App\Data\ActivityLog\ActivityLogData;
use App\Models\ActivityLog;
use App\Repositories\Contracts\ActivityLog\ActivityLogRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = ActivityLog::query()
            ->with(['user.admin', 'user.roles'])
            ->latest('id');

        if (! empty($filters['action'])) {
            $query->forAction($filters['action']);
        }

        if (! empty($filters['entity_type'])) {
            $query->forEntityType($filters['entity_type']);
        }

        if (! empty($filters['user_id'])) {
            $query->forUser((int) $filters['user_id']);
        }

        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (! empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function create(ActivityLogData $data): ActivityLog
    {
        return ActivityLog::create([
            'user_id' => $data->user_id,
            'action' => $data->action,
            'entity_type' => $data->entity_type,
            'entity_id' => $data->entity_id,
            'description' => $data->description,
            'ip_address' => $data->ip_address,
            'user_agent' => $data->user_agent,
            'created_at' => now(),
        ]);
    }

    public function find(int $id): ?ActivityLog
    {
        return ActivityLog::with(['user.admin', 'user.roles'])->find($id);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return ActivityLog::with(['user.admin', 'user.roles'])
            ->latest('id')
            ->limit($limit)
            ->get();
    }

    public function getDistinctActions(): array
    {
        return ActivityLog::query()
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action')
            ->toArray();
    }

    public function getDistinctEntityTypes(): array
    {
        return ActivityLog::query()
            ->select('entity_type')
            ->distinct()
            ->orderBy('entity_type')
            ->pluck('entity_type')
            ->toArray();
    }

    public function getStats(): array
    {
        $today = Carbon::today();

        return [
            'total_logs' => ActivityLog::count(),
            'today_logs' => ActivityLog::whereDate('created_at', $today)->count(),
            'unique_users' => ActivityLog::whereNotNull('user_id')->distinct('user_id')->count('user_id'),
            'top_action' => ActivityLog::query()
                ->select('action', DB::raw('count(*) as count'))
                ->groupBy('action')
                ->orderByDesc('count')
                ->first()?->action ?? 'N/A',
        ];
    }

    public function deleteAll(): int
    {
        return ActivityLog::query()->delete();
    }
}
