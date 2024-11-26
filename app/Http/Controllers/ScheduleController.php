<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Schedule::query();

        if ($request->filled('start_time')) {
            $query->where('start_time', '>=', $request->start_time);
        }

        if ($request->filled('end_time')) {
            $query->where('end_time', '<=', $request->end_time);
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('subject')) {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }

        if ($request->filled('room')) {
            $query->where('room', 'like', '%' . $request->room . '%');
        }

        // Obtener los horarios filtrados
        $schedules = $query->get();

        return view('schedule', compact('schedules'));
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

        $schedule = Schedule::create([
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
        $schedule = Schedule::findOrFail($id);
        return response()->json($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);

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
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json(null, 204);
    }
}
