<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Verificar si ya existe la columna estado
        if (!Schema::hasColumn('servicios', 'estado')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->boolean('estado')->default(true)->after('tiempo_estimado');
            });
        } else {
            // Si ya existe, cambiar el tipo de dato de enum a boolean
            DB::statement('ALTER TABLE servicios MODIFY estado TINYINT(1) DEFAULT 1');
        }
    }

    public function down(): void
    {
        // No revertimos el cambio de tipo porque ya tenemos datos
    }
};
