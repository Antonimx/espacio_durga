<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumnoRequest extends FormRequest
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
            'observaciones' => ['nullable','string', 'max:200']
        ];
    }

    public function messages(): array
    {
        return [
            'observaciones.string' => 'Debe ser string',
            'observaciones.max' => 'Puede tener un máximo de 200 carácteres'
        ];
    }
}
