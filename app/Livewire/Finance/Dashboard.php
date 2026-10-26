<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\WorkOrder;
use App\Models\QuotationItem;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $currentMonth;
    public $currentYear;
    
    public function mount()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
    }

    public function render()
    {
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth()->endOfDay();

        // Ventas POS Directas (Excluyendo espejo de OT)
        $posSales = Sale::whereNull('work_order_id')
            ->where('status', '!=', 'voided')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        $posTotal = (float) $posSales->sum('total');
        $posNet = (float) $posSales->sum('subtotal');
        $posTax = (float) $posSales->sum('tax_amount');
        if ($posTax <= 0 && $posTotal > 0) {
            $posNet = $posTotal / 1.19;
            $posTax = $posTotal - $posNet;
        }

        // Órdenes de Trabajo del período: Separar Mano de Obra (Utilidad Real) de Repuestos + Envíos (Costo Cliente)
        $workOrders = WorkOrder::with(['parts', 'payments'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotIn('status', ['Rechazado', 'Cancelado'])
            ->get();

        $servicesIncome = (float) $workOrders->sum(fn($wo) => $wo->effective_labor_cost);
        $otPartsTotal = (float) $workOrders->sum(fn($wo) => $wo->parts_total);
        $otShippingTotal = (float) $workOrders->sum(fn($wo) => (float) ($wo->shipping_cost ?? 0));
        $productsIncome = $otPartsTotal + $otShippingTotal;

        // Ingresos Reales del Negocio = Mano de Obra OT + Ventas POS Directas (No incluye repuestos ni envíos de clientes)
        $otLaborNet = $servicesIncome > 0 ? ($servicesIncome / 1.19) : 0;
        $otLaborTax = $servicesIncome - $otLaborNet;

        $totalSales = $posTotal + $servicesIncome;
        $totalSalesNet = $posNet + $otLaborNet;
        $totalSalesTax = $posTax + $otLaborTax;

        // Gastos
        $expenses = Expense::whereBetween('date', [$startDate, $endDate])->get();
        $totalExpensesNet = (float) $expenses->sum('net_amount');
        $totalExpensesTax = (float) $expenses->sum('tax_amount');
        $totalExpenses = (float) $expenses->sum('total_amount');
        if ($totalExpensesTax <= 0 && $totalExpenses > 0) {
            $totalExpensesNet = $totalExpenses / 1.19;
            $totalExpensesTax = $totalExpenses - $totalExpensesNet;
        }

        // Utilidad Neta Real (Ingresos Mano de Obra + POS menos Gastos)
        $netProfit = $totalSales - $totalExpenses;

        // Balance IVA (Tax Collected on Labor + POS - Tax Paid on Purchases)
        $taxBalance = $totalSalesTax - $totalExpensesTax;

        return view('livewire.finance.dashboard', [
            'totalSalesNet'    => $totalSalesNet,
            'totalSalesTax'    => $totalSalesTax,
            'totalSales'       => $totalSales,
            'posTotal'         => $posTotal,
            'totalExpensesNet' => $totalExpensesNet,
            'totalExpensesTax' => $totalExpensesTax,
            'totalExpenses'    => $totalExpenses,
            'netProfit'        => $netProfit,
            'taxBalance'       => $taxBalance,
            'servicesIncome'   => $servicesIncome,
            'productsIncome'   => $productsIncome,
            'otPartsTotal'     => $otPartsTotal,
            'otShippingTotal'  => $otShippingTotal,
        ])->layout('layouts.app');
    }
}
