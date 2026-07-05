<?php

namespace App\Livewire;

use App\Models\WorkOrder;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WorkOrderImage;

class Dashboard extends Component
{
    use WithFileUploads;

    // Bitacora & Photo Modal Properties
    public $isLogging = false;
    public $loggingOrderId = null;
    public $loggingOrderCode = '';
    public $newLogTitle = 'Avance Técnico';
    public $newLogNotes = '';
    public $newLogPhoto;
    public $uploadPhoto;
    public $uploadPhotoType = 'progress'; // 'before', 'progress', 'after'
    public $currentOrderImages = []; // to display in the modal gallery

    public function startLogging($id)
    {
        $order = WorkOrder::with('images')->findOrFail($id);
        $this->loggingOrderId = $order->id;
        $this->loggingOrderCode = substr($order->uuid, 0, 8);
        $this->newLogTitle = 'Avance Técnico';
        $this->newLogNotes = '';
        $this->newLogPhoto = null;
        $this->uploadPhoto = null;
        $this->uploadPhotoType = 'progress';
        
        $this->loadCurrentImages();
        $this->isLogging = true;
    }

    public function loadCurrentImages()
    {
        $this->currentOrderImages = WorkOrderImage::where('work_order_id', $this->loggingOrderId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function saveManualLog()
    {
        $this->validate([
            'newLogNotes' => 'required|string|min:5',
            'newLogTitle' => 'required|string|max:100',
            'newLogPhoto' => 'nullable|image|max:10240', // 10MB max
        ]);

        $order = WorkOrder::findOrFail($this->loggingOrderId);
        
        $fileName = null;
        if ($this->newLogPhoto) {
            $extension = $this->newLogPhoto->getClientOriginalExtension();
            $fileName = 'work-orders/' . uniqid() . '.' . $extension;
            
            $publicPath = storage_path('app/public/work-orders');
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            
            file_put_contents(storage_path('app/public/' . $fileName), file_get_contents($this->newLogPhoto->getRealPath()));
            
            // Auto add to WorkOrderImage (so it also appears in the gallery!)
            $order->images()->create([
                'type' => 'progress',
                'image_path' => $fileName,
            ]);
        }

        $order->logs()->create([
            'status' => $order->status,
            'title' => $this->newLogTitle,
            'notes' => $this->newLogNotes,
            'image_path' => $fileName,
            'user_id' => auth()->id(),
        ]);

        $this->newLogNotes = '';
        $this->newLogTitle = 'Avance Técnico';
        $this->newLogPhoto = null;
        
        $this->loadCurrentImages();
        
        session()->flash('message', 'Comentario de bitácora agregado con éxito.');
    }

    public function uploadProgressPhoto()
    {
        $this->validate([
            'uploadPhoto' => 'required|image|max:10240', // 10MB max
            'uploadPhotoType' => 'required|in:before,progress,after',
        ]);

        $order = WorkOrder::findOrFail($this->loggingOrderId);
        
        $extension = $this->uploadPhoto->getClientOriginalExtension();
        $fileName = 'work-orders/' . uniqid() . '.' . $extension;
        
        $publicPath = storage_path('app/public/work-orders');
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }
        
        file_put_contents(storage_path('app/public/' . $fileName), file_get_contents($this->uploadPhoto->getRealPath()));

        $order->images()->create([
            'type' => $this->uploadPhotoType,
            'image_path' => $fileName,
        ]);

        $this->uploadPhoto = null;
        $this->loadCurrentImages();
        
        $typeLabels = [
            'before' => 'Foto de Estado Inicial (Antes)',
            'progress' => 'Foto de Avance de Reparación',
            'after' => 'Foto de Resultado Final (Después)',
        ];
        $label = $typeLabels[$this->uploadPhotoType] ?? 'Foto de Avance';
        
        $order->logs()->create([
            'status' => $order->status,
            'title' => $label,
            'notes' => 'Se ha cargado una nueva evidencia fotográfica de la reparación al sistema para el seguimiento del cliente.',
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', 'Foto de progreso subida con éxito.');
    }

    public function deleteProgressPhoto($imageId)
    {
        $image = WorkOrderImage::findOrFail($imageId);
        $filePath = storage_path('app/public/' . $image->image_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $image->delete();
        $this->loadCurrentImages();
        session()->flash('message', 'Foto de progreso eliminada con éxito.');
    }
    // Budgeting & Diagnostic Modal Properties
    public $isBudgeting = false;
    public $editingOrderId = null;
    public $editingOrderCode = '';
    public $editingLaborCost = 0;
    public $editingDiagnosticNotes = '';
    public $editingSelectedParts = []; // array of ['id', 'name', 'sale_price', 'quantity']
    public $editingSearchPart = '';
    public $editingFoundParts = [];

    public function updatedEditingSearchPart()
    {
        if(strlen($this->editingSearchPart) > 2) {
            $this->editingFoundParts = \App\Models\Inventory::where('name', 'like', '%' . $this->editingSearchPart . '%')
                ->orWhere('category', 'like', '%' . $this->editingSearchPart . '%')
                ->take(5)->get();
        } else {
            $this->editingFoundParts = [];
        }
    }

    public function startBudgeting($id)
    {
        $order = WorkOrder::with('parts')->findOrFail($id);
        $this->editingOrderId = $order->id;
        $this->editingOrderCode = substr($order->uuid, 0, 8);
        $this->editingLaborCost = $order->labor_cost;
        
        // Cargar repuestos asociados previamente
        $this->editingSelectedParts = [];
        foreach ($order->parts as $part) {
            $this->editingSelectedParts[] = [
                'id' => $part->id,
                'name' => $part->name,
                'sale_price' => $part->pivot->price_at_time,
                'quantity' => $part->pivot->quantity,
            ];
        }
        
        $this->editingDiagnosticNotes = '';
        $this->editingSearchPart = '';
        $this->editingFoundParts = [];
        $this->isBudgeting = true;
    }

    public function addEditingPart($id)
    {
        $part = \App\Models\Inventory::find($id);
        if($part && $part->stock > 0) {
            $this->editingSelectedParts[] = [
                'id' => $part->id,
                'name' => $part->name,
                'sale_price' => $part->sale_price,
                'quantity' => 1
            ];
            $this->editingSearchPart = '';
            $this->editingFoundParts = [];
        }
    }

    public function removeEditingPart($index)
    {
        unset($this->editingSelectedParts[$index]);
        $this->editingSelectedParts = array_values($this->editingSelectedParts);
    }

    public function saveBudget()
    {
        if (!auth()->user()->hasRole(['admin', 'tecnico'])) {
            session()->flash('message', 'No tienes autorización para realizar esta acción.');
            return;
        }

        $this->validate([
            'editingLaborCost' => 'required|numeric|min:0',
            'editingDiagnosticNotes' => 'required|string|min:5',
        ]);

        $order = WorkOrder::findOrFail($this->editingOrderId);
        
        // 1. Devolver stock de repuestos cargados anteriormente para recalcular
        foreach ($order->parts as $oldPart) {
            $inv = \App\Models\Inventory::find($oldPart->id);
            if ($inv) {
                $inv->stock += $oldPart->pivot->quantity;
                $inv->save();
            }
        }

        // 2. Asociar nuevos repuestos y descontar del inventario
        $syncParts = [];
        foreach ($this->editingSelectedParts as $part) {
            $syncParts[$part['id']] = [
                'quantity' => $part['quantity'],
                'price_at_time' => $part['sale_price']
            ];

            $inv = \App\Models\Inventory::find($part['id']);
            if ($inv) {
                $inv->stock -= $part['quantity'];
                $inv->save();
            }
        }
        $order->parts()->sync($syncParts);

        // Calcular costo total de repuestos
        $partsCost = collect($this->editingSelectedParts)->sum(function($p) {
            return $p['sale_price'] * $p['quantity'];
        });
        $totalBudget = (float)$this->editingLaborCost + $partsCost;

        // 3. Actualizar la orden de trabajo a Presupuestado
        $order->update([
            'labor_cost' => $this->editingLaborCost,
            'status' => 'Presupuestado'
        ]);

        // 4. Registrar en la bitácora
        $order->logs()->create([
            'status' => 'Presupuestado',
            'title' => 'Diagnóstico y Presupuesto Listo',
            'notes' => "Diagnóstico Técnico: " . $this->editingDiagnosticNotes . "\nPresupuesto establecido: Mano de obra $" . number_format($this->editingLaborCost, 0, ',', '.') . " + Repuestos $" . number_format($partsCost, 0, ',', '.') . " (Total del Presupuesto: $" . number_format($totalBudget, 0, ',', '.') . "). Esperando aprobación del cliente.",
            'user_id' => auth()->id(),
        ]);

        $this->isBudgeting = false;
        session()->flash('message', "Presupuesto y diagnóstico para la orden #{$this->editingOrderCode} guardados exitosamente.");
    }

    public function updateStatus($workOrderId, $newStatus)
    {
        if (!auth()->user()->hasRole(['admin', 'tecnico'])) {
            session()->flash('message', 'No tienes autorización para realizar esta acción.');
            return;
        }

        $statusInfo = [
            'Ingresado' => ['title' => 'Recepción de Dispositivo', 'notes' => 'El equipo se encuentra registrado en cola de espera.'],
            'En Revisión' => ['title' => 'Revisión Técnica en Curso', 'notes' => 'El técnico ha tomado el equipo y ha comenzado el diagnóstico y revisión física del dispositivo.'],
            'Presupuestado' => ['title' => 'Diagnóstico y Presupuesto', 'notes' => 'El técnico ha finalizado el diagnóstico. El presupuesto ha sido calculado y está en espera de la aprobación del cliente.'],
            'Aprobado' => ['title' => 'Presupuesto Aprobado', 'notes' => 'El cliente ha aprobado el presupuesto propuesto. El equipo queda en cola para reparación.'],
            'Rechazado' => ['title' => 'Presupuesto Rechazado', 'notes' => 'El cliente ha rechazado el presupuesto propuesto. Se procederá con la devolución del equipo sin reparar.'],
            'En Reparación' => ['title' => 'Reparación en Proceso', 'notes' => 'El técnico ha iniciado las labores de reparación y cambio de componentes del equipo.'],
            'Listo para Entrega' => ['title' => 'Reparación Finalizada', 'notes' => 'El proceso de reparación ha concluido exitosamente y el equipo ha pasado todos los controles de calidad. Listo para retiro.'],
            'Entregado' => ['title' => 'Equipo Entregado', 'notes' => 'El equipo ha sido devuelto formalmente al cliente. Garantía y orden de servicio cerradas.'],
        ];

        if (!array_key_exists($newStatus, $statusInfo)) {
            return;
        }

        $wo = WorkOrder::findOrFail($workOrderId);
        $oldStatus = $wo->status;
        $wo->update(['status' => $newStatus]);

        // Registrar en la bitácora
        $wo->logs()->create([
            'status' => $newStatus,
            'title' => $statusInfo[$newStatus]['title'],
            'notes' => $statusInfo[$newStatus]['notes'],
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', "El estado de la orden de trabajo #{$wo->id} ha cambiado de '{$oldStatus}' a '{$newStatus}' con registro en bitácora.");
    }

    public function render()
    {
        $user = auth()->user();

        if ($user->isCliente()) {
            $clientId = $user->client_id;
            $recentOrders = WorkOrder::with('client')
                ->where('client_id', $clientId)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('livewire.client-dashboard', [
                'clientOrders' => $recentOrders,
            ])->layout('layouts.app');
        }

        // General stats
        $totalOrders = WorkOrder::count();
        $ingresadas = WorkOrder::where('status', 'Ingresado')->count();
        $enReparacion = WorkOrder::where('status', 'En Reparación')->count();
        $listas = WorkOrder::where('status', 'Listo para Entrega')->count();
        $entregadas = WorkOrder::where('status', 'Entregado')->count();

        // Financial stats (Admin only)
        $totalRevenue = 0;
        if (auth()->user()->isAdmin()) {
            $downPayments = WorkOrder::sum('down_payment');
            $laborRevenue = WorkOrder::where('status', 'Entregado')->sum('labor_cost');
            $totalRevenue = $downPayments + $laborRevenue;
        }

        // Recent work orders
        $recentOrders = WorkOrder::with('client')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('livewire.dashboard', [
            'totalOrders' => $totalOrders,
            'ingresadas' => $ingresadas,
            'enReparacion' => $enReparacion,
            'listas' => $listas,
            'entregadas' => $entregadas,
            'totalRevenue' => $totalRevenue,
            'recentOrders' => $recentOrders,
        ])->layout('layouts.app');
    }
}
