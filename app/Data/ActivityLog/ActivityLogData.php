<?php

namespace App\Data\ActivityLog;

use Spatie\LaravelData\Data;

class ActivityLogData extends Data
{
    public function __construct(
        public string $action,
        public string $entity_type,
        public int $entity_id,
        public string $description,
        public ?int $user_id = null,
        public ?string $ip_address = null,
        public ?string $user_agent = null,
    ) {}

    /**
     * Create ActivityLogData from attributes with sensible defaults for request context.
     */
    public static function make(
        string $action,
        string $entityType,
        int $entityId,
        string $description,
        ?int $userId = null,
        ?string $ipAddress = null,
        ?string $userAgent = null,
    ): self {
        return new self(
            action: strtoupper($action),
            entity_type: class_basename($entityType),
            entity_id: $entityId,
            description: $description,
            user_id: $userId ?? auth()->id(),
            ip_address: $ipAddress ?? request()?->ip() ?? '127.0.0.1',
            user_agent: $userAgent ?? (request()?->userAgent() ?? 'System'),
        );
    }
}
