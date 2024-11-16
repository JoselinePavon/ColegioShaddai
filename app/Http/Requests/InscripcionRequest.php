<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InscripcionRequest extends FormRequest
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

            'codigo_correlativo' => 'required|unique:inscripcions,codigo_correlativo',
			'registro_alumnos_id' => 'required',
			'grados_id' => 'required',
			'seccions_id' => 'required',
        ];
    }
}
