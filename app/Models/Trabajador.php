<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trabajador extends Model
{
    use HasFactory, SoftDeletes;

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

    public function scopeActivos($query)
    {
        return $query->where('estado', 1)->orWhereNull('estado');
    }
}
