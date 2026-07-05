<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('default_price', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('work_order_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
        });

        // Migrate existing labor_cost to work_order_services for backwards compatibility
        $workOrders = DB::table('work_orders')->where('labor_cost', '>', 0)->get();
        foreach ($workOrders as $wo) {
            DB::table('work_order_services')->insert([
                'work_order_id' => $wo->id,
                'service_id' => null,
                'name' => 'Mano de Obra (Migrado)',
                'price' => $wo->labor_cost,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('work_order_services');
        Schema::dropIfExists('services');
    }
};
