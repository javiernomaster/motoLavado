<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // Nombre de la tabla (opcional si Laravel no la detecta bien)
    protected $table = 'clientes';

    // PK personalizada
    protected $primaryKey = 'id_cliente';

    // Campos que se pueden insertar
    protected $fillable = [
        'nombre',
        'telefono',
        'direccion'
    ];

    // Relación: un cliente tiene muchas motos
    public function motos()
    {
        return $this->hasMany(Moto::class, 'id_cliente');
    }

    // 🔥 Relación: un cliente tiene muchos lavados
    public function lavados()
    {
        return $this->hasMany(LavadoOrden::class, 'id_cliente');
    }
}