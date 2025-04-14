<?php

namespace App\Http\Controllers;

use App\Models\Me;
use App\Models\Pago;
use App\Models\RegistroAlumno;
use App\Models\Tipopago;
use App\Models\estado;
use App\Models\Inscripcion;
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
        $mesActual = Carbon::now()->month;
        $añoActual = Carbon::now()->year;
        $mesLimite = 10; // Octubre


        // Habilitar registro de depuración
        Log::debug("======= INICIO DE PROCESAMIENTO DE SOLVENCIA =======");
        Log::debug("Mes actual: $mesActual, Año: $añoActual");

        $grados_id = $request->get('grados_id');
        $seccions_id = $request->get('seccions_id');
        $estado = $request->get('estado');

        // Consulta con relaciones
        $query = Pago::with([
            'registroAlumno.inscripcion.grado.nivel',
            'registroAlumno.inscripcion.seccion',
            'estado',
            'mes',
            'tipopago'
        ])->orderBy('created_at', 'desc');

        // Filtros por grado y sección
        if ($grados_id) {
            $query->whereHas('registroAlumno.inscripcion.grado', function ($q) use ($grados_id) {
                $q->where('id', $grados_id);
            });
        }

        if ($seccions_id) {
            $query->whereHas('registroAlumno.inscripcion.seccion', function ($q) use ($seccions_id) {
                $q->where('id', $seccions_id);
            });
        }

        $pagos = $query->get();
        Log::debug("Total de pagos encontrados: " . $pagos->count());

        // Agrupación por alumno y lógica de solvencia
        $alumnos = $pagos->groupBy('registro_alumnos_id')->map(function ($pagosAlumno) use ($mesActual, $mesLimite, $añoActual) {
            $alumnoNombre = $pagosAlumno->first()->registroAlumno->nombres ?? 'Desconocido';
            $alumnoId = $pagosAlumno->first()->registro_alumnos_id ?? 'Desconocido';
            Log::debug("======= PROCESANDO ALUMNO: $alumnoNombre (ID: $alumnoId) =======");

            // Determinar el nivel del alumno y los tipos de pago correspondientes
            $nivelId = $pagosAlumno->first()->registroAlumno->inscripcion->grado->nivel->id ?? null;
            $tiposPagoPorNivel = [];

            switch ($nivelId) {
                case 1: // Preprimaria
                case 2: // Primaria
                    $tiposPagoPorNivel = [2]; // Solo colegiatura regular
                    break;
                case 3: // Básico
                    $tiposPagoPorNivel = [3]; // Solo colegiatura básico
                    break;
                case 4: // Diversificado
                    $tiposPagoPorNivel = [4]; // Solo colegiatura diversificado
                    break;
                default:
                    $tiposPagoPorNivel = [2, 3, 4]; // Considerar todos por si acaso
            }

            Log::debug("Nivel: $nivelId, Tipos de pago: " . implode(', ', $tiposPagoPorNivel));

            // Filtrar pagos por tipo de pago según el nivel
            $pagosFiltrados = $pagosAlumno->filter(function ($pago) use ($tiposPagoPorNivel) {
                // Incluir pagos regulares según el nivel
                if (in_array($pago->tipopagos_id, $tiposPagoPorNivel)) {
                    return true;
                }

                // Incluir pagos de tipo "Completar Pago" que contengan "Colegiatura" en su descripción
                if ($pago->tipopago && stripos($pago->tipopago->tipo_pago, 'Completar Pago') !== false
                    && stripos($pago->tipopago->tipo_pago, 'Colegiatura') !== false) {
                    return true;
                }

                return false;
            });

            Log::debug("Total de pagos filtrados por tipo: " . $pagosFiltrados->count());

            // Agrupar pagos por mes
            $pagosPorMes = [];

            foreach ($pagosFiltrados as $pago) {
                $mesPago = $pago->mes_id;

                // Inicializar el array para este mes si no existe
                if (!isset($pagosPorMes[$mesPago])) {
                    $pagosPorMes[$mesPago] = [
                        'total_abonado' => 0,
                        'monto_esperado' => $pago->tipopago->monto ?? 0,
                        'pagos' => []
                    ];
                }

                // Agregar este pago al mes correspondiente
                $pagosPorMes[$mesPago]['pagos'][] = $pago;

                // Obtener el abono o monto según corresponda
                $montoActual = 0;

                // Si es un pago con abono específico (como pagos parciales o complementarios)
                if (isset($pago->abono) && $pago->abono > 0) {
                    $montoActual = $pago->abono;
                    Log::debug("Sumando abono de $montoActual para el mes $mesPago (ID: {$pago->id}, Tipo: {$pago->tipopagos_id})");
                }
                // Si es un pago completo (estados 1 o 3)
                else if ($pago->estados_id == 1 || $pago->estados_id == 3) {
                    $montoActual = $pago->tipopago->monto ?? 0;
                    Log::debug("Sumando monto completo de $montoActual para el mes $mesPago (ID: {$pago->id}, Tipo: {$pago->tipopagos_id}, Estado: {$pago->estados_id})");
                }
                // Si es un pago incompleto (estado 4 o cualquier otro)
                else {
                    // Para pagos incompletos, usar el monto del pago o el abono, lo que esté disponible
                    $montoActual = $pago->monto ?? $pago->abono ?? 0;
                    Log::debug("Sumando monto parcial de $montoActual para el mes $mesPago (ID: {$pago->id}, Tipo: {$pago->tipopagos_id}, Estado: {$pago->estados_id})");
                }

                // Sumar al total abonado para este mes
                $pagosPorMes[$mesPago]['total_abonado'] += $montoActual;

                Log::debug("Total acumulado para el mes $mesPago: {$pagosPorMes[$mesPago]['total_abonado']}");
            }

            // Verificar cada mes para determinar si está completamente pagado
            $mesesPagados = [];

            foreach ($pagosPorMes as $mes => $datosPago) {
                $totalAbonado = $datosPago['total_abonado'];
                $montoEsperado = $datosPago['monto_esperado'];

                Log::debug("Verificando mes $mes: Total abonado=$totalAbonado, Monto esperado=$montoEsperado");

                if ($totalAbonado >= $montoEsperado) {
                    $mesesPagados[] = $mes;
                    Log::debug("Mes $mes COMPLETAMENTE PAGADO");
                } else {
                    Log::debug("Mes $mes NO completamente pagado");
                }
            }

            // Ordenar los meses pagados
            sort($mesesPagados);
            Log::debug("Meses pagados completamente: " . implode(', ', $mesesPagados));

            // Lógica de solvencia según el mes actual
            $esSolvente = false;

            // Caso 1: Enero (mes 1) - Reinicio de contador
            if ($mesActual == 1) {
                // En enero todos empiezan como insolventes hasta que paguen enero
                $esSolvente = in_array(1, $mesesPagados);
            }
            // Caso 2: Febrero a Octubre (meses 2-10) - Verificar pagos hasta el mes anterior
            else if ($mesActual >= 2 && $mesActual <= 10) {
                $mesesRequeridos = range(1, $mesActual - 1); // Solo verificar hasta el mes anterior
                $mesesFaltantes = array_diff($mesesRequeridos, $mesesPagados);
                $esSolvente = empty($mesesFaltantes);

                if (!$esSolvente) {
                    Log::debug("Meses faltantes: " . implode(', ', $mesesFaltantes));
                }
            }
            // Caso 3: Noviembre y Diciembre (meses 11-12) - Solvente si pagó hasta octubre
            else if ($mesActual == 11 || $mesActual == 12) {
                // Si pagó hasta octubre (todos los meses del 1 al 10), está solvente
                $mesesCompletos = range(1, 10);
                $mesesFaltantes = array_diff($mesesCompletos, $mesesPagados);
                $esSolvente = empty($mesesFaltantes);

                if (!$esSolvente) {
                    Log::debug("Meses faltantes: " . implode(', ', $mesesFaltantes));
                }
            }

            Log::debug("¿Es solvente? " . ($esSolvente ? 'SÍ' : 'NO'));

            return [
                'registroAlumno' => $pagosAlumno->first()->registroAlumno,
                'mesesPagados' => $mesesPagados,
                'esSolvente' => $esSolvente,
            ];
        });

        // Filtro por estado solvente/insolvente
        if ($estado) {
            $alumnos = $alumnos->filter(function ($alumno) use ($estado) {
                return ($estado === 'solvente') ? $alumno['esSolvente'] : !$alumno['esSolvente'];
            });
        }

        // Grados y secciones para los filtros de la vista
        $grado = \App\Models\Grado::pluck('nombre_grado', 'id');
        $seccion = \App\Models\Seccion::pluck('seccion', 'id');

        Log::debug("Total alumnos: " . count($alumnos) .
            ", Solventes: " . $alumnos->where('esSolvente', true)->count() .
            ", Insolventes: " . $alumnos->where('esSolvente', false)->count());
        Log::debug("======= FIN DE PROCESAMIENTO DE SOLVENCIA =======");

        return view('pago.index', compact('pagos', 'grado', 'seccion', 'alumnos', 'mesActual'))
            ->with('i', 0);
    }


    public function show($registro_alumnos_id)
    {

        // Obtener todos los pagos realizados por el alumno con el registro_alumnos_id
        $pagos = Pago::where('registro_alumnos_id', $registro_alumnos_id)
            ->with(['registroAlumno.inscripcion', 'tipopago', 'mes', 'estado'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Verificar si el alumno tiene pagos registrados
        if ($pagos->isEmpty()) {
            return redirect()->route('pagos.index')->with('error', 'No se encontraron pagos para este alumno.');
        }
        $totalPagos = $pagos->sum(function ($pago) {
            if (in_array($pago->tipopagos_id, [5, 6])) { // Verificar si tipopagos_id es 3 o 5
                // Si es Computación, sumar el abono
                return $pago->abono ?? 0;
            }
            // Para otros pagos, sumar el monto
            return $pago->tipopago->monto ?? 0;
        });

        // Retornar la vista con los pagos del alumno
        return view('pago.show', compact('pagos','totalPagos'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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

        return view('pago.form', compact('pago', 'montos', 'tipos', 'registro_alumnos', 'mes', 'pagosPorMes','inscripcionPagada'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(PagoRequest $request){

        // Validación de los campos
        $request->validate([
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


}
