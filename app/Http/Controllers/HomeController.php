<?php

namespace App\Http\Controllers;
use App\Models\Inscripcion;
use App\Models\Pago;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {

        $totalAlumnos = Inscripcion::count();

        $totalIngresos = Pago::join('tipopagos', 'pagos.tipopagos_id', '=', 'tipopagos.id')
            ->selectRaw('SUM(tipopagos.monto) + SUM(pagos.abono) as total')
            ->value('total');

        return view('home', compact('totalAlumnos', 'totalIngresos'));
    }

}
