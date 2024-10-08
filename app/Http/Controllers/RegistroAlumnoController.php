<?php

namespace App\Http\Controllers;

use App\Models\RegistroAlumno;
use App\Http\Requests\RegistroAlumnoRequest;

/**
 * Class RegistroAlumnoController
 * @package App\Http\Controllers
 */
class RegistroAlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registroAlumnos = RegistroAlumno::paginate();

        return view('registro-alumno.index', compact('registroAlumnos'))
            ->with('i', (request()->input('page', 1) - 1) * $registroAlumnos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $registroAlumno = new RegistroAlumno();
        return view('registro-alumno.create', compact('registroAlumno'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistroAlumnoRequest $request)
    {
        RegistroAlumno::create($request->validated());

        return redirect()->route('registro-alumnos.index')
            ->with('success', 'RegistroAlumno created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $registroAlumno = RegistroAlumno::find($id);

        return view('registro-alumno.show', compact('registroAlumno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $registroAlumno = RegistroAlumno::find($id);

        return view('registro-alumno.edit', compact('registroAlumno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegistroAlumnoRequest $request, RegistroAlumno $registroAlumno)
    {
        $registroAlumno->update($request->validated());

        return redirect()->route('registro-alumnos.index')
            ->with('success', 'RegistroAlumno updated successfully');
    }

    public function destroy($id)
    {
        RegistroAlumno::find($id)->delete();

        return redirect()->route('registro-alumnos.index')
            ->with('success', 'RegistroAlumno deleted successfully');
    }
}
