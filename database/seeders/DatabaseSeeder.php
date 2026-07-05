<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\WorkOrder;
use App\Models\Inventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeding standard users for testing roles
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@sointech.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $tecnico = User::create([
            'name' => 'Técnico de Servicio',
            'email' => 'tecnico@sointech.com',
            'password' => bcrypt('tecnico123'),
            'role' => 'tecnico',
        ]);

        $recepcionista = User::create([
            'name' => 'Recepcionista',
            'email' => 'recepcion@sointech.com',
            'password' => bcrypt('recepcion123'),
            'role' => 'recepcionista',
        ]);

        // Seed Clients
        $c1 = Client::create([
            'full_name' => 'Juan Pérez Silva',
            'rut_dni' => '18.456.789-0',
            'phone' => '+56987654321',
            'email' => 'juan.perez@gmail.com',
        ]);

        $c2 = Client::create([
            'full_name' => 'María Paz González',
            'rut_dni' => '15.321.654-K',
            'phone' => '+56912345678',
            'email' => 'maria.gonzalez@hotmail.com',
        ]);

        $c3 = Client::create([
            'full_name' => 'Carlos Muñoz Tapia',
            'rut_dni' => '19.876.543-2',
            'phone' => '+56955566677',
            'email' => 'carlos.munoz@yahoo.com',
        ]);

        $c4 = Client::create([
            'full_name' => 'Ana Luisa Vergara',
            'rut_dni' => '12.987.654-3',
            'phone' => '+56933344455',
            'email' => 'ana.vergara@gmail.com',
        ]);

        $c5 = Client::create([
            'full_name' => 'Roberto Rojas Soto',
            'rut_dni' => '16.789.012-4',
            'phone' => '+56999988877',
            'email' => 'roberto.rojas@outlook.com',
        ]);

        // Seed Work Orders
        WorkOrder::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'client_id' => $c1->id,
            'device_type' => 'Smartphone',
            'brand_model' => 'iPhone 14 Pro Max',
            'imei_serial' => '359281048291048',
            'reported_issue' => 'Pantalla rota y no carga batería',
            'unlock_password' => '04829',
            'status' => 'Ingresado',
            'labor_cost' => 120000.00,
            'down_payment' => 30000.00,
            'payment_method' => 'Efectivo',
            'terms_accepted' => true,
        ]);

        WorkOrder::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'client_id' => $c2->id,
            'device_type' => 'Notebook',
            'brand_model' => 'MacBook Air M2 2022',
            'imei_serial' => 'C02F9103Q05D',
            'reported_issue' => 'Teclado derramado con líquido cafe y algunas teclas no funcionan',
            'unlock_password' => 'maria2022',
            'status' => 'En Reparación',
            'labor_cost' => 180000.00,
            'down_payment' => 50000.00,
            'payment_method' => 'Transferencia',
            'terms_accepted' => true,
        ]);

        WorkOrder::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'client_id' => $c3->id,
            'device_type' => 'Console',
            'brand_model' => 'PlayStation 5 Slim',
            'imei_serial' => 'S01-492019482-P',
            'reported_issue' => 'Sobrecalentamiento al jugar y se apaga sola a los 15 minutos',
            'unlock_password' => null,
            'status' => 'Listo para Entrega',
            'labor_cost' => 65000.00,
            'down_payment' => 20000.00,
            'payment_method' => 'Tarjeta de Crédito',
            'terms_accepted' => true,
        ]);

        WorkOrder::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'client_id' => $c4->id,
            'device_type' => 'Tablet',
            'brand_model' => 'iPad Air 5th Gen',
            'imei_serial' => 'DMPF8194Q05F',
            'reported_issue' => 'Puerto de carga USB-C suelto',
            'unlock_password' => '9988',
            'status' => 'Entregado',
            'labor_cost' => 55000.00,
            'down_payment' => 15000.00,
            'payment_method' => 'Tarjeta de Débito',
            'terms_accepted' => true,
        ]);

        WorkOrder::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'client_id' => $c5->id,
            'device_type' => 'Smartphone',
            'brand_model' => 'Samsung Galaxy S23 Ultra',
            'imei_serial' => '358194059201948',
            'reported_issue' => 'Cámara trasera borrosa y vidrio de la cámara trizado',
            'unlock_password' => 'Patrón de Z',
            'status' => 'Ingresado',
            'labor_cost' => 95000.00,
            'down_payment' => 0.00,
            'payment_method' => 'Efectivo',
            'terms_accepted' => true,
        ]);

        WorkOrder::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'client_id' => $c1->id,
            'device_type' => 'Smartwatch',
            'brand_model' => 'Apple Watch Series 8',
            'imei_serial' => 'H92KD910F',
            'reported_issue' => 'Vidrio frontal quebrado, touch si funciona',
            'unlock_password' => '1212',
            'status' => 'En Reparación',
            'labor_cost' => 70000.00,
            'down_payment' => 20000.00,
            'payment_method' => 'Transferencia',
            'terms_accepted' => true,
        ]);

        WorkOrder::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'client_id' => $c2->id,
            'device_type' => 'Notebook',
            'brand_model' => 'Asus ROG Zephyrus G14',
            'imei_serial' => 'L9N0CX04928194A',
            'reported_issue' => 'Mantenimiento preventivo, cambio de metal líquido y limpieza de ventiladores',
            'unlock_password' => 'asus1234',
            'status' => 'Listo para Entrega',
            'labor_cost' => 45000.00,
            'down_payment' => 0.00,
            'payment_method' => 'Tarjeta de Débito',
            'terms_accepted' => true,
        ]);

        WorkOrder::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'client_id' => $c3->id,
            'device_type' => 'Smartphone',
            'brand_model' => 'Xiaomi Redmi Note 12 Pro',
            'imei_serial' => '869281048291047',
            'reported_issue' => 'No enciende, después de caída no da señales de vida',
            'unlock_password' => '0000',
            'status' => 'Entregado',
            'labor_cost' => 85000.00,
            'down_payment' => 10000.00,
            'payment_method' => 'Efectivo',
            'terms_accepted' => true,
        ]);

        // Seed Inventory
        Inventory::create([
            'category' => 'Pantallas',
            'name' => 'Pantalla iPhone 14 Pro Max OLED OEM',
            'stock' => 12,
            'cost_price' => 45000.00,
            'sale_price' => 95000.00,
        ]);

        Inventory::create([
            'category' => 'Baterías',
            'name' => 'Batería MacBook Air M2 A2681',
            'stock' => 3, // Low Stock (< 5)
            'cost_price' => 25000.00,
            'sale_price' => 55000.00,
        ]);

        Inventory::create([
            'category' => 'Conectores',
            'name' => 'Puerto de carga USB-C iPad Air 5',
            'stock' => 15,
            'cost_price' => 3000.00,
            'sale_price' => 15000.00,
        ]);

        Inventory::create([
            'category' => 'Ventiladores',
            'name' => 'Ventilador PlayStation 5 Slim Nidec',
            'stock' => 2, // Low Stock (< 5)
            'cost_price' => 8000.00,
            'sale_price' => 25000.00,
        ]);

        Inventory::create([
            'category' => 'Cámaras',
            'name' => 'Vidrio de Cámara Samsung S23 Ultra',
            'stock' => 25,
            'cost_price' => 1500.00,
            'sale_price' => 8000.00,
        ]);

        Inventory::create([
            'category' => 'Insumos',
            'name' => 'Pasta Térmica Thermal Grizzly Kryonaut',
            'stock' => 8,
            'cost_price' => 7500.00,
            'sale_price' => 14000.00,
        ]);

        $this->call(DeviceCatalogSeeder::class);
    }
}
