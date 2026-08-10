<div class="space-y-6 animate-fade-in" 
     x-data="{
        chartIncome: null,
        chartStatus: null,
        initCharts() {
            this.$nextTick(() => {
                this.renderCharts();
            });
        },
        renderCharts() {
            const labels = @js($chartLabels);
            const salesData = @js($chartSalesData);
            const expensesData = @js($chartExpensesData);
            const statusLabels = @js(array_keys($otStatuses->toArray()));
            const statusValues = @js(array_values($otStatuses->toArray()));

            // 1. Chart Ingresos vs Egresos
            const ctx1 = document.getElementById('incomeChart');
            if (ctx1) {
                if (this.chartIncome) this.chartIncome.destroy();
                this.chartIncome = new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Ingresos ($)',
                                data: salesData,
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.15)',
                                fill: true,
                                tension: 0.35,
                                borderWidth: 3,
                                pointBackgroundColor: '#3b82f6'
                            },
                            {
                                label: 'Egresos ($)',
                                data: expensesData,
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                fill: true,
                                tension: 0.35,
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
                            legend: { labels: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', weight: '600' } } }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { color: '#64748b' } },
                            y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#64748b' } }
                        }
                    }
                });
            }

            // 2. Chart Órdenes por Estado
            const ctx2 = document.getElementById('statusChart');
            if (ctx2 && statusLabels.length > 0) {
                if (this.chartStatus) this.chartStatus.destroy();
                this.chartStatus = new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            data: statusValues,
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', weight: '600' } } }
                        },
                        cutout: '70%'
                    }
                });
            }
        }
     }"
     x-init="initCharts()"
     wire:effect="initCharts()">

    <!-- Include Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Top Header & Action Buttons -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Módulo de Informes & KPIs</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Monitoreo funcional, servicio técnico, finanzas y cálculo de IVA para contador.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('reports.pdf', ['range' => $dateRange, 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
               target="_blank" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-orange-600 hover:bg-orange-500 text-white font-semibold text-sm rounded-xl shadow-lg shadow-orange-500/20 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Exportar Reporte PDF (Contador)
            </a>
        </div>
    </div>

    <!-- Barra de Filtros Intuitiva con Presets de Fechas (Pills) -->
    <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Período de Análisis</span>
            </div>

            <div wire:loading wire:target="selectPreset, dateRange, startDate, endDate" class="text-xs font-semibold text-orange-500 animate-pulse flex items-center gap-1.5">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Actualizando métricas...
            </div>
        </div>

        <!-- Presets Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <button wire:click="selectPreset('today')" 
                    class="px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $dateRange === 'today' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/30 ring-2 ring-orange-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                Hoy
            </button>
            <button wire:click="selectPreset('yesterday')" 
                    class="px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $dateRange === 'yesterday' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/30 ring-2 ring-orange-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                Ayer
            </button>
            <button wire:click="selectPreset('week')" 
                    class="px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $dateRange === 'week' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/30 ring-2 ring-orange-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                Esta Semana
            </button>
            <button wire:click="selectPreset('month')" 
                    class="px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $dateRange === 'month' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/30 ring-2 ring-orange-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                Este Mes
            </button>
            <button wire:click="selectPreset('last_month')" 
                    class="px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $dateRange === 'last_month' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/30 ring-2 ring-orange-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                Mes Anterior
            </button>
            <button wire:click="selectPreset('year')" 
                    class="px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $dateRange === 'year' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/30 ring-2 ring-orange-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                Este Año
            </button>
            <button wire:click="selectPreset('custom')" 
                    class="px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $dateRange === 'custom' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/30 ring-2 ring-orange-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                📅 Personalizado
            </button>
        </div>

        <!-- Custom Date Range Selectors -->
        @if($dateRange === 'custom')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Desde</label>
                <input wire:model.live="startDate" type="date" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl py-2 px-3 text-sm text-slate-800 dark:text-slate-100 focus:outline-none focus:border-orange-500 transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Hasta</label>
                <input wire:model.live="endDate" type="date" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl py-2 px-3 text-sm text-slate-800 dark:text-slate-100 focus:outline-none focus:border-orange-500 transition">
            </div>
        </div>
        @endif
    </div>

    <!-- 🏛️ MÓDULO RESUMEN DE IVA PARA EL CONTADOR -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white border border-indigo-500/30 rounded-3xl p-6 shadow-xl relative overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-indigo-500/20">
            <div>
                <span class="text-xs font-black text-indigo-400 uppercase tracking-widest">Información Impuesto al Valor Agregado (IVA 19%)</span>
                <h2 class="text-xl sm:text-2xl font-black mt-1">Estimación de IVA a Pagar - Contador</h2>
            </div>
            <div class="px-4 py-2 bg-indigo-500/20 rounded-2xl border border-indigo-500/30 text-right">
                <span class="text-[10px] text-indigo-300 font-bold uppercase block">Resultado del Período</span>
                <span class="text-xl font-black {{ $ivaToPay >= 0 ? 'text-emerald-400' : 'text-cyan-400' }}">
                    {{ $ivaToPay >= 0 ? '$ ' . number_format($ivaToPay, 0, ',', '.') : '+$ ' . number_format(abs($ivaToPay), 0, ',', '.') . ' (Favor)' }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <!-- IVA Débito -->
            <div class="bg-slate-900/60 p-4 rounded-2xl border border-blue-500/30">
                <div class="flex items-center justify-between text-blue-400 mb-1">
                    <span class="text-xs font-bold uppercase">1. IVA Débito (Ventas)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                </div>
                <p class="text-2xl font-black text-white">${{ number_format($ivaDebitFiscal, 0, ',', '.') }}</p>
                <p class="text-[11px] text-slate-400 mt-1">Base Neta: ${{ number_format($salesNetTotal, 0, ',', '.') }}</p>
            </div>

            <!-- IVA Crédito -->
            <div class="bg-slate-900/60 p-4 rounded-2xl border border-red-500/30">
                <div class="flex items-center justify-between text-red-400 mb-1">
                    <span class="text-xs font-bold uppercase">2. IVA Crédito (Compras/Gastos)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                </div>
                <p class="text-2xl font-black text-white">${{ number_format($ivaCreditFiscal, 0, ',', '.') }}</p>
                <p class="text-[11px] text-slate-400 mt-1">Base Neta: ${{ number_format($expensesNetTotal, 0, ',', '.') }}</p>
            </div>

            <!-- Estima a Pagar -->
            <div class="bg-slate-900/60 p-4 rounded-2xl border border-emerald-500/30">
                <div class="flex items-center justify-between text-emerald-400 mb-1">
                    <span class="text-xs font-bold uppercase">3. Total Impuesto a Pagar</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-2xl font-black {{ $ivaToPay >= 0 ? 'text-emerald-400' : 'text-cyan-400' }}">
                    ${{ number_format(max(0, $ivaToPay), 0, ',', '.') }}
                </p>
                <p class="text-[11px] text-slate-400 mt-1">Diferencia (Débito - Crédito)</p>
            </div>
        </div>
    </div>

    <!-- 1. CARDS DE KPIS PRINCIPALES -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Ingresos Brutos -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-5 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ingresos Brutos</span>
                <div class="p-2.5 bg-blue-500/10 text-blue-500 rounded-2xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">${{ number_format($grossIncome, 0, ',', '.') }}</p>
            <div class="mt-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                Ventas POS: <strong class="text-blue-500">${{ number_format($totalSales, 0, ',', '.') }}</strong> | OT: <strong class="text-indigo-500">${{ number_format($otTotalRecaudado, 0, ',', '.') }}</strong>
            </div>
        </div>

        <!-- Egresos Totales -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-5 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Egresos Totales</span>
                <div class="p-2.5 bg-red-500/10 text-red-500 rounded-2xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">${{ number_format($totalExpenses, 0, ',', '.') }}</p>
            <div class="mt-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                Gastos y Compras del período
            </div>
        </div>

        <!-- Utilidad Neta -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-5 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Utilidad Neta</span>
                <div class="p-2.5 {{ $netProfit >= 0 ? 'bg-emerald-500/10 text-emerald-500' : 'bg-red-500/10 text-red-500' }} rounded-2xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black {{ $netProfit >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                ${{ number_format($netProfit, 0, ',', '.') }}
            </p>
            <div class="mt-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                Balance Ingresos vs Egresos
            </div>
        </div>

        <!-- Ticket Promedio & Operaciones -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-5 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ticket Promedio</span>
                <div class="p-2.5 bg-orange-500/10 text-orange-500 rounded-2xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">${{ number_format($averageTicket, 0, ',', '.') }}</p>
            <div class="mt-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                {{ $salesCount + $otCount }} operaciones totales
            </div>
        </div>
    </div>

    <!-- 2. NIVEL DE GRÁFICOS INTERACTIVOS (Chart.js) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Gráfico 1: Evolución Diaria (2 cols) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Tendencia de Ingresos vs Egresos</h3>
                </div>
                <span class="text-xs font-semibold text-slate-400">Variación Diaria</span>
            </div>

            <div class="h-64 sm:h-80 relative">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>

        <!-- Gráfico 2: Distribución de Órdenes por Estado (1 col) -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 30a10 10 0 100-20 10 10 0 000 20zM11 4a8 8 0 110 16 8 8 0 010-16z"></path></svg>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Órdenes por Estado</h3>
                </div>
                <span class="text-xs font-extrabold text-orange-500 bg-orange-500/10 px-2.5 py-1 rounded-lg">{{ $otCount }} Total</span>
            </div>

            <div class="h-64 relative flex items-center justify-center">
                @if($otCount > 0)
                    <canvas id="statusChart"></canvas>
                @else
                    <p class="text-xs text-slate-400 font-medium">Sin órdenes de trabajo en el rango seleccionado.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- 🧾 TABLA DETALLE DE VENTAS CON IVA (SOLICITUD DEL CLIENTE) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Libro Detallado de Ventas (Detalle de IVA para Contador)</h3>
            </div>
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">{{ $salesCount }} ventas en el período</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-800 text-[11px] font-black text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-4">Fecha</th>
                        <th class="py-3 px-4">Cliente</th>
                        <th class="py-3 px-4">Método</th>
                        <th class="py-3 px-4 text-right">Monto Neto ($)</th>
                        <th class="py-3 px-4 text-right">IVA 19% ($)</th>
                        <th class="py-3 px-4 text-right">Total ($)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs">
                    @forelse($sales as $sale)
                    @php
                        $sub = $sale->subtotal > 0 ? $sale->subtotal : ($sale->total / 1.19);
                        $tax = $sale->tax_amount > 0 ? $sale->tax_amount : ($sale->total - $sub);
                    @endphp
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition">
                        <td class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900 dark:text-white">{{ $sale->client_name ?? 'Cliente Genérico' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 rounded-lg text-[11px] font-semibold text-slate-600 dark:text-slate-300">
                                {{ $sale->payment_method }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right font-medium text-slate-600 dark:text-slate-400">${{ number_format($sub, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-right font-bold text-blue-500">${{ number_format($tax, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-right font-black text-slate-900 dark:text-white">${{ number_format($sale->total, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400 text-xs">No hay ventas registradas en el período seleccionado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. NIVEL DE DESGLOSE Y PRODUCTIVIDAD -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Desempeño por Técnico -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Técnicos Asignados
                </h3>
            </div>

            <div class="space-y-3">
                @forelse($workOrdersByTech as $techItem)
                <div class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-950 rounded-2xl border border-slate-200/60 dark:border-slate-800">
                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                        {{ $techItem->technician->name ?? 'Sin Asignar' }}
                    </span>
                    <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 rounded-xl text-xs font-bold border border-emerald-500/20">
                        {{ $techItem->total }} órdenes
                    </span>
                </div>
                @empty
                <p class="text-xs text-slate-400 text-center py-6">No hay registros de asignaciones a técnicos.</p>
                @endforelse
            </div>
        </div>

        <!-- Métodos de Pago POS -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Métodos de Pago (Ventas)
                </h3>
            </div>

            <div class="space-y-3">
                @forelse($salesByMethod as $method => $amount)
                <div class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-950 rounded-2xl border border-slate-200/60 dark:border-slate-800">
                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-200 uppercase">
                        {{ $method ?: 'Efectivo' }}
                    </span>
                    <span class="text-sm font-black text-slate-900 dark:text-white">
                        ${{ number_format($amount, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <p class="text-xs text-slate-400 text-center py-6">No hay ventas registradas en el período.</p>
                @endforelse
            </div>
        </div>

        <!-- Top 5 Productos / Repuestos Vendidos -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    Top Vendidos
                </h3>
            </div>

            <div class="space-y-3">
                @forelse($topProducts as $prod)
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-950 rounded-2xl border border-slate-200/60 dark:border-slate-800">
                    <div class="truncate max-w-[160px]">
                        <p class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate">{{ $prod->name }}</p>
                        <span class="text-[10px] text-slate-400">{{ $prod->total_qty }} uds vendidas</span>
                    </div>
                    <span class="text-xs font-black text-orange-500">
                        ${{ number_format($prod->total_amount, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <p class="text-xs text-slate-400 text-center py-6">No hay productos vendidos en este período.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- 4. SNAPSHOT DE INVENTARIO ACTUAL -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Estado Global del Inventario</h3>
            </div>
            <a href="{{ route('inventory.index') }}" class="text-xs font-semibold text-orange-500 hover:underline">Gestionar Inventario →</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-slate-50 dark:bg-slate-950 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-800">
                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Costo Invertido en Stock</span>
                <span class="text-xl font-black text-slate-900 dark:text-white mt-1 block">${{ number_format($inventoryValue, 0, ',', '.') }}</span>
            </div>
            
            <div class="bg-slate-50 dark:bg-slate-950 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-800">
                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Venta Potencial Total</span>
                <span class="text-xl font-black text-emerald-500 mt-1 block">${{ number_format($inventorySaleValue, 0, ',', '.') }}</span>
            </div>

            <div class="bg-red-500/10 p-4 rounded-2xl border border-red-500/20">
                <span class="block text-[10px] font-black text-red-500 uppercase tracking-widest">Productos con Stock Crítico (≤ 5)</span>
                <span class="text-xl font-black text-red-500 mt-1 block">{{ $lowStockCount }} Ítems</span>
            </div>
        </div>
    </div>

</div>
