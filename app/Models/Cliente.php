<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

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
}