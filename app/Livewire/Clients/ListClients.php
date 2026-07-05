<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class ListClients extends Component
{
    public string $search = '';
    
    // Modal states and form fields
    public bool $showModal = false;
    public string $full_name = '';
    public string $rut_dni = '';
    public string $phone = '';
    public string $email = '';

    // Orders modal states
    public bool $showOrdersModal = false;
    public ?Client $selectedClient = null;
    public $clientOrders = [];
    public string $searchOrders = '';

    protected array $rules = [
        'full_name' => 'required|string|max:255',
        'rut_dni' => 'nullable|string|max:25',
        'phone' => 'required|string|max:25',
        'email' => 'nullable|email|max:255',
    ];

    public function openCreateModal()
    {
        $this->resetErrorBag();
        $this->reset(['full_name', 'rut_dni', 'phone', 'email']);
        $this->showModal = true;
    }

    public function saveClient()
    {
        $this->validate();

        Client::create([
            'full_name' => $this->full_name,
            'rut_dni' => $this->rut_dni,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);

        $this->showModal = false;
        session()->flash('message', "El cliente '{$this->full_name}' se ha registrado exitosamente.");
        $this->reset(['full_name', 'rut_dni', 'phone', 'email']);
    }

    public function viewOrders($clientId)
    {
        $this->searchOrders = '';
        $this->selectedClient = Client::findOrFail($clientId);
        $this->clientOrders = $this->selectedClient->workOrders()->latest()->get();
        $this->showOrdersModal = true;
    }

    public function updatedSearchOrders()
    {
        if ($this->selectedClient) {
            $this->clientOrders = $this->selectedClient->workOrders()
                ->where(function($q) {
                    $q->where('uuid', 'like', '%' . $this->searchOrders . '%')
                      ->orWhere('device_type', 'like', '%' . $this->searchOrders . '%')
                      ->orWhere('brand_model', 'like', '%' . $this->searchOrders . '%')
                      ->orWhere('reported_issue', 'like', '%' . $this->searchOrders . '%')
                      ->orWhere('status', 'like', '%' . $this->searchOrders . '%');
                })
                ->latest()
                ->get();
        }
    }

    public function render()
    {
        $query = Client::withCount('workOrders')
            ->orderBy('full_name', 'asc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('full_name', 'like', '%' . $this->search . '%')
                  ->orWhere('rut_dni', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $clients = $query->get();

        return view('livewire.clients.list-clients', [
            'clients' => $clients,
        ])->layout('layouts.app');
    }
}
