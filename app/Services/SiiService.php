<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class SiiService
{
    /**
     * Emite una boleta o factura al SII (Simulación)
     * 
     * @param Sale $sale La venta registrada
     * @return array Resultado de la emisión
     */
    public function emitDocument(Sale $sale)
    {
        $settings = Setting::first();
        
        // Verificaciones básicas para saber si la API está configurada
        if (!$settings || empty($settings->sii_api_key)) {
            Log::warning("SII API no está configurada. Documento {$sale->id} quedará pendiente.");
            return [
                'success' => false,
                'status' => 'pending',
                'message' => 'API Key no configurada'
            ];
        }

        // Aquí iría el código de conexión a la API (Ej: LibreDTE, Haulmer, OpenFactura)
        /*
         * Ejemplo de payload para API:
         * $payload = [
         *    'Encabezado' => [
         *       'IdDoc' => ['TipoDTE' => $sale->document_type === 'factura' ? 33 : 39],
         *       'Emisor' => ['RUTEmisor' => $settings->company_rut, ...],
         *       'Receptor' => ['RUTRecep' => $sale->client_rut, 'RznSocRecep' => $sale->client_name, ...]
         *    ],
         *    'Detalle' => $sale->items->map(...)
         * ];
         * $response = Http::withToken($settings->sii_api_key)->post('...', $payload);
         */

        // SIMULACIÓN DE ÉXITO
        // En producción, este bloque dependerá de la respuesta real de la API
        
        $simulatedFolio = rand(1000, 9999);
        $simulatedXmlUrl = url("/simulated_xml/{$sale->id}_{$simulatedFolio}.xml");

        Log::info("Documento emitido simulado (SII): Tipo {$sale->document_type}, Folio {$simulatedFolio}");

        return [
            'success' => true,
            'status' => 'accepted', // En Chile normalmente es 'accepted' o 'sent' al inicio
            'folio' => $simulatedFolio,
            'xml_url' => $simulatedXmlUrl,
            'message' => 'Documento emitido exitosamente (Simulación)'
        ];
    }
}
