<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'description',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'entity_id' => 'integer',
        ];
    }

    /**
     * User who performed the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'System / Automated',
            'email' => 'system@system.local',
        ]);
    }

    /**
     * Scope a query to filter by user.
     */
    public function scopeForUser(Builder $query, ?int $userId): Builder
    {
        return $userId ? $query->where('user_id', $userId) : $query;
    }

    /**
     * Scope a query to filter by action.
     */
    public function scopeForAction(Builder $query, ?string $action): Builder
    {
        return $action ? $query->where('action', $action) : $query;
    }

    /**
     * Scope a query to filter by entity type.
     */
    public function scopeForEntityType(Builder $query, ?string $entityType): Builder
    {
        return $entityType ? $query->where('entity_type', $entityType) : $query;
    }

    /**
     * Scope a query to search descriptions and IP addresses.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($search) {
            $q->where('description', 'like', "%{$search}%")
                ->orWhere('ip_address', 'like', "%{$search}%")
                ->orWhere('action', 'like', "%{$search}%")
                ->orWhere('entity_type', 'like', "%{$search}%")
                ->orWhereHas('user', function (Builder $userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        });
    }

    /**
     * Badge class helper for Action.
     */
    public function getActionBadgeClassAttribute(): string
    {
        return match (strtoupper($this->action)) {
            'CREATED', 'ACCEPTED' => 'badge-success',
            'UPDATED' => 'badge-info',
            'DELETED', 'REJECTED' => 'badge-danger',
            'LOGIN' => 'badge-warning',
            'LOGOUT' => 'badge-secondary',
            'STATUS_CHANGE' => 'badge-primary',
            default => 'badge-dark',
        };
    }

    /**
     * Inline badge style tailored for dark mode.
     */
    public function getActionBadgeStyleAttribute(): string
    {
        return match (strtoupper($this->action)) {
            'CREATED', 'ACCEPTED' => 'background: rgba(16, 185, 129, 0.18); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35);',
            'UPDATED' => 'background: rgba(6, 182, 212, 0.18); color: #38bdf8; border: 1px solid rgba(6, 182, 212, 0.35);',
            'DELETED', 'REJECTED' => 'background: rgba(239, 68, 68, 0.18); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.35);',
            'LOGIN' => 'background: rgba(245, 158, 11, 0.18); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35);',
            'LOGOUT' => 'background: rgba(148, 163, 184, 0.18); color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.35);',
            'STATUS_CHANGE' => 'background: rgba(234, 88, 12, 0.18); color: #fb923c; border: 1px solid rgba(234, 88, 12, 0.35);',
            default => 'background: rgba(100, 116, 139, 0.18); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.35);',
        };
    }
}
