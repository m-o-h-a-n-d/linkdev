<?php

namespace App\Utility\Enums;

enum TeamStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending Review',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'badge-warning',
            self::ACCEPTED => 'badge-success',
            self::REJECTED => 'badge-danger',
        };
    }
}
