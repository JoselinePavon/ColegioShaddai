<?php

namespace App\Http\Controllers;

use App\Models\RegistroAlumno;
use App\Models\Seccion;
use App\Models\Grado;

use App\Models\Inscripcion;
use App\Http\Requests\InscripcionRequest;

/**
 * Class InscripcionController
 * @package App\Http\Controllers
 */
class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las secciones y grados
        $seccion = Seccion::pluck('seccion', 'id');
        $grado = Grado::pluck('nombre_grado', 'id');

        // Obtener los filtros seleccionados por el usuario
        $seccions_id = request()->get('seccions_id');
        $grados_id = request()->get('grados_id');

        // Filtrar las inscripciones en base a la sección y/o grado seleccionados
        $inscripcions = Inscripcion::query();

        if ($seccions_id) {
            $inscripcions->where('seccions_id', $seccions_id);
        }

        if ($grados_id) {
            $inscripcions->where('grados_id', $grados_id);
        }

        $inscripcions = $inscripcions->paginate();

        return view('inscripcion.index', compact('inscripcions', 'seccion', 'grado'))
            ->with('i', (request()->input('page', 1) - 1) * $inscripcions->perPage());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $inscripcion = new Inscripcion();
        $registro_alumno = RegistroAlumno::pluck('nombres', 'id');
        $grado = Grado::pluck('nombre_grado', 'id');
        $seccion = Seccion::pluck('seccion', 'id');
        return view('inscripcion.create', compact('inscripcion', 'registro_alumno','grado','seccion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InscripcionRequest $request)
    {
        Inscripcion::create($request->validated());

        return redirect()->route('inscripcions.index')
            ->with('success', 'Inscripcion created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inscripcion = Inscripcion::find($id);

        return view('inscripcion.show', compact('inscripcion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inscripcion = Inscripcion::find($id);
        $registro_alumno = RegistroAlumno::pluck('nombres', 'id');
        $grado = Grado::pluck('nombre_grado', 'id');
        $seccion = Seccion::pluck('seccion', 'id');

        return view('inscripcion.edit', compact('inscripcion', 'registro_alumno','grado','seccion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InscripcionRequest $request, Inscripcion $inscripcion)
    {
        $inscripcion->update($request->validated());

        return redirect()->route('inscripcions.index')
            ->with('success', 'Inscripcion updated successfully');
    }

    public function destroy($id)
    {
        Inscripcion::find($id)->delete();

        return redirect()->route('inscripcions.index')
            ->with('success', 'Inscripcion deleted successfully');
    }
}
