<?php

namespace App\Services;

use App\Models\Building;
use App\Models\Space;
use Illuminate\Database\Eloquent\Collection;

class BuildingService
{
    public function createBuilding(array $data): Building
    {
        return Building::create([
            'institutionId' => $data['institutionId'],
            'name' => $data['name'],
            'address' => $data['address'],
            'numberOfFloors' => $data['numberOfFloors'],
        ]);
    }

    public function updateBuilding(Building $building, array $data): Building
    {
        // Valida y actualiza los datos, incluyendo el número de pisos
        $building->update([
            'institutionId' => $data['institutionId'],
            'name' => $data['name'],
            'address' => $data['address'] ?? null, // Maneja si 'address' no está presente
            'numberOfFloors' => $data['numberOfFloors'], // Agregado para incluir el número de pisos
        ]);

        return $building;
    }


    public function deleteBuilding(Building $building): void
    {
        $building->delete();
    }

    public function getBuilding(Building $building): Building
    {
        return Building::findOrFail($building);
    }

    public function getBuildings(Building $building): Collection
    {
        return Building::all();
    }
}
