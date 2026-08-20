<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Smartphones
            ['name' => 'Cambio de Pantalla / Touch Screen', 'category' => 'smartphone', 'default_price' => 35000, 'description' => 'Reemplazo de módulo de pantalla y calibración táctil'],
            ['name' => 'Cambio de Batería', 'category' => 'smartphone', 'default_price' => 25000, 'description' => 'Sustitución de batería de alta calidad con prueba de carga'],
            ['name' => 'Mantenimiento por Humedad / Sulfato', 'category' => 'smartphone', 'default_price' => 30000, 'description' => 'Desoxidación por ultrasonido y secado químico de placa madre'],
            ['name' => 'Reparación de Puerto de Carga flex/Pin', 'category' => 'smartphone', 'default_price' => 25000, 'description' => 'Reemplazo o resoldado de zócalo/flex de carga'],
            ['name' => 'Micro-soldadura en Placa Smartphone', 'category' => 'smartphone', 'default_price' => 45000, 'description' => 'Reparación de líneas de alimentación, PMIC o circuitos integrados'],

            // Notebooks
            ['name' => 'Mantenimiento Térmico Completo + Pasta', 'category' => 'notebook', 'default_price' => 25000, 'description' => 'Limpieza interna, lubricación de fan y cambio de pasta térmica de alto rendimiento'],
            ['name' => 'Formateo + Instalación de SO y Softwares', 'category' => 'notebook', 'default_price' => 20000, 'description' => 'Instalación limpia de Windows/macOS, drivers, suite de oficina y utilitarios'],
            ['name' => 'Cambio de Pantalla / Display Notebook', 'category' => 'notebook', 'default_price' => 45000, 'description' => 'Instalación de pantalla LCD/LED con garantía'],
            ['name' => 'Reparación de Bisagras y Carcasa', 'category' => 'notebook', 'default_price' => 35000, 'description' => 'Reconstrucción de anclajes de bisagras y soldadura de plástico'],
            ['name' => 'Reparación Electrónica Placa Madre Notebook', 'category' => 'notebook', 'default_price' => 55000, 'description' => 'Diagnóstico y reparación de cortocircuitos en placa madre de laptop'],

            // Consolas
            ['name' => 'Limpieza Profunda + Cambio Pasta Térmica Consola', 'category' => 'console', 'default_price' => 30000, 'description' => 'Mantenimiento preventivo/correctivo para PlayStation, Xbox o Nintendo'],
            ['name' => 'Reemplazo de Puerto HDMI', 'category' => 'console', 'default_price' => 35000, 'description' => 'Desoldado y sustitución de puerto HDMI dañado en consola'],
            ['name' => 'Reparación de Fuente de Poder Consola', 'category' => 'console', 'default_price' => 40000, 'description' => 'Reparación de etapa de alimentación primaria/secundaria'],

            // General / Diagnósticos
            ['name' => 'Diagnóstico Electrónico Avanzado', 'category' => 'general', 'default_price' => 15000, 'description' => 'Evaluación detallada de fallas en laboratorio técnico'],
            ['name' => 'Respaldo y Recuperación de Información', 'category' => 'general', 'default_price' => 25000, 'description' => 'Extracción y respaldo seguro de archivos de usuario'],
        ];

        foreach ($services as $srv) {
            Service::updateOrCreate(
                ['name' => $srv['name']],
                $srv
            );
        }
    }
}
