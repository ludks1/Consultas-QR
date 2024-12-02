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
        $institutions = Institution::all();
        $buildings = Building::all();
        return view('buildingview', compact('buildings', 'institutions'));
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
        // Encuentra el edificio o lanza una excepción si no existe
        $building = Building::findOrFail($id);

        // Valida los datos del request
        $validatedData = $request->validate([
            'name' => 'required|string|unique:buildings,name,' . $id,
            'institutionId' => 'required|integer',
            'address' => 'nullable|string',
            'numberOfFloors' => 'required|integer|min:1', // Agregado para validar el número de pisos
        ]);

        // Actualiza el edificio usando los datos validados
        $building->update($validatedData);

        // Redirige con un mensaje de éxito
        return redirect()->route('building.view', $building->id)->with('success', 'Edificio actualizado exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $building = Building::findOrFail($id);
        $building->delete();

        return redirect()->route('building.view', compact('building'))->with('success', 'Edificio actualizado exitosamente.');
    }

    public function showBuildingForm()
    {
        $institutions = Institution::all(); // Obtén todas las instituciones de la base de datos
        return view('building', compact('institutions'));
    }
}
