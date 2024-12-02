<?php

namespace App\Http\Controllers;

use App\Enums\Career;
use App\Models\Subject;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $subjects = Subject::all();
        $careers = Career::getOptions();
        return view('subjectview', compact('subjects', 'careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code',
            'description' => 'nullable|string|max:1000',
            'career' => 'required|string|max:255',
            'semester' => 'nullable|integer|min:1|max:10',
        ]);

        // Depuración

        $this->subjectService->addSubject($validatedData);

        return redirect()->route('subject')->with('success', 'Materia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = Subject::findOrFail($id);
        return response()->json($subject);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $code)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
            'career' => 'required|string|max:100',
            'semester' => 'required|integer|min:1|max:12',
        ]);

        // Buscar la materia por código
        $subject = Subject::where('code', $code)->firstOrFail();

        try {
            // Actualizar la materia usando el servicio
            $this->subjectService->updateSubject($subject, $validatedData);

            // Redirigir con éxito
            return redirect()->route('subject.view')->with('success', 'Materia actualizada exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores
            return back()->withErrors(['error' => 'Error al actualizar la materia: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code)
    {
        $subject = Subject::where('code', $code)->firstOrFail(); // Busca por código
        $this->subjectService->deleteSubject($subject); // Usa el servicio para eliminar
        return redirect()->route('subject.view')->with('success', 'Subject eliminado correctamente.');
    }

    public function showSubjectForm(Request $request)
    {
        $careers = Career::getOptions();
        return view('subject', compact('careers'));
    }
}
