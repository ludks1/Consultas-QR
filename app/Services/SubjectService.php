<?php

namespace App\Services;

use App\Enums\UserType;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class SubjectService
{
    public function addSubject(User $user, Subject $subject, array $data): Subject
    {
        if ($user->subjects()->where('id', $subject)->exists()) {
            throw ValidationException::withMessages(['subjectId' => 'La materia ya está asignada.']);
        }
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para crear una materia.']);
        }
        return $subject->create([
            'name' => $data['name'],
            'code' => $data['code'],
            'description' => $data['description'],
            'career' => $data['career'],
            'semester' => $data['semester'],
        ]);
    }

    public function updateSubject(User$user, Subject $subject, array $data): Subject
    {
        if ($user['type'] !== UserType::ADMIN) {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para crear una materia.']);
        }
        $subject->update([
            'name' => $data['name'],
            'code' => $data['code'],
            'description' => $data['description'],
            'career' => $data['career'],
            'semester' => $data['semester'],
        ]);
        return $subject;
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
