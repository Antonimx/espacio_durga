<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;


class ContratoPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contratos_planes';
    public $timestamps = false;

    protected $fillable = ['rut_alumno', 'plan_mensual_id', 'inicio_mensualidad', 'fin_mensualidad', 'n_clases_disponibles'];

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'rut_alumno', 'rut');
    }

    public function planMensual(): BelongsTo
    {
        return $this->belongsTo(PlanMensual::class);
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }

    public function getInicioMensualidadFormateadaAttribute()
    {
        return Carbon::parse($this->inicio_mensualidad)->format('d/m/Y');
    }
    public function getFinMensualidadFormateadaAttribute()
    {
        return Carbon::parse($this->fin_mensualidad)->format('d/m/Y');
    }
    public function getFechaTerminoContratoFormateadaAttribute()
    {
        return Carbon::parse($this->fecha_termino_contrato)->format('d/m/Y');
    }

    public function getRazonTerminoAttribute()
    {
        $alumno = Alumno::find($this->rut_alumno);

        if(!$alumno){
            return 'Se eliminó el alumno';
        } else if ($this->n_clases_disponibles !== 0) {
            if ($this->fecha_termino_contrato < $this->fin_mensualidad) {
                return 'Manual';
            } else if ($this->fecha_termino_contrato > $this->fin_mensualidad) {
                return 'Mensualidad vencida';
            }
        } else return 'Todas las clases consumidas';
    }

    public function getClasesAsistidasAttribute()
    {
        return $this->planMensual->n_clases - $this->n_clases_disponibles;
    }
}
