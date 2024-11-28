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
    public function update(Request $request, string $id)
    {
        $subject = Subject::findOrFail($id);

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
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return response()->json(null, 204);
    }

    public function showSubjectForm(Request $request)
    {
        $careers = Career::getOptions();
        return view('subject', compact('careers'));
    }
}
