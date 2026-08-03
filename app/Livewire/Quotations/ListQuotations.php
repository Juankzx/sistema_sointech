<?php

namespace App\Livewire\Quotations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Quotation;
use App\Models\Client;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ListQuotations extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $this->deleteQuotation($id);
    }

    public function deleteQuotation($id)
    {
        $quote = Quotation::find($id);
        if ($quote) {
            $quote->update(['status' => 'rechazada']);
            session()->flash('success', 'Cotización N° ' . $quote->quote_number . ' desactivada / cambiada a Rechazada correctamente.');
        } else {
            session()->flash('error', 'No se encontró la cotización especificada.');
        }
    }

    public function convertToWorkOrder($id)
    {
        try {
            $quote = Quotation::with('items')->findOrFail($id);

            if ($quote->status === 'convertida' && $quote->work_order_id) {
                session()->flash('error', 'Esta cotización ya fue convertida previamente.');
                return;
            }

            // Buscar o crear cliente con las columnas correctas ('full_name', 'rut_dni', 'phone', 'email')
            $client = null;
            if ($quote->client_id) {
                $client = Client::find($quote->client_id);
            }
            if (!$client) {
                $clientName = !empty($quote->client_name) ? $quote->client_name : 'Cliente Cotización ' . $quote->quote_number;
                $client = Client::create([
                    'full_name' => $clientName,
                    'rut_dni'   => $quote->client_rut,
                    'phone'     => !empty($quote->client_phone) ? $quote->client_phone : 'Sin teléfono',
                    'email'     => $quote->client_email,
                ]);
                $quote->update(['client_id' => $client->id]);
            }

            // Inferir el tipo de equipo si no está definido o es ambiguo
            $deviceType = $quote->device_type;
            if (empty($deviceType) || $deviceType === 'desktop') {
                $info = strtolower(($quote->device_info ?? '') . ' ' . implode(' ', $quote->items->pluck('description')->toArray()));
                if (preg_match('/(a\d+|galaxy|iphone|samsung|xiaomi|motorola|redmi|huawei|celular|phone|smartphone|bateria|pantalla|fpc)/i', $info)) {
                    $deviceType = 'smartphone';
                } elseif (preg_match('/(macbook|notebook|laptop|thinkpad|zenbook)/i', $info)) {
                    $deviceType = 'notebook';
                } elseif (preg_match('/(imac|mac all-in-one)/i', $info)) {
                    $deviceType = 'imac';
                } elseif (preg_match('/(ipad|tablet)/i', $info)) {
                    $deviceType = 'tablet';
                } elseif (preg_match('/(ps4|ps5|playstation|xbox|switch|nintendo|consola)/i', $info)) {
                    $deviceType = 'console';
                } else {
                    $deviceType = 'desktop';
                }
            }

            // Crear Orden de Trabajo con UUID obligatorio y 0 abono por defecto
            $workOrder = WorkOrder::create([
                'uuid'               => (string) Str::uuid(),
                'client_id'          => $client->id,
                'device_type'        => $deviceType,
                'brand_model'        => $quote->device_info ?? 'Equipo Presupuestado',
                'reported_issue'     => 'Trabajo según Cotización ' . $quote->quote_number . ': ' . implode(', ', $quote->items->pluck('description')->toArray()),
                'status'             => 'Ingresado',
                'estimated_delivery' => Carbon::now()->addDays(2),
                'estimated_cost'     => $quote->total,
                'labor_cost'         => $quote->services_total,
                'down_payment'       => 0, // Inicia en 0 (sin abono ficticio)
                'technician_id'      => auth()->id(),
                'received_by_user_id' => auth()->id(),
            ]);

            $quote->update([
                'status' => 'convertida',
                'work_order_id' => $workOrder->id,
            ]);

            session()->flash('success', 'Cotización ' . $quote->quote_number . ' convertida exitosamente a Orden de Trabajo #' . $workOrder->id);
            return redirect()->route('work-orders.index');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al convertir cotización a OT: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al convertir la cotización: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Quotation::with(['client', 'user', 'items'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('quote_number', 'like', '%' . $this->search . '%')
                  ->orWhere('client_name', 'like', '%' . $this->search . '%')
                  ->orWhere('device_info', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $quotations = $query->paginate(10);

        return view('livewire.quotations.list-quotations', [
            'quotations' => $quotations,
        ])->layout('layouts.app');
    }
}
