<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Venta #{{ substr($sale->uuid, 0, 8) }}</title>
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
            margin-bottom: 2px;
        }

        .table-head {
            display: flex;
            justify-content: space-between;
            font-size: 9.5px;
            font-weight: 800;
            color: #374151;
            padding: 2px 0;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 4px 0;
        }
        .item-qty {
            font-weight: 800;
            width: 22px;
            flex-shrink: 0;
        }
        .item-desc {
            flex-grow: 1;
            padding-right: 6px;
        }
        .item-title {
            font-weight: 700;
            font-size: 10.5px;
            color: #111827;
        }
        .item-unit {
            font-size: 9px;
            color: #6b7280;
            font-weight: 500;
        }
        .item-total {
            font-weight: 800;
            font-size: 11px;
            text-align: right;
            flex-shrink: 0;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 10.5px;
            margin-bottom: 3px;
        }
        .total-grand {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 16px;
            font-weight: 800;
            padding-top: 4px;
        }

        .qr-container {
            margin: 12px auto 8px auto;
            text-align: center;
        }
        .qr-img {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            display: block;
        }

        .footer-text {
            font-size: 10px;
            font-weight: 700;
            color: #111827;
            margin-top: 6px;
        }
        .footer-sub {
            font-size: 8.5px;
            color: #6b7280;
            margin-top: 2px;
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
            @if(isset($companySettings) && $companySettings->logo_path)
                <img src="{{ Storage::url($companySettings->logo_path) }}" alt="Logo">
            @else
                <img src="/images/logo-dark.png" alt="Logo Soin">
            @endif
        </div>
        <div class="company-name">{{ strtoupper($companySettings->company_name ?? 'SOIN TECHNOLOGY') }}</div>
        <div class="company-sub">{{ $companySettings->address ?? 'Casimiros Olivos #1176' }}</div>
        <div class="company-sub">Tel: {{ $companySettings->phone ?? '+56 9 4529 6314' }}</div>
    </div>

    <div class="line-dashed"></div>

    <!-- Document Header -->
    <div class="doc-title uppercase text-center">{{ $sale->document_type ?? 'BOLETA' }}</div>
    
    <div class="line-solid"></div>

    <div class="info-grid">
        <div class="flex-between">
            <span><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex-between">
            <span><strong>Folio:</strong> #{{ substr($sale->uuid, 0, 8) }}</span>
            <span><strong>Pago:</strong> {{ $sale->payment_method }}</span>
        </div>
        <div class="flex-between">
            <span><strong>Cliente / Razón Social:</strong> {{ $sale->client_name }}</span>
        </div>
        @if($sale->client_rut)
            <div class="flex-between">
                <span><strong>RUT:</strong> {{ $sale->client_rut }}</span>
            </div>
        @endif
        @if($sale->client_business_activity)
            <div class="flex-between">
                <span><strong>Giro:</strong> {{ $sale->client_business_activity }}</span>
            </div>
        @endif
        @if($sale->client_address)
            <div class="flex-between">
                <span><strong>Dirección:</strong> {{ $sale->client_address }}</span>
            </div>
        @endif
    </div>

    <div class="line-dashed"></div>

    <!-- Table Header -->
    <div class="table-head">
        <span style="width: 22px;">CANT</span>
        <span style="flex-grow: 1;">DESCRIPCIÓN</span>
        <span style="text-align: right;">TOTAL</span>
    </div>

    <div class="line-solid"></div>

    <!-- Items -->
    @foreach($sale->items as $index => $item)
        <div class="item-row">
            <div class="item-qty">{{ $item->quantity }}x</div>
            <div class="item-desc">
                <div class="item-title">{{ $item->name }}</div>
                <div class="item-unit">${{ number_format($item->unit_price, 0, ',', '.') }} c/u</div>
            </div>
            <div class="item-total">${{ number_format($item->subtotal, 0, ',', '.') }}</div>
        </div>
        @if(!$loop->last)
            <div class="line-dotted"></div>
        @endif
    @endforeach

    <div class="line-solid"></div>

    <!-- Totals -->
    <div class="total-row">
        <span>Subtotal Neto:</span>
        <span>${{ number_format($sale->subtotal, 0, ',', '.') }}</span>
    </div>
    <div class="total-row">
        <span>IVA ({{ $sale->tax_rate }}%):</span>
        <span>${{ number_format($sale->tax_amount, 0, ',', '.') }}</span>
    </div>

    <div class="line-solid"></div>

    <div class="total-grand">
        <span>TOTAL:</span>
        <span>${{ number_format($sale->total, 0, ',', '.') }}</span>
    </div>

    <div class="line-dashed"></div>

    <!-- QR Code -->
    <div class="qr-container">
        <img class="qr-img" src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=https://sointech.cl" alt="QR Code">
    </div>

    <div class="text-center">
        <div class="footer-text">¡Gracias por preferir a SOIN TECHNOLOGY!</div>
        <div class="footer-sub">Conserve este comprobante para cualquier consulta.</div>
    </div>

</body>
</html>
