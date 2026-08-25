{{-- 
    ETIQUETA ADHESIVA TÉRMICA PARA IDENTIFICACIÓN DE EQUIPOS EN TALLER
    Tamaño: 58mm × 40mm (Estándar adhesivo para impresoras térmicas)
--}}
@props(['templateId', 'order'])

@php
    $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();
    $companyName = strtoupper($settings->company_name ?: 'SOINTECH');
    $clientName = $order->client?->full_name ?? 'Cliente N/A';
    $clientPhone = $order->client?->phone ?? 'Sin teléfono';
    $deviceName = $order->brand_model ?? 'Equipo N/A';
    $reportedIssue = $order->reported_issue ?? 'Diagnóstico General';
    $orderCode = strtoupper(substr($order->uuid, 0, 8));
    $pin = $order->unlock_password ?? null;
    $trackingUrl = url('/seguimiento/' . $order->uuid);
@endphp

<div id="{{ $templateId }}" style="display: none;">
    <div style="
        font-family: 'Inter', 'Segoe UI', -apple-system, sans-serif;
        width: 58mm;
        max-width: 58mm;
        box-sizing: border-box;
        padding: 2mm 2.5mm;
        margin: 0 auto;
        background: #fff;
        color: #000;
        line-height: 1.3;
        font-size: 9.5px;
        overflow: hidden;
    ">
        {{-- Encabezado con Mini QR ultracompacto en la esquina superior derecha --}}
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1.5px solid #000; padding-bottom: 1mm; margin-bottom: 1.5mm;">
            <div>
                <div style="font-size: 11px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; line-height: 1;">
                    {{ $companyName }}
                </div>
                <div style="font-size: 7.5px; color: #333; margin-top: 0.5mm; font-weight: 700;">Servicio Técnico</div>
            </div>

            {{-- Mini QR (14mm) súper legible para cámaras y lectores sin estorbar el texto --}}
            <div style="flex-shrink: 0; text-align: center;">
                <canvas id="{{ $templateId }}-qr" data-url="{{ $trackingUrl }}" style="width: 14mm; height: 14mm; display: block;"></canvas>
            </div>
        </div>

        {{-- Código de Orden y Fecha --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #000; padding-bottom: 1mm; margin-bottom: 1.5mm;">
            <span style="font-size: 13px; font-weight: 900; letter-spacing: 0.5px;">OT #{{ $orderCode }}</span>
            <span style="font-size: 8px; font-weight: 700; color: #333;">{{ $order->created_at ? $order->created_at->format('d/m/Y') : date('d/m/Y') }}</span>
        </div>

        {{-- Datos completos con 100% de ancho horizontal --}}
        <div style="font-size: 9.5px; line-height: 1.35;">
            <div style="margin-bottom: 0.8mm;">
                <span style="font-weight: 800; font-size: 8px; text-transform: uppercase; color: #444;">Cliente:</span>
                <span style="font-weight: 800; font-size: 9.5px; word-break: break-word;">{{ $clientName }}</span>
            </div>

            <div style="margin-bottom: 0.8mm;">
                <span style="font-weight: 800; font-size: 8px; text-transform: uppercase; color: #444;">Teléfono:</span>
                <span style="font-weight: 700; font-size: 9px;">{{ $clientPhone }}</span>
            </div>

            <div style="margin-bottom: 0.8mm;">
                <span style="font-weight: 800; font-size: 8px; text-transform: uppercase; color: #444;">Equipo:</span>
                <span style="font-weight: 800; font-size: 9.5px; word-break: break-word;">{{ $deviceName }}</span>
            </div>

            <div style="margin-bottom: 1.2mm;">
                <span style="font-weight: 800; font-size: 8px; text-transform: uppercase; color: #444;">Falla:</span>
                <span style="font-weight: 700; font-size: 9px; word-break: break-word;">{{ $reportedIssue }}</span>
            </div>

            @if($pin)
            <div style="margin-top: 0.8mm; padding: 0.8mm 1.8mm; border: 1.5px solid #000; border-radius: 3px; display: inline-block; background: #fff;">
                <span style="font-weight: 900; font-size: 9.5px;">🔑 Clave: {{ $pin }}</span>
            </div>
            @else
            <div style="margin-top: 0.5mm; font-size: 8px; font-weight: 700; color: #555;">
                🔒 Sin Clave / Patrón
            </div>
            @endif
        </div>
    </div>
</div>
