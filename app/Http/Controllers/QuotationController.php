<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Setting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    /**
     * Obtiene una imagen codificada en Base64 para DomPDF e HTML.
     */
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

    /**
     * Vista de impresión HTML amigable con window.print() o descarga PDF.
     */
    public function print($id)
    {
        $quotation = Quotation::with(['items', 'client', 'user'])->findOrFail($id);
        $settings = Setting::find(1);
        $logos = $this->getLogoBase64($settings);

        return view('print.quotation-pdf', array_merge(
            compact('quotation', 'settings'),
            $logos
        ));
    }

    /**
     * Descarga directa en formato PDF usando Dompdf.
     */
    public function downloadPdf($id)
    {
        $quotation = Quotation::with(['items', 'client', 'user'])->findOrFail($id);
        $settings = Setting::find(1);
        $logos = $this->getLogoBase64($settings);

        $pdf = Pdf::loadView('print.quotation-pdf', array_merge([
            'quotation' => $quotation,
            'settings'  => $settings,
            'isPdfDownload' => true,
        ], $logos))
        ->setPaper('a4', 'portrait')
        ->setOption([
            'defaultFont' => 'Helvetica',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $fileName = sprintf('Cotizacion_%s_%s.pdf', $quotation->quote_number, str_replace(' ', '_', $quotation->client_name ?? 'Cliente'));

        return $pdf->download($fileName);
    }
}
