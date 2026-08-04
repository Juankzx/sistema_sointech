<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\DeviceCatalog;

class DeviceCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed default settings
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'warranty_text' => "Garantía de 90 días aplicable únicamente a la falla reparada y repuestos instalados. No cubre daños por golpes, líquidos/humedad, sellos rotos ni intervención de terceros. El cliente es responsable de su respaldo de datos. Las notificaciones vía WhatsApp/Email constituyen aviso formal. Tras 30 días del aviso se cobrará bodegaje; transcurridos 90 días corridos sin retiro ni respuesta, el equipo se declarará legalmente abandonado (Ley 19.496).",
                'checklist_templates' => [
                    'smartphone' => [
                        '¿Enciende?',
                        'Contacto con líquido',
                        'Táctil / Pantalla',
                        'Face ID / Touch ID',
                        'Cámaras (Frontal/Trasera)',
                        'Parlante / Auricular',
                        'Micrófono',
                        'Botones Físicos',
                        'Puerto de Carga',
                        'Wi-Fi y Bluetooth'
                    ],
                    'notebook' => [
                        '¿Enciende?',
                        'Contacto con líquido',
                        'Teclado Completo',
                        'Touchpad / Mouse',
                        'Pantalla / Display',
                        'Puertos USB / Conectores',
                        'Cargador y Batería',
                        'Wi-Fi y Red',
                        'Carcasa / Bisagras',
                        'Audio / Parlantes'
                    ],
                    'console' => [
                        '¿Enciende?',
                        'Contacto con líquido',
                        'Salida de Video HDMI',
                        'Lector de Discos / Lente',
                        'Conectividad Controles',
                        'Wi-Fi / Red Lan',
                        'Ventilador / Ruido',
                        'Puerto de Alimentación',
                        'Botón de Encendido / Eject'
                    ],
                    'tablet' => [
                        '¿Enciende?',
                        'Contacto con líquido',
                        'Táctil / Touch',
                        'Pantalla / Display',
                        'Cámaras (Front/Tras)',
                        'Botones de Volumen / Power',
                        'Batería / Carga',
                        'Wi-Fi y Bluetooth',
                        'Audio / Salida audífonos'
                    ],
                    'other' => [
                        '¿Enciende?',
                        'Contacto con líquido',
                        'Estado Estético General',
                        'Puertos de Entrada / Salida',
                        'Funcionamiento Principal'
                    ]
                ]
            ]
        );

        // 2. Seed default devices catalog
        $devices = [
            // Smartphones - Apple
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 11'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 11 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 11 Pro Max'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 12 Mini'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 12'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 12 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 12 Pro Max'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 13 Mini'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 13'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 13 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 13 Pro Max'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 14'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 14 Plus'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 14 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 14 Pro Max'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 15'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 15 Plus'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 15 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 15 Pro Max'],
            
            // Smartphones - Samsung
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S20'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S20 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S21'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S21 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S22'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S22 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S23'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S23 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S24'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S24 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A34 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A54 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A55 5G'],
            
            // Smartphones - Xiaomi
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Redmi Note 11'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Redmi Note 12 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Redmi Note 13 Pro 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Poco X5 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Poco X6 Pro'],
            
            // Consoles - Sony PlayStation
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 4 Fat'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 4 Slim'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 4 Pro'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 5 Fat (Lector)'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 5 Fat Digital'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 5 Slim (Lector)'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 5 Slim Digital'],
            
            // Consoles - Microsoft Xbox
            ['device_type' => 'console', 'brand' => 'Microsoft', 'model' => 'Xbox One S'],
            ['device_type' => 'console', 'brand' => 'Microsoft', 'model' => 'Xbox One X'],
            ['device_type' => 'console', 'brand' => 'Microsoft', 'model' => 'Xbox Series S'],
            ['device_type' => 'console', 'brand' => 'Microsoft', 'model' => 'Xbox Series X'],
            
            // Consoles - Nintendo
            ['device_type' => 'console', 'brand' => 'Nintendo', 'model' => 'Switch V1/V2'],
            ['device_type' => 'console', 'brand' => 'Nintendo', 'model' => 'Switch Lite'],
            ['device_type' => 'console', 'brand' => 'Nintendo', 'model' => 'Switch OLED'],
            
            // Notebooks - Apple MacBook
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Air M1 (2020)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Air M2 (2022)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Air M3 (2024)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 13" M1 (2020)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 14" M1 Pro (2021)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 14" M2 Pro (2023)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 14" M3 (2023)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 16" M1 Max (2021)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 16" M2 Max (2023)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 16" M3 Max (2023)'],
            
            // Notebooks - HP, Dell, Lenovo, Asus
            ['device_type' => 'notebook', 'brand' => 'HP', 'model' => 'Pavilion 15'],
            ['device_type' => 'notebook', 'brand' => 'HP', 'model' => 'ProBook 450'],
            ['device_type' => 'notebook', 'brand' => 'Dell', 'model' => 'Inspiron 15'],
            ['device_type' => 'notebook', 'brand' => 'Dell', 'model' => 'Latitude 3420'],
            ['device_type' => 'notebook', 'brand' => 'Dell', 'model' => 'XPS 13'],
            ['device_type' => 'notebook', 'brand' => 'Lenovo', 'model' => 'ThinkPad L14'],
            ['device_type' => 'notebook', 'brand' => 'Lenovo', 'model' => 'IdeaPad 3'],
            ['device_type' => 'notebook', 'brand' => 'Lenovo', 'model' => 'Legion 5 Pro'],
            ['device_type' => 'notebook', 'brand' => 'Asus', 'model' => 'ROG Zephyrus G14'],
            ['device_type' => 'notebook', 'brand' => 'Asus', 'model' => 'TUF Gaming A15'],
            ['device_type' => 'notebook', 'brand' => 'Asus', 'model' => 'ZenBook 14'],
            
            // Tablets - Apple iPad
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad 9th Gen (10.2")'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad 10th Gen (10.9")'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad Mini 6'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad Air 5 (M1)'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad Pro 11" M2'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad Pro 12.9" M2'],
            
            // Tablets - Samsung Galaxy Tab
            ['device_type' => 'tablet', 'brand' => 'Samsung', 'model' => 'Galaxy Tab A9'],
            ['device_type' => 'tablet', 'brand' => 'Samsung', 'model' => 'Galaxy Tab A9+'],
            ['device_type' => 'tablet', 'brand' => 'Samsung', 'model' => 'Galaxy Tab S9 FE'],
            ['device_type' => 'tablet', 'brand' => 'Samsung', 'model' => 'Galaxy Tab S9 Ultra'],
        ];

        foreach ($devices as $dev) {
            DeviceCatalog::firstOrCreate([
                'device_type' => $dev['device_type'],
                'brand' => $dev['brand'],
                'model' => $dev['model']
            ]);
        }
    }
}
