<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PlanMensual extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'planes_mensuales';
    public $timestamps = false;

    protected $fillable = ['nombre', 'n_clases', 'valor','cant_alumnos'];


    public function contratosPlanes(): HasMany
    {
        return $this->hasMany(ContratoPlan::class);
    }
}
