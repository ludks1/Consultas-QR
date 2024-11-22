<?php

namespace App\Enums;

enum SpaceType: string
{
    case CLASSROOM = 'classroom';
    case LABORATORY = 'laboratory';
    case AUDITORIUM = 'auditorium';
    case LIBRARY = 'library';
    case OFFICE = 'office';
    case RESTROOM = 'restroom';
    case CAFETERIA = 'cafeteria';
    case PARKING_LOT = 'parking_lot';
    case SERVER_ROOM = 'server_room';
    case SECURITY_ROOM = 'security_room';
    case NURSE_ROOM = 'nurse_room';
    case PRINCIPAL_ROOM = 'principal_room';
    case VICE_PRINCIPAL_ROOM = 'vice_principal_room';
    case COURT = 'court';

    public static function getOptions(): array
    {
        return array_map(fn($space) => $space->value, self::cases());
    }
}
