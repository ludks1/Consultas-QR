<?php

namespace App\Http\Controllers;

use App\Enums\SpaceType;
use App\Models\Building;
use App\Models\Institution;
use App\Models\Space;
use App\Services\SpaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SpaceController extends Controller
{

    protected $spaceService;

    public function __construct(SpaceService $spaceService)
    {
        $this->spaceService = $spaceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener todas las instituciones
        $institutions = Institution::all();

        // Obtener todas las opciones de tipos de espacio
        $spaceTypes = SpaceType::getOptions();

        // Filtrar edificios por institución si `institutionId` está presente
        $buildings = [];
        if ($request->filled('institutionId')) {
            $institution = Institution::find($request->institutionId);
            if ($institution) {
                $buildings = $institution->buildings; // Relación debe estar definida
            }
        }

        // Obtener todos los espacios
        $spaces = Space::all();

        // Lista de pisos inicial vacía
        $floors = [];

        // Determinar el rango de pisos si `buildingId` está presente
        if ($request->filled('buildingId')) {
            $building = Building::find($request->buildingId);
            if ($building && $building->numberOfFloors > 0) {
                $floors = range(1, $building->numberOfFloors);
            }
        }

        // Devolver la vista con todos los datos necesarios
        return view('spaceview', compact('institutions', 'buildings', 'spaces', 'floors', 'spaceTypes'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'institutionId' => 'required|exists:institutions,id',
            'buildingId' => 'required|exists:buildings,id',
            'floor' => 'required|integer',
            'type' => 'required|string|max:255',
        ]);

        // Llamar al servicio para guardar el espacio y generar el QR
        $this->spaceService->createSpace($validatedData);

        // Redirigir a la página de éxito o mostrar mensaje
        return redirect()->route('space')->with('success', 'Espacio registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $space = Space::findOrFail($id);
        return response()->json($space);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'institutionId' => 'required|exists:institutions,id',
            'buildingId' => 'required|exists:buildings,id',
            'floor' => 'required|integer',
            'type' => 'required|string|max:255',
            'addressDescription' => 'nullable|string|max:500', // Opcional
        ]);

        try {
            // Buscar el espacio por ID
            $space = Space::findOrFail($id);

            // Llamar al servicio para actualizar el espacio
            $this->spaceService->updateSpace($space, $validatedData);

            // Redirigir con mensaje de éxito
            return redirect()->route('space.view')->with('success', 'Espacio actualizado correctamente.');
        } catch (\Exception $e) {
            // Registrar el error y redirigir con mensaje de error
            Log::error('Error al actualizar espacio: ' . $e->getMessage());
            return back()->with('error', 'Hubo un error al actualizar el espacio. Inténtalo de nuevo.');
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $space = Space::findOrFail($id);
        $space->delete();

        return redirect()->route('space.view', compact('space'))->with('success', 'Espacio eliminado correctamente.');
    }

    public function showSpaceForm(Request $request)
    {
        // Obtener todas las instituciones y edificios
        $institutions = Institution::all();

        $buildings = [];
        $floors = [];

        $spaceTypes = SpaceType::getOptions();
        // Si se ha seleccionado una institución y un edificio, filtrar los edificios y pisos correspondientes
        if ($request->has('institutionId')) {
            $buildings = Building::where('institutionId', $request->institutionId)->get();
        }

        if ($request->has('buildingId')) {
            $building = Building::find($request->buildingId);
            if ($building) {
                $floors = range(1, $building->numberOfFloors);  // Obtener el rango de pisos
            }
        }

        return view('space', compact('institutions', 'buildings', 'floors', 'spaceTypes'));
    }

    public function getBuildings($institutionId)
    {
        // Verificar si la institución existe
        $buildings = Building::where('institutionId', $institutionId)->get();

        return response()->json([
            'buildings' => $buildings
        ]);
    }

    public function getFloors($buildingId)
    {
        $building = Building::find($buildingId);

        // Si el edificio existe y tiene pisos
        if ($building) {
            $floors = range(1, $building->numberOfFloors); // Asumiendo que `numberOfFloors` es el número de pisos
            return response()->json([
                'floors' => $floors
            ]);
        }

        return response()->json([
            'floors' => []
        ], 404);
    }

    public function getSpaces($buildingId)
    {
        $spaces = Space::where('buildingId', $buildingId)->get();

        return response()->json([
            'spaces' => $spaces
        ]);
    }

    public function showSpace($id)
    {
        // Obtener el espacio por ID
        $space = Space::findOrFail($id);

        // Llamar al método para reconstruir el QR
        $qrCodeBase64 = $this->spaceService->reconstructQRCode($space->id);

        // Pasar el espacio y el QR a la vista
        return view('space.view', compact('space', 'qrCodeBase64'));
    }
}
