<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\RegistroAlumno;
use App\Models\Tipopago;
use App\Models\Inscripcion;
use App\Http\Requests\PagoRequest;
use Illuminate\Http\Request;

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
        Pago::create($request->validated());

        return redirect()->route('pagos.index')
            ->with('success', 'Pago created successfully.');
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
