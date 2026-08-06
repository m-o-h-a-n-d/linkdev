<?php

namespace App\Models;

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
    ];

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
