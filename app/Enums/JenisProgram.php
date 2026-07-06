<?php

namespace App\Enums;

enum JenisProgram: string
{
    case SMALL_GROUP  = 'Small Group';
    case GROUP        = 'Group';
    case SEMI_PRIVATE = 'Semi-private';
    case PRIVATE      = 'Private';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
