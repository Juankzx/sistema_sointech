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
        Schema::table('sales', function (Blueprint $table) {
            $table->enum('document_type', ['ticket', 'boleta', 'factura'])->default('ticket')->after('uuid');
            $table->string('client_rut')->nullable()->after('client_phone');
            $table->string('client_business_activity')->nullable()->after('client_rut');
            $table->string('client_address')->nullable()->after('client_business_activity');
            $table->string('client_city')->nullable()->after('client_address');
            
            $table->integer('sii_document_number')->nullable()->after('cash_register_id');
            $table->string('sii_status')->nullable()->after('sii_document_number');
            $table->string('sii_xml_url')->nullable()->after('sii_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'document_type',
                'client_rut',
                'client_business_activity',
                'client_address',
                'client_city',
                'sii_document_number',
                'sii_status',
                'sii_xml_url'
            ]);
        });
    }
};
