<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Inventory;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\CashRegister;
use App\Models\Setting;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PointOfSale extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // ─── URL Params ───
    #[Url]
    public $ot_id = null;

    // ─── Cash Register ───
    public $activeRegister;

    // ─── POS / Cart ───
    public $search = '';
    public $foundProducts = [];
    public $cart = [];

    public $clientMode = 'generic';
    public $searchClient = '';
    public $foundClients = [];
    public $selectedClientId = null;

    public $clientName = 'Cliente Genérico';
    public $clientPhone = '';
    public $clientEmail = '';
    public $paymentMethod = 'Efectivo';

    // SII & Document Fields
    public $documentType = 'ticket';
    public $clientRut = '';
    public $clientGiro = '';
    public $clientAddress = '';
    public $clientCity = '';

    public $taxRate = 19.00;

    public $showReceiptModal = false;
    public $completedSaleUuid = null;



    public function mount()
    {
        $this->loadActiveRegister();

        $setting = Setting::first();
        if ($setting && $setting->tax_rate) {
            $this->taxRate = $setting->tax_rate;
        }

        // Cargar productos por defecto (últimos ingresados con stock)
        $this->foundProducts = Inventory::where('stock', '>', 0)->latest()->limit(12)->get()->toArray();

        // Si se recibe una OT por URL, cargarla en el carrito
        if ($this->ot_id) {
            $ot = WorkOrder::with('client')->find($this->ot_id);
            if ($ot) {
                // Calcular saldo pendiente
                $partsCost = $ot->parts()->get()->sum(function($p) {
                    return $p->pivot->price_at_time * $p->pivot->quantity;
                });
                $totalCost = (float)$ot->labor_cost + $partsCost;
                $balanceDue = $totalCost - (float)$ot->down_payment;

                if ($balanceDue > 0) {
                    $this->cart[] = [
                        'id' => 'OT-' . $ot->id, // ID especial
                        'name' => 'Pago/Abono OT #' . substr($ot->uuid, 0, 8),
                        'price' => $balanceDue,
                        'cost_price' => 0,
                        'quantity' => 1,
                        'stock' => 1,
                        'is_ot' => true,
                        'ot_id' => $ot->id
                    ];

                    // Pre-seleccionar al cliente si existe
                    if ($ot->client) {
                        $this->selectClient($ot->client->id);
                        $this->clientMode = 'registered'; // Cambiar a modo cliente registrado
                    }
                }
            }
        }
    }

    // ════════════════════════════════════
    //  CASH REGISTER METHODS
    // ════════════════════════════════════

    public function loadActiveRegister()
    {
        // Cierre automático de cajas no cerradas de días anteriores (con cálculo de balances)
        CashRegister::autoCloseStaleRegisters();

        $this->activeRegister = CashRegister::where('status', 'open')
            ->whereDate('opened_at', \Carbon\Carbon::today())
            ->first();
    }

    public function loadProducts()
    {
        if (strlen($this->search) >= 1) {
            $this->foundProducts = Inventory::where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('category', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%');
                })
                ->where('stock', '>', 0)
                ->limit(12)
                ->get()
                ->toArray();
        } else {
            $this->foundProducts = Inventory::where('stock', '>', 0)->latest()->limit(12)->get()->toArray();
        }
    }

    public function updatedSearch()
    {
        $this->loadProducts();
    }

    public function updatedClientMode()
    {
        if ($this->clientMode === 'generic') {
            $this->clientName = 'Cliente Genérico';
            $this->clientPhone = '';
            $this->clientEmail = '';
            $this->clientRut = '';
            $this->selectedClientId = null;
        } else {
            $this->clientName = '';
            $this->clientPhone = '';
            $this->clientEmail = '';
            $this->clientRut = '';
            $this->selectedClientId = null;
            $this->searchClient = '';
            $this->foundClients = [];
        }
    }

    public function updatedSearchClient()
    {
        if (strlen($this->searchClient) >= 1) {
            $this->foundClients = \App\Models\Client::where('full_name', 'like', '%' . $this->searchClient . '%')
                ->orWhere('rut_dni', 'like', '%' . $this->searchClient . '%')
                ->orWhere('phone', 'like', '%' . $this->searchClient . '%')

                ->limit(5)
                ->get()
                ->toArray();
        } else {
            $this->foundClients = [];
        }
    }

    public function selectClient($clientId)
    {
        $client = \App\Models\Client::find($clientId);
        if ($client) {
            $this->selectedClientId = $client->id;
            $this->clientName = $client->full_name;
            $this->clientPhone = $client->phone;
            $this->clientEmail = $client->email;
            $this->clientRut = $client->rut_dni;

            $this->searchClient = '';
            $this->foundClients = [];
        }
    }

    public function addToCart($inventoryId)
    {
        $product = Inventory::findOrFail($inventoryId);

        if ($product->stock <= 0) {
            session()->flash('error', 'Producto sin stock.');
            return;
        }

        $cartIndex = collect($this->cart)->search(function ($item) use ($inventoryId) {
            return $item['id'] == $inventoryId;
        });

        if ($cartIndex !== false) {
            if ($this->cart[$cartIndex]['quantity'] < $product->stock) {
                $this->cart[$cartIndex]['quantity']++;
            } else {
                session()->flash('error', 'No hay más stock disponible para ' . $product->name);
            }
        } else {
            $this->cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price,
                'cost_price' => $product->cost_price,
                'quantity' => 1,
                'stock' => $product->stock,
            ];
        }

        $this->search = '';
        $this->loadProducts();
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
    }

    public function updateQuantity($index, $action)
    {
        if ($action === 'increase') {
            if ($this->cart[$index]['quantity'] < $this->cart[$index]['stock']) {
                $this->cart[$index]['quantity']++;
            }
        } elseif ($action === 'decrease') {
            if ($this->cart[$index]['quantity'] > 1) {
                $this->cart[$index]['quantity']--;
            } else {
                $this->removeFromCart($index);
            }
        }
    }

    public function getSubtotalProperty()
    {
        $totalWithVat = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return $totalWithVat / (1 + ($this->taxRate / 100));
    }

    public function getTaxAmountProperty()
    {
        return $this->total - $this->subtotal;
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function processSale()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'El carrito está vacío.');
            return;
        }

        if ($this->documentType === 'factura') {
            $this->validate([
                'clientName' => 'required',
                'clientRut' => 'required',
                'clientGiro' => 'required',
                'clientAddress' => 'required',
                'clientCity' => 'required',
            ], [
                'clientName.required' => 'La razón social es obligatoria para la factura.',
                'clientRut.required' => 'El RUT es obligatorio para la factura.',
                'clientGiro.required' => 'El Giro es obligatorio para la factura.',
                'clientAddress.required' => 'La dirección es obligatoria.',
                'clientCity.required' => 'La comuna/ciudad es obligatoria.',
            ]);
        }

        $finalClientId = $this->selectedClientId;
        if ($this->clientMode === 'new') {
            $this->validate([
                'clientName' => 'required',
                'clientPhone' => 'required'
            ]);

            $newClient = \App\Models\Client::create([
                'full_name' => $this->clientName,
                'rut_dni' => $this->clientRut,
                'phone' => $this->clientPhone,
                'email' => $this->clientEmail
            ]);
            $finalClientId = $newClient->id;
        }

        // Re-check cash register
        $activeRegister = CashRegister::where('status', 'open')
            ->whereDate('opened_at', \Carbon\Carbon::today())
            ->first();
        if (!$activeRegister) {
            session()->flash('error', '⚠️ La caja diaria está cerrada. Debes abrir la caja antes de procesar una venta.');
            $this->loadActiveRegister();
            return;
        }

        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'document_type' => $this->documentType,
                'client_name' => $this->clientName ?: 'Cliente Genérico',
                'client_rut' => $this->clientRut,
                'client_business_activity' => $this->documentType === 'factura' ? $this->clientGiro : null,
                'client_address' => $this->documentType === 'factura' ? $this->clientAddress : null,
                'client_city' => $this->documentType === 'factura' ? $this->clientCity : null,
                'client_phone' => $this->clientPhone,
                'subtotal' => $this->subtotal,
                'tax_rate' => $this->taxRate,
                'tax_amount' => $this->taxAmount,
                'total' => $this->total,
                'payment_method' => $this->paymentMethod,
                'user_id' => auth()->id(),
                'cash_register_id' => $activeRegister->id,
                'sii_status' => $this->documentType !== 'ticket' ? 'pending' : null,
            ]);

            $workOrderId = null;

            foreach ($this->cart as $item) {
                if (isset($item['is_ot']) && $item['is_ot']) {
                    // Es un pago / abono de OT
                    $ot = WorkOrder::find($item['ot_id']);
                    if ($ot) {
                        $workOrderId = $ot->id;
                        $itemPaidAmount = (float)($item['price'] * ($item['quantity'] ?? 1));

                        // Actualizar abono acumulado en la Orden de Trabajo
                        $ot->down_payment += $itemPaidAmount;
                        $ot->save();

                        // Registrar log en la OT
                        $ot->logs()->create([
                            'title' => 'Abono / Pago por POS',
                            'notes' => "Abono / Pago de $" . number_format($itemPaidAmount, 0, ',', '.') . " registrado exitosamente desde el Punto de Venta.",
                            'status' => $ot->status,
                            'user_id' => auth()->id(),
                        ]);
                    }
                } else {
                    // Es un producto normal, actualizar stock
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'inventory_id' => $item['id'],
                        'name' => $item['name'],
                        'quantity' => $item['quantity'],
                        'cost_price' => $item['cost_price'],
                        'unit_price' => $item['price'],
                        'subtotal' => $item['price'] * $item['quantity'],
                    ]);

                    $product = Inventory::find($item['id']);
                    if ($product) {
                        $product->decrement('stock', (int)($item['quantity'] ?? 1));
                    }
                }
            }

            // Emitir a SII si corresponde
            if ($this->documentType !== 'ticket') {
                $siiService = new \App\Services\SiiService();
                $result = $siiService->emitDocument($sale);

                if ($result['success']) {
                    $sale->update([
                        'sii_status' => $result['status'],
                        'sii_document_number' => $result['folio'] ?? null,
                        'sii_xml_url' => $result['xml_url'] ?? null,
                    ]);
                } else {
                    $sale->update(['sii_status' => 'pending']);
                }
            }

            // Register Payment in CashRegister
            $activeRegister->payments()->create([
                'type' => 'income',
                'amount' => $this->total,
                'payment_method' => $this->paymentMethod,
                'document_type' => $this->documentType,
                'description' => 'Venta POS: ' . collect($this->cart)->pluck('name')->implode(', '),
                'user_id' => auth()->id(),
                'work_order_id' => $workOrderId, // Vinculamos el pago a la OT si existe
            ]);

            // Si hay OT vinculada, verificamos si su saldo quedó en 0 para entregarla
            if ($workOrderId) {
                $ot = WorkOrder::find($workOrderId);
                if ($ot) {
                    $partsCost = $ot->parts()->get()->sum(function($p) {
                        return $p->pivot->price_at_time * $p->pivot->quantity;
                    });
                    $totalCost = (float)$ot->labor_cost + $partsCost;
                    
                    // Sumar todos los pagos incluyendo el recién creado
                    $totalPaid = $ot->payments()->where('type', 'income')->sum('amount') + (float)$ot->down_payment;
                    $balanceDue = $totalCost - $totalPaid;

                    if ($balanceDue <= 0 && !in_array($ot->status, ['Entregado', 'Rechazado'])) {
                        $ot->update([
                            'status' => 'Entregado',
                            'delivered_at' => Carbon::now()
                        ]);
                        
                        $ot->logs()->create([
                            'title' => 'Equipo Entregado',
                            'notes' => 'El saldo de la orden fue cubierto y el equipo ha sido entregado.',
                            'status' => 'Entregado',
                            'user_id' => auth()->id(),
                        ]);
                    }
                }
            }

            DB::commit();

            // Clear Cart
            $this->cart = [];
            $this->clientName = 'Cliente Genérico';
            $this->clientPhone = '';
            $this->documentType = 'ticket';
            $this->clientRut = '';
            $this->clientGiro = '';
            $this->clientAddress = '';
            $this->clientCity = '';

            // Refresh register balance
            $this->loadActiveRegister();

            // Show Receipt Modal
            $this->completedSaleUuid = $sale->uuid;
            $this->showReceiptModal = true;

            session()->flash('message', 'Venta registrada con éxito.');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al procesar la venta: ' . $e->getMessage());
        }
    }



    public function render()
    {
        $completedSale = null;
        if ($this->completedSaleUuid) {
            $completedSale = Sale::with('items')->where('uuid', $this->completedSaleUuid)->first();
        }

        $companySettings = Setting::first();

        return view('livewire.pos.point-of-sale', [
            'completedSale' => $completedSale,
            'companySettings' => $companySettings,
        ])->layout('layouts.app');
    }
}
