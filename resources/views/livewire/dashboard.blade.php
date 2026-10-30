<div class="space-y-6 animate-fade-in max-w-full overflow-x-hidden" wire:poll.visible.10s>

    <!-- 1. HEADER DE BIENVENIDA & ACCIONES RÁPIDAS -->
    <div class="relative overflow-hidden rounded-2xl p-5 sm:p-6 text-white shadow-lg shadow-slate-950/15 border border-white/10 flex flex-col md:flex-row md:items-center justify-between gap-4"
         style="background: linear-gradient(135deg, #090d16 0%, #0f172a 35%, #1e3a8a 70%, #0284c7 100%);">
        <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-cyan-300/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 left-1/3 w-56 h-56 rounded-full bg-blue-500/15 blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-2.5 py-0.5 bg-white/15 backdrop-blur-md text-white border border-white/20 text-[10px] font-bold uppercase tracking-wider rounded-full">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
                <span class="text-xs text-slate-300 font-medium">{{ ucfirst(\Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')) }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight mt-1.5">
                ¡Hola, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-xs text-slate-300 mt-0.5">Resumen de operaciones del taller y estado en tiempo real.</p>
        </div>

        <!-- Quick Action Buttons -->
        <div class="relative z-10 flex flex-wrap items-center gap-2.5">
            @if(auth()->user()->isAdmin() || auth()->user()->role === 'recepcionista')
                <a href="{{ route('work-orders.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white text-blue-900 hover:bg-blue-50 font-bold text-xs rounded-xl transition shadow-md hover:-translate-y-0.5">
                    <x-ui.icon name="plus" class="w-4 h-4 text-blue-600" />
                    <span>Nueva Orden OT</span>
                </a>
                <a href="{{ route('pos.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white/15 hover:bg-white/25 backdrop-blur-md text-white border border-white/30 font-bold text-xs rounded-xl transition shadow-sm hover:-translate-y-0.5">
                    <x-ui.icon name="shopping-bag" class="w-4 h-4 text-cyan-300" />
                    <span>Punto de Venta POS</span>
                </a>
            @endif
        </div>
    </div>

    <!-- 2. TARJETAS DE KPIS PRINCIPALES (GRID 5 COLS) -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
        <!-- Total Órdenes (Azul Tech) -->
        <div class="bg-white dark:bg-zinc-900 border border-blue-200/80 dark:border-blue-800/50 rounded-2xl p-4 shadow-xs flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-cyan-500"></div>
            <div>
                <span class="text-[11px] font-bold text-blue-600 dark:text-blue-300 uppercase tracking-wider block">Órdenes Totales</span>
                <span class="text-2xl font-extrabold font-mono text-zinc-900 dark:text-zinc-100 mt-0.5 block">{{ $totalOrders }}</span>
                <span class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5 block">{{ $ingresadas }} en recepción</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-cyan-600 flex items-center justify-center text-white shadow-md shadow-blue-500/30 shrink-0">
                <x-ui.icon name="clipboard" class="w-5 h-5" />
            </div>
        </div>

        <!-- En Reparación (Azul & Celeste) -->
        <div class="bg-white dark:bg-zinc-900 border border-sky-200/80 dark:border-sky-800/50 rounded-2xl p-4 shadow-xs flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-cyan-400"></div>
            <div>
                <span class="text-[11px] font-bold text-blue-600 dark:text-cyan-300 uppercase tracking-wider block">En Reparación</span>
                <span class="text-2xl font-extrabold font-mono text-zinc-900 dark:text-zinc-100 mt-0.5 block">{{ $enReparacion }}</span>
                <span class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5 block">{{ $enRevision }} en revisión</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white shadow-md shadow-cyan-500/30 shrink-0">
                <x-ui.icon name="tool" class="w-5 h-5" />
            </div>
        </div>

        <!-- Esperando Repuestos (Ámbar Cálido) -->
        <div class="bg-white dark:bg-zinc-900 border border-amber-200/80 dark:border-amber-800/50 rounded-2xl p-4 shadow-xs flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-400"></div>
            <div>
                <span class="text-[11px] font-bold text-amber-600 dark:text-amber-300 uppercase tracking-wider block">Esp. Repuestos</span>
                <span class="text-2xl font-extrabold font-mono text-zinc-900 dark:text-zinc-100 mt-0.5 block">{{ $esperandoRepuestos }}</span>
                <span class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5 block">A la espera de piezas</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-md shadow-amber-500/30 shrink-0">
                <x-ui.icon name="package" class="w-5 h-5" />
            </div>
        </div>

        <!-- Listas para Entrega (Esmeralda / Turquesa) -->
        <div class="bg-white dark:bg-zinc-900 border border-emerald-200/80 dark:border-emerald-800/50 rounded-2xl p-4 shadow-xs flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div>
                <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-300 uppercase tracking-wider block">Listas Entrega</span>
                <span class="text-2xl font-extrabold font-mono text-emerald-600 dark:text-emerald-400 mt-0.5 block">{{ $listas }}</span>
                <span class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5 block">{{ $entregadas }} entregadas</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-md shadow-emerald-500/30 shrink-0">
                <x-ui.icon name="check-circle" class="w-5 h-5" />
            </div>
        </div>

        <!-- Utilidad Mano de Obra / Finanzas -->
        <div class="col-span-2 sm:col-span-2 lg:col-span-1 bg-white dark:bg-zinc-900 border border-sky-200/80 dark:border-sky-800/50 rounded-2xl p-4 shadow-xs flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-aurora"></div>
            <div>
                <span class="text-[11px] font-bold text-sky-600 dark:text-sky-300 uppercase tracking-wider block">Utilidad M. Obra</span>
                <span class="text-xl font-extrabold font-mono text-zinc-900 dark:text-zinc-100 mt-0.5 block">
                    ${{ number_format($totalRevenue, 0, ',', '.') }}
                </span>
                <span class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5 block">Ganancia neta taller</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-aurora flex items-center justify-center text-white shadow-md shadow-brand-500/30 shrink-0">
                <x-ui.icon name="dollar-sign" class="w-5 h-5" />
            </div>
        </div>
    </div>

    <!-- 3. GRÁFICOS (2 COLS) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Gráfico 1: Tendencia 7 días (2 cols) -->
        <div class="lg:col-span-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-800">
                <div class="flex items-center gap-2">
                    <x-ui.icon name="trending-up" class="w-4 h-4 text-brand-500" />
                    <h3 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Ingreso de Órdenes (Últimos 7 Días)</h3>
                </div>
                <span class="text-[11px] text-zinc-400">Flujo semanal</span>
            </div>
            <div class="h-60 relative"
                 wire:ignore
                 x-data="{
                     chart: null,
                     init() {
                         this.$nextTick(() => this.updateChart());
                         this.$watch('$wire.chartOrderCounts', () => this.updateChart());
                         this.$watch('$wire.chartLabels', () => this.updateChart());
                     },
                     updateChart() {
                         const labels = $wire.chartLabels || [];
                         const data = $wire.chartOrderCounts || [];
                         const ctx = this.$refs.canvas;
                         if (!ctx) return;

                         if (this.chart) {
                             this.chart.data.labels = labels;
                             this.chart.data.datasets[0].data = data;
                             this.chart.update();
                         } else {
                             this.chart = new Chart(ctx, {
                                 type: 'line',
                                 data: {
                                     labels: labels,
                                     datasets: [{
                                         label: 'Nuevas Órdenes',
                                         data: data,
                                         borderColor: '#8b5cf6',
                                         backgroundColor: 'rgba(99, 102, 241, 0.12)',
                                         fill: true,
                                         tension: 0.3,
                                         borderWidth: 2,
                                         pointBackgroundColor: '#6366f1',
                                         pointRadius: 3
                                     }]
                                 },
                                 options: {
                                     responsive: true,
                                     maintainAspectRatio: false,
                                     plugins: {
                                         legend: { display: false }
                                     },
                                     scales: {
                                         x: { grid: { display: false }, ticks: { color: '#71717a', font: { size: 10 } } },
                                         y: { grid: { color: 'rgba(120, 120, 120, 0.08)' }, ticks: { color: '#71717a', precision: 0, font: { size: 10 } } }
                                     }
                                 }
                             });
                         }
                     }
                 }">
                <canvas x-ref="canvas"></canvas>
            </div>
        </div>

        <!-- Gráfico 2: Carga por Estado (1 col) -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-800">
                <div class="flex items-center gap-2">
                    <x-ui.icon name="pie-chart" class="w-4 h-4 text-zinc-500" />
                    <h3 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Carga del Taller</h3>
                </div>
                <x-ui.badge variant="default">{{ $totalOrders }} OT</x-ui.badge>
            </div>
            <div class="h-60 relative flex items-center justify-center"
                 wire:ignore
                 x-data="{
                     chart: null,
                     init() {
                         this.$nextTick(() => this.updateChart());
                         this.$watch('$wire.statusDistribution', () => this.updateChart());
                     },
                     updateChart() {
                         const statusMap = $wire.statusDistribution || {};
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
                                         backgroundColor: ['#8b5cf6', '#6366f1', '#0ea5e9', '#06b6d4', '#f59e0b', '#10b981'],
                                         borderWidth: 0
                                     }]
                                 },
                                 options: {
                                     responsive: true,
                                     maintainAspectRatio: false,
                                     plugins: {
                                         legend: { position: 'bottom', labels: { color: '#71717a', font: { size: 10 } } }
                                     },
                                     cutout: '72%'
                                 }
                             });
                         }
                     }
                 }">
                <canvas x-ref="canvas"></canvas>
            </div>
        </div>
    </div>

    <!-- 4. TABLA DE ÓRDENES RECIENTES -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-800">
            <div>
                <h3 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider flex items-center gap-2">
                    <x-ui.icon name="clipboard" class="w-4 h-4 text-zinc-500" />
                    Órdenes de Trabajo Recientes
                </h3>
                <p class="text-xs text-zinc-500 mt-0.5">Últimos equipos registrados en el sistema.</p>
            </div>
            
            <a href="{{ route('work-orders.index') }}" class="text-xs font-medium text-brand-600 dark:text-brand-400 hover:underline self-start sm:self-center flex items-center gap-1">
                <span>Ver todas las órdenes</span>
                <x-ui.icon name="arrow-right" class="w-3.5 h-3.5" />
            </a>
        </div>

        <div class="w-full max-w-full overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
                        <th class="py-2.5 px-3">Código OT</th>
                        <th class="py-2.5 px-3">Cliente</th>
                        <th class="py-2.5 px-3">Equipo / Dispositivo</th>
                        <th class="py-2.5 px-3">Estado</th>
                        <th class="py-2.5 px-3 text-right">M. Obra ($)</th>
                        <th class="py-2.5 px-3 text-right">Abono ($)</th>
                        @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                            <th class="py-2.5 px-3 text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800 text-xs">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition">
                        <td class="py-3 px-3">
                            <span class="font-mono text-xs font-semibold text-brand-600 dark:text-brand-400">
                                #{{ substr($order->uuid, 0, 8) }}
                            </span>
                        </td>
                        <td class="py-3 px-3">
                            <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $order->client->full_name }}</div>
                            <div class="text-[11px] text-zinc-500">{{ $order->client->phone }}</div>
                        </td>
                        <td class="py-3 px-3">
                            <div class="flex flex-col gap-0.5">
                                <span class="font-medium text-zinc-900 dark:text-zinc-100 text-xs">{{ $order->brand_model }}</span>
                                <span class="text-[10px] text-zinc-500">
                                    {{ $order->device_type_label }}
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-3">
                            @php
                                $badgeVariant = match($order->status) {
                                    'Ingresado' => 'default',
                                    'En Revisión' => 'info',
                                    'Presupuestado' => 'warning',
                                    'Aprobado' => 'info',
                                    'Esperando Repuestos' => 'warning',
                                    'Rechazado' => 'danger',
                                    'En Reparación' => 'info',
                                    'Listo para Entrega' => 'success',
                                    'Entregado' => 'default',
                                    default => 'default',
                                };
                            @endphp
                            <x-ui.badge :variant="$badgeVariant">{{ $order->status }}</x-ui.badge>
                        </td>
                        <td class="py-3 px-3 text-right font-medium font-mono text-zinc-900 dark:text-zinc-100">
                            ${{ number_format($order->labor_cost, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-3 text-right font-medium font-mono text-emerald-600 dark:text-emerald-400">
                            @if($order->down_payment > 0)
                                ${{ number_format($order->down_payment, 0, ',', '.') }}
                            @else
                                <span class="text-zinc-400 font-normal font-sans text-[11px]">Sin abono</span>
                            @endif
                        </td>
                        @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                            <td class="py-3 px-3 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button 
                                        wire:click="startLogging({{ $order->id }})" 
                                        class="p-1.5 rounded-lg bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer"
                                        title="Gestionar / Ver Detalles"
                                    >
                                        <x-ui.icon name="eye" class="w-3.5 h-3.5" />
                                    </button>

                                    @php
                                        $clientNameShort = explode(' ', $order->client->full_name)[0];
                                        $waMessage = "Hola {$clientNameShort}, puedes hacer el seguimiento de la reparación de tu {$order->brand_model} en tiempo real aquí: " . url('/seguimiento/' . $order->uuid);
                                    @endphp
                                    <a 
                                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client->phone) }}?text={{ urlencode($waMessage) }}"
                                        target="_blank" 
                                        class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:hover:bg-emerald-900/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60 transition cursor-pointer"
                                        title="Notificar por WhatsApp"
                                    >
                                        <x-ui.icon name="whatsapp" class="w-3.5 h-3.5" />
                                    </a>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-zinc-500 text-xs">No hay órdenes de trabajo recientes.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL BITÁCORA Y FOTOS -->
    @if($isLogging)
    <div class="fixed inset-0 z-[100] overflow-y-auto overscroll-contain bg-zinc-950/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 max-w-xl w-full max-h-[90dvh] overflow-y-auto overscroll-contain shadow-2xl relative space-y-4 my-auto">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                    Bitácora de Trabajo - Orden #{{ $loggingOrderCode }}
                </h3>
                <button wire:click="$set('isLogging', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <x-ui.icon name="x" class="w-4 h-4" />
                </button>
            </div>

            <!-- Formulario agregar avance -->
            <div class="space-y-3">
                <div>
                    <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Título del Avance</label>
                    <input wire:model="newLogTitle" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg py-2 px-3 text-xs text-zinc-900 dark:text-zinc-100 focus:ring-1 focus:ring-brand-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Notas del Técnico</label>
                    <textarea wire:model="newLogNotes" rows="3" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg py-2 px-3 text-xs text-zinc-900 dark:text-zinc-100 focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Escribe el avance o diagnóstico..."></textarea>
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Foto Adjunta (Opcional)</label>
                    <input @change="compressAndUploadPhoto($event, 'newLogPhoto', $wire)" type="file" accept="image/*" class="text-xs text-zinc-500">
                    @if($newLogPhoto)
                        <div class="mt-2 flex items-center justify-between bg-zinc-50 dark:bg-zinc-800 p-2 rounded-lg border border-zinc-200 dark:border-zinc-700">
                            <div class="flex items-center gap-2">
                                <img src="{{ $newLogPhoto->temporaryUrl() }}" class="w-9 h-9 object-cover rounded">
                                <span class="text-[11px] text-zinc-500">Foto lista para subir</span>
                            </div>
                            <button type="button" wire:click="$set('newLogPhoto', null)" class="px-2 py-1 bg-red-50 hover:bg-red-100 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-300 rounded text-[10px] font-medium transition cursor-pointer">
                                Quitar
                            </button>
                        </div>
                    @endif
                </div>
                <button wire:click="saveManualLog" class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white font-medium text-xs rounded-lg shadow-xs transition">
                    Guardar Avance
                </button>
            </div>

            <!-- Galería de Fotos Existentes -->
            @if(count($currentOrderImages) > 0)
            <div class="pt-3 border-t border-zinc-100 dark:border-zinc-800">
                <h4 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider mb-2">Galería de Fotos de la Orden</h4>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                    @foreach($currentOrderImages as $img)
                    <div class="relative group rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-800 aspect-square">
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
