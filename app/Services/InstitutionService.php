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
    public function createInstitution(array $data)
    {
        if (isset($data['logo'])) {
            $data['logo'] = $data['logo']->store('logos', 'public');
        }

        Institution::create($data);
    }

    public function updateInstitutions(Institution $institution, array $data): Institution
    {
        $institution->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'logo' => $data['logo'],
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
