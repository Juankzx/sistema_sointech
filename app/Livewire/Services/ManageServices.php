<?php

namespace App\Livewire\Services;

use Livewire\Component;
use App\Models\Service;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManageServices extends Component
{
    // Modal state
    public $showModal = false;
    public $editing_service_id = null;

    // Form fields
    public $service_name = '';
    public $service_category = 'general';
    public $service_default_price = '';
    public $service_description = '';

    // Filters
    public $search = '';
    public $filterCategory = '';

    // Confirmation
    public $confirmingDeleteId = null;

    protected $queryString = ['filterCategory', 'search'];

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $service = Service::find($id);
        if ($service) {
            $this->editing_service_id = $service->id;
            $this->service_name = $service->name;
            $this->service_category = $service->category;
            $this->service_default_price = $service->default_price;
            $this->service_description = $service->description;
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

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
                session()->flash('message', 'Servicio actualizado correctamente.');
            }
        } else {
            Service::create([
                'name' => trim($this->service_name),
                'category' => $this->service_category,
                'default_price' => (float)$this->service_default_price,
                'description' => trim($this->service_description),
                'is_active' => true,
            ]);
            session()->flash('message', 'Servicio agregado al catálogo.');
        }

        $this->closeModal();
    }

    public function toggleStatus($id)
    {
        $service = Service::find($id);
        if ($service) {
            $service->update(['is_active' => !$service->is_active]);
        }
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDeleteId = null;
    }

    public function deleteService($id)
    {
        $service = Service::find($id);
        if ($service) {
            $service->delete();
            session()->flash('message', 'Servicio eliminado del catálogo.');
        }
        $this->confirmingDeleteId = null;
    }

    public function setCategory($cat)
    {
        $this->filterCategory = $cat;
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

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }

        $services = $query->orderBy('category')->orderBy('name')->get();

        // Category counts for filter pills
        $categoryCounts = Service::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $totalServices = Service::count();

        return view('livewire.services.manage-services', [
            'services' => $services,
            'categoryCounts' => $categoryCounts,
            'totalServices' => $totalServices,
        ]);
    }
}
