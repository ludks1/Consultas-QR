<?php

namespace App\Services;

use App\Enums\UserType;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class EventService
{
    public function createEvent(User $user, Event $event): Event
    {
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para crear un evento.']);
        }
        return Event::create([
            'institutionId' => $event['institutionId'],
            'buildingId' => $event['buildingId'],
            'spaceId' => $event['spaceId'],
            'name' => $event['name'],
            'description' => $event['description'],
            'startDate' => $event['startDate'],
            'endDate' => $event['endDate'],
            'startTime' => $event['startTime'],
            'endTime' => $event['endTime'],
        ]);
    }

    public function updateEvent(User $user, Event $event): Event
    {
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para actualizar un evento.']);
        }
        $event->update([
            'institutionId' => $event['institutionId'],
            'buildingId' => $event['buildingId'],
            'spaceId' => $event['spaceId'],
            'name' => $event['name'],
            'description' => $event['description'],
            'startDate' => $event['startDate'],
            'endDate' => $event['endDate'],
            'startTime' => $event['startTime'],
            'endTime' => $event['endTime'],
        ]);
        return $event;
    }

    public function deleteEvent(User $user, Event $event): void
    {
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para eliminar un evento.']);
        }
        $event->delete();
    }
    public function getEvents(User $user): Collection
    {
        return $user->events;
    }
}
