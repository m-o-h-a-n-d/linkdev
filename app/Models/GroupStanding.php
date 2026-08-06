<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupStanding extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'team_id',
        'played',
        'won',
        'draw',
        'lost',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points',
        'position_rank',
    ];

    /**
     * Group for this standing record.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(CompetitionGroup::class, 'group_id');
    }

    /**
     * Team for this standing record.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
