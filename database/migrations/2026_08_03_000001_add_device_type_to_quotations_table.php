<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('quotations') && !Schema::hasColumn('quotations', 'device_type')) {
            Schema::table('quotations', function (Blueprint $table) {
                $table->string('device_type')->nullable()->default('smartphone')->after('device_info');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('quotations') && Schema::hasColumn('quotations', 'device_type')) {
            Schema::table('quotations', function (Blueprint $table) {
                $table->dropColumn('device_type');
            });
        }
    }
};
