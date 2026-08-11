<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ strtoupper($payment->document_type ?? 'Comprobante de Pago') }} OT #{{ substr($order->uuid, 0, 8) }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 12px; margin: 0; padding: 10px; width: 80mm; color: #000; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .mb-2 { margin-bottom: 8px; }
        .mb-4 { margin-bottom: 16px; }
        .mt-2 { margin-top: 8px; }
        .mt-4 { margin-top: 16px; }
        .border-b { border-bottom: 1px dashed #000; padding-bottom: 4px; margin-bottom: 4px; }
        .flex { display: flex; justify-content: space-between; }
        .uppercase { text-transform: uppercase; }
        @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body onload="window.print();">
    <div class="no-print" style="margin-bottom: 14px; text-align: center;">
        <button onclick="if(window.history.length > 1){ window.history.back(); } else { window.location.href='{{ route('work-orders.index') }}'; }" style="background: #0f172a; color: #ffffff; border: 1px solid #334155; padding: 10px 20px; border-radius: 12px; font-weight: 800; font-size: 13px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
            ← Volver a Órdenes de Trabajo
        </button>
    </div>
    <div class="text-center font-bold mb-4 uppercase border-b pb-2">
        @if(isset($appSettings) && $appSettings->logo_path)
            <img src="{{ Storage::url($appSettings->logo_path) }}" alt="Logo" style="max-width: 120px; max-height: 60px; margin-bottom: 8px; filter: grayscale(100%) contrast(1.2);">
            <br>
        @else
            === SISTEMA SOINTECH ===<br>
        @endif
        {{ strtoupper($payment->document_type ?? 'COMPROBANTE DE PAGO') }}
    </div>

    @if(($payment->document_type ?? '') === 'Factura')
        <div class="font-bold border-b uppercase mb-2">DATOS DEL CLIENTE (FACTURA)</div>
        <div class="flex"><span>Razón Social:</span> <span>{{ $order->client->company_name ?? $order->client->full_name }}</span></div>
        <div class="flex"><span>RUT:</span> <span>{{ $order->client->rut_dni }}</span></div>
        <div class="flex"><span>Giro:</span> <span style="text-align: right;">{{ $order->client->business_activity }}</span></div>
        <div class="flex"><span>Dirección:</span> <span style="text-align: right;">{{ $order->client->address }}</span></div>
        <div class="flex mb-4"><span>Comuna:</span> <span>{{ $order->client->commune }}</span></div>
    @else
        <div class="mb-4">
            <div class="flex"><span>Cliente:</span> <span>{{ $order->client->full_name }}</span></div>
            @if($order->client->rut_dni)
                <div class="flex"><span>RUT/DNI:</span> <span>{{ $order->client->rut_dni }}</span></div>
            @endif
        </div>
    @endif

    <div class="mb-4 mt-2">
        <div class="flex"><span>Orden de Trabajo:</span> <span>#{{ substr($order->uuid, 0, 8) }}</span></div>
        <div class="flex"><span>Fecha Emisión:</span> <span>{{ $payment->created_at->format('d/m/Y H:i') }}</span></div>
        <div class="flex"><span>Equipo / Modelo:</span> <span style="text-align: right;">{{ $order->brand_model }}</span></div>
        @if($order->reported_issue)
            <div class="flex"><span>Reparación / Servicio:</span> <span style="text-align: right; font-weight: bold;">{{ $order->reported_issue }}</span></div>
        @endif
    </div>

    <div class="font-bold border-b uppercase mb-2">DETALLE DEL PAGO</div>
    
    <div class="flex"><span>Descripción:</span> <span style="text-align: right;">{{ $payment->description }}</span></div>
    <div class="flex"><span>Método de Pago:</span> <span>{{ $payment->payment_method }}</span></div>
    
    <div class="flex font-bold mt-4 mb-4 border-b pb-2 text-center text-lg">
        <span>MONTO PAGADO:</span> 
        <span>${{ number_format($payment->amount, 0, ',', '.') }}</span>
    </div>

    @php
        $quotation = \App\Models\Quotation::where('work_order_id', $order->id)->with('items')->first();
        $partsCost = $order->parts ? $order->parts->sum(function($p) {
            return $p->pivot->price_at_time * $p->pivot->quantity;
        }) : 0;
        $totalCost = (float)$order->labor_cost + $partsCost;
        $balanceDue = $totalCost - (float)$order->down_payment;
    @endphp

    <div class="font-bold border-b uppercase mb-2 mt-4">DETALLE DEL SERVICIO Y REPUESTOS</div>
    
    @if($quotation && $quotation->items && $quotation->items->count() > 0)
        @foreach($quotation->items as $item)
        <div class="flex" style="margin-bottom: 3px;">
            <span style="max-width: 70%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">• {{ $item->description }} (x{{ $item->quantity }})</span>
            <span>${{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
        @endforeach
    @else
        @if($order->labor_cost > 0)
        <div class="flex" style="margin-bottom: 3px;">
            <span style="max-width: 70%; word-break: break-word;">• {{ $order->reported_issue ?: 'Servicio Técnico' }} ({{ $order->brand_model }})</span>
            <span>${{ number_format($order->labor_cost, 0, ',', '.') }}</span>
        </div>
        @endif
        @foreach($order->parts as $part)
        <div class="flex">
            <span style="max-width: 65%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">• {{ $part->name }} (x{{ $part->pivot->quantity }})</span>
            <span>${{ number_format($part->pivot->price_at_time * $part->pivot->quantity, 0, ',', '.') }}</span>
        </div>
        @endforeach
    @endif
    
    <div class="border-b mt-2 mb-2"></div>
    
    <div class="flex font-bold"><span>Total Servicio:</span> <span>${{ number_format($totalCost, 0, ',', '.') }}</span></div>
    <div class="flex"><span>Abonado Total:</span> <span>${{ number_format($order->down_payment, 0, ',', '.') }}</span></div>
    
    @if($balanceDue > 0)
        <div class="flex font-bold mt-2"><span>SALDO PENDIENTE:</span> <span>${{ number_format(max(0, $balanceDue), 0, ',', '.') }}</span></div>
    @else
        <div class="text-center mt-3 mb-1 font-bold border border-black p-1 uppercase">
            *** PAGADO ***
        </div>
    @endif

    <div class="text-center mt-4 font-bold text-xs border-t pt-4">
        * Gracias por su preferencia *
    </div>
</body>
</html>
