<?php

namespace App\Livewire\Public;

use App\Models\WorkOrder;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Schema;

class LandingPage extends Component
{
    public $searchQuery = '';
    public $searchError = '';

    // Contact/Quote form fields
    public $contact_name = '';
    public $contact_phone = '';
    public $contact_email = '';
    public $device_type = 'Laptop';
    public $issue_description = '';
    public $quoteSubmitted = false;

    protected $rules = [
        'contact_name'      => 'required|min:3|max:100',
        'contact_phone'     => 'required|min:8|max:20',
        'contact_email'     => 'nullable|email|max:100',
        'device_type'       => 'required',
        'issue_description' => 'required|min:10|max:1000',
    ];

    protected $messages = [
        'contact_name.required'      => 'Por favor ingresa tu nombre completo.',
        'contact_phone.required'     => 'Por favor ingresa un número de teléfono de contacto.',
        'issue_description.required' => 'Por favor describe brevemente la falla de tu equipo.',
        'issue_description.min'      => 'La descripción de la falla debe tener al menos 10 caracteres.',
    ];

    public function searchOrder()
    {
        $this->searchError = '';
        $query = trim($this->searchQuery);

        if (empty($query)) {
            $this->searchError = 'Por favor ingresa un número de orden, código o documento.';
            return;
        }

        // Clean up common prefixes like "OT-", "#"
        $cleanQuery = preg_replace('/^(ot|orden|#|\-)+/i', '', $query);
        $cleanQuery = trim($cleanQuery);

        // Search in WorkOrder model:
        // 1. Exact or prefix match on UUID
        // 2. Exact match on ID
        // 3. Match via client phone or document number
        $workOrder = WorkOrder::where('uuid', $query)
            ->orWhere('uuid', 'like', $cleanQuery . '%')
            ->orWhere('id', $cleanQuery)
            ->orWhereHas('client', function ($q) use ($cleanQuery, $query) {
                $q->where('phone', 'like', '%' . $cleanQuery . '%')
                  ->orWhere('document_number', 'like', '%' . $cleanQuery . '%');
            })
            ->latest()
            ->first();

        if ($workOrder) {
            return redirect()->route('work-orders.track', ['uuid' => $workOrder->uuid]);
        }

        $this->searchError = 'No encontramos ninguna orden activa con el código "' . e($query) . '". Por favor verifica el número en tu comprobante o contáctanos por WhatsApp.';
    }

    public function sendQuoteRequest()
    {
        $this->validate();

        $this->quoteSubmitted = true;
        
        $this->reset(['contact_name', 'contact_phone', 'contact_email', 'device_type', 'issue_description']);
    }

    public function render()
    {
        $settings = null;
        if (Schema::hasTable('settings')) {
            $settings = Setting::first();
        }

        return view('livewire.public.landing-page', [
            'settings' => $settings,
        ])->layout('layouts.public');
    }
}
