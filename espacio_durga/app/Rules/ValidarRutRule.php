<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidarRutRule implements ValidationRule
{

    private $extranjero;
    
    public function __construct($extranjero = false){
        $this->extranjero = $extranjero;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        if (!$this->extranjero){ //Si NO es extranjero se valida el RUT.
            if(!$this->esRutValido($value)){
                $fail('Rut inválido');
            }
        }
    }

    private function esRutValido($rutCompleto){
        if (!preg_match('/^[0-9]+-[0-9kK]{1}$/', $rutCompleto)) {
            return false;
        }
        
        $rut = explode('-',$rutCompleto)[0];
        $serie = [2, 3, 4, 5, 6, 7];
        $suma = 0;
        $factor = 0;
        
        // Recorrer el RUT de derecha a izquierda
        for ($i = strlen($rut) - 1; $i >= 0; $i--) {
            // Multiplicar cada dígito del RUT por el número de la serie (que se repite cíclicamente)
            $suma += $rut[$i] * $serie[$factor];
            $factor = ($factor + 1) % count($serie); // Ciclar entre los índices de la serie
        }
        
        // Obtener el módulo 11 de la suma
        $resto = $suma % 11;
        $digito = 11 - $resto;

        $digitoVerificador = explode('-',$rutCompleto)[1];
        if ((string)$digito !== $digitoVerificador){
            return false;
        }
        return true;
    }
    
}
