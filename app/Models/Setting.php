<?php

namespace App\Models;

use App\Utility\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'favicon',
        'icon',
        'session',
        'header',
        'description',
        'matches_image',
    ];

    /**
     * Get the full URL for the favicon.
     */
    public function getFaviconUrlAttribute(): ?string
    {
        if (! $this->favicon) {
            return null;
        }

        if (str_starts_with($this->favicon, 'http://') || str_starts_with($this->favicon, 'https://')) {
            return $this->favicon;
        }

        if (str_starts_with($this->favicon, 'frontend/') || str_starts_with($this->favicon, 'images/')) {
            return asset($this->favicon);
        }

        return Storage::disk('public')->url($this->favicon);
    }

    /**
     * Get the full URL for the site icon / logo.
     */
    public function getIconUrlAttribute(): ?string
    {
        if (! $this->icon) {
            return null;
        }

        if (str_starts_with($this->icon, 'http://') || str_starts_with($this->icon, 'https://')) {
            return $this->icon;
        }

        if (str_starts_with($this->icon, 'frontend/') || str_starts_with($this->icon, 'images/')) {
            return asset($this->icon);
        }

        return Storage::disk('public')->url($this->icon);
    }

    /**
     * Get the full URL for the matches diagram / bracket image.
     */
    public function getMatchesImageUrlAttribute(): string
    {
        if (! $this->matches_image) {
            return asset('frontend/images/ihf-bracket.png');
        }

        if (str_starts_with($this->matches_image, 'http://') || str_starts_with($this->matches_image, 'https://')) {
            return $this->matches_image;
        }

        if (str_starts_with($this->matches_image, 'frontend/') || str_starts_with($this->matches_image, 'images/')) {
            return asset($this->matches_image);
        }

        return Storage::disk('public')->url($this->matches_image);
    }
}
