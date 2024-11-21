<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use App\Rules\ChangePasswdConfirmationRule;
use App\Rules\ChangePasswdRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswdRequest extends FormRequest
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
            'current_password' => ['required',new ChangePasswdRule(Usuario::find($this->input('rut')))],
            'new_password' => ['required'],
            'new_password_confirmation' => ['required', new ChangePasswdConfirmationRule($this->input('new_password'))]
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Indique contraseña actual',
            'new_password.required' => 'Indique contraseña nueva',
            'new_password_confirmation.required' => 'Campo requerido',
        ];
    }
}
