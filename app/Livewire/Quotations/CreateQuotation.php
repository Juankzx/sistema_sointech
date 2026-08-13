<?php

namespace App\Livewire\Quotations;

use Livewire\Component;
use App\Models\Client;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\QuotationTemplate;
use App\Models\Setting;
use App\Models\WorkOrder;
use App\Models\Inventory;
use Carbon\Carbon;

class CreateQuotation extends Component
{
    public $quote_id = null;

    // Client fields
    public $client_id = null;
    public $client_name = '';
    public $client_email = '';
    public $client_phone = '';
    public $client_rut = '';
    public $search_client = '';
    public $found_clients = [];

    // Device info
    public $device_info = '';
    public $device_type = 'smartphone';
    public $brand_model = '';
    public $imei_serial = '';
    public $found_devices = [];

    public function updatedBrandModel()
    {
        if (strlen($this->brand_model) >= 2) {
            $this->found_devices = \App\Models\DeviceCatalog::where('model', 'like', '%' . $this->brand_model . '%')
                ->orWhere('brand', 'like', '%' . $this->brand_model . '%')
                ->limit(5)
                ->get()
                ->toArray();
        } else {
            $this->found_devices = [];
        }
        $this->syncDeviceInfo();
    }

    public function selectDevice($brand, $model)
    {
        $this->brand_model = trim("{$brand} {$model}");
        $this->found_devices = [];
        $this->syncDeviceInfo();
    }

    public function syncDeviceInfo()
    {
        $parts = array_filter([
            $this->brand_model ?: $this->device_info,
            $this->imei_serial ? "SN: {$this->imei_serial}" : null
        ]);
        $this->device_info = implode(' - ', $parts);
    }

    // Quotation data
    public $quote_number = '';
    public $valid_until = '';
    public $status = 'borrador';
    public $notes = '';
    public $terms_and_conditions = '';

    // Tax & Totals
    // tax_mode: 'labor_only' (IVA 19% solo a mano de obra), 'included' (IVA incluido en el total), 'added' (+19% IVA a todo), 'exempt' (Exento)
    public $tax_mode = 'labor_only';
    public $tax_included = false;
    public $discount = 0;
    public $subtotal = 0;
    public $tax_amount = 0;
    public $total = 0;

    // Items array
    public $items = [];

    // Templates & Inventory search
    public $selected_template_id = null;
    public $templates = [];
    public $search_inventory = '';
    public $found_inventory = [];

    public function mount($id = null)
    {
        $this->templates = QuotationTemplate::orderBy('title')->get();
        $setting = Setting::find(1);

        if ($id) {
            $quote = Quotation::with('items')->findOrFail($id);
            $this->quote_id = $quote->id;
            $this->quote_number = $quote->quote_number;
            $this->client_id = $quote->client_id;
            $this->client_name = $quote->client_name;
            $this->client_email = $quote->client_email;
            $this->client_phone = $quote->client_phone;
            $this->client_rut = $quote->client_rut;
            $this->device_info = $quote->device_info;
            $this->device_type = $quote->device_type ?? 'smartphone';
            $this->brand_model = $quote->device_info;
            $this->valid_until = $quote->valid_until ? $quote->valid_until->format('Y-m-d') : '';
            $this->status = $quote->status;
            $this->notes = $quote->notes;
            $this->terms_and_conditions = $quote->terms_and_conditions;
            $this->tax_included = (bool)$quote->tax_included;
            $this->discount = (float)$quote->discount;

            if ($quote->tax_included) {
                $this->tax_mode = 'included';
            } elseif ((float)$quote->tax_amount > 0) {
                // Verificar si el IVA corresponde a mano de obra o a todo
                $servicesSum = $quote->items->where('type', 'servicio')->sum(fn($i) => $i->quantity * $i->unit_price);
                $expectedLaborTax = round($servicesSum * 0.19);
                if (abs($expectedLaborTax - (float)$quote->tax_amount) < 5) {
                    $this->tax_mode = 'labor_only';
                } else {
                    $this->tax_mode = 'added';
                }
            } else {
                $this->tax_mode = 'exempt';
            }

            $this->items = $quote->items->map(function ($item) {
                return [
                    'id'          => $item->id,
                    'description' => $item->description,
                    'type'        => $item->type,
                    'quantity'    => $item->quantity,
                    'unit_price'  => (float)$item->unit_price,
                    'subtotal'    => (float)$item->subtotal,
                ];
            })->toArray();
        } else {
            $this->quote_number = Quotation::generateQuoteNumber();
            $this->valid_until = Carbon::now()->addDays(15)->format('Y-m-d');
            $this->tax_mode = 'labor_only'; // Por defecto: IVA 19% solo a la mano de obra
            $this->terms_and_conditions = $setting?->legal_terms ?? "1. Presupuesto válido por 15 días continuos a contar de la fecha de emisión.
2. Garantía de 12 meses en repuestos nuevos y 90 días en servicios de mano de obra.
3. Repuestos a pedido tienen un plazo estimado de llegada de 24 a 72 horas hábiles tras la aprobación.
4. La garantía cubre fallas de fabricación; no aplica por líquido, humedad, golpes o intervención de terceros.";
            
            // Iniciar con formulario completamente en blanco
            $this->device_info = '';
            $this->addItem('', 'servicio', 0, 1);
        }

        $this->calculateTotals();
    }

    public function setWarrantyPreset($type)
    {
        switch ($type) {
            case 'standard':
                $this->terms_and_conditions = "1. Presupuesto válido por 15 días continuos desde su emisión.
2. Garantía de 90 días (3 meses) en servicios de mano de obra y 12 meses en repuestos nuevos.
3. Repuestos a pedido tienen un tiempo estimado de importación/llegada de 24 a 72 horas hábiles.
4. La garantía no cubre daños por líquidos, caídas, humedad, sobretensión eléctrica o manipulación de terceros.";
                break;
            case 'parts_12m':
                $this->terms_and_conditions = "1. Presupuesto válido por 15 días continuos desde su emisión.
2. Garantía Extendida de 12 Meses (1 Año) en repuestos instalados (SSD, RAM, Pantallas Originales) y 90 días en mano de obra.
3. Repuestos a pedido se gestionan tras la confirmación de la cotización.
4. Cobertura válida presentando este documento con sellos de seguridad intactos.";
                break;
            case 'express_30d':
                $this->terms_and_conditions = "1. Presupuesto válido por 7 días continuos desde su emisión.
2. Garantía Express de 30 Días en reparaciones a nivel de componente / microsoldadura.
3. No aplica garantía si el equipo presenta signos de humedad, sulfatación o golpe posterior.";
                break;
            case 'no_warranty':
                $this->terms_and_conditions = "1. Presupuesto válido por 7 días continuos.
2. Servicio de Diagnóstico / Limpieza General Exento de Garantía posterior.
3. El cliente acepta las condiciones técnicas informadas tras la revisión del equipo.";
                break;
        }
    }

    public function updatedSearchClient()
    {
        if (strlen($this->search_client) >= 2) {
            $this->found_clients = Client::where('full_name', 'like', '%' . $this->search_client . '%')
                ->orWhere('company_name', 'like', '%' . $this->search_client . '%')
                ->orWhere('rut_dni', 'like', '%' . $this->search_client . '%')
                ->orWhere('phone', 'like', '%' . $this->search_client . '%')
                ->limit(5)
                ->get()
                ->toArray();
        } else {
            $this->found_clients = [];
        }
    }

    public function selectClient($clientId)
    {
        $client = Client::find($clientId);
        if ($client) {
            $this->client_id = $client->id;
            $this->client_name = $client->company_name ? "{$client->full_name} ({$client->company_name})" : $client->full_name;
            $this->client_email = $client->email;
            $this->client_phone = $client->phone;
            $this->client_rut = $client->rut_dni;
            $this->search_client = '';
            $this->found_clients = [];
        }
    }

    public function clearClient()
    {
        $this->client_id = null;
        $this->client_name = '';
        $this->client_email = '';
        $this->client_phone = '';
        $this->client_rut = '';
    }

    public function updatedSearchInventory()
    {
        if (strlen($this->search_inventory) >= 2) {
            $this->found_inventory = Inventory::where('name', 'like', '%' . $this->search_inventory . '%')
                ->orWhere('sku', 'like', '%' . $this->search_inventory . '%')
                ->limit(6)
                ->get()
                ->toArray();
        } else {
            $this->found_inventory = [];
        }
    }

    public function addInventoryItem($inventoryId)
    {
        $item = Inventory::find($inventoryId);
        if ($item) {
            $this->addItem(
                $item->name . ($item->stock <= 0 ? ' (A Pedido)' : ''),
                'producto',
                $item->sale_price ?? $item->price ?? 0,
                1
            );
            $this->search_inventory = '';
            $this->found_inventory = [];
        }
    }

    public function addOnDemandPart()
    {
        $this->addItem('[A Pedido] ', 'producto', 0, 1);
    }

    public function loadTemplate($templateId)
    {
        if (!$templateId) return;
        $template = QuotationTemplate::find($templateId);
        if ($template && !empty($template->items)) {
            $this->selected_template_id = $template->id;
            if (empty($this->device_info) && $template->device_category) {
                $this->device_info = $template->device_category . ' (Upgrade & Mantención)';
            }
            $this->items = [];
            foreach ($template->items as $item) {
                $qty = (int)($item['quantity'] ?? 1);
                $price = (float)($item['unit_price'] ?? 0);
                $this->items[] = [
                    'description' => $item['description'] ?? '',
                    'type'        => $item['type'] ?? 'servicio',
                    'quantity'    => $qty,
                    'unit_price'  => $price,
                    'subtotal'    => $qty * $price,
                ];
            }
            if ($template->terms_and_conditions) {
                $this->terms_and_conditions = $template->terms_and_conditions;
            }
            $this->calculateTotals();
        }
    }

    public function addItem($description = '', $type = 'servicio', $unitPrice = 0, $quantity = 1)
    {
        $this->items[] = [
            'description' => $description,
            'type'        => $type,
            'quantity'    => (int)$quantity,
            'unit_price'  => (float)$unitPrice,
            'subtotal'    => (int)$quantity * (float)$unitPrice,
        ];
        $this->calculateTotals();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotals();
    }

    public function updatedItems()
    {
        foreach ($this->items as $i => $item) {
            $qty = (int)($item['quantity'] ?? 1);
            $price = (float)($item['unit_price'] ?? 0);
            $this->items[$i]['subtotal'] = $qty * $price;
        }
        $this->calculateTotals();
    }

    public function updatedTaxMode()
    {
        $this->tax_included = ($this->tax_mode === 'included');
        $this->calculateTotals();
    }

    public function updatedTaxIncluded()
    {
        $this->tax_mode = $this->tax_included ? 'included' : 'labor_only';
        $this->calculateTotals();
    }

    public function updatedDiscount()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $servicesSum = 0;
        $productsSum = 0;

        foreach ($this->items as $item) {
            $qty = (int)($item['quantity'] ?? 1);
            $price = (float)($item['unit_price'] ?? 0);
            $lineSub = ($qty * $price);

            if (($item['type'] ?? 'servicio') === 'servicio') {
                $servicesSum += $lineSub;
            } else {
                $productsSum += $lineSub;
            }
        }

        $rawSum = $servicesSum + $productsSum;
        $disc = (float)$this->discount;
        $netSum = max(0, $rawSum - $disc);

        if ($this->tax_mode === 'labor_only') {
            // Opción 1: IVA 19% aplicado ÚNICAMENTE sobre la Mano de Obra / Servicios
            $this->tax_included = false;
            $this->subtotal = round($netSum);
            $this->tax_amount = round($servicesSum * 0.19);
            $this->total = $this->subtotal + $this->tax_amount;
        } elseif ($this->tax_mode === 'included') {
            // Precios en lista incluyen IVA 19% (Total Bruto Fijo)
            $this->tax_included = true;
            $this->total = round($netSum);
            $this->subtotal = round($this->total / 1.19);
            $this->tax_amount = $this->total - $this->subtotal;
        } elseif ($this->tax_mode === 'added') {
            // Precios son NETOS (+ 19% IVA a todo)
            $this->tax_included = false;
            $this->subtotal = round($netSum);
            $this->tax_amount = round($this->subtotal * 0.19);
            $this->total = $this->subtotal + $this->tax_amount;
        } else {
            // Exento de IVA
            $this->tax_included = false;
            $this->subtotal = round($netSum);
            $this->tax_amount = 0;
            $this->total = round($netSum);
        }
    }

    public function save($targetStatus = 'borrador')
    {
        $this->validate([
            'client_name' => 'required|string|max:255',
            'device_info' => 'required|string|max:255',
            'items'       => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.unit_price'  => 'required|numeric|min:0',
        ], [
            'client_name.required' => 'Debes ingresar el nombre del cliente.',
            'device_info.required' => 'Especifica el equipo (ej: iMac 21.5 Mid 2014).',
            'items.required'       => 'Agrega al menos un ítem al presupuesto.',
            'items.*.description.required' => 'La descripción del ítem no puede estar vacía.',
        ]);

        $this->calculateTotals();

        $quotation = Quotation::updateOrCreate(
            ['id' => $this->quote_id],
            [
                'quote_number'         => $this->quote_id ? $this->quote_number : Quotation::generateQuoteNumber(),
                'client_id'            => $this->client_id,
                'client_name'          => $this->client_name,
                'client_email'         => $this->client_email,
                'client_phone'         => $this->client_phone,
                'client_rut'           => $this->client_rut,
                'device_info'          => $this->device_info,
                'device_type'          => $this->device_type,
                'subtotal'             => $this->subtotal,
                'tax_amount'           => $this->tax_amount,
                'discount'             => $this->discount,
                'total'                => $this->total,
                'tax_included'         => $this->tax_included,
                'status'               => $targetStatus,
                'valid_until'          => $this->valid_until ? Carbon::parse($this->valid_until) : null,
                'terms_and_conditions' => $this->terms_and_conditions,
                'notes'                => $this->notes,
                'user_id'              => auth()->id(),
            ]
        );

        // Recrear ítems
        $quotation->items()->delete();
        foreach ($this->items as $item) {
            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'description'  => $item['description'],
                'type'         => $item['type'] ?? 'servicio',
                'quantity'     => (int)$item['quantity'],
                'unit_price'   => (float)$item['unit_price'],
                'subtotal'     => (int)$item['quantity'] * (float)$item['unit_price'],
            ]);
        }

        session()->flash('success', 'Cotización ' . $quotation->quote_number . ' guardada con éxito.');

        return redirect()->route('quotations.index');
    }

    public function convertToWorkOrder($id = null)
    {
        try {
            $quoteId = $id ?? $this->quote_id;
            if (!$quoteId) {
                $this->save('aceptada');
                $quoteId = $this->quote_id;
            }

            $quote = Quotation::findOrFail($quoteId);

            if ($quote->status === 'convertida' && $quote->work_order_id) {
                session()->flash('error', 'Esta cotización ya fue convertida previamente a la Orden de Trabajo #' . $quote->work_order_id);
                return redirect()->route('work-orders.index');
            }

            return redirect()->route('work-orders.create', ['from_quote' => $quoteId]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al convertir cotización: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.quotations.create-quotation')->layout('layouts.app');
    }
}
