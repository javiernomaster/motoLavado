<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motos', function (Blueprint $table) {
            $table->id();

            $table->string('placa')->unique();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();

            // 🔗 Relación con clientes
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motos');
    }
};