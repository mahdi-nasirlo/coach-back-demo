<?php

namespace App\Traits;

trait EnumHelperTrait
{
    public static function array(): array
    {
        return array_combine(self::names(), self::values());
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
