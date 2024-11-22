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
        // Obtener los filtros de grado, sección y estado del request
        $grados_id = $request->get('grados_id');
        $seccions_id = $request->get('seccions_id');
        $estado = $request->get('estado');

        // Construir la consulta inicial
        $query = Pago::with([
            'registroAlumno.inscripcion.grado',
            'registroAlumno.inscripcion.seccion',
            'estado',
            'mes'
        ]);

        // Aplicar filtro por grado si existe
        if ($grados_id) {
            $query->whereHas('registroAlumno.inscripcion.grado', function ($q) use ($grados_id) {
                $q->where('id', $grados_id);
            });
        }

        // Aplicar filtro por sección si existe
        if ($seccions_id) {
            $query->whereHas('registroAlumno.inscripcion.seccion', function ($q) use ($seccions_id) {
                $q->where('id', $seccions_id);
            });
        }

        // Obtener resultados únicos por alumno
        $pagos = $query->get();

        // Agrupar los pagos por alumno y determinar los meses pagados
        $alumnos = $pagos->groupBy('registro_alumnos_id')->map(function ($pagosAlumno) use ($mesActual) {
            $mesesPagados = $pagosAlumno->pluck('mes_id')->toArray();
            return [
                'registroAlumno' => $pagosAlumno->first()->registroAlumno,
                'mesesPagados' => $mesesPagados,
                'esSolvente' => in_array($mesActual, $mesesPagados),
            ];
        });

        // Aplicar filtro por estado si existe
        if ($estado) {
            $alumnos = $alumnos->filter(function ($alumno) use ($estado) {
                return ($estado === 'solvente') ? $alumno['esSolvente'] : !$alumno['esSolvente'];
            });
        }

        // Obtener las listas de grados y secciones para los select
        $grado = \App\Models\Grado::pluck('nombre_grado', 'id');
        $seccion = \App\Models\Seccion::pluck('seccion', 'id');

        // Retornar la vista con todas las variables necesarias
        return view('pago.index', compact('pagos', 'grado', 'seccion', 'alumnos', 'mesActual'))
            ->with('i', 0); // Reiniciar índice para paginación
    }

    public function show($registro_alumnos_id)
    {

        // Obtener todos los pagos realizados por el alumno con el registro_alumnos_id
        $pagos = Pago::where('registro_alumnos_id', $registro_alumnos_id)
            ->with(['registroAlumno.inscripcion', 'tipopago', 'mes', 'estado'])
            ->get();

        // Verificar si el alumno tiene pagos registrados
        if ($pagos->isEmpty()) {
            return redirect()->route('pagos.index')->with('error', 'No se encontraron pagos para este alumno.');
        }
        $totalPagos = $pagos->sum(fn($pago) => $pago->tipopago->monto);

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
        $mes = Me::pluck('mes', 'id');
        $registro_alumnos = RegistroAlumno::pluck('nombres', 'id');
        $montos = Tipopago::pluck('monto', 'id');

        // Obtener los pagos realizados para todos los alumnos
        $pagosPorMes = [];

        if ($alumno = RegistroAlumno::first()) { // Aquí debes ajustar la lógica para obtener el alumno correcto
            $pagosPorMes = Pago::where('registro_alumnos_id', $alumno->id)
                ->select('mes_id', 'tipopagos_id')
                ->get()
                ->toArray();
        }

        return view('pago.form', compact('pago', 'montos', 'tipos', 'registro_alumnos', 'mes', 'pagosPorMes'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(PagoRequest $request)
    {
        // Validación de los campos
        $request->validate([
            'num_serie' => 'required|unique:pagos,num_serie',
            'registro_alumnos_id' => 'required',
            'tipopagos_id' => 'nullable', // Puede ser nulo si es pago combinado
            'fecha_pago' => 'required|date',
            'mes_id' => 'required_if:tipopagos_id,1|required_if:pagos_combinados,not_null', // Mes obligatorio en pagos combinados
            'pagos_combinados' => 'nullable|array', // Aceptar array de pagos combinados
            'pagos_combinados.*' => 'exists:tipopagos,id', // Validar que los IDs existan en la BD
        ], [
            'num_serie.unique' => 'El número de boleta ya está en uso.',
            'num_serie.required' => 'El número de boleta es obligatorio.',
            'mes_id.required_if' => 'El mes es obligatorio para pagos de colegiatura o pagos combinados.',
            'pagos_combinados.required' => 'Debe seleccionar al menos un tipo de pago en Pago Combinado.',
        ]);

        $data = $request->all();

        // Si se selecciona "combinado" pero no se seleccionan pagos en pagos_combinados
        if ($request->input('tipopagos_id') === 'combinado') {
            if (empty($data['pagos_combinados']) || !is_array($data['pagos_combinados'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Debe seleccionar al menos un tipo de pago en Pago Combinado.');
            }

            foreach ($data['pagos_combinados'] as $tipopagos_id) {
                // Excluir inscripción (ID 2) de pagos combinados
                if ($tipopagos_id == 2) {
                    continue;
                }

                // Determinar el estado del pago
                $estado_id = ($tipopagos_id == 1) ? 1 : 3; // 1 = solvente para colegiatura, 3 = cancelado para otros

                // Crear el pago combinado con el mes seleccionado
                Pago::create([
                    'num_serie' => $data['num_serie'],
                    'registro_alumnos_id' => $data['registro_alumnos_id'],
                    'tipopagos_id' => $tipopagos_id,
                    'fecha_pago' => $data['fecha_pago'],
                    'mes_id' => $data['mes_id'], // Tomar el mes seleccionado en el formulario
                    'estados_id' => $estado_id,
                ]);
            }

            // Redirigir con mensaje de éxito
            return redirect()->route('pagos.index')
                ->with('success', 'Pago combinado registrado exitosamente.');
        }

        // Manejar el caso de pagos individuales
        if ($data['tipopagos_id'] == 2) {
            // Verificar si ya existe un pago de inscripción
            $pagoInscripcion = Pago::where('registro_alumnos_id', $data['registro_alumnos_id'])
                ->where('tipopagos_id', 2)
                ->first();

            if ($pagoInscripcion) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'El alumno ya ha realizado el pago de inscripción.');
            }
        }

        if ($data['tipopagos_id'] == 1) {
            // Verificar si ya existe un pago de colegiatura para el mes seleccionado
            $pagoExistente = Pago::where('registro_alumnos_id', $data['registro_alumnos_id'])
                ->where('tipopagos_id', 1)
                ->where('mes_id', $data['mes_id'])
                ->first();

            if ($pagoExistente) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'El alumno ya ha realizado un pago para el mes seleccionado.');
            }

            // Asignar estado "solvente" para colegiatura
            $data['estados_id'] = 1;
        } else {
            // Estado 3 para otros tipos de pago
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
        Pago::find($id)->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Pago deleted successfully');
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
        $mes = Me::pluck('mes', 'id');// Obtener todos los tipos de pago


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

        if ($alumno) {
            // Obtener información de inscripción (grado y sección)
            $inscripcion = Inscripcion::where('registro_alumnos_id', $alumno->id)->first();
            $grado = $inscripcion ? $inscripcion->grado : null;
            $seccion = $inscripcion ? $inscripcion->seccion : null;

            $pagosPorMes = Pago::where('registro_alumnos_id', $alumno->id)
                ->select('mes_id', 'tipopagos_id')
                ->get()
                ->toArray();
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
        ));
    }


}
