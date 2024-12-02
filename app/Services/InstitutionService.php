<?php

namespace App\Services;

use App\Models\Institution;
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
        try {
            $institution->update([
                'name' => $data['name'],
                'address' => $data['address'],
                'logo' => $data['logo'] ?? $institution->logo, // Mantener el logo actual si no se envió uno nuevo
                'phone' => $data['phone'] ?? $institution->phone,
                'email' => $data['email'] ?? $institution->email,
            ]);
            return $institution;
        } catch (\Exception $e) {
            throw new \RuntimeException('Error al actualizar la institución: ' . $e->getMessage());
        }
    }

    public function deleteInstitution(Institution $institution): void
    {
        try {
            $institution->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException('Error al eliminar la institución: ' . $e->getMessage());
        }
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
