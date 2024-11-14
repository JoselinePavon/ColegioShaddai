<?php

namespace App\Http\Controllers;

use App\Models\Colonia;
use App\Models\Encargado;
use App\Models\Lugar;
use App\Models\RegistroAlumno;
use App\Http\Requests\RegistroAlumnoRequest;
use Illuminate\Support\Facades\Log;

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
        $encargado = Encargado::paginate();

        return view('registro-alumno.index', compact('registroAlumnos', 'encargado'))
            ->with('i', (request()->input('page', 1) - 1) * $registroAlumnos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $registroAlumno = new RegistroAlumno();
        $encargado = new Encargado();

        $lugares = Lugar::all();
        $colonias = Colonia::all();
        return view('registro-alumno.create', compact('registroAlumno', 'encargado', 'lugares', 'colonias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistroAlumnoRequest $request)
    {

        $alumno = RegistroAlumno::create($request->validated());

        $encargado = new Encargado([
            'nombre_encargado' => $request->input('nombre_encargado'),
            'dpi' => $request->input('dpi'),
            'telefono' => $request->input('telefono'),
            'persona_emergencia' => $request->input('persona_emergencia'),
            'registro_alumnos_id' => $alumno->id, // Asignación automática
            'lugars_id' => $request->input('lugars_id'), // Lugar seleccionado
            'colonias_id' => $request->input('colonias_id') // Colonia seleccionada
        ]);
        $encargado->save();
        return redirect()->route('registro-alumnos.index')
            ->with('success', 'RegistroAlumno created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $registroAlumno = RegistroAlumno::with('encargado')->find($id);

        if (!$registroAlumno) {
            return redirect()->route('registro-alumnos.index')
                ->with('error', 'Registro de Alumno no encontrado');
        }

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

    public function destroy($id){
        try {
        RegistroAlumno::find($id)->delete();

        return redirect()->route('registro-alumnos.index')
            ->with('success', 'RegistroAlumno deleted successfully');
    }catch (\Exception $exception){
            Log::debug($exception->getMessage());
            return redirect()->route('registro-alumnos.index')->with('alerta','no');
        }
    }
}
