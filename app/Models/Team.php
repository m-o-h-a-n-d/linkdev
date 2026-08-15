<?php

namespace App\Models;

use App\Utility\Enums\TeamStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'short_name',
        'logo',
        'city',
        'country',
        'email',
        'phone',
        'manager_name',
        'arena',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'status' => TeamStatus::class,
    ];

    protected $appends = [
        'logo_url',
    ];

    public function getLogoUrlAttribute(): string
    {
        if (empty($this->logo)) {
            return asset('backend/img/undraw_profile.svg');
        }

        if (filter_var($this->logo, FILTER_VALIDATE_URL) || str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        }

        if (str_starts_with($this->logo, 'defaults/') || str_starts_with($this->logo, 'backend/') || str_starts_with($this->logo, 'assets/')) {
            return asset($this->logo);
        }

        if (str_starts_with($this->logo, 'storage/')) {
            return asset($this->logo);
        }

        return asset('storage/' . $this->logo);
    }

    public function isPending(): bool
    {
        return $this->status === TeamStatus::PENDING;
    }

    public function isAccepted(): bool
    {
        return $this->status === TeamStatus::ACCEPTED;
    }

    public function isRejected(): bool
    {
        return $this->status === TeamStatus::REJECTED;
    }


    /**
     * Competitions this team participates in.
     */
    public function competitions(): BelongsToMany
    {
        return $this->belongsToMany(Competition::class, 'competition_team')
                    ->withTimestamps();
    }

    /**
     * Groups this team belongs to.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(CompetitionGroup::class, 'group_team', 'team_id', 'group_id')
                    ->withTimestamps();
    }

    /**
     * Matches where team is home team.
     */
    public function homeMatches(): HasMany
    {
        return $this->hasMany(GameMatch::class, 'home_team_id');
    }

    /**
     * Matches where team is away team.
     */
    public function awayMatches(): HasMany
    {
        return $this->hasMany(GameMatch::class, 'away_team_id');
    }

    /**
     * Matches won by this team.
     */
    public function wonMatches(): HasMany
    {
        return $this->hasMany(GameMatch::class, 'winner_team_id');
    }

    /**
     * Competitions won by this team.
     */
    public function wonCompetitions(): HasMany
    {
        return $this->hasMany(Competition::class, 'winner_team_id');
    }

    /**
     * Group standings for this team.
     */
    public function groupStandings(): HasMany
    {
        return $this->hasMany(GroupStanding::class);
    }

    /**
     * Competition statistics for this team.
     */
    public function statistics(): HasMany
    {
        return $this->hasMany(TeamStatistic::class);
    }
}
