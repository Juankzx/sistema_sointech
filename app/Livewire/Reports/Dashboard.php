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

        // 1. Órdenes de Trabajo
        $workOrders = WorkOrder::whereBetween('created_at', [$start, $end])->get();
        $otTotalRecaudado = Payment::whereBetween('created_at', [$start, $end])->sum('amount');
        $otStatuses = $workOrders->groupBy('status')->map->count();
        $otCount = $workOrders->count();

        // Órdenes por Técnico (Usando relación technician() y columna technician_id)
        $workOrdersByTech = WorkOrder::whereBetween('created_at', [$start, $end])
            ->whereNotNull('technician_id')
            ->select('technician_id', DB::raw('count(*) as total'))
            ->groupBy('technician_id')
            ->with('technician')
            ->get();

        // 2. Ventas POS & Cálculos de IVA Débito
        $sales = Sale::whereBetween('created_at', [$start, $end])->latest()->get();
        $totalSales = $sales->sum('total');
        $salesCount = $sales->count();
        $salesByMethod = $sales->groupBy('payment_method')->map->sum('total');

        // IVA Débito en Ventas (Subtotal, Tax, Total)
        $salesNetTotal = $sales->sum('subtotal');
        $salesTaxTotal = $sales->sum('tax_amount');

        // If subtotal/tax_amount wasn't populated on some legacy sales, estimate using 19% IVA (Chile standard)
        if ($salesTaxTotal <= 0 && $totalSales > 0) {
            $salesNetTotal = $totalSales / 1.19;
            $salesTaxTotal = $totalSales - $salesNetTotal;
        }

        // Top 5 Productos/Repuestos más vendidos
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
        $totalExpenses = $expenses->sum('total_amount');
        $expensesNetTotal = $expenses->sum('net_amount');
        $expensesTaxTotal = $expenses->sum('tax_amount');

        if ($expensesTaxTotal <= 0 && $totalExpenses > 0) {
            $expensesNetTotal = $totalExpenses / 1.19;
            $expensesTaxTotal = $totalExpenses - $expensesNetTotal;
        }

        // Resumen IVA a pagar / saldo a favor
        $ivaDebitFiscal = $salesTaxTotal;
        $ivaCreditFiscal = $expensesTaxTotal;
        $ivaToPay = $ivaDebitFiscal - $ivaCreditFiscal;

        // Finanzas
        $grossIncome = $totalSales + $otTotalRecaudado;
        $netProfit = $grossIncome - $totalExpenses;
        $averageTicket = ($salesCount + $otCount) > 0 ? $grossIncome / ($salesCount + $otCount) : 0;

        // 4. Inventario Snapshot
        $inventoryItems = Inventory::all();
        $inventoryValue = $inventoryItems->sum(fn($item) => $item->stock * $item->cost);
        $inventorySaleValue = $inventoryItems->sum(fn($item) => $item->stock * $item->price);
        $lowStockCount = $inventoryItems->where('stock', '<=', 5)->count();

        // 5. Tendencias para Gráficos
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
                $dayOt = Payment::whereDate('created_at', $dayStr)->sum('amount');
                $dayExpenses = $expenses->filter(fn($e) => Carbon::parse($e->date)->format('Y-m-d') === $dayStr)->sum('total_amount');

                $chartSalesData[] = (float) ($daySales + $dayOt);
                $chartExpensesData[] = (float) $dayExpenses;
                $chartOtData[] = (int) $workOrders->filter(fn($o) => $o->created_at->format('Y-m-d') === $dayStr)->count();
            }
        } else {
            $curr = $start->copy()->startOfMonth();
            while ($curr->lte($end)) {
                $monthStr = $curr->format('Y-m');
                $chartLabels[] = $curr->format('M Y');

                $mSales = $sales->filter(fn($s) => $s->created_at->format('Y-m') === $monthStr)->sum('total');
                $mOt = Payment::whereBetween('created_at', [$curr->copy()->startOfMonth(), $curr->copy()->endOfMonth()])->sum('amount');
                $mExpenses = $expenses->filter(fn($e) => Carbon::parse($e->date)->format('Y-m') === $monthStr)->sum('total_amount');

                $chartSalesData[] = (float) ($mSales + $mOt);
                $chartExpensesData[] = (float) $mExpenses;
                $chartOtData[] = (int) $workOrders->filter(fn($o) => $o->created_at->format('Y-m') === $monthStr)->count();

                $curr->addMonth();
            }
        }

        return view('livewire.reports.dashboard', [
            'otCount' => $otCount,
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
