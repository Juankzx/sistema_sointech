<div id="{{ $templateId }}" class="hidden">
    @php
        $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();
        $thermalLogoData = '';
        $thermalLogoPath = public_path('images/logo-dark.png');
        if (file_exists($thermalLogoPath)) {
            $thermalLogoData = 'data:image/png;base64,' . base64_encode(file_get_contents($thermalLogoPath));
        }

        $sigSrc = null;
        if (!empty($order->signature_path)) {
            $sigFullPath = storage_path('app/public/' . $order->signature_path);
            if (file_exists($sigFullPath)) {
                $sigData = base64_encode(file_get_contents($sigFullPath));
                $sigSrc = 'data:image/png;base64,' . $sigData;
            } else {
                $sigSrc = asset('storage/' . $order->signature_path);
            }
        }

        $partsCostTotal = $order->parts ? $order->parts->sum(function($p) { return $p->pivot->price_at_time * $p->pivot->quantity; }) : 0;
        $orderTotal = (float)$order->labor_cost + $partsCostTotal;
        $balanceDue = max(0, $orderTotal - (float)$order->down_payment);
    @endphp

    <div class="thermal-ticket-container" style="font-family: 'Inter', Arial, sans-serif; width: 100%; max-width: 76mm; padding: 2px; margin: 0 auto; background: #fff; color: #000;">
        <!-- Header -->
        <div style="text-align: center; border-bottom: 2px dashed #000; padding-bottom: 6px; margin-bottom: 6px;">
            @if($thermalLogoData)
                <div style="background: #0f172a; padding: 6px 12px; border-radius: 8px; display: inline-block; margin-bottom: 4px;">
                    <img src="{{ $thermalLogoData }}" alt="Logo" style="max-height: 28px; width: auto; display: block; margin: 0 auto;">
                </div>
            @endif
            <div style="font-size: 14px; font-weight: 900; letter-spacing: 0.5px; text-transform: uppercase;">
                {{ strtoupper($settings->company_name ?: 'SOIN TECHNOLOGY') }}
            </div>
            <div style="font-size: 9px; color: #333; margin-top: 1px;">Servicio Técnico Especializado</div>
            <div style="font-size: 14px; font-weight: 900; margin-top: 4px; border: 1.5px solid #000; padding: 2px 0; border-radius: 4px;">
                OT #{{ substr($order->uuid, 0, 8) }}
            </div>
            <div style="font-size: 9px; margin-top: 3px; font-weight: bold;">
                Fecha: {{ $order->created_at->format('d/m/Y H:i') }}
            </div>
        </div>

        <!-- Detail Section -->
        <div style="font-size: 10px; line-height: 1.35; border-bottom: 1px dashed #000; padding-bottom: 6px; margin-bottom: 6px;">
            <div style="margin-bottom: 4px;">
                <strong>CLIENTE:</strong> {{ Str::limit($order->client?->full_name ?? 'Cliente N/A', 26) }}<br>
                <strong>RUT/RUN:</strong> {{ $order->client?->rut_dni ?? 'N/A' }} | <strong>TEL:</strong> {{ $order->client?->phone ?? 'N/A' }}
            </div>

            <div style="margin-bottom: 4px; border-top: 1px dotted #ccc; padding-top: 3px;">
                <strong>DISPOSITIVO:</strong> {{ Str::limit($order->brand_model, 26) }}<br>
                <strong>TIPO:</strong> {{ $order->device_type }}
                @if($order->unlock_password)
                    | <strong>CLAVE:</strong> {{ $order->unlock_password }}
                @endif
            </div>

            @php
                $quotation = \App\Models\Quotation::where('work_order_id', $order->id)->with('items')->first();
            @endphp

            @if($quotation && $quotation->items && $quotation->items->count() > 0)
            <div style="border-top: 1px dotted #ccc; padding-top: 3px; margin-bottom: 4px;">
                <strong>DETALLE DE SERVICIOS / REPUESTOS:</strong><br>
                @foreach($quotation->items as $item)
                    <div style="display: flex; justify-content: space-between; font-size: 9px; margin-top: 1px;">
                        <span style="max-width: 70%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">• {{ $item->description }} (x{{ $item->quantity }})</span>
                        <span>${{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            @else
            <div style="border-top: 1px dotted #ccc; padding-top: 3px;">
                <strong>FALLA REPORTADA:</strong><br>
                <span style="font-size: 9.5px;">{{ Str::limit($order->reported_issue, 80) }}</span>
            </div>
            @endif
        </div>

        <!-- Costs & Balances Summary -->
        <div style="font-size: 10px; border-bottom: 1.5px solid #000; padding-bottom: 4px; margin-bottom: 6px; line-height: 1.4;">
            <div style="display: flex; justify-content: space-between;">
                <span>Presupuesto Estimado:</span>
                <span>${{ number_format($orderTotal, 0, ',', '.') }}</span>
            </div>
            @if($order->down_payment > 0)
                <div style="display: flex; justify-content: space-between; font-weight: bold; color: #000;">
                    <span>Abonado:</span>
                    <span>${{ number_format($order->down_payment, 0, ',', '.') }}</span>
                </div>
            @endif
            <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 900; margin-top: 2px; border-top: 1px solid #000; padding-top: 2px;">
                <span>SALDO PENDIENTE:</span>
                <span>${{ number_format($balanceDue, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Terms of Service & Abandonment Policy -->
        <div style="font-size: 8px; line-height: 1.25; border-bottom: 1px dashed #000; padding-bottom: 6px; margin-bottom: 6px; text-align: justify;">
            <div style="font-weight: 900; text-align: center; text-transform: uppercase; font-size: 8.5px; margin-bottom: 3px;">
                CONDICIONES DE SERVICIO Y ABANDONO
            </div>
            • <strong>RESPALDO DE DATOS:</strong> El cliente debe respaldar sus datos. La empresa NO responde por pérdida de información o archivos.<br>
            • <strong>EQUIPOS APAGADOS:</strong> No se responde por fallas ocultas o no verificables al momento del ingreso.<br>
            • <strong>NOTIFICACIONES:</strong> El envío de mensajes vía WhatsApp, llamadas o email al contacto registrado constituye <strong>notificación formal de retiro</strong>.<br>
            • <strong>BODEGAJE Y ABANDONO (Ley 19.496):</strong> Pasados 30 días del aviso sin retiro se aplica recargo de bodegaje. Cumplidos <strong>90 días corridos</strong> sin retirar el equipo ni responder avisos, el dispositivo se declarará <strong>LEGALMENTE ABANDONADO</strong> y la empresa dispondrá del bien para cubrir repuestos y bodegaje adeudados.<br>
            • <strong>GARANTÍA 90 DÍAS:</strong> Cubre solo la falla reparada. Se anula por humedad, golpes, sellos rotos u otros talleres.
        </div>

        <!-- Signature Block -->
        <div style="margin-bottom: 8px; text-align: center;">
            @if($sigSrc)
                <div style="margin: 4px auto; max-height: 45px; overflow: hidden;">
                    <img src="{{ $sigSrc }}" alt="Firma Cliente" style="max-height: 40px; max-width: 160px; object-fit: contain;">
                </div>
                <div style="border-top: 1px solid #000; font-size: 8px; font-weight: bold; margin-top: 2px; padding-top: 2px;">
                    FIRMA CLIENTE CONFORME
                </div>
            @else
                <div style="border-bottom: 1px solid #000; height: 35px; margin: 5px 15px 3px;"></div>
                <div style="font-size: 8px; font-weight: bold;">
                    FIRMA CLIENTE: {{ Str::limit($order->client->full_name, 24) }}
                </div>
            @endif
            <div style="font-size: 7px; color: #333; margin-top: 2px;">
                RUT: {{ $order->client->rut_dni ?? '__________________' }}
            </div>
            <div style="font-size: 7px; color: #555; margin-top: 2px; font-style: italic;">
                "Declaro haber leído, aceptado y recibido copia de estas condiciones"
            </div>
        </div>

        <!-- Tracking & Footer -->
        <div style="text-align: center;">
            <div style="margin: 0 auto 2px; display: inline-block;">
                <canvas id="{{ $qrCanvasId }}" data-url="{{ url('/seguimiento/'.$order->uuid) }}"></canvas>
            </div>
            <div style="font-size: 8px; font-weight: bold;">
                Escanee el código QR para consultar el estado en vivo
            </div>
            <div style="font-size: 7.5px; color: #444; margin-top: 2px;">
                ¡Gracias por su confianza en {{ $settings->company_name ?: 'SOIN TECHNOLOGY' }}!
            </div>
        </div>
    </div>
</div>

