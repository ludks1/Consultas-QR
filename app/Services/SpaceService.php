<?php

namespace App\Services;

use App\Models\Space;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function reconstructQRCode($spaceId)
    {
        // Obtener el espacio por ID
        $space = Space::find($spaceId);

        if (!$space || !$space->qrCode) {
            throw new \Exception("No se encontró el espacio o no tiene un código QR asociado.");
        }

        // Obtener la cadena base64 del código QR almacenado
        $qrCodeBase64 = $space->qrCode;

        // Decodificar la cadena base64 a binario
        $qrCodeImg = base64_decode($qrCodeBase64);

        // Escribir el código QR (aunque ya lo tenemos como base64, podemos reconvertirlo)
        $writer = new PngWriter();
        $qrCode = new QrCode($qrCodeImg);  // Aceptamos la imagen decodificada (binario)
        $reconstructedImg = $writer->write($qrCode)->getString();

        // Si deseas mostrar el QR directamente como base64, puedes hacer lo siguiente:
        return base64_encode($reconstructedImg);
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
        try {
            // Actualizar los datos del espacio
            $space->update([
                'buildingId' => $data['buildingId'] ?? null,
                'floor' => $data['floor'] ?? null,
                'name' => $data['name'] ?? null,
                'addressDescription' => $data['addressDescription'] ?? null,
                'type' => $data['type'] ?? null,
                'capacity' => $data['capacity'] ?? null,
                'qrCode' => $data['qrCode'] ?? null,
            ]);

            // Generar el código QR después de actualizar
            $this->createQRCode($space);

            // Retornar el objeto actualizado
            return $space;
        } catch (\Exception $e) {
            // Registrar el error y lanzar una excepción
            Log::error('Error en updateSpace: ' . $e->getMessage());
            throw new \Exception('No se pudo actualizar el espacio.');
        }
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
