<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arqueo de Caja #{{ $register->id }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 11px; 
            line-height: 1.35;
            margin: 0 auto; 
            padding: 12px 10px; 
            width: 80mm; 
            color: #111827; 
            background: #fff;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }
        .font-extrabold { font-weight: 800; }
        .uppercase { text-transform: uppercase; }

        .logo-circle {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #090d16;
            margin: 0 auto 6px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid #0b0f19;
            padding: 5px;
        }
        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .company-name {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -0.3px;
            color: #000;
            margin-bottom: 2px;
        }
        .company-sub {
            font-size: 9.5px;
            color: #4b5563;
            font-weight: 500;
        }

        .line-dashed {
            border-top: 1.5px dashed #000;
            margin: 10px 0;
        }
        .line-solid {
            border-top: 2px solid #000;
            margin: 6px 0;
        }
        .line-dotted {
            border-top: 1px dotted #d1d5db;
            margin: 6px 0;
        }

        .doc-title {
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-grid {
            margin: 6px 0;
            font-size: 10.5px;
        }
        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3px;
        }

        .section-title {
            font-size: 11.5px;
            font-weight: 800;
            margin-top: 10px;
            margin-bottom: 4px;
            letter-spacing: 0.3px;
        }

        .sub-row {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #374151;
            margin-bottom: 2px;
            padding-left: 6px;
        }

        .highlight-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 800;
            color: #000;
            margin: 4px 0;
        }

        /* Espaciado amplio para firmas */
        .signatures-wrapper {
            margin-top: 55px;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            gap: 12px;
        }
        .signature-item {
            text-align: center;
            font-size: 9px;
            color: #374151;
            flex: 1;
        }
        .signature-line {
            border-top: 1.5px solid #000;
            margin-bottom: 4px;
            width: 100%;
        }

        .footer-note {
            font-size: 9px;
            font-weight: 700;
            color: #6b7280;
            margin-top: 24px;
        }

        @media print {
            body { margin: 0 auto; padding: 0; }
            @page { margin: 0; size: 80mm auto; }
        }
    </style>
</head>
<body onload="window.print();">

    <!-- Header Logo & Info -->
    <div class="text-center">
        <div class="logo-circle">
            @if(isset($appSettings) && $appSettings->logo_path)
                <img src="{{ Storage::url($appSettings->logo_path) }}" alt="Logo">
            @else
                <img src="/images/logo-dark.png" alt="Logo Soin">
            @endif
        </div>
        <div class="company-name">{{ strtoupper($appSettings->company_name ?? 'SOIN TECHNOLOGY') }}</div>
        <div class="company-sub">{{ $appSettings->address ?? 'Casimiros Olivos #1176' }}</div>
        <div class="company-sub">Tel: {{ $appSettings->phone ?? '+56 9 4529 6314' }}</div>
    </div>

    <div class="line-dashed"></div>

    <!-- Document Title -->
    <div class="doc-title text-center uppercase">ARQUEO DE CAJA</div>
    
    <div class="line-solid"></div>

    <!-- Cierre Info -->
    <div class="info-grid">
        <div class="flex-between">
            <span><strong>N° Cierre:</strong> {{ $register->id }}</span>
            <span><strong>Fecha:</strong> {{ $register->closed_at ? $register->closed_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex-between">
            <span><strong>Cajero:</strong> {{ $register->user->name ?? 'Administrador' }}</span>
        </div>
    </div>

    <div class="line-dashed"></div>

    <!-- Resumen del día -->
    <div class="section-title uppercase">RESUMEN DEL DÍA</div>
    
    <div class="line-solid"></div>

    <div class="flex-between">
        <span>Base Inicial:</span>
        <span>${{ number_format($register->opening_balance, 0, ',', '.') }}</span>
    </div>

    <div class="highlight-row">
        <span>Total Esperado Sistema:</span>
        <span>${{ number_format($register->expected_closing_balance, 0, ',', '.') }}</span>
    </div>

    <div class="line-dotted"></div>

    <div class="sub-row">
        <span>- Efectivo Esp:</span>
        <span>${{ number_format($register->expected_cash, 0, ',', '.') }}</span>
    </div>
    <div class="sub-row">
        <span>- Transf. Esp:</span>
        <span>${{ number_format($register->expected_transfer, 0, ',', '.') }}</span>
    </div>
    <div class="sub-row">
        <span>- Tarjeta Esp:</span>
        <span>${{ number_format($register->expected_card, 0, ',', '.') }}</span>
    </div>

    <div class="line-dashed"></div>

    <!-- Contabilizado Físico -->
    <div class="section-title uppercase">CONTABILIZADO FÍSICO (CUADRE)</div>

    <div class="line-solid"></div>

    <div class="sub-row">
        <span>- Efectivo Real:</span>
        <span>${{ number_format($register->closing_cash, 0, ',', '.') }}</span>
    </div>
    <div class="sub-row">
        <span>- Transf. Real:</span>
        <span>${{ number_format($register->closing_transfer, 0, ',', '.') }}</span>
    </div>
    <div class="sub-row">
        <span>- Tarjeta Real:</span>
        <span>${{ number_format($register->closing_card, 0, ',', '.') }}</span>
    </div>

    <div class="line-solid"></div>

    <div class="highlight-row">
        <span>TOTAL CONTABILIZADO:</span>
        <span>${{ number_format($register->closing_balance, 0, ',', '.') }}</span>
    </div>

    @php
        $diferencia = $register->closing_balance - $register->expected_closing_balance;
    @endphp
    <div class="highlight-row" style="margin-top: 2px;">
        <span>DIFERENCIA:</span>
        <span>{{ $diferencia > 0 ? '+' : '' }}${{ number_format($diferencia, 0, ',', '.') }}</span>
    </div>

    @if($register->notes)
        <div class="line-dotted"></div>
        <div style="font-size: 9.5px; margin: 4px 0;">
            <strong>Observaciones:</strong> {{ $register->notes }}
        </div>
    @endif

    <div class="line-dashed"></div>

    <!-- Espacio Amplio para Firmas -->
    <div class="signatures-wrapper">
        <div class="signature-item">
            <div class="signature-line"></div>
            <strong>Firma Cajero</strong>
        </div>
        <div class="signature-item">
            <div class="signature-line"></div>
            <strong>Firma Supervisor</strong>
        </div>
    </div>

    <div class="text-center footer-note">
        * Documento Interno de Arqueo *
    </div>

</body>
</html>
