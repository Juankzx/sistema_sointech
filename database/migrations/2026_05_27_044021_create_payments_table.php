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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_register_id')->constrained('cash_registers')->onDelete('cascade');
            $table->foreignId('work_order_id')->nullable()->constrained('work_orders')->onDelete('set null');
            $table->enum('type', ['income', 'expense'])->default('income');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('payment_method')->default('Efectivo'); // Efectivo, Tarjeta, Transferencia
            $table->string('description')->nullable(); // e.g. "Abono inicial", "Pago final", "Compra insumos"
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Who received the payment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
