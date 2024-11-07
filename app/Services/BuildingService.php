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
            'institutionId'=> $data['institutionId'],
            'name'=> $data['name'],
            'address'=> $data['address'],
            'numberOfFloors'=> $data['numberOfFloors'],
        ]);
    }

    public function updateBuildin(Space $space, array $data): Space
    {
        $space->update([
            'institutionId'=> $data['institutionId'],
            'name'=> $data['name'],
            'address'=> $data['address'],
            'numberOfFloors'=> $data['numberOfFloors'],
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
