<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EncargadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'nombre_encargado' => 'required|string',
            'edad_encargado' => 'required|string',
            'estado_civil' => 'required|string',
            'oficio' => 'required|string',
			'dpi' => 'required|string',
			'telefono' => 'required',
			'persona_emergencia' => 'required|string',
            'registro_alumnos_id' => 'required|string',
            'lugars_id' => 'required|string',
            'colonias_id' => 'required|string',
        ];
    }
}
