<?php

namespace App\Http\Controllers;

use App\Models\Colonia;
use App\Models\Encargado;
use App\Models\Grado;
use App\Models\Inscripcion;
use App\Models\Lugar;
use App\Models\RegistroAlumno;
use App\Http\Requests\RegistroAlumnoRequest;
use App\Models\Seccion;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


/**
 * Class RegistroAlumnoController
 * @package App\Http\Controllers
 */
class RegistroAlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $existingCodes = RegistroAlumno::pluck('codigo_personal')->toArray();
        $existingCorrelativos = Inscripcion::pluck('codigo_correlativo')->toArray();

        $lugares = Lugar::all();
        $colonias = Colonia::all();
        $grado = Grado::pluck('nombre_grado', 'id');
        $seccion = Seccion::pluck('seccion', 'id');

        $ultimosAlumnos = RegistroAlumno::latest()->take(2)->get();
        $ultimasInscripciones = Inscripcion::with('registroAlumno', 'grado', 'seccion')->latest()->take(2)->get();

        return view('registro-alumno.create', compact('existingCorrelativos','ultimosAlumnos', 'ultimasInscripciones','lugares','colonias','grado','seccion','existingCodes'));
    }



    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            // Validación del alumno
            'codigo_personal' => 'nullable|string|unique:registro_alumnos,codigo_personal', // Permitir nulo
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'genero' => 'required|string|in:Masculino,Femenino',
            'edad' => 'required|integer|min:1',
            'fecha_nacimiento' => 'required|date',
            // Validación del encargado
            'nombre_encargado' => 'required|string|max:255',
            'edad_encargado' => 'required|integer|min:1|max:120',
            'estado_civil' => 'required|string|max:255',
            'oficio' => 'required|string|max:255',
            'dpi' => 'required|numeric',
            'lugars_id' => 'required|exists:lugars,id',
            'colonias_id' => 'required|exists:colonias,id',
            'telefono' => 'required|string|max:20',
            'persona_emergencia' => 'required|string|max:255',
            // Validación de la inscripción
            'codigo_correlativo' => 'required|unique:inscripcions,codigo_correlativo',
            'grados_id' => 'required|exists:grados,id',
            'jornada' => 'required|string|in:Matutina,Vespertina',
            'seccions_id' => 'required|exists:seccions,id',
        ]);

        // Crear el registro del encargado
        $encargado = Encargado::create([
            'nombre_encargado' => $request->nombre_encargado,
            'edad_encargado' => $request->edad_encargado,
            'estado_civil' => $request->estado_civil,
            'oficio' => $request->oficio,
            'dpi' => $request->dpi,
            'lugars_id' => $request->lugars_id,
            'colonias_id' => $request->colonias_id,
            'telefono' => $request->telefono,
            'persona_emergencia' => $request->persona_emergencia,
        ]);

        // Crear el registro del alumno
        $alumno = RegistroAlumno::create([
            'codigo_personal' => $request->codigo_personal,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'genero' => $request->genero,
            'edad' => $request->edad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'encargados_id' => $encargado->id, // Asignar automáticamente el ID del encargado
        ]);

        // Crear el registro de inscripción
        Inscripcion::create([
            'registro_alumnos_id' => $alumno->id, // Asignar automáticamente el ID del alumno
            'codigo_correlativo' => $request->codigo_correlativo,
            'grados_id' => $request->grados_id,
            'jornada' => $request->jornada,
            'seccions_id' => $request->seccions_id,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('registro-alumnos.create')
            ->with('success', 'Registro realizado exitosamente.');
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
        $lugares = Lugar::all();
        $colonias = Colonia::all();
        $grado = Grado::pluck('nombre_grado', 'id');
        $seccion = Seccion::pluck('seccion', 'id');
        $encargado = Encargado::pluck('nombre_encargado', 'id');

        return view('registro-alumno.edit', compact('registroAlumno', 'lugares', 'colonias', 'grado', 'seccion', 'encargado'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistroAlumno $registroAlumno)
    {
        // Validación de los campos
        $validated = $request->validate([
            // Campos de registro_alumnos
            'codigo_personal' => 'required|unique:registro_alumnos,codigo_personal,' . $registroAlumno->id,
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'genero' => 'required|string|in:Masculino,Femenino',
            'edad' => 'required|integer|min:1',
            'fecha_nacimiento' => 'required|date',

            // Campos de encargados
            'nombre_encargado' => 'required|string|max:255',
            'edad_encargado' => 'required|integer|min:1|max:120',
            'estado_civil' => 'required|string|max:255',
            'oficio' => 'required|string|max:255',
            'dpi' => 'required|string',
            'lugars_id' => 'required|exists:lugars,id',
            'colonias_id' => 'required|exists:colonias,id',
            'telefono' => 'required|string',
            'persona_emergencia' => 'required|string',
        ]);

        // Actualización en la tabla registro_alumnos
        $registroAlumno->update([
            'codigo_personal' => $validated['codigo_personal'],
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'genero' => $validated['genero'],
            'edad' => $validated['edad'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
        ]);

        // Actualización en la tabla encargados
        $encargado = $registroAlumno->encargado; // Relación con el modelo Encargado
        if ($encargado) {
            $encargado->update([
                'nombre_encargado' => $validated['nombre_encargado'],
                'edad_encargado' => $validated['edad_encargado'],
                'estado_civil' => $validated['estado_civil'],
                'oficio' => $validated['oficio'],
                'dpi' => $validated['dpi'],
                'telefono' => $validated['telefono'],
                'persona_emergencia' => $validated['persona_emergencia'],
                'lugars_id' => $validated['lugars_id'],
                'colonias_id' => $validated['colonias_id'],
            ]);
        }

        // Redirección con mensaje de éxito
        return redirect()->route('registro-alumnos.index')->with('success', 'Registro actualizado correctamente.');
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

    public function validarCodigo(Request $request)
    {
        $codigo = $request->input('codigo');
        $existe = RegistroAlumno::where('codigo_personal', $codigo)->exists();

        return response()->json(['existe' => $existe]);
    }

    public function validarCodigoCorrelativo(Request $request)
    {
        $codigo = $request->input('codigo');
        $existe = Inscripcion::where('codigo_correlativo', $codigo)->exists();

        return response()->json(['existe' => $existe]);
    }

}
