<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ChangePasswdConfirmationRule implements ValidationRule
{
    protected $newPassword;

    public function __construct($newPassword)
    {
        $this->newPassword = $newPassword;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->newPassword != $value){
            $fail('Las contraseñas no coinciden');
        }
    }
}
