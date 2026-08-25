{{-- 
    ETIQUETA ADHESIVA TÉRMICA PARA IDENTIFICACIÓN DE EQUIPOS
    Tamaño: 58mm × 40mm (estándar etiquetadoras térmicas)
    Uso: Se pega directamente en la carcasa del equipo (celular, notebook, consola)
--}}
@props(['templateId', 'order'])

@php
    $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();
    $companyName = strtoupper($settings->company_name ?: 'SOINTECH');
    $clientName = \Illuminate\Support\Str::limit($order->client?->full_name ?? 'Cliente N/A', 22);
    $deviceName = \Illuminate\Support\Str::limit($order->brand_model ?? 'Equipo N/A', 24);
    $orderCode = strtoupper(substr($order->uuid, 0, 8));
    $pin = $order->unlock_password ?? null;
    $trackingUrl = url('/seguimiento/' . $order->uuid);
@endphp

<div id="{{ $templateId }}" style="display: none;">
    <div style="
        font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        width: 58mm;
        max-width: 58mm;
        min-height: 38mm;
        padding: 2.5mm 3mm;
        margin: 0 auto;
        background: #fff;
        color: #000;
        box-sizing: border-box;
        overflow: hidden;
    ">
        {{-- Header: Nombre empresa + línea --}}
        <div style="text-align: center; border-bottom: 1.5px solid #000; padding-bottom: 1.5mm; margin-bottom: 2mm;">
            <div style="font-size: 11px; font-weight: 900; letter-spacing: 1.5px; text-transform: uppercase; line-height: 1;">
                {{ $companyName }}
            </div>
            <div style="font-size: 7px; color: #333; margin-top: 0.5mm; font-weight: 600;">Servicio Técnico</div>
        </div>

        {{-- Body: Info del equipo --}}
        <div style="display: flex; align-items: flex-start; gap: 2mm;">
            
            {{-- Columna izquierda: Datos --}}
            <div style="flex: 1; min-width: 0; font-size: 9px; line-height: 1.45;">
                {{-- Código OT --}}
                <div style="font-size: 11px; font-weight: 900; letter-spacing: 0.3px; margin-bottom: 1mm;">
                    OT #{{ $orderCode }}
                </div>

                {{-- Cliente --}}
                <div style="margin-bottom: 0.5mm;">
                    <span style="font-weight: 700; font-size: 7.5px; text-transform: uppercase; color: #555;">Cliente:</span><br>
                    <span style="font-weight: 700; font-size: 9px;">{{ $clientName }}</span>
                </div>

                {{-- Equipo --}}
                <div style="margin-bottom: 0.5mm;">
                    <span style="font-weight: 700; font-size: 7.5px; text-transform: uppercase; color: #555;">Equipo:</span><br>
                    <span style="font-weight: 700; font-size: 9px;">{{ $deviceName }}</span>
                </div>

                {{-- PIN / Contraseña (solo si existe) --}}
                @if($pin)
                <div style="margin-top: 0.5mm; padding: 1mm 1.5mm; border: 1px solid #000; border-radius: 2px; display: inline-block;">
                    <span style="font-weight: 900; font-size: 8.5px;">🔑 {{ $pin }}</span>
                </div>
                @endif
            </div>

            {{-- Columna derecha: QR Code --}}
            <div style="flex-shrink: 0; text-align: center; padding-top: 1mm;">
                <canvas id="{{ $templateId }}-qr" data-url="{{ $trackingUrl }}" style="width: 18mm; height: 18mm;"></canvas>
                <div style="font-size: 5.5px; font-weight: 700; color: #555; margin-top: 0.5mm; line-height: 1;">Escanear</div>
            </div>
        </div>

        {{-- Footer mínimo --}}
        <div style="text-align: center; border-top: 1px dashed #999; padding-top: 1mm; margin-top: 1.5mm;">
            <span style="font-size: 6px; color: #777; font-weight: 600;">{{ now()->format('d/m/Y') }} • {{ $companyName }}</span>
        </div>
    </div>
</div>
