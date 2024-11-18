<?php

namespace App\Http\Requests;

use App\Rules\ValidarMismoUsuarioRule;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioUpdateRequest extends FormRequest
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
            'nivel_acceso' => ['required', 'exists:roles,nivel_acceso', new ValidarMismoUsuarioRule($this->input('rut'))],
        ];
    }
    public function messages(): array
    {
        return [
            'nivel_acceso.required' => 'Seleccione nivel de acceso',
            'nivel_acceso.exists' => 'El nivel de acceso no existe'
        ];
    }
}
