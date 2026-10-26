<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Ejecutivo & Libro de IVA - Sointech</title>
    <style>
        @page {
            margin: 10mm 12mm 12mm 12mm;
        }
        * {
            box-sizing: border-box;
            font-family: 'Helvetica', 'Arial', sans-serif !important;
        }
        body {
            color: #0f172a;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .top-accent {
            height: 4px;
            background: #f97316;
            margin-bottom: 12px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-img {
            max-height: 55px;
            max-width: 180px;
        }
        .report-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            text-align: right;
            margin: 0;
            text-transform: uppercase;
        }
        .report-subtitle {
            font-size: 11px;
            color: #ea580c;
            text-align: right;
            font-weight: bold;
            margin-top: 3px;
        }
        .badge-period {
            display: inline-block;
            background-color: #ffedd5;
            color: #c2410c;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 11px;
            margin-top: 6px;
        }

        /* KPI Cards Table */
        .kpi-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-bottom: 20px;
        }
        .kpi-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }
        .kpi-title {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .kpi-value {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 4px;
        }
        .text-green { color: #16a34a; }
        .text-red { color: #dc2626; }
        .text-orange { color: #ea580c; }
        .text-blue { color: #2563eb; }

        /* Section Titles */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 4px;
            margin-top: 16px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        /* Data Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .data-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 6px 8px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }
        .data-table td {
            padding: 5px 8px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .footer-text {
            margin-top: 30px;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="top-accent"></div>

    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                @if(!empty($logoDark))
                    <img src="{{ $logoDark }}" class="logo-img" alt="Logo">
                @else
                    <h2 style="margin: 0; color: #ea580c;">{{ $settings->trade_name ?? 'SOINTECH' }}</h2>
                @endif
                <div style="font-size: 10px; color: #64748b; margin-top: 4px;">
                    {{ $settings->trade_name ?? 'Sointech Servicio Técnico' }} | RIF: {{ $settings->tax_id ?? 'N/A' }}<br>
                    Teléfono: {{ $settings->phone ?? 'N/A' }} | {{ $settings->email ?? '' }}
                </div>
            </td>
            <td style="width: 50%; text-align: right;">
                <h1 class="report-title">Reporte de IVA & Finanzas</h1>
                <div class="report-subtitle">Resumen Contable para Contador</div>
                <div class="badge-period">{{ $periodLabel }}</div>
            </td>
        </tr>
    </table>

    <!-- KPIS GENERALES E IVA -->
    <table class="kpi-table">
        <tr>
            <td class="kpi-card" style="width: 25%;">
                <div class="kpi-title">Utilidad Mano de Obra + POS</div>
                <div class="kpi-value text-green">${{ number_format($grossIncome, 0, ',', '.') }}</div>
            </td>
            <td class="kpi-card" style="width: 25%;">
                <div class="kpi-title">Repuestos + Envíos (Cliente)</div>
                <div class="kpi-value text-orange">${{ number_format($otThirdPartyTotal ?? 0, 0, ',', '.') }}</div>
            </td>
            <td class="kpi-card" style="width: 25%;">
                <div class="kpi-title">Estima IVA a Pagar</div>
                <div class="kpi-value {{ $ivaToPay >= 0 ? 'text-blue' : 'text-green' }}">
                    ${{ number_format(max(0, $ivaToPay), 0, ',', '.') }}
                </div>
            </td>
            <td class="kpi-card" style="width: 25%;">
                <div class="kpi-title">Utilidad Neta Final</div>
                <div class="kpi-value {{ $netProfit >= 0 ? 'text-green' : 'text-red' }}">
                    ${{ number_format($netProfit, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    <!-- RESUMEN DE IVA Y DESGLOSE DE INGRESOS -->
    <div class="section-title">1. Resumen Contable de Ingresos Reales (Mano de Obra) e IVA (19%)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Concepto / Tipo de Registro</th>
                <th class="text-right">Monto Neto ($)</th>
                <th class="text-right">Monto IVA 19% ($)</th>
                <th class="text-right">Monto Total ($)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Ingresos por Mano de Obra OT (Utilidad Servicio Técnico)</strong></td>
                <td class="text-right">${{ number_format($otLaborNet ?? 0, 0, ',', '.') }}</td>
                <td class="text-right text-blue">${{ number_format($otLaborTax ?? 0, 0, ',', '.') }}</td>
                <td class="text-right text-green"><strong>${{ number_format($otLaborIncome ?? 0, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td><strong>Ventas Directas POS (Mostrador)</strong></td>
                <td class="text-right">${{ number_format($posNetTotal ?? 0, 0, ',', '.') }}</td>
                <td class="text-right text-blue">${{ number_format($posTaxTotal ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">${{ number_format($totalSales, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><em>Reembolso Repuestos y Envíos de Clientes (Costo Terceros - No es Utilidad)</em></td>
                <td class="text-right">-</td>
                <td class="text-right">-</td>
                <td class="text-right text-orange">${{ number_format($otThirdPartyTotal ?? 0, 0, ',', '.') }} (Rep: ${{ number_format($otPartsTotal ?? 0, 0, ',', '.') }} | Env: ${{ number_format($otShippingTotal ?? 0, 0, ',', '.') }})</td>
            </tr>
            <tr>
                <td><strong>Compras & Gastos con Factura (Crédito Fiscal)</strong></td>
                <td class="text-right">${{ number_format($expensesNetTotal, 0, ',', '.') }}</td>
                <td class="text-right text-red">${{ number_format($expensesTaxTotal, 0, ',', '.') }}</td>
                <td class="text-right">${{ number_format($totalExpenses, 0, ',', '.') }}</td>
            </tr>
            <tr style="background-color: #f1f5f9; font-weight: bold;">
                <td>LIQUIDACIÓN ESTIMADA DE IVA A PAGAR AL FISCO (Solo M. Obra + POS - Gastos)</td>
                <td class="text-right">-</td>
                <td class="text-right {{ $ivaToPay >= 0 ? 'text-green' : 'text-blue' }}">
                    ${{ number_format($ivaToPay, 0, ',', '.') }}
                </td>
                <td class="text-right">-</td>
            </tr>
        </tbody>
    </table>

    <!-- DESGLOSE DE ÓRDENES DE TRABAJO -->
    <div class="section-title">2. Desglose de Órdenes de Trabajo (Mano de Obra vs Repuestos de Clientes)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha / OT</th>
                <th>Cliente / Equipo</th>
                <th>Estado</th>
                <th class="text-right">Repuesto ($)</th>
                <th class="text-right">Envío ($)</th>
                <th class="text-right">M. Obra (Utilidad)</th>
                <th class="text-right">Total Cliente</th>
            </tr>
        </thead>
        <tbody>
            @forelse($workOrders ?? [] as $wo)
            <tr>
                <td>#{{ substr($wo->uuid, 0, 8) }} ({{ $wo->created_at->format('d/m/Y') }})</td>
                <td>{{ $wo->client->full_name ?? 'Cliente N/A' }} - {{ $wo->brand_model }}</td>
                <td>{{ $wo->status }}</td>
                <td class="text-right">${{ number_format($wo->parts_total, 0, ',', '.') }}</td>
                <td class="text-right">${{ number_format($wo->shipping_cost ?? 0, 0, ',', '.') }}</td>
                <td class="text-right text-green"><strong>${{ number_format($wo->effective_labor_cost, 0, ',', '.') }}</strong></td>
                <td class="text-right">${{ number_format($wo->calculated_total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No hay órdenes de trabajo en el período.</td>
            </tr>
            @endforelse
            @if(isset($workOrders) && count($workOrders) > 0)
            <tr style="background-color: #f1f5f9; font-weight: bold;">
                <td colspan="3" class="text-right">TOTALES ÓRDENES ACTIVAS</td>
                <td class="text-right text-orange">${{ number_format($otPartsTotal ?? 0, 0, ',', '.') }}</td>
                <td class="text-right text-orange">${{ number_format($otShippingTotal ?? 0, 0, ',', '.') }}</td>
                <td class="text-right text-green">${{ number_format($otLaborIncome ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">${{ number_format(($otThirdPartyTotal ?? 0) + ($otLaborIncome ?? 0), 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- 🧾 DETALLE DE VENTAS DE IVA PARA CONTADOR -->
    <div class="section-title">3. Libro Detallado de Ventas Directas POS (Mostrador)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha / Hora</th>
                <th>Cliente</th>
                <th>Método Pago</th>
                <th class="text-right">Neto ($)</th>
                <th class="text-right">IVA ($)</th>
                <th class="text-right">Total ($)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            @php
                $sub = $sale->subtotal > 0 ? $sale->subtotal : ($sale->total / 1.19);
                $tax = $sale->tax_amount > 0 ? $sale->tax_amount : ($sale->total - $sub);
            @endphp
            <tr>
                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $sale->client_name ?? 'Cliente Genérico' }}</td>
                <td>{{ $sale->payment_method }}</td>
                <td class="text-right">${{ number_format($sub, 0, ',', '.') }}</td>
                <td class="text-right text-blue">${{ number_format($tax, 0, ',', '.') }}</td>
                <td class="text-right"><strong>${{ number_format($sale->total, 0, ',', '.') }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No hay ventas POS registradas en el período.</td>
            </tr>
            @endforelse
            @if(count($sales) > 0)
            <tr style="background-color: #f1f5f9; font-weight: bold;">
                <td colspan="3" class="text-right">TOTALES VENTAS POS</td>
                <td class="text-right">${{ number_format($posNetTotal ?? $salesNetTotal, 0, ',', '.') }}</td>
                <td class="text-right text-blue">${{ number_format($posTaxTotal ?? $salesTaxTotal, 0, ',', '.') }}</td>
                <td class="text-right">${{ number_format($totalSales, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- SERVICIO TÉCNICO -->
    <div class="section-title">3. Rendimiento del Servicio Técnico</div>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top; padding-right: 8px;">
                <p style="font-weight: bold; margin-bottom: 6px;">Estado de las Órdenes:</p>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($otStatuses as $status => $count)
                        <tr>
                            <td>{{ ucfirst($status) }}</td>
                            <td class="text-center"><strong>{{ $count }}</strong></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">Sin órdenes registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top; padding-left: 8px;">
                <p style="font-weight: bold; margin-bottom: 6px;">Productividad por Técnico:</p>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Técnico Asignado</th>
                            <th class="text-center">Órdenes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($workOrdersByTech as $item)
                        <tr>
                            <td>{{ $item->technician->name ?? 'Sin asignar' }}</td>
                            <td class="text-center"><strong>{{ $item->total }}</strong></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">Sin registros de asignación</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <!-- INVENTARIO -->
    <div class="section-title">4. Estado Actual del Inventario</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Métrica de Inventario</th>
                <th class="text-right">Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Costo Total de Productos en Stock</td>
                <td class="text-right">${{ number_format($inventoryValue, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Valor Potencial de Venta en Stock</td>
                <td class="text-right text-green">${{ number_format($inventorySaleValue, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Productos con Stock Crítico (≤ 5 unidades)</td>
                <td class="text-right text-red"><strong>{{ $lowStockCount }} ítems</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer-text">
        Este documento es un reporte consolidado autogenerado por el sistema {{ $settings->trade_name ?? 'Sointech' }} el {{ $generatedAt }}.
    </div>
</body>
</html>
