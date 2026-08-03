<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\Inventory;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private function getBase64Image(string $relativePath): ?string
    {
        $fullPath = public_path($relativePath);
        if (file_exists($fullPath)) {
            $type = pathinfo($fullPath, PATHINFO_EXTENSION);
            $data = file_get_contents($fullPath);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return null;
    }

    private function getLogoBase64(?Setting $settings): array
    {
        $customLogo = null;
        if ($settings && $settings->logo_path && file_exists(storage_path('app/public/' . $settings->logo_path))) {
            $path = storage_path('app/public/' . $settings->logo_path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $customLogo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $logoDark  = $customLogo ?? $this->getBase64Image('images/logo-dark.png');
        $logoLight = $customLogo ?? $this->getBase64Image('images/logo-light.png');

        return [
            'logoDark'  => $logoDark,
            'logoLight' => $logoLight,
        ];
    }

    public function downloadPdf(Request $request)
    {
        $dateRange = $request->get('range', 'month');
        $inputStart = $request->get('start_date');
        $inputEnd = $request->get('end_date');

        $now = Carbon::now();

        switch ($dateRange) {
            case 'today':
                $start = $now->copy()->startOfDay();
                $end = $now->copy()->endOfDay();
                $periodLabel = 'Hoy (' . $start->format('d/m/Y') . ')';
                break;
            case 'yesterday':
                $start = $now->copy()->subDay()->startOfDay();
                $end = $now->copy()->subDay()->endOfDay();
                $periodLabel = 'Ayer (' . $start->format('d/m/Y') . ')';
                break;
            case 'week':
                $start = $now->copy()->startOfWeek();
                $end = $now->copy()->endOfWeek();
                $periodLabel = 'Esta Semana (' . $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y') . ')';
                break;
            case 'month':
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
                $periodLabel = 'Este Mes (' . $start->format('m/Y') . ')';
                break;
            case 'last_month':
                $start = $now->copy()->subMonth()->startOfMonth();
                $end = $now->copy()->subMonth()->endOfMonth();
                $periodLabel = 'Mes Anterior (' . $start->format('m/Y') . ')';
                break;
            case 'year':
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
                $periodLabel = 'Año ' . $start->format('Y');
                break;
            case 'custom':
            default:
                $start = $inputStart ? Carbon::parse($inputStart)->startOfDay() : $now->copy()->startOfMonth();
                $end = $inputEnd ? Carbon::parse($inputEnd)->endOfDay() : $now->copy()->endOfMonth();
                $periodLabel = 'Período: ' . $start->format('d/m/Y') . ' al ' . $end->format('d/m/Y');
                break;
        }

        // Metrics Query
        $workOrders = WorkOrder::whereBetween('created_at', [$start, $end])->get();
        $otTotalRecaudado = Payment::whereBetween('created_at', [$start, $end])->sum('amount');
        $otStatuses = $workOrders->groupBy('status')->map->count();
        $otCount = $workOrders->count();

        // Work orders by Technician (using technician_id and technician relationship)
        $workOrdersByTech = WorkOrder::whereBetween('created_at', [$start, $end])
            ->whereNotNull('technician_id')
            ->select('technician_id', DB::raw('count(*) as total'))
            ->groupBy('technician_id')
            ->with('technician')
            ->get();

        // POS Sales
        $sales = Sale::whereBetween('created_at', [$start, $end])->latest()->get();
        $totalSales = $sales->sum('total');
        $salesCount = $sales->count();
        $salesByMethod = $sales->groupBy('payment_method')->map->sum('total');

        $salesNetTotal = $sales->sum('subtotal');
        $salesTaxTotal = $sales->sum('tax_amount');
        if ($salesTaxTotal <= 0 && $totalSales > 0) {
            $salesNetTotal = $totalSales / 1.19;
            $salesTaxTotal = $totalSales - $salesNetTotal;
        }

        // Expenses
        $expenses = Expense::whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])->latest()->get();
        $totalExpenses = $expenses->sum('total_amount');
        $expensesNetTotal = $expenses->sum('net_amount');
        $expensesTaxTotal = $expenses->sum('tax_amount');
        if ($expensesTaxTotal <= 0 && $totalExpenses > 0) {
            $expensesNetTotal = $totalExpenses / 1.19;
            $expensesTaxTotal = $totalExpenses - $expensesNetTotal;
        }

        // IVA Summary
        $ivaDebitFiscal = $salesTaxTotal;
        $ivaCreditFiscal = $expensesTaxTotal;
        $ivaToPay = $ivaDebitFiscal - $ivaCreditFiscal;

        // Financial Totals
        $grossIncome = $totalSales + $otTotalRecaudado;
        $netProfit = $grossIncome - $totalExpenses;

        // Inventory
        $inventoryItems = Inventory::all();
        $inventoryValue = $inventoryItems->sum(fn($i) => $i->stock * $i->cost);
        $inventorySaleValue = $inventoryItems->sum(fn($i) => $i->stock * $i->price);
        $lowStockCount = $inventoryItems->where('stock', '<=', 5)->count();

        $settings = Setting::find(1);
        $logos = $this->getLogoBase64($settings);

        $pdf = Pdf::loadView('pdf.reports-summary', array_merge([
            'periodLabel' => $periodLabel,
            'start' => $start,
            'end' => $end,
            'otCount' => $otCount,
            'otTotalRecaudado' => $otTotalRecaudado,
            'otStatuses' => $otStatuses,
            'workOrdersByTech' => $workOrdersByTech,
            'sales' => $sales,
            'salesCount' => $salesCount,
            'totalSales' => $totalSales,
            'salesNetTotal' => $salesNetTotal,
            'salesTaxTotal' => $salesTaxTotal,
            'salesByMethod' => $salesByMethod,
            'expenses' => $expenses,
            'totalExpenses' => $totalExpenses,
            'expensesNetTotal' => $expensesNetTotal,
            'expensesTaxTotal' => $expensesTaxTotal,
            'ivaDebitFiscal' => $ivaDebitFiscal,
            'ivaCreditFiscal' => $ivaCreditFiscal,
            'ivaToPay' => $ivaToPay,
            'grossIncome' => $grossIncome,
            'netProfit' => $netProfit,
            'inventoryValue' => $inventoryValue,
            'inventorySaleValue' => $inventorySaleValue,
            'lowStockCount' => $lowStockCount,
            'settings' => $settings,
            'generatedAt' => Carbon::now()->format('d/m/Y H:i:s')
        ], $logos));

        $pdf->setPaper('a4', 'portrait');

        $fileName = 'Reporte_Ejecutivo_Sointech_' . $start->format('Ymd') . '_' . $end->format('Ymd') . '.pdf';

        return $pdf->stream($fileName);
    }
}
