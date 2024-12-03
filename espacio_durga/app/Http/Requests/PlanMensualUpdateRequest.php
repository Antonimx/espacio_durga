<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanMensualUpdateRequest extends FormRequest
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
            'valor' => ['required', 'integer','gt:0']
        ];
    }

    public function messages(): array
    {
        return[
            'nombre.required' => 'Indique el nombre del plan mensual',
            'nombre.min' => 'El nombre debe tener un mínimo de 3 carácteres',
            'nombre.max' => 'El nombre no puede tener más de 20 cáracteres',
            
            'valor.required' => 'Indique el valor del plan mensual',
            'valor.integer' => 'Debe ser un número',
            'valor.gt' => 'Debe ser mayor a 0',
            
        ];
    }
}
