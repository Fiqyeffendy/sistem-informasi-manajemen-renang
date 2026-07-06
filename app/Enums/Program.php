<?php

namespace App\Enums;

enum Program: string
{
    case WATER_BABIES = 'Fella WaterBabies (Swimming Lessons for Toddlers)';
    case SWIM_STARS   = 'Fella SwimStars (Swimming Lessons for Kids)';
    case AQUA_FIT     = 'Fella AquaFit (Swimming Lessons for Adults)';
    case SWIM_ELITE   = 'Fella SwimElite (Swimming Lessons for Elite)';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::WATER_BABIES => 'WaterBabies (Toddlers)',
            self::SWIM_STARS   => 'SwimStars (Kids)',
            self::AQUA_FIT     => 'AquaFit (Adults)',
            self::SWIM_ELITE   => 'SwimElite (Elite)',
        };
    }
}
