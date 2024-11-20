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
    public function index()
    {
        $mesActual = Carbon::now()->month;

        // Obtener todos los pagos con las relaciones necesarias
        $pagos = Pago::with([
            'registroAlumno.inscripcion.grado',
            'registroAlumno.inscripcion.seccion',
            'estado',
            'mes'
        ])->get();

        // Agrupar los pagos por alumno y determinar los meses pagados
        $alumnos = $pagos->groupBy('registro_alumnos_id')->map(function ($pagosAlumno) {
            return [
                'registroAlumno' => $pagosAlumno->first()->registroAlumno,
                'mesesPagados' => $pagosAlumno->pluck('mes_id')->toArray(), // Meses pagados
            ];
        });

        return view('pago.index', compact('alumnos', 'mesActual','pagos'))->with('i', 0);
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

        // Retornar la vista con los pagos del alumno
        return view('pago.show', compact('pagos'));
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
        $request->validate([
            'num_serie' => 'required|unique:pagos,num_serie',
            'registro_alumnos_id' => 'required',
            'tipopagos_id' => 'required',
            'fecha_pago' => 'required|date',
            'mes_id' => 'required',

        ], [
            'num_serie.unique' => 'El número de boleta ya está en uso.',
            'num_serie.required' => 'El número de boleta es obligatorio.',
        ]);

        $data = $request->validated();
// Verificar si el tipo de pago es inscripción (id 2)
        if ($data['tipopagos_id'] == 2) {
            $pagoInscripcion = Pago::where('registro_alumnos_id', $data['registro_alumnos_id'])
                ->where('tipopagos_id', 2) // Verificar solo pagos de inscripción
                ->first();

            if ($pagoInscripcion) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'El alumno ya ha realizado el pago de inscripción.');
            }
        }

        // Verificar si el tipo de pago es colegiatura (id 1)
        if ($data['tipopagos_id'] == 1) {

            // Verificar si ya existe un pago de colegiatura para este alumno en el mes y año actuales
            $pagoExistente = Pago::where('registro_alumnos_id', $data['registro_alumnos_id'])
                ->where('tipopagos_id', 1) // Solo colegiatura
                ->where('mes_id', $data['mes_id']) // Verificar el mes
                ->first();

            if ($pagoExistente) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'El alumno ya ha realizado un pago para el mes seleccionado.');
            }

            // Asignar estado "solvente" si es colegiatura
            $data['estados_id'] = 1; // Estado 1 representa "solvente"
        } else {
            // Asignar estado 3 para otros tipos de pago que no son colegiatura
            $data['estados_id'] = 3;
        }

        // Crear el pago con los datos validados
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
