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
        // 1. Crear o actualizar usuario administrador
        User::firstOrCreate(
            ['email' => 'juancarloszg915@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('Youngrich0403$$'),
                'role' => 'admin',
            ]
        );

        // 2. Ejecutar catálogo de dispositivos y configuraciones de garantía
        $this->call(DeviceCatalogSeeder::class);

        // 3. Ejecutar plantillas de checklists por tipo de dispositivo
        $this->call(ChecklistSeeder::class);
    }
}
