<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Competition extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'season',
        'status',
        'start_date',
        'end_date',
        'winner_team_id',
        'created_by_user_id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Competition $competition) {
            if ($competition->isForceDeleting()) {
                $competition->groups()->withTrashed()->forceDelete();
                $competition->settings()->withTrashed()->forceDelete();
                $competition->matches()->withTrashed()->forceDelete();
            } else {
                $competition->groups()->delete();
                $competition->settings()->delete();
                $competition->matches()->delete();
            }
        });

        static::restoring(function (Competition $competition) {
            $competition->groups()->onlyTrashed()->restore();
            $competition->settings()->onlyTrashed()->restore();
            $competition->matches()->onlyTrashed()->restore();
        });
    }

    /**
     * Get the team that won this competition.
     */
    public function winnerTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }

    /**
     * Get the user who created this competition.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * Get the settings for this competition.
     */
    public function settings(): HasOne
    {
        return $this->hasOne(CompetitionSetting::class);
    }

    /**
     * Teams participating in this competition.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'competition_team')
                    ->withTimestamps();
    }

    /**
     * Groups in this competition.
     */
    public function groups(): HasMany
    {
        return $this->hasMany(CompetitionGroup::class);
    }

    /**
     * Matches in this competition.
     */
    public function matches(): HasMany
    {
        return $this->hasMany(GameMatch::class);
    }

    /**
     * Team statistics in this competition.
     */
    public function statistics(): HasMany
    {
        return $this->hasMany(TeamStatistic::class);
    }
}
