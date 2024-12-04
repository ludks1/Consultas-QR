<?php

namespace App\Enums;

enum Days: string
{
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';
    case SUNDAY = 'sunday';

    public static function getOptions(): array
    {
        return array_map(fn($day) => $day->value, self::cases());
    }
}
