<?php

namespace App\Services;

use App\Models\Space;
use Illuminate\Database\Eloquent\Collection;

class SpaceService
{

    public function createQRCode(Space $space)
    {
        $jsonData = $space->toJson();

        $qrCodeImg = Space::format('png')
            ->size(200)
            ->generate($jsonData);
        $qrCodeBase64 = base64_encode($qrCodeImg);

        $space->qrCode = $qrCodeBase64;
        $space->save();

        return $qrCodeBase64;
    }
    public function createSpace(array $data): Space
    {
        return Space::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'capacity' => $data['capacity'],
            'buildingId' => $data['buildingId'],
        ]);
    }

    public function updateSpace(Space $space, array $data): Space
    {
        $space->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'capacity' => $data['capacity'],
            'buildingId' => $data['buildingId'],
        ]);
        return $space;
    }

    public function deleteSpace(Space $space): void
    {
        $space->delete();
    }

    public function getSpace(Space $space): Space
    {
        return Space::findOrFail($space);
    }

    public function getSpaces(Space $space): Collection
    {
        return Space::all();
    }
}
