<?php

namespace App\Http\Controllers;

use App\Enums\SpaceType;
use App\Models\Building;
use App\Models\Institution;
use App\Models\Space;
use App\Services\SpaceService;
use Illuminate\Http\Request;

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
    public function index()
    {
        $spaces = Space::all();
        return response()->json($spaces);
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
        $space = Space::findOrFail($id);

        $request->validate([
            'institution_id' => 'required|integer',
            'building_id' => 'required|integer',
            'floor' => 'required|string',
            'name' => 'required|string',
            'addressDescription' => 'required|string',
            'category' => 'required|string',
            'qrCode' => 'required|string|unique:spaces' . $space->qrCode,
        ]);

        $space->update([
            'institution_id' => $request->institution_id,
            'building_id' => $request->building_id,
            'floor' => $request->floor,
            'name' => $request->name,
            'addressDescription' => $request->addressDescription,
            'category' => $request->category,
            'qrCode' => $request->qrCode,
        ]);

        return response()->json($space);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $space = Space::findOrFail($id);
        $space->delete();

        return response()->json(null, 204);
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
}
