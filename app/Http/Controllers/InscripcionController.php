<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Inscripcion;
use App\Http\Requests\InscripcionRequest;
use App\Models\Seccion;


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
        $inscripcions = Inscripcion::paginate();
        $grado = Grado::pluck('nombre_grado', 'id');
        $seccion = Seccion::pluck('seccion', 'id');

        return view('inscripcion.index', compact('inscripcions', 'grado','seccion'))
            ->with('i', (request()->input('page', 1) - 1) * $inscripcions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inscripcion = new Inscripcion();
        $grados = Grado::pluck('nombre_grado', 'id');
        $seccions = Seccion::pluck('seccion', 'id');
        return view('inscripcion.create', compact('inscripcion', 'grados','seccions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InscripcionRequest $request)
    {
        $inscripcion = Inscripcion::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'genero' => $request->genero,
            'edad' => $request->edad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'grados_id' => $request->grados_id,
            'seccions_id' => $request->seccions_id,
        ]);

        return redirect()->route('inscripcions.index')
            ->with('success', 'Inscripción creada exitosamente.');
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

        return view('inscripcion.edit', compact('inscripcion'));
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
