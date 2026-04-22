<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    // Nombre de la tabla (opcional pero recomendado)
    protected $table = 'motos';

    // PK personalizada (placa)
    protected $primaryKey = 'placa';

    // No es autoincremental
    public $incrementing = false;

    // Tipo de dato de la PK
    protected $keyType = 'string';

    // Campos que se pueden insertar
    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'tipo_moto',
        'cilindraje',
        'color',
        'id_cliente'
    ];

    // Relación: una moto pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // 🔥 Relación: una moto tiene muchos lavados
    public function lavados()
    {
        return $this->hasMany(LavadoOrden::class, 'placa');
    }
}