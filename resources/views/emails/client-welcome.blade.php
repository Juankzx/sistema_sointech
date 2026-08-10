<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a {{ $company }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #090d16;
            color: #e2e8f0;
            margin: 0;
            padding: 24px 12px;
            -webkit-text-size-adjust: 100%;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #111827;
            border: 1px solid #1f2937;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        .header-bar {
            height: 6px;
            background: linear-gradient(90deg, #6366f1 0%, #3b82f6 50%, #10b981 100%);
        }
        .header {
            padding: 36px 32px 20px 32px;
            text-align: center;
            background-color: #111827;
        }
        .logo-img {
            max-height: 65px;
            width: auto;
            object-fit: contain;
        }
        .company-name {
            font-size: 20px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-top: 10px;
            text-transform: uppercase;
        }
        .content {
            padding: 0 32px 36px 32px;
            font-size: 15px;
            line-height: 1.65;
            color: #cbd5e1;
        }
        .greeting {
            font-size: 20px;
            font-weight: 800;
            color: #ffffff;
            margin-top: 0;
            margin-bottom: 12px;
        }
        .info-box {
            background-color: #1f2937;
            border: 1px solid #374151;
            border-radius: 16px;
            padding: 20px;
            margin: 24px 0;
        }
        .info-title {
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            color: #3b82f6;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }
        .btn-container {
            text-align: center;
            margin: 32px 0 24px 0;
        }
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 800;
            text-decoration: none;
            padding: 14px 36px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
            letter-spacing: 0.3px;
        }
        .footer {
            background-color: #0b0f19;
            border-top: 1px solid #1f2937;
            padding: 24px 32px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header-bar"></div>
        
        <div class="header">
            @if(isset($logoUrl))
                <img src="{{ $logoUrl }}" alt="{{ $company }}" class="logo-img">
            @endif
            <div class="company-name">{{ $company }}</div>
        </div>

        <div class="content">
            <h2 class="greeting">¡Hola, {{ $user->name }}! 👋</h2>
            
            <p>Se ha registrado tu perfil de cliente en <strong>{{ $company }}</strong>. A través de nuestro Portal de Servicio Técnico podrás hacer seguimiento en tiempo real de tus equipos, aprobar presupuestos y revisar tu historial de atención.</p>

            <div class="info-box">
                <div class="info-title">🔒 Activa tu cuenta en 1 paso</div>
                <p style="margin: 0; font-size: 14px; color: #9ca3af;">
                    Para establecer tu contraseña personal e ingresar al portal cuando quieras, haz clic en el siguiente botón:
                </p>
            </div>

            <div class="btn-container">
                <a href="{{ $setupUrl }}" class="btn-primary" target="_blank">
                    🔑 Crear mi Contraseña e Ingresar
                </a>
            </div>

            <p style="font-size: 13px; color: #9ca3af; text-align: center;">
                Este enlace de activación es seguro y vence en 24 horas.
            </p>
        </div>

        <div class="footer">
            <p style="margin: 0 0 6px 0;"><strong>{{ $company }}</strong> &bull; Servicio Técnico Especializado</p>
            <p style="margin: 0;">Si no solicitaste esta cuenta, puedes ignorar este correo de forma segura.</p>
        </div>
    </div>
</body>
</html>
