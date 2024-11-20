<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ContratoPDFController extends Controller
{
    public function generarPDF(Request $request)
    {
        $data = $request->all();

        $pdf = PDF::loadView('contrato_pdf', $data);

        return $pdf->download('contrato.pdf');
    }
}
