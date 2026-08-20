<?php

namespace App\Livewire\Services;

use Livewire\Component;
use App\Models\Service;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManageServices extends Component
{
    public $service_name = '';
    public $service_category = 'general';
    public $service_default_price = '';
    public $service_description = '';
    public $service_search = '';
    public $editing_service_id = null;

    public function saveService()
    {
        $this->validate([
            'service_name' => 'required|string|min:2|max:100',
            'service_category' => 'required|string',
            'service_default_price' => 'required|numeric|min:0',
        ], [
            'service_name.required' => 'El nombre del servicio es obligatorio.',
            'service_default_price.required' => 'Ingresa el precio sugerido.',
            'service_default_price.numeric' => 'El precio debe ser un número válido.',
        ]);

        if ($this->editing_service_id) {
            $service = Service::find($this->editing_service_id);
            if ($service) {
                $service->update([
                    'name' => trim($this->service_name),
                    'category' => $this->service_category,
                    'default_price' => (float)$this->service_default_price,
                    'description' => trim($this->service_description),
                ]);
                session()->flash('message', '¡Servicio actualizado correctamente!');
            }
        } else {
            Service::create([
                'name' => trim($this->service_name),
                'category' => $this->service_category,
                'default_price' => (float)$this->service_default_price,
                'description' => trim($this->service_description),
                'is_active' => true,
            ]);
            session()->flash('message', '¡Servicio agregado al catálogo exitosamente!');
        }

        $this->resetForm();
    }

    public function editService($id)
    {
        $service = Service::find($id);
        if ($service) {
            $this->editing_service_id = $service->id;
            $this->service_name = $service->name;
            $this->service_category = $service->category;
            $this->service_default_price = $service->default_price;
            $this->service_description = $service->description;
        }
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function toggleStatus($id)
    {
        $service = Service::find($id);
        if ($service) {
            $service->update(['is_active' => !$service->is_active]);
            session()->flash('message', 'Estado del servicio actualizado.');
        }
    }

    public function deleteService($id)
    {
        $service = Service::find($id);
        if ($service) {
            $service->delete();
            session()->flash('message', 'Servicio eliminado del catálogo.');
        }
    }

    private function resetForm()
    {
        $this->editing_service_id = null;
        $this->service_name = '';
        $this->service_category = 'general';
        $this->service_default_price = '';
        $this->service_description = '';
    }

    public function render()
    {
        $query = Service::query();
        if ($this->service_search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->service_search . '%')
                  ->orWhere('category', 'like', '%' . $this->service_search . '%')
                  ->orWhere('description', 'like', '%' . $this->service_search . '%');
            });
        }

        $servicesList = $query->orderBy('category')->orderBy('name')->get();

        return view('livewire.services.manage-services', [
            'servicesList' => $servicesList,
        ]);
    }
}
