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
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
        ]);
    }

    public function updateBuildin(Space $space, array $data): Space
    {
        $space->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
        ]);
        return $space;
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
