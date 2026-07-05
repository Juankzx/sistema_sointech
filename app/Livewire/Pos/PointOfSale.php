<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inventory;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\CashRegister;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PointOfSale extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // ─── Active Tab ───
    public $posTab = 'sell'; // sell, movements, history

    // ─── Cash Register ───
    public $activeRegister;
    public $opening_balance = 0;
    public $expected_closing_balance = 0;
    public $closing_balance = 0;
    public $expected_cash = 0;
    public $expected_transfer = 0;
    public $expected_card = 0;
    public $closing_cash = 0;
    public $closing_transfer = 0;
    public $closing_card = 0;
    public $closing_notes = '';
    public $showOpenModal = false;
    public $showCloseModal = false;
    public $searchRegister = '';

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

    // ─── Sales History ───
    public $searchSales = '';
    public $dateFrom = '';
    public $dateTo = '';

    public function mount()
    {
        $this->loadActiveRegister();

        $setting = Setting::first();
        if ($setting && $setting->tax_rate) {
            $this->taxRate = $setting->tax_rate;
        }
    }

    // ════════════════════════════════════
    //  CASH REGISTER METHODS
    // ════════════════════════════════════

    public function loadActiveRegister()
    {
        $this->activeRegister = CashRegister::where('status', 'open')->first();

        if ($this->activeRegister) {
            $this->calculateExpectedBalance();
        }
    }

    public function calculateExpectedBalance()
    {
        if (!$this->activeRegister) return;

        $payments = $this->activeRegister->payments;

        $incomeCash = $payments->where('type', 'income')->where('payment_method', 'Efectivo')->sum('amount');
        $expenseCash = $payments->where('type', 'expense')->where('payment_method', 'Efectivo')->sum('amount');
        $this->expected_cash = $this->activeRegister->opening_balance + $incomeCash - $expenseCash;

        $incomeTransfer = $payments->where('type', 'income')->where('payment_method', 'Transferencia')->sum('amount');
        $expenseTransfer = $payments->where('type', 'expense')->where('payment_method', 'Transferencia')->sum('amount');
        $this->expected_transfer = $incomeTransfer - $expenseTransfer;

        $cardMethods = ['Débito/Crédito', 'Débito', 'Crédito', 'Tarjeta'];
        $incomeCard = $payments->where('type', 'income')->whereIn('payment_method', $cardMethods)->sum('amount');
        $expenseCard = $payments->where('type', 'expense')->whereIn('payment_method', $cardMethods)->sum('amount');
        $this->expected_card = $incomeCard - $expenseCard;

        $this->expected_closing_balance = $this->expected_cash + $this->expected_transfer + $this->expected_card;

        $this->closing_cash = $this->expected_cash;
        $this->closing_transfer = $this->expected_transfer;
        $this->closing_card = $this->expected_card;
        $this->closing_balance = $this->expected_closing_balance;
    }

    public function openRegister()
    {
        $this->validate([
            'opening_balance' => 'required|numeric|min:0',
        ]);

        CashRegister::create([
            'user_id' => auth()->id(),
            'opening_balance' => $this->opening_balance,
            'status' => 'open',
            'opened_at' => now(),
        ]);

        $this->showOpenModal = false;
        $this->opening_balance = 0;
        $this->loadActiveRegister();
        session()->flash('message', '✅ Caja abierta exitosamente. ¡Ya puedes vender!');
    }

    public function closeRegister()
    {
        $this->validate([
            'closing_cash' => 'required|numeric|min:0',
            'closing_transfer' => 'required|numeric|min:0',
            'closing_card' => 'required|numeric|min:0',
        ]);

        $this->closing_balance = $this->closing_cash + $this->closing_transfer + $this->closing_card;

        $this->activeRegister->update([
            'expected_cash' => $this->expected_cash,
            'expected_transfer' => $this->expected_transfer,
            'expected_card' => $this->expected_card,
            'closing_cash' => $this->closing_cash,
            'closing_transfer' => $this->closing_transfer,
            'closing_card' => $this->closing_card,
            'closing_balance' => $this->closing_balance,
            'expected_closing_balance' => $this->expected_closing_balance,
            'notes' => $this->closing_notes,
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        $this->showCloseModal = false;
        $this->closing_notes = '';
        $this->cart = [];
        $this->loadActiveRegister();
        session()->flash('message', '🔒 Caja cerrada exitosamente.');
    }

    public function updatedSearchRegister()
    {
        $this->resetPage('registersPage');
    }

    // ════════════════════════════════════
    //  POS / CART METHODS
    // ════════════════════════════════════

    public function switchPosTab($tab)
    {
        $this->posTab = $tab;
    }

    public function updatedSearch()
    {
        if (strlen($this->search) > 2) {
            $this->foundProducts = Inventory::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('category', 'like', '%' . $this->search . '%')
                ->where('stock', '>', 0)
                ->limit(10)
                ->get()
                ->toArray();
        } else {
            $this->foundProducts = [];
        }
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
        if (strlen($this->searchClient) > 2) {
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
        $this->foundProducts = [];
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
        $activeRegister = CashRegister::where('status', 'open')->first();
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

            foreach ($this->cart as $item) {
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
                    $product->stock -= $item['quantity'];
                    $product->save();
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
                'description' => 'Venta POS: ' . collect($this->cart)->pluck('name')->implode(', '),
                'user_id' => auth()->id(),
            ]);

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

    // ════════════════════════════════════
    //  SALES HISTORY
    // ════════════════════════════════════

    public function updatedSearchSales()
    {
        $this->resetPage('salesPage');
    }

    public function updatedDateFrom()
    {
        $this->resetPage('salesPage');
    }

    public function updatedDateTo()
    {
        $this->resetPage('salesPage');
    }

    // ════════════════════════════════════
    //  RENDER
    // ════════════════════════════════════

    public function render()
    {
        $completedSale = null;
        if ($this->completedSaleUuid) {
            $completedSale = Sale::with('items')->where('uuid', $this->completedSaleUuid)->first();
        }

        $companySettings = Setting::first();

        // Payments for movements tab
        $payments = [];
        if ($this->activeRegister) {
            $payments = $this->activeRegister->payments()->with(['workOrder', 'user'])->latest()->get();
        }

        // Closed registers (when no active register)
        $recentRegisters = null;
        if (!$this->activeRegister) {
            $regQuery = CashRegister::with('user')->where('status', 'closed');
            if (!empty($this->searchRegister)) {
                $regQuery->where(function($q) {
                    $q->where('id', 'like', '%' . $this->searchRegister . '%')
                      ->orWhereHas('user', function($qu) {
                          $qu->where('name', 'like', '%' . $this->searchRegister . '%');
                      });
                });
            }
            $recentRegisters = $regQuery->latest()->paginate(10, ['*'], 'registersPage');
        }

        // Sales history
        $salesQuery = Sale::with(['user', 'items']);
        if (!empty($this->searchSales)) {
            $salesQuery->where(function($q) {
                $q->where('client_name', 'like', '%' . $this->searchSales . '%')
                  ->orWhere('uuid', 'like', '%' . $this->searchSales . '%')
                  ->orWhereHas('user', function($q2) {
                      $q2->where('name', 'like', '%' . $this->searchSales . '%');
                  });
            });
        }
        if (!empty($this->dateFrom)) {
            $salesQuery->whereDate('created_at', '>=', $this->dateFrom);
        }
        if (!empty($this->dateTo)) {
            $salesQuery->whereDate('created_at', '<=', $this->dateTo);
        }
        $sales = $salesQuery->latest()->paginate(15, ['*'], 'salesPage');

        return view('livewire.pos.point-of-sale', [
            'completedSale' => $completedSale,
            'companySettings' => $companySettings,
            'payments' => $payments,
            'recentRegisters' => $recentRegisters,
            'sales' => $sales,
        ])->layout('layouts.app');
    }
}
