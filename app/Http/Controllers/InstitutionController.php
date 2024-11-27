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
        return response()->json($institutions);
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
        $institution = Institution::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:institutions,name,' . $institution->id,
            'address' => 'required|string',
            'logo' => 'required|string',
        ]);

        $institution->update([
            'name' => $request->name,
            'address' => $request->address,
            'logo' => $request->logo,
        ]);

        return response()->json($institution);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $institution = Institution::findOrFail($id);
        $institution->delete();

        return response()->json(null, 204);
    }

    public function showInstitutionForm()
    {
        return view('institution');
    }
}
