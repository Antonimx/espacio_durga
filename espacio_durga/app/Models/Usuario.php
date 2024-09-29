<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;



class Usuario extends Authenticatable
{
    use HasFactory;
    protected $table = 'usuarios';
    protected $primaryKey = 'rut';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['rut', 'nivel_acceso'];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class,'rut','rut');
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class,'nivel_acceso','nivel_acceso');
    }

    public function esAdmin():bool
    {
        return $this->nivel_acceso==1;
    }
}
