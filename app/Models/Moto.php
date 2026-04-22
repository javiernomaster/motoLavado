<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\LavadoOrden;

class Moto extends Model
{
    protected $table = 'motos';

    protected $primaryKey = 'placa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'cliente_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function lavados()
    {
        return $this->hasMany(LavadoOrden::class, 'placa', 'placa');
    }
}