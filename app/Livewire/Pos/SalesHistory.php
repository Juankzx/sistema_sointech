<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;
use App\Models\Inventory;

class SalesHistory extends Component
{
    use WithPagination;

    public $search = '';
    public $dateFrom = '';
    public $dateTo = '';

    // Void sale modal
    public $showVoidModal = false;
    public $voidSaleId = null;
    public $voidReason = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    /**
     * Abre el modal de confirmación de anulación
     */
    public function confirmVoid($saleId)
    {
        $this->voidSaleId = $saleId;
        $this->voidReason = '';
        $this->showVoidModal = true;
    }

    /**
     * Cancela la anulación
     */
    public function cancelVoid()
    {
        $this->showVoidModal = false;
        $this->voidSaleId = null;
        $this->voidReason = '';
    }

    /**
     * Ejecuta la anulación de la venta
     */
    public function voidSale()
    {
        $this->validate([
            'voidReason' => 'required|min:3|max:500',
        ], [
            'voidReason.required' => 'Debes ingresar un motivo de anulación.',
            'voidReason.min' => 'El motivo debe tener al menos 3 caracteres.',
        ]);

        $sale = Sale::with('items')->find($this->voidSaleId);

        if (!$sale) {
            session()->flash('error', 'Venta no encontrada.');
            $this->cancelVoid();
            return;
        }

        if ($sale->isVoided()) {
            session()->flash('error', 'Esta venta ya fue anulada.');
            $this->cancelVoid();
            return;
        }

        // Devolver stock de productos al inventario
        foreach ($sale->items as $item) {
            if ($item->inventory_id) {
                $product = Inventory::find($item->inventory_id);
                if ($product) {
                    $product->increment('stock', (int) $item->quantity);
                }
            }
        }

        // Marcar venta como anulada
        $sale->update([
            'status' => 'voided',
            'voided_at' => now(),
            'voided_by' => auth()->id(),
            'void_reason' => $this->voidReason,
        ]);

        $this->cancelVoid();
        session()->flash('success', 'Venta #' . substr($sale->uuid, 0, 8) . ' anulada exitosamente. Stock devuelto al inventario.');
    }

    public function render()
    {
        $query = Sale::with(['user', 'items']);

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('client_name', 'like', '%' . $this->search . '%')
                  ->orWhere('uuid', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($q2) {
                      $q2->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if (!empty($this->dateFrom)) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if (!empty($this->dateTo)) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $sales = $query->latest()->paginate(15);

        // Total solo de ventas activas (no anuladas)
        $totalActiveSales = $sales->where('status', 'completed')->sum('total');

        return view('livewire.pos.sales-history', [
            'sales' => $sales,
            'totalActiveSales' => $totalActiveSales,
        ])->layout('layouts.app');
    }
}
