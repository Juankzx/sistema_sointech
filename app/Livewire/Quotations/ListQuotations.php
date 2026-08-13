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
            $quote = Quotation::findOrFail($id);

            if ($quote->status === 'convertida' && $quote->work_order_id) {
                session()->flash('error', 'Esta cotización ya fue convertida previamente a la Orden de Trabajo #' . $quote->work_order_id);
                return;
            }

            return redirect()->route('work-orders.create', ['from_quote' => $id]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al convertir cotización a OT: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar la cotización: ' . $e->getMessage());
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
