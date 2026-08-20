<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arqueo de Caja #{{ $register->id }} - {{ $appSettings->trade_name ?? 'Sointech' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body { 
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 11.5px; 
            line-height: 1.4;
            color: #0f172a; 
            background: #090d16;
            min-height: 100vh;
        }

        /* BANNER DE NAVEGACIÓN Y CONTROLES (SOLO PANTALLA) */
        .top-navbar {
            background: #0d1117;
            border-bottom: 1px solid #1f2937;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-back {
            background: #1f2937;
            color: #e5e7eb;
            border-color: #374151;
        }
        .btn-back:hover {
            background: #374151;
            color: #ffffff;
        }

        .btn-print {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16,185,129,0.25);
        }
        .btn-print:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-ok { background: rgba(16,185,129,0.15); color: #34d399; border: 1px solid rgba(16,185,129,0.3); }
        .status-diff-neg { background: rgba(244,63,94,0.15); color: #fb7185; border: 1px solid rgba(244,63,94,0.3); }
        .status-diff-pos { background: rgba(245,158,11,0.15); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); }

        /* CONTENEDOR DEL DOCUMENTO DE IMPRESIÓN */
        .page-container {
            display: flex;
            justify-content: center;
            padding: 30px 15px;
        }

        .ticket-card {
            width: 84mm;
            background: #ffffff;
            padding: 20px 16px;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.6);
            color: #111827;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }
        .font-black { font-weight: 900; }
        .uppercase { text-transform: uppercase; }

        .logo-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #0f172a;
            margin: 0 auto 8px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid #1e293b;
            padding: 4px;
        }
        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .company-name {
            font-size: 15px;
            font-weight: 900;
            letter-spacing: -0.3px;
            color: #0f172a;
            margin-bottom: 2px;
        }
        .company-sub {
            font-size: 10px;
            color: #475569;
            font-weight: 600;
        }

        .divider-dashed {
            border-top: 1.5px dashed #64748b;
            margin: 12px 0;
        }
        .divider-solid {
            border-top: 2px solid #0f172a;
            margin: 8px 0;
        }
        .divider-dotted {
            border-top: 1px dotted #cbd5e1;
            margin: 6px 0;
        }

        .doc-header {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px;
            margin: 8px 0;
            text-align: center;
        }
        .doc-title {
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.8px;
            color: #0f172a;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10.5px;
            margin-bottom: 3px;
        }
        .info-row span:first-child { color: #475569; font-weight: 600; }
        .info-row span:last-child { color: #0f172a; font-weight: 700; }

        .section-header {
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.5px;
            color: #0f172a;
            margin-top: 10px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sub-row {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #334155;
            margin-bottom: 3px;
            padding-left: 6px;
        }

        .highlight-box {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 8px 10px;
            margin: 6px 0;
            border: 1px solid #e2e8f0;
        }

        .highlight-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
        }

        .diff-box {
            border-radius: 10px;
            padding: 8px 10px;
            margin-top: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            font-weight: 900;
        }

        .diff-box.ok { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .diff-box.neg { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
        .diff-box.pos { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }

        .notes-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px;
            font-size: 9.5px;
            color: #334155;
            margin: 8px 0;
            line-height: 1.4;
        }

        /* Tabla de Movimientos */
        .payments-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
            margin-top: 6px;
        }
        .payments-table th {
            text-align: left;
            padding: 4px 2px;
            border-bottom: 1.5px solid #0f172a;
            color: #475569;
            font-weight: 800;
            text-transform: uppercase;
        }
        .payments-table td {
            padding: 4px 2px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }

        /* Espaciado para Firmas */
        .signatures-wrapper {
            margin-top: 45px;
            display: flex;
            justify-content: space-between;
            gap: 16px;
        }
        .signature-item {
            text-align: center;
            font-size: 9.5px;
            color: #475569;
            flex: 1;
        }
        .signature-line {
            border-top: 1.5px solid #0f172a;
            margin-bottom: 4px;
            width: 100%;
        }

        .footer-note {
            font-size: 9px;
            font-weight: 700;
            color: #64748b;
            margin-top: 20px;
            text-align: center;
        }

        /* REGLAS PARA IMPRESIÓN (IMPRESORAS TÉRMICAS / PDF) */
        @media print {
            .no-print { display: none !important; }
            body { 
                background: #ffffff !important; 
                padding: 0 !important; 
                margin: 0 auto !important; 
            }
            .page-container { padding: 0 !important; }
            .ticket-card {
                width: 80mm !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 4px !important;
            }
            @page { margin: 0; size: 80mm auto; }
        }
    </style>
</head>
<body>

    @php
        $diferencia = (float)$register->closing_balance - (float)$register->expected_closing_balance;
    @endphp

    <!-- BARRA DE CONTROLES SUPERIOR (SOLO EN PANTALLA) -->
    <div class="top-navbar no-print">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('cash-registers.index') }}" class="btn-action btn-back">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver a Gestión de Cajas
            </a>
            
            <div style="display: flex; align-items: center; gap: 8px; color: #9ca3af; font-size: 13px; font-weight: 700;">
                <span>Caja #{{ $register->id }}</span>
                <span>•</span>
                <span class="status-badge {{ round($diferencia) == 0 ? 'status-ok' : ($diferencia < 0 ? 'status-diff-neg' : 'status-diff-pos') }}">
                    @if(round($diferencia) == 0)
                        ✓ Cuadre Perfecto
                    @elseif($diferencia < 0)
                        ⚠️ Faltante: -${{ number_format(abs($diferencia), 0, ',', '.') }}
                    @else
                        ℹ️ Sobrante: +${{ number_format($diferencia, 0, ',', '.') }}
                    @endif
                </span>
            </div>
        </div>

        <button onclick="window.print()" class="btn-action btn-print">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Imprimir Arqueo (80mm / Ticket)
        </button>
    </div>

    <!-- TARJETA DEL TICKET DE ARQUEO -->
    <div class="page-container">
        <div class="ticket-card">

            <!-- Logo y Empresa -->
            <div class="text-center">
                <div class="logo-circle">
                    @if(isset($appSettings) && $appSettings->logo_path)
                        <img src="{{ Storage::url($appSettings->logo_path) }}" alt="Logo">
                    @else
                        <img src="/images/logo-dark.png" alt="Logo Soin">
                    @endif
                </div>
                <div class="company-name">{{ strtoupper($appSettings->trade_name ?: ($appSettings->company_name ?? 'SOIN TECHNOLOGY')) }}</div>
                @if(isset($appSettings) && $appSettings->company_rut)
                    <div class="company-sub">RUT: {{ $appSettings->company_rut }}</div>
                @endif
                <div class="company-sub">{{ $appSettings->company_address ?? 'Casimiros Olivos #1176' }}</div>
                <div class="company-sub">Tel: {{ $appSettings->company_phone ?? '+56 9 4529 6314' }}</div>
            </div>

            <div class="divider-dashed"></div>

            <!-- Título del Documento -->
            <div class="doc-header">
                <div class="doc-title uppercase">ARQUEO Y CIERRE DE CAJA</div>
                <div style="font-size: 10px; font-weight: 700; color: #475569; margin-top: 2px;">
                    Caja N° #{{ $register->id }}
                </div>
            </div>

            <!-- Datos de Cierre -->
            <div style="margin: 8px 0;">
                <div class="info-row">
                    <span>Apertura:</span>
                    <span>{{ $register->opened_at ? $register->opened_at->format('d/m/Y H:i') : 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span>Cierre:</span>
                    <span>{{ $register->closed_at ? $register->closed_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span>Responsable:</span>
                    <span>{{ $register->user->name ?? 'Administrador' }}</span>
                </div>
            </div>

            <div class="divider-dashed"></div>

            <!-- Resumen Esperado Sistema -->
            <div class="section-header uppercase">
                <span>1. ESPERADO EN SISTEMA</span>
            </div>
            
            <div class="divider-solid"></div>

            <div class="info-row" style="margin-bottom: 4px;">
                <span>Fondo Inicial (Base):</span>
                <span>${{ number_format($register->opening_balance, 0, ',', '.') }}</span>
            </div>

            <div class="sub-row">
                <span>- Efectivo Esp:</span>
                <span>${{ number_format($register->expected_cash, 0, ',', '.') }}</span>
            </div>
            <div class="sub-row">
                <span>- Transferencias Esp:</span>
                <span>${{ number_format($register->expected_transfer, 0, ',', '.') }}</span>
            </div>
            <div class="sub-row">
                <span>- Tarjetas / Vouchers Esp:</span>
                <span>${{ number_format($register->expected_card, 0, ',', '.') }}</span>
            </div>

            <div class="highlight-box">
                <div class="highlight-row">
                    <span>TOTAL ESPERADO:</span>
                    <span>${{ number_format($register->expected_closing_balance, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="divider-dashed"></div>

            <!-- Contabilizado Físico (Cuadre Real) -->
            <div class="section-header uppercase">
                <span>2. CONTABILIZADO FÍSICO (CUADRE)</span>
            </div>

            <div class="divider-solid"></div>

            <div class="sub-row">
                <span>- Efectivo en Gaveta:</span>
                <span>${{ number_format($register->closing_cash, 0, ',', '.') }}</span>
            </div>
            <div class="sub-row">
                <span>- Transferencias Verificadas:</span>
                <span>${{ number_format($register->closing_transfer, 0, ',', '.') }}</span>
            </div>
            <div class="sub-row">
                <span>- Tarjetas / Vouchers:</span>
                <span>${{ number_format($register->closing_card, 0, ',', '.') }}</span>
            </div>

            <div class="highlight-box" style="background: #0f172a; color: #ffffff;">
                <div class="highlight-row" style="color: #ffffff;">
                    <span>TOTAL CONTABILIZADO:</span>
                    <span style="font-size: 13px; font-weight: 900;">${{ number_format($register->closing_balance, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Caja de Diferencia -->
            <div class="diff-box {{ round($diferencia) == 0 ? 'ok' : ($diferencia < 0 ? 'neg' : 'pos') }}">
                <span>DIFERENCIA (CUADRE):</span>
                <span>{{ $diferencia > 0 ? '+' : '' }}${{ number_format($diferencia, 0, ',', '.') }}</span>
            </div>

            <!-- Observaciones -->
            @if($register->notes)
                <div class="divider-dotted"></div>
                <div class="notes-box">
                    <strong>Observaciones de Cierre:</strong><br>
                    {{ $register->notes }}
                </div>
            @endif

            <!-- Desglose Opcional de Movimientos Registrados -->
            @if($register->payments && $register->payments->count() > 0)
                <div class="divider-dashed"></div>
                <div class="section-header uppercase">
                    <span>3. DETALLE DE MOVIMIENTOS ({{ $register->payments->count() }})</span>
                </div>
                <table class="payments-table">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Concepto</th>
                            <th>Método</th>
                            <th class="text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($register->payments as $pay)
                            <tr>
                                <td>{{ $pay->created_at ? $pay->created_at->format('H:i') : '-' }}</td>
                                <td>
                                    @if($pay->workOrder)
                                        OT #{{ substr($pay->workOrder->uuid, 0, 6) }}
                                    @else
                                        {{ Str::limit($pay->description ?: 'Pago Directo', 14) }}
                                    @endif
                                </td>
                                <td>{{ $pay->payment_method }}</td>
                                <td class="text-right font-bold" style="color: {{ $pay->type === 'income' ? '#047857' : '#be123c' }};">
                                    {{ $pay->type === 'income' ? '+' : '-' }}${{ number_format($pay->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="divider-dashed"></div>

            <!-- Firmas -->
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

            <div class="footer-note">
                * Documento Interno de Arqueo - Sistema Sointech *
            </div>

        </div>
    </div>

</body>
</html>
