<?php

namespace App\Services;

use App\Enums\UserType;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class ScheduleService
{
    public function createSchedule(User $user, Schedule $schedule): Schedule
    {
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para crear un horario.']);
        }
        return Schedule::create([
            'spaceId' => $schedule['spaceId'],
            'subjectId' => $schedule['subjectId'],
            'day' => $schedule['day'],
            'startIime' => $schedule['startIime'],
            'endIime' => $schedule['endIime'],
        ]);
    }

    public function updateSchedule(User $user, Schedule $schedule, array $data): Schedule
    {
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para modificar un horario.']);
        }
        $schedule->update([
            'spaceId' => $data['spaceId'],
            'subjectId' => $data['subjectId'],
            'day' => $data['day'],
            'startIime' => $data['startIime'],
            'endIime' => $data['endIime'],
        ]);
        return $schedule;
    }

    public function deleteSchedule(User $user, Schedule $schedule): void
    {
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para eliminar un horario.']);
        }
        $schedule->delete();
    }

    public function getSchedule(User $user, Schedule $schedule): Collection
    {
        if ($user['type'] === UserType::STUDENT) {
            return $schedule['day']->where('date', now());
        } elseif ($user['type'] === UserType::TEACHER || $user['type'] === UserType::ADMIN) {
            return Schedule::all();
        } else {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para ver el horario.']);
        }
    }
}
