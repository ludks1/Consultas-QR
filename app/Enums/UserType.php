<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case STUDENT = 'student';
    case TEACHER = 'teacher';

    public static function getAllowedOptions(): array
    {
        // Devuelve solo las opciones específicas
        return [
            self::TEACHER->value,
            self::STUDENT->value,
        ];
    }
}
