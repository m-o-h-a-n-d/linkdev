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
