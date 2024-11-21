<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContratoPDFController extends Controller
{
    public function generarPDF(Request $request)
    {
        $data = $request->all();

        $pdf = PDF::loadView('contrato_pdf', $data);

        return $pdf->download('contrato.pdf');
    }
}
