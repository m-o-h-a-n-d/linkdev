<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'competition_id',
        'matches_played',
        'wins',
        'draws',
        'losses',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points',
    ];

    /**
     * Team for these statistics.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Competition for these statistics.
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
