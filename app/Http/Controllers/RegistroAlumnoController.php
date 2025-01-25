<?php

namespace App\Http\Controllers;

use App\Models\Colonia;
use App\Models\Encargado;
use App\Models\Grado;
use App\Models\Inscripcion;
use App\Models\Lugar;
use App\Models\Nivel;
use App\Models\RegistroAlumno;
use App\Http\Requests\RegistroAlumnoRequest;
use App\Models\Seccion;
use Carbon\Carbon;
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
        $seccion = Seccion::pluck('seccion', 'id');
        $grado = Grado::with('nivel')->get()->mapWithKeys(function ($grado) {
            return [$grado->id => "{$grado->nombre_grado} - {$grado->nivel->nivel}"];
        });

        // Obtener los filtros seleccionados por el usuario
        $seccions_id = request()->get('seccions_id');
        $grados_id = request()->get('grados_id');

        // Construir la consulta base
        $registroAlumnos = RegistroAlumno::with(['encargado', 'inscripcion.grado', 'inscripcion.seccion'])
            ->whereHas('inscripcion', function ($query) use ($seccions_id, $grados_id) {
                if ($seccions_id) {
                    $query->where('seccions_id', $seccions_id);
                }
                if ($grados_id) {
                    $query->where('grados_id', $grados_id);
                }
            })
            ->orderBy('created_at','desc')
            ->get()
            ->map(function ($alumno) {
                $alumno->fecha_nacimiento = Carbon::parse($alumno->fecha_nacimiento)->format('m-d-Y');
                return $alumno;
            });

        // Paginación

        return view('registro-alumno.index', compact('registroAlumnos', 'grado', 'seccion'));
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
        $seccion = Seccion::pluck('seccion', 'id');
        $grado = Grado::with('nivel')->get()->mapWithKeys(function ($grado) {
            return [$grado->id => "{$grado->nombre_grado} - {$grado->nivel->nivel}"];
        });

        $nivel = Nivel::pluck('nivel', 'id');

        $ultimosAlumnos = RegistroAlumno::latest()->take(2)->get();
        $ultimasInscripciones = Inscripcion::with('registroAlumno', 'grado', 'seccion')->latest()->take(2)->get();

        return view('registro-alumno.create', compact('nivel','existingCorrelativos','ultimosAlumnos', 'ultimasInscripciones','lugares','colonias','grado','seccion','existingCodes'));
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
            'parentesco' => 'required|string|max:255',
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

        // Buscar o crear el encargado
        $encargadoId = $request->input('encargados_id');
        if (!$encargadoId) {
            $encargado = Encargado::create([
                'nombre_encargado' => $request->nombre_encargado,
                'edad_encargado' => $request->edad_encargado,
                'estado_civil' => $request->estado_civil,
                'oficio' => $request->oficio,
                'dpi' => $request->dpi,
                'parentesco' => $request->parentesco,
                'lugars_id' => $request->lugars_id,
                'colonias_id' => $request->colonias_id,
                'telefono' => $request->telefono,
                'persona_emergencia' => $request->persona_emergencia,
            ]);
            $encargadoId = $encargado->id;
        }

        // Crear el registro del alumno
        $alumno = RegistroAlumno::create([
            'codigo_personal' => $request->codigo_personal,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'genero' => $request->genero,
            'edad' => $request->edad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'encargados_id' => $encargadoId, // Asignar el ID del encargado
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
        $registroAlumno = RegistroAlumno::with(['encargado', 'inscripcion.grado', 'inscripcion.seccion'])->findOrFail($id);
        $grado = Grado::with('nivel')->get()->mapWithKeys(function ($grado) {
            return [$grado->id => "{$grado->nombre_grado} - {$grado->nivel->nivel}"];
        });
        $lugares = Lugar::all();
        $colonias = Colonia::all();
        $seccion = Seccion::pluck('seccion', 'id');
        $encargado = $registroAlumno->encargado;
        $inscripcion = $registroAlumno->inscripcion;

        return view('registro-alumno.edit', compact('registroAlumno', 'lugares', 'colonias', 'grado', 'seccion', 'encargado', 'inscripcion'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistroAlumno $registroAlumno)
    {
        // Validar los datos
        $validated = $request->validate([
            // Alumno
            'codigo_personal' => 'nullable|unique:registro_alumnos,codigo_personal,' . $registroAlumno->id,
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'genero' => 'required|in:Masculino,Femenino',
            'edad' => 'required|integer|min:1',
            'fecha_nacimiento' => 'required|date',

            // Encargado
            'nombre_encargado' => 'required|string|max:255',
            'edad_encargado' => 'required|integer|min:1|max:120',
            'estado_civil' => 'required|string',
            'oficio' => 'required|string|max:255',
            'dpi' => 'required|string',
            'lugars_id' => 'required|exists:lugars,id',
            'colonias_id' => 'required|exists:colonias,id',
            'telefono' => 'required|string',
            'persona_emergencia' => 'required|string',
            'parentesco' => 'required|string',

            // Inscripción
            'codigo_correlativo' => 'required|unique:inscripcions,codigo_correlativo,' . $registroAlumno->inscripcion->id,
            'grados_id' => 'required|exists:grados,id',
            'seccions_id' => 'required|exists:seccions,id',
            'jornada' => 'required|string',
        ]);

        // Actualizar alumno
        $registroAlumno->update([
            'codigo_personal' => $validated['codigo_personal'],
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'genero' => $validated['genero'],
            'edad' => $validated['edad'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
        ]);

        // Actualizar encargado
        $encargado = $registroAlumno->encargado;
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
                'parentesco' => $validated['parentesco'],
            ]);
        }

        // Actualizar inscripción
        $inscripcion = $registroAlumno->inscripcion;
        if ($inscripcion) {
            $inscripcion->update([
                'codigo_correlativo' => $validated['codigo_correlativo'],
                'grados_id' => $validated['grados_id'],
                'seccions_id' => $validated['seccions_id'],
                'jornada' => $validated['jornada'],
            ]);
        }

        return redirect()->route('registro-alumnos.index')->with('success', 'Registro actualizado correctamente.');
    }




    public function destroy($id)
    {
        try {
            // Obtener el registro del alumno
            $registroAlumno = RegistroAlumno::findOrFail($id);

            // Obtener al encargado asociado al alumno
            $encargado = $registroAlumno->encargado;

            // Verificar cuántos alumnos tiene asignados el encargado
            $alumnosRelacionados = RegistroAlumno::where('encargados_id', $encargado->id)->count();

            // Eliminar el alumno
            $registroAlumno->delete();

            // Variable para el mensaje
            $mensaje = 'El alumno fue eliminado.';

            // Si el encargado no tiene otros alumnos asignados, eliminarlo
            if ($alumnosRelacionados <= 1 && $encargado) {
                $encargado->delete();
                $mensaje = 'El alumno y el encargado fueron eliminados exitosamente.';
            }

            return redirect()->route('registro-alumnos.index')
                ->with('success', $mensaje);
        } catch (\Exception $exception) {
            // Manejar errores y registrar en el log
            Log::debug($exception->getMessage());
            return redirect()->route('registro-alumnos.index')->with('alerta', 'no');
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


    public function buscarEncargado(Request $request)
    {
        $query = $request->input('query');
        $encargado = Encargado::where('dpi', 'LIKE', '%' . $query . '%')
            ->orWhere('nombre_encargado', 'LIKE', '%' . $query . '%')
            ->first();

        if ($encargado) {
            return response()->json([
                'found' => true,
                'encargado' => [
                    'id' => $encargado->id,
                    'nombre_encargado' => $encargado->nombre_encargado,
                    'edad_encargado' => $encargado->edad_encargado,
                    'dpi' => $encargado->dpi,
                    'oficio' => $encargado->oficio,
                    'parentesco' => $encargado->parentesco,
                    'estado_civil' => $encargado->estado_civil === 'Casado' ? 'Casado(a)' : ($encargado->estado_civil === 'Soltero' ? 'Soltero(a)' : $encargado->estado_civil),
                    'lugars_id' => $encargado->lugars_id,
                    'colonias_id' => $encargado->colonias_id,
                    'telefono' => $encargado->telefono,
                    'persona_emergencia' => $encargado->persona_emergencia,
                ]
            ]);
        }

        return response()->json(['found' => false]);
    }


}
