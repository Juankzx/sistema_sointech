<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\WorkOrder;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\Inventory;
use App\Models\Payment;
use Carbon\Carbon;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $dateRange = 'month'; // 'today', 'week', 'month', 'custom'
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->setDateRange();
    }

    public function updatedDateRange()
    {
        $this->setDateRange();
    }

    public function setDateRange()
    {
        $now = Carbon::now();

        switch ($this->dateRange) {
            case 'today':
                $this->startDate = $now->copy()->startOfDay()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfDay()->format('Y-m-d');
                break;
            case 'week':
                $this->startDate = $now->copy()->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfWeek()->format('Y-m-d');
                break;
            case 'month':
                $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                break;
            case 'custom':
                // Do not override if user selects custom and types dates
                if (!$this->startDate) $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                if (!$this->endDate) $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                break;
        }
    }

    public function render()
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        // 1. Órdenes de Trabajo
        $workOrders = WorkOrder::whereBetween('created_at', [$start, $end])->get();
        $otTotalRecaudado = Payment::whereBetween('created_at', [$start, $end])->sum('amount');
        
        $otStatuses = $workOrders->groupBy('status')->map->count();
        $otCount = $workOrders->count();

        // 2. Ventas POS
        $sales = Sale::whereBetween('created_at', [$start, $end])->get();
        $totalSales = $sales->sum('total');
        $salesByMethod = $sales->groupBy('payment_method')->map->sum('total');

        // 3. Finanzas (Egresos)
        $expenses = Expense::whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])->get();
        $totalExpenses = $expenses->sum('total_amount');

        // 4. Inventario (Current Snapshot)
        $inventoryItems = Inventory::all();
        $inventoryValue = $inventoryItems->sum(function($item) {
            return $item->stock * $item->cost;
        });
        $inventorySaleValue = $inventoryItems->sum(function($item) {
            return $item->stock * $item->price;
        });
        $lowStockItems = $inventoryItems->where('stock', '<=', 5);

        // Ganancia Bruta Estimada
        $netProfit = ($totalSales + $otTotalRecaudado) - $totalExpenses;

        return view('livewire.reports.dashboard', [
            'otCount' => $otCount,
            'otTotalRecaudado' => $otTotalRecaudado,
            'otStatuses' => $otStatuses,
            
            'totalSales' => $totalSales,
            'salesCount' => $sales->count(),
            'salesByMethod' => $salesByMethod,
            
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            
            'inventoryValue' => $inventoryValue,
            'inventorySaleValue' => $inventorySaleValue,
            'lowStockCount' => $lowStockItems->count(),
        ]);
    }
}
