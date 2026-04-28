<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LavadoOrden extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lavado_ordens';
    protected $primaryKey = 'id_orden';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'fecha',
        'estado',
        'cliente_id',
        'moto_id',
        'servicio_id',
        'trabajador_id',
        'precio_total',
        'monto_pagado',
        'saldo',
        'metodo_pago',
        'estado_pago',
    ];

    protected $casts = [
        'fecha' => 'date',
        'precio_total' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
        'saldo' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function moto()
    {
        return $this->belongsTo(Moto::class, 'moto_id');
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'trabajador_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function historial()
    {
        return $this->hasMany(LavadoEstadoHistorial::class, 'lavado_orden_id');
    }
}
