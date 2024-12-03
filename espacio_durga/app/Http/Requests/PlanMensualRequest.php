<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanMensualRequest extends FormRequest
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
            'nombre' => ['required', 'min:3','max:20'],
            'n_clases' => ['required', 'integer','gt:0','lte:255'],
            'valor' => ['required', 'integer','gt:0']
        ];
    }

    public function messages(): array
    {
        return[
            'nombre.required' => 'Indique el nombre del plan mensual',
            'nombre.min' => 'El nombre debe tener un mínimo de 3 carácteres',
            'nombre.max' => 'El nombre no puede tener más de 20 cáracteres',

            'n_clases.required' => 'Indique el número de clases del plan mensual',
            'n_clases.integer' => 'Debe ser un número',
            'n_clases.gt' => 'Debe ser mayor a 0',
            'n_clases.lte' => 'Debe ser menor o igual a 255',
            
            'valor.required' => 'Indique el valor del plan mensual',
            'valor.integer' => 'Debe ser un número',
            'valor.gt' => 'Debe ser mayor a 0',
            
        ];
    }
}
