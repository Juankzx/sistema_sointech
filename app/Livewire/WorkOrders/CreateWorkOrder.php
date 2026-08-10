<?php

namespace App\Livewire\WorkOrders;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Client;
use App\Models\Inventory;
use App\Models\WorkOrder;
use App\Models\WorkOrderImage;
use App\Services\ImageOptimizer;
use App\Models\Setting;
use App\Models\DeviceCatalog;
use Illuminate\Support\Str;

class CreateWorkOrder extends Component
{
    use WithFileUploads;

    // Client data
    public $client_id = null;
    public $full_name;
    public $rut_dni;
    public $phone;
    public $email;
    public $client_selected = false;
    public $client_editing = false;

    // Device data
    public $device_type = 'smartphone';
    public $brand_model;
    public $imei_serial;
    public $reported_issue;
    public $unlock_password;
    public $estimated_delivery;

    // Checklist Configurations
    public $checklist_templates = [];
    public $checklist_values = []; // dynamic checklist state [ 'Item' => true/false ]
    public $turns_on = true;
    public $liquid_contact = 'No';
    public $aesthetic_notes;
    public $initialPhotos = []; // for multiple file uploads

    public function updatedInitialPhotos()
    {
        if (is_array($this->initialPhotos)) {
            $this->initialPhotos = array_values(array_filter($this->initialPhotos, function ($file) {
                return $file && (is_string($file) || method_exists($file, 'getRealPath') || method_exists($file, 'temporaryUrl'));
            }));
        }

        $this->validate([
            'initialPhotos.*' => 'nullable|file|max:30720',
        ], [
            'initialPhotos.*.file' => 'Uno de los archivos seleccionados no es válido.',
            'initialPhotos.*.max' => 'Una de las imágenes supera los 30 MB máximos.',
            'initialPhotos.*.uploaded' => 'No se pudo subir una de las fotos. Verifica que no supere los 30 MB.',
        ]);
    }

    public function removeInitialPhoto($index)
    {
        if (isset($this->initialPhotos[$index])) {
            unset($this->initialPhotos[$index]);
            $this->initialPhotos = array_values($this->initialPhotos);
        }
    }

    // Finances
    public $budget_type = 'fixed'; // 'fixed' or 'pending' (Solo Diagnóstico)
    public $labor_cost = 0;
    public $down_payment = 0;
    public $payment_method = 'Efectivo';
    public $selected_parts = []; // array of ['id', 'name', 'sale_price', 'quantity']

    // Legal & Images
    public $terms_accepted = false;
    public $signature_base64; // from canvas
    public $signature_token = null; // token for mobile signing session
    public $kiosk_mode = false;     // Kiosk client mode overlay control

    // ---------- COMPONENTES DE PC DE TORRE ----------
    public $components = [];

    // Validation rules for components (optional)
    protected $rules = [
        // existing rules will be merged with component validation below
        'components.*.component_type' => 'required|in:cpu,gpu,ram,storage,psu,case,motherboard,cooler,mouse,keyboard,other',
        'components.*.brand' => 'nullable|string',
        'components.*.model' => 'nullable|string',
        'components.*.serial_number' => 'nullable|string',
        'components.*.remarks' => 'nullable|string',
    ];

    public $initial_status = 'Ingresado';

    // Search Suggestions arrays
    public $searchClient = '';
    public $searchPart = '';
    public $foundClients = [];
    public $foundParts = [];
    public $foundDevices = []; // predictive models

    // Success State Modal
    public $show_success_modal = false;
    public $created_order_uuid = null;
    public $created_order_id = null;

    public function mount()
    {
        // Cargar checklists desde settings configurados en base de datos
        $settings = Setting::find(1);
        if ($settings) {
            $this->checklist_templates = $settings->checklist_templates ?? [];
        }

        $this->updatedDeviceType();
    }

    public function updatedDeviceType()
    {
        // Reconstruir checklist dinámico basado en la base de datos
        $this->checklist_values = [];
        $items = $this->checklist_templates[$this->device_type] ?? [];
        foreach ($items as $item) {
            // Inicializar todos los chequeos como correctos (true) por facilidad
            $this->checklist_values[$item] = true;
        }

        // Limpiar el campo de marca y modelo y autocompletados
        $this->brand_model = '';
        $this->foundDevices = [];
    }

    public function addQuickTag($tag)
    {
        if (empty(trim($this->reported_issue))) {
            $this->reported_issue = $tag;
        } else {
            if (!str_contains($this->reported_issue, $tag)) {
                $this->reported_issue = rtrim($this->reported_issue, ' .,') . ', ' . $tag;
            }
        }
    }

    public function getQuickTagsProperty()
    {
        return match ($this->device_type) {
            'smartphone', 'tablet' => [
                '📱 Pantalla Rota / Táctil',
                '🔋 Batería no rinde / Hinchada',
                '⚡ No enciende / Apagado',
                '🔌 Conector de Carga suelto',
                '📷 Cámara / Cristal dañado',
                '💧 Mojado / Contacto Líquido',
                '🔊 Sin Sonido / Parlante',
            ],
            'notebook', 'desktop' => [
                '💻 Formateo + Sistema Operativo',
                '🧹 Mantenimiento + Pasta Térmica',
                '💾 Cambio SSD / Sin Disco',
                '🧠 Ampliación Memoria RAM',
                '⚡ No enciende / Sin Video',
                '🔋 Batería / Cargador dañado',
                '🖥️ Pantalla / Bisagra rota',
            ],
            'console' => [
                '🎮 Mantenimiento + Limpieza',
                '🔌 Puerto HDMI / Sin Video',
                '🔥 Sobrecalentamiento / Apagón',
                '🕹️ Drift en Mandos / Joysticks',
                '💿 Lector de Discos / No lee',
            ],
            default => [
                '⚙️ Mantenimiento General',
                '⚡ No enciende',
                '🔌 Falla de Alimentación',
                '🔍 Diagnóstico / Revisión',
            ],
        };
    }

    public function updatedBrandModel()
    {
        if (strlen($this->brand_model) > 1) {
            $this->foundDevices = DeviceCatalog::where('device_type', $this->device_type)
                ->where(function ($q) {
                    $q->where('brand', 'like', '%' . $this->brand_model . '%')
                        ->orWhere('model', 'like', '%' . $this->brand_model . '%');
                })
                ->take(5)
                ->get();
        } else {
            $this->foundDevices = [];
        }
    }

    public function selectDevice($brand, $model)
    {
        $this->brand_model = $brand . ' ' . $model;
        $this->foundDevices = [];
    }

    public function updatedSearchClient()
    {
        if (strlen($this->searchClient) >= 1) {
            $this->foundClients = Client::where('full_name', 'like', '%' . $this->searchClient . '%')
                ->orWhere('rut_dni', 'like', '%' . $this->searchClient . '%')
                ->orWhere('phone', 'like', '%' . $this->searchClient . '%')
                ->take(6)->get();
        } else {
            $this->foundClients = [];
        }
    }


    public function selectClient($id)
    {
        $client = Client::find($id);
        if ($client) {
            $this->client_id = $client->id;
            $this->full_name = $client->full_name;
            $this->rut_dni = $client->rut_dni;
            $this->phone = $client->phone;
            $this->email = $client->email;
            $this->searchClient = '';
            $this->foundClients = [];
            $this->client_selected = true;
            $this->client_editing = false;
        }
    }

    public function toggleClientEditing()
    {
        $this->client_editing = !$this->client_editing;
    }

    public function clearClientSelection()
    {
        $this->client_id = null;
        $this->full_name = '';
        $this->phone = '';
        $this->rut_dni = '';
        $this->email = '';
        $this->client_selected = false;
        $this->client_editing = false;
        $this->searchClient = '';
        $this->foundClients = [];
    }

    public function updatedInitialStatus($value)
    {
        if ($value === 'Aprobado') {
            $this->budget_type = 'fixed';
        } elseif (in_array($value, ['Ingresado', 'En Revisión'])) {
            $this->budget_type = 'pending';
            $this->labor_cost = 0;
            $this->down_payment = 0;
            $this->selected_parts = [];
        } elseif ($value === 'Garantía') {
            $this->budget_type = 'fixed';
            $this->labor_cost = 0;
            $this->down_payment = 0;
            $this->selected_parts = [];
        }
    }

    public function updatedBudgetType($value)
    {
        if ($value === 'pending') {
            $this->labor_cost = 0;
            $this->down_payment = 0;
            $this->selected_parts = [];
            if ($this->initial_status === 'Aprobado') {
                $this->initial_status = 'Ingresado';
            }
        } elseif ($value === 'fixed') {
            if (in_array($this->initial_status, ['Ingresado', 'En Revisión'])) {
                $this->initial_status = 'Aprobado';
            }
        }
    }



    public function updatedSearchPart()
    {
        if (strlen($this->searchPart) >= 1) {
            $this->foundParts = Inventory::where('name', 'like', '%' . $this->searchPart . '%')
                ->orWhere('category', 'like', '%' . $this->searchPart . '%')
                ->take(6)->get();
        } else {
            $this->foundParts = [];
        }
    }


    public function addPart($id)
    {
        $part = Inventory::find($id);
        if ($part && $part->stock > 0) {
            $this->selected_parts[] = [
                'id' => $part->id,
                'name' => $part->name,
                'sale_price' => $part->sale_price,
                'quantity' => 1
            ];
            $this->searchPart = '';
            $this->foundParts = [];
        }
    }

    public function removePart($index)
    {
        unset($this->selected_parts[$index]);
        $this->selected_parts = array_values($this->selected_parts);
    }

    public function addComponent()
    {
        $this->components[] = [
            'type' => 'cpu',
            'brand' => '',
            'model' => '',
            'serial_number' => ''
        ];
    }

    public function removeComponent($index)
    {
        unset($this->components[$index]);
        $this->components = array_values($this->components);
    }

    public function getTotalProperty()
    {
        if ($this->budget_type === 'pending') {
            return 0;
        }
        $totalParts = collect($this->selected_parts)->sum(function ($part) {
            return $part['sale_price'] * $part['quantity'];
        });
        return $totalParts + (float) $this->labor_cost;
    }

    public function getBalanceProperty()
    {
        if ($this->budget_type === 'pending') {
            return 0;
        }
        return $this->getTotalProperty() - (float) $this->down_payment;
    }

    public function save()
    {
        $this->validate([
            'full_name' => 'required|string',
            'phone' => 'required|string',
            'device_type' => 'required|string',
            'brand_model' => 'required|string',
            'reported_issue' => 'required|string',
            'terms_accepted' => 'accepted',
            'signature_base64' => 'nullable|string',
            'components.*.type' => 'required|in:cpu,gpu,ram,storage,psu,case,motherboard,cooler,mouse,keyboard,other',
            'initialPhotos.*' => 'nullable|file|max:30720',
        ], [
            'initialPhotos.*.file' => 'Una de las fotos adjuntas no es válida o falló al subirse.',
            'initialPhotos.*.max' => 'Una de las fotos supera el tamaño máximo permitido (30 MB).',
            'initialPhotos.*.uploaded' => 'No se pudo subir una de las fotos. Verifica su formato y tamaño.',
        ]);

        // Guardar o Actualizar Cliente
        if ($this->client_id) {
            $client = Client::find($this->client_id);
            if ($client) {
                $client->update([
                    'full_name' => $this->full_name,
                    'rut_dni' => $this->rut_dni,
                    'email' => $this->email,
                    'phone' => $this->phone,
                ]);
            }
        } else {
            $client = Client::updateOrCreate(
                ['phone' => $this->phone],
                [
                    'full_name' => $this->full_name,
                    'rut_dni' => $this->rut_dni,
                    'email' => $this->email,
                ]
            );
        }

        // Guardar firma como archivo
        $signatureName = null;
        if ($this->signature_base64) {
            $image_parts = explode(";base64,", $this->signature_base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $signatureName = 'signatures/' . uniqid() . '.' . $image_type;

            $publicPath = storage_path('app/public/signatures');
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            file_put_contents(storage_path('app/public/' . $signatureName), $image_base64);
        }

        // Construir JSON del Checklist Dinámico
        $checklist = [
            'turns_on' => $this->turns_on,
            'liquid_contact' => $this->liquid_contact,
            'aesthetic_notes' => $this->aesthetic_notes,
            'features' => $this->checklist_values // Dynamic checklists populated from database
        ];

        // Costos finales dependen del tipo de presupuesto
        $finalLaborCost = $this->budget_type === 'pending' ? 0 : $this->labor_cost;
        $finalDownPayment = $this->budget_type === 'pending' ? 0 : $this->down_payment;

        // Validar que haya caja abierta si hay abono
        $activeRegister = \App\Models\CashRegister::where('status', 'open')
            ->whereDate('opened_at', \Carbon\Carbon::today())
            ->first();

        if ($finalDownPayment > 0 && !$activeRegister) {
            session()->flash('error', 'No puedes registrar un abono porque no hay una caja abierta para hoy. Abre la caja primero en el panel de Caja Diaria.');
            return;
        }

        // Crear OT
        $workOrder = WorkOrder::create([
            'uuid' => (string) Str::uuid(),
            'client_id' => $client->id,
            'received_by_user_id' => auth()->id(),
            'device_type' => $this->device_type,
            'brand_model' => $this->brand_model,
            'imei_serial' => $this->imei_serial,
            'reported_issue' => $this->reported_issue,
            'unlock_password' => $this->unlock_password,
            'status' => $this->initial_status,
            'checklist' => $checklist,
            'labor_cost' => $finalLaborCost,
            'down_payment' => $finalDownPayment,
            'payment_method' => $this->payment_method,
            'signature_path' => $signatureName,
            'terms_accepted' => $this->terms_accepted,
            'estimated_delivery' => $this->estimated_delivery,
        ]);

        // Registrar componentes de PC si existen
        if (in_array($this->device_type, ['desktop', 'notebook', 'other']) && !empty($this->components)) {
            foreach ($this->components as $comp) {
                \App\Models\WorkOrderComponent::create([
                    'work_order_id' => $workOrder->id,
                    'component_type' => $comp['type'],
                    'brand' => $comp['brand'] ?? null,
                    'model' => $comp['model'] ?? null,
                    'serial_number' => $comp['serial_number'] ?? null,
                ]);
            }
        }

        // Guardar fotos del estado inicial
        if (!empty($this->initialPhotos)) {
            foreach ($this->initialPhotos as $photo) {
                $path = ImageOptimizer::optimizeAndStore($photo, 'work_order_images');
                WorkOrderImage::create([
                    'work_order_id' => $workOrder->id,
                    'image_path' => $path,
                    'type' => 'before'
                ]);
            }
        }

        // Registrar pago en caja si hay abono
        if ($finalDownPayment > 0 && $activeRegister) {
            \App\Models\Payment::create([
                'cash_register_id' => $activeRegister->id,
                'work_order_id' => $workOrder->id,
                'type' => 'income',
                'amount' => $finalDownPayment,
                'payment_method' => $this->payment_method,
                'description' => 'Abono inicial OT #' . substr($workOrder->uuid, 0, 8),
                'user_id' => auth()->id(),
            ]);
        }

        // Registrar bitácora inicial adaptativa
        $statusNotes = 'El dispositivo ha sido recibido en recepción, se encuentra registrado formalmente y está en cola para diagnóstico técnico.';
        $statusTitle = 'Ingreso de Equipo';

        if ($this->budget_type === 'pending') {
            $statusNotes .= ' Equipo ingresado con Presupuesto por Evaluar (Revisión de placa o limpieza requerida).';
        }

        if ($this->initial_status === 'En Revisión') {
            $statusTitle = 'Ingreso Directo a Revisión';
            $statusNotes = 'El dispositivo ha sido recibido en recepción e ingresado directamente a revisión para su diagnóstico técnico inmediato.';
        } elseif ($this->initial_status === 'Aprobado') {
            $statusTitle = 'Aprobación en Recepción';
            $statusNotes = 'El cliente ha aceptado el presupuesto fijo en mostrador. El equipo pasa directamente a taller para iniciar la reparación.';
        } elseif ($this->initial_status === 'Garantía') {
            $statusTitle = 'Ingreso por Garantía';
            $statusNotes = 'El dispositivo ha reingresado al taller bajo concepto de revisión por garantía. Pasa directo a mesa técnica para evaluar las condiciones y validez de la misma.';
        }

        $workOrder->logs()->create([
            'status' => $this->initial_status,
            'title' => $statusTitle,
            'notes' => $statusNotes,
            'user_id' => auth()->id(),
        ]);

        // Asociar Repuestos a la OT
        if ($this->budget_type !== 'pending') {
            foreach ($this->selected_parts as $part) {
                $workOrder->parts()->attach($part['id'], [
                    'quantity' => $part['quantity'],
                    'price_at_time' => $part['sale_price']
                ]);

                // Descontar del stock de inventario
                $inv = Inventory::find($part['id']);
                if ($inv) {
                    $inv->decrement('stock', (int)$part['quantity']);

                    // Alerta de stock bajo al Administrador
                    if ($inv->stock <= $inv->min_stock) {
                        $settings = \App\Models\Setting::find(1);
                        $adminEmail = $settings?->support_email ?: auth()->user()->email;
                        if ((!$settings || $settings->notify_on_low_stock) && $adminEmail) {
                            try {
                                \App\Services\MailService::configureSmtp();
                                \Illuminate\Support\Facades\Mail::to($adminEmail)
                                    ->send(new \App\Mail\LowStockAlert($inv));
                            } catch (\Exception $e) {
                                \Illuminate\Support\Facades\Log::warning("No se pudo enviar alerta de stock bajo para {$inv->name}: " . $e->getMessage());
                            }
                        }
                    }
                }
            }
        }

        // Enviar notificación por correo al cliente al crear la OT
        if ($client->email) {
            $settings = \App\Models\Setting::find(1);
            if (!$settings || $settings->notify_on_ot_status) {
                try {
                    \App\Services\MailService::configureSmtp();
                    \Illuminate\Support\Facades\Mail::to($client->email)
                        ->send(new \App\Mail\WorkOrderStatusChanged($workOrder, $this->initial_status));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("No se pudo enviar correo de ingreso de OT #{$workOrder->id}: " . $e->getMessage());
                }
            }
        }

        // Cargar datos para el modal de impresión sin salir de la vista
        $this->created_order_uuid = $workOrder->uuid;
        $this->created_order_id = $workOrder->id;
        $this->show_success_modal = true;

        session()->flash('message', '¡Orden de trabajo creada exitosamente!');
    }

    public function closeSuccessModal()
    {
        $this->show_success_modal = false;
        return redirect()->to('/');
    }

    public function getCreatedOrderProperty()
    {
        if ($this->created_order_id) {
            return WorkOrder::with(['client', 'components'])->find($this->created_order_id);
        }
        return null;
    }

    public function generateSignatureToken()
    {
        $this->validate([
            'full_name' => 'required|string',
            'phone' => 'required|string',
            'device_type' => 'required|string',
            'brand_model' => 'required|string',
            'reported_issue' => 'required|string',
        ]);

        $this->signature_token = 'sig_' . Str::random(12);

        \Illuminate\Support\Facades\Cache::put($this->signature_token, [
            'status' => 'pending',
            'full_name' => $this->full_name,
            'device_type' => $this->device_type,
            'brand_model' => $this->brand_model,
            'reported_issue' => $this->reported_issue,
            'aesthetic_notes' => $this->aesthetic_notes ?? 'Ninguna',
            'estimated_delivery' => $this->estimated_delivery ?? 'Pendiente',
            'budget_type' => $this->budget_type,
            'total' => $this->getTotalProperty(),
            'down_payment' => $this->down_payment,
            'balance' => $this->getBalanceProperty(),
            'warranty_text' => Setting::find(1)->warranty_text ?? 'Garantía exclusiva por fallas de funcionamiento de la pieza reemplazada. No cubre daños por golpes, presión o humedad.',
            'signature_base64' => null
        ], now()->addMinutes(30));
    }

    public function checkSignatureStatus()
    {
        if ($this->signature_token) {
            $data = \Illuminate\Support\Facades\Cache::get($this->signature_token);
            if ($data && $data['status'] === 'signed' && !empty($data['signature_base64'])) {
                $this->signature_base64 = $data['signature_base64'];
                $this->terms_accepted = true;

                // Clean up token to stop polling and clear cache
                $this->signature_token = null;
                session()->flash('signature_success', '¡Firma recibida correctamente desde el celular del cliente!');

                // Dispatch browser event to draw signature preview on canvas
                $this->dispatch('signature-loaded-from-mobile', signature: $this->signature_base64);
            }
        }
    }

    public function cancelSignatureSession()
    {
        if ($this->signature_token) {
            \Illuminate\Support\Facades\Cache::forget($this->signature_token);
        }
        $this->signature_token = null;
    }

    public function toggleKioskMode()
    {
        $this->validate([
            'full_name' => 'required|string',
            'phone' => 'required|string',
            'device_type' => 'required|string',
            'brand_model' => 'required|string',
            'reported_issue' => 'required|string',
        ]);
        $this->kiosk_mode = !$this->kiosk_mode;
    }

    public function render()
    {
        return view('livewire.work-orders.create-work-order')->layout('layouts.app');
    }
}
