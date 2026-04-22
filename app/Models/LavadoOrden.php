<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LavadoOrden extends Model
{
    // PK personalizada
    protected $primaryKey = 'id_orden';

    // Campos permitidos
    protected $fillable = [
        'fecha',
        'estado',
        'placa',
        'id_cliente'
    ];

    // Relación con cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relación con moto
    public function moto()
    {
        return $this->belongsTo(Moto::class, 'placa');
    }
}