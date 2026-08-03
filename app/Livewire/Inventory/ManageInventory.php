<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Livewire\Component;

class ManageInventory extends Component
{
    public string $search = '';

    // Create Modal states
    public bool $showModal = false;
    public string $category = '';
    public string $name = '';
    public int $stock = 0;
    public float $cost_price = 0;
    public float $sale_price = 0;

    // Adjust Stock Modal states
    public bool $showAdjustModal = false;
    public int $selectedPartId = 0;
    public int $adjustAmount = 0;

    protected array $rules = [
        'category' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'stock' => 'required|integer|min:0',
        'cost_price' => 'required|numeric|min:0',
        'sale_price' => 'required|numeric|min:0',
    ];

    public function openCreateModal()
    {
        $this->resetErrorBag();
        $this->reset(['category', 'name', 'stock', 'cost_price', 'sale_price']);
        $this->showModal = true;
    }

    public function savePart()
    {
        $this->validate();

        Inventory::create([
            'category' => $this->category,
            'name' => $this->name,
            'stock' => $this->stock,
            'cost_price' => $this->cost_price,
            'sale_price' => $this->sale_price,
        ]);

        $this->showModal = false;
        session()->flash('message', "El repuesto '{$this->name}' ha sido agregado al catálogo.");
        $this->reset(['category', 'name', 'stock', 'cost_price', 'sale_price']);
    }

    public function openAdjustModal($partId)
    {
        $this->selectedPartId = $partId;
        $this->adjustAmount = 0;
        $this->showAdjustModal = true;
    }

    public function adjustStock()
    {
        $this->validate([
            'adjustAmount' => 'required|integer',
        ]);

        $part = Inventory::findOrFail($this->selectedPartId);
        $newStock = $part->stock + $this->adjustAmount;

        if ($newStock < 0) {
            $this->addError('adjustAmount', 'El stock final no puede ser menor a 0.');
            return;
        }

        $part->update(['stock' => $newStock]);
        $this->showAdjustModal = false;
        
        session()->flash('message', "El stock de '{$part->name}' se ha ajustado exitosamente a {$newStock} unidades.");
    }

    public function deletePart($partId)
    {
        if (!auth()->user()->isAdmin()) {
            session()->flash('message', 'No tienes autorización para eliminar repuestos.');
            return;
        }

        $part = Inventory::findOrFail($partId);
        $partName = $part->name;
        $part->delete();

        session()->flash('message', "El repuesto '{$partName}' ha sido eliminado del catálogo.");
    }

    public function render()
    {
        $query = Inventory::orderBy('name', 'asc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        $parts = $query->get();

        $totalParts = Inventory::count();
        $lowStockCount = Inventory::where('stock', '>', 0)->where('stock', '<', 5)->count();
        $outOfStockCount = Inventory::where('stock', '<=', 0)->count();
        $totalValuation = Inventory::all()->sum(fn($p) => $p->stock * $p->sale_price);

        return view('livewire.inventory.manage-inventory', [
            'parts' => $parts,
            'totalParts' => $totalParts,
            'lowStockCount' => $lowStockCount,
            'outOfStockCount' => $outOfStockCount,
            'totalValuation' => $totalValuation,
        ])->layout('layouts.app');
    }

}
