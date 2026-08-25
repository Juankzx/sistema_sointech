@props(['templateId', 'order'])

@php
    $totalParts = $order->parts->sum(function($part) {
        return $part->pivot->price_at_time * $part->pivot->quantity;
    });
    $subtotal = $order->labor_cost + $totalParts;
    // Obtener la configuración general para datos reales y escalables
    $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();
    
    // Calcular IVA dinámico basado en configuración
    $ivaRate = ($settings->tax_rate ?? 19) / 100;
    $neto = round($subtotal / (1 + $ivaRate));
    $iva = $subtotal - $neto;
    
    // Formatear Tiempo Estimado Inteligente
    $estimated = $order->estimated_delivery ?: 'A convenir';
    if (is_numeric(trim($estimated))) {
        $estimated = trim($estimated) . ' Día(s)';
    }
    // Buscar la bitácora de diagnóstico si existe para la descripción
    $diagnosticLog = $order->logs()->where('status', 'Presupuestado')->first();
    $diagnosticNotes = $diagnosticLog ? $diagnosticLog->notes : $order->reported_issue;
    
    // Limpiar texto de diagnóstico técnico de la bitácora
    if (preg_match('/Diagnóstico Técnico:\s*(.*?)\nPresupuesto establecido:/s', $diagnosticNotes, $matches)) {
        $diagnosticNotes = trim($matches[1]);
    }
@endphp

<div id="{{ $templateId }}" class="w-[210mm] min-h-[297mm] bg-white text-gray-900 mx-auto relative overflow-hidden" style="display: none; padding: 15mm; font-family: 'Inter', sans-serif;">
    
    <!-- Watermark Background -->
    <div class="absolute inset-0 z-0 flex items-center justify-center opacity-[0.03] pointer-events-none overflow-hidden">
        @if($settings->logo_path)
            <img src="{{ asset('storage/' . $settings->logo_path) }}" class="w-2/3 object-contain filter grayscale" alt="Watermark">
        @else
            <img src="{{ asset('images/logo-dark.png') }}" class="w-2/3 object-contain filter grayscale" alt="Watermark">
        @endif
    </div>
    
    <!-- HEADER EMPRESARIAL -->
    <div class="flex justify-between items-start border-b-2 border-gray-900 pb-6 mb-8 relative z-10">
        <div class="w-1/2">
            <!-- Logo corporativo dinámico de configuración -->
            @if($settings->logo_path)
                <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="{{ $settings->company_name ?: 'Soin Technology' }}" class="h-16 mb-3 object-contain">
            @else
                <img src="{{ asset('images/logo-dark.png') }}" alt="Soin Technology" class="h-16 mb-3 object-contain">
            @endif
            <h1 class="text-sm font-black text-gray-900 tracking-widest uppercase">{{ $settings->company_name ?: 'Soin Technology' }}</h1>
            <p class="text-[10px] text-gray-500 mt-1 leading-tight">
                {{ $settings->company_address ?? 'Configura tu dirección en Ajustes' }}<br>
                Tel: {{ $settings->company_phone ?? 'Configura tu teléfono en Ajustes' }}<br>
                Email: {{ $settings->support_email ?? 'Configura tu correo en Ajustes' }}
            </p>
        </div>
        <div class="w-1/2 text-right">
            <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter mb-2">COTIZACIÓN</h2>
            <div class="bg-gray-100 p-3 rounded-lg inline-block text-left border border-gray-200">
                <table class="text-[10px]">
                    <tr>
                        <td class="font-bold text-gray-500 pr-4 pb-1">Nº Cotización:</td>
                        <td class="font-bold text-gray-900 pb-1">COT-{{ strtoupper(substr($order->uuid, 0, 8)) }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold text-gray-500 pr-4 pb-1">Fecha Emisión:</td>
                        <td class="font-bold text-gray-900 pb-1">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold text-gray-500 pr-4">Validez:</td>
                        <td class="font-bold text-red-600">15 Días</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- DATOS DEL CLIENTE Y EQUIPO -->
    <div class="flex gap-6 mb-8 relative z-10">
        <!-- Cliente -->
        <div class="w-1/2 bg-gray-50/80 backdrop-blur-sm p-4 rounded-xl border border-gray-200">
            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest border-b border-gray-200 pb-2 mb-3">Datos del Cliente</h3>
            <table class="text-xs w-full">
                <tr><td class="text-gray-500 py-1 w-1/3">Razón Social / Nombre:</td><td class="font-bold text-gray-900">{{ $order->client?->full_name ?? 'Cliente N/A' }}</td></tr>
                <tr><td class="text-gray-500 py-1">RUT / DNI:</td><td class="font-bold text-gray-900">{{ $order->client?->rut_dni ?: 'No registrado' }}</td></tr>
                <tr><td class="text-gray-500 py-1">Teléfono:</td><td class="font-bold text-gray-900">{{ $order->client?->phone ?? 'No registrado' }}</td></tr>
                <tr><td class="text-gray-500 py-1">Email:</td><td class="font-bold text-gray-900">{{ $order->client?->email ?: 'No registrado' }}</td></tr>
            </table>
        </div>
        
        <!-- Equipo -->
        <div class="w-1/2 bg-gray-50/80 backdrop-blur-sm p-4 rounded-xl border border-gray-200">
            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest border-b border-gray-200 pb-2 mb-3">Equipo a Intervenir</h3>
            <table class="text-xs w-full">
                <tr><td class="text-gray-500 py-1 w-1/3">Tipo / Modelo:</td><td class="font-bold text-gray-900 uppercase">{{ $order->device_type }} - {{ $order->brand_model }}</td></tr>
                <tr><td class="text-gray-500 py-1">Nº Serie / IMEI:</td><td class="font-bold text-gray-900 font-mono">{{ $order->imei_serial ?: 'N/A' }}</td></tr>
                <tr><td class="text-gray-500 py-1">Tiempo Estimado:</td><td class="font-bold text-gray-900">{{ $estimated }}</td></tr>
            </table>
        </div>
    </div>

    <!-- TABLA DE SERVICIOS Y REPUESTOS -->
    <div class="mb-8 relative z-10">
        <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Detalle Técnico y Valorización</h3>
        
        <table class="w-full text-xs border-collapse">
            <thead>
                <tr class="bg-gray-900 text-white">
                    <th class="py-2.5 px-3 text-left font-bold rounded-tl-lg w-16">Cant.</th>
                    <th class="py-2.5 px-3 text-left font-bold w-full">Descripción del Ítem / Servicio</th>
                    <th class="py-2.5 px-3 text-right font-bold w-24">P. Unitario</th>
                    <th class="py-2.5 px-3 text-right font-bold rounded-tr-lg w-28">Subtotal</th>
                </tr>
            </thead>
            <tbody class="border-b border-gray-200">
                <!-- Mano de Obra / Diagnóstico -->
                @if($order->labor_cost > 0)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-3 text-gray-900 font-medium text-center">1</td>
                    <td class="py-3 px-3 text-gray-900">
                        <div class="font-bold mb-1">Servicio Técnico y Mano de Obra</div>
                        <div class="text-[10px] text-gray-600 leading-tight mb-2">
                            <strong>Falla Reportada:</strong> {{ $order->reported_issue }}
                        </div>
                        <div class="text-[10px] text-gray-600 leading-tight">
                            <strong>Diagnóstico / Acción:</strong> {{ $diagnosticNotes }}
                        </div>
                    </td>
                    <td class="py-3 px-3 text-right text-gray-700">${{ number_format($order->labor_cost, 0, ',', '.') }}</td>
                    <td class="py-3 px-3 text-right font-bold text-gray-900">${{ number_format($order->labor_cost, 0, ',', '.') }}</td>
                </tr>
                @endif
                
                <!-- Repuestos -->
                @foreach($order->parts as $part)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-3 text-gray-900 font-medium text-center">{{ $part->pivot->quantity }}</td>
                    <td class="py-3 px-3 text-gray-900">
                        <div class="font-bold">{{ $part->name }}</div>
                        <div class="text-[10px] text-gray-500">Categoría: {{ $part->category }}</div>
                    </td>
                    <td class="py-3 px-3 text-right text-gray-700">${{ number_format($part->pivot->price_at_time, 0, ',', '.') }}</td>
                    <td class="py-3 px-3 text-right font-bold text-gray-900">${{ number_format($part->pivot->price_at_time * $part->pivot->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Totales -->
        <div class="flex justify-end mt-4">
            <div class="w-64 bg-gray-50 p-4 rounded-xl border border-gray-200">
                <div class="flex justify-between mb-2 text-xs">
                    <span class="text-gray-500 font-bold">Subtotal Neto:</span>
                    <span class="text-gray-900 font-bold">${{ number_format($neto, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-2 text-xs">
                    <span class="text-gray-500 font-bold">I.V.A ({{ $settings->tax_rate ?? 19 }}%):</span>
                    <span class="text-gray-900 font-bold">${{ number_format($iva, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mt-3 pt-3 border-t border-gray-300">
                    <span class="text-sm font-black text-gray-900 uppercase">Total:</span>
                    <span class="text-sm font-black text-gray-900">${{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- TÉRMINOS Y CONDICIONES (EMPRESARIALES) -->
    <div class="mt-10 pt-6 border-t-2 border-gray-900/10 relative z-10">
        <h3 class="text-[10px] font-black text-gray-900 uppercase tracking-widest mb-3">Términos, Condiciones y Garantías</h3>
        <ul class="text-[9px] text-gray-600 space-y-1.5 list-disc pl-4 text-justify">
            <li><strong>Validez del presupuesto:</strong> Esta cotización tiene una validez de 15 días corridos desde su emisión. Los precios de los repuestos están sujetos a disponibilidad de stock y variaciones del mercado internacional.</li>
            <li><strong>Condiciones de Pago:</strong> Para iniciar la reparación o importación de repuestos exclusivos, se requiere la aprobación formal (orden de compra o pago parcial, según lo acordado con el ejecutivo).</li>
            <li><strong>Tiempos de Ejecución:</strong> El tiempo estimado de entrega indicado es referencial e inicia a partir de la aprobación de esta cotización. Puede variar por factores logísticos externos o hallazgos técnicos secundarios durante la reparación.</li>
            <li><strong>Garantía de Servicio:</strong> Todas nuestras reparaciones y repuestos originales cuentan con una garantía de {{ $settings->warranty_months ?? 3 }} meses, exclusiva contra defectos de fábrica o fallas en la instalación. No cubre daños inducidos por el usuario (golpes, humedad, sobrecargas eléctricas).</li>
            <li><strong>Resguardo de Información:</strong> Se recomienda respaldar su información antes de entregar el equipo. Sointech no se hace responsable por pérdida de datos durante los procesos de diagnóstico o reparación de hardware/software.</li>
        </ul>
    </div>

    <!-- APROBACIÓN VIRTUAL -->
    <div class="mt-14 px-10 relative z-10">
        <div class="bg-gray-50/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4 text-center">
            <p class="text-[10px] text-gray-600 leading-relaxed font-medium">
                Este documento constituye una cotización formal generada digitalmente. Su aceptación puede realizarse vía correo electrónico, WhatsApp corporativo o aprobando el presupuesto directamente a través del portal de seguimiento en línea. <strong>No requiere firma física.</strong>
            </p>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="absolute bottom-6 left-0 right-0 text-center px-10">
        <div class="text-[9px] font-bold text-gray-400 mb-1 border-t border-gray-200 pt-4">
            Documento generado digitalmente por el Sistema de Gestión Sointech
        </div>
    </div>
</div>
