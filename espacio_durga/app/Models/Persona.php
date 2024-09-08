<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'personas';
    protected $primaryKey = 'rut';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;


    protected $fillable = ['rut', 'nombre', 'apellido', 'fecha_nac', 'direccion', 'fono'];

    public function alumno(): HasOne
    {
        return $this->hasOne(Alumno::class,'rut','rut');
    }

    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class,'rut','rut');
    }

}
