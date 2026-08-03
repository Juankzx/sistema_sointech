<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Expense;
use App\Models\Inventory;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ManagePurchases extends Component
{
    use WithPagination;

    public $currentMonth;
    public $currentYear;
    
    // Form fields
    public $showForm = false;
    public $expenseId;
    public $date;
    public $document_type = 'factura';
    public $document_number;
    
    // Supplier search
    public $searchSupplier = '';
    public $foundSuppliers = [];
    public $supplier_id = null;
    public $supplier_name; // To display selected
    
    public $category = 'Inventario/Repuestos';
    public $description;
    public $net_amount = 0;
    public $tax_amount = 0;
    public $total_amount = 0;
    
    public $autoCalculateTax = true;
    public $updateCostPrice = true; // Update inventory cost price
    
    // Cart for Inventory Items
    public $searchProduct = '';
    public $foundProducts = [];
    public $cart = []; // ['inventory_id', 'name', 'quantity', 'unit_cost', 'subtotal']

    protected $rules = [
        'date' => 'required|date',
        'document_type' => 'required|in:factura,boleta,recibo,otro',
        'category' => 'required|string|max:255',
        'total_amount' => 'required|numeric|min:0',
        'cart.*.quantity' => 'required|numeric|min:1',
        'cart.*.unit_cost' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
        $this->date = Carbon::now()->format('Y-m-d');
    }

    // --- Supplier Search ---

    public function updatedSearchSupplier()
    {
        if (strlen($this->searchSupplier) > 1) {
            $this->foundSuppliers = Supplier::where('name', 'like', '%' . $this->searchSupplier . '%')
                ->orWhere('rut', 'like', '%' . $this->searchSupplier . '%')
                ->take(5)
                ->get();
        } else {
            $this->foundSuppliers = [];
        }
    }

    public function selectSupplier($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $this->supplier_id = $supplier->id;
            $this->supplier_name = $supplier->name;
            $this->searchSupplier = '';
            $this->foundSuppliers = [];
        }
    }

    public function clearSupplier()
    {
        $this->supplier_id = null;
        $this->supplier_name = '';
    }

    // --- Totals Calculation ---

    public function updatedTotalAmount($value)
    {
        if (count($this->cart) == 0) {
            $this->calculateTaxFromTotal($value);
        }
    }
    
    public function calculateTaxFromTotal($total)
    {
        if ($this->autoCalculateTax && $this->document_type === 'factura') {
            $total = (float)$total;
            $net = round($total / 1.19, 0);
            $tax = $total - $net;
            
            $this->net_amount = $net;
            $this->tax_amount = $tax;
        } else if ($this->autoCalculateTax && in_array($this->document_type, ['boleta', 'recibo', 'otro'])) {
            $this->net_amount = (float)$total;
            $this->tax_amount = 0;
        }
    }

    public function updatedDocumentType()
    {
        if (count($this->cart) > 0) {
            $this->calculateTotalsFromCart();
        } else {
            $this->calculateTaxFromTotal($this->total_amount);
        }
    }

    // --- Cart & Inventory Search ---

    public function updatedSearchProduct()
    {
        if (strlen($this->searchProduct) > 2) {
            $this->foundProducts = Inventory::where('name', 'like', '%' . $this->searchProduct . '%')
                ->orWhere('category', 'like', '%' . $this->searchProduct . '%')
                ->take(5)
                ->get();
        } else {
            $this->foundProducts = [];
        }
    }

    public function addProductToCart($inventory_id)
    {
        $product = Inventory::find($inventory_id);
        if (!$product) return;

        // Check if already in cart
        foreach ($this->cart as $index => $item) {
            if ($item['inventory_id'] == $inventory_id) {
                $this->cart[$index]['quantity']++;
                $this->cart[$index]['subtotal'] = $this->cart[$index]['quantity'] * $this->cart[$index]['unit_cost'];
                $this->searchProduct = '';
                $this->foundProducts = [];
                $this->calculateTotalsFromCart();
                return;
            }
        }

        // Add new
        $this->cart[] = [
            'inventory_id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'unit_cost' => $product->cost_price > 0 ? $product->cost_price : 0,
            'subtotal' => $product->cost_price > 0 ? $product->cost_price : 0,
        ];

        $this->category = 'Inventario/Repuestos';
        $this->searchProduct = '';
        $this->foundProducts = [];
        $this->calculateTotalsFromCart();
    }

    public function updateCartItem($index, $field, $value)
    {
        $this->cart[$index][$field] = $value;
        $this->cart[$index]['subtotal'] = (float)$this->cart[$index]['quantity'] * (float)$this->cart[$index]['unit_cost'];
        $this->calculateTotalsFromCart();
    }

    public function removeProductFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart); // Reindex
        $this->calculateTotalsFromCart();
    }

    public function calculateTotalsFromCart()
    {
        if (count($this->cart) == 0) return;

        $totalNetItems = 0;
        foreach ($this->cart as $item) {
            $totalNetItems += (float)$item['subtotal'];
        }

        if ($this->document_type === 'factura') {
            // Cart items cost is usually NET.
            $this->net_amount = $totalNetItems;
            $this->tax_amount = round($totalNetItems * 0.19, 0);
            $this->total_amount = $this->net_amount + $this->tax_amount;
        } else {
            $this->net_amount = $totalNetItems;
            $this->tax_amount = 0;
            $this->total_amount = $totalNetItems;
        }
    }


    // --- Form Actions ---

    public function createExpense()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function editExpense($id)
    {
        $this->resetValidation();
        $expense = Expense::with('supplier')->findOrFail($id);
        
        $this->expenseId = $expense->id;
        $this->date = $expense->date->format('Y-m-d');
        $this->document_type = $expense->document_type;
        $this->document_number = $expense->document_number;
        
        if ($expense->supplier_id) {
            $this->supplier_id = $expense->supplier_id;
            $this->supplier_name = $expense->supplier->name ?? '';
        } else {
            // Fallback to legacy fields
            $this->supplier_id = null;
            $this->supplier_name = $expense->supplier_name ?? '';
        }

        $this->category = $expense->category;
        $this->description = $expense->description;
        $this->net_amount = $expense->net_amount;
        $this->tax_amount = $expense->tax_amount;
        $this->total_amount = $expense->total_amount;
        
        // Load cart items
        $this->cart = [];
        $items = PurchaseItem::where('expense_id', $expense->id)->with('inventory')->get();
        foreach ($items as $item) {
            $this->cart[] = [
                'id' => $item->id, // track existing purchase items
                'inventory_id' => $item->inventory_id,
                'name' => $item->inventory ? $item->inventory->name : 'Producto Eliminado',
                'quantity' => $item->quantity,
                'unit_cost' => $item->unit_cost,
                'subtotal' => $item->subtotal,
            ];
        }

        $this->autoCalculateTax = false;
        
        $this->showForm = true;
    }

    public function saveExpense()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $data = [
                'date' => $this->date,
                'document_type' => $this->document_type,
                'document_number' => $this->document_number,
                'supplier_id' => $this->supplier_id,
                'supplier_name' => $this->supplier_name, // Keeping as fallback for simple string name
                'category' => $this->category,
                'description' => $this->description,
                'net_amount' => $this->net_amount,
                'tax_amount' => $this->tax_amount,
                'total_amount' => $this->total_amount,
                'user_id' => auth()->id(),
            ];

            if ($this->expenseId) {
                // Editing existing
                $expense = Expense::findOrFail($this->expenseId);
                
                // If editing, we must revert the previous stock additions first
                $oldItems = PurchaseItem::where('expense_id', $expense->id)->get();
                foreach ($oldItems as $oldItem) {
                    $inv = Inventory::find($oldItem->inventory_id);
                    if ($inv) {
                        $inv->stock -= $oldItem->quantity;
                        $inv->save();
                    }
                }
                
                // Delete old items
                PurchaseItem::where('expense_id', $expense->id)->delete();
                
                $expense->update($data);
                $message = 'Compra/Gasto actualizado correctamente.';
            } else {
                $expense = Expense::create($data);
                $message = 'Compra/Gasto registrado correctamente.';
            }

            // Save new items and update stock
            foreach ($this->cart as $item) {
                PurchaseItem::create([
                    'expense_id' => $expense->id,
                    'inventory_id' => $item['inventory_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $item['subtotal']
                ]);

                // Update inventory
                $inv = Inventory::find($item['inventory_id']);
                if ($inv) {
                    $inv->increment('stock', (int)$item['quantity']);
                    if ($this->updateCostPrice) {
                        $inv->cost_price = $item['unit_cost'];
                        $inv->save();
                    }
                }
            }

            DB::commit();
            session()->flash('message', $message);
            $this->showForm = false;
            $this->resetForm();
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function deleteExpense($id)
    {
        DB::beginTransaction();
        try {
            $expense = Expense::findOrFail($id);
            
            // Revert stock
            $items = PurchaseItem::where('expense_id', $expense->id)->get();
            foreach ($items as $item) {
                $inv = Inventory::find($item->inventory_id);
                if ($inv) {
                    $inv->stock -= $item->quantity;
                    $inv->save();
                }
            }

            $expense->delete();
            DB::commit();
            session()->flash('message', 'Registro eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->expenseId = null;
        $this->date = Carbon::now()->format('Y-m-d');
        $this->document_type = 'factura';
        $this->document_number = '';
        $this->supplier_id = null;
        $this->supplier_name = '';
        $this->searchSupplier = '';
        $this->foundSuppliers = [];
        $this->category = 'Inventario/Repuestos';
        $this->description = '';
        $this->net_amount = 0;
        $this->tax_amount = 0;
        $this->total_amount = 0;
        $this->autoCalculateTax = true;
        
        $this->cart = [];
        $this->searchProduct = '';
        $this->foundProducts = [];
        
        $this->resetValidation();
    }

    public function render()
    {
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth()->endOfDay();

        // Include items relationship
        $expenses = Expense::with(['purchaseItems.inventory', 'supplier'])
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('livewire.finance.manage-purchases', [
            'expenses' => $expenses
        ])->layout('layouts.app');
    }
}
