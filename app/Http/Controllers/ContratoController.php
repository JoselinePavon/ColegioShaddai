<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\RegistroAlumno;
use Illuminate\Http\Request;
use App\Models\Encargado;

class ContratoController extends Controller
{
    public function contrato()
    {
        return view('contrato.contrato');
    }

    public function buscarAlumno(Request $request)
    {
        // Obtener el código correlativo enviado
        $codigoCorrelativo = $request->get('codigo_correlativo');

        // Buscar el encargado y su relación con alumno e inscripción
        $encargado = Encargado::with(['registroAlumno.inscripcion' => function ($query) use ($codigoCorrelativo) {
            // Filtrar la inscripción por el código correlativo
            $query->where('codigo_correlativo', $codigoCorrelativo);
        }])
            ->first();

        // Si el encargado existe y tiene información relacionada
        if ($encargado && $encargado->registroAlumno && $encargado->registroAlumno->inscripcion) {
            // Obtener el alumno y su inscripción
            $inscripcion = $encargado->registroAlumno->inscripcion;

            return view('contrato.contrato', [
                'codigoCorrelativo' => $codigoCorrelativo,
                'nombreCompleto' => $encargado->nombre_encargado,
                'edad' => $encargado->edad ?? '',
                'estadoCivil' => $encargado->estado_civil ?? '',
                'oficio' => $encargado->oficio ?? '',
                'identificacion' => $encargado->dpi ?? '',
                'residencia' => $encargado->colonias ?? '',
                'telefonoCasa' => $encargado->telefono ?? '',
                'telefonoCelular' => $encargado->persona_emergencia ?? '',
                // Obtener los datos del alumno desde la relación
                'alumno' => $encargado->registroAlumno->nombres ?? '',
                'grado' => $inscripcion->grado->nombre_grado ?? '',
                'seccion' => $inscripcion->seccion->seccion ?? '',
                'jornada' => $inscripcion->jornada ?? '',
            ]);
        }

        // Si no se encuentra el encargado o la información relacionada, regresar con un mensaje de error
        return redirect()->back()->with('error', 'No se encontró información para el código ingresado.');
    }
}

