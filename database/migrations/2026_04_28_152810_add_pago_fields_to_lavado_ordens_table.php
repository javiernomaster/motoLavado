<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lavado_ordens', function (Blueprint $table) {
            $table->decimal('monto_pagado', 10, 2)->default(0)->after('precio_total');
            $table->decimal('saldo', 10, 2)->default(0)->after('monto_pagado');
            $table->enum('metodo_pago', ['efectivo', 'qr', 'efectivo/qr'])->nullable()->after('saldo');
            $table->enum('estado_pago', ['pendiente', 'parcial', 'pagado'])->default('pendiente')->after('metodo_pago');
        });
    }

    public function down(): void
    {
        Schema::table('lavado_ordens', function (Blueprint $table) {
            $table->dropColumn(['monto_pagado', 'saldo', 'metodo_pago', 'estado_pago']);
        });
    }
};
