<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'competition_id',
        'group_id',
        'home_team_id',
        'away_team_id',
        'winner_team_id',
        'scheduled_at',
        'started_at',
        'ended_at',
        'status',
        'home_score',
        'away_score',
        'round_number',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    /**
     * Competition owning this match.
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * Group owning this match.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(CompetitionGroup::class, 'group_id');
    }

    /**
     * Home team.
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * Away team.
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    /**
     * Winner team.
     */
    public function winnerTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }

    /**
     * Dynamic status accessor: auto-transitions scheduled matches to live when scheduled_at <= now.
     */
    public function getStatusAttribute($value): string
    {
        $rawStatus = strtolower($value ?? 'scheduled');

        if ($rawStatus === 'scheduled' && $this->scheduled_at && $this->scheduled_at->isPast()) {
            if ($this->exists) {
                $startedAt = $this->started_at ?? $this->scheduled_at ?? now();
                try {
                    $this->newQuery()->where('id', $this->id)->where('status', 'scheduled')->update([
                        'status' => 'live',
                        'started_at' => $startedAt,
                    ]);
                    $this->attributes['status'] = 'live';
                    $this->attributes['started_at'] = $startedAt;
                } catch (\Throwable $e) {
                    // Fallback
                }
            }
            return 'live';
        }

        return $rawStatus;
    }

    /**
     * Get elapsed live seconds.
     */
    public function getElapsedSecondsAttribute(): int
    {
        if ($this->status === 'finished' && $this->started_at && $this->ended_at) {
            return (int) $this->started_at->diffInSeconds($this->ended_at);
        }

        if ($this->status === 'live' && $this->started_at) {
            return (int) $this->started_at->diffInSeconds(now());
        }

        if ($this->status === 'scheduled' && $this->scheduled_at && $this->scheduled_at->isPast()) {
            return (int) $this->scheduled_at->diffInSeconds(now());
        }

        return 0;
    }

    /**
     * Get formatted timer MM:SS.
     */
    public function getFormattedTimerAttribute(): string
    {
        if ($this->status === 'finished') {
            return 'FULL TIME';
        }

        $totalSeconds = $this->elapsed_seconds;
        $minutes = floor($totalSeconds / 60);
        $seconds = $totalSeconds % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
