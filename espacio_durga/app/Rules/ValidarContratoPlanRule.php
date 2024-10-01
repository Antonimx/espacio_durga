<?php

namespace App\Rules;

use App\Models\ContratoPlan;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidarContratoPlanRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $contratoActivoExistente = ContratoPlan::where('rut_alumno',$value)->where('estado',1)->get();
        if (!$contratoActivoExistente){
            $fail('El alumno con rut '. $value . ' ya tiene un contrato activo.');
        }
    }
}
