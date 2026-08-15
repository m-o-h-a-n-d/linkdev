<?php

namespace App\Utility;

use App\Models\ActivityLog;
use App\Services\ActivityLog\ActivityLogService;

class ActivityLogger
{
    /**
     * Quickly record an activity log entry anywhere in the application.
     */
    public static function log(
        string $action,
        string $entityType,
        int $entityId,
        string $description,
        ?int $userId = null,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): ActivityLog {
        return app(ActivityLogService::class)->log(
            action: $action,
            entityType: $entityType,
            entityId: $entityId,
            description: $description,
            userId: $userId,
            ipAddress: $ipAddress,
            userAgent: $userAgent
        );
    }
}
