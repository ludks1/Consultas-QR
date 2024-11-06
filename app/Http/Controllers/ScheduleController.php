<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = ScheduleController::all();
        return response()->json($schedules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'institutionId' => 'required|integer',
            'buildingId' => 'required|integer',
            'spaceId' => 'required|integer',
            'subjectId' => 'required|integer',
            'day' => 'required|string',
            'startIime' => 'required|string',
            'endIime' => 'required|string',
        ]);

        $schedule = ScheduleController::create([
            'institutionId' => $request->institutionId,
            'buildingId' => $request->buildingId,
            'spaceId' => $request->spaceId,
            'subjectId' => $request->subjectId,
            'day' => $request->day,
            'startIime' => $request->startIime,
            'endIime' => $request->endIime,
        ]);

        return response()->json($schedule, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = ScheduleController::findOrFail($id);
        return response()->json($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = ScheduleController::findOrFail($id);

        $request->validate([
            'institutionId' => 'required|integer',
            'buildingId' => 'required|integer',
            'spaceId' => 'required|integer',
            'subjectId' => 'required|integer',
            'day' => 'required|string',
            'startIime' => 'required|string',
            'endIime' => 'required|string',
        ]);

        $schedule->update([
            'institutionId' => $request->institutionId,
            'buildingId' => $request->buildingId,
            'spaceId' => $request->spaceId,
            'subjectId' => $request->subjectId,
            'day' => $request->day,
            'startIime' => $request->startIime,
            'endIime' => $request->endIime,
        ]);

        return response()->json($schedule);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = ScheduleController::findOrFail($id);
        $schedule->delete();

        return response()->json(null, 204);
    }
}
