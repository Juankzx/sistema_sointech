<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\WorkOrder;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Expense;
use App\Models\Inventory;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $dateRange = 'month'; // 'today', 'yesterday', 'week', 'month', 'last_month', 'year', 'custom'
    public $startDate;
    public $endDate;

    // Chart Reactive Properties
    public $chartLabels = [];
    public $chartSalesData = [];
    public $chartExpensesData = [];
    public $chartOtData = [];
    public $otStatusesMap = [];

    public function mount()
    {
        $this->setDateRange();
    }

    public function selectPreset($preset)
    {
        $this->dateRange = $preset;
        $this->setDateRange();
    }

    public function updatedDateRange()
    {
        $this->setDateRange();
    }

    public function updatedStartDate()
    {
        $this->dateRange = 'custom';
    }

    public function updatedEndDate()
    {
        $this->dateRange = 'custom';
    }

    public function setDateRange()
    {
        $now = Carbon::now();

        switch ($this->dateRange) {
            case 'today':
                $this->startDate = $now->copy()->startOfDay()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfDay()->format('Y-m-d');
                break;
            case 'yesterday':
                $this->startDate = $now->copy()->subDay()->startOfDay()->format('Y-m-d');
                $this->endDate = $now->copy()->subDay()->endOfDay()->format('Y-m-d');
                break;
            case 'week':
                $this->startDate = $now->copy()->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfWeek()->format('Y-m-d');
                break;
            case 'month':
                $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $this->startDate = $now->copy()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->copy()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case 'year':
                $this->startDate = $now->copy()->startOfYear()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfYear()->format('Y-m-d');
                break;
            case 'custom':
                if (!$this->startDate) $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                if (!$this->endDate) $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                break;
        }
    }

    public function render()
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        // 1. Órdenes de Trabajo y Separación de Mano de Obra (Utilidad) vs Repuestos/Envíos (Costo Cliente)
        $workOrders = WorkOrder::with(['client', 'parts', 'payments'])
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->get();

        $validWorkOrders = $workOrders->whereNotIn('status', ['Rechazado', 'Cancelado']);

        // Mano de Obra = La verdadera utilidad / ingreso que le queda al taller
        $otLaborIncome = (float) $validWorkOrders->sum(fn($wo) => $wo->effective_labor_cost);
        $otLaborRealized = (float) $validWorkOrders->sum(fn($wo) => $wo->status === 'Entregado' ? $wo->effective_labor_cost : $wo->realized_labor_revenue);

        // Repuestos + Envíos = Plata del cliente (reembolso a precio costo, NO es utilidad del taller)
        $otPartsTotal = (float) $validWorkOrders->sum(fn($wo) => $wo->parts_total);
        $otShippingTotal = (float) $validWorkOrders->sum(fn($wo) => (float) ($wo->shipping_cost ?? 0));
        $otThirdPartyTotal = $otPartsTotal + $otShippingTotal;

        // Total general cobrado / recaudado en caja por OTs (incluyendo repuestos + envío + mano de obra)
        $otTotalRecaudado = (float) $validWorkOrders->sum(fn($wo) => $wo->status === 'Entregado' ? $wo->calculated_total : $wo->paid_amount);

        $otStatuses = $workOrders->groupBy('status')->map->count();
        $otCount = $workOrders->count();

        // Órdenes por Técnico (Usando relación technician() y columna technician_id)
        $workOrdersByTech = WorkOrder::whereBetween('created_at', [$start, $end])
            ->whereNotNull('technician_id')
            ->select('technician_id', DB::raw('count(*) as total'))
            ->groupBy('technician_id')
            ->with('technician')
            ->get();

        // 2. Ventas POS Directas (Excluyendo ventas espejo de OTs para no duplicar ni sumar repuestos de clientes)
        $sales = Sale::whereNull('work_order_id')
            ->where('status', '!=', 'voided')
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->get();
        $totalSales = (float) $sales->sum('total');
        $salesCount = $sales->count();

        // Métodos de pago combinados (Ventas POS + Pagos OT)
        $otPaymentsInPeriod = Payment::whereBetween('created_at', [$start, $end])->where('type', 'income')->get();
        $salesByMethod = $otPaymentsInPeriod->groupBy('payment_method')->map->sum('amount');
        if ($salesByMethod->isEmpty() && $sales->isNotEmpty()) {
            $salesByMethod = $sales->groupBy('payment_method')->map->sum('total');
        }

        // IVA Débito Fiscal: Calculado SOLO sobre Ventas POS + Mano de Obra OT (NUNCA sobre el repuesto/envío del cliente)
        $posNetTotal = (float) $sales->sum('subtotal');
        $posTaxTotal = (float) $sales->sum('tax_amount');
        if ($posTaxTotal <= 0 && $totalSales > 0) {
            $posNetTotal = $totalSales / 1.19;
            $posTaxTotal = $totalSales - $posNetTotal;
        }

        $otLaborNet = $otLaborIncome > 0 ? ($otLaborIncome / 1.19) : 0;
        $otLaborTax = $otLaborIncome - $otLaborNet;

        $salesNetTotal = $posNetTotal + $otLaborNet;
        $salesTaxTotal = $posTaxTotal + $otLaborTax;

        // Top 5 Productos/Repuestos más vendidos en POS
        $topProducts = SaleItem::select('name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_amount'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Top Servicios (Mano de Obra) más solicitados y sus KPIs (Defensivo ante migraciones)
        $topServices = collect();
        $servicesTotalRevenue = 0;
        $servicesTotalCount = 0;

        if (\Illuminate\Support\Facades\Schema::hasTable('work_order_services')) {
            $topServices = \App\Models\WorkOrderService::select(
                    'name',
                    DB::raw('COUNT(*) as total_qty'),
                    DB::raw('SUM(price) as total_amount'),
                    DB::raw('AVG(price) as avg_price')
                )
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('name')
                ->orderByDesc('total_qty')
                ->take(6)
                ->get();

            $servicesTotalRevenue = \App\Models\WorkOrderService::whereBetween('created_at', [$start, $end])->sum('price');
            $servicesTotalCount = \App\Models\WorkOrderService::whereBetween('created_at', [$start, $end])->count();
        }

        // 3. Egresos / Compras & Cálculos de IVA Crédito
        $expenses = Expense::whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])->latest()->get();
        $totalExpenses = (float) $expenses->sum('total_amount');
        $expensesNetTotal = (float) $expenses->sum('net_amount');
        $expensesTaxTotal = (float) $expenses->sum('tax_amount');

        if ($expensesTaxTotal <= 0 && $totalExpenses > 0) {
            $expensesNetTotal = $totalExpenses / 1.19;
            $expensesTaxTotal = $totalExpenses - $expensesNetTotal;
        }

        // Resumen IVA a pagar / saldo a favor
        $ivaDebitFiscal = $salesTaxTotal;
        $ivaCreditFiscal = $expensesTaxTotal;
        $ivaToPay = $ivaDebitFiscal - $ivaCreditFiscal;

        // Finanzas Reales del Taller: Solo cuenta la Mano de Obra OT + Ventas POS como ingreso propio
        $grossIncome = $totalSales + $otLaborIncome;
        $netProfit = $grossIncome - $totalExpenses;
        $averageTicket = ($salesCount + $validWorkOrders->count()) > 0 ? $grossIncome / ($salesCount + $validWorkOrders->count()) : 0;

        // 4. Inventario Snapshot
        $inventoryItems = Inventory::all();
        $inventoryValue = $inventoryItems->sum(fn($item) => max(0, $item->stock) * $item->cost);
        $inventorySaleValue = $inventoryItems->sum(fn($item) => max(0, $item->stock) * $item->price);
        $lowStockCount = $inventoryItems->where('category', '!=', 'Repuesto por Encargo')->where('stock', '<=', 5)->count();

        // 5. Tendencias para Gráficos (Mostrando Ingreso Real: Mano de Obra OT + Ventas POS)
        $chartLabels = [];
        $chartSalesData = [];
        $chartExpensesData = [];
        $chartOtData = [];

        $diffDays = $start->diffInDays($end);

        if ($diffDays <= 31) {
            $period = \Carbon\CarbonPeriod::create($start, $end);
            foreach ($period as $date) {
                $dayStr = $date->format('Y-m-d');
                $chartLabels[] = $date->format('d/m');
                
                $daySales = $sales->filter(fn($s) => $s->created_at->format('Y-m-d') === $dayStr)->sum('total');
                $dayOtLabor = $validWorkOrders->filter(fn($o) => $o->created_at->format('Y-m-d') === $dayStr)->sum(fn($o) => $o->effective_labor_cost);
                $dayExpenses = $expenses->filter(fn($e) => Carbon::parse($e->date)->format('Y-m-d') === $dayStr)->sum('total_amount');

                $chartSalesData[] = (float) ($daySales + $dayOtLabor);
                $chartExpensesData[] = (float) $dayExpenses;
                $chartOtData[] = (int) $workOrders->filter(fn($o) => $o->created_at->format('Y-m-d') === $dayStr)->count();
            }
        } else {
            $curr = $start->copy()->startOfMonth();
            while ($curr->lte($end)) {
                $monthStr = $curr->format('Y-m');
                $chartLabels[] = $curr->format('M Y');

                $mSales = $sales->filter(fn($s) => $s->created_at->format('Y-m') === $monthStr)->sum('total');
                $mOtLabor = $validWorkOrders->filter(fn($o) => $o->created_at->format('Y-m') === $monthStr)->sum(fn($o) => $o->effective_labor_cost);
                $mExpenses = $expenses->filter(fn($e) => Carbon::parse($e->date)->format('Y-m') === $monthStr)->sum('total_amount');

                $chartSalesData[] = (float) ($mSales + $mOtLabor);
                $chartExpensesData[] = (float) $mExpenses;
                $chartOtData[] = (int) $workOrders->filter(fn($o) => $o->created_at->format('Y-m') === $monthStr)->count();

                $curr->addMonth();
            }
        }

        $this->chartLabels = $chartLabels;
        $this->chartSalesData = $chartSalesData;
        $this->chartExpensesData = $chartExpensesData;
        $this->chartOtData = $chartOtData;
        $this->otStatusesMap = $otStatuses->toArray();

        return view('livewire.reports.dashboard', [
            'workOrders' => $workOrders,
            'otCount' => $otCount,
            'otLaborIncome' => $otLaborIncome,
            'otLaborRealized' => $otLaborRealized,
            'otPartsTotal' => $otPartsTotal,
            'otShippingTotal' => $otShippingTotal,
            'otThirdPartyTotal' => $otThirdPartyTotal,
            'otTotalRecaudado' => $otTotalRecaudado,
            'otStatuses' => $otStatuses,
            'workOrdersByTech' => $workOrdersByTech,
            
            'sales' => $sales,
            'totalSales' => $totalSales,
            'salesCount' => $salesCount,
            'salesByMethod' => $salesByMethod,
            'salesNetTotal' => $salesNetTotal,
            'salesTaxTotal' => $salesTaxTotal,
            'topProducts' => $topProducts,
            'topServices' => $topServices,
            'servicesTotalRevenue' => $servicesTotalRevenue,
            'servicesTotalCount' => $servicesTotalCount,
            
            'expenses' => $expenses,
            'totalExpenses' => $totalExpenses,
            'expensesNetTotal' => $expensesNetTotal,
            'expensesTaxTotal' => $expensesTaxTotal,

            'ivaDebitFiscal' => $ivaDebitFiscal,
            'ivaCreditFiscal' => $ivaCreditFiscal,
            'ivaToPay' => $ivaToPay,

            'grossIncome' => $grossIncome,
            'netProfit' => $netProfit,
            'averageTicket' => $averageTicket,
            
            'inventoryValue' => $inventoryValue,
            'inventorySaleValue' => $inventorySaleValue,
            'lowStockCount' => $lowStockCount,

            'chartLabels' => $chartLabels,
            'chartSalesData' => $chartSalesData,
            'chartExpensesData' => $chartExpensesData,
            'chartOtData' => $chartOtData,
        ]);
    }
}
