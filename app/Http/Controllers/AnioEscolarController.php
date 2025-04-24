<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroAlumno;
use App\Models\Tipopago;
use App\Models\Me;
use App\Models\Pago;
use App\Models\AnioEscolar;

class AnioEscolarController extends Controller
{
    public function obtenerAniosEscolares()
{
    $aniosEscolares = AnioEscolar::orderBy('nombre', 'desc')->get();
    return response()->json($aniosEscolares);
}
    public function create()
{
    $pago = new Pago();
    $tipos = Tipopago::pluck('tipo_pago', 'id');
    $mes = Me::whereBetween('id', [1, 10])->pluck('mes', 'id');
    $registro_alumnos = RegistroAlumno::pluck('nombres', 'id');
    $montos = Tipopago::pluck('monto', 'id');
    $alumnoId = request()->input('registro_alumnos_id');

    $inscripcionPagada = false;

    // Lógica de pago
    if ($alumnoId) {
        $alumno = RegistroAlumno::find($alumnoId);
        if ($alumno) {
            $inscripcionPagada = Pago::where('registro_alumnos_id', $alumno->id)
                ->where('tipopagos_id', 1)
                ->exists();

            if ($inscripcionPagada) {
                $tipos = $tipos->except(1);
            }
        }
    }

    // Obtener pagos por mes
    $pagosPorMes = [];
    if ($alumnoId && $alumno) {
        $pagosPorMes = Pago::where('registro_alumnos_id', $alumno->id)
            ->select('mes_id', 'tipopagos_id')
            ->get()
            ->toArray();
    }

    // Pasar los datos a la vista, pero sin los años escolares
    return view('pago.form', compact('pago', 'montos', 'tipos', 'registro_alumnos', 'mes', 'pagosPorMes', 'inscripcionPagada'));
}

}
