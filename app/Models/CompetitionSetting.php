<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompetitionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'competition_id',
        'competition_type',
        'max_teams',
        'points_win',
        'points_draw',
        'points_loss',
    ];

    /**
     * Competition owning these settings.
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
