<?php

namespace App\Http\Controllers;

use App\Enums\Career;
use App\Enums\Days;
use App\Models\Building;
use App\Models\Institution;
use App\Models\Schedule;
use App\Models\Space;
use App\Models\Subject;
use App\Services\ScheduleService;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

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
        $institutions = Institution::all();
        $buildings = Building::all();
        $spaces = Space::all();

        return view('scheduleview', compact('schedules', 'institutions', 'buildings', 'spaces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'startIime' => 'required|date_format:H:i',
            'endIime' => 'required|date_format:H:i|after:startIime',
            'day' => 'required|string',
            'subjectId' => 'required|string|max:255',
            'spaceId' => 'required|exists:spaces,id',
        ]);

        $data = $request->all();
        $data['day'] = $data['day'];  // Mapeamos 'day' a 'day'

        // Llamar al servicio para registrar el horario
        try {
            $result = $this->scheduleService->storeSchedule($validated);

            // Verificamos si el resultado es true o un mensaje de error
            if ($result === true) {
                return redirect()->route('schedule')->with('success', 'Edificio creado exitosamente.');
            } else {
                return response()->json(['success' => false, 'message' => $result]); // Enviamos el mensaje de error
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al registrar el horario. ' . $e->getMessage()]);
        }
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
    public function destroy(Request $request, string $id)
    {
        try {
            // Obtener el horario por su ID
            $schedule = Schedule::findOrFail($id);

            // Llamar al servicio para eliminar el horario
            $this->scheduleService->deleteSchedule($request->user(), $schedule);

            return redirect()->route('schedule.view')->with('success', 'Horario eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('schedule.view')->with('error', 'Error al eliminar el horario: ' . $e->getMessage());
        }
    }

    // se necesita mandar la materia para crear el horario en la bdd
    public function showScheduleForm(Request $request)
    {
        $institutions = Institution::all();
        $buildings = [];
        $spaces = [];
        $subjects = Subject::all();
        $days = Days::getOptions();

        if ($request->has('institutionId')) {
            $buildings = Building::where('institutionId', $request->institutionId)->get();
        }
        if ($request->has('buildingId')) {
            $buildings = Building::where('buildingId', $request->buildingId)->get();
        }
        if ($request->has('spaceId')) {
            $spaces = Building::where('spaceId', $request->spaceId)->get();
        }
        if ($request->has('subjectId')) {
            $subjects = Subject::where('code', $request->code)->get();
        }
        return view('schedule', compact('institutions', 'buildings', 'spaces', 'subjects', 'days'));
    }

    public function getBuildings($institutionId)
    {
        // Verificar si la institución existe
        $buildings = Building::where('institutionId', $institutionId)->get();

        return response()->json([
            'buildings' => $buildings
        ]);
    }

    public function getSpaces($spaceId)
    {
        $spaces = Space::where('buildingId', $spaceId)->get();
        return response()->json([
            'spaces' => $spaces
        ]);
    }
}
