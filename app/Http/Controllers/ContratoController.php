<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function contrato()
    {
        return view('contrato.contrato');
    }

}
