<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';

    protected $fillable = [
        'nombre',
        'ci',
        'telefono',
        'direccion',
        'porcentaje_comision',
        'estado'
    ];

    public function lavados()
    {
        return $this->hasMany(LavadoOrden::class, 'trabajador_id');
    }
}