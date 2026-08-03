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
            'email' => 'juancarloszg915@gmail.com',
            'password' => bcrypt('Youngrich0403$$'),
            'role' => 'admin',
        ]);
        $this->call(DeviceCatalogSeeder::class);
    }
}
