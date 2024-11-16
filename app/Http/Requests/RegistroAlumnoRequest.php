<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroAlumnoRequest extends FormRequest
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
			'nombres' => 'required|string',
			'apellidos' => 'required|string',
			'genero' => 'required|string',
			'edad' => 'required',
			'fecha_nacimiento' => 'required',
            'codigo_personal' => 'unique:registro_alumnos,codigo_personal', // Validación única
            'codigo_correlativo' => 'required|unique:inscripcions,codigo_correlativo',


        ];
    }
}
