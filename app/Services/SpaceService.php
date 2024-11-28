<?php

namespace App\Services;

use App\Models\Space;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Database\Eloquent\Collection;

class SpaceService
{

    private function createQRCode(Space $space)
    {
        // Convertir el objeto a JSON
        $jsonData = $space->toJson();

        // Crear el código QR
        $qrCode = new QrCode($jsonData);
        $qrCode->setSize(200);

        // Generar la imagen QR en formato PNG
        $writer = new PngWriter();
        $qrCodeImg = $writer->write($qrCode)->getString();

        // Convertir la imagen generada a base64
        $qrCodeBase64 = base64_encode($qrCodeImg);

        // Asignar el código QR al espacio
        $space->qrCode = $qrCodeBase64;

        // Guardar el espacio con el código QR
        $space->save();

        return $qrCodeBase64;
    }

    public function createSpace(array $data): Space
    {
        // Crear el espacio en la base de datos
        $space = Space::create([
            'buildingId' => $data['buildingId'],
            'floor' => $data['floor'],
            'name' => $data['name'],
            'addressDescription' => $data['addressDescription'] ?? null,
            'type' => $data['type'],
            'capacity' => $data['capacity'],
        ]);

        // Generar el código QR después de crear el espacio
        $this->createQRCode($space);

        // Retornar el objeto space
        return $space;
    }

    public function updateSpace(Space $space, array $data): Space
    {
        $space->update([
            'buildingId' => $data['buildingId'],
            'floor' => $data['floor'],
            'name' => $data['name'],
            'addressDescription' => $data['addressDescription'],
            'type' => $data['type'],
            'qrCode' => $data['qrCode'],
            'capacity' => $data['capacity'],
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

    public function getSpaces(): Collection
    {
        return Space::all();
    }
}
