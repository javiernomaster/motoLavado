<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'ci',
        'telefono',
        'direccion',
    ];

    public function motos()
    {
        return $this->hasMany(Moto::class);
    }

    public function lavados()
    {
        return $this->hasMany(LavadoOrden::class, 'cliente_id');
    }
}
