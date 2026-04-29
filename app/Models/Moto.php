<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Cliente;
use App\Models\LavadoOrden;

class Moto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'motos';

    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'cliente_id',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function lavados()
    {
        return $this->hasMany(LavadoOrden::class, 'moto_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }
}
