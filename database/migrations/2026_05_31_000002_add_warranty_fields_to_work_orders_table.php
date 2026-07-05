<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            // Meses de garantía específicos para esta OT (null = usa el global de settings)
            $table->unsignedTinyInteger('warranty_months')->nullable()->after('status');
            // Fecha real de entrega al cliente (se llena cuando status → 'Entregado')
            $table->timestamp('delivered_at')->nullable()->after('warranty_months');
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['warranty_months', 'delivered_at']);
        });
    }
};
