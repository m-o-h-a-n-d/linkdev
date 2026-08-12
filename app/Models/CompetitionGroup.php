<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompetitionGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'competition_id',
        'name',
    ];

    /**
     * Competition to which this group belongs.
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * Teams in this group.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'group_team', 'group_id', 'team_id')
                    ->withTimestamps();
    }

    /**
     * Matches in this group.
     */
    public function matches(): HasMany
    {
        return $this->hasMany(GameMatch::class, 'group_id');
    }

    /**
     * Standings in this group.
     */
    public function standings(): HasMany
    {
        return $this->hasMany(GroupStanding::class, 'group_id');
    }
}
