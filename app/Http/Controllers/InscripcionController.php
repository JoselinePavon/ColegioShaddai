<?php

namespace App\Http\Controllers;

use App\Models\AnioEscolar;
use App\Models\Encargado;
use App\Models\RegistroAlumno;
use App\Models\Seccion;
use App\Models\Grado;

use App\Models\Inscripcion;
use App\Http\Requests\InscripcionRequest;
use Illuminate\Http\Request;

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
        $encargado = Encargado::paginate();

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

        $totalInscritos = Inscripcion::count();
        $inscripcions = $inscripcions->paginate();

        return view('inscripcion.index', compact('inscripcions', 'seccion', 'grado', 'totalInscritos','encargado'))
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
        $aniosEscolar = AnioEscolar::pluck('nombre', 'id');
        return view('inscripcion.form', compact('inscripcion', 'registro_alumno','grado','seccion','aniosEscolar'));
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
        $aniosEscolar = AnioEscolar::pluck('nombre', 'id');

        return view('inscripcion.edit', compact('inscripcion', 'registro_alumno','grado','seccion', 'aniosEscolar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inscripcion $inscripcion)
    {
        $validated = $request->validate([
            'codigo_correlativo' => 'required|unique:inscripcions,codigo_correlativo,' . $inscripcion->id,
            'grados_id' => 'required|exists:grados,id',
            'seccions_id' => 'required|exists:seccions,id',
            'anio_escolar_id' => 'required|exists:anio_escolars,id',


        ]);

        $inscripcion->update([
            'codigo_correlativo' => $validated['codigo_correlativo'],
            'grados_id' => $validated['grados_id'],
            'seccions_id' => $validated['seccions_id'],
            'anio_escolar_id' => $validated['nombre_id'],

        ]);

        return redirect()->route('inscripcions.index')
            ->with('success', 'Inscripción actualizada correctamente.');
    }


    public function destroy($id)
    {
        Inscripcion::find($id)->delete();

        return redirect()->route('inscripcions.index')
            ->with('success', 'Inscripcion deleted successfully');
    }

    public function buscar()
    {
        return view('inscripcion.form');
    }
    public function resultados(Request $request)
    {
        $inscripcion = new Inscripcion();

        $registro_alumno = RegistroAlumno::pluck('nombres', 'id');
        $grado = Grado::pluck('nombre_grado', 'id');
        $seccion = Seccion::pluck('seccion', 'id');
        $aniosEscolar = AnioEscolar::pluck('nombre', 'id');

        // Recuperar el valor de búsqueda desde la solicitud
        $search = $request->input('search');

        // Realizar la lógica de búsqueda según tus necesidades
        $alumnos = RegistroAlumno::where('id', 'LIKE', "%$search%")
            ->orWhere('nombres', 'LIKE', "%$search%")
            ->get();

        // Pasar el ID del primer alumno encontrado a la vista
        $alumno = $alumnos->first();

        // Verificar si el alumno ya tiene una inscripción
        $yaInscrito = false;
        if ($alumno) {
            $yaInscrito = Inscripcion::where('registro_alumnos_id', $alumno->id)->exists();
        }

        // Pasar los resultados de la búsqueda a la vista resultados.blade.php
        return view('inscripcion.form', compact('inscripcion', 'alumnos', 'registro_alumno', 'grado', 'seccion', 'aniosEscolar','alumno', 'yaInscrito'));
    }


}

