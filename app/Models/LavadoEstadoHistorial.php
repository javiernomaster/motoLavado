<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LavadoEstadoHistorial extends Model
{
    protected $table = 'lavado_estado_historials';

    protected $fillable = [
        'lavado_orden_id',
        'estado_anterior',
        'estado_nuevo',
        'user_id',
        'observacion',
    ];

    public function lavadoOrden()
    {
        return $this->belongsTo(LavadoOrden::class, 'lavado_orden_id', 'id_orden');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

