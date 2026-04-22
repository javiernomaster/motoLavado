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
        Schema::create('motos', function (Blueprint $table) {
            $table->string('placa')->primary(); // PK

            $table->string('marca');
            $table->string('modelo');
            $table->string('tipo_moto');
            $table->string('cilindraje');
            $table->string('color');

            // RELACIÓN CON CLIENTE
            $table->unsignedBigInteger('id_cliente');

            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('clientes')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motos');
    }
};