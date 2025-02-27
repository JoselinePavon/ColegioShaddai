<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Illuminate\Http\Request;

class ReglamentoController extends Controller
{
    public function reglamento()
    {
        return view('Reglamento.reglamento');
    }



    public function buscarreglamento(Request $request)
    {
        // Buscar la inscripción por el código correlativo
        $inscripcion = Inscripcion::where('codigo_correlativo', $request->input('codigo_correlativo'))
            ->with(['registroAlumno', 'registroAlumno.encargado', 'grado', 'seccion'])
            ->first();

        // Si no se encuentra, devolver un mensaje de error
        if (!$inscripcion) {
            return view('Reglamento.reglamento')
                ->with('error', 'No se encontró información para el código correlativo ingresado.');
        }

        // Preparar los datos para la vista
        $encargado = $inscripcion->registroAlumno->encargado ?? null;

        return view('Reglamento.reglamento', [
            'codigoCorrelativo' => $inscripcion->codigo_correlativo,
            'nombreCompleto' => $encargado->nombre_encargado ?? '',
            'edad_encargado' => $encargado->edad_encargado ?? '',
            'estadoCivil' => $encargado->estado_civil ?? '',
            'oficio' => $encargado->oficio ?? '',
            'identificacion' => $encargado->dpi ?? '',
            'residencia' => $encargado ?
                ($encargado->lugar->lugar . ', ' . $encargado->colonia->nombre) : '',
            'telefonoCasa' => $encargado->telefono ?? '',
            'telefonoCelular' => $encargado->persona_emergencia ?? '',
            'correo' => '', // Agrega este campo si tienes un correo asociado
            'nombreEducando' => $inscripcion->registroAlumno->nombres . ' ' . $inscripcion->registroAlumno->apellidos,
            'gradoNivel' => $inscripcion->grado->nombre_grado ?? '',
            'nivel' => $inscripcion->grado->nivel->nivel ?? '',
            'jornada' => $inscripcion->jornada ?? '',
        ]);
    }
}


