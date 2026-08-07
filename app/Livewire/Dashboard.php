<?php

namespace App\Livewire;

use App\Models\WorkOrder;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WorkOrderImage;
use App\Services\ImageOptimizer;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
    public $currentOrderImages = [];

    // Presupuesto Modal Properties
    public $isBudgeting = false;
    public $budgetingOrderId = null;
    public $budgetingOrderCode = '';
    public $budgetLaborCost = 0;
    public $budgetPartsCost = 0;
    public $budgetNotes = '';

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
            'newLogPhoto' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,heic,heif|max:30720',
        ]);

        $order = WorkOrder::findOrFail($this->loggingOrderId);
        
        $fileName = null;
        if ($this->newLogPhoto) {
            $fileName = ImageOptimizer::optimizeAndStore($this->newLogPhoto, 'work-orders');
            
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
            'uploadPhoto' => 'required|file|mimes:jpeg,png,jpg,gif,webp,heic,heif|max:30720',
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

        session()->flash('message', 'Fotografía guardada con éxito en la galería.');
    }

    public function updateStatus($orderId, $newStatus)
    {
        $wo = WorkOrder::findOrFail($orderId);
        $oldStatus = $wo->status;

        if ($oldStatus === $newStatus) return;

        $statusInfo = [
            'Ingresado' => ['title' => 'Equipo Registrado', 'notes' => 'Orden de trabajo ingresada al sistema.'],
            'En Revisión' => ['title' => 'Inicio de Evaluación', 'notes' => 'El equipo ha pasado a la mesa de diagnóstico técnico.'],
            'Presupuestado' => ['title' => 'Diagnóstico Finalizado', 'notes' => 'Diagnóstico completado. Presupuesto listo para aprobación.'],
            'Aprobado' => ['title' => 'Presupuesto Aprobado', 'notes' => 'El cliente ha autorizado la reparación del equipo.'],
            'Rechazado' => ['title' => 'Presupuesto Rechazado', 'notes' => 'El presupuesto fue rechazado por el cliente.'],
            'En Reparación' => ['title' => 'Reparación en Proceso', 'notes' => 'El técnico se encuentra trabajando en la reparación.'],
            'Listo para Entrega' => ['title' => 'Reparación Finalizada', 'notes' => 'El equipo completó las pruebas de calidad y está listo para ser retirado.'],
            'Entregado' => ['title' => 'Equipo Entregado', 'notes' => 'El equipo ha sido devuelto satisfactoriamente al cliente.'],
        ];

        $wo->update(['status' => $newStatus]);

        $logNotes = $statusInfo[$newStatus]['notes'] ?? 'Estado actualizado.';

        $wo->logs()->create([
            'status' => $newStatus,
            'title' => $statusInfo[$newStatus]['title'] ?? 'Cambio de Estado',
            'notes' => $logNotes,
            'user_id' => auth()->id(),
        ]);

        $this->sendOtStatusEmail($wo, $newStatus);

        session()->flash('message', "Estado de la orden #{$wo->id} actualizado a '{$newStatus}'.");
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

    public function render()
    {
        $user = auth()->user();

        if ($user->isCliente()) {
            $clientId = $user->client_id;
            $recentOrders = WorkOrder::with(['client', 'parts'])
                ->where('client_id', $clientId)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('livewire.client-dashboard', [
                'clientOrders' => $recentOrders,
            ])->layout('layouts.app');
        }

        // Stats principales
        $totalOrders = WorkOrder::count();
        $ingresadas = WorkOrder::where('status', 'Ingresado')->count();
        $enReparacion = WorkOrder::where('status', 'En Reparación')->count();
        $listas = WorkOrder::where('status', 'Listo para Entrega')->count();
        $entregadas = WorkOrder::where('status', 'Entregado')->count();
        $enRevision = WorkOrder::where('status', 'En Revisión')->count();
        $presupuestadas = WorkOrder::where('status', 'Presupuestado')->count();

        // Finanzas
        $totalRevenue = 0;
        if (auth()->user()->isAdmin()) {
            $downPayments = WorkOrder::sum('down_payment');
            $laborRevenue = WorkOrder::where('status', 'Entregado')->sum('labor_cost');
            $totalRevenue = $downPayments + $laborRevenue;
        }

        // Recientes (últimas 6 órdenes)
        $recentOrders = WorkOrder::with('client')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Datos para Gráfico de Tendencia de los últimos 7 días
        $start7 = Carbon::now()->subDays(6)->startOfDay();
        $end7 = Carbon::now()->endOfDay();
        $period = CarbonPeriod::create($start7, $end7);

        $chartLabels = [];
        $chartOrderCounts = [];

        foreach ($period as $date) {
            $dayStr = $date->format('Y-m-d');
            $chartLabels[] = $date->format('d/m');
            $chartOrderCounts[] = WorkOrder::whereDate('created_at', $dayStr)->count();
        }

        // Distribución por estado para gráfico dona
        $statusDistribution = [
            'Ingresado' => $ingresadas,
            'En Revisión' => $enRevision,
            'En Reparación' => $enReparacion,
            'Listo p/ Entrega' => $listas,
            'Entregado' => $entregadas,
        ];

        return view('livewire.dashboard', [
            'totalOrders' => $totalOrders,
            'ingresadas' => $ingresadas,
            'enReparacion' => $enReparacion,
            'listas' => $listas,
            'entregadas' => $entregadas,
            'enRevision' => $enRevision,
            'presupuestadas' => $presupuestadas,
            'totalRevenue' => $totalRevenue,
            'recentOrders' => $recentOrders,
            'chartLabels' => $chartLabels,
            'chartOrderCounts' => $chartOrderCounts,
            'statusDistribution' => $statusDistribution,
        ])->layout('layouts.app');
    }
}
