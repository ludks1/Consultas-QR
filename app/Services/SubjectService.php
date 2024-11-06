<?php

namespace App\Services;

use App\Enums\UserType;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class SubjectService
{
    public function addSubject(User $user, Subject $subject): Subject
    {
        if ($user->subjects()->where('id', $subject)->exists()) {
            throw ValidationException::withMessages(['subjectId' => 'La materia ya está asignada.']);
        }
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para crear una materia.']);
        }
        return $subject->create([
            'name' => $subject['name'],
            'code' => $subject['code'],
            'description' => $subject['description'],
            'career' => $subject['career'],
        ]);
    }

    public function deleteSubject(User $user, Subject $subject): void
    {
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para eliminar una materia.']);
        }
        $subject->delete();
    }

    public function getSubjects(Subject $subject): Collection
    {
        return Subject::all();
    }
}
