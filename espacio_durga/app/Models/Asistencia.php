<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;



class Asistencia extends Model
{
    use HasFactory;
    protected $table = 'asistencias';
    public $timestamps = false;


    protected $fillable = ['contrato_plan_id', 'fecha_hora'];

    public function contratoPlan(): BelongsTo
    {
        return $this->belongsTo(ContratoPlan::class);
    }

    public function getFechaHoraFormateadaAttribute()
    {
        return Carbon::parse($this->fecha_hora)->format('d/m/Y H:i');
    }

}
