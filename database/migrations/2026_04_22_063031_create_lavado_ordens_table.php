<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lavado_ordens', function (Blueprint $table) {
            $table->id('id_orden'); // PK

            $table->date('fecha');
            $table->string('estado')->default('Pendiente');

            // RELACIONES
            $table->string('placa'); // FK moto
            $table->unsignedBigInteger('id_cliente'); // FK cliente

            $table->timestamps();

            // CLAVES FORÁNEAS
            $table->foreign('placa')
                  ->references('placa')
                  ->on('motos')
                  ->onDelete('cascade');

            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('clientes')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lavado_ordens');
    }
};