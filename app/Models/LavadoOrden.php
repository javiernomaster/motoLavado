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
        'cliente_id',
        'moto_id',
        'servicio_id',
        'trabajador_id',
        'precio_total'
    ];

    // Relación con cliente
public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con moto
public function moto()
    {
        return $this->belongsTo(Moto::class);
    }
    
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
    
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}