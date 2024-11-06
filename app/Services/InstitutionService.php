<?php

namespace App\Services;

use App\Enums\Career;
use App\Enums\UserType;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class InstitutionService
{
    /**
     * @throws ValidationException
     */
    public function createInstitution(array $data): Institution
    {
        if ($data['type'] !== UserType::ADMIN && User::where('type', UserType::ADMIN)->exists()) {
            throw ValidationException::withMessages(['type' => 'Ya existe un administrador.']);
        }
        return Institution::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
        ]);
    }

    public function updateInstitutions(Institution $institution, array $data): Institution
    {
        $institution->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
        ]);
        return $institution;
    }

    public function deleteInstitution(Institution $institution): void
    {
        $institution->delete();
    }

    public function getInstitutions(): Collection
    {
        return Institution::all();
    }

    public function getInstitution(int $id): Institution
    {
        return Institution::findOrFail($id);
    }
}
