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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('company_name')->nullable();
            $table->string('company_rut')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('currency')->default('CLP');
            $table->decimal('tax_rate', 5, 2)->default(19.00);
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'company_name', 'company_rut', 'company_address', 
                'company_phone', 'currency', 'tax_rate', 
                'logo_path', 'favicon_path'
            ]);
        });
    }
};
