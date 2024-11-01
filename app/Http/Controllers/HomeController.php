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
        // Contar el total de alumnos inscritos
        $totalAlumnos = Inscripcion::count();

        // Calcular el total de ingresos sumando el monto de cada pago según su tipo de pago
        $totalIngresos = Pago::with('tipopago')->get()->sum(function($pago) {
            return $pago->tipopago->monto;
        });

        return view('home', compact('totalAlumnos', 'totalIngresos'));
    }

}
