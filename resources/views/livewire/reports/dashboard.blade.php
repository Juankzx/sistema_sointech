<div class="space-y-6 pb-16 md:pb-6">

    <!-- Top Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50">
                    <x-ui.icon name="bar-chart-2" class="w-5 h-5" />
                </span>
                Módulo de Informes & KPIs
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Monitoreo funcional, servicio técnico, finanzas y cálculo de IVA para contador.</p>
        </div>

        <div class="flex items-center gap-3 self-start sm:self-auto">
            <a href="{{ route('reports.pdf', ['range' => $dateRange, 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
               target="_blank" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold rounded-lg shadow-xs transition duration-150 cursor-pointer">
                <x-ui.icon name="download" class="w-4 h-4" />
                Exportar Reporte PDF (Contador)
            </a>
        </div>
    </div>

    <!-- Barra de Filtros con Presets de Fechas -->
    <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-3">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <x-ui.icon name="calendar" class="w-4 h-4 text-orange-500" />
                <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Período de Análisis</span>
            </div>

            <div wire:loading wire:target="selectPreset, dateRange, startDate, endDate" class="text-xs font-medium text-orange-600 dark:text-orange-400 flex items-center gap-1.5">
                <span class="w-3.5 h-3.5 border-2 border-orange-500/20 border-t-orange-500 rounded-full animate-spin"></span>
                Actualizando métricas...
            </div>
        </div>

        <!-- Presets Buttons -->
        <div class="flex flex-wrap items-center gap-1.5">
            @php
                $presets = [
                    'today' => 'Hoy',
                    'yesterday' => 'Ayer',
                    'week' => 'Esta Semana',
                    'month' => 'Este Mes',
                    'last_month' => 'Mes Anterior',
                    'year' => 'Este Año',
                    'custom' => 'Personalizado',
                ];
            @endphp
            @foreach($presets as $key => $label)
                <button wire:click="selectPreset('{{ $key }}')" 
                        class="px-3 py-1.5 text-xs font-medium rounded-lg transition duration-150 cursor-pointer {{ $dateRange === $key ? 'bg-orange-600 text-white shadow-xs' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <!-- Custom Date Range Selectors -->
        @if($dateRange === 'custom')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-zinc-100 dark:border-zinc-800">
            <div>
                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Desde</label>
                <input wire:model.live="startDate" type="date" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-1.5 px-3 text-xs text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500 transition">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Hasta</label>
                <input wire:model.live="endDate" type="date" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-1.5 px-3 text-xs text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500 transition">
            </div>
        </div>
        @endif
    </div>

    <!-- MÓDULO RESUMEN DE IVA PARA EL CONTADOR -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-800">
            <div>
                <span class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Impuesto al Valor Agregado (IVA 19%)</span>
                <h2 class="text-base font-bold text-zinc-900 dark:text-zinc-100 mt-0.5">Estimación de IVA a Pagar — Contador</h2>
            </div>
            <div class="px-3 py-1.5 bg-zinc-100 dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 text-right self-start sm:self-auto">
                <span class="text-[10px] text-zinc-500 dark:text-zinc-400 font-medium uppercase block">Resultado del Período</span>
                <span class="text-sm font-bold {{ $ivaToPay >= 0 ? 'text-zinc-900 dark:text-zinc-100' : 'text-emerald-600 dark:text-emerald-400' }}">
                    {{ $ivaToPay >= 0 ? '$ ' . number_format($ivaToPay, 0, ',', '.') : '+$ ' . number_format(abs($ivaToPay), 0, ',', '.') . ' (Favor)' }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
            <!-- IVA Débito -->
            <div class="bg-zinc-50 dark:bg-zinc-850 p-3.5 rounded-lg border border-zinc-200/80 dark:border-zinc-800">
                <div class="flex items-center justify-between text-zinc-700 dark:text-zinc-300 mb-1">
                    <span class="text-xs font-semibold">1. IVA Débito (M. Obra + POS)</span>
                    <x-ui.icon name="trending-up" class="w-3.5 h-3.5 text-blue-500" />
                </div>
                <p class="text-xl font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($ivaDebitFiscal, 0, ',', '.') }}</p>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-0.5">Base Neta: ${{ number_format($salesNetTotal, 0, ',', '.') }} (Excluye repuestos)</p>
            </div>

            <!-- IVA Crédito -->
            <div class="bg-zinc-50 dark:bg-zinc-850 p-3.5 rounded-lg border border-zinc-200/80 dark:border-zinc-800">
                <div class="flex items-center justify-between text-zinc-700 dark:text-zinc-300 mb-1">
                    <span class="text-xs font-semibold">2. IVA Crédito (Compras/Gastos)</span>
                    <x-ui.icon name="trending-down" class="w-3.5 h-3.5 text-red-500" />
                </div>
                <p class="text-xl font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($ivaCreditFiscal, 0, ',', '.') }}</p>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-0.5">Base Neta: ${{ number_format($expensesNetTotal, 0, ',', '.') }}</p>
            </div>

            <!-- Estima a Pagar -->
            <div class="bg-zinc-50 dark:bg-zinc-850 p-3.5 rounded-lg border border-zinc-200/80 dark:border-zinc-800">
                <div class="flex items-center justify-between text-zinc-700 dark:text-zinc-300 mb-1">
                    <span class="text-xs font-semibold">3. Total Impuesto a Pagar</span>
                    <x-ui.icon name="dollar-sign" class="w-3.5 h-3.5 text-emerald-500" />
                </div>
                <p class="text-xl font-bold {{ $ivaToPay >= 0 ? 'text-zinc-900 dark:text-zinc-100' : 'text-emerald-600 dark:text-emerald-400' }}">
                    ${{ number_format(max(0, $ivaToPay), 0, ',', '.') }}
                </p>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-0.5">Diferencia (Débito - Crédito)</p>
            </div>
        </div>
    </div>

    <!-- 1. CARDS DE KPIS PRINCIPALES -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Ingresos Reales / Utilidad Bruta -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Ingresos Reales (Tu Utilidad)</span>
                <span class="p-1.5 rounded-md bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                    <x-ui.icon name="trending-up" class="w-4 h-4" />
                </span>
            </div>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($grossIncome, 0, ',', '.') }}</p>
            <div class="mt-2 text-[11px] text-zinc-400 dark:text-zinc-500">
                M. Obra OT: <strong class="text-emerald-600 dark:text-emerald-400 font-semibold">${{ number_format($otLaborIncome, 0, ',', '.') }}</strong> • POS: <strong class="text-zinc-700 dark:text-zinc-300 font-semibold">${{ number_format($totalSales, 0, ',', '.') }}</strong>
            </div>
        </div>

        <!-- Plata de Clientes para Repuestos y Envíos -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Repuestos y Envíos (Cliente)</span>
                <span class="p-1.5 rounded-md bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400">
                    <x-ui.icon name="package" class="w-4 h-4" />
                </span>
            </div>
            <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">${{ number_format($otThirdPartyTotal, 0, ',', '.') }}</p>
            <div class="mt-2 text-[11px] text-zinc-400 dark:text-zinc-500">
                Repuestos: <strong>${{ number_format($otPartsTotal, 0, ',', '.') }}</strong> • Envíos: <strong>${{ number_format($otShippingTotal, 0, ',', '.') }}</strong>
            </div>
        </div>

        <!-- Egresos Totales -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Egresos Totales</span>
                <span class="p-1.5 rounded-md bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400">
                    <x-ui.icon name="trending-down" class="w-4 h-4" />
                </span>
            </div>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($totalExpenses, 0, ',', '.') }}</p>
            <div class="mt-2 text-[11px] text-zinc-400 dark:text-zinc-500">
                Gastos y Compras del período
            </div>
        </div>

        <!-- Utilidad Neta Final -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-xs border-l-4 {{ $netProfit >= 0 ? 'border-l-emerald-500' : 'border-l-red-500' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Utilidad Neta Final</span>
                <span class="p-1.5 rounded-md {{ $netProfit >= 0 ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400' : 'bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400' }}">
                    <x-ui.icon name="dollar-sign" class="w-4 h-4" />
                </span>
            </div>
            <p class="text-2xl font-bold {{ $netProfit >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                ${{ number_format($netProfit, 0, ',', '.') }}
            </p>
            <div class="mt-2 text-[11px] text-zinc-400 dark:text-zinc-500">
                M. Obra Cobrada: <strong class="text-emerald-600 dark:text-emerald-400 font-semibold">${{ number_format($otLaborRealized, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    <!-- 2. NIVEL DE GRÁFICOS INTERACTIVOS (Chart.js) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Gráfico 1: Evolución Diaria (2 cols) -->
        <div class="lg:col-span-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-800">
                <div class="flex items-center gap-2">
                    <x-ui.icon name="bar-chart-2" class="w-4 h-4 text-orange-500" />
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Tendencia de Utilidad (Mano de Obra + POS) vs Egresos</h3>
                </div>
                <span class="text-[11px] text-zinc-400">Excluye repuestos clientes</span>
            </div>

            <div class="h-64 sm:h-72 relative"
                 wire:ignore
                 x-data="{
                     chart: null,
                     init() {
                         this.$nextTick(() => this.updateChart());
                         this.$watch('$wire.chartSalesData', () => this.updateChart());
                         this.$watch('$wire.chartExpensesData', () => this.updateChart());
                         this.$watch('$wire.chartLabels', () => this.updateChart());
                     },
                     updateChart() {
                         const labels = $wire.chartLabels || [];
                         const salesData = $wire.chartSalesData || [];
                         const expensesData = $wire.chartExpensesData || [];
                         const ctx = this.$refs.canvas;
                         if (!ctx) return;

                         if (this.chart) {
                             this.chart.data.labels = labels;
                             this.chart.data.datasets[0].data = salesData;
                             this.chart.data.datasets[1].data = expensesData;
                             this.chart.update();
                         } else {
                             this.chart = new Chart(ctx, {
                                 type: 'line',
                                 data: {
                                     labels: labels,
                                     datasets: [
                                         {
                                             label: 'Utilidad Mano de Obra + POS ($)',
                                             data: salesData,
                                             borderColor: '#10b981',
                                             backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                             fill: true,
                                             tension: 0.3,
                                             borderWidth: 2,
                                             pointBackgroundColor: '#10b981'
                                         },
                                         {
                                             label: 'Egresos ($)',
                                             data: expensesData,
                                             borderColor: '#ef4444',
                                             backgroundColor: 'rgba(239, 68, 68, 0.05)',
                                             fill: true,
                                             tension: 0.3,
                                             borderWidth: 2,
                                             borderDash: [4, 4],
                                             pointBackgroundColor: '#ef4444'
                                         }
                                     ]
                                 },
                                 options: {
                                     responsive: true,
                                     maintainAspectRatio: false,
                                     plugins: {
                                         legend: { labels: { color: '#71717a', font: { family: 'Plus Jakarta Sans', weight: '500', size: 11 } } }
                                     },
                                     scales: {
                                         x: { grid: { display: false }, ticks: { color: '#a1a1aa', font: { size: 10 } } },
                                         y: { grid: { color: 'rgba(161, 161, 170, 0.1)' }, ticks: { color: '#a1a1aa', font: { size: 10 } } }
                                     }
                                 }
                             });
                         }
                     }
                 }">
                <canvas x-ref="canvas"></canvas>
            </div>
        </div>

        <!-- Gráfico 2: Distribución de Órdenes por Estado (1 col) -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-800">
                <div class="flex items-center gap-2">
                    <x-ui.icon name="pie-chart" class="w-4 h-4 text-orange-500" />
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Órdenes por Estado</h3>
                </div>
                <x-ui.badge variant="neutral" size="xs">{{ $otCount }} Total</x-ui.badge>
            </div>

            <div class="h-64 sm:h-72 relative flex items-center justify-center"
                 wire:ignore
                 x-data="{
                     chart: null,
                     init() {
                         this.$nextTick(() => this.updateChart());
                         this.$watch('$wire.otStatusesMap', () => this.updateChart());
                     },
                     updateChart() {
                         const statusMap = $wire.otStatusesMap || {};
                         const statusLabels = Object.keys(statusMap);
                         const statusValues = Object.values(statusMap);
                         const ctx = this.$refs.canvas;
                         if (!ctx) return;

                         if (statusLabels.length === 0) return;

                         if (this.chart) {
                             this.chart.data.labels = statusLabels;
                             this.chart.data.datasets[0].data = statusValues;
                             this.chart.update();
                         } else {
                             this.chart = new Chart(ctx, {
                                 type: 'doughnut',
                                 data: {
                                     labels: statusLabels,
                                     datasets: [{
                                         data: statusValues,
                                         backgroundColor: ['#f97316', '#10b981', '#3b82f6', '#ef4444', '#8b5cf6', '#06b6d4'],
                                         borderWidth: 0
                                     }]
                                 },
                                 options: {
                                     responsive: true,
                                     maintainAspectRatio: false,
                                     plugins: {
                                         legend: { position: 'bottom', labels: { color: '#71717a', font: { family: 'Plus Jakarta Sans', weight: '500', size: 11 } } }
                                     },
                                     cutout: '70%'
                                 }
                             });
                         }
                     }
                 }">
                <canvas x-ref="canvas"></canvas>
            </div>
        </div>
    </div>

    <!-- TABLA DESGLOSE DE UTILIDAD POR ORDEN DE TRABAJO -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-800">
            <div>
                <div class="flex items-center gap-2">
                    <x-ui.icon name="wrench" class="w-4 h-4 text-emerald-500" />
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Desglose de Órdenes de Trabajo: Mano de Obra vs Repuestos</h3>
                </div>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-0.5">El costo de repuesto y envío lo paga el cliente; lo que entra como utilidad es la Mano de Obra.</p>
            </div>
            <div class="self-start sm:self-auto">
                <x-ui.badge variant="success" size="sm">
                    Utilidad Mano de Obra: ${{ number_format($otLaborIncome, 0, ',', '.') }}
                </x-ui.badge>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 border-b border-zinc-200 dark:border-zinc-800 text-[10px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        <th class="py-2.5 px-3">Fecha / OT</th>
                        <th class="py-2.5 px-3">Cliente / Equipo</th>
                        <th class="py-2.5 px-3">Estado</th>
                        <th class="py-2.5 px-3 text-right">Repuesto (Cliente)</th>
                        <th class="py-2.5 px-3 text-right">Envío (Cliente)</th>
                        <th class="py-2.5 px-3 text-right">Mano de Obra (Utilidad)</th>
                        <th class="py-2.5 px-3 text-right">Total Cliente</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($workOrders as $wo)
                    @php
                        $woParts = $wo->parts_total;
                        $woShipping = (float) ($wo->shipping_cost ?? 0);
                        $woLabor = $wo->effective_labor_cost;
                        $woTotal = $wo->calculated_total;
                        $isRejected = in_array($wo->status, ['Rechazado', 'Cancelado']);
                    @endphp
                    <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition {{ $isRejected ? 'opacity-50 line-through' : '' }}">
                        <td class="py-2.5 px-3">
                            <span class="font-mono font-semibold text-orange-600 dark:text-orange-400 block">#{{ substr($wo->uuid, 0, 8) }}</span>
                            <span class="text-[10px] text-zinc-400">{{ $wo->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="py-2.5 px-3">
                            <span class="font-medium text-zinc-800 dark:text-zinc-200 block">{{ $wo->client->full_name ?? 'Cliente N/A' }}</span>
                            <span class="text-[10px] text-zinc-400">{{ $wo->brand_model }}</span>
                        </td>
                        <td class="py-2.5 px-3">
                            <x-ui.badge variant="neutral" size="xs">
                                {{ $wo->status }}
                            </x-ui.badge>
                        </td>
                        <td class="py-2.5 px-3 text-right font-medium text-amber-600 dark:text-amber-400">${{ number_format($woParts, 0, ',', '.') }}</td>
                        <td class="py-2.5 px-3 text-right font-medium text-zinc-500 dark:text-zinc-400">${{ number_format($woShipping, 0, ',', '.') }}</td>
                        <td class="py-2.5 px-3 text-right font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($woLabor, 0, ',', '.') }}</td>
                        <td class="py-2.5 px-3 text-right font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($woTotal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-zinc-400 text-xs">No hay órdenes de trabajo en el período seleccionado.</td>
                    </tr>
                    @endforelse
                    @if(count($workOrders) > 0)
                    <tr class="bg-zinc-50 dark:bg-zinc-850 font-bold text-xs border-t border-zinc-200 dark:border-zinc-700">
                        <td colspan="3" class="py-3 px-3 text-right uppercase text-zinc-500 dark:text-zinc-400">Totales del Período:</td>
                        <td class="py-3 px-3 text-right text-amber-600 dark:text-amber-400">${{ number_format($otPartsTotal, 0, ',', '.') }}</td>
                        <td class="py-3 px-3 text-right text-zinc-500 dark:text-zinc-400">${{ number_format($otShippingTotal, 0, ',', '.') }}</td>
                        <td class="py-3 px-3 text-right text-emerald-600 dark:text-emerald-400">${{ number_format($otLaborIncome, 0, ',', '.') }}</td>
                        <td class="py-3 px-3 text-right text-zinc-900 dark:text-zinc-100">${{ number_format($otPartsTotal + $otShippingTotal + $otLaborIncome, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- TABLA DETALLE DE VENTAS POS CON IVA -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center gap-2">
                <x-ui.icon name="receipt" class="w-4 h-4 text-orange-500" />
                <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Libro Detallado de Ventas Directas POS</h3>
            </div>
            <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $salesCount }} ventas POS en el período</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 border-b border-zinc-200 dark:border-zinc-800 text-[10px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        <th class="py-2.5 px-3">Fecha</th>
                        <th class="py-2.5 px-3">Cliente</th>
                        <th class="py-2.5 px-3">Método</th>
                        <th class="py-2.5 px-3 text-right">Monto Neto ($)</th>
                        <th class="py-2.5 px-3 text-right">IVA 19% ($)</th>
                        <th class="py-2.5 px-3 text-right">Total ($)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($sales as $sale)
                    @php
                        $sub = $sale->subtotal > 0 ? $sale->subtotal : ($sale->total / 1.19);
                        $tax = $sale->tax_amount > 0 ? $sale->tax_amount : ($sale->total - $sub);
                    @endphp
                    <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition">
                        <td class="py-2.5 px-3 font-mono text-zinc-500 dark:text-zinc-400">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-2.5 px-3 font-medium text-zinc-800 dark:text-zinc-200">{{ $sale->client_name ?? 'Cliente Genérico' }}</td>
                        <td class="py-2.5 px-3">
                            <x-ui.badge variant="neutral" size="xs">
                                {{ $sale->payment_method }}
                            </x-ui.badge>
                        </td>
                        <td class="py-2.5 px-3 text-right font-medium text-zinc-500 dark:text-zinc-400">${{ number_format($sub, 0, ',', '.') }}</td>
                        <td class="py-2.5 px-3 text-right font-medium text-zinc-500 dark:text-zinc-400">${{ number_format($tax, 0, ',', '.') }}</td>
                        <td class="py-2.5 px-3 text-right font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($sale->total, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-zinc-400 text-xs">No hay ventas POS registradas en el período seleccionado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. NIVEL DE DESGLOSE Y PRODUCTIVIDAD -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Desempeño por Técnico -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-xs">
            <div class="flex items-center justify-between mb-3 pb-2 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="text-xs font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-1.5">
                    <x-ui.icon name="user" class="w-3.5 h-3.5 text-orange-500" />
                    Técnicos Asignados
                </h3>
            </div>

            <div class="space-y-2">
                @forelse($workOrdersByTech as $techItem)
                <div class="flex items-center justify-between p-2 bg-zinc-50 dark:bg-zinc-850 rounded-lg border border-zinc-200/60 dark:border-zinc-800 text-xs">
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">
                        {{ $techItem->technician->name ?? 'Sin Asignar' }}
                    </span>
                    <x-ui.badge variant="neutral" size="xs">
                        {{ $techItem->total }} OT
                    </x-ui.badge>
                </div>
                @empty
                <p class="text-[11px] text-zinc-400 text-center py-4">No hay asignaciones registradas.</p>
                @endforelse
            </div>
        </div>

        <!-- Métodos de Pago POS -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-xs">
            <div class="flex items-center justify-between mb-3 pb-2 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="text-xs font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-1.5">
                    <x-ui.icon name="credit-card" class="w-3.5 h-3.5 text-orange-500" />
                    Métodos de Pago
                </h3>
            </div>

            <div class="space-y-2">
                @forelse($salesByMethod as $method => $amount)
                <div class="flex items-center justify-between p-2 bg-zinc-50 dark:bg-zinc-850 rounded-lg border border-zinc-200/60 dark:border-zinc-800 text-xs">
                    <span class="font-medium text-zinc-800 dark:text-zinc-200 uppercase">
                        {{ $method ?: 'Efectivo' }}
                    </span>
                    <span class="font-bold text-zinc-900 dark:text-zinc-100">
                        ${{ number_format($amount, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <p class="text-[11px] text-zinc-400 text-center py-4">No hay ventas registradas.</p>
                @endforelse
            </div>
        </div>

        <!-- Top 5 Productos / Repuestos Vendidos -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-xs">
            <div class="flex items-center justify-between mb-3 pb-2 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="text-xs font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-1.5">
                    <x-ui.icon name="package" class="w-3.5 h-3.5 text-orange-500" />
                    Top Repuestos POS
                </h3>
            </div>

            <div class="space-y-2">
                @forelse($topProducts as $prod)
                <div class="flex items-center justify-between p-2 bg-zinc-50 dark:bg-zinc-850 rounded-lg border border-zinc-200/60 dark:border-zinc-800 text-xs">
                    <div class="truncate max-w-[120px]">
                        <p class="font-medium text-zinc-800 dark:text-zinc-200 truncate">{{ $prod->name }}</p>
                        <span class="text-[10px] text-zinc-400">{{ $prod->total_qty }} uds</span>
                    </div>
                    <span class="font-bold text-zinc-900 dark:text-zinc-100">
                        ${{ number_format($prod->total_amount, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <p class="text-[11px] text-zinc-400 text-center py-4">No hay productos vendidos.</p>
                @endforelse
            </div>
        </div>

        <!-- Top Servicios (Mano de Obra) más solicitados -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-xs">
            <div class="flex items-center justify-between mb-3 pb-2 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="text-xs font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-1.5">
                    <x-ui.icon name="wrench" class="w-3.5 h-3.5 text-orange-500" />
                    Top Servicios
                </h3>
                <span class="text-[10px] font-bold text-zinc-500">
                    ${{ number_format($servicesTotalRevenue, 0, ',', '.') }}
                </span>
            </div>

            <div class="space-y-2">
                @forelse($topServices as $srv)
                <div class="flex items-center justify-between p-2 bg-zinc-50 dark:bg-zinc-850 rounded-lg border border-zinc-200/60 dark:border-zinc-800 text-xs">
                    <div class="truncate max-w-[120px]">
                        <p class="font-medium text-zinc-800 dark:text-zinc-200 truncate">{{ $srv->name }}</p>
                        <span class="text-[10px] text-zinc-400">{{ $srv->total_qty }} serv.</span>
                    </div>
                    <span class="font-bold text-zinc-900 dark:text-zinc-100">
                        ${{ number_format($srv->total_amount, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <p class="text-[11px] text-zinc-400 text-center py-4">No hay servicios catalogados.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- 4. SNAPSHOT DE INVENTARIO ACTUAL -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-xs">
        <div class="flex items-center justify-between mb-3 pb-2 border-b border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center gap-2">
                <x-ui.icon name="package" class="w-4 h-4 text-orange-500" />
                <h3 class="text-xs font-bold text-zinc-900 dark:text-zinc-100">Estado Global del Inventario</h3>
            </div>
            <a href="{{ route('inventory.index') }}" class="text-xs font-medium text-orange-600 dark:text-orange-400 hover:underline">Gestionar Inventario →</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="bg-zinc-50 dark:bg-zinc-850 p-3 rounded-lg border border-zinc-200/60 dark:border-zinc-800">
                <span class="block text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Costo Invertido en Stock</span>
                <span class="text-lg font-bold text-zinc-900 dark:text-zinc-100 mt-1 block">${{ number_format($inventoryValue, 0, ',', '.') }}</span>
            </div>
            
            <div class="bg-zinc-50 dark:bg-zinc-850 p-3 rounded-lg border border-zinc-200/60 dark:border-zinc-800">
                <span class="block text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Venta Potencial Total</span>
                <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400 mt-1 block">${{ number_format($inventorySaleValue, 0, ',', '.') }}</span>
            </div>

            <div class="bg-red-50/50 dark:bg-red-950/20 p-3 rounded-lg border border-red-200 dark:border-red-900/40">
                <span class="block text-[10px] font-semibold text-red-600 dark:text-red-400 uppercase tracking-wider">Stock Crítico (≤ 5)</span>
                <span class="text-lg font-bold text-red-600 dark:text-red-400 mt-1 block">{{ $lowStockCount }} Ítems</span>
            </div>
        </div>
    </div>

</div>