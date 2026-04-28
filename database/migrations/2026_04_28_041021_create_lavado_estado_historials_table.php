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
        Schema::create('lavado_estado_historials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lavado_orden_id');
            $table->foreign('lavado_orden_id')->references('id_orden')->on('lavado_ordens')->onDelete('cascade');
            $table->string('estado_anterior')->nullable();
            $table->string('estado_nuevo');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lavado_estado_historials');
    }
};

