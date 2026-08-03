<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Servidor SMTP - {{ $company ?? 'Sointech' }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 24px 12px;
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
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        }
        .header {
            padding: 32px 32px 20px 32px;
            text-align: center;
            background-color: #ffffff;
        }
        .logo-img {
            max-height: 65px;
            width: auto;
        }
        .status-badge {
            display: inline-block;
            font-size: 12px;
            font-weight: 800;
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 6px 18px;
            border-radius: 50px;
            text-transform: uppercase;
            margin: 16px 0 20px 0;
        }
        .content {
            padding: 0 32px 32px 32px;
            font-size: 15px;
            line-height: 1.6;
            color: #334155;
        }
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 20px 32px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header-bar"></div>
        <div class="header">
            @if(isset($message) && !empty($logoPath) && file_exists($logoPath))
                <img src="{{ $message->embed($logoPath) }}" alt="{{ $company }}" class="logo-img">
            @elseif(!empty($logoUrl))
                <img src="{{ $logoUrl }}" alt="{{ $company }}" class="logo-img">
            @else
                <h2 style="margin: 0; font-size: 24px; font-weight: 800; color: #ea580c;">{{ $company }}</h2>
            @endif
            <div>
                <span class="status-badge">✅ Conexión SMTP Verificada</span>
            </div>
        </div>

        <div class="content">
            <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin-top: 0;">¡Tu Servidor de Correo Funciona Perfectamente! 👋</h1>
            <p>Este es un correo de prueba enviado desde <strong>{{ $company }}</strong> para confirmar que la configuración SMTP está correctamente establecida.</p>

            <div class="info-card">
                • <strong>Destinatario de Prueba:</strong> {{ $recipientEmail }}<br>
                • <strong>Estado del Servicio:</strong> Activo & Operativo<br>
                • <strong>Envíos Automáticos:</strong> Habilitados
            </div>

            <p style="font-size: 13px; color: #64748b;">A partir de este momento, tus clientes recibirán notificaciones automáticas y personalizadas con el diseño de tu marca.</p>
        </div>

        <div class="footer">
            © {{ date('Y') }} {{ $company }}. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
