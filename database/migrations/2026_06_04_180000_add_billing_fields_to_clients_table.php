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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('rut_dni');
            $table->string('business_activity')->nullable()->after('company_name');
            $table->string('address')->nullable()->after('business_activity');
            $table->string('commune')->nullable()->after('address');
        });
        
        Schema::table('payments', function (Blueprint $table) {
            $table->string('document_type')->default('Ticket Interno')->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'business_activity', 'address', 'commune']);
        });
        
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('document_type');
        });
    }
};
