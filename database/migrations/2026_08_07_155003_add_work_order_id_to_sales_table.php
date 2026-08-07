<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('sales', 'work_order_id')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->foreignId('work_order_id')
                      ->nullable()
                      ->after('cash_register_id')
                      ->constrained('work_orders')
                      ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('sales', 'work_order_id')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropForeign(['work_order_id']);
                $table->dropColumn('work_order_id');
            });
        }
    }
};

