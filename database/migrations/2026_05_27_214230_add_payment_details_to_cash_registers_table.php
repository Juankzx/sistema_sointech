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
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->decimal('expected_cash', 10, 2)->default(0)->after('expected_closing_balance');
            $table->decimal('expected_transfer', 10, 2)->default(0)->after('expected_cash');
            $table->decimal('expected_card', 10, 2)->default(0)->after('expected_transfer');
            
            $table->decimal('closing_cash', 10, 2)->nullable()->after('closing_balance');
            $table->decimal('closing_transfer', 10, 2)->nullable()->after('closing_cash');
            $table->decimal('closing_card', 10, 2)->nullable()->after('closing_transfer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->dropColumn([
                'expected_cash', 'expected_transfer', 'expected_card',
                'closing_cash', 'closing_transfer', 'closing_card'
            ]);
        });
    }
};
