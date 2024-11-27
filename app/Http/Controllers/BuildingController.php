<?php

namespace App\Http\Controllers;

use App\Services\BuildingService;
use App\Models\Building;
use App\Models\Institution;
use Illuminate\Http\Request;

class BuildingController extends Controller
{

    protected $buildingService;

    public function __construct(BuildingService $buildingService)
    {
        $this->buildingService = $buildingService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buildings = Building::all();
        return response()->json($buildings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:buildings',
            'address' => 'required|string',
            'numberOfFloors' => 'required|integer',
            'institutionId' => 'required|exists:institutions,id',
        ]);

        $data = $request->all();

        try {
            $this->buildingService->createBuilding($data);
            return redirect()->route('building')->with('success', 'Edificio creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al crear el edificio: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $building = Building::findOrFail($id);
        return response()->json($building);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $building = Building::findOrFail($id);
        $request->validate([
            'institutionId' => 'required|integer',
            'name' => 'required|string',
            'address' => 'optional|string',
        ]);

        $building = Building::create([
            'institutionId' => $request->institutionId,
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return response()->json($building);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $building = Building::findOrFail($id);
        $building->delete();

        return response()->json(null, 204);
    }

    public function showBuildingForm()
    {
        $institutions = Institution::all(); // Obtén todas las instituciones de la base de datos
        return view('building', compact('institutions'));
    }
}
