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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('device_type');
            $table->string('brand_model');
            $table->string('imei_serial')->nullable();
            $table->text('reported_issue');
            $table->string('unlock_password')->nullable();
            $table->string('status')->default('Ingresado');
            $table->json('checklist')->nullable();
            $table->decimal('labor_cost', 10, 2)->default(0);
            $table->decimal('down_payment', 10, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->string('signature_path')->nullable();
            $table->boolean('terms_accepted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
