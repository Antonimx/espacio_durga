<?php

namespace App\Models;

use Carbon\Carbon;
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


    protected $fillable = ['rut', 'nombre', 'apellido', 'genero', 'fecha_nac', 'direccion', 'fono','extranjero'];
    protected $fillableOnUpdate = ['nombre', 'apellido', 'genero', 'fecha_nac', 'direccion', 'fono'];

    public function fillableOnUpdate()
    {
        return $this->fillableOnUpdate;
    }

    public function alumno(): HasOne
    {
        return $this->hasOne(Alumno::class,'rut','rut');
    }

    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class,'rut','rut');
    }

    public function getFechaNacFormateadaAttribute()
    {
        return Carbon::parse($this->fecha_nac)->format('d/m/Y');
    }

    public function getEdadAttribute()
    {
        return (int)abs(Carbon::now()->diffInYears($this->fecha_nac));
    }

    public function getGeneroFormateadoAttribute()
    {
        if($this->genero == 'F'){
            return 'Femenino';
        } else if ($this->genero == 'M'){
            return 'Masculino';
        } else return 'Otro';
    }

}
