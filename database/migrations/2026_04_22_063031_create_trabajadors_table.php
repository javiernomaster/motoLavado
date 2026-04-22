<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trabajadors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ci')->unique();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
           $table->decimal('porcentaje_comision', 5, 2)->default(40);
            $table->string('estado')->default('activo'); // activo/inactivo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trabajadors');
    }
};