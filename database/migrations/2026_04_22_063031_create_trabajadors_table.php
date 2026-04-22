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
            $table->decimal('salario', 10, 2)->nullable();
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trabajadors');
    }
};