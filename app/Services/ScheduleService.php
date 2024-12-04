<?php

namespace App\Services;

use App\Enums\UserType;
use App\Models\Building;
use App\Models\Institution;
use App\Models\Schedule;
use App\Models\Space;
use App\Models\User;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class ScheduleService
{

    private function updateQRCode(Space $space)
    {
        // Obtener todos los horarios asociados al espacio
        $schedules = Schedule::where('spaceId', $space->id)->get();

        // Construir los datos del QR
        $qrData = [
            'spaceName' => $space->name,
            'schedules' => $schedules->map(function ($schedule) {
                return [
                    'subjectId' => $schedule->subjectId,
                    'day' => $schedule->day,
                    'startIime' => $schedule->startIime,
                    'endIime' => $schedule->endIime,
                ];
            }),
        ];

        // Convertir los datos a JSON
        $jsonData = json_encode($qrData);

        // Crear el código QR
        $qrCode = new QrCode($jsonData);
        $qrCode->setSize(200);

        // Generar la imagen QR en formato PNG
        $writer = new PngWriter();
        $qrCodeImg = $writer->write($qrCode)->getString();

        // Convertir la imagen generada a base64
        $qrCodeBase64 = base64_encode($qrCodeImg);

        // Asignar el nuevo código QR al espacio
        $space->qrCode = $qrCodeBase64;

        // Guardar el espacio con el código QR actualizado
        $space->save();

        return $qrCodeBase64;
    }


    public function storeSchedule(array $data)
    {
        // Validar que la hora de inicio no sea mayor que la hora de fin
        if (strtotime($data['startIime']) >= strtotime($data['endIime'])) {
            return 'La hora de inicio no puede ser mayor o igual a la hora de fin';
        }

        // Verificar conflictos en el mismo salón, mismo día y horario solapado
        $conflict = Schedule::where('spaceId', $data['spaceId'])
            ->where('day', $data['day'])
            ->where(function ($query) use ($data) {
                // Conflicto si las horas se solapan
                $query->whereBetween('startIime', [$data['startIime'], $data['endIime']])
                    ->orWhereBetween('endIime', [$data['startIime'], $data['endIime']])
                    ->orWhere(function ($query) use ($data) {
                        $query->where('startIime', '<=', $data['startIime'])
                            ->where('endIime', '>=', $data['endIime']);
                    });
            })
            ->exists();

        if ($conflict) {
            return 'Existe un conflicto de horario con otro evento en el mismo salón y día';
        }

        // Crear el horario si no hay conflictos
        try {
            Schedule::create([
                'startIime' => $data['startIime'],  // Verifica que sea 'start_time' en tu base de datos
                'endIime' => $data['endIime'],      // Lo mismo para 'end_time'
                'day' => $data['day'],
                'subjectId' => $data['subjectId'],
                'spaceId' => $data['spaceId'],
            ]);
            // Obtener el espacio asociado
            $space = Space::findOrFail($data['spaceId']);

            // Actualizar el QR del salón
            $this->updateQRCode($space);
        } catch (\Exception $e) {
            return 'Error al registrar el horario: ' . $e->getMessage();
        }

        return true; // Horario registrado con éxito
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
        // Verificar permisos
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages([
                'type' => 'No cuentas con los permisos para eliminar un horario.',
            ]);
        }

        // Obtener el espacio asociado antes de eliminar el horario
        $space = Space::findOrFail($schedule->spaceId);

        // Eliminar el horario
        $schedule->delete();

        // Actualizar el código QR del espacio
        $this->updateQRCode($space);
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

    public function getSpaces()
    {
        return Space::all();
    }
}
