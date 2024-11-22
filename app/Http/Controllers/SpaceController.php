<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
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
        $request->validate([
            'institution_id' => 'required|integer',
            'building_id' => 'required|integer',
            'floor' => 'required|string',
            'name' => 'required|string',
            'addressDescription' => 'required|string',
            'category' => 'required|string',
            'qrCode' => 'required|string|unique:spaces',
        ]);

        $space = Space::create([
            'institution_id' => $request->institution_id,
            'building_id' => $request->building_id,
            'floor' => $request->floor,
            'name' => $request->name,
            'addressDescription' => $request->addressDescription,
            'category' => $request->category,
            'qrCode' => $request->qrCode,
        ]);

        return response()->json($space, 201);
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
            'qrCode' => 'required|string|unique:spaces'.$space->qrCode,
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
}
