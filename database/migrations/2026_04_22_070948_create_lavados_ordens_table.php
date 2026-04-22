<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lavado_ordens', function (Blueprint $table) {
            $table->id('id_orden');

            $table->date('fecha');
            $table->string('estado')->default('Pendiente');

            // 🔗 RELACIONES CORRECTAS
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('moto_id')->constrained('motos')->onDelete('cascade');
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            $table->foreignId('trabajador_id')->constrained('trabajadors')->onDelete('cascade');

            $table->decimal('precio_total', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lavado_ordens');
    }
};