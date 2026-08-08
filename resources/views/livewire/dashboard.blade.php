<div class="space-y-6 animate-fade-in max-w-full overflow-x-hidden"
     x-data="{
        chartTrend: null,
        chartStatus: null,
        initDashboardCharts() {
            this.$nextTick(() => {
                this.renderDashboardCharts();
            });
        },
        renderDashboardCharts() {
            const labels = @js($chartLabels);
            const orderCounts = @js($chartOrderCounts);
            const statusMap = @js($statusDistribution);
            const statusLabels = Object.keys(statusMap);
            const statusValues = Object.values(statusMap);

            // 1. Chart Tendencia
            const ctx1 = document.getElementById('dashTrendChart');
            if (ctx1) {
                if (this.chartTrend) this.chartTrend.destroy();
                this.chartTrend = new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Nuevas Órdenes',
                            data: orderCounts,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.12)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointBackgroundColor: '#3b82f6',
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 11 } } },
                            y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#64748b', precision: 0 } }
                        }
                    }
                });
            }

            // 2. Chart Distribucion Estados
            const ctx2 = document.getElementById('dashStatusChart');
            if (ctx2 && statusLabels.length > 0) {
                if (this.chartStatus) this.chartStatus.destroy();
                this.chartStatus = new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            data: statusValues,
                            backgroundColor: ['#64748b', '#6366f1', '#3b82f6', '#10b981', '#a855f7'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', weight: '600', size: 11 } } }
                        },
                        cutout: '72%'
                    }
                });
            }
        }
     }"
     x-init="initDashboardCharts()"
     wire:effect="initDashboardCharts()">

    <!-- Include Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- 1. HEADER MINIMALISTA DE BIENVENIDA & ACCIONES -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-5">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 bg-orange-500/10 text-orange-600 dark:text-orange-400 border border-orange-500/20 text-[10px] font-black uppercase tracking-wider rounded-full">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
                <span class="text-xs text-slate-400 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d \d\e F \d\e Y') }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-1">
                ¡Hola, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Resumen de operaciones del taller y estado en tiempo real.</p>
        </div>

        <!-- Quick Action Buttons -->
        <div class="flex flex-wrap items-center gap-2.5">
            @if(auth()->user()->isAdmin() || auth()->user()->role === 'recepcionista')
                <a href="{{ route('work-orders.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-orange-600 hover:bg-orange-500 text-white font-semibold text-xs rounded-xl shadow-md shadow-orange-500/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nueva Orden OT
                </a>
                <a href="{{ route('pos.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-semibold text-xs rounded-xl transition-all">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Punto de Venta POS
                </a>
            @endif
        </div>
    </div>

    <!-- 2. TARJETAS DE KPIS PRINCIPALES (GRID 4 COLS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Órdenes -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Órdenes Totales</span>
                <span class="text-3xl font-black text-slate-900 dark:text-white mt-1 block">{{ $totalOrders }}</span>
                <span class="text-[11px] text-slate-400 font-medium mt-0.5 block">{{ $ingresadas }} en recepción</span>
            </div>
            <div class="p-3 bg-blue-500/10 text-blue-500 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>

        <!-- En Reparación -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">En Reparación</span>
                <span class="text-3xl font-black text-indigo-500 mt-1 block">{{ $enReparacion }}</span>
                <span class="text-[11px] text-slate-400 font-medium mt-0.5 block">{{ $enRevision }} en revisión inicial</span>
            </div>
            <div class="p-3 bg-indigo-500/10 text-indigo-500 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
            </div>
        </div>

        <!-- Listas para Entrega -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Listas para Entrega</span>
                <span class="text-3xl font-black text-emerald-500 mt-1 block">{{ $listas }}</span>
                <span class="text-[11px] text-slate-400 font-medium mt-0.5 block">{{ $entregadas }} entregadas en total</span>
            </div>
            <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Recaudación / Finanzas -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Recaudación OT</span>
                <span class="text-2xl font-black text-slate-900 dark:text-white mt-1 block">
                    ${{ number_format($totalRevenue, 0, ',', '.') }}
                </span>
                <span class="text-[11px] text-slate-400 font-medium mt-0.5 block">Abonos + M. Obra Entregada</span>
            </div>
            <div class="p-3 bg-orange-500/10 text-orange-500 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- 3. GRÁFICOS MINIMALISTAS (2 COLS) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Gráfico 1: Tendencia 7 días (2 cols) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Ingreso de Órdenes (Últimos 7 Días)</h3>
                </div>
                <span class="text-[11px] font-semibold text-slate-400">Flujo Semanal</span>
            </div>
            <div class="h-60 relative">
                <canvas id="dashTrendChart"></canvas>
            </div>
        </div>

        <!-- Gráfico 2: Carga por Estado (1 col) -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 30a10 10 0 100-20 10 10 0 000 20zM11 4a8 8 0 110 16 8 8 0 010-16z"></path></svg>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Carga del Taller</h3>
                </div>
                <span class="text-xs font-bold text-orange-500 bg-orange-500/10 px-2 py-0.5 rounded-lg">{{ $totalOrders }} OT</span>
            </div>
            <div class="h-60 relative flex items-center justify-center">
                @if($totalOrders > 0)
                    <canvas id="dashStatusChart"></canvas>
                @else
                    <p class="text-xs text-slate-400">Sin órdenes en el sistema.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- 4. TABLA MINIMALISTA DE ÓRDENES RECIENTES (SIN SCROLLBAR MOLESTO) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Órdenes de Trabajo Recientes
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Últimos equipos registrados en el sistema.</p>
            </div>
            
            <a href="{{ route('work-orders.index') }}" class="text-xs font-semibold text-orange-600 dark:text-orange-400 hover:underline self-start sm:self-center">
                Ver Todas las Órdenes →
            </a>
        </div>

        <div class="w-full max-w-full overflow-x-auto theme-scrollbar">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-800 text-[11px] font-black text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-3">Código OT</th>
                        <th class="py-3 px-3">Cliente</th>
                        <th class="py-3 px-3">Equipo / Dispositivo</th>
                        <th class="py-3 px-3">Estado</th>
                        <th class="py-3 px-3 text-right">M. Obra ($)</th>
                        <th class="py-3 px-3 text-right">Abono ($)</th>
                        @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                            <th class="py-3 px-3 text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/30 transition">
                        <td class="py-3.5 px-3">
                            <span class="font-mono text-xs font-bold text-orange-600 dark:text-orange-400">
                                #{{ substr($order->uuid, 0, 8) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-3">
                            <div class="font-bold text-slate-900 dark:text-white">{{ $order->client->full_name }}</div>
                            <div class="text-[10px] text-slate-400">{{ $order->client->phone }}</div>
                        </td>
                        <td class="py-3.5 px-3">
                            <div class="font-semibold text-slate-800 dark:text-slate-200">{{ $order->brand_model }}</div>
                            <div class="text-[10px] text-slate-400">{{ $order->device_type }}</div>
                        </td>
                        <td class="py-3.5 px-3">
                            @php
                                $statusClasses = [
                                    'Ingresado' => 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700',
                                    'En Revisión' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                                    'Presupuestado' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                    'Aprobado' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                                    'Rechazado' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                    'En Reparación' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                                    'Listo para Entrega' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                    'Entregado' => 'bg-purple-500/10 text-purple-500 border-purple-500/20',
                                ];
                                $class = $statusClasses[$order->status] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold border {{ $class }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="py-3.5 px-3 text-right font-bold text-slate-900 dark:text-white">
                            ${{ number_format($order->labor_cost, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-3 text-right font-bold text-emerald-500">
                            @if($order->down_payment > 0)
                                ${{ number_format($order->down_payment, 0, ',', '.') }}
                            @else
                                <span class="text-slate-400 font-normal text-[11px]">Sin abono</span>
                            @endif
                        </td>
                        @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                            <td class="py-3.5 px-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button 
                                        wire:click="startLogging({{ $order->id }})" 
                                        class="w-8 h-8 rounded-xl bg-blue-500/10 hover:bg-blue-600 text-blue-400 hover:text-white border border-blue-500/20 hover:border-blue-500 transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-blue-500/30 hover:-translate-y-0.5 cursor-pointer group"
                                        title="Gestionar / Ver Detalles"
                                    >
                                        <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>

                                    @php
                                        $clientNameShort = explode(' ', $order->client->full_name)[0];
                                        $waMessage = "Hola {$clientNameShort}, puedes hacer el seguimiento de la reparación de tu {$order->brand_model} en tiempo real aquí: " . url('/seguimiento/' . $order->uuid);
                                    @endphp
                                    <a 
                                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client->phone) }}?text={{ urlencode($waMessage) }}"
                                        target="_blank" 
                                        class="w-8 h-8 rounded-xl bg-emerald-500/10 hover:bg-emerald-600 text-emerald-400 hover:text-white border border-emerald-500/20 hover:border-emerald-500 transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-emerald-500/30 hover:-translate-y-0.5 cursor-pointer group"
                                        title="Notificar por WhatsApp"
                                    >
                                        <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c-.001 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-slate-400 text-xs">No hay órdenes de trabajo recientes.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL BITÁCORA Y FOTOS -->
    @if($isLogging)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 max-w-2xl w-full shadow-2xl relative space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">
                    Bitácora de Trabajo - Orden #{{ $loggingOrderCode }}
                </h3>
                <button wire:click="$set('isLogging', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">✕</button>
            </div>

            <!-- Formulario agregar avance -->
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Título del Avance</label>
                    <input wire:model="newLogTitle" type="text" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl py-2 px-3 text-xs text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Notas del Técnico</label>
                    <textarea wire:model="newLogNotes" rows="3" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl py-2 px-3 text-xs text-slate-900 dark:text-white" placeholder="Escribe el avance o diagnóstico..."></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Foto Adjunta (Opcional)</label>
                    <input wire:model="newLogPhoto" type="file" class="text-xs text-slate-400">
                    @if($newLogPhoto)
                        <div class="mt-2 flex items-center justify-between bg-slate-900 p-2 rounded-xl border border-slate-800">
                            <div class="flex items-center gap-2">
                                <img src="{{ $newLogPhoto->temporaryUrl() }}" class="w-10 h-10 object-cover rounded-lg">
                                <span class="text-[10px] text-slate-400">Foto lista</span>
                            </div>
                            <button type="button" wire:click="$set('newLogPhoto', null)" class="px-2 py-1 bg-red-950/50 hover:bg-red-900 border border-red-800 text-red-300 rounded-lg text-[10px] font-bold transition">
                                ❌ Quitar
                            </button>
                        </div>
                    @endif
                </div>
                <button wire:click="saveManualLog" class="px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white font-semibold text-xs rounded-xl shadow-sm">
                    Guardar Avance
                </button>
            </div>

            <!-- Galería de Fotos Existentes -->
            @if(count($currentOrderImages) > 0)
            <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
                <h4 class="text-xs font-bold text-slate-400 uppercase mb-2">Galería de Fotos de la Orden</h4>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                    @foreach($currentOrderImages as $img)
                    <div class="relative group rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 aspect-square">
                        <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

</div>
