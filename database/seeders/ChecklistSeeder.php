<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = Setting::firstOrCreate(['id' => 1]);

        $checklists = [
            'smartphone' => [
                'Pantalla (Táctil y display)',
                'Cámara Frontal y Trasera',
                'Micrófono y Altavoz',
                'Puerto de Carga',
                'Botones Físicos (Volumen, Encendido)',
                'Señal Wi-Fi / Bluetooth',
                'Señal Red Móvil / SIM',
                'Sensores (Proximidad, Huella)',
                'Batería (Estado de carga)',
                'Carcasa (Rayones, golpes)',
            ],
            'notebook' => [
                'Pantalla (Píxeles muertos, manchas)',
                'Teclado (Prueba de teclas)',
                'Touchpad / Mouse',
                'Puertos USB / HDMI / Audio',
                'Batería y Cargador original',
                'Conexión Wi-Fi / Bluetooth',
                'Cámara Web y Micrófono',
                'Altavoces',
                'Bisagras y Carcasa general',
                'Arranque del Sistema Operativo',
            ],
            'console' => [
                'Lector de Discos (Si aplica)',
                'Puertos HDMI / USB / Alimentación',
                'Conexión a Internet (Wi-Fi/LAN)',
                'Sincronización de Controles',
                'Salida de Audio y Video',
                'Ventiladores y Temperatura',
                'Carcasa (Golpes, estado general)',
                'Almacenamiento Interno',
            ],
            'tablet' => [
                'Pantalla Táctil y Display',
                'Puerto de Carga',
                'Cámaras (Frontal y Trasera)',
                'Botones Físicos (Volumen, Power)',
                'Conexión Wi-Fi / Bluetooth',
                'Altavoces y Micrófono',
                'Batería (Estado visible)',
                'Carcasa y Biseles',
            ],
            'other' => [
                'Verificación de Encendido',
                'Estado Físico General (Golpes, daños)',
                'Cable de Corriente / Alimentación',
                'Puertos Principales',
                'Botones de Operación',
                'Accesorios o Componentes Extras',
            ],
        ];

        // Mantener ítems existentes si los hubiera y sólo fusionar, o simplemente reemplazar.
        // Como es un seeder inicial, podemos asignar directamente o hacer un merge.
        // Haremos un reemplazo para asegurar que estén los básicos,
        $rawTemplates = $settings->checklist_templates;
        $currentChecklists = is_string($rawTemplates) ? json_decode($rawTemplates, true) : $rawTemplates;
        if (!is_array($currentChecklists)) {
            $currentChecklists = [];
        }

        foreach ($checklists as $category => $items) {
            if (empty($currentChecklists[$category])) {
                $currentChecklists[$category] = $items;
            } else {
                // Agregar sólo los que no existan para evitar duplicados
                foreach ($items as $item) {
                    if (!in_array($item, $currentChecklists[$category])) {
                        $currentChecklists[$category][] = $item;
                    }
                }
            }
        }

        $settings->update([
            'checklist_templates' => $currentChecklists,
        ]);
        
        $this->command->info('Checklists de equipos sembrados exitosamente.');
    }
}
