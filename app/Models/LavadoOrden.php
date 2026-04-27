<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Moto;
use App\Models\Trabajador;
use App\Models\Servicio;

class LavadoOrden extends Model
{
    use HasFactory;

    protected $table = 'lavado_ordens';

    protected $primaryKey = 'id_orden';

    protected $fillable = [
        'fecha',
        'estado',
        'cliente_id',
        'moto_id',
        'servicio_id',
        'trabajador_id',
        'precio_total'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function moto()
    {
        return $this->belongsTo(Moto::class, 'moto_id', 'id');
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'trabajador_id', 'id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id', 'id');
    }
}