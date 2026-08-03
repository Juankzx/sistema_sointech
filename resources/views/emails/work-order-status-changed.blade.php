<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de tu Equipo - {{ $company ?? 'Sointech' }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 24px 12px;
            -webkit-text-size-adjust: 100%;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }
        .header-bar {
            height: 5px;
            background: linear-gradient(90deg, #ea580c 0%, #f97316 100%);
        }
        .header {
            padding: 32px 32px 20px 32px;
            text-align: center;
            background-color: #ffffff;
        }
        .logo-container {
            display: inline-block;
            margin-bottom: 12px;
        }
        .logo-img {
            max-height: 65px;
            width: auto;
            object-contain: fit;
        }
        .company-subtitle {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
            font-weight: 500;
        }
        .status-badge {
            display: inline-block;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.5px;
            padding: 6px 18px;
            border-radius: 50px;
            text-transform: uppercase;
            margin: 16px 0 24px 0;
        }
        .status-ingresado { background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .status-revision { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
        .status-presupuestado { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .status-aprobado { background-color: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .status-reparacion { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
        .status-listo { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .status-entregado { background-color: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }
        .status-rechazado { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .content {
            padding: 0 32px 32px 32px;
            font-size: 15px;
            line-height: 1.6;
            color: #334155;
        }
        .greeting {
            font-size: 19px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 12px;
        }
        .device-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            margin: 24px 0;
        }
        .device-card-title {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            color: #ea580c;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }
        .device-info {
            font-size: 14px;
            color: #334155;
            line-height: 1.7;
        }
        .btn-container {
            text-align: center;
            margin: 28px 0 12px 0;
        }
        .btn-cta {
            display: inline-block;
            background-color: #ea580c;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            padding: 14px 32px;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(234, 88, 12, 0.25);
            transition: all 0.2s ease;
        }
        .footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 24px 32px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
        }
        .footer strong {
            color: #334155;
        }
    </style>
</head>
<body>
    @php
        $code = substr($order->uuid, 0, 8);
        $clientName = $order->client ? $order->client->full_name : 'Cliente';
        $trackingUrl = route('work-orders.track', ['uuid' => $order->uuid]);

        $badgeClass = match($newStatus) {
            'Ingresado' => 'status-ingresado',
            'En Revisión' => 'status-revision',
            'Presupuestado' => 'status-presupuestado',
            'Aprobado' => 'status-aprobado',
            'En Reparación' => 'status-reparacion',
            'Listo para Entrega' => 'status-listo',
            'Entregado' => 'status-entregado',
            'Rechazado' => 'status-rechazado',
            default => 'status-ingresado'
        };

        $statusMessages = [
            'Ingresado' => 'Recibimos tu equipo en nuestra recepción y ha sido registrado formalmente en nuestro taller para su revisión.',
            'En Revisión' => 'Tu equipo ya se encuentra en la mesa de trabajo de nuestros técnicos siendo evaluado minuciosamente.',
            'Presupuestado' => 'Hemos finalizado la revisión técnica de tu equipo y preparamos la propuesta de trabajo.',
            'Aprobado' => 'Recibimos la confirmación de tu presupuesto. Tu equipo entra de inmediato en proceso de reparación.',
            'En Reparación' => 'Nuestros técnicos están ejecutando la reparación y sustitución de piezas de tu dispositivo.',
            'Listo para Entrega' => '¡Excelentes noticias! Tu equipo ya fue reparado, pasó todas las pruebas de calidad y está listo para ser retirado.',
            'Entregado' => 'El equipo ha sido entregado conforme en nuestra sucursal. ¡Muchas gracias por confiar en Sointech!',
            'Rechazado' => 'Tomamos nota de la decisión sobre la propuesta. Puedes pasar a retirar tu equipo en nuestro horario habitual.'
        ];

        $detailMsg = $statusMessages[$newStatus] ?? 'El estado de tu orden de trabajo ha sido actualizado.';
    @endphp

    <div class="email-wrapper">
        <div class="header-bar"></div>
        
        <div class="header">
            <div class="logo-container">
                @if(isset($message) && !empty($logoPath) && file_exists($logoPath))
                    <img src="{{ $message->embed($logoPath) }}" alt="{{ $company }}" class="logo-img">
                @elseif(!empty($logoUrl))
                    <img src="{{ $logoUrl }}" alt="{{ $company }}" class="logo-img">
                @else
                    <h2 style="margin: 0; font-size: 24px; font-weight: 800; color: #ea580c;">{{ $company }}</h2>
                @endif
            </div>
            <div class="company-subtitle">Servicios Tecnológicos & Servicio Técnico Especializado</div>
            <div>
                <span class="status-badge {{ $badgeClass }}">Estado Actual: {{ $newStatus }}</span>
            </div>
        </div>

        <div class="content">
            @if(!empty($customBody))
                <div style="white-space: pre-line;">{!! nl2br(e($customBody)) !!}</div>
            @else
                <h1 class="greeting">Hola, {{ $clientName }} 👋</h1>
                <p style="margin-top: 0;">Te escribimos de parte del equipo de <strong>{{ $company }}</strong> para informarte sobre las novedades de tu reparación.</p>
                <p>{{ $detailMsg }}</p>
            @endif

            <div class="device-card">
                <div class="device-card-title">📌 Ficha de la Orden #{{ $code }}</div>
                <div class="device-info">
                    • <strong>Equipo:</strong> {{ $order->device_brand }} {{ $order->device_model }}<br>
                    • <strong>N° Serie / IMEI:</strong> {{ $order->serial_number ?: 'N/A' }}<br>
                    • <strong>Falla Registrada:</strong> {{ $order->reported_issue }}
                </div>
            </div>

            <div class="btn-container">
                <a href="{{ $trackingUrl }}" class="btn-cta" target="_blank">🔍 Ver Seguimiento en Vivo</a>
            </div>

            <p style="font-size: 13px; color: #64748b; text-align: center; margin-top: 24px;">
                Si tienes alguna consulta adicional, puedes responder directamente a este correo o comunicarte con nuestro equipo.
            </p>
        </div>

        <div class="footer">
            Atentamente,<br>
            <strong>El Equipo de {{ $company }}</strong><br>
            @if(isset($settings) && $settings->phone)
                Teléfono: {{ $settings->phone }} | 
            @endif
            @if(isset($settings) && $settings->address)
                {{ $settings->address }}
            @endif
            <div style="margin-top: 8px; font-size: 11px; color: #94a3b8;">
                © {{ date('Y') }} {{ $company }}. Todos los derechos reservados.
            </div>
        </div>
    </div>
</body>
</html>
