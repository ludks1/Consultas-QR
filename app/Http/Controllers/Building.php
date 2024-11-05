<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Building extends Controller
{
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
            'institutionId' => 'required|integer',
            'name' => 'required|string',
            'address' => 'optional|string',
        ]);

        $building = Building::create([
            'institutionId' => $request->institutionId,
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return response()->json($building, 201);
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
}
