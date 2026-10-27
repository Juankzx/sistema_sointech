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
                'category'    => 'Microsoldadura SMD',
                'title'       => 'Reparación de Placa Madre en Corto',
                'caption'     => 'Diagnóstico térmico y reemplazo de IC de carga bajo microscopio trinocular. Salvamos la placa original sin perder datos. 🔬⚡ #Microsoldadura #SoinTech',
                'url'         => 'https://www.instagram.com/soin_tech',
                'image'       => null,
                'asset_image' => '/images/landing/microsoldering.jpg',
                'theme'       => 'purple',
                'likes'       => '184',
                'date'        => 'Laboratorio · Destacado',
            ],
            [
                'category'    => 'Consolas · PS5 / Switch',
                'title'       => 'Puerto HDMI 2.1 PS5 + Metal Líquido',
                'caption'     => 'Recambio de conector HDMI 2.1 con reconstrucción de pistas y mantención térmica completa con metal líquido certificado. 🎮🔥 #PS5 #NintendoSwitch #Xbox',
                'url'         => 'https://www.instagram.com/soin_tech',
                'image'       => null,
                'asset_image' => '/images/landing/consoles.jpg',
                'theme'       => 'cyan',
                'likes'       => '246',
                'date'        => 'Gaming · Caso Real',
            ],
            [
                'category'    => 'Notebooks & Mac',
                'title'       => 'Mantención Pro + Upgrade SSD NVMe',
                'caption'     => 'Limpieza ultrasónica, thermal pads de alto rendimiento y clonación a SSD NVMe Gen4 para máximo desempeño. 💻🚀 #MacBook #NotebookGamer',
                'url'         => 'https://www.instagram.com/soin_tech',
                'image'       => null,
                'asset_image' => '/images/landing/notebooks.jpg',
                'theme'       => 'pink',
                'likes'       => '159',
                'date'        => 'Taller · Portátiles',
            ],
            [
                'category'    => 'iPhone & Smartphones',
                'title'       => 'Pantalla OLED Original & Carga Rápida',
                'caption'     => 'Cambio de módulo OLED con sellado original, batería nueva al 100% y reparación de línea USB-C / Lightning. 📱✨ #iPhoneService #Smartphones',
                'url'         => 'https://www.instagram.com/soin_tech',
                'image'       => null,
                'asset_image' => '/images/landing/mobile.jpg',
                'theme'       => 'blue',
                'likes'       => '198',
                'date'        => 'Laboratorio Móvil',
            ],
            [
                'category'    => 'Empresas & Soporte TI',
                'title'       => 'Soporte Corporativo, Redes & Servidores',
                'caption'     => 'Mantención preventiva de flotas de computadores, redes Wi-Fi empresariales, servidores Cloud y software POS/ERP. 🏢🌐 #SoporteTI #Empresas',
                'url'         => 'https://www.instagram.com/soin_tech',
                'image'       => null,
                'asset_image' => '/images/landing/b2b.jpg',
                'theme'       => 'emerald',
                'likes'       => '142',
                'date'        => 'División Empresas',
            ],
            [
                'category'    => 'Workstations & Rescate Datos',
                'title'       => 'Armado Workstation & Recuperación SSD',
                'caption'     => 'Ensamblaje profesional con refrigeración líquida ARGB, pruebas de estrés y rescate de información crítica. 🖥️💎 #Workstation #PCGaming',
                'url'         => 'https://www.instagram.com/soin_tech',
                'image'       => null,
                'asset_image' => '/images/landing/workstation.jpg',
                'theme'       => 'purple',
                'likes'       => '211',
                'date'        => 'Ingeniería & Datos',
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
