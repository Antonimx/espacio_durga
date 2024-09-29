<?php

namespace App\Http\Requests;

use App\Models\Persona;
use App\Rules\ValidarRutRule;
use Illuminate\Foundation\Http\FormRequest;

class PersonaRequest extends FormRequest
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
        // dd('personaRequest');
        //reglas en comun
        $rules = [
            'nombre' => ['required', 'string', 'alpha', 'max:30'],
            'apellido' => ['required', 'string', 'alpha', 'max:30'],
            'fecha_nac' => ['required', 'date', 'before:today'],
            'direccion' => ['nullable', 'string', 'max:30'],
            'fono' => ['required', 'string', 'regex:/^[0-9+]*$/', 'max:15'],
        ];

        // si NO existe la persona se agrega la regla de rut
        if (!Persona::where('rut', $this->input('rut'))->exists()) { 
            $rules['rut'] = ['required', 'unique:personas,rut', 'string', new ValidarRutRule($this->input('extranjero'))];
        }
        
        return $rules;
    }

    public function messages(): array
    {
        return [
            'rut.required' => 'Indicar RUT.',
            'rut.string' => 'Debe ser un string',
            'rut.unique' => 'Ya hay una persona con este RUT',

            'nombre.required' => 'Indicar nombre.',
            'nombre.string' => 'Debe ser un string',
            'nombre.alpha' => 'El nombre solo debe contener letras.',
            'nombre.max' => 'El nombre puede tener máximo 30 carácteres.',

            'apellido.required' => 'Indicar apellido.',
            'apellido.string' => 'Debe ser un string',
            'apellido.alpha' => 'El apellido solo debe contener letras.',
            'apellido.max' => 'El apellido puede tener máximo 30 carácteres.',

            'fecha_nac.required' => 'Indicar fecha de nacimiento.',
            'fecha_nac.date' => 'Debe ser una fecha',
            'fecha_nac.before' => 'La fecha tiene que ser antes de hoy.',

            'direccion.string' => 'Debe ser un string',
            'direccion.max' => 'La dirección puede tener máximo 30 carácteres.',

            'fono.required' => 'Indicar número de contacto.',
            'fono.max' => 'El número de contacto puede tener máximo 15 carácteres.',
            'fono.regex' => "El número de contacto solo puede contener dígitos y el símbolo '#'.",
        ];
    }
}
