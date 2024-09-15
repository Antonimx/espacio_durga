<?php

namespace App\Rules;

use App\Models\Asistencia;
use App\Models\ContratoPlan;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HoraAsistenciaRule implements ValidationRule
{
    private $contratoPlanId;
    public function __construct($contratoPlanId){
        $this->contratoPlanId = $contratoPlanId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $contratoPlan = ContratoPlan::find($this->contratoPlanId);
        $existingAsistencia = Asistencia::where('contrato_plan_id', $contratoPlan->id)
        ->whereBetween('fecha_hora', [Carbon::now()->subHour(), Carbon::now()])
        ->first(); 

        if ($existingAsistencia){
            $fail('Ya hay un registro de asistencia hoy para este alumno a las '. $existingAsistencia->fecha_hora->format('H:i'). 'hrs. Debe esperar una hora si quiere tomar asistencia de nuevo.');
        }
    }
}
