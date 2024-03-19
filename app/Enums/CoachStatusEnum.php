<?php

namespace App\Enums;

use App\Models\Coach;
use App\Traits\RandomEnum;
use App\Traits\ReverseCases;

enum CoachStatusEnum: int
{
    use RandomEnum;
    use ReverseCases;

    case UNDONE = 0;
    case PENDING = 1;
    case ACCEPTED = 2;
    case REJECTED = 3;
    case ACTIVE = 4;
    case INACTIVE = 5;

    public static function isUndone(Coach $coach): bool
    {
        return $coach->status == self::UNDONE->value;
    }
}
