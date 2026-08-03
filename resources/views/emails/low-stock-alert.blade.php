<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta de Inventario - {{ $company ?? 'Sointech' }}</title>
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
            background: linear-gradient(90deg, #ef4444 0%, #f97316 100%);
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
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
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
        .item-card {
            background-color: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 16px;
            padding: 20px;
            margin: 20px 0;
        }
        .btn-cta {
            display: inline-block;
            background-color: #dc2626;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            padding: 12px 28px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
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
                <span class="status-badge">⚠️ Reposición de Stock Requerida</span>
            </div>
        </div>

        <div class="content">
            @if(!empty($customBody))
                <div style="white-space: pre-line;">{!! nl2br(e($customBody)) !!}</div>
            @else
                <h2 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-top: 0;">Un artículo ha alcanzado su límite mínimo de stock</h2>
                <p>Hola Administrador, la cantidad en inventario del siguiente producto se encuentra en nivel crítico:</p>
            @endif

            <div class="item-card">
                • <strong>Producto:</strong> {{ $item->name }}<br>
                • <strong>Categoría:</strong> {{ ucfirst($item->category ?? 'General') }}<br>
                • <strong>Stock Disponible:</strong> <strong style="color: #dc2626;">{{ $item->stock }} unidades</strong><br>
                • <strong>Stock Mínimo Deseado:</strong> {{ $item->min_stock }} unidades
            </div>

            <p style="font-size: 13px; color: #64748b;">Te sugerimos contactar a tus proveedores para generar una orden de compra antes de que el repuesto se agote por completo.</p>

            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ url('/inventario') }}" class="btn-cta" target="_blank">📦 Gestionar Inventario</a>
            </div>
        </div>

        <div class="footer">
            © {{ date('Y') }} {{ $company }}. Control Automático de Inventario.
        </div>
    </div>
</body>
</html>
