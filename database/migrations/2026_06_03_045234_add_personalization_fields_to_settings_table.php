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
            $table->string('trade_name')->nullable()->after('company_name');
            $table->string('timezone')->default('America/Santiago')->after('currency');
            $table->string('support_email')->nullable()->after('sii_environment');
            $table->string('support_whatsapp')->nullable()->after('support_email');
            $table->string('social_instagram')->nullable()->after('support_whatsapp');
            $table->string('social_facebook')->nullable()->after('social_instagram');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'trade_name', 'timezone', 'support_email', 'support_whatsapp', 
                'social_instagram', 'social_facebook'
            ]);
        });
    }
};
