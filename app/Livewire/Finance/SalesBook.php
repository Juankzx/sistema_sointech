<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class SalesBook extends Component
{
    public $currentMonth;
    public $currentYear;
    
    public function mount()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
    }

    public function exportCsv()
    {
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth()->endOfDay();

        $sales = Sale::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'asc')->get();

        $csvFileName = 'libro_ventas_' . $this->currentMonth . '_' . $this->currentYear . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'Fecha', 'Tipo Documento', 'Folio (SII)', 'RUT Cliente', 'Razon Social', 
            'Monto Neto', 'Monto IVA', 'Monto Total'
        ];

        $callback = function() use($sales, $columns) {
            $file = fopen('php://output', 'w');
            // Add BOM for Excel UTF-8
            fputs($file, $bom =(chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($file, $columns, ';');

            foreach ($sales as $sale) {
                $row = [
                    $sale->created_at->format('d/m/Y'),
                    ucfirst($sale->document_type),
                    $sale->document_number ?? 'Pendiente',
                    $sale->client_rut ?? 'Genérico',
                    $sale->client_name ?? 'Genérico',
                    $sale->subtotal,
                    $sale->tax_amount,
                    $sale->total
                ];
                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function render()
    {
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth()->endOfDay();

        $sales = Sale::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();

        return view('livewire.finance.sales-book', [
            'sales' => $sales
        ])->layout('layouts.app');
    }
}
