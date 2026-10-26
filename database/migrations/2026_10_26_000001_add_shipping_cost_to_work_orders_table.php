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
        if (Schema::hasTable('work_orders') && !Schema::hasColumn('work_orders', 'shipping_cost')) {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->decimal('shipping_cost', 10, 2)->default(0)->after('labor_cost');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('work_orders') && Schema::hasColumn('work_orders', 'shipping_cost')) {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->dropColumn('shipping_cost');
            });
        }
    }
};
