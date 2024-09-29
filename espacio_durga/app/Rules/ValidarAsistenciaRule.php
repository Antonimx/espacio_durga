<?php

namespace App\Rules;

use App\Models\Asistencia;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidarAsistenciaRule implements ValidationRule
{
    private $contratoPlanId;

    public function __construct($contratoPlanId){
        $this->$contratoPlanId = $contratoPlanId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        dd($this->contratoPlanId);
        $asistenciaExistente = Asistencia::where('contrato_plan_id', $this->contratoPlanId)
        ->whereBetween('fecha_hora', [Carbon::now()->subHour(), Carbon::now()])
        ->first();

        if ($asistenciaExistente){
            $horaExistente = Carbon::parse($asistenciaExistente->fecha_hora)->format('H:i');
            $fail('Ya se registró una asistencia para este alumno a las '. $horaExistente. '.Debe esperar una hora si quiere registrar nuevamente');
        }
    }
}
