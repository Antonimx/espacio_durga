<?php

namespace App\Http\Requests;

use App\Rules\ValidarContratoPlanRule;
use Illuminate\Foundation\Http\FormRequest;

class ContratoPlanRequest extends FormRequest
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
            'rut_alumno' => [new ValidarContratoPlanRule],
            'plan_mensual_id' => ['required', 'int', 'exists:planes_mensuales,id']
        ];
    }

    public function messages(): array
    {
        return [
            'plan_mensual_id.required' => 'Campo obligatorio',
            'plan_mensual_id.int' => 'Debe ser integer',
            'plan_mensual_id.exists' => 'Seleccione plan',
        ];
    }
}
