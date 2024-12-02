<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Services\InstitutionService;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{

    protected $institutionService;

    public function __construct(InstitutionService $institutionService)
    {
        $this->institutionService = $institutionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $institutions = Institution::all();
        return view('institutionview', compact('institutions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {;
        $request->validate([
            'name' => 'required|string|unique:institutions',
            'address' => 'required|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'phone' => 'required|string',
            'email' => 'required|string|email',
        ]);

        $data = $request->all();

        $this->institutionService->createInstitution($data);

        return redirect()->route('institution');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $institution = Institution::findOrFail($id);
        return response()->json($institution);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $institution = Institution::where('id', $id)->firstOrFail();

        // Validar entrada
        $request->validate([
            'name' => 'required|string|unique:institutions,name,' . $institution->id,
            'address' => 'required|string',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Logo opcional y validación del archivo
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        // Preparar datos
        $data = $request->only(['name', 'address', 'phone', 'email']);
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        try {
            // Actualizar institución mediante el servicio
            $this->institutionService->updateInstitutions($institution, $data);

            return redirect()->route('institution.view')
                ->with('success', 'Institución actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar la institución: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $institution = Institution::where('id', $id)->firstOrFail();

        try {
            $this->institutionService->deleteInstitution($institution);
            return redirect()->route('institution.view')
                ->with('success', 'Institución eliminada exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar la institución: ' . $e->getMessage()]);
        }
    }

    public function showInstitutionForm()
    {
        return view('institution');
    }
}
