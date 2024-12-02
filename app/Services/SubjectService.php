<?php

namespace App\Services;

use App\Enums\Career;
use App\Enums\UserType;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SubjectService
{
    public function addSubject(array $data): Subject
    {
        // Crea la materia en la base de datos con los datos proporcionados
        try {
            return Subject::create([
                'name' => $data['name'],
                'code' => $data['code'],
                'description' => $data['description'] ?? null,
                'career' => $data['career'],
                'semester' => $data['semester'] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al crear materia: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateSubject(Subject $subject, array $data): Subject
    {
        try {
            $subject->update([
                'name' => $data['name'],
                'code' => $data['code'],
                'description' => $data['description'],
                'career' => $data['career'],
                'semester' => $data['semester'],
            ]);

            return $subject;
        } catch (\Exception $e) {
            // Manejo de errores, puedes lanzar una excepción personalizada si lo necesitas.
            throw new \RuntimeException('Error al actualizar la materia: ' . $e->getMessage());
        }
    }

    public function deleteSubject(Subject $subject): void
    {
        $subject->delete();
    }

    public function getSubjects(): Collection
    {
        return Subject::all();
    }
}
