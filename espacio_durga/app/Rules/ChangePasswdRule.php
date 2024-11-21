<?php

namespace App\Rules;

use App\Models\Usuario;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class ChangePasswdRule implements ValidationRule
{
    protected $usuario;
    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Hash::check($value,$this->usuario->password)){
            $fail('Contraseña incorrecta');
        }
    }
}
