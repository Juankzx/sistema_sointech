<?php

namespace App\Livewire\Public;

use App\Models\WorkOrder;
use Livewire\Component;

class TrackWorkOrder extends Component
{
    public WorkOrder $workOrder;
    public bool $sortAsc = false; // false = Más recientes primero, true = Más antiguos primero

    public function mount($uuid)
    {
        $this->workOrder = WorkOrder::with(['client', 'parts', 'logs', 'images'])
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    public function toggleSortOrder()
    {
        $this->sortAsc = !$this->sortAsc;
    }

    public function approveBudget()
    {
        if ($this->workOrder->status !== 'Presupuestado') {
            return;
        }

        $this->workOrder->update(['status' => 'Aprobado']);

        // Registrar avance en bitácora
        $this->workOrder->logs()->create([
            'status' => 'Aprobado',
            'title' => 'Presupuesto Aprobado por el Cliente',
            'notes' => 'El cliente ha revisado el presupuesto en línea y ha dado su aprobación formal para iniciar las labores de reparación.',
            'user_id' => null, // approved by public customer
        ]);

        session()->flash('message', '¡Presupuesto aprobado con éxito! Hemos notificado al taller e iniciaremos la reparación de tu equipo a la brevedad.');
        $this->workOrder->load(['logs', 'parts', 'images']);
    }

    public function rejectBudget()
    {
        if ($this->workOrder->status !== 'Presupuestado') {
            return;
        }

        $this->workOrder->update(['status' => 'Rechazado']);

        // Registrar rechazo en bitácora
        $this->workOrder->logs()->create([
            'status' => 'Rechazado',
            'title' => 'Presupuesto Rechazado por el Cliente',
            'notes' => 'El cliente ha revisado el presupuesto en línea y ha decidido rechazar los valores de reparación o el diagnóstico. El equipo pasa a cola de devolución sin reparar.',
            'user_id' => null,
        ]);

        session()->flash('message', 'Presupuesto rechazado. Procederemos a empaquetar tu equipo para devolvértelo en recepción.');
        $this->workOrder->load(['logs', 'parts', 'images']);
    }

    public function render()
    {
        $logs = $this->workOrder->logs;
        if ($this->sortAsc) {
            $logs = $logs->sortBy('created_at');
        } else {
            $logs = $logs->sortByDesc('created_at');
        }

        $latestLog = $this->workOrder->logs->sortByDesc('created_at')->first();

        return view('livewire.public.track-work-order', [
            'orderedLogs' => $logs,
            'latestLog'   => $latestLog,
        ])->layout('layouts.public');
    }
}
