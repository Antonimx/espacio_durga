<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Alumno extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'alumnos';
    protected $primaryKey = 'rut';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['rut', 'observaciones'];

    public function persona(): HasOne
    {
        return $this->hasOne(Persona::class, 'rut','rut');
    }

    public function contratosPlanes(): HasMany
    {
        return $this->hasMany(ContratoPlan::class,'rut_alumno','rut');
    }
    
}
