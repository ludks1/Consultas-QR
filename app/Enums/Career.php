<?php

namespace App\Enums;

enum Career: string
{
    case ISW = 'Software Engineering';
    case IPI = 'Industrial Production Engineering';
    case ITC = 'Computer Engineering';

    public static function getOptions(): array
    {
        return [
            self::ISW->value,
            self::IPI->value,
            self::ITC->value,
        ];
    }
}
