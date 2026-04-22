<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadors';

    protected $fillable = [
    'nombre',
    'ci',
    'telefono',
    'direccion',
    'porcentaje_comision',
    'estado'
];
}