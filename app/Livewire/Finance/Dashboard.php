<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Expense;
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

        // Ventas
        $sales = Sale::whereBetween('created_at', [$startDate, $endDate])->get();
        $totalSalesNet = $sales->sum('subtotal');
        $totalSalesTax = $sales->sum('tax_amount');
        $totalSales = $sales->sum('total');

        // Gastos
        $expenses = Expense::whereBetween('date', [$startDate, $endDate])->get();
        $totalExpensesNet = $expenses->sum('net_amount');
        $totalExpensesTax = $expenses->sum('tax_amount');
        $totalExpenses = $expenses->sum('total_amount');

        // Utilidad Neta (Net Sales - Net Expenses)
        $netProfit = $totalSalesNet - $totalExpensesNet;

        // Balance IVA (Tax Collected - Tax Paid)
        $taxBalance = $totalSalesTax - $totalExpensesTax;

        return view('livewire.finance.dashboard', [
            'totalSalesNet' => $totalSalesNet,
            'totalSalesTax' => $totalSalesTax,
            'totalSales' => $totalSales,
            'totalExpensesNet' => $totalExpensesNet,
            'totalExpensesTax' => $totalExpensesTax,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'taxBalance' => $taxBalance,
        ])->layout('layouts.app');
    }
}
