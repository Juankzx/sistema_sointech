<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send automatic WhatsApp status notification for a Work Order using Meta Cloud API.
     */
    public static function sendOtStatusNotification(WorkOrder $workOrder, string $newStatus): bool
    {
        $settings = Setting::find(1);

        if (!$settings || !$settings->whatsapp_enabled) {
            return false;
        }

        $phoneNumberId = trim($settings->whatsapp_phone_number_id ?? '');
        $accessToken = trim($settings->whatsapp_access_token ?? '');
        $templateName = trim($settings->whatsapp_template_name ?: 'ot_status_update');

        if (empty($phoneNumberId) || empty($accessToken)) {
            Log::warning("WhatsApp Service: Credentials missing (Phone Number ID or Access Token).");
            return false;
        }

        $clientPhone = $workOrder->client?->phone;
        if (empty($clientPhone)) {
            return false;
        }

        // Clean phone number to E.164 without plus or symbols (e.g. +56 9 1234 5678 -> 56912345678)
        $cleanPhone = preg_replace('/[^0-9]/', '', $clientPhone);
        if (strlen($cleanPhone) < 8) {
            Log::warning("WhatsApp Service: Invalid phone number format [{$clientPhone}].");
            return false;
        }

        // Default to Chile country code (56) if 9 digits provided without country code
        if (strlen($cleanPhone) === 9 && str_starts_with($cleanPhone, '9')) {
            $cleanPhone = '56' . $cleanPhone;
        }

        $code = strtoupper(substr($workOrder->uuid, 0, 8));
        $clientName = $workOrder->client?->full_name ?: 'Cliente';
        $device = trim("{$workOrder->brand_model}");
        $trackingUrl = route('work-orders.track', ['uuid' => $workOrder->uuid]);

        // Meta Graph API Endpoint v19.0
        $url = "https://graph.facebook.com/v19.0/{$phoneNumberId}/messages";

        try {
            $response = Http::withToken($accessToken)
                ->acceptJson()
                ->post($url, [
                    'messaging_product' => 'whatsapp',
                    'to' => $cleanPhone,
                    'type' => 'template',
                    'template' => [
                        'name' => $templateName,
                        'language' => [
                            'code' => 'es'
                        ],
                        'components' => [
                            [
                                'type' => 'body',
                                'parameters' => [
                                    ['type' => 'text', 'text' => $clientName],
                                    ['type' => 'text', 'text' => $code],
                                    ['type' => 'text', 'text' => $newStatus],
                                    ['type' => 'text', 'text' => $device],
                                    ['type' => 'text', 'text' => $trackingUrl]
                                ]
                            ]
                        ]
                    ]
                ]);

            if ($response->successful()) {
                Log::info("WhatsApp notification sent successfully for OT #{$code} to {$cleanPhone}.");
                return true;
            } else {
                Log::error("WhatsApp Service Error for OT #{$code}: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp Service Exception for OT #{$code}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send a test message to verify Meta API credentials.
     */
    public static function sendTestMessage(string $toPhone): array
    {
        $settings = Setting::find(1);

        if (!$settings) {
            return ['success' => false, 'message' => 'No se encontraron las configuraciones del sistema.'];
        }

        $phoneNumberId = trim($settings->whatsapp_phone_number_id ?? '');
        $accessToken = trim($settings->whatsapp_access_token ?? '');
        $templateName = trim($settings->whatsapp_template_name ?: 'hello_world');

        if (empty($phoneNumberId) || empty($accessToken)) {
            return ['success' => false, 'message' => 'Ingresa el Phone Number ID y el Token de Acceso de Meta primero.'];
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $toPhone);
        if (strlen($cleanPhone) === 9 && str_starts_with($cleanPhone, '9')) {
            $cleanPhone = '56' . $cleanPhone;
        }

        $url = "https://graph.facebook.com/v19.0/{$phoneNumberId}/messages";

        try {
            $response = Http::withToken($accessToken)
                ->acceptJson()
                ->post($url, [
                    'messaging_product' => 'whatsapp',
                    'to' => $cleanPhone,
                    'type' => 'template',
                    'template' => [
                        'name' => $templateName,
                        'language' => [
                            'code' => 'es'
                        ]
                    ]
                ]);

            if ($response->successful()) {
                return ['success' => true, 'message' => '¡Mensaje de prueba enviado exitosamente a ' . $cleanPhone . '!'];
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? $response->body();
                return ['success' => false, 'message' => 'Error de Meta API: ' . $errorMessage];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Excepción de red: ' . $e->getMessage()];
        }
    }
}
