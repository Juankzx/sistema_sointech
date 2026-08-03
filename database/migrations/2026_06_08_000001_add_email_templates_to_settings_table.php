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
            $table->string('email_ot_subject')->nullable();
            $table->text('email_ot_body')->nullable();
            $table->string('email_low_stock_subject')->nullable();
            $table->text('email_low_stock_body')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'email_ot_subject',
                'email_ot_body',
                'email_low_stock_subject',
                'email_low_stock_body',
            ]);
        });
    }
};
