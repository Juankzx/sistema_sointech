<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cotización #{{ $quotation->quote_number }} - {{ $quotation->client_name ?? 'Cliente' }}</title>
    <style>
        @page {
            margin: 8mm 12mm 12mm 12mm;
        }
        * {
            box-sizing: border-box;
            font-family: 'Helvetica', 'Arial', sans-serif !important;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif !important;
            color: #0f172a;
            font-size: 11.5px;
            line-height: 1.45;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .container {
            max-width: 820px;
            margin: 0 auto;
            padding: 10px;
            font-family: 'Helvetica', 'Arial', sans-serif !important;
        }

        /* Top Color Accent Line - Naranja Corporativo */
        .top-accent-bar {
            height: 5px;
            background: #ea580c;
            border-radius: 4px 4px 0 0;
            margin-bottom: 12px;
        }
        
        /* Modern Header Container */
        .header-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
        }

        /* Company Identity Box (Logo + Details Side by Side) */
        .identity-box {
            display: table;
            width: 100%;
        }
        .logo-cell {
            display: table-cell;
            vertical-align: top;
            width: 120px;
            padding-right: 15px;
        }
        .logo-img {
            max-width: 110px;
            max-height: 70px;
            object-fit: contain;
            border-radius: 8px;
        }
        .info-cell {
            display: table-cell;
            vertical-align: top;
        }
        .company-title {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin: 0 0 4px 0;
            text-transform: uppercase;
        }
        .company-meta-line {
            font-size: 11px;
            color: #475569;
            margin-bottom: 3px;
        }
        .company-link {
            color: #ea580c;
            font-weight: bold;
            text-decoration: none;
        }

        /* Quotation Number & Dates Box */
        .quote-meta-box {
            text-align: right;
            border-left: 2px solid #fed7aa;
            padding-left: 16px;
        }
        .quote-main-title {
            font-size: 16px;
            font-weight: bold;
            color: #ea580c;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0 0 2px 0;
        }
        .quote-folio {
            font-size: 15px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .date-row {
            font-size: 10.5px;
            color: #64748b;
            margin-top: 3px;
        }
        .date-row strong {
            color: #334155;
        }

        /* Client & Device Cards */
        .cards-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 12px 0;
            margin-left: -12px;
            margin-right: -12px;
            margin-bottom: 20px;
        }
        .mini-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 16px;
            vertical-align: top;
            width: 50%;
        }
        .mini-card.client-card {
            border-left: 4px solid #ea580c;
        }
        .mini-card.device-card {
            border-left: 4px solid #ea580c;
        }
        .card-caption {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            color: #ea580c;
        }

        .item-row {
            margin-bottom: 4px;
            font-size: 11px;
        }
        .item-lbl {
            font-weight: 600;
            color: #64748b;
            display: inline-block;
            width: 75px;
        }
        .item-val {
            color: #0f172a;
            font-weight: 600;
        }
        .item-val-highlight {
            color: #0f172a;
            font-weight: bold;
        }

        /* Items Table */
        .items-section {
            margin-bottom: 20px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }
        .items-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 12px;
            text-align: left;
            border-bottom: 2px solid #ea580c;
        }
        .items-table th.text-center { text-align: center; }
        .items-table th.text-right { text-align: right; }
        .items-table td {
            padding: 11px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 11.5px;
            vertical-align: middle;
        }
        .items-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        
        /* Type Badges */
        .badge-pill {
            display: inline-block;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 12px;
            letter-spacing: 0.5px;
        }
        .badge-prod {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }
        .badge-serv {
            background-color: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        /* Totals Card */
        .summary-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .totals-box-minimal {
            width: 280px;
            margin-left: auto;
            background-color: #f8fafc;
            border-radius: 10px;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
        }
        .t-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
            font-size: 11px;
            color: #475569;
        }
        .t-row-final {
            margin-top: 6px;
            background-color: #0f172a;
            border-radius: 8px;
            padding: 9px 12px;
            color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 3px solid #ea580c;
        }
        .t-final-label {
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .t-final-val {
            font-size: 15px;
            font-weight: bold;
            color: #ea580c;
        }

        /* Terms Card */
        .terms-panel {
            background-color: #f8fafc;
            border-radius: 10px;
            border-left: 4px solid #ea580c;
            padding: 12px 16px;
            margin-bottom: 22px;
        }
        .terms-title-txt {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #ea580c;
            letter-spacing: 0.8px;
            margin-bottom: 5px;
        }
        .terms-body-txt {
            font-size: 10px;
            color: #475569;
            white-space: pre-line;
            line-height: 1.55;
        }

        .foot-text {
            text-align: center;
            font-size: 9.5px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
            margin-top: 20px;
        }

        /* Web Action Header */
        .web-bar {
            background-color: #0f172a;
            color: #ffffff;
            padding: 10px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }
        .action-btn {
            background-color: #ea580c;
            color: #ffffff;
            border: none;
            padding: 7px 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        .action-btn:hover { background-color: #c2410c; }
        .action-dl { background-color: #059669; }
        .action-dl:hover { background-color: #047857; }

        @media print {
            .web-bar { display: none !important; }
            body { background: #ffffff; }
            .container { padding: 0; max-width: 100%; }
        }
    </style>
</head>
<body @if(!isset($isPdfDownload)) onload="window.print()" @endif>

    @if(!isset($isPdfDownload))
    <div class="container web-bar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <button onclick="if(window.history.length > 1){ window.history.back(); } else { window.location.href='{{ route('quotations.index') }}'; }" class="action-btn" style="background-color: #334155; margin-right: 4px;">
                ← Volver
            </button>
            <span style="font-weight: bold; font-size: 13px;">Cotización {{ $quotation->quote_number }}</span>
            <span style="font-size: 12px; color: #94a3b8; display: inline-block;" class="hide-mobile">| {{ $quotation->client_name ?? 'Cliente' }}</span>
        </div>
        <div style="display: flex; align-items: center; gap: 6px;">
            <a href="{{ route('quotations.download', $quotation->id) }}" class="action-btn action-dl">
                Descargar PDF
            </a>
            <button onclick="window.print()" class="action-btn">
                Imprimir Presupuesto
            </button>
        </div>
    </div>
    @endif

    <div class="container">
        
        <div class="top-accent-bar"></div>

        <!-- Header Card con Logo y Datos de Soin Technology -->
        <div class="header-card">
            <table class="header-table">
                <tr>
                    <td style="width: 65%;">
                        <div class="identity-box">
                            <div class="logo-cell">
                                @if(isset($logoLight) && $logoLight)
                                    <img src="{{ $logoLight }}" alt="Logo" class="logo-img">
                                @elseif(isset($logoDark) && $logoDark)
                                    <img src="{{ $logoDark }}" alt="Logo" class="logo-img">
                                @endif
                            </div>
                            <div class="info-cell">
                                <h1 class="company-title">{{ $settings->trade_name ?? $settings->company_name ?? 'Soin Technology' }}</h1>
                                
                                <div class="company-meta-line">
                                    <strong>Dirección:</strong> {{ $settings->company_address ?? 'Casimiros Olivos #1176' }}
                                </div>
                                <div class="company-meta-line">
                                    <strong>Teléfono/WA:</strong> {{ $settings->company_phone ?? '+56 9 4529 6314' }}
                                </div>
                                <div class="company-meta-line">
                                    <strong>Email:</strong> {{ $settings->support_email ?? 'jzuniga.sointech@gmail.com' }}
                                </div>
                                <div class="company-meta-line">
                                    <strong>Sitio Web:</strong> <a href="https://www.sointech.cl" target="_blank" class="company-link">www.sointech.cl</a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="width: 35%; vertical-align: top;">
                        <div class="quote-meta-box">
                            <div class="quote-main-title">COTIZACIÓN</div>
                            <div class="quote-folio">N° {{ $quotation->quote_number }}</div>
                            <div class="date-row">
                                <strong>Fecha Emisión:</strong> {{ $quotation->created_at->format('d-m-Y') }}
                            </div>
                            <div class="date-row">
                                <strong>Válido Hasta:</strong> {{ $quotation->valid_until ? $quotation->valid_until->format('d-m-Y') : '14-08-2026' }}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Tarjetas del Cliente y del Equipo -->
        <table class="cards-table">
            <tr>
                <td class="mini-card client-card">
                    <div class="card-caption caption-client">DATOS DEL CLIENTE</div>
                    @if(isset($quotation->client) && $quotation->client->company_name)
                    <div class="item-row">
                        <span class="item-lbl">Razón Social:</span>
                        <span class="item-val" style="font-weight: bold; color: #ea580c;">{{ $quotation->client->company_name }}</span>
                    </div>
                    <div class="item-row">
                        <span class="item-lbl">Contacto:</span>
                        <span class="item-val">{{ $quotation->client_name ?? $quotation->client->full_name }}</span>
                    </div>
                    @else
                    <div class="item-row">
                        <span class="item-lbl">Nombre:</span>
                        <span class="item-val">{{ $quotation->client_name ?? ($quotation->client->full_name ?? 'Cliente General') }}</span>
                    </div>
                    @endif

                    @if($quotation->client_rut || (isset($quotation->client) && $quotation->client->rut_dni))
                    <div class="item-row">
                        <span class="item-lbl">RUT:</span>
                        <span class="item-val">{{ $quotation->client_rut ?? $quotation->client->rut_dni }}</span>
                    </div>
                    @endif

                    @if(isset($quotation->client) && $quotation->client->business_activity)
                    <div class="item-row">
                        <span class="item-lbl">Giro:</span>
                        <span class="item-val">{{ $quotation->client->business_activity }}</span>
                    </div>
                    @endif

                    @if(isset($quotation->client) && $quotation->client->address)
                    <div class="item-row">
                        <span class="item-lbl">Dirección:</span>
                        <span class="item-val">{{ $quotation->client->address }} ({{ $quotation->client->commune }})</span>
                    </div>
                    @endif

                    @if($quotation->client_phone || (isset($quotation->client) && $quotation->client->phone))
                    <div class="item-row">
                        <span class="item-lbl">Teléfono:</span>
                        <span class="item-val">{{ $quotation->client_phone ?? $quotation->client->phone }}</span>
                    </div>
                    @endif

                    @if($quotation->client_email || (isset($quotation->client) && $quotation->client->email))
                    <div class="item-row">
                        <span class="item-lbl">Email:</span>
                        <span class="item-val">{{ $quotation->client_email ?? $quotation->client->email }}</span>
                    </div>
                    @endif
                </td>
                <td class="mini-card device-card">
                    <div class="card-caption caption-device">ESPECIFICACIÓN DEL EQUIPO Y SERVICIO</div>
                    <div class="item-row">
                        <span class="item-lbl">Equipo:</span>
                        <span class="item-val-highlight">{{ $quotation->device_info ?? 'Equipo en Servicio Técnico' }}</span>
                    </div>
                    <div class="item-row">
                        <span class="item-lbl">Atendido por:</span>
                        <span class="item-val">{{ $quotation->user->name ?? 'Administrador' }}</span>
                    </div>
                    <div class="item-row">
                        <span class="item-lbl">Estado:</span>
                        <span class="item-val" style="text-transform: uppercase;">{{ $quotation->status_label }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Detalle de Repuestos y Servicios -->
        <div class="items-section">
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 52%;">DESCRIPCIÓN DEL REPUESTO / SERVICIO</th>
                        <th class="text-center" style="width: 14%;">TIPO</th>
                        <th class="text-center" style="width: 8%;">CANT.</th>
                        <th class="text-right" style="width: 13%;">P. UNITARIO</th>
                        <th class="text-right" style="width: 13%;">SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotation->items as $item)
                    <tr>
                        <td>
                            <strong style="color: #0f172a; font-size: 11.5px;">{{ $item->description }}</strong>
                        </td>
                        <td class="text-center">
                            @if(strtolower($item->type) === 'producto')
                                <span class="badge-pill badge-prod">PRODUCTO</span>
                            @else
                                <span class="badge-pill badge-serv">SERVICIO</span>
                            @endif
                        </td>
                        <td class="text-center" style="font-weight: bold; color: #334155;">{{ $item->quantity }}</td>
                        <td class="text-right" style="color: #475569;">${{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="text-right" style="font-weight: bold; color: #0f172a;">${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="color: #94a3b8; padding: 18px;">No hay ítems registrados en esta cotización.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Resumen de Totales -->
        <table class="summary-container">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 15px;">
                    @php
                        $productsTotal = $quotation->products_total;
                        $servicesTotal = $quotation->services_total;
                        $deposit = $quotation->required_deposit;
                        $pending = $quotation->pending_balance;
                    @endphp

                    @if($productsTotal > 0)
                    <div style="background-color: #fff7ed; border: 1px solid #ffedd5; border-left: 4px solid #ea580c; border-radius: 10px; padding: 10px 12px; margin-bottom: 10px; font-size: 10.5px;">
                        <strong style="color: #c2410c; text-transform: uppercase; font-size: 9.5px; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">CONDICIONES DE PAGO Y ENCARGO</strong>
                        <div style="color: #475569; margin-bottom: 3px;">
                            Repuestos / Componentes: <strong style="color: #0f172a;">${{ number_format($productsTotal, 0, ',', '.') }}</strong>
                        </div>
                        <div style="color: #475569; margin-bottom: 4px;">
                            Mano de Obra / Servicios: <strong style="color: #0f172a;">${{ number_format($servicesTotal, 0, ',', '.') }}</strong>
                        </div>
                        <div style="background-color: #ffffff; border: 1px solid #fed7aa; border-radius: 6px; padding: 6px 10px; margin-top: 6px;">
                            <div style="color: #ea580c; font-weight: bold; font-size: 11px;">
                                Abono Requerido (100% Repuestos): <span>${{ number_format($deposit, 0, ',', '.') }} CLP</span>
                            </div>
                            <div style="color: #64748b; font-size: 9.5px; margin-top: 2px;">
                                Saldo Restante al Entregar: <strong>${{ number_format($pending, 0, ',', '.') }} CLP</strong>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($quotation->notes)
                    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; font-size: 10px;">
                        <strong style="color: #ea580c; text-transform: uppercase; font-size: 9px; letter-spacing: 0.5px;">Notas / Observaciones:</strong><br>
                        <span style="color: #475569; margin-top: 4px; display: block;">{{ $quotation->notes }}</span>
                    </div>
                    @endif
                </td>
                <td style="width: 50%;">
                        @php
                            $totalVal = (float)$quotation->total;
                            $taxVal = (float)$quotation->tax_amount;
                            $subtotalVal = (float)$quotation->subtotal;
                            $discountVal = (float)$quotation->discount;
                            $taxIncluded = (bool)$quotation->tax_included;

                            if ($taxIncluded) {
                                $neto = round($totalVal / 1.19);
                                $iva = $totalVal - $neto;
                                $taxLabel = "IVA 19% (Incluido)";
                            } elseif ($taxVal > 0) {
                                $neto = $subtotalVal;
                                $iva = $taxVal;
                                $servicesSum = $quotation->items->where('type', 'servicio')->sum(fn($i) => $i->quantity * $i->unit_price);
                                $expectedLaborTax = round($servicesSum * 0.19);
                                if ($servicesSum > 0 && abs($expectedLaborTax - $taxVal) < 5) {
                                    $taxLabel = "IVA 19% (Solo M. Obra)";
                                } else {
                                    $taxLabel = "IVA 19% (Adicionado)";
                                }
                            } else {
                                $neto = $totalVal;
                                $iva = 0;
                                $taxLabel = "IVA (Exento)";
                            }
                        @endphp

                        <div class="t-row">
                            <span>Subtotal (Neto):</span>
                            <span style="font-weight: 600;">${{ number_format($neto, 0, ',', '.') }}</span>
                        </div>
                        @if($discountVal > 0)
                        <div class="t-row" style="color: #dc2626;">
                            <span>Descuento:</span>
                            <span style="font-weight: 600;">-${{ number_format($discountVal, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="t-row" style="color: #ea580c;">
                            <span>{{ $taxLabel }}:</span>
                            <span style="font-weight: 600;">{{ $iva > 0 ? '+$' . number_format($iva, 0, ',', '.') : '$0' }}</span>
                        </div>
                        <div class="t-row-final">
                            <span class="t-final-label">TOTAL FINAL:</span>
                            <span class="t-final-val">${{ number_format($totalVal, 0, ',', '.') }} CLP</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Términos y Condiciones -->
        @if($quotation->terms_and_conditions)
        <div class="terms-panel">
            <div class="terms-title-txt">TÉRMINOS, CONDICIONES Y GARANTÍA DEL SERVICIO</div>
            <div class="terms-body-txt">{{ $quotation->terms_and_conditions }}</div>
        </div>
        @endif

        <!-- Pie de página -->
        <div class="foot-text">
            Este presupuesto es un documento formal emitido por Soin Technology. Gracias por su preferencia y confianza.
        </div>
    </div>
</body>
</html>
