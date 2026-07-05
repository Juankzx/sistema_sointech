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
        Schema::create('orden_trabajos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_ot')->unique();
            $table->string('tracking_token')->unique();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('marca_modelo');
            $table->string('imei_serie')->nullable();
            $table->text('falla_reportada');
            $table->string('contrasena_desbloqueo')->nullable();
            $table->string('tipo_dispositivo')->default('Smartphone');
            $table->string('estado')->default('Ingresado');
            $table->json('checklist')->nullable();
            $table->text('observaciones_esteticas')->nullable();
            $table->longText('firma_cliente')->nullable();
            $table->json('evidencia_antes')->nullable();
            $table->json('evidencia_despues')->nullable();
            $table->decimal('mano_obra', 10, 2)->default(0);
            $table->decimal('abono', 10, 2)->default(0);
            $table->string('metodo_pago')->nullable();
            $table->text('diagnostico_interno')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamp('fecha_ingreso')->useCurrent();
            $table->timestamp('fecha_entrega')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_trabajos');
    }
};
