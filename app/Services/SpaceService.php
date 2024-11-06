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
            'buildingId'=> $data['buildingId'],
            'floor'=> $data['floor'],
            'name'=> $data['name'],
            'addressDescription'=> $data['addressDescription'],
            'type'=> $data['type'],
            'qrCode'=> $data['qrCode'],
            'capacity'=> $data['capacity'],
        ]);
    }

    public function updateSpace(Space $space, array $data): Space
    {
        $space->update([
            'buildingId'=> $data['buildingId'],
            'floor'=> $data['floor'],
            'name'=> $data['name'],
            'addressDescription'=> $data['addressDescription'],
            'type'=> $data['type'],
            'qrCode'=> $data['qrCode'],
            'capacity'=> $data['capacity'],
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
