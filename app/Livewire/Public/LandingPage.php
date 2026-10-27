<?php

namespace App\Livewire\Public;

use App\Models\WorkOrder;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Schema;

class LandingPage extends Component
{
    public $searchQuery = '';
    public $searchError = '';

    // Contact/Quote form fields
    public $contact_name = '';
    public $contact_phone = '';
    public $contact_email = '';
    public $device_type = 'Servicio Técnico Computador / Notebook / Mac';
    public $issue_description = '';
    public $quoteSubmitted = false;

    protected $rules = [
        'contact_name'      => 'required|min:3|max:100',
        'contact_phone'     => 'required|min:8|max:20',
        'contact_email'     => 'nullable|email|max:100',
        'device_type'       => 'required',
        'issue_description' => 'required|min:10|max:1000',
    ];

    protected $messages = [
        'contact_name.required'      => 'Por favor ingresa tu nombre o razón social.',
        'contact_phone.required'     => 'Por favor ingresa un número de teléfono o WhatsApp de contacto.',
        'issue_description.required' => 'Por favor describe brevemente la falla del equipo o requerimiento.',
        'issue_description.min'      => 'La descripción debe tener al menos 10 caracteres.',
    ];

    public static function defaultInstagramPosts(): array
    {
        return [
            [
                'category' => 'Microsoldadura SMD',
                'title'    => 'Reparación de Placa Lógica en Corto',
                'caption'  => 'Diagnóstico con cámara térmica y microscopio trinocular: localizamos condensador en corto en línea principal y reemplazamos IC de carga sin cambiar la placa completa.',
                'url'      => 'https://www.instagram.com/sointech.cl',
                'image'    => null,
                'theme'    => 'purple',
                'likes'    => '148',
                'date'     => 'Destacado · Laboratorio',
            ],
            [
                'category' => 'Consolas · PS5 / Xbox',
                'title'    => 'Cambio de Puerto HDMI 2.1 + Metal Líquido PS5',
                'caption'  => 'Reemplazo de conector HDMI dañado con reconstrucción de pistas bajo microscopio y mantención térmica completa con redistribución de metal líquido.',
                'url'      => 'https://www.instagram.com/sointech.cl',
                'image'    => null,
                'theme'    => 'cyan',
                'likes'    => '215',
                'date'     => 'Caso Real · Gaming',
            ],
            [
                'category' => 'Notebooks & Mac',
                'title'    => 'Mantención Térmica & Upgrade SSD NVMe Gen4',
                'caption'  => 'Limpieza ultrasónica de disipadores, recambio de thermal pads profesionales, pasta térmica de alta conductividad y clonación de sistema a NVMe de alta velocidad.',
                'url'      => 'https://www.instagram.com/sointech.cl',
                'image'    => null,
                'theme'    => 'pink',
                'likes'    => '132',
                'date'     => 'Taller · Portátiles',
            ],
            [
                'category' => 'iPhone & Smartphones',
                'title'    => 'Cambio de Pantalla OLED & Recuperación de Carga',
                'caption'  => 'Instalación de pantalla con sellado contra polvo/humedad, reemplazo de batería certificada y reparación de línea de datos USB-C / Lightning.',
                'url'      => 'https://www.instagram.com/sointech.cl',
                'image'    => null,
                'theme'    => 'blue',
                'likes'    => '184',
                'date'     => 'Servicio Móvil',
            ],
            [
                'category' => 'Empresas & Soporte TI',
                'title'    => 'Mantención de Flota de Equipos & Redes Corporativas',
                'caption'  => 'Operativo preventivo para empresa: optimización de estaciones de trabajo, ordenamiento de rack de comunicaciones, respaldos automatizados y seguridad de red.',
                'url'      => 'https://www.instagram.com/sointech.cl',
                'image'    => null,
                'theme'    => 'emerald',
                'likes'    => '119',
                'date'     => 'División Empresas',
            ],
            [
                'category' => 'Software & Sistemas POS',
                'title'    => 'Implementación de Sistema de Gestión y Punto de Venta',
                'caption'  => 'Digitalización completa de operaciones: control de órdenes de trabajo, inventario en tiempo real, caja diaria, cotizaciones y avisos automáticos por WhatsApp.',
                'url'      => 'https://www.instagram.com/sointech.cl',
                'image'    => null,
                'theme'    => 'purple',
                'likes'    => '167',
                'date'     => 'Ingeniería Software',
            ],
        ];
    }

    public function searchOrder()
    {
        $this->searchError = '';
        $query = trim($this->searchQuery);

        if (empty($query)) {
            $this->searchError = 'Por favor ingresa un número de orden, código o documento.';
            return;
        }

        // Clean up common prefixes like "OT-", "#"
        $cleanQuery = preg_replace('/^(ot|orden|#|\-)+/i', '', $query);
        $cleanQuery = trim($cleanQuery);

        // Search in WorkOrder model:
        // 1. Exact or prefix match on UUID
        // 2. Exact match on ID
        // 3. Match via client phone or document number
        $workOrder = WorkOrder::where('uuid', $query)
            ->orWhere('uuid', 'like', $cleanQuery . '%')
            ->orWhere('id', $cleanQuery)
            ->orWhereHas('client', function ($q) use ($cleanQuery) {
                $q->where('phone', 'like', '%' . $cleanQuery . '%')
                  ->orWhere('rut_dni', 'like', '%' . $cleanQuery . '%');
            })
            ->latest()
            ->first();

        if ($workOrder) {
            return redirect()->route('work-orders.track', ['uuid' => $workOrder->uuid]);
        }

        $this->searchError = 'No encontramos ninguna orden activa con el código "' . e($query) . '". Verifica el código en tu comprobante o escríbenos por WhatsApp.';
    }

    public function sendQuoteRequest()
    {
        $this->validate();

        $this->quoteSubmitted = true;

        $this->reset(['contact_name', 'contact_phone', 'contact_email', 'issue_description']);
    }

    public function render()
    {
        $settings = null;
        if (Schema::hasTable('settings')) {
            $settings = Setting::first();
        }

        $instagramPosts = self::defaultInstagramPosts();
        if ($settings && is_array($settings->predictive_catalog) && !empty($settings->predictive_catalog['instagram_posts'])) {
            $instagramPosts = $settings->predictive_catalog['instagram_posts'];
        }

        return view('livewire.public.landing-page', [
            'settings'       => $settings,
            'instagramPosts' => $instagramPosts,
        ])->layout('layouts.public');
    }
}
