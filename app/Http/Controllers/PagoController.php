<?php

namespace App\Http\Controllers;

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

    public function actualizarSolvenciasMensuales()
    {
        $mes_actual = Carbon::now()->month;
        $anio_actual = Carbon::now()->year;

        // Obtener todos los alumnos registrados
        $alumnos = RegistroAlumno::all();

        foreach ($alumnos as $alumno) {
            // Buscar pagos de colegiatura (tipopagos_id 1) para el mes actual
            $pago = Pago::where('registro_alumnos_id', $alumno->id)
                ->where('tipopagos_id', 1) // Solo colegiatura
                ->whereMonth('fecha_pago', $mes_actual)
                ->whereYear('fecha_pago', $anio_actual)
                ->first();

            // Si no hay pago de colegiatura para el mes actual, marcar como insolvente
            if (!$pago) {
                Pago::create([
                    'registro_alumnos_id' => $alumno->id,
                    'tipopagos_id' => 1, // Colegiatura
                    'fecha_pago' => now(),
                    'estados_id' => 2, // Estado 2 representa "insolvente"
                ]);
            }
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagos = Pago::paginate();

        return view('pago.index', compact('pagos'))
            ->with('i', (request()->input('page', 1) - 1) * $pagos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pago = new Pago();
        $tipos = Tipopago::pluck('tipo_pago', 'id'); // Obtener todos los tipos de pago
        $registro_alumnos = RegistroAlumno::pluck('nombres', 'id'); // Obtener todos los alumnos
        $montos = Tipopago::pluck('monto', 'id'); // Agregar esto para obtener los montos

        return view('pago.create', compact('pago', 'montos','tipos', 'registro_alumnos'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PagoRequest $request)
    {
        $data = $request->validated();

        // Verificar si el tipo de pago es colegiatura (id 1)
        if ($data['tipopagos_id'] == 1) {
            $mes_actual = Carbon::now()->month;
            $anio_actual = Carbon::now()->year;

            // Verificar si ya existe un pago de colegiatura para este alumno en el mes y año actuales
            $pagoExistente = Pago::where('registro_alumnos_id', $data['registro_alumnos_id'])
                ->where('tipopagos_id', 1) // Solo colegiatura
                ->whereMonth('fecha_pago', $mes_actual)
                ->whereYear('fecha_pago', $anio_actual)
                ->first();

            if ($pagoExistente) {
                // Si ya existe un pago de colegiatura, redirigir con un mensaje de error
                return redirect()->route('pagos.index')
                    ->with('error', 'Ya existe un pago de colegiatura registrado para este mes.');
            }

            // Asignar estado "solvente" si es colegiatura
            $data['estados_id'] = 1; // Estado 1 representa "solvente"
        } else {
            // Asignar estado 3 para otros tipos de pago que no son colegiatura
            $data['estados_id'] = 3;
        }

        Pago::create($data);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado exitosamente.');
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pago = Pago::find($id);

        return view('pago.show', compact('pago'));
    }

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
        $montos = Tipopago::pluck('monto', 'id'); // Asegúrate de que este sea el nombre de tu columna para el monto

        $search = $request->input('search');

        // Buscar el alumno por ID o nombre
        $alumno = RegistroAlumno::where('id', 'LIKE', "%$search%")
            ->orWhere('nombres', 'LIKE', "%$search%")
            ->first();

        // Si el alumno existe, obtenemos el grado asignado
        $grado = null;
        if ($alumno) {
            $inscripcion = Inscripcion::where('registro_alumnos_id', $alumno->id)->first();
            $grado = $inscripcion ? $inscripcion->grado : null;
        }

        return view('pago.form', compact('alumno', 'montos','grado','pago','tipos','registro_alumno'))
        ->with('noAlumno', !$alumno);
    }
}
