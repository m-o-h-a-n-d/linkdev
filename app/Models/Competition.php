<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Competition extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
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

    // Accessors Not Mutators
    /*
            Accessors are used to format or manipulate the value of an attribute when it is accessed,
            while mutators are used to modify the value of an attribute before it is saved to the database.
     */
    public function getSlugAttribute(): string
    {
        return Str::slug($this->name);
    }



    /*
|--------------------------------------------------------------------------
| Soft Deletes في Laravel
|--------------------------------------------------------------------------
|
|
|
| withTrashed()
|-------------
|بتجيب كل الـ Records:
|- الـ Records العادية التي deleted_at = NULL
|- الـ Records التي تم حذفها Soft Delete
|
|
|
| مثال:
| $competition->groups()->withTrashed()->get();
|
|
| onlyTrashed()
| -------------
| بتجيب فقط الـ Records التي تم حذفها بـ Soft Delete
| أي التي deleted_at ليست NULL.
|
| مثال:
| $competition->groups()->onlyTrashed()->get();
|
|
| ملخص سريع:
|
| withTrashed()  => كل الـ Records (الموجودة + المحذوفة Soft Delete)
| onlyTrashed()  => المحذوفة بـ Soft Delete فقط
| Query عادي     => الـ Records الموجودة فقط
|
*/

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
