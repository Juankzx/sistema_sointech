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
                    'smartwatch' => [
                        '¿Enciende?',
                        'Contacto con líquido',
                        'Pantalla / Táctil',
                        'Batería / Carga',
                        'Correa / Broche',
                        'Sensores (Pulso / SpO2)',
                        'Bluetooth / Sincronización',
                        'Botones / Corona Digital',
                        'Vibración / Altavoz'
                    ],
                    'allinone' => [
                        '¿Enciende?',
                        'Contacto con líquido',
                        'Pantalla / Display',
                        'Webcam / Micrófono',
                        'Teclado y Mouse',
                        'Puertos USB / Alimentación',
                        'Wi-Fi / Bluetooth',
                        'Disco / Almacenamiento',
                        'Memoria RAM',
                        'Audio / Parlantes'
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
            // ==================== SMARTPHONES ====================
            // Apple iPhone
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 6'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 6 Plus'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 6s'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 6s Plus'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 7'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 7 Plus'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 8'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 8 Plus'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone X'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone XR'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone XS'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone XS Max'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone SE (1ª Gen)'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone SE (2ª Gen)'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone SE (3ª Gen)'],
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
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 16'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 16 Plus'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 16 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Apple', 'model' => 'iPhone 16 Pro Max'],

            // Samsung Galaxy - S Series
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S8 / S8+'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S9 / S9+'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S10 / S10+ / S10e'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S20 / S20+ / S20 FE'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S20 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S21 / S21+ / S21 FE'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S21 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S22 / S22+'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S22 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S23 / S23+ / S23 FE'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S23 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S24 / S24+'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy S24 Ultra'],
            
            // Samsung Galaxy - Z Series (Foldables)
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy Z Flip 3 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy Z Flip 4 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy Z Flip 5 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy Z Flip 6 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy Z Fold 3 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy Z Fold 4 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy Z Fold 5 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy Z Fold 6 5G'],

            // Samsung Galaxy - A Series
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A03 / A03s'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A04 / A04s / A04e'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A05 / A05s'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A12 / A13'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A14 5G / A15 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A22 / A23 / A24 / A25'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A32 / A33 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A34 5G / A35 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A52 / A52s 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A53 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A54 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A55 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy A72 / A73 5G'],

            // Samsung Galaxy - Note & M Series
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy Note 9 / Note 10+'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy Note 20 / Note 20 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Samsung', 'model' => 'Galaxy M14 5G / M34 5G / M54 5G'],

            // Xiaomi / Redmi / POCO
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Redmi Note 9 / Note 9 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Redmi Note 10 / Note 10 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Redmi Note 11 / Note 11S / Note 11 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Redmi Note 12 / Note 12 Pro 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Redmi Note 13 4G / Note 13 Pro 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Redmi Note 13 Pro+ 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Redmi 9A / 10C / 12 / 13C'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Poco X3 Pro / X3 NFC'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Poco X4 Pro 5G / X5 Pro 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Poco X6 / X6 Pro 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Poco F3 / F4 / F5 / F6 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Xiaomi 11T / 11T Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Xiaomi 12 / 12T / 13 / 13T Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Xiaomi', 'model' => 'Xiaomi 14 / 14 Ultra'],

            // Motorola
            ['device_type' => 'smartphone', 'brand' => 'Motorola', 'model' => 'Moto G8 / G9 Play / G9 Power'],
            ['device_type' => 'smartphone', 'brand' => 'Motorola', 'model' => 'Moto G20 / G22 / G30 / G31 / G32'],
            ['device_type' => 'smartphone', 'brand' => 'Motorola', 'model' => 'Moto G50 5G / G51 5G / G52'],
            ['device_type' => 'smartphone', 'brand' => 'Motorola', 'model' => 'Moto G53 5G / G54 5G / G84 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Motorola', 'model' => 'Moto G60 / G71 / G72 / G82'],
            ['device_type' => 'smartphone', 'brand' => 'Motorola', 'model' => 'Moto E7 / E13 / E20 / E32'],
            ['device_type' => 'smartphone', 'brand' => 'Motorola', 'model' => 'Moto Edge 20 Pro / Edge 30 Neo / Fusion'],
            ['device_type' => 'smartphone', 'brand' => 'Motorola', 'model' => 'Moto Edge 40 / Edge 40 Neo'],
            ['device_type' => 'smartphone', 'brand' => 'Motorola', 'model' => 'Moto Edge 50 Pro / Edge 50 Ultra'],
            ['device_type' => 'smartphone', 'brand' => 'Motorola', 'model' => 'Razr 40 / Razr 40 Ultra'],

            // Huawei & Honor
            ['device_type' => 'smartphone', 'brand' => 'Huawei', 'model' => 'P20 Lite / P30 Lite / P40 Lite'],
            ['device_type' => 'smartphone', 'brand' => 'Huawei', 'model' => 'P30 Pro / P40 Pro / P50 Pro / P60 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Huawei', 'model' => 'Y6 / Y7 / Y9 2019 / Y9 Prime'],
            ['device_type' => 'smartphone', 'brand' => 'Huawei', 'model' => 'Nova 5T / Nova 9 / Nova 10 / Nova 11i'],
            ['device_type' => 'smartphone', 'brand' => 'Honor', 'model' => 'Honor 50 / Honor 70 / Honor 90 / 90 Lite'],
            ['device_type' => 'smartphone', 'brand' => 'Honor', 'model' => 'Honor Magic 5 Pro / Magic 6 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Honor', 'model' => 'Honor X7a / X8a / X9a 5G'],

            // Google Pixel, OPPO, Realme, Vivo
            ['device_type' => 'smartphone', 'brand' => 'Google', 'model' => 'Pixel 6 / 6a / 6 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Google', 'model' => 'Pixel 7 / 7a / 7 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'Google', 'model' => 'Pixel 8 / 8a / 8 Pro / Pixel 9 Pro'],
            ['device_type' => 'smartphone', 'brand' => 'OPPO', 'model' => 'A54 / A57 / A78 / Reno 7 / Reno 10 5G'],
            ['device_type' => 'smartphone', 'brand' => 'Realme', 'model' => 'Realme 8 / 9 Pro+ / 11 Pro+ 5G / C55 / C67'],
            ['device_type' => 'smartphone', 'brand' => 'Vivo', 'model' => 'Vivo Y20 / V25 / V29 5G / V30 5G'],

            // ==================== SMARTWATCHES ====================
            // Apple Watch
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch Series 3 (38mm/42mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch Series 4 (40mm/44mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch Series 5 (40mm/44mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch Series 6 (40mm/44mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch SE 1ª Gen (40mm/44mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch Series 7 (41mm/45mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch Series 8 (41mm/45mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch SE 2ª Gen (40mm/44mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch Series 9 (41mm/45mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch Series 10 (42mm/46mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch Ultra (49mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Apple', 'model' => 'Apple Watch Ultra 2 (49mm)'],

            // Samsung Galaxy Watch
            ['device_type' => 'smartwatch', 'brand' => 'Samsung', 'model' => 'Galaxy Watch Active 2'],
            ['device_type' => 'smartwatch', 'brand' => 'Samsung', 'model' => 'Galaxy Watch 3 (41mm/45mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Samsung', 'model' => 'Galaxy Watch 4 (40mm/44mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Samsung', 'model' => 'Galaxy Watch 4 Classic (42mm/46mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Samsung', 'model' => 'Galaxy Watch 5 (40mm/44mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Samsung', 'model' => 'Galaxy Watch 5 Pro (45mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Samsung', 'model' => 'Galaxy Watch 6 (40mm/44mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Samsung', 'model' => 'Galaxy Watch 6 Classic (43mm/47mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Samsung', 'model' => 'Galaxy Watch 7 (40mm/44mm)'],
            ['device_type' => 'smartwatch', 'brand' => 'Samsung', 'model' => 'Galaxy Watch Ultra (47mm)'],

            // Xiaomi, Huawei, Garmin, Amazfit
            ['device_type' => 'smartwatch', 'brand' => 'Xiaomi', 'model' => 'Smart Band 6 / 7 / 8 / 9'],
            ['device_type' => 'smartwatch', 'brand' => 'Xiaomi', 'model' => 'Watch S1 / S3 / Redmi Watch 3 / 4'],
            ['device_type' => 'smartwatch', 'brand' => 'Huawei', 'model' => 'Watch GT 2 / GT 3 / GT 3 Pro / GT 4'],
            ['device_type' => 'smartwatch', 'brand' => 'Huawei', 'model' => 'Watch FIT / FIT 2 / FIT 3 / Band 8 / 9'],
            ['device_type' => 'smartwatch', 'brand' => 'Garmin', 'model' => 'Forerunner 55 / 245 / 265 / 965'],
            ['device_type' => 'smartwatch', 'brand' => 'Garmin', 'model' => 'Fenix 6 / 7 / Venu 2 / 3 / Instinct 2'],
            ['device_type' => 'smartwatch', 'brand' => 'Amazfit', 'model' => 'GTS 2 / 3 / 4 / GTR 3 / 4 / Bip 5 / T-Rex 2'],
            ['device_type' => 'smartwatch', 'brand' => 'Fitbit', 'model' => 'Charge 5 / Charge 6 / Versa 3 / Versa 4 / Sense 2'],

            // ==================== TODO EN UNO (ALL-IN-ONE) ====================
            ['device_type' => 'allinone', 'brand' => 'Apple', 'model' => 'iMac 21.5" Retina 4K (2017/2019)'],
            ['device_type' => 'allinone', 'brand' => 'Apple', 'model' => 'iMac 27" Retina 5K (2017/2019/2020)'],
            ['device_type' => 'allinone', 'brand' => 'Apple', 'model' => 'iMac 24" M1 (2021)'],
            ['device_type' => 'allinone', 'brand' => 'Apple', 'model' => 'iMac 24" M3 (2023)'],
            ['device_type' => 'allinone', 'brand' => 'HP', 'model' => 'Pavilion All-in-One 24" / 27"'],
            ['device_type' => 'allinone', 'brand' => 'HP', 'model' => 'HP 22 / 24 All-in-One'],
            ['device_type' => 'allinone', 'brand' => 'HP', 'model' => 'Envy All-in-One 32"'],
            ['device_type' => 'allinone', 'brand' => 'Lenovo', 'model' => 'IdeaCentre AIO 3 / AIO 5 / AIO 5i'],
            ['device_type' => 'allinone', 'brand' => 'Lenovo', 'model' => 'Yoga AIO 7 / ThinkCentre Neo 30a AIO'],
            ['device_type' => 'allinone', 'brand' => 'Dell', 'model' => 'Inspiron 24 5000 AIO / 27 7000 AIO'],
            ['device_type' => 'allinone', 'brand' => 'Dell', 'model' => 'OptiPlex 7400 All-in-One'],
            ['device_type' => 'allinone', 'brand' => 'Asus', 'model' => 'Asus AIO A5401 / Vivo AiO V241'],
            ['device_type' => 'allinone', 'brand' => 'Acer', 'model' => 'Aspire C24 / Aspire C27 All-in-One'],

            // ==================== CONSOLES ====================
            // Sony PlayStation
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 3 Fat / Slim / Super Slim'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 4 Fat'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 4 Slim'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 4 Pro'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 5 Fat (Lector)'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 5 Fat Digital'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 5 Slim (Lector)'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 5 Slim Digital'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation 5 Pro'],
            ['device_type' => 'console', 'brand' => 'Sony', 'model' => 'PlayStation Portal'],

            // Microsoft Xbox
            ['device_type' => 'console', 'brand' => 'Microsoft', 'model' => 'Xbox 360 Slim / E'],
            ['device_type' => 'console', 'brand' => 'Microsoft', 'model' => 'Xbox One Fat / One S / One X'],
            ['device_type' => 'console', 'brand' => 'Microsoft', 'model' => 'Xbox Series S'],
            ['device_type' => 'console', 'brand' => 'Microsoft', 'model' => 'Xbox Series X'],

            // Nintendo & Handhelds
            ['device_type' => 'console', 'brand' => 'Nintendo', 'model' => 'Switch V1 / V2'],
            ['device_type' => 'console', 'brand' => 'Nintendo', 'model' => 'Switch Lite'],
            ['device_type' => 'console', 'brand' => 'Nintendo', 'model' => 'Switch OLED'],
            ['device_type' => 'console', 'brand' => 'Nintendo', 'model' => '3DS / 3DS XL / 2DS'],
            ['device_type' => 'console', 'brand' => 'Valve', 'model' => 'Steam Deck LCD / OLED'],
            ['device_type' => 'console', 'brand' => 'Asus', 'model' => 'ROG Ally / ROG Ally X'],
            ['device_type' => 'console', 'brand' => 'Lenovo', 'model' => 'Legion Go'],

            // ==================== NOTEBOOKS ====================
            // Apple MacBook
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Air 13" (2017-2020 Intel)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Air 13" M1 (2020)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Air 13" M2 (2022)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Air 15" M2 (2023)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Air 13" M3 (2024)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Air 15" M3 (2024)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 13" (2017-2020 Intel)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 13" M1 / M2'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 14" M1 Pro / Max (2021)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 16" M1 Pro / Max (2021)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 14" M2 Pro / Max (2023)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 16" M2 Pro / Max (2023)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 14" M3 / Pro / Max (2023)'],
            ['device_type' => 'notebook', 'brand' => 'Apple', 'model' => 'MacBook Pro 16" M3 Pro / Max (2023)'],

            // Notebooks - HP, Dell, Lenovo, Asus, Acer, MSI
            ['device_type' => 'notebook', 'brand' => 'HP', 'model' => 'Pavilion 14 / 15'],
            ['device_type' => 'notebook', 'brand' => 'HP', 'model' => 'ProBook 440 / 450 G8 / G9 / G10'],
            ['device_type' => 'notebook', 'brand' => 'HP', 'model' => 'EliteBook 840 / 850 G7 / G8 / G9'],
            ['device_type' => 'notebook', 'brand' => 'HP', 'model' => 'Omen 16 / Victus 15 / 16'],
            ['device_type' => 'notebook', 'brand' => 'HP', 'model' => 'Envy 13 / 15 / x360'],
            ['device_type' => 'notebook', 'brand' => 'Dell', 'model' => 'Inspiron 14 / 15 3000 / 5000'],
            ['device_type' => 'notebook', 'brand' => 'Dell', 'model' => 'Latitude 3420 / 3520 / 5420 / 5520'],
            ['device_type' => 'notebook', 'brand' => 'Dell', 'model' => 'XPS 13 / XPS 15 / XPS 17'],
            ['device_type' => 'notebook', 'brand' => 'Dell', 'model' => 'Alienware m15 / m16 / x14'],
            ['device_type' => 'notebook', 'brand' => 'Lenovo', 'model' => 'ThinkPad E14 / E15 / L14 / T14 / X1 Carbon'],
            ['device_type' => 'notebook', 'brand' => 'Lenovo', 'model' => 'IdeaPad 1 / 3 / 5 / Flex 5'],
            ['device_type' => 'notebook', 'brand' => 'Lenovo', 'model' => 'Legion 5 / 5 Pro / 7 / Slim 5'],
            ['device_type' => 'notebook', 'brand' => 'Lenovo', 'model' => 'Yoga 7i / 9i / Slim 7'],
            ['device_type' => 'notebook', 'brand' => 'Asus', 'model' => 'ROG Zephyrus G14 / G16 / Strix G16'],
            ['device_type' => 'notebook', 'brand' => 'Asus', 'model' => 'TUF Gaming A15 / F15 / A16'],
            ['device_type' => 'notebook', 'brand' => 'Asus', 'model' => 'ZenBook 13 / 14 / 15 / VivoBook 14 / 15'],
            ['device_type' => 'notebook', 'brand' => 'Acer', 'model' => 'Aspire 3 / 5 / 7 / Nitro 5 / 16'],
            ['device_type' => 'notebook', 'brand' => 'Acer', 'model' => 'Swift 3 / Swift Go / Predator Helios 300'],

            // ==================== TABLETS ====================
            // Apple iPad
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad 7ª Gen (10.2")'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad 8ª Gen (10.2")'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad 9ª Gen (10.2")'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad 10ª Gen (10.9")'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad Mini 5 / Mini 6'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad Air 4 / Air 5 (M1) / Air 11" (M2)'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad Pro 11" M1 / M2 / M4'],
            ['device_type' => 'tablet', 'brand' => 'Apple', 'model' => 'iPad Pro 12.9" M1 / M2 / 13" M4'],

            // Samsung Galaxy Tab & Others
            ['device_type' => 'tablet', 'brand' => 'Samsung', 'model' => 'Galaxy Tab A7 / A8 / A9 / A9+'],
            ['device_type' => 'tablet', 'brand' => 'Samsung', 'model' => 'Galaxy Tab S6 Lite / S7 / S7 FE'],
            ['device_type' => 'tablet', 'brand' => 'Samsung', 'model' => 'Galaxy Tab S8 / S8+ / S8 Ultra'],
            ['device_type' => 'tablet', 'brand' => 'Samsung', 'model' => 'Galaxy Tab S9 / S9 FE / S9 Ultra'],
            ['device_type' => 'tablet', 'brand' => 'Xiaomi', 'model' => 'Xiaomi Pad 5 / Pad 6 / Redmi Pad / Pad SE'],
            ['device_type' => 'tablet', 'brand' => 'Lenovo', 'model' => 'Lenovo Tab M10 / Tab P11 / Tab P12'],
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
