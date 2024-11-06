<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = SubjectController::all();
        return response()->json($subjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
            'description' => 'string',
            'career' => 'required|string',
        ]);

        $subject = SubjectController::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'career' => $request->career,
        ]);

        return response()->json($subject, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = SubjectController::findOrFail($id);
        return response()->json($subject);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subject = SubjectController::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
            'description' => 'string',
            'career' => 'required|string',
        ]);

        $subject->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'career' => $request->career,
        ]);

        return response()->json($subject);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = SubjectController::findOrFail($id);
        $subject->delete();

        return response()->json(null, 204);
    }
}
