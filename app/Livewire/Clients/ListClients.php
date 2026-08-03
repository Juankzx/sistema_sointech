<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class ListClients extends Component
{
    public string $search = '';
    
    // Modal states and form fields
    public bool $showModal = false;
    public bool $is_company = false;
    public string $full_name = '';
    public string $company_name = '';
    public string $rut_dni = '';
    public string $business_activity = '';
    public string $address = '';
    public string $commune = '';
    public string $phone = '';
    public string $email = '';

    // Orders modal states
    public bool $showOrdersModal = false;
    public ?Client $selectedClient = null;
    public $clientOrders = [];
    public string $searchOrders = '';

    protected array $rules = [
        'full_name' => 'required|string|max:255',
        'company_name' => 'nullable|string|max:255',
        'rut_dni' => 'nullable|string|max:25',
        'business_activity' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'commune' => 'nullable|string|max:255',
        'phone' => 'required|string|max:25',
        'email' => 'nullable|email|max:255',
    ];

    public ?int $editingClientId = null;

    public function openCreateModal()
    {
        $this->resetErrorBag();
        $this->reset(['full_name', 'company_name', 'rut_dni', 'business_activity', 'address', 'commune', 'phone', 'email', 'editingClientId', 'is_company']);
        $this->showModal = true;
    }

    public function editClient($clientId)
    {
        $this->resetErrorBag();
        $client = Client::findOrFail($clientId);
        $this->editingClientId = $client->id;
        $this->full_name = $client->full_name;
        $this->company_name = $client->company_name ?? '';
        $this->rut_dni = $client->rut_dni ?? '';
        $this->business_activity = $client->business_activity ?? '';
        $this->address = $client->address ?? '';
        $this->commune = $client->commune ?? '';
        $this->phone = $client->phone;
        $this->email = $client->email ?? '';
        $this->is_company = !empty($client->company_name);
        $this->showModal = true;
    }

    public function saveClient()
    {
        $this->validate();

        $clientData = [
            'full_name' => $this->full_name,
            'company_name' => $this->is_company ? $this->company_name : null,
            'rut_dni' => $this->rut_dni,
            'business_activity' => $this->is_company ? $this->business_activity : null,
            'address' => $this->is_company ? $this->address : null,
            'commune' => $this->is_company ? $this->commune : null,
            'phone' => $this->phone,
            'email' => $this->email,
        ];

        if ($this->editingClientId) {
            $client = Client::findOrFail($this->editingClientId);
            $client->update($clientData);
            session()->flash('message', "El cliente '{$this->full_name}' se ha actualizado exitosamente.");
        } else {
            Client::create($clientData);
            session()->flash('message', "El cliente '{$this->full_name}' se ha registrado exitosamente.");
        }

        $this->showModal = false;
        $this->reset(['full_name', 'company_name', 'rut_dni', 'business_activity', 'address', 'commune', 'phone', 'email', 'editingClientId', 'is_company']);
    }

    public function deleteClient($clientId)
    {
        $client = Client::findOrFail($clientId);
        if ($client->workOrders()->count() > 0) {
            session()->flash('error', "No se puede eliminar a '{$client->full_name}' porque tiene órdenes de trabajo asociadas.");
            return;
        }

        $client->delete();
        session()->flash('message', "El cliente ha sido eliminado correctamente.");
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
