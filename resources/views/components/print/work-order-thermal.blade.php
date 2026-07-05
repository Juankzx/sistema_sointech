<div id="{{ $templateId }}" class="hidden">
    @php
        $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();
    @endphp
    <div style="font-family: 'Courier New', Courier, monospace; color: #000; width: 300px; padding: 10px; margin: 0 auto; background: #fff;">
        <div style="text-align: center; border-bottom: 2px dashed #000; padding-bottom: 10px; margin-bottom: 10px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: bold;">{{ strtoupper($settings->company_name ?: 'SOIN TECHNOLOGY') }}</h2>
            <p style="margin: 2px 0 0; font-size: 12px;">Servicio Técnico</p>
            <h3 style="margin: 5px 0 0; font-size: 18px; font-weight: bold;">OT #{{ substr($order->uuid, 0, 8) }}</h3>
            <p style="margin: 2px 0 0; font-size: 12px;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div style="font-size: 13px; line-height: 1.4; border-bottom: 2px dashed #000; padding-bottom: 10px; margin-bottom: 10px;">
            <p style="margin: 2px 0;"><strong>Cliente:</strong><br>{{ Str::limit($order->client->full_name, 25) }}</p>
            <p style="margin: 2px 0;"><strong>Tel:</strong> {{ $order->client->phone }}</p>
            
            <p style="margin: 8px 0 2px;"><strong>Equipo:</strong><br>{{ Str::limit($order->brand_model, 25) }}</p>
            <p style="margin: 2px 0;"><strong>Falla:</strong><br>{{ Str::limit($order->reported_issue, 50) }}</p>
            
            @if($order->unlock_password)
            <p style="margin: 2px 0;"><strong>Clave:</strong> {{ $order->unlock_password }}</p>
            @endif
        </div>

        <div style="text-align: center; padding-top: 10px;">
            <p style="margin: 0 0 5px; font-size: 11px;">Escanear para seguimiento:</p>
            <canvas id="{{ $qrCanvasId }}" width="120" height="120" data-url="{{ url('/seguimiento/'.$order->uuid) }}"></canvas>
            <p style="margin: 5px 0 0; font-size: 10px;">{{ substr($order->uuid, 0, 8) }}</p>
        </div>
    </div>
</div>
