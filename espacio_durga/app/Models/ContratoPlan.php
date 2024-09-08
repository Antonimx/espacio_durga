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
    use HasFactory,SoftDeletes;

    protected $table = 'contratos_planes';
    public $timestamps = false;

    protected $fillable = ['rut_alumno', 'plan_mensual_id', 'inicio_mensualidad', 'fin_mensualidad', 'n_clases_disponibles', 'estado'];

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class,'rut_alumno','rut');
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
}
