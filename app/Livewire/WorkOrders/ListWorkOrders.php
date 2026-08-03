<?php

namespace App\Livewire\WorkOrders;

use App\Models\WorkOrder;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WorkOrderImage;
use App\Services\ImageOptimizer;

class ListWorkOrders extends Component
{
    use WithFileUploads;

    public string $search = '';
    public string $statusFilter = ''; // Empty string means 'All'
    public string $dateFrom = '';
    public string $dateTo = '';
    public string $technicianFilter = '';
    public bool $hasWarrantyFilter = false;
    public bool $hasPendingBalanceFilter = false;


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

    // Unified Modal Properties
    public $isManaging = false;
    public $activeTab = 'details'; // 'details', 'logs', 'gallery', 'share', 'payments'

    // Technician assignment
    public $managingTechnicianId = null;

    // Add Payment Properties
    public $newPaymentAmount = 0;
    public $newPaymentMethod = 'Efectivo';
    public $newPaymentDescription = 'Abono Parcial';

    // Billing/Factura Properties
    public $documentType = 'Ticket Interno'; // Ticket Interno, Boleta, Factura
    public $clientCompanyName = '';
    public $clientBusinessActivity = '';
    public $clientAddress = '';
    public $clientCommune = '';

    // Delivery Modal Properties
    public $isDelivering = false;
    public $deliveringOrderId = null;
    public $deliveringOrderCode = '';
    public $deliveryWarrantyMonths = 3;
    public $deliveryNotes = '';
    public $deliveryBalanceDue = 0;
    public $deliveryPayBalance = false;
    public $deliveryPaymentMethod = 'Efectivo';

    public function openWorkOrderDetails($id)
    {
        $order = WorkOrder::with(['client', 'parts', 'images', 'logs', 'payments.user', 'technician', 'receivedBy'])->findOrFail($id);
        
        // 1. Bitacora / Log properties initialization
        $this->loggingOrderId = $order->id;
        $this->loggingOrderCode = substr($order->uuid, 0, 8);
        $this->newLogTitle = 'Avance Técnico';
        $this->newLogNotes = '';
        $this->newLogPhoto = null;
        $this->uploadPhoto = null;
        $this->uploadPhotoType = 'progress';
        
        // 2. Budget / Editing properties initialization
        $this->editingOrderId = $order->id;
        $this->editingOrderCode = substr($order->uuid, 0, 8);
        $this->editingLaborCost = round($order->labor_cost);
        if ($order->estimated_delivery) {
            try {
                $this->editingEstimatedDelivery = \Carbon\Carbon::parse($order->estimated_delivery)->format('Y-m-d');
            } catch (\Exception $e) {
                $this->editingEstimatedDelivery = \Carbon\Carbon::now()->addDays(2)->format('Y-m-d');
            }
        } else {
            $this->editingEstimatedDelivery = \Carbon\Carbon::now()->addDays(2)->format('Y-m-d');
        }
        $this->forceEditBudget = false;
        
        // Try to fetch diagnostic notes from recent budget log
        $diagnosticLog = $order->logs()
            ->where('title', 'Diagnóstico y Presupuesto Listo')
            ->first();
        if ($diagnosticLog) {
            $notes = $diagnosticLog->notes;
            if (preg_match('/Diagnóstico Técnico:\s*(.*?)\nPresupuesto establecido:/s', $notes, $matches)) {
                $this->editingDiagnosticNotes = trim($matches[1]);
            } else {
                $this->editingDiagnosticNotes = $notes;
            }
        } else {
            $this->editingDiagnosticNotes = '';
        }

        // Initialize Technician
        $this->managingTechnicianId = $order->technician_id;

        // Reset Payment properties
        $this->newPaymentAmount = 0;
        $this->newPaymentMethod = 'Efectivo';
        $this->newPaymentDescription = 'Abono Parcial';
        
        $this->documentType = 'Ticket Interno';
        if ($order->client) {
            $this->clientCompanyName = $order->client->company_name ?? '';
            $this->clientBusinessActivity = $order->client->business_activity ?? '';
            $this->clientAddress = $order->client->address ?? '';
            $this->clientCommune = $order->client->commune ?? '';
        }

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

        $this->editingSearchPart = '';
        $this->editingFoundParts = [];
        
        $this->loadCurrentImages();
        
        $this->activeTab = 'details';
        $this->isManaging = true;
    }

    public function startLogging($id)
    {
        $this->openWorkOrderDetails($id);
        $this->activeTab = 'logs';
    }

    public function loadCurrentImages()
    {
        $this->currentOrderImages = WorkOrderImage::where('work_order_id', $this->loggingOrderId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function closeManagingModal()
    {
        $this->isManaging = false;
        $this->loggingOrderId = null;
        $this->editingOrderId = null;
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
            $fileName = ImageOptimizer::optimizeAndStore($this->newLogPhoto, 'work-orders');
            
            // Auto add to WorkOrderImage (so it also appears in the gallery!)
            $order->images()->create([
                'type' => 'progress',
                'image_path' => $fileName,
            ]);
        }

        $oldStatus = $order->status;
        $statusChanged = false;

        if ($order->status === 'Ingresado') {
            $order->status = 'En Revisión';
            $order->save();
            $statusChanged = true;
        }

        $order->logs()->create([
            'status' => $order->status,
            'title' => $this->newLogTitle,
            'notes' => $this->newLogNotes,
            'image_path' => $fileName,
            'user_id' => auth()->id(),
        ]);

        if ($statusChanged) {
            $order->logs()->create([
                'status' => 'En Revisión',
                'title' => 'Revisión Técnica en Curso',
                'notes' => 'El sistema actualizó automáticamente el estado a "En Revisión" tras el primer registro técnico.',
                'user_id' => auth()->id(),
            ]);
        }

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
        
        $fileName = ImageOptimizer::optimizeAndStore($this->uploadPhoto, 'work-orders');

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
    }

    public function startRepair()
    {
        $order = WorkOrder::findOrFail($this->editingOrderId);
        if ($order->status !== 'Aprobado') return;

        $order->update(['status' => 'En Reparación']);
        $order->logs()->create([
            'status' => 'En Reparación',
            'title' => 'Reparación en Proceso',
            'notes' => 'El técnico ha iniciado las labores de reparación y cambio de componentes del equipo.',
            'user_id' => auth()->id(),
        ]);
        
        session()->flash('message', 'La orden ha pasado a estado En Reparación.');
        $this->openWorkOrderDetails($order->id);
    }

    public function finishRepair()
    {
        $order = WorkOrder::findOrFail($this->editingOrderId);
        if ($order->status !== 'En Reparación') return;

        $order->update(['status' => 'Listo para Entrega']);
        $order->logs()->create([
            'status' => 'Listo para Entrega',
            'title' => 'Reparación Finalizada',
            'notes' => 'El proceso de reparación ha concluido exitosamente y el equipo ha pasado todos los controles de calidad. Listo para retiro.',
            'user_id' => auth()->id(),
        ]);
        
        session()->flash('message', 'La orden ha pasado a estado Listo para Entrega.');
        $this->openWorkOrderDetails($order->id);
    }

    // Budgeting & Diagnostic Modal Properties
    public $isBudgeting = false;
    public $editingOrderId = null;
    public $editingOrderCode = '';
    public $editingLaborCost = 0;
    public $editingDiagnosticNotes = '';
    public $editingEstimatedDelivery = '';
    public $editingSelectedParts = []; // array of ['id', 'name', 'sale_price', 'quantity']
    public $editingSearchPart = '';
    public $editingFoundParts = [];
    public $forceEditBudget = false;

    public function unlockBudgetEditing()
    {
        $this->forceEditBudget = true;
    }

    public function updatedEditingSearchPart()
    {
        if (strlen($this->editingSearchPart) >= 1) {
            $this->editingFoundParts = \App\Models\Inventory::where('name', 'like', '%' . $this->editingSearchPart . '%')
                ->orWhere('category', 'like', '%' . $this->editingSearchPart . '%')
                ->take(6)->get();
        } else {
            $this->editingFoundParts = [];
        }
    }


    public function startBudgeting($id)
    {
        $this->openWorkOrderDetails($id);
        $this->activeTab = 'details';
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
            'editingEstimatedDelivery' => 'nullable|string|max:255',
        ]);

        $order = WorkOrder::findOrFail($this->editingOrderId);
        
        // 1. Devolver stock de repuestos cargados anteriormente para recalcular
        foreach ($order->parts as $oldPart) {
            $inv = \App\Models\Inventory::find($oldPart->id);
            if ($inv) {
                $inv->increment('stock', (int)$oldPart->pivot->quantity);
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
                $inv->decrement('stock', (int)$part['quantity']);
            }
        }
        $order->parts()->sync($syncParts);

        // Calcular costo total de repuestos
        $partsCost = collect($this->editingSelectedParts)->sum(function($p) {
            return $p['sale_price'] * $p['quantity'];
        });
        $totalBudget = (float)$this->editingLaborCost + $partsCost;

        // 3. Actualizar la orden de trabajo (preservando Aprobado, En Reparación, etc.)
        $newStatus = in_array($order->status, ['Aprobado', 'En Reparación', 'Listo para Entrega', 'Entregado']) 
            ? $order->status 
            : 'Presupuestado';

        $order->update([
            'labor_cost' => $this->editingLaborCost,
            'status' => $newStatus,
            'estimated_delivery' => $this->editingEstimatedDelivery ?: $order->estimated_delivery
        ]);

        // 4. Registrar en la bitácora
        $logTitle = ($newStatus === 'Presupuestado') ? 'Diagnóstico y Presupuesto Listo' : 'Presupuesto Actualizado';
        $logNotes = "Diagnóstico Técnico: " . $this->editingDiagnosticNotes . "\nPresupuesto establecido: Mano de obra $" . number_format($this->editingLaborCost, 0, ',', '.') . " + Repuestos $" . number_format($partsCost, 0, ',', '.') . " (Total del Presupuesto: $" . number_format($totalBudget, 0, ',', '.') . ").\n" . ($this->editingEstimatedDelivery ? "Tiempo Estimado de Entrega: " . $this->editingEstimatedDelivery . ".\n" : "") . ($newStatus === 'Presupuestado' ? "Esperando aprobación del cliente." : "Orden con estado activo (" . $newStatus . ").");

        $order->logs()->create([
            'status' => $newStatus,
            'title' => $logTitle,
            'notes' => $logNotes,
            'user_id' => auth()->id(),
        ]);


        $this->isBudgeting = false;
        $this->isManaging = false;
        session()->flash('message', "Presupuesto y diagnóstico para la orden #{$this->editingOrderCode} guardados exitosamente.");
    }

    public function updateStatus($workOrderId, $newStatus)
    {
        if (!auth()->user()->hasRole(['admin', 'tecnico'])) {
            session()->flash('message', 'No tienes autorización para realizar esta acción.');
            return;
        }

        if ($newStatus === 'Entregado') {
            $this->initiateDelivery($workOrderId);
            return;
        }

        $statusInfo = [
            'Ingresado' => ['title' => 'Recepción de Dispositivo', 'notes' => 'El equipo se encuentra registrado en cola de espera.'],
            'En Revisión' => ['title' => 'Revisión Técnica en Curso', 'notes' => 'El técnico ha tomado el equipo y ha comenzado el diagnóstico y revisión física del dispositivo.'],
            'Presupuestado' => ['title' => 'Diagnóstico y Presupuesto', 'notes' => 'El técnico ha finalizado el diagnóstico. El presupuesto ha sido calculado y está en espera de la aprobación del cliente.'],
            'Aprobado' => ['title' => 'Presupuesto Aprobado', 'notes' => 'El cliente ha aprobado el presupuesto propuesto. El equipo queda en cola para reparación.'],
            'Esperando Repuestos' => ['title' => 'En Espera de Repuestos', 'notes' => 'Estamos a la espera de que los repuestos lleguen de proveedor para iniciar la reparación.'],
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

        $wo->logs()->create([
            'status' => $newStatus,
            'title' => $statusInfo[$newStatus]['title'],
            'notes' => $statusInfo[$newStatus]['notes'],
            'user_id' => auth()->id(),
        ]);

        $this->sendOtStatusEmail($wo, $newStatus);

        session()->flash('message', "El estado ha sido actualizado a: {$newStatus}");
    }

    protected function sendOtStatusEmail(WorkOrder $wo, string $newStatus)
    {
        $settings = \App\Models\Setting::find(1);
        if ($settings && isset($settings->notify_on_ot_status) && !$settings->notify_on_ot_status) {
            return;
        }

        $clientEmail = $wo->client?->email;
        if ($clientEmail) {
            try {
                \App\Services\MailService::configureSmtp();
                \Illuminate\Support\Facades\Mail::to($clientEmail)
                    ->send(new \App\Mail\WorkOrderStatusChanged($wo, $newStatus));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("No se pudo enviar correo de cambio de estado de OT #{$wo->id}: " . $e->getMessage());
            }
        }
    }

    public function initiateDelivery($workOrderId)
    {
        $wo = WorkOrder::findOrFail($workOrderId);
        $this->deliveringOrderId = $wo->id;
        $this->deliveringOrderCode = substr($wo->uuid, 0, 8);
        
        $settings = \App\Models\Setting::find(1);

        // Detectar si fue recepcionado con humedad / contacto de líquido
        $hasLiquidContact = isset($wo->checklist['liquid_contact']) && in_array(strtolower($wo->checklist['liquid_contact']), ['sí', 'si', 'yes']);

        if ($hasLiquidContact) {
            $this->deliveryWarrantyMonths = 0;
            $this->deliveryNotes = 'Equipo ingresado con antecedente de humedad / contacto con líquido. Se entrega SIN GARANTÍA por riesgo de sulfatación o corrosión posterior.';
        } else {
            $this->deliveryWarrantyMonths = $wo->warranty_months ?? ($settings?->warranty_months ?? 3);
            $this->deliveryNotes = '';
        }
        
        $totalCost = $wo->labor_cost + $wo->parts->sum(function($p) { return $p->pivot->price_at_time * $p->pivot->quantity; });
        $this->deliveryBalanceDue = max(0, $totalCost - $wo->down_payment);
        $this->deliveryPayBalance = false;
        $this->deliveryPaymentMethod = 'Efectivo';
        $this->documentType = 'Ticket Interno';
        
        if ($wo->client) {
            $this->clientCompanyName = $wo->client->company_name ?? '';
            $this->clientBusinessActivity = $wo->client->business_activity ?? '';
            $this->clientAddress = $wo->client->address ?? '';
            $this->clientCommune = $wo->client->commune ?? '';
        }
        
        $this->isDelivering = true;
    }

    public function processDelivery()
    {
        $wo = WorkOrder::findOrFail($this->deliveringOrderId);

        $totalCost = $wo->labor_cost + $wo->parts->sum(function($p) { return $p->pivot->price_at_time * $p->pivot->quantity; });
        $balanceDue = max(0, $totalCost - $wo->down_payment);

        // 1. Validación por Rol: Si hay saldo pendiente y NO se marca para pagar en caja
        if ($balanceDue > 0 && !$this->deliveryPayBalance) {
            if (!auth()->user()->hasRole('admin')) {
                session()->flash('error', '⚠️ No tienes autorización para entregar un equipo con saldo pendiente sin registrar su pago. Esta acción requiere permisos de Administrador.');
                return;
            }
        }

        // 2. Validación de Caja Abierta y Factura antes de realizar cambios en BD si va a cobrar
        $activeRegister = null;
        if ($this->deliveryPayBalance && $balanceDue > 0) {
            $activeRegister = \App\Models\CashRegister::where('status', 'open')
                ->whereDate('opened_at', \Carbon\Carbon::today())
                ->first();

            if (!$activeRegister) {
                session()->flash('error', '⚠️ No se puede entregar ni cobrar la Orden porque la Caja Diaria está cerrada. Abre la caja del día primero.');
                return;
            }

            if ($this->documentType === 'Factura') {
                $this->validate([
                    'clientCompanyName' => 'required|string',
                    'clientBusinessActivity' => 'required|string',
                    'clientAddress' => 'required|string',
                    'clientCommune' => 'required|string',
                ]);
            }
        }

        // 3. Actualizar estado de la OT a Entregado
        $wo->status = 'Entregado';
        $wo->delivered_at = \Carbon\Carbon::now();
        $wo->warranty_months = (int)$this->deliveryWarrantyMonths;
        $wo->save();

        $notes = 'El equipo ha sido devuelto formalmente al cliente. Garantía y orden de servicio cerradas.';
        if ($this->deliveryNotes) {
            $notes .= "\nNotas de entrega: " . $this->deliveryNotes;
        }

        if ($wo->warranty_months > 0) {
            $expiryDate = \Carbon\Carbon::now()->addMonths($wo->warranty_months);
            $notes .= "\n\nGarantía de {$wo->warranty_months} mes(es) vigente hasta el {$expiryDate->format('d/m/Y')}. Aplica exclusivamente por fallas de funcionamiento de las piezas reemplazadas (No cubre humedad, sulfatación ni golpes).";
        } else {
            $notes .= "\n\n⚠️ SE ENTREGA SIN GARANTÍA DE REPARACIÓN (Exclusión por humedad, riesgo de placa o condiciones del servicio).";
        }

        // Si fue entregado con saldo pendiente autorizado por Admin
        if ($balanceDue > 0 && !$this->deliveryPayBalance && auth()->user()->hasRole('admin')) {
            $notes .= "\n\n⚠️ ENTREGA CON SALDO PENDIENTE AUTORIZADA POR ADMINISTRADOR (" . auth()->user()->name . "). Saldo por cobrar: $" . number_format($balanceDue, 0, ',', '.');
        }

        $wo->logs()->create([
            'status' => 'Entregado',
            'title' => ($balanceDue > 0 && !$this->deliveryPayBalance) ? 'Equipo Entregado (Autorizado sin Pago)' : 'Equipo Entregado',
            'notes' => $notes,
            'user_id' => auth()->id(),
        ]);

        // 4. Registrar pago si corresponde
        if ($this->deliveryPayBalance && $balanceDue > 0 && $activeRegister) {
            if ($this->documentType === 'Factura' && $wo->client) {
                $wo->client->update([
                    'company_name' => $this->clientCompanyName,
                    'business_activity' => $this->clientBusinessActivity,
                    'address' => $this->clientAddress,
                    'commune' => $this->clientCommune,
                ]);
            }

            $payment = \App\Models\Payment::create([
                'cash_register_id' => $activeRegister->id,
                'work_order_id' => $wo->id,
                'type' => 'income',
                'amount' => $balanceDue,
                'payment_method' => $this->deliveryPaymentMethod,
                'document_type' => $this->documentType,
                'description' => 'Pago final de saldo OT #' . substr($wo->uuid, 0, 8),
                'user_id' => auth()->id(),
            ]);

            $this->dispatch('payment-registered', paymentId: $payment->id);

            $wo->down_payment += $balanceDue;
            $wo->save();

            $wo->logs()->create([
                'status' => 'Entregado',
                'title' => 'Pago Final Registrado',
                'notes' => 'Se registró el pago del saldo pendiente por $' . number_format($balanceDue, 0, ',', '.') . ' mediante ' . $this->deliveryPaymentMethod,
                'user_id' => auth()->id(),
            ]);
        }

        $this->sendOtStatusEmail($wo, 'Entregado');

        $this->isDelivering = false;
        session()->flash('message', "El equipo de la orden #{$this->deliveringOrderCode} ha sido entregado exitosamente.");
    }

    public function reenterWarranty($workOrderId)
    {
        if (!auth()->user()->hasRole(['admin', 'tecnico'])) {
            session()->flash('message', 'No tienes autorización para realizar esta acción.');
            return;
        }

        $wo = WorkOrder::findOrFail($workOrderId);
        $wo->update(['status' => 'Garantía']);

        $wo->logs()->create([
            'status' => 'Garantía',
            'title' => 'Reingreso por Garantía',
            'notes' => 'El dispositivo ha reingresado al taller bajo concepto de revisión por garantía tras una entrega previa. Pasa directo a mesa técnica para evaluar las condiciones y validez de la misma.',
            'user_id' => auth()->id(),
        ]);

        $this->closeManagingModal();
        session()->flash('message', "El equipo de la orden #" . substr($wo->uuid, 0, 8) . " ha reingresado al taller por Garantía.");
    }

    public function assignTechnician()
    {
        if (!auth()->user()->isAdmin()) {
            session()->flash('message', 'Solo administradores pueden asignar técnicos.');
            return;
        }

        $order = WorkOrder::findOrFail($this->editingOrderId);

        if ($order->status === 'Entregado') {
            session()->flash('message', 'No se puede cambiar el técnico asignado a una orden entregada al cliente.');
            $this->managingTechnicianId = $order->technician_id;
            return;
        }


        $order->technician_id = $this->managingTechnicianId ?: null;

        
        $techName = 'Nadie';
        if ($this->managingTechnicianId) {
            $tech = \App\Models\User::find($this->managingTechnicianId);
            $techName = $tech ? $tech->name : 'Nadie';
        }

        // Auto-advance to 'En Revisión' if it was 'Ingresado'
        if ($order->status === 'Ingresado' && $this->managingTechnicianId) {
            $order->status = 'En Revisión';
            $order->logs()->create([
                'status' => 'En Revisión',
                'title' => 'Técnico Asignado (' . $techName . ')',
                'notes' => 'La orden pasa automáticamente a revisión técnica tras asignar el técnico.',
                'user_id' => auth()->id(),
            ]);
        } else {
            $order->logs()->create([
                'status' => $order->status,
                'title' => 'Asignación de Técnico',
                'notes' => 'Técnico responsable asignado: ' . $techName,
                'user_id' => auth()->id(),
            ]);
        }

        $order->save();
        session()->flash('message', 'Técnico asignado correctamente.');
        $this->openWorkOrderDetails($this->editingOrderId);
    }

    public function addPayment()
    {
        $this->validate([
            'newPaymentAmount' => 'required|numeric|min:1',
            'newPaymentMethod' => 'required|string',
        ]);

        $order = WorkOrder::findOrFail($this->editingOrderId);

        // Verify open cash register
        $activeRegister = \App\Models\CashRegister::where('status', 'open')
            ->whereDate('opened_at', \Carbon\Carbon::today())
            ->first();

        if (!$activeRegister) {
            session()->flash('error', 'No puedes registrar un pago porque no hay una caja abierta para hoy.');
            return;
        }

        if ($this->documentType === 'Factura') {
            $this->validate([
                'clientCompanyName' => 'required|string',
                'clientBusinessActivity' => 'required|string',
                'clientAddress' => 'required|string',
                'clientCommune' => 'required|string',
            ]);
            $order->client->update([
                'company_name' => $this->clientCompanyName,
                'business_activity' => $this->clientBusinessActivity,
                'address' => $this->clientAddress,
                'commune' => $this->clientCommune,
            ]);
        }

        $payment = \App\Models\Payment::create([
            'cash_register_id' => $activeRegister->id,
            'work_order_id' => $order->id,
            'type' => 'income',
            'amount' => $this->newPaymentAmount,
            'payment_method' => $this->newPaymentMethod,
            'document_type' => $this->documentType,
            'description' => $this->newPaymentDescription ?: 'Abono Parcial OT #' . substr($order->uuid, 0, 8),
            'user_id' => auth()->id(),
        ]);
        
        $this->dispatch('payment-registered', paymentId: $payment->id);

        $order->down_payment += $this->newPaymentAmount;
        $order->save();

        $order->logs()->create([
            'status' => $order->status,
            'title' => 'Pago Registrado',
            'notes' => 'Se ha registrado un pago por $' . number_format($this->newPaymentAmount, 0, ',', '.') . ' mediante ' . $this->newPaymentMethod . '.',
            'user_id' => auth()->id(),
        ]);

        $this->newPaymentAmount = 0;
        $this->newPaymentDescription = 'Abono Parcial';

        session()->flash('message', 'Pago registrado exitosamente.');
        $this->openWorkOrderDetails($this->editingOrderId);
    }

    public function exportCSV()
    {
        $query = WorkOrder::with('client', 'technician')->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('brand_model', 'like', '%' . $this->search . '%')
                  ->orWhere('device_type', 'like', '%' . $this->search . '%')
                  ->orWhere('imei_serial', 'like', '%' . $this->search . '%')
                  ->orWhereHas('client', function($cq) {
                      $cq->where('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        if ($this->technicianFilter) {
            if ($this->technicianFilter === 'unassigned') {
                $query->whereNull('technician_id');
            } else {
                $query->where('technician_id', $this->technicianFilter);
            }
        }

        if ($this->hasWarrantyFilter) {
            $query->where('status', 'Entregado')
                  ->whereNotNull('delivered_at');
        }

        $workOrders = $query->get();
        
        if ($this->hasWarrantyFilter) {
            $workOrders = $workOrders->filter(function($wo) {
                return $wo->warrantyStatus['status'] === 'active';
            });
        }

        $csvData = "Código OT,Cliente,Equipo,Estado,Costo,Abono,Técnico,Fecha\n";
        foreach ($workOrders as $order) {
            $techName = $order->technician ? $order->technician->name : 'No Asignado';
            $csvData .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s\n",
                substr($order->uuid, 0, 8),
                '"' . $order->client->full_name . '"',
                '"' . $order->brand_model . '"',
                $order->status,
                $order->labor_cost,
                $order->down_payment,
                '"' . $techName . '"',
                $order->created_at->format('Y-m-d H:i')
            );
        }

        return response()->streamDownload(function () use ($csvData) {
            echo $csvData;
        }, 'reporte_ordenes_' . date('Y-m-d') . '.csv');
    }

    public function cancelWorkOrder($id, $reason = '')
    {
        if (!auth()->user()->isAdmin()) {
            session()->flash('error', 'Solo los Administradores tienen autorización para anular o desactivar órdenes de trabajo.');
            return;
        }

        $order = WorkOrder::findOrFail($id);

        if ($order->status === 'Entregado') {
            session()->flash('error', 'No se puede anular una orden que ya fue entregada formalmente al cliente.');
            return;
        }

        $oldStatus = $order->status;
        $order->update(['status' => 'Anulada']);

        $order->logs()->create([
            'status'  => 'Anulada',
            'title'   => 'Orden Anulada / Desactivada',
            'notes'   => 'La orden fue cambiada a estado "Anulada" (estado previo: ' . $oldStatus . '). Motivo: ' . ($reason ?: 'Solicitud de Administración'),
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', 'La orden de trabajo #' . substr($order->uuid, 0, 8) . ' ha sido desactivada y cambiada a estado "Anulada".');
        $this->closeManagingModal();
    }

    public function render()
    {
        $query = WorkOrder::with(['client', 'technician'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('brand_model', 'like', '%' . $this->search . '%')
                  ->orWhere('device_type', 'like', '%' . $this->search . '%')
                  ->orWhere('imei_serial', 'like', '%' . $this->search . '%')
                  ->orWhereHas('client', function($cq) {
                      $cq->where('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        if ($this->technicianFilter) {
            if ($this->technicianFilter === 'unassigned') {
                $query->whereNull('technician_id');
            } else {
                $query->where('technician_id', $this->technicianFilter);
            }
        }

        $allOrdersForStats = WorkOrder::with(['parts'])->where('status', '!=', 'Rechazado')->get();
        $totalPendingReceivables = 0;
        $pendingCount = 0;
        $totalCollected = 0;

        foreach ($allOrdersForStats as $woStat) {
            $partsCost = $woStat->parts->sum(function($p) { return $p->pivot->price_at_time * $p->pivot->quantity; });
            $totalCost = $woStat->labor_cost + $partsCost;
            $balance = max(0, $totalCost - $woStat->down_payment);
            $totalCollected += $woStat->down_payment;
            
            if ($balance > 0) {
                $totalPendingReceivables += $balance;
                $pendingCount++;
            }
        }

        $workOrders = $query->get();
        $technicians = \App\Models\User::whereIn('role', ['admin', 'tecnico'])->get();

        // Filtro de garantía activa
        if ($this->hasWarrantyFilter) {
            $workOrders = $workOrders->filter(function($wo) {
                return $wo->warrantyStatus['status'] === 'active';
            });
        }

        // Filtro de saldos pendientes por cobrar
        if ($this->hasPendingBalanceFilter) {
            $workOrders = $workOrders->filter(function($wo) {
                $partsCost = $wo->parts->sum(function($p) { return $p->pivot->price_at_time * $p->pivot->quantity; });
                $totalCost = $wo->labor_cost + $partsCost;
                return ($totalCost - $wo->down_payment) > 0;
            });
        }

        return view('livewire.work-orders.list-work-orders', [
            'workOrders' => $workOrders,
            'technicians' => $technicians,
            'totalPendingReceivables' => $totalPendingReceivables,
            'pendingCount' => $pendingCount,
            'totalCollected' => $totalCollected,
        ])->layout('layouts.app');
    }
}

