<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $event = Event::all();
        return response()->json($event);
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
            'name' => 'required|string',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'startTime' => 'required|time',
            'endTime' => 'required|time',
        ]);

        $event = Event::create([
            'institutionId' => $request->institutionId,
            'buildingId' => $request->buildingId,
            'spaceId' => $request->spaceId,
            'name' => $request->name,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
        ]);

        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'institutionId' => 'required|integer',
            'buildingId' => 'required|integer',
            'spaceId' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'startTime' => 'required|time',
            'endTime' => 'required|time',
        ]);

        $event->update([
            'institutionId' => $request->institutionId,
            'buildingId' => $request->buildingId,
            'spaceId' => $request->spaceId,
            'name' => $request->name,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(null, 204);
    }
}
