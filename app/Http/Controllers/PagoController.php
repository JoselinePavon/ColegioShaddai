<?php

namespace App\Http\Controllers;

use App\Models\Me;
use App\Models\Pago;
use App\Models\Grado;
use App\Models\RegistroAlumno;
use App\Models\Tipopago;
use App\Models\estado;
use App\Models\Inscripcion;
use App\Models\AnioEscolar;
use App\Models\Seccion;
use App\Http\Requests\PagoRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


/**
 * Class PagoController
 * @package App\Http\Controllers
 */
class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Guardar filtros en sesión si se proporcionan en la solicitud
        if ($request->has('grados_id')) {
            session(['filtro_grados_id' => $request->get('grados_id')]);
        }
        if ($request->has('seccions_id')) {
            session(['filtro_seccions_id' => $request->get('seccions_id')]);
        }
        if ($request->has('estado')) {
            session(['filtro_estado' => $request->get('estado')]);
        }
        if ($request->has('anio_escolar_id')) {
            session(['filtro_anio_escolar_id' => $request->get('anio_escolar_id')]);
        }

        // Recuperar filtros de la sesión si no se proporcionan en la solicitud
        $grados_id = $request->get('grados_id', session('filtro_grados_id'));
        $seccions_id = $request->get('seccions_id', session('filtro_seccions_id'));
        $estado = $request->get('estado', session('filtro_estado'));
        $anioEscolarId = $request->get('anio_escolar_id', session('filtro_anio_escolar_id'));

        $mesActual = Carbon::now()->month;
        $añoActual = Carbon::now()->year;
        $mesLimite = 10;

        Log::debug("======= INICIO DE PROCESAMIENTO DE SOLVENCIA =======");
        Log::debug("Mes actual: $mesActual, Año: $añoActual");

        $query = Pago::with([
            'registroAlumno.inscripcion.grado.nivel',
            'registroAlumno.inscripcion.seccion',
            'estado',
            'mes',
            'tipopago'
        ]);

        // Aplicar filtro por año escolar si se ha proporcionado
        if ($anioEscolarId) {
            $query->whereHas('registroAlumno.inscripcion', function ($q) use ($anioEscolarId) {
                $q->where('anio_escolar_id', $anioEscolarId);
            });
        }

        // Filtrar por grados_id si se ha proporcionado
        if ($grados_id) {
            $query->whereHas('registroAlumno.inscripcion.grado', function ($q) use ($grados_id) {
                $q->where('id', $grados_id);
            });
        }

        // Filtrar por seccions_id si se ha proporcionado
        if ($seccions_id) {
            $query->whereHas('registroAlumno.inscripcion.seccion', function ($q) use ($seccions_id) {
                $q->where('id', $seccions_id);
            });
        }

        $query->orderBy('created_at', 'desc');

        // Obtener los pagos filtrados
        $pagos = $query->get();
        Log::debug("Total de pagos encontrados: " . $pagos->count());

        // Agrupar los pagos por alumno
        $alumnos = $pagos->groupBy('registro_alumnos_id')->map(function ($pagosAlumno) use ($mesActual, $mesLimite, $añoActual) {
            // Obtener el nombre del alumno y el ID
            $alumnoNombre = $pagosAlumno->first()->registroAlumno->nombres ?? 'Desconocido';
            $alumnoId = $pagosAlumno->first()->registro_alumnos_id ?? 'Desconocido';
            Log::debug("======= PROCESANDO ALUMNO: $alumnoNombre (ID: $alumnoId) =======");

            // Obtener el nivel del alumno
            $nivelId = $pagosAlumno->first()->registroAlumno->inscripcion->grado->nivel->id ?? null;
            $tiposPagoPorNivel = [];

            switch ($nivelId) {
                case 1: case 2:
                $tiposPagoPorNivel = [2]; break;
                case 3:
                    $tiposPagoPorNivel = [3]; break;
                case 4:
                    $tiposPagoPorNivel = [4]; break;
                default:
                    $tiposPagoPorNivel = [2, 3, 4];
            }

            Log::debug("Nivel: $nivelId, Tipos de pago: " . implode(', ', $tiposPagoPorNivel));

            $pagosFiltrados = $pagosAlumno->whereIn('tipopagos_id', $tiposPagoPorNivel);
            Log::debug("Total de pagos filtrados por tipo: " . $pagosFiltrados->count());

            $pagosPorMes = [];

            foreach ($pagosFiltrados as $pago) {
                $mesPago = $pago->mes_id;

                if (!isset($pagosPorMes[$mesPago])) {
                    $pagosPorMes[$mesPago] = [
                        'total_abonado' => 0,
                        'monto_esperado' => $pago->tipopago->monto ?? 0,
                        'pagos' => []
                    ];
                }

                $pagosPorMes[$mesPago]['pagos'][] = $pago;

                $montoActual = 0;

                if (isset($pago->abono) && $pago->abono > 0) {
                    $montoActual = $pago->abono;
                    Log::debug("Sumando abono de $montoActual para el mes $mesPago");
                } else if ($pago->estados_id == 1 || $pago->estados_id == 3) {
                    $montoActual = $pago->tipopago->monto ?? 0;
                    Log::debug("Sumando monto completo de $montoActual para el mes $mesPago (estado: {$pago->estados_id})");
                }

                $pagosPorMes[$mesPago]['total_abonado'] += $montoActual;
            }

            // Determinar los meses pagados
            $mesesPagados = [];

            foreach ($pagosPorMes as $mes => $datosPago) {
                $totalAbonado = $datosPago['total_abonado'];
                $montoEsperado = $datosPago['monto_esperado'];

                if ($totalAbonado >= $montoEsperado) {
                    $mesesPagados[] = $mes;
                }
            }

            sort($mesesPagados);

            $esSolvente = false;

            if ($mesActual == 1) {
                $esSolvente = in_array(1, $mesesPagados);
            } else if ($mesActual >= 2 && $mesActual <= 10) {
                $mesesRequeridos = range(1, $mesActual - 1);
                $mesesFaltantes = array_diff($mesesRequeridos, $mesesPagados);
                $esSolvente = empty($mesesFaltantes);
            } else if ($mesActual == 11 || $mesActual == 12) {
                $mesesCompletos = range(1, 10);
                $mesesFaltantes = array_diff($mesesCompletos, $mesesPagados);
                $esSolvente = empty($mesesFaltantes);
            }

            return [
                'registroAlumno' => $pagosAlumno->first()->registroAlumno,
                'mesesPagados' => $mesesPagados,
                'esSolvente' => $esSolvente,
            ];
        });

        // Filtrar alumnos por estado si se proporciona
        if ($estado) {
            $alumnos = $alumnos->filter(function ($alumno) use ($estado) {
                return ($estado === 'solvente') ? $alumno['esSolvente'] : !$alumno['esSolvente'];
            });
        }

        // Obtener los grados, secciones y años escolares para la vista
        $grado = \App\Models\Grado::pluck('nombre_grado', 'id');
        $seccion = \App\Models\Seccion::pluck('seccion', 'id');
        $aniosEscolares = \App\Models\AnioEscolar::pluck('nombre', 'id');

        return view('pago.index', compact(
            'pagos',
            'grado',
            'seccion',
            'alumnos',
            'mesActual',
            'aniosEscolares',
            'grados_id',      // Pasar los valores de filtro a la vista
            'seccions_id',
            'estado',
            'anioEscolarId'
        ))->with('i', 0);
    }



    public function show(Request $request, $registro_alumnos_id) {
        // Obtener el año del request (si fue seleccionado en el filtro)
        $anio = $request->input('anio');

        // Primero obtener el registro del alumno independientemente de los pagos
        $registroAlumno = \App\Models\RegistroAlumno::findOrFail($registro_alumnos_id);

        // Obtener todos los pagos realizados por el alumno
        $pagos = Pago::where('registro_alumnos_id', $registro_alumnos_id)
            ->with(['registroAlumno.inscripcion', 'tipopago', 'mes', 'estado'])
            ->when($anio, function ($query) use ($anio) {
                // Filtrar por año de la fecha de pago si se seleccionó un año
                return $query->whereYear('fecha_pago', $anio);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Calcular el total de pagos (será 0 si no hay pagos)
        $totalPagos = $pagos->sum(function ($pago) {
            if (in_array($pago->tipopagos_id, [5, 6])) { // Computación
                return $pago->abono ?? 0;
            }
            return $pago->tipopago->monto ?? 0;
        });

        // Obtener los valores de filtro de la sesión para construir la URL de regreso
        $filtro_grados_id = session('filtro_grados_id');
        $filtro_seccions_id = session('filtro_seccions_id');
        $filtro_estado = session('filtro_estado');
        $filtro_anio_escolar_id = session('filtro_anio_escolar_id');

        // Retornar la vista con todas las variables necesarias
        return view('pago.show', compact(
            'pagos',
            'totalPagos',
            'anio',
            'registroAlumno',
            'registro_alumnos_id',
            'filtro_grados_id',
            'filtro_seccions_id',
            'filtro_estado',
            'filtro_anio_escolar_id'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aniosEscolares = AnioEscolar::orderBy('nombre', 'desc')->get();
        $pago = new Pago();
        $tipos = Tipopago::pluck('tipo_pago', 'id');
        $mes = Me::whereBetween('id', [1, 10])->pluck('mes', 'id'); // Filtrar meses entre enero y octubre
        $registro_alumnos = RegistroAlumno::pluck('nombres', 'id');
        $montos = Tipopago::pluck('monto', 'id');
        $alumnoId = request()->input('registro_alumnos_id'); // Captura el ID del alumno si es enviado en la solicitud

        $inscripcionPagada = false;


        if ($alumnoId) {
            $inscripcionPagada = Pago::where('registro_alumnos_id', $alumno->id ?? null)
                ->where('tipopagos_id', 1) // ID 1 es Inscripción
                ->exists();

            // Si inscripción ya fue pagada, exclúyela de los tipos de pago
            if ($inscripcionPagada) {
                $tipos = $tipos->except(1); // Excluir inscripción del listado
            }
        }
        // Obtener los pagos realizados para todos los alumnos
        $pagosPorMes = [];

        if ($alumno = RegistroAlumno::first()) { // Aquí debes ajustar la lógica para obtener el alumno correcto
            $pagosPorMes = Pago::where('registro_alumnos_id', $alumno->id)
                ->select('mes_id', 'tipopagos_id')
                ->get()
                ->toArray();
        }

        return view('pago.form', compact('aniosEscolares','pago', 'montos', 'tipos', 'registro_alumnos', 'mes', 'pagosPorMes','inscripcionPagada'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(PagoRequest $request){

        // Validación de los campos
        $request->validate([
            'anio_escolar_id' => 'required|exists:anios_escolares,id',
            'num_serie' => 'required',
            'registro_alumnos_id' => 'required',
            'tipopagos_id' => 'nullable', // Puede ser nulo si es pago combinado
            'fecha_pago' => 'required|date',
            'mes_id' => $request->input('tipopagos_id') == 6 ? 'nullable|exists:mes,id' : 'required|exists:mes,id',
            'pagos_combinados' => 'nullable|array', // Aceptar array de pagos combinados
            'pagos_combinados.*' => 'exists:tipopagos,id', // Validar que los IDs existan en la BD
        ], [
            'num_serie.unique' => 'El número de boleta ya está en uso.',
            'num_serie.required' => 'El número de boleta es obligatorio.',
            'mes_id.required_unless' => 'El mes es obligatorio para este tipo de pago.',
            'pagos_combinados.required' => 'Debe seleccionar al menos un tipo de pago en Pago Combinado.',
        ]);

        $data = $request->all();
        $montoOriginal = Tipopago::find($data['tipopagos_id'])->monto ?? 0;

        // Limitar el monto de computación
        if ($data['tipopagos_id'] == 6) {
            // Primero verifica que el monto individual no exceda los 500 quetzales
            if ((float)$data['abono'] > 500) {  // Nota: Uso 'abono' en lugar de 'monto' según tu código anterior
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'El pago de computación no puede exceder los 500 quetzales.');
            }

            // Obtener el total de pagos de computación ya realizados por el alumno
            $totalComputacion = Pago::where('registro_alumnos_id', $data['registro_alumnos_id'])
                ->where('tipopagos_id', 6)
                ->sum('abono');  // Suma el campo 'abono' de todos los pagos de computación

            // Verificar si el nuevo pago más el total acumulado excede los 500 quetzales
            if ($totalComputacion + (float)$data['abono'] > 500) {
                $montoDisponible = 500 - $totalComputacion;

                return redirect()->back()
                    ->withInput()
                    ->with('error', "El total de pagos de computación no puede exceder los 500 quetzales.
                            Total actual: Q." . number_format($totalComputacion, 2) . ".
                            Monto disponible: Q." . number_format($montoDisponible, 2) . ".");
            }
        }

        // Obtén el monto desde la tabla `tipopagos`
        $montoOriginal = Tipopago::find($data['tipopagos_id'])->monto ?? 0;

        // Verifica si el pago es de computación (tipopagos_id 6)
        if ($data['tipopagos_id'] == 6) {
            // Si el monto es mayor a 500, muestra la alerta
            if ((float)$data['monto'] > 500) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'El pago de computación no puede exceder los 500 quetzales.');
            }
        }

        if (in_array($data['tipopagos_id'], [5, 6])) {
            // Validar que el campo "abono" tenga un valor
            if (empty($data['abono'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Debe ingresar un abono para el pago de Computación.');
            }
            $data['estados_id'] = 3; // Estado para computación

        }

        // Si se selecciona "combinado" pero no se seleccionan pagos en pagos_combinados
        if ($request->input('tipopagos_id') === 'combinado') {
            if (empty($data['pagos_combinados']) || !is_array($data['pagos_combinados'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Debe seleccionar al menos un tipo de pago en Pago Combinado.');
            }

            foreach ($data['pagos_combinados'] as $tipopagos_id) {
                // Excluir inscripción (ID 2) de pagos combinados
                $mesId = ($tipopagos_id == 1) ? 13 : $data['mes_id'];
            if ($tipopagos_id == [5, 6]) {
                    continue;
                }

                // Determinar el estado del pago
                $estado_id = in_array($tipopagos_id, [2, 3, 4]) ? 1 : 3; // 1 = solvente para colegiatura, 3 = cancelado para otros

                // Crear el pago combinado con el mes seleccionado
                Pago::create([
                    'anio_escolar_id' => $request->anio_escolar_id,
                    'num_serie' => $data['num_serie'],
                    'registro_alumnos_id' => $data['registro_alumnos_id'],
                    'tipopagos_id' => $tipopagos_id,
                    'fecha_pago' => $data['fecha_pago'],
                    'mes_id' => $mesId, // Tomar el mes seleccionado en el formulario
                    'estados_id' => $estado_id,
                ]);
            }

            // Redirigir con mensaje de éxito
            return redirect()->route('pagos.index')
                ->with('success', 'Pago combinado registrado exitosamente.');
        }

        // Manejar el caso de pagos individuales
        if ($data['tipopagos_id'] == 1) {

            // Verificar si ya existe un pago de inscripción
            $pagoInscripcion = Pago::where('registro_alumnos_id', $data['registro_alumnos_id'])
                ->where('tipopagos_id', 1)
                ->first();

            if ($pagoInscripcion) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'El alumno ya ha realizado el pago de inscripción.');
            }
            $data['mes_id'] = 13; // Asignar el valor 13 para inscripción
            $data['estados_id'] = 3; // Estado solvente

        }
        if (in_array($data['tipopagos_id'], [2, 3, 4])) {

            if ((float)$data['monto'] != $montoOriginal) {
                $data['abono'] = $data['monto']; // Guarda el monto modificado en abono
                unset($data['monto']); // Elimina el campo 'monto' para que no interfiera
                $data['estados_id'] = 4; // Estado 4 para monto diferente
            } else {
                $data['estados_id'] = 1; // Estado 1 para solvente
            }
            // Verificar si ya existe un pago de colegiatura para el mes seleccionado
            $pagoExistente = Pago::where('registro_alumnos_id', $data['registro_alumnos_id'])
                ->where('tipopagos_id', $data['tipopagos_id'])
                ->where('mes_id', $data['mes_id'])
                ->first();

            if ($pagoExistente) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'El alumno ya ha realizado un pago para el mes seleccionado.');
            }



        }
        if (!isset($data['estados_id'])) {
            $data['estados_id'] = 3;
        }

        // Crear el pago individual
        Pago::create($data);

        // Redirigir con mensaje de éxito
        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado exitosamente.');
    }





    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $pago = Pago::find($id);
        $tipos = Tipopago::pluck('tipo_pago', 'id'); // Obtener todos los tipos de pago
        $registro_alumnos = RegistroAlumno::pluck('nombres', 'id'); // Obtener todos los alumnos
        $montos = Tipopago::pluck('monto', 'id'); // Agregar esto para obtener los montos

        return view('pago.edit', compact( 'pago','montos','tipos', 'registro_alumnos'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PagoRequest $request, Pago $pago)
    {
        $pago->update($request->validated());

        return redirect()->route('pagos.index')
            ->with('success', 'Pago updated successfully');
    }

    public function destroy($id)
    {
        try {
        Pago::find($id)->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Pago Eliminado Exitosamente');
        }catch (\Exception $exception) {
                // Manejar errores y registrar en el log
                Log::debug($exception->getMessage());
                return redirect()->route('pagos.index')->with('alerta', 'no');
            }
    }

    public function buscar()
    {
        return view('pago.form');
    }

    public function resultadosp(Request $request)
    {
        $pago = new Pago();
        $registro_alumno = RegistroAlumno::pluck('nombres', 'id');
        $tipos = Tipopago::pluck('tipo_pago', 'id');
        $montos = Tipopago::pluck('monto', 'id');
        $mes = Me::whereBetween('id', [1, 10])->pluck('mes', 'id'); // Filtrar meses entre enero y octubre

        $inscripcionPagada = false;


        $search = $request->input('search');
        $error = null;

        // Buscar el alumno por ID, nombre o código correlativo
        $alumno = RegistroAlumno::where('id', 'LIKE', "%$search%")
            ->orWhere('nombres', 'LIKE', "%$search%")
            ->orWhereHas('inscripciones', function ($query) use ($search) {
                $query->where('codigo_correlativo', 'LIKE', "%$search%");
            })
            ->first();

        // Variables para grado, sección y estado de colegiatura
        $grado = null;
        $seccion = null;
        $pagosPorMes = [];
        $tipos = Tipopago::pluck('tipo_pago', 'id'); // Obtener todos los tipos de pago

        if ($alumno) {
            // Obtener información de inscripción (grado y sección)
            $inscripcion = Inscripcion::where('registro_alumnos_id', $alumno->id)->first();
            $grado = $inscripcion ? $inscripcion->grado : null;
            $seccion = $inscripcion ? $inscripcion->seccion : null;

            if ($grado && $grado->nivels_id) {
                // Filtrar tipos de pago según el nivel del alumno
                switch ($grado->nivels_id) {
                    case 1: // Preprimaria
                    case 2: // Primaria
                        $tipos = $tipos->except([3, 4]); // Excluir colegiatura diversificado (ID 4) y colegiatura básico (ID 6)
                        break;
                    case 3: // Básico
                        $tipos = $tipos->except([2, 4]); // Excluir colegiatura regular (ID 2) y colegiatura diversificado (ID 4)
                        break;
                    case 4: // Diversificado
                        $tipos = $tipos->except([2, 3]); // Excluir colegiatura regular (ID 2) y colegiatura básico (ID 6)
                        break;
                }
            }

            $pagosPorMes = Pago::where('registro_alumnos_id', $alumno->id)
                ->select('mes_id', 'tipopagos_id')
                ->get()
                ->toArray();
            // Verificar si la inscripción ya fue pagada
            $inscripcionPagada = Pago::where('registro_alumnos_id', $alumno->id ?? null)
                ->where('tipopagos_id', 1) // ID 1 es Inscripción
                ->exists();

            // Si inscripción ya fue pagada, excluirla de los tipos de pago
            if ($inscripcionPagada) {
                $tipos = $tipos->except(1); // Excluir inscripción del listado
            }
        } else {
            $error = "Alumno no encontrado.";
        }


        return view('pago.create', compact(
            'alumno',
            'montos',
            'grado',
            'seccion',
            'pago',
            'tipos',
            'registro_alumno',
            'error',
            'pagosPorMes',
            'mes',
            'inscripcionPagada',
            'tipos'
        ));
    }
    public function indexp(Request $request)
    {
        // Obtener los grados y secciones para los filtros
        $grado = Grado::pluck('nombre_grado', 'id');
        $seccion = Seccion::pluck('seccion', 'id');
        $aniosEscolares = AnioEscolar::pluck('nombre',    'id');   // ← para la vista

        // Iniciar la consulta base
        $query = RegistroAlumno::with(['pagos', 'inscripcion', 'encargado']);

/*━━━━━━━━━━ 3. Filtro por Año Escolar ━━━━━━━━━━*/
$anioEscolarId = $request->get('anio_escolar_id');
if ($anioEscolarId) {
    $query->whereHas('inscripcion', fn ($q) =>
        $q->where('anio_escolar_id', $anioEscolarId)
    );
}
        // Verificar si hay filtros y si la relación inscripcion existe
        if ($request->filled('grados_id')) {
            $query->whereHas('inscripcion', function($q) use ($request) {
                $q->where('grados_id', $request->grados_id);
            });
        }

        if ($request->filled('seccions_id')) {
            $query->whereHas('inscripcion', function($q) use ($request) {
                $q->where('seccions_id', $request->seccions_id);
            });
        }



        $registroAlumnos = $query->get();

        return view('pago.pagoinscripcion', compact('registroAlumnos', 'grado', 'seccion','aniosEscolares'));
    }

}
