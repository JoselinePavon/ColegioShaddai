<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
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
			'num_serie' => 'required|string',
			'fecha_pago' => 'required|string',
			'tipopagos_id' => 'required',
			'registro_alumnos_id' => 'required',
            'mes_id' => 'required',
            'monto_abono' => ' ',
        ];
    }
}
