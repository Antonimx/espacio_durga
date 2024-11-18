<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;


class ValidarMismoUsuarioRule implements ValidationRule
{
    private $rut;
    
    public function __construct($rut){
        $this->rut = $rut;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Auth::user()->rut == $this->rut && Auth::user()->nivel_acceso != $value){
            $fail('No puede editar su propio nivel de acceso');
        }
    }
}
