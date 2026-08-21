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
            $table->boolean('whatsapp_enabled')->default(false)->after('notify_on_low_stock');
            $table->string('whatsapp_phone_number_id')->nullable()->after('whatsapp_enabled');
            $table->string('whatsapp_business_account_id')->nullable()->after('whatsapp_phone_number_id');
            $table->text('whatsapp_access_token')->nullable()->after('whatsapp_business_account_id');
            $table->string('whatsapp_template_name')->default('ot_status_update')->after('whatsapp_access_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp_enabled',
                'whatsapp_phone_number_id',
                'whatsapp_business_account_id',
                'whatsapp_access_token',
                'whatsapp_template_name'
            ]);
        });
    }
};
