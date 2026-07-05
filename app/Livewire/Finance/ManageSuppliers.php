<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;

class ManageSuppliers extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $supplierId;
    
    // Form fields
    public $name;
    public $rut;
    public $phone;
    public $email;
    public $address;
    public $contact_name;

    protected $rules = [
        'name' => 'required|string|max:255',
        'rut' => 'nullable|string|max:20',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:255',
        'contact_name' => 'nullable|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createSupplier()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function editSupplier($id)
    {
        $this->resetValidation();
        $supplier = Supplier::findOrFail($id);
        
        $this->supplierId = $supplier->id;
        $this->name = $supplier->name;
        $this->rut = $supplier->rut;
        $this->phone = $supplier->phone;
        $this->email = $supplier->email;
        $this->address = $supplier->address;
        $this->contact_name = $supplier->contact_name;
        
        $this->showForm = true;
    }

    public function saveSupplier()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'rut' => $this->rut,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'contact_name' => $this->contact_name,
        ];

        if ($this->supplierId) {
            Supplier::where('id', $this->supplierId)->update($data);
            session()->flash('message', 'Proveedor actualizado correctamente.');
        } else {
            Supplier::create($data);
            session()->flash('message', 'Proveedor creado correctamente.');
        }

        $this->showForm = false;
        $this->resetForm();
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        
        if ($supplier->expenses()->count() > 0) {
            session()->flash('error', 'No puedes eliminar este proveedor porque tiene compras asociadas.');
            return;
        }

        $supplier->delete();
        session()->flash('message', 'Proveedor eliminado correctamente.');
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->supplierId = null;
        $this->name = '';
        $this->rut = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->contact_name = '';
        $this->resetValidation();
    }

    public function render()
    {
        $suppliers = Supplier::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('rut', 'like', '%' . $this->search . '%')
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('livewire.finance.manage-suppliers', [
            'suppliers' => $suppliers
        ])->layout('layouts.app');
    }
}
