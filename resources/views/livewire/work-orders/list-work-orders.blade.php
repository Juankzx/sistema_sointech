<div class="space-y-5" 
     wire:poll.visible.8s
     x-data
     x-effect="
         if (!$wire.isManaging && !$wire.isDelivering) {
             document.body.style.overflow = '';
             document.body.style.touchAction = '';
             document.documentElement.style.overflow = '';
             document.body.classList.remove('modal-open');
         }
     ">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Órdenes de Trabajo</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Control, diagnóstico y seguimiento de servicios técnicos en taller.</p>
        </div>
        
        @if(auth()->user()->isAdmin() || auth()->user()->role === 'recepcionista')
            <a href="{{ route('work-orders.create') }}" class="inline-flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold px-3.5 py-2 rounded-lg shadow-xs transition self-start sm:self-center">
                <x-ui.icon name="plus" class="w-4 h-4" />
                <span>Nueva Orden</span>
            </a>
        @endif
    </div>

    <!-- TOP FINANCIAL METRICS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        {{-- Tarjeta 1: Saldos por Cobrar --}}
        <div wire:click="$toggle('hasPendingBalanceFilter')" 
            class="p-4 rounded-xl border transition cursor-pointer flex items-center justify-between group shadow-xs
                {{ $hasPendingBalanceFilter ? 'bg-rose-50/80 dark:bg-rose-950/30 border-rose-300 dark:border-rose-800' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700' }}">
            <div class="space-y-0.5">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400 block">
                    Por Cobrar (Pendiente)
                </span>
                <div class="text-xl font-bold text-slate-900 dark:text-white">
                    ${{ number_format($totalPendingReceivables, 0, ',', '.') }}
                </div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block">
                    {{ $pendingCount }} {{ $pendingCount === 1 ? 'orden' : 'órdenes' }} con saldo pendiente
                </span>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200/80 dark:border-rose-900/60">
                <x-ui.icon name="cash" class="w-5 h-5" />
            </div>
        </div>

        {{-- Tarjeta 2: Recaudación por Abonos --}}
        <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 flex items-center justify-between shadow-xs">
            <div class="space-y-0.5">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 block">
                    Total Recaudado (Abonos)
                </span>
                <div class="text-xl font-bold text-slate-900 dark:text-white">
                    ${{ number_format($totalCollected, 0, ',', '.') }}
                </div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block">Ingresos registrados en caja</span>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200/80 dark:border-emerald-900/60">
                <x-ui.icon name="trending-up" class="w-5 h-5" />
            </div>
        </div>

        {{-- Tarjeta 3: Total Registros --}}
        <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 flex items-center justify-between shadow-xs">
            <div class="space-y-0.5">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">
                    Órdenes Filtradas
                </span>
                <div class="text-xl font-bold text-slate-900 dark:text-white">
                    {{ count($workOrders) }}
                </div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block">Coincidencias en sistema</span>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                <x-ui.icon name="work-orders" class="w-5 h-5" />
            </div>
        </div>
    </div>

    <!-- FILTER BAR (SEARCH & STATUS PILLS) -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-xs space-y-3.5">
        <div class="flex flex-col md:flex-row gap-3 items-center justify-between">
            <!-- Search Input -->
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                    <x-ui.icon name="search" class="w-4 h-4" />
                </span>
                <input wire:model.live="search" type="text" placeholder="Buscar por cliente, #OT, serie, modelo..." 
                    class="w-full bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-lg py-1.5 pl-9 pr-3 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-hidden focus:border-orange-500 focus:ring-1 focus:ring-orange-500/30 transition">
            </div>

            <!-- Date & Tech Filters -->
            <div class="flex flex-wrap gap-2 w-full md:w-auto items-center">
                <input wire:model.live="dateFrom" type="date" title="Desde" class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-lg py-1.5 px-2.5 text-xs text-slate-700 dark:text-slate-300 focus:outline-hidden focus:border-orange-500 transition">
                <span class="text-slate-400 text-xs">a</span>
                <input wire:model.live="dateTo" type="date" title="Hasta" class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-lg py-1.5 px-2.5 text-xs text-slate-700 dark:text-slate-300 focus:outline-hidden focus:border-orange-500 transition">
                
                @if(auth()->user()->isAdmin())
                <select wire:model.live="technicianFilter" class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-lg py-1.5 px-2.5 text-xs text-slate-700 dark:text-slate-300 focus:outline-hidden focus:border-orange-500 transition cursor-pointer">
                    <option value="">Técnicos: Todos</option>
                    <option value="unassigned">No Asignado</option>
                    @foreach($technicians as $tech)
                        <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                    @endforeach
                </select>
                @endif
            </div>

            <!-- Right side tools -->
            <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                <!-- Export CSV -->
                <button wire:click="exportCSV" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-950/40 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 font-semibold rounded-lg text-xs transition cursor-pointer" title="Exportar a Excel/CSV">
                    <x-ui.icon name="download" class="w-3.5 h-3.5" />
                    <span>Exportar</span>
                </button>
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700">
                    {{ count($workOrders) }} registro(s)
                </span>
            </div>
        </div>

        <!-- Status Filter Pills -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2.5 border-t border-slate-100 dark:border-slate-800/80">
            <div class="flex flex-wrap gap-1.5">
                <button wire:click="$set('statusFilter', '')" class="px-3 py-1 rounded-lg text-xs font-medium transition border {{ $statusFilter === '' && !$hasPendingBalanceFilter ? 'bg-orange-600 text-white border-orange-700 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    Todos
                </button>
                <button wire:click="$toggle('hasPendingBalanceFilter')" class="px-3 py-1 rounded-lg text-xs font-medium transition border cursor-pointer inline-flex items-center gap-1.5 {{ $hasPendingBalanceFilter ? 'bg-rose-600 text-white border-rose-700 shadow-xs' : 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-900/60 hover:bg-rose-100' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                    <span>Con Saldo Pendiente ({{ $pendingCount }})</span>
                </button>
                <button wire:click="$set('statusFilter', 'Ingresado')" class="px-3 py-1 rounded-lg text-xs font-medium transition border {{ $statusFilter === 'Ingresado' ? 'bg-orange-600 text-white border-orange-700 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    Ingresados
                </button>
                <button wire:click="$set('statusFilter', 'En Reparación')" class="px-3 py-1 rounded-lg text-xs font-medium transition border {{ $statusFilter === 'En Reparación' ? 'bg-orange-600 text-white border-orange-700 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    En Reparación
                </button>
                <button wire:click="$set('statusFilter', 'Esperando Repuestos')" class="px-3 py-1 rounded-lg text-xs font-medium transition border {{ $statusFilter === 'Esperando Repuestos' ? 'bg-orange-600 text-white border-orange-700 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    Esperando Repuestos
                </button>
                <button wire:click="$set('statusFilter', 'Listo para Entrega')" class="px-3 py-1 rounded-lg text-xs font-medium transition border {{ $statusFilter === 'Listo para Entrega' ? 'bg-orange-600 text-white border-orange-700 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    Listos para Entrega
                </button>
                <button wire:click="$set('statusFilter', 'Entregado')" class="px-3 py-1 rounded-lg text-xs font-medium transition border {{ $statusFilter === 'Entregado' ? 'bg-orange-600 text-white border-orange-700 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    Entregados
                </button>
            </div>

            <div class="flex items-center gap-2 pr-1">
                <label class="flex items-center cursor-pointer select-none">
                    <input type="checkbox" wire:model.live="hasWarrantyFilter" class="sr-only peer">
                    <div class="relative w-8 h-4 bg-slate-300 dark:bg-slate-700 peer-focus:outline-hidden rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[1px] after:left-[1px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-emerald-600"></div>
                    <span class="ml-2 text-xs font-medium {{ $hasWarrantyFilter ? 'text-emerald-600 dark:text-emerald-400 font-semibold' : 'text-slate-500 dark:text-slate-400' }}">Solo Garantía Vigente</span>
                </label>
            </div>
        </div>
    </div>

    <!-- DESKTOP TABLE -->
    <div class="hidden md:block bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
        <div class="overflow-x-auto theme-scrollbar">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-800/40 text-slate-500 dark:text-slate-400 font-semibold uppercase text-[10px] tracking-wider border-b border-slate-200 dark:border-slate-800">
                        <th class="px-4 py-3">Código</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Equipo / Dispositivo</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Finanzas</th>
                        <th class="px-4 py-3">Fechas / Gar.</th>
                        @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                            <th class="px-4 py-3 text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/70">
                    @forelse($workOrders as $order)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-colors">
                            <!-- Code -->
                            <td class="px-4 py-3">
                                <span class="font-mono text-xs font-semibold text-orange-600 dark:text-orange-400 uppercase tracking-tight">
                                    #{{ substr($order->uuid, 0, 8) }}
                                </span>
                            </td>
                            <!-- Client -->
                            <td class="px-4 py-3">
                                <div class="flex flex-col">
                                    <span class="font-medium text-slate-900 dark:text-white">{{ $order->client->full_name }}</span>
                                    <span class="text-[11px] text-slate-500 dark:text-slate-400">{{ $order->client->phone }}</span>
                                </div>
                            </td>
                            <!-- Device -->
                            <td class="px-4 py-3">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-slate-900 dark:text-slate-100 font-medium">{{ $order->brand_model }}</span>
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                            {{ $order->device_type_label }}
                                        </span>
                                        @if($order->imei_serial)
                                            <span class="text-[10px] text-slate-400 font-mono">SN: {{ $order->imei_serial }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <!-- Status -->
                            <td class="px-4 py-3">
                                @php
                                    $statusVariants = [
                                        'Ingresado' => 'default',
                                        'En Revisión' => 'info',
                                        'Presupuestado' => 'warning',
                                        'Aprobado' => 'brand',
                                        'Esperando Repuestos' => 'warning',
                                        'Rechazado' => 'danger',
                                        'En Reparación' => 'info',
                                        'Listo para Entrega' => 'success',
                                        'Entregado' => 'purple',
                                    ];
                                    $variant = $statusVariants[$order->status] ?? 'default';
                                @endphp
                                @if(auth()->user()->hasRole(['admin', 'tecnico']))
                                    <div class="relative inline-block" x-data="{ openTableStatus: false }">
                                        <button 
                                            type="button" 
                                            @click="openTableStatus = !openTableStatus" 
                                            class="inline-flex items-center gap-1 cursor-pointer"
                                            title="Clic para cambiar estado"
                                        >
                                            <x-ui.badge :variant="$variant" size="sm" :dot="true">
                                                <span>{{ $order->status }}</span>
                                                <x-ui.icon name="chevron-down" class="w-3 h-3 opacity-60 ml-0.5" />
                                            </x-ui.badge>
                                        </button>
                                        <div 
                                            x-show="openTableStatus" 
                                            @click.outside="openTableStatus = false" 
                                            x-transition 
                                            class="absolute left-0 mt-1 z-50 w-44 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-lg p-1 space-y-0.5 max-h-56 overflow-y-auto"
                                            style="display: none;"
                                        >
                                            @foreach([
                                                'Ingresado', 'En Revisión', 'Presupuestado', 'Aprobado',
                                                'Esperando Repuestos', 'En Reparación', 'Listo para Entrega',
                                                'Entregado', 'Rechazado'
                                            ] as $st)
                                                <button 
                                                    type="button" 
                                                    wire:click="updateStatus({{ $order->id }}, '{{ $st }}')"
                                                    @click="openTableStatus = false"
                                                    class="w-full text-left px-2.5 py-1.5 text-xs font-medium text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg flex items-center justify-between transition-colors"
                                                >
                                                    <span>{{ $st }}</span>
                                                    @if($order->status === $st)
                                                        <x-ui.icon name="check" class="w-3.5 h-3.5 text-orange-600" />
                                                    @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <x-ui.badge :variant="$variant" size="sm" :dot="true">
                                        {{ $order->status }}
                                    </x-ui.badge>
                                @endif
                            </td>
                            <!-- Finanzas -->
                            <td class="px-4 py-3">
                                 @php
                                     $totalCostTable = $order->calculated_total;
                                     $balanceTable   = $order->pending_balance;
                                 @endphp
                                 <div class="flex flex-col gap-0.5">
                                     @if($totalCostTable > 0)
                                         <span class="font-semibold text-slate-900 dark:text-white" title="Presupuesto Total">
                                             Total: ${{ number_format($totalCostTable, 0, ',', '.') }}
                                         </span>
                                     @endif
                                     @if($order->down_payment > 0)
                                         <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">
                                             Abono: ${{ number_format($order->down_payment, 0, ',', '.') }}
                                         </span>
                                     @else
                                         <span class="text-[11px] text-slate-400">
                                             Sin abono
                                         </span>
                                     @endif

                                     @php
                                          $finBadge = $order->financial_status_badge;
                                      @endphp
                                      <span class="inline-flex items-center text-[10px] font-medium border px-1.5 py-0.2 rounded w-fit mt-0.5 {{ $finBadge['class'] }}">
                                          {{ $finBadge['label'] }}
                                      </span>
                                 </div>
                            </td>
                            <!-- Fechas / Gar. -->
                            <td class="px-4 py-3">
                                <div class="flex flex-col gap-0.5 items-start">
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $order->created_at->format('d/m/y') }}</span>
                                    @php
                                        $daysInWorkshop = $order->created_at->startOfDay()->diffInDays(now()->startOfDay());
                                        $isDelayed = $daysInWorkshop >= 3 && !in_array($order->status, ['Entregado', 'Rechazado', 'Listo para Entrega']);
                                        $warranty = $order->warrantyStatus;
                                    @endphp
                                    @if($isDelayed)
                                        <span class="inline-flex items-center gap-1 text-[10px] text-rose-600 dark:text-rose-400 font-medium bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/60 px-1.5 py-0.5 rounded" title="Días en taller: {{ $daysInWorkshop }}">
                                            <x-ui.icon name="clock" class="w-3 h-3" />
                                            <span>+{{ $daysInWorkshop }}d</span>
                                        </span>
                                    @endif
                                    @if($warranty['status'] === 'active')
                                        <span class="text-[10px] font-medium text-emerald-600 dark:text-emerald-400 mt-0.5">Gar: {{ $warranty['days_remaining'] }}d</span>
                                    @elseif($warranty['status'] === 'expired')
                                        <span class="text-[10px] font-medium text-rose-600 dark:text-rose-400 mt-0.5">Gar: Vencida</span>
                                    @endif
                                </div>
                            </td>
                            <!-- Actions -->
                            @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button 
                                            wire:click="openWorkOrderDetails({{ $order->id }})" 
                                            class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-orange-600 hover:text-white dark:hover:bg-orange-600 hover:border-orange-600 border border-slate-200 dark:border-slate-700 transition-colors flex items-center justify-center cursor-pointer"
                                            title="Gestionar / Ver Detalles"
                                        >
                                            <x-ui.icon name="eye" class="w-4 h-4" />
                                        </button>

                                        @php
                                            $clientNameShort = explode(' ', $order->client->full_name)[0];
                                            $waMessage = "Hola {$clientNameShort}, puedes hacer el seguimiento de la reparación de tu {$order->brand_model} en tiempo real aquí: " . url('/seguimiento/' . $order->uuid);
                                        @endphp
                                        <a 
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client->phone) }}?text={{ urlencode($waMessage) }}"
                                            target="_blank" 
                                            class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-600 hover:text-white border border-emerald-200 dark:border-emerald-800/60 transition-colors flex items-center justify-center cursor-pointer"
                                            title="Notificar por WhatsApp"
                                        >
                                            <x-ui.icon name="whatsapp" class="w-4 h-4" />
                                        </a>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <x-ui.icon name="work-orders" class="w-10 h-10 text-slate-300 dark:text-slate-600 mx-auto mb-2" />
                                <p class="text-xs font-medium">No se encontraron órdenes de trabajo con los criterios aplicados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MOBILE CARDS -->
    <div class="md:hidden flex flex-col gap-3">
        @forelse($workOrders as $order)
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 flex flex-col shadow-xs">
                <!-- Header: Code & Status -->
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2.5 mb-2.5">
                    <span class="font-mono text-xs font-semibold text-orange-600 dark:text-orange-400 uppercase tracking-tight">
                        #{{ substr($order->uuid, 0, 8) }}
                    </span>
                    @php
                        $statusVariants = [
                            'Ingresado' => 'default',
                            'En Revisión' => 'info',
                            'Presupuestado' => 'warning',
                            'Aprobado' => 'brand',
                            'Esperando Repuestos' => 'warning',
                            'Rechazado' => 'danger',
                            'En Reparación' => 'info',
                            'Listo para Entrega' => 'success',
                            'Entregado' => 'purple',
                        ];
                        $variant = $statusVariants[$order->status] ?? 'default';
                    @endphp
                    @if(auth()->user()->hasRole(['admin', 'tecnico']))
                        <div class="relative inline-block" x-data="{ openMobileStatus: false }">
                            <button 
                                type="button" 
                                @click="openMobileStatus = !openMobileStatus" 
                                class="inline-flex items-center gap-1 cursor-pointer"
                            >
                                <x-ui.badge :variant="$variant" size="sm" :dot="true">
                                    <span>{{ $order->status }}</span>
                                    <x-ui.icon name="chevron-down" class="w-3 h-3 opacity-60 ml-0.5" />
                                </x-ui.badge>
                            </button>
                            <div 
                                x-show="openMobileStatus" 
                                @click.outside="openMobileStatus = false" 
                                x-transition 
                                class="absolute right-0 mt-1 z-50 w-48 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-lg p-1 space-y-0.5 max-h-56 overflow-y-auto"
                                style="display: none;"
                            >
                                @foreach([
                                    'Ingresado', 'En Revisión', 'Presupuestado', 'Aprobado',
                                    'Esperando Repuestos', 'En Reparación', 'Listo para Entrega',
                                    'Entregado', 'Rechazado'
                                ] as $st)
                                    <button 
                                        type="button" 
                                        wire:click="updateStatus({{ $order->id }}, '{{ $st }}')"
                                        @click="openMobileStatus = false"
                                        class="w-full text-left px-2.5 py-1.5 text-xs font-medium text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg flex items-center justify-between transition-colors"
                                    >
                                        <span>{{ $st }}</span>
                                        @if($order->status === $st)
                                            <x-ui.icon name="check" class="w-3.5 h-3.5 text-orange-600" />
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <x-ui.badge :variant="$variant" size="sm" :dot="true">
                            {{ $order->status }}
                        </x-ui.badge>
                    @endif
                </div>
                
                <!-- Client & Device -->
                <div class="space-y-1.5 mb-3">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Cliente</span>
                        <div class="flex items-center gap-2">
                            <span class="text-slate-900 dark:text-white font-medium text-xs">{{ $order->client->full_name }}</span>
                            <span class="text-[11px] text-slate-400">{{ $order->client->phone }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Equipo</span>
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="text-slate-900 dark:text-slate-100 font-medium text-xs">{{ $order->brand_model }}</span>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                {{ $order->device_type_label }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Cost & Warranty Row -->
                <div class="flex items-center justify-between bg-slate-50 dark:bg-slate-800/40 rounded-lg p-2.5 mb-3 border border-slate-200/60 dark:border-slate-800">
                    <div>
                        <span class="text-[10px] text-slate-400 block">Total M.O.</span>
                        <span class="text-slate-900 dark:text-white font-semibold text-xs">${{ number_format($order->labor_cost, 0, ',', '.') }}</span>
                    </div>
                    @php
                        $warranty = $order->warrantyStatus;
                    @endphp
                    <div class="text-right">
                        @if($warranty['status'] === 'active')
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60">
                                Vigente {{ $warranty['days_remaining'] }}d
                            </span>
                        @elseif($warranty['status'] === 'expired')
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800/60">
                                Vencida
                            </span>
                        @else
                            <span class="text-slate-400 text-[10px]">&mdash;</span>
                        @endif
                    </div>
                </div>

                <!-- Minimalist Quick Access Action Row -->
                @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                    <div class="grid grid-cols-4 gap-1.5 pt-2 border-t border-slate-100 dark:border-slate-800 mt-auto">
                        <!-- 1. Gestionar (Costos / General) -->
                        <button 
                            wire:click="openWorkOrderDetails({{ $order->id }}, 'details')" 
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-60 cursor-wait"
                            wire:target="openWorkOrderDetails({{ $order->id }}, 'details')"
                            type="button"
                            class="flex flex-col items-center justify-center gap-1 py-1.5 px-1 rounded-lg bg-orange-600 hover:bg-orange-700 text-white font-medium transition active:scale-95 shadow-xs"
                            title="Gestionar"
                        >
                            <x-ui.icon name="eye" class="w-3.5 h-3.5 shrink-0" />
                            <span class="text-[10px]">Gestionar</span>
                        </button>

                        <!-- 2. Bitácora de Avances -->
                        <button 
                            wire:click="openWorkOrderDetails({{ $order->id }}, 'logs')" 
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-60 cursor-wait"
                            wire:target="openWorkOrderDetails({{ $order->id }}, 'logs')"
                            type="button"
                            class="flex flex-col items-center justify-center gap-1 py-1.5 px-1 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition active:scale-95"
                            title="Bitácora"
                        >
                            <x-ui.icon name="message" class="w-3.5 h-3.5 shrink-0" />
                            <span class="text-[10px]">Bitácora</span>
                        </button>

                        <!-- 3. Pagos y Cobro -->
                        <button 
                            wire:click="openWorkOrderDetails({{ $order->id }}, 'payments')" 
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-60 cursor-wait"
                            wire:target="openWorkOrderDetails({{ $order->id }}, 'payments')"
                            type="button"
                            class="flex flex-col items-center justify-center gap-1 py-1.5 px-1 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition active:scale-95"
                            title="Pagos"
                        >
                            <x-ui.icon name="cash" class="w-3.5 h-3.5 shrink-0" />
                            <span class="text-[10px]">Pagos</span>
                        </button>

                        <!-- 4. WhatsApp al Cliente -->
                        @php
                            $clientNameShort = explode(' ', $order->client->full_name)[0];
                            $waMessage = "Hola {$clientNameShort}, puedes hacer el seguimiento de la reparación de tu {$order->brand_model} en tiempo real aquí: " . url('/seguimiento/' . $order->uuid);
                        @endphp
                        <a 
                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client->phone) }}?text={{ urlencode($waMessage) }}" 
                            target="_blank" 
                            class="flex flex-col items-center justify-center gap-1 py-1.5 px-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 hover:bg-emerald-100 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60 transition active:scale-95"
                            title="WhatsApp"
                        >
                            <x-ui.icon name="whatsapp" class="w-3.5 h-3.5 shrink-0" />
                            <span class="text-[10px]">WhatsApp</span>
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-8 text-center text-slate-400">
                <x-ui.icon name="work-orders" class="w-8 h-8 mx-auto mb-2 text-slate-300 dark:text-slate-600" />
                <p class="text-xs font-medium">No se encontraron órdenes</p>
            </div>
        @endforelse
    </div>

    <!-- UNIFIED WORK ORDER MANAGEMENT MODAL ("Todo en Uno") -->
    @if($isManaging && $loggingOrderId)
        @php
            $managingOrder = \App\Models\WorkOrder::with(['client', 'parts', 'images', 'logs.user', 'technician', 'receivedBy'])->find($loggingOrderId);
        @endphp
        
        @if($managingOrder)
        <div wire:key="managing-order-{{ $managingOrder->id }}">
            @php
                $partsCost = $managingOrder->parts_total;
                $shippingCost = (float)($managingOrder->shipping_cost ?? 0);
                $totalCost = $managingOrder->calculated_total;
                $balanceDue = $managingOrder->pending_balance;
            @endphp
            <div x-data="{ previewImage: null, zoomLevel: 1, mobileMenuOpen: false }" 
                 x-init="
                     document.body.style.overflow = 'hidden';
                     document.body.style.touchAction = 'none';
                     document.documentElement.style.overflow = 'hidden';
                     document.body.classList.add('modal-open');
                 " 
                 x-on:destroy="
                     document.body.style.overflow = '';
                     document.body.style.touchAction = '';
                     document.documentElement.style.overflow = '';
                     document.body.classList.remove('modal-open');
                 " 
                 @keydown.escape.window="if(!previewImage) $wire.closeManagingModal()"
                 class="fixed inset-0 bg-black/60 dark:bg-black/80 backdrop-blur-sm z-50 flex flex-col items-center justify-center p-0 md:p-6 overflow-hidden overscroll-none"
                 style="touch-action: none;">
                <div class="bg-white dark:bg-zinc-900 md:border border-zinc-200 dark:border-zinc-800 rounded-none md:rounded-xl w-full h-full md:h-[90vh] md:max-w-6xl overflow-hidden shadow-2xl animate-fade-in flex flex-col min-w-0 overscroll-contain relative"
                     style="touch-action: pan-y; -webkit-overflow-scrolling: touch;">
                    
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-800 px-4 py-3 md:px-6 md:py-4 shrink-0 bg-white dark:bg-zinc-900">
                        <div class="min-w-0 flex items-center gap-3">
                            <x-ui.badge variant="brand">OT #{{ substr($managingOrder->uuid, 0, 8) }}</x-ui.badge>
                            <div class="min-w-0">
                                <h3 class="text-sm md:text-base font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                    {{ $managingOrder->brand_model }}
                                </h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate">
                                    Cliente: <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $managingOrder->client->full_name }}</span>
                                    @if($managingOrder->technician)
                                        <span class="hidden sm:inline"> • Técnico: <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $managingOrder->technician->name }}</span></span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Desktop Print Buttons -->
                        <div class="hidden md:flex items-center gap-2 ml-auto mr-4">
                            @if($managingOrder->status === 'Entregado')
                                <button type="button" onclick="window.printContent('modal-thermal-delivery-template', 'qr-modal-canvas-thermal')" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-200 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                                    <x-ui.icon name="truck" class="w-3.5 h-3.5 text-zinc-500 dark:text-zinc-400" />
                                    Ticket Entrega
                                </button>
                            @else
                                @if(in_array($managingOrder->status, ['Presupuestado', 'Aprobado', 'Esperando Repuestos']))
                                    <button type="button" onclick="window.printContent('modal-quote-template', 'qr-modal-canvas')" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-200 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                                        <x-ui.icon name="quote" class="w-3.5 h-3.5 text-zinc-500 dark:text-zinc-400" />
                                        Cotización
                                    </button>
                                @endif
                                <button type="button" onclick="window.printContent('modal-receipt-template', 'qr-modal-canvas')" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-200 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                                    <x-ui.icon name="document" class="w-3.5 h-3.5 text-zinc-500 dark:text-zinc-400" />
                                    Recibo A4
                                </button>
                                <button type="button" onclick="window.printStickerLabel({{ $managingOrder->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-200 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                                    <x-ui.icon name="tag" class="w-3.5 h-3.5 text-zinc-500 dark:text-zinc-400" />
                                    Etiqueta
                                </button>
                            @endif
                        </div>

                        <!-- Mobile Overflow Menu -->
                        <div class="md:hidden relative ml-auto mr-2">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-1.5 text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"></path></svg>
                            </button>
                            <div x-show="mobileMenuOpen" @click.outside="mobileMenuOpen = false" x-transition class="absolute right-0 top-full mt-1 w-48 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl z-50 p-1.5 space-y-0.5" style="display:none;">
                                @if($managingOrder->status === 'Entregado')
                                    <button type="button" onclick="window.printContent('modal-thermal-delivery-template', 'qr-modal-canvas-thermal')" @click="mobileMenuOpen=false" class="w-full text-left px-3 py-2 text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition flex items-center gap-2">
                                        <x-ui.icon name="truck" class="w-3.5 h-3.5" />
                                        Ticket Entrega
                                    </button>
                                @else
                                    @if(in_array($managingOrder->status, ['Presupuestado', 'Aprobado', 'Esperando Repuestos']))
                                        <button type="button" onclick="window.printContent('modal-quote-template', 'qr-modal-canvas')" @click="mobileMenuOpen=false" class="w-full text-left px-3 py-2 text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition flex items-center gap-2">
                                            <x-ui.icon name="quote" class="w-3.5 h-3.5" />
                                            Cotización A4
                                        </button>
                                    @endif
                                    <button type="button" onclick="window.printContent('modal-receipt-template', 'qr-modal-canvas')" @click="mobileMenuOpen=false" class="w-full text-left px-3 py-2 text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition flex items-center gap-2">
                                        <x-ui.icon name="document" class="w-3.5 h-3.5" />
                                        Recibo A4
                                    </button>
                                    <button type="button" onclick="window.printStickerLabel({{ $managingOrder->id }})" @click="mobileMenuOpen=false" class="w-full text-left px-3 py-2 text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition flex items-center gap-2">
                                        <x-ui.icon name="tag" class="w-3.5 h-3.5" />
                                        Etiqueta Adhesiva
                                    </button>
                                @endif
                            </div>
                        </div>

                        <button wire:click="closeManagingModal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition cursor-pointer p-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg">
                            <x-ui.icon name="x" class="w-5 h-5" />
                        </button>
                    </div>

                    <!-- Mobile Compact Summary Bar -->
                    <div class="lg:hidden bg-zinc-50 dark:bg-zinc-900/60 border-b border-zinc-200 dark:border-zinc-800 px-4 py-2 shrink-0">
                        <div class="flex items-center justify-between gap-2">
                            @php
                                $statusVariantMap = [
                                    'Ingresado' => 'default',
                                    'En Revisión' => 'info',
                                    'Presupuestado' => 'warning',
                                    'Aprobado' => 'brand',
                                    'Esperando Repuestos' => 'warning',
                                    'Rechazado' => 'danger',
                                    'En Reparación' => 'info',
                                    'En Verificación' => 'purple',
                                    'Listo para Entrega' => 'success',
                                    'Entregado' => 'default',
                                    'Anulada' => 'danger',
                                ];
                                $mVariant = $statusVariantMap[$managingOrder->status] ?? 'default';
                            @endphp
                            <x-ui.badge :variant="$mVariant" :dot="true">
                                {{ $managingOrder->status }}
                            </x-ui.badge>
                            <div class="text-right">
                                @if($balanceDue > 0)
                                    <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">Pendiente: ${{ number_format($balanceDue, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Pagado</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Action Banner -->
                    @if(auth()->user()->hasRole(['admin', 'tecnico']))
                        @if($managingOrder->status === 'Aprobado')
                            <div class="lg:hidden bg-brand-50/50 dark:bg-brand-950/20 border-b border-brand-200 dark:border-brand-900/40 px-4 py-2.5 shrink-0 z-20">
                                <button wire:click="startRepair" type="button" class="w-full bg-brand-600 hover:bg-brand-500 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm transition text-xs flex items-center justify-center gap-2">
                                    <x-ui.icon name="tools" class="w-4 h-4" />
                                    Iniciar Reparación
                                </button>
                            </div>
                        @elseif($managingOrder->status === 'En Reparación')
                            <div class="lg:hidden bg-amber-50/50 dark:bg-amber-950/20 border-b border-amber-200 dark:border-amber-900/40 px-4 py-2.5 shrink-0 z-20">
                                <button wire:click="finishRepair" type="button" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm transition text-xs flex items-center justify-center gap-2">
                                    <x-ui.icon name="check" class="w-4 h-4" />
                                    Finalizar Reparación
                                </button>
                            </div>
                        @endif
                    @endif

                    <!-- Main Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 p-4 sm:p-5 lg:p-6 overflow-y-auto flex-1 theme-scrollbar min-w-0 w-full pb-24 md:pb-6 overscroll-contain" style="-webkit-overflow-scrolling: touch; touch-action: pan-y;">
                        
                        <!-- LEFT COLUMN: Summary & Financials (4 cols) -->
                        <div class="col-span-12 lg:col-span-4 space-y-4 min-w-0 w-full">
                            
                            <!-- Status Selector Card -->
                            <div class="bg-zinc-50/60 dark:bg-zinc-900/40 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-2.5">
                                <span class="text-[11px] font-semibold text-zinc-500 uppercase tracking-wider block">Estado de la OT</span>
                                
                                @if(auth()->user()->hasRole(['admin', 'tecnico']))
                                    @php
                                        $statuses = [
                                            'Ingresado' => ['label' => 'Ingresado', 'variant' => 'default'],
                                            'En Revisión' => ['label' => 'En Revisión', 'variant' => 'info'],
                                            'Presupuestado' => ['label' => 'Presupuestado', 'variant' => 'warning'],
                                            'Aprobado' => ['label' => 'Aprobado', 'variant' => 'brand'],
                                            'Esperando Repuestos' => ['label' => 'Esperando Repuestos', 'variant' => 'warning'],
                                            'Rechazado' => ['label' => 'Rechazado', 'variant' => 'danger'],
                                            'En Reparación' => ['label' => 'En Reparación', 'variant' => 'info'],
                                            'En Verificación' => ['label' => 'En Verificación', 'variant' => 'purple'],
                                            'Listo para Entrega' => ['label' => 'Listo para Entrega', 'variant' => 'success'],
                                            'Entregado' => ['label' => 'Entregado', 'variant' => 'default'],
                                        ];
                                        $currentStatus = $statuses[$managingOrder->status] ?? ['label' => $managingOrder->status, 'variant' => 'default'];
                                    @endphp
                                    <div class="relative w-full" x-data="{ open: false }">
                                        <!-- Custom Select Button Trigger -->
                                        <button 
                                            type="button" 
                                            @click="open = !open" 
                                            class="w-full flex items-center justify-between bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700/80 text-xs font-medium px-3 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 transition cursor-pointer select-none text-left shadow-sm"
                                        >
                                            <x-ui.badge :variant="$currentStatus['variant']" :dot="true">
                                                {{ $currentStatus['label'] }}
                                            </x-ui.badge>
                                            <svg class="h-4 w-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        
                                        <!-- Custom Dropdown Menu -->
                                        <div 
                                            x-show="open" 
                                            @click.outside="open = false"
                                            x-transition:enter="transition ease-out duration-150"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-100"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="absolute z-30 w-full mt-1.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl p-1.5 space-y-0.5 max-h-60 overflow-y-auto theme-scrollbar"
                                            style="display: none;"
                                        >
                                            @foreach($statuses as $value => $data)
                                                <button 
                                                    type="button"
                                                    wire:click="updateStatus({{ $managingOrder->id }}, '{{ $value }}')"
                                                    @click="open = false"
                                                    class="w-full flex items-center gap-2 px-2.5 py-1.5 text-left text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition cursor-pointer"
                                                >
                                                    <x-ui.badge :variant="$data['variant']" :dot="true">
                                                        {{ $data['label'] }}
                                                    </x-ui.badge>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    @php
                                        $variant = $statusVariantMap[$managingOrder->status] ?? 'default';
                                    @endphp
                                    <x-ui.badge :variant="$variant" :dot="true">
                                        {{ $managingOrder->status }}
                                    </x-ui.badge>
                                @endif
                            </div>

                            @if(auth()->user()->isAdmin() && $managingOrder->status !== 'Entregado')
                            <!-- Danger Zone: Anular / Eliminar -->
                            <div class="bg-rose-50/50 dark:bg-rose-950/10 p-3.5 rounded-xl border border-rose-200 dark:border-rose-900/30 space-y-2">
                                <span class="text-[11px] font-semibold text-rose-600 dark:text-rose-400 uppercase tracking-wider block border-b border-rose-200 dark:border-rose-900/20 pb-1.5 flex items-center gap-1.5">
                                    <x-ui.icon name="alert-triangle" class="w-3.5 h-3.5" />
                                    Zona de Peligro
                                </span>

                                {{-- Botón Anular --}}
                                @if($managingOrder->status !== 'Anulada')
                                <button
                                    type="button"
                                    wire:click="cancelWorkOrder({{ $managingOrder->id }})"
                                    wire:confirm="¿Anular esta orden de trabajo? Se cambiará su estado a 'Anulada'. Esta acción es reversible cambiando el estado nuevamente."
                                    class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-lg bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-700 dark:text-amber-400 font-medium text-xs transition cursor-pointer"
                                >
                                    <x-ui.icon name="x" class="w-3.5 h-3.5" />
                                    Anular Orden
                                </button>
                                @else
                                <div class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg bg-amber-500/10 border border-amber-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    <span class="text-xs text-amber-700 dark:text-amber-400 font-medium">Orden Anulada</span>
                                </div>
                                @endif

                                {{-- Botón Eliminar Permanentemente --}}
                                <button
                                    type="button"
                                    wire:click="deleteWorkOrder({{ $managingOrder->id }})"
                                    wire:confirm="⚠️ ELIMINAR PERMANENTEMENTE\n\nEsta acción es IRREVERSIBLE. Se eliminará la orden, sus fotos, logs y se devolverá el stock de repuestos. ¿Estás absolutamente seguro?"
                                    class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-400 font-medium text-xs transition cursor-pointer"
                                >
                                    <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                    Eliminar Permanentemente
                                </button>
                            </div>
                            @endif

                            <!-- Financial Summary Card -->
                            <div class="bg-zinc-50/60 dark:bg-zinc-900/40 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-3">
                                <span class="text-[11px] font-semibold text-zinc-500 uppercase tracking-wider block border-b border-zinc-200 dark:border-zinc-800 pb-1.5">Resumen de Caja</span>
                                
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between items-center">
                                        <span class="text-zinc-600 dark:text-zinc-400">Mano de Obra (Tu Utilidad)</span>
                                        <span class="font-semibold text-emerald-600 dark:text-emerald-400">${{ number_format($managingOrder->effective_labor_cost, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-zinc-600 dark:text-zinc-400">Repuestos (Costo Cliente)</span>
                                        <span class="font-medium text-zinc-900 dark:text-zinc-200">${{ number_format($partsCost, 0, ',', '.') }}</span>
                                    </div>
                                    @if($shippingCost > 0)
                                        <div class="flex justify-between items-center">
                                            <span class="text-zinc-600 dark:text-zinc-400">Envío Repuesto (Cliente)</span>
                                            <span class="font-medium text-zinc-900 dark:text-zinc-200">${{ number_format($shippingCost, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    @if($totalCost > 0)
                                        <div class="flex justify-between items-center border-t border-zinc-200 dark:border-zinc-800 pt-2 font-semibold">
                                            <span class="text-zinc-700 dark:text-zinc-300">Total a Cobrar Cliente</span>
                                            <span class="text-zinc-900 dark:text-zinc-100">${{ number_format($totalCost, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between items-center text-zinc-600 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                                        <span>Abonado</span>
                                        @if($managingOrder->down_payment > 0)
                                            <span class="font-semibold text-emerald-600 dark:text-emerald-400">${{ number_format($managingOrder->down_payment, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-zinc-400">Sin Abono</span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center pt-0.5">
                                        <span class="font-medium text-zinc-700 dark:text-zinc-300">Saldo Pendiente</span>
                                        @if($totalCost <= 0)
                                            <x-ui.badge variant="warning">Por Evaluar</x-ui.badge>
                                        @elseif($balanceDue > 0)
                                            <x-ui.badge variant="danger">${{ number_format($balanceDue, 0, ',', '.') }}</x-ui.badge>
                                        @else
                                            <x-ui.badge variant="success">$0 (Pagado)</x-ui.badge>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Device Quick Info Card -->
                            <div class="bg-zinc-50/60 dark:bg-zinc-900/40 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-3">
                                <span class="text-[11px] font-semibold text-zinc-500 uppercase tracking-wider block border-b border-zinc-200 dark:border-zinc-800 pb-1.5">Ficha del Dispositivo</span>
                                
                                <div class="space-y-2.5 text-xs">
                                    <div>
                                        <span class="text-[10px] text-zinc-400 uppercase tracking-wider block">Equipo</span>
                                        <div class="flex items-center gap-2 flex-wrap mt-0.5">
                                            <span class="text-zinc-900 dark:text-zinc-100 font-semibold">{{ $managingOrder->brand_model }}</span>
                                            <x-ui.badge variant="brand">{{ $managingOrder->device_type_label }}</x-ui.badge>
                                        </div>
                                    </div>
                                    
                                    @if($managingOrder->imei_serial)
                                        <div>
                                            <span class="text-[10px] text-zinc-400 uppercase tracking-wider block">IMEI / Serie</span>
                                            <span class="text-zinc-800 dark:text-zinc-200 font-mono font-medium">{{ $managingOrder->imei_serial }}</span>
                                        </div>
                                    @endif

                                    @if($managingOrder->unlock_password)
                                        <div>
                                            <span class="text-[10px] text-zinc-400 uppercase tracking-wider block">Clave de Acceso</span>
                                            <span class="text-amber-600 dark:text-amber-400 font-mono font-semibold">{{ $managingOrder->unlock_password }}</span>
                                        </div>
                                    @endif

                                    <div>
                                        <span class="text-[10px] text-zinc-400 uppercase tracking-wider block">Falla Reportada</span>
                                        <span class="text-zinc-700 dark:text-zinc-300 italic block mt-1 bg-white dark:bg-zinc-950 p-2.5 rounded-lg border border-zinc-200 dark:border-zinc-800 leading-relaxed text-xs">
                                            "{{ $managingOrder->reported_issue }}"
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Warranty Card -->
                            @php
                                $mWarranty = $managingOrder->warrantyStatus;
                            @endphp
                            @if($managingOrder->status === 'Entregado' || $mWarranty['status'] !== 'none')
                            <div class="rounded-xl border p-4 space-y-3
                                {{ $mWarranty['status'] === 'active'
                                    ? 'bg-emerald-50/50 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-800/40'
                                    : ($mWarranty['status'] === 'expired'
                                        ? 'bg-rose-50/50 dark:bg-rose-950/20 border-rose-200 dark:border-rose-800/40'
                                        : 'bg-zinc-50/60 dark:bg-zinc-900/40 border-zinc-200 dark:border-zinc-800') }}">

                                <div class="flex items-center justify-between border-b pb-2
                                    {{ $mWarranty['status'] === 'active' ? 'border-emerald-200 dark:border-emerald-800/40' : ($mWarranty['status'] === 'expired' ? 'border-rose-200 dark:border-rose-800/40' : 'border-zinc-200 dark:border-zinc-800') }}">
                                    <span class="text-[11px] font-semibold uppercase tracking-wider flex items-center gap-1.5
                                        {{ $mWarranty['status'] === 'active' ? 'text-emerald-700 dark:text-emerald-400' : ($mWarranty['status'] === 'expired' ? 'text-rose-700 dark:text-rose-400' : 'text-zinc-500') }}">
                                        <x-ui.icon name="shield" class="w-3.5 h-3.5" />
                                        Garantía de Servicio
                                    </span>
                                    @if($mWarranty['status'] === 'active')
                                        <x-ui.badge variant="success" :dot="true">Vigente</x-ui.badge>
                                    @elseif($mWarranty['status'] === 'expired')
                                        <x-ui.badge variant="danger" :dot="true">Vencida</x-ui.badge>
                                    @else
                                        <span class="text-[10px] font-medium text-zinc-400">Pendiente entrega</span>
                                    @endif
                                </div>

                                <div class="space-y-2 text-xs">
                                    @if($mWarranty['months'] > 0)
                                        <div class="flex justify-between">
                                            <span class="text-zinc-500">Meses de Garantía</span>
                                            <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $mWarranty['months'] }} mes(es)</span>
                                        </div>
                                    @endif

                                    @if($managingOrder->delivered_at)
                                        <div class="flex justify-between">
                                            <span class="text-zinc-500">Fecha de Entrega</span>
                                            <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $managingOrder->delivered_at->format('d/m/Y') }}</span>
                                        </div>
                                    @endif

                                    @if($mWarranty['expiry_date'])
                                        <div class="flex justify-between">
                                            <span class="text-zinc-500">Vencimiento</span>
                                            <span class="font-semibold {{ $mWarranty['status'] === 'active' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                                {{ $mWarranty['expiry_date']->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    @endif

                                    @if($mWarranty['status'] === 'active')
                                        <div class="mt-2 pt-2 border-t border-emerald-200 dark:border-emerald-800/30">
                                            @php
                                                $totalDays = $mWarranty['months'] * 30;
                                                $daysLeft  = $mWarranty['days_remaining'];
                                                $pct       = min(100, round(($daysLeft / max(1, $totalDays)) * 100));
                                            @endphp
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-emerald-700 dark:text-emerald-400 font-medium">Tiempo restante</span>
                                                <span class="font-semibold text-emerald-700 dark:text-emerald-300">{{ $daysLeft }} días</span>
                                            </div>
                                            <div class="w-full bg-emerald-100 dark:bg-emerald-950/40 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-emerald-500 h-1.5 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                                            </div>
                                        </div>
                                    @elseif($mWarranty['status'] === 'expired')
                                        <div class="mt-2 pt-2 border-t border-rose-200 dark:border-rose-800/30">
                                            <p class="text-[11px] text-rose-600 dark:text-rose-400 leading-relaxed">
                                                La garantía de esta reparación expiró el {{ $mWarranty['expiry_date']->format('d/m/Y') }}.
                                            </p>
                                        </div>
                                    @endif

                                    @if($managingOrder->status === 'Entregado' && $mWarranty['status'] === 'active')
                                        <button wire:click="reenterWarranty({{ $managingOrder->id }})" wire:confirm="¿Deseas reingresar este equipo al taller por concepto de garantía? El estado cambiará a Garantía y el equipo volverá a estar activo para los técnicos." class="mt-3 w-full py-2 px-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg font-medium text-xs transition flex justify-center items-center gap-2 cursor-pointer shadow-sm">
                                            <x-ui.icon name="history" class="w-3.5 h-3.5" />
                                            Reingresar por Garantía
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endif

                        </div>

                        <!-- RIGHT COLUMN: Interactive Tabs Section (8 cols) -->
                        <div class="col-span-12 lg:col-span-8 flex flex-col space-y-6 min-w-0 w-full">
                            
                            <!-- Desktop Navigation Tabs (hidden on mobile) -->
                            <div class="hidden md:flex border-b border-zinc-200 dark:border-zinc-800 gap-1 overflow-x-auto min-w-0 w-full no-scrollbar">
                                <button 
                                    wire:click="$set('activeTab', 'details')" 
                                    class="px-3.5 py-2.5 text-xs font-medium border-b-2 transition cursor-pointer flex items-center gap-1.5 shrink-0 {{ $activeTab === 'details' ? 'border-brand-500 text-brand-600 dark:text-brand-400 bg-brand-50/50 dark:bg-brand-950/20' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 hover:bg-zinc-100/60 dark:hover:bg-zinc-800/40' }}">
                                    <x-ui.icon name="tools" class="w-4 h-4" />
                                    Diagnóstico y Costos
                                </button>
                                <button 
                                    wire:click="$set('activeTab', 'logs')" 
                                    class="px-3.5 py-2.5 text-xs font-medium border-b-2 transition cursor-pointer flex items-center gap-1.5 shrink-0 {{ $activeTab === 'logs' ? 'border-brand-500 text-brand-600 dark:text-brand-400 bg-brand-50/50 dark:bg-brand-950/20' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 hover:bg-zinc-100/60 dark:hover:bg-zinc-800/40' }}">
                                    <x-ui.icon name="history" class="w-4 h-4" />
                                    Bitácora
                                </button>
                                <button 
                                    wire:click="$set('activeTab', 'share')" 
                                    class="px-3.5 py-2.5 text-xs font-medium border-b-2 transition cursor-pointer flex items-center gap-1.5 shrink-0 {{ $activeTab === 'share' ? 'border-brand-500 text-brand-600 dark:text-brand-400 bg-brand-50/50 dark:bg-brand-950/20' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 hover:bg-zinc-100/60 dark:hover:bg-zinc-800/40' }}">
                                    <x-ui.icon name="whatsapp" class="w-4 h-4" />
                                    Enlaces y WhatsApp
                                </button>
                                <button 
                                    wire:click="$set('activeTab', 'payments')" 
                                    class="px-3.5 py-2.5 text-xs font-medium border-b-2 transition cursor-pointer flex items-center gap-1.5 shrink-0 {{ $activeTab === 'payments' ? 'border-brand-500 text-brand-600 dark:text-brand-400 bg-brand-50/50 dark:bg-brand-950/20' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 hover:bg-zinc-100/60 dark:hover:bg-zinc-800/40' }}">
                                    <x-ui.icon name="caja" class="w-4 h-4" />
                                    Historial de Pagos
                                </button>
                            </div>

                            <!-- Tab Contents -->
                            <div class="flex-1 rounded-xl p-0 sm:p-5 lg:min-h-[350px]">
                                
                                <!-- 1. TAB: DETAILS & DIAGNOSTIC & BUDGETING -->
                                <div x-show="$wire.activeTab === 'details'" class="space-y-5">
                                    <div class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 pb-3">
                                        <h4 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Diagnóstico Técnico y Presupuesto</h4>
                                        <span class="text-xs text-zinc-500">Manejo de repuestos y cobros</span>
                                    </div>

                                    @if(auth()->user()->hasRole(['admin', 'tecnico']))
                                        @if($managingOrder && $managingOrder->status === 'Aprobado')
                                            <!-- Botón Iniciar Reparación -->
                                            <div class="bg-brand-50/50 dark:bg-brand-950/20 border border-brand-200 dark:border-brand-900/40 rounded-xl p-4 flex flex-col items-center text-center">
                                                <h5 class="text-brand-600 dark:text-brand-400 font-semibold text-sm mb-1">Presupuesto Aprobado</h5>
                                                <p class="text-zinc-500 dark:text-zinc-400 text-xs mb-3">El cliente ha aprobado el presupuesto. Puedes comenzar con los trabajos técnicos en el equipo.</p>
                                                <button wire:click="startRepair" type="button" class="bg-brand-600 hover:bg-brand-500 text-white font-medium py-2 px-5 rounded-lg shadow-sm transition text-xs flex items-center gap-1.5 cursor-pointer">
                                                    <x-ui.icon name="tools" class="w-4 h-4" />
                                                    Iniciar Reparación
                                                </button>
                                            </div>
                                        @elseif($managingOrder && $managingOrder->status === 'En Reparación')
                                            <!-- Botón Finalizar Reparación -->
                                            <div class="bg-amber-50/50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/40 rounded-xl p-4 flex flex-col items-center text-center">
                                                <h5 class="text-amber-700 dark:text-amber-400 font-semibold text-sm mb-1">Reparación en Proceso</h5>
                                                <p class="text-zinc-500 dark:text-zinc-400 text-xs mb-3">La reparación está en curso. Una vez termines todas las pruebas y labores técnicas, marca la reparación como finalizada.</p>
                                                <button wire:click="finishRepair" type="button" class="bg-amber-600 hover:bg-amber-500 text-white font-medium py-2 px-5 rounded-lg shadow-sm transition text-xs flex items-center gap-1.5 cursor-pointer">
                                                    <x-ui.icon name="check" class="w-4 h-4" />
                                                    Marcar Reparación como Finalizada
                                                </button>
                                            </div>
                                        @endif
                                        <form wire:submit.prevent="saveBudget" class="space-y-4">
                                            
                                            @php
                                                $isLocked = in_array($managingOrder->status, ['Presupuestado', 'Aprobado', 'En Reparación', 'En Verificación', 'Listo para Entrega', 'Entregado']) && !$forceEditBudget;
                                            @endphp
                                            
                                            <!-- PASO 1: Asignar Técnico -->
                                            @if(auth()->user()->isAdmin())
                                            @php
                                                $isTechLocked = in_array($managingOrder->status, ['Presupuestado', 'Aprobado', 'En Reparación', 'En Verificación', 'Listo para Entrega', 'Entregado']) && !$forceEditBudget;
                                            @endphp
                                            <div class="space-y-1.5 p-4 rounded-xl bg-zinc-50/60 dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800">
                                                <div class="flex justify-between items-center mb-1">
                                                    <label class="block text-xs font-semibold text-zinc-900 dark:text-zinc-200 uppercase tracking-wider flex items-center gap-1.5">
                                                        <span class="w-5 h-5 rounded-full bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 flex items-center justify-center text-[10px] font-bold">1</span>
                                                        Técnico Responsable
                                                    </label>
                                                    @if($isTechLocked)
                                                        <x-ui.badge variant="warning">Asignación Fijada ({{ $managingOrder->status }})</x-ui.badge>
                                                    @endif
                                                </div>
                                                <select wire:model.live="managingTechnicianId" wire:change="assignTechnician"
                                                    {{ $isTechLocked ? 'disabled' : '' }}
                                                    class="w-full rounded-lg py-2 px-3 bg-white dark:bg-zinc-950 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-brand-500 transition {{ $isTechLocked ? 'opacity-60 cursor-not-allowed' : 'cursor-pointer' }}">
                                                    <option value="">-- Sin Asignar --</option>
                                                    @foreach($technicians as $tech)
                                                        <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                                    @endforeach
                                                </select>

                                                @if($isTechLocked)
                                                    <p class="text-[11px] text-amber-600 dark:text-amber-400 mt-1">
                                                        No se puede cambiar el técnico asignado cuando la orden está en proceso o entregada.
                                                    </p>
                                                @else
                                                    <p class="text-[11px] text-zinc-500 mt-1">Se guarda automáticamente al seleccionar.</p>
                                                @endif
                                            </div>
                                            @endif

                                            <!-- PASO 2: Diagnostic Notes -->
                                            <div class="space-y-1.5 p-4 rounded-xl bg-zinc-50/60 dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800">
                                                <div class="flex justify-between items-center mb-1">
                                                    <label class="block text-xs font-semibold text-zinc-900 dark:text-zinc-200 uppercase tracking-wider flex items-center gap-1.5">
                                                        <span class="w-5 h-5 rounded-full bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 flex items-center justify-center text-[10px] font-bold">2</span>
                                                        Diagnóstico Técnico del Dispositivo *
                                                    </label>
                                                    @if($isLocked)
                                                        @if($managingOrder->status === 'Presupuestado' || auth()->user()->isAdmin())
                                                            <button type="button" wire:click="unlockBudgetEditing" class="text-[11px] text-amber-700 dark:text-amber-400 hover:underline font-medium px-2 py-0.5 border border-amber-500/30 rounded-md bg-amber-500/10 transition flex items-center gap-1 cursor-pointer">
                                                                <x-ui.icon name="edit" class="w-3 h-3" />
                                                                Desbloquear Edición {{ auth()->user()->isAdmin() && $managingOrder->status !== 'Presupuestado' ? '(Admin)' : '' }}
                                                            </button>
                                                        @else
                                                            <x-ui.badge variant="default">Diagnóstico Congelado</x-ui.badge>
                                                        @endif
                                                    @endif
                                                </div>
                                                <textarea 
                                                    wire:model="editingDiagnosticNotes" 
                                                    rows="3" 
                                                    {{ $isLocked ? 'disabled' : '' }}
                                                    class="w-full rounded-lg p-3 bg-white dark:bg-zinc-950 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-1 focus:ring-brand-500 transition text-xs leading-relaxed {{ $isLocked ? 'opacity-70 cursor-not-allowed' : '' }}"
                                                    placeholder="Describe en detalle la falla encontrada, repuestos requeridos y la solución técnica..."
                                                    required
                                                ></textarea>
                                                @error('editingDiagnosticNotes') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- PASO 3: Parts Search, Custom Part at Cost, and Shipping -->
                                            @if(!$isLocked)
                                            <div class="space-y-3 p-4 rounded-xl bg-zinc-50/60 dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800 relative">
                                                <label class="block text-xs font-semibold text-zinc-900 dark:text-zinc-200 uppercase tracking-wider flex items-center gap-1.5 mb-1">
                                                    <span class="w-5 h-5 rounded-full bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 flex items-center justify-center text-[10px] font-bold">3</span>
                                                    Repuestos (Costo Cliente) y Envío
                                                </label>
                                                <div class="relative">
                                                    <input 
                                                        type="text" 
                                                        wire:model.live.debounce.150ms="editingSearchPart" 
                                                        class="w-full rounded-lg py-2 pl-9 pr-3 bg-white dark:bg-zinc-950 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-1 focus:ring-brand-500 transition text-xs font-medium"
                                                        placeholder="Buscar repuesto en catálogo por nombre o categoría..."
                                                        autocomplete="off"
                                                    >
                                                    <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center text-zinc-400 pointer-events-none">
                                                        <x-ui.icon name="search" class="w-4 h-4" />
                                                    </span>

                                                    @if(strlen($editingSearchPart) > 0 && count($editingFoundParts) === 0)
                                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                                            <svg class="w-3.5 h-3.5 animate-spin text-zinc-400" fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if(count($editingFoundParts) > 0)
                                                    <div class="absolute z-30 w-full left-0 right-0 mt-1 overflow-hidden rounded-xl shadow-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                                                        <div class="px-3 py-1.5 flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900">
                                                            <span class="text-[10px] font-semibold text-zinc-500 uppercase">
                                                                {{ count($editingFoundParts) }} repuesto(s) encontrado(s)
                                                            </span>
                                                            <span class="text-[10px] text-zinc-400">Clic para añadir</span>
                                                        </div>
                                                        <ul class="max-h-48 overflow-y-auto theme-scrollbar divide-y divide-zinc-100 dark:divide-zinc-800">
                                                            @foreach($editingFoundParts as $part)
                                                                <li wire:click="addEditingPart({{ $part->id }})"
                                                                    class="flex items-center justify-between gap-3 p-2.5 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/60 transition group text-xs">
                                                                    <div class="flex items-center gap-2.5 min-w-0">
                                                                        <div class="w-7 h-7 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 text-zinc-500">
                                                                            <x-ui.icon name="box" class="w-3.5 h-3.5" />
                                                                        </div>
                                                                        <div class="min-w-0">
                                                                            <div class="font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ $part->name }}</div>
                                                                            <div class="text-[10px] text-zinc-500 mt-0.5">
                                                                                <span>{{ $part->category }}</span>
                                                                                <span>•</span>
                                                                                @if($part->stock <= 0)
                                                                                    <span class="text-amber-600 dark:text-amber-400 font-medium">A pedido (Sin Stock Físico)</span>
                                                                                @elseif($part->stock < 5)
                                                                                    <span class="text-amber-600 dark:text-amber-400 font-medium">Stock Bajo: {{ $part->stock }}</span>
                                                                                @else
                                                                                    <span>Stock: {{ $part->stock }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex items-center gap-2 shrink-0">
                                                                        <span class="font-mono font-semibold text-emerald-600 dark:text-emerald-400 text-xs">
                                                                            ${{ number_format($part->cost > 0 ? $part->cost : $part->sale_price, 0, ',', '.') }}
                                                                        </span>
                                                                        <span class="text-[10px] font-medium px-2 py-0.5 rounded bg-brand-50 dark:bg-brand-950/40 text-brand-600 dark:text-brand-400 border border-brand-200 dark:border-brand-800/40 opacity-0 group-hover:opacity-100 transition-opacity">
                                                                            + Añadir
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                <!-- Ingreso directo de Repuesto a Pedido -->
                                                <div class="p-3 bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-lg space-y-2">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-[11px] font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider flex items-center gap-1.5">
                                                            <x-ui.icon name="box" class="w-3.5 h-3.5 text-zinc-400" />
                                                            Repuesto a Pedido (A Precio Costo Cliente)
                                                        </span>
                                                        <span class="text-[10px] text-zinc-400">Sin stock físico</span>
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                                                        <div class="sm:col-span-6">
                                                            <input type="text" wire:model="editingCustomPartName" placeholder="Nombre del repuesto (Ej: Pantalla iPhone 13)..."
                                                                class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-700 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-1 focus:ring-brand-500">
                                                        </div>
                                                        <div class="sm:col-span-4">
                                                            <input type="number" wire:model="editingCustomPartCost" placeholder="Costo ($)..."
                                                                class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-700 rounded-lg p-2 text-xs font-semibold text-zinc-900 dark:text-zinc-100 text-right focus:outline-none focus:ring-1 focus:ring-brand-500">
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <button type="button" wire:click="addEditingCustomPart"
                                                                class="w-full h-full bg-zinc-900 dark:bg-zinc-100 hover:bg-zinc-800 dark:hover:bg-white text-white dark:text-zinc-900 font-medium py-2 rounded-lg text-xs transition cursor-pointer">
                                                                + Añadir
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Costo de Envío del Repuesto -->
                                                <div class="p-3 bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                                                    <div>
                                                        <span class="text-[11px] font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider block">Costo de Envío del Repuesto (Cliente)</span>
                                                        <span class="text-[10px] text-zinc-400">Se cobra al cliente junto al repuesto (no suma como utilidad)</span>
                                                    </div>
                                                    <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                                        <button type="button" wire:click="setEditingQuickShipping(10000)"
                                                            class="px-2.5 py-1 rounded-md text-[11px] font-medium border transition cursor-pointer {{ (float)$editingShippingCost == 10000 ? 'bg-brand-50 dark:bg-brand-950/40 border-brand-300 dark:border-brand-700 text-brand-700 dark:text-brand-300' : 'bg-zinc-100 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-300 hover:border-zinc-400' }}">
                                                            +$10.000
                                                        </button>
                                                        @if((float)$editingShippingCost > 0)
                                                            <button type="button" wire:click="setEditingQuickShipping(0)"
                                                                class="px-2 py-1 rounded-md text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-500 hover:text-rose-500 transition cursor-pointer">
                                                                $0
                                                            </button>
                                                        @endif
                                                        <input type="number" wire:model.live="editingShippingCost" min="0" step="500"
                                                            class="w-24 bg-zinc-50 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-700 rounded-lg py-1 px-2.5 text-xs font-semibold text-zinc-900 dark:text-zinc-100 text-right focus:outline-none focus:ring-1 focus:ring-brand-500">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Added Parts Grid/List -->
                                            @if(count($editingSelectedParts) > 0)
                                                <div class="bg-zinc-50/60 dark:bg-zinc-900/40 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-2">
                                                    <h5 class="text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider border-b border-zinc-200 dark:border-zinc-800 pb-1.5">Repuestos Asignados al Servicio (Costo Cliente)</h5>
                                                    <div class="space-y-1.5 max-h-40 overflow-y-auto pr-1 theme-scrollbar">
                                                        @foreach($editingSelectedParts as $index => $part)
                                                            <div class="flex justify-between items-center text-xs py-1.5 border-b border-zinc-100 dark:border-zinc-800/60 last:border-0 gap-2">
                                                                <div class="flex flex-col flex-1 min-w-0">
                                                                    <span class="text-zinc-900 dark:text-zinc-100 font-medium truncate">{{ $part['name'] }}</span>
                                                                    <span class="text-[10px] text-zinc-400">Cantidad: {{ $part['quantity'] }}</span>
                                                                </div>
                                                                <div class="flex items-center gap-2">
                                                                    @if(!$isLocked)
                                                                        <span class="text-[10px] text-zinc-400">Costo:</span>
                                                                        <input type="number" wire:model.live="editingSelectedParts.{{ $index }}.sale_price"
                                                                            class="w-24 bg-white dark:bg-zinc-950 border border-zinc-300 dark:border-zinc-700 rounded-md py-1 px-2 text-xs font-semibold text-zinc-900 dark:text-zinc-100 text-right focus:outline-none focus:ring-1 focus:ring-brand-500">
                                                                        <button type="button" wire:click="removeEditingPart({{ $index }})" class="text-zinc-400 hover:text-rose-500 transition cursor-pointer p-1 rounded-md hover:bg-rose-50 dark:hover:bg-rose-950/20">
                                                                            <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                                                        </button>
                                                                    @else
                                                                        <span class="text-zinc-900 dark:text-zinc-100 font-semibold">${{ number_format($part['sale_price'], 0, ',', '.') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- FOTOS DE INGRESO DEL EQUIPO (CARRUSEL INTERACTIVO) -->
                                            @if($managingOrder->images && $managingOrder->images->count() > 0)
                                                @php
                                                    $adminCheckInList = $managingOrder->images->map(fn($img) => [
                                                        'src' => asset('storage/' . $img->image_path),
                                                        'caption' => 'Foto de Ingreso del Equipo (Check-in)'
                                                    ])->values()->toArray();
                                                @endphp
                                                <div 
                                                    x-data="{ 
                                                        activeIndex: 0, 
                                                        photos: {{ json_encode($adminCheckInList) }},
                                                        next() { this.activeIndex = (this.activeIndex + 1) % this.photos.length },
                                                        prev() { this.activeIndex = (this.activeIndex - 1 + this.photos.length) % this.photos.length },
                                                        touchStartX: 0,
                                                        touchEndX: 0,
                                                        handleTouchStart(e) { this.touchStartX = e.changedTouches[0].screenX },
                                                        handleTouchEnd(e) { 
                                                            this.touchEndX = e.changedTouches[0].screenX;
                                                            if (this.touchStartX - this.touchEndX > 35) this.next();
                                                            if (this.touchEndX - this.touchStartX > 35) this.prev();
                                                        }
                                                    }" 
                                                    class="bg-zinc-50/60 dark:bg-zinc-900/40 p-3.5 sm:p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-3 min-w-0"
                                                >
                                                    <div class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 pb-2">
                                                        <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-200 uppercase tracking-wider flex items-center gap-1.5">
                                                            <x-ui.icon name="camera" class="w-3.5 h-3.5 text-zinc-500" />
                                                            Fotos de Ingreso (Check-in)
                                                        </span>
                                                        <x-ui.badge variant="default">
                                                            <span x-text="activeIndex + 1"></span> / <span x-text="photos.length"></span> fotos
                                                        </x-ui.badge>
                                                    </div>

                                                    <!-- Frame Principal Interactivo -->
                                                    <div 
                                                        @touchstart="handleTouchStart($event)" 
                                                        @touchend="handleTouchEnd($event)"
                                                        class="relative aspect-[4/3] sm:aspect-[16/9] w-full rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-800 bg-zinc-900 flex items-center justify-center select-none"
                                                    >
                                                        <template x-for="(photo, index) in photos" :key="index">
                                                            <div 
                                                                x-show="activeIndex === index"
                                                                x-transition:enter="transition ease-out duration-150"
                                                                x-transition:enter-start="opacity-0"
                                                                x-transition:enter-end="opacity-100"
                                                                class="absolute inset-0 w-full h-full flex items-center justify-center p-1"
                                                            >
                                                                <img 
                                                                    :src="photo.src" 
                                                                    @click="openGlobalLightbox(photos, activeIndex, 'Fotos de Ingreso (Check-in)')"
                                                                    class="max-w-full max-h-full object-contain cursor-pointer rounded"
                                                                    alt="Foto de ingreso"
                                                                />
                                                            </div>
                                                        </template>

                                                        <!-- Botones de Navegación -->
                                                        <button 
                                                            x-show="photos.length > 1"
                                                            @click="prev()" 
                                                            type="button" 
                                                            class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/60 hover:bg-black/80 text-white font-medium flex items-center justify-center transition shadow z-10 text-sm cursor-pointer"
                                                            aria-label="Anterior"
                                                        >
                                                            ‹
                                                        </button>
                                                        <button 
                                                            x-show="photos.length > 1"
                                                            @click="next()" 
                                                            type="button" 
                                                            class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/60 hover:bg-black/80 text-white font-medium flex items-center justify-center transition shadow z-10 text-sm cursor-pointer"
                                                            aria-label="Siguiente"
                                                        >
                                                            ›
                                                        </button>

                                                        <!-- Botón Ampliar -->
                                                        <button 
                                                            type="button"
                                                            @click="openGlobalLightbox(photos, activeIndex, 'Fotos de Ingreso (Check-in)')"
                                                            class="absolute bottom-2 right-2 px-2.5 py-1 rounded-md text-[10px] font-medium bg-black/70 hover:bg-black/90 text-white transition flex items-center gap-1 backdrop-blur-sm cursor-pointer"
                                                        >
                                                            <x-ui.icon name="search" class="w-3 h-3" />
                                                            Ampliar
                                                        </button>
                                                    </div>

                                                    <!-- Tira de Miniaturas -->
                                                    <div class="flex items-center gap-2 overflow-x-auto py-1 px-0.5 theme-scrollbar">
                                                        <template x-for="(photo, index) in photos" :key="index">
                                                            <button 
                                                                type="button"
                                                                @click="activeIndex = index; openGlobalLightbox(photos, index, 'Fotos de Ingreso (Check-in)')"
                                                                :class="activeIndex === index ? 'border-brand-500 ring-2 ring-brand-500/30 opacity-100' : 'border-zinc-200 dark:border-zinc-800 opacity-60 hover:opacity-100'"
                                                                class="relative w-14 h-14 shrink-0 rounded-lg overflow-hidden border bg-zinc-100 dark:bg-zinc-800 transition cursor-pointer group"
                                                            >
                                                                <img :src="photo.src" class="w-full h-full object-cover" />
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- PASO 3.5: Catálogo y Selección de Servicios -->
                                            @if(!$isLocked)
                                            <div class="space-y-2 p-4 rounded-xl bg-zinc-50/60 dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800 relative">
                                                <label class="block text-xs font-semibold text-zinc-900 dark:text-zinc-200 uppercase tracking-wider flex items-center gap-1.5 mb-1">
                                                    <span class="w-5 h-5 rounded-full bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 flex items-center justify-center text-[10px] font-bold">3.5</span>
                                                    Añadir Servicios del Catálogo (Mano de Obra)
                                                </label>
                                                
                                                <!-- Buscador Predictivo de Servicios -->
                                                <div class="relative">
                                                    <input 
                                                        type="text" 
                                                        wire:model.live.debounce.250ms="editingSearchService" 
                                                        placeholder="Buscar servicio en catálogo (ej: Mantenimiento, Pantalla, Reballing)..." 
                                                        class="w-full rounded-lg py-2 pl-9 pr-3 bg-white dark:bg-zinc-950 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-1 focus:ring-brand-500 transition text-xs"
                                                    >
                                                    <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center text-zinc-400 pointer-events-none">
                                                        <x-ui.icon name="search" class="w-4 h-4" />
                                                    </span>
                                                    
                                                    <!-- Desplegable Predictivo -->
                                                    @if(count($editingFoundServices) > 0)
                                                        <div class="absolute z-30 w-full left-0 right-0 mt-1 overflow-hidden rounded-xl shadow-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                                                            <div class="px-3 py-1.5 flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 text-[10px] font-semibold text-zinc-500 uppercase">
                                                                <span>{{ count($editingFoundServices) }} servicio(s) encontrado(s)</span>
                                                                <span class="text-zinc-400">Clic para añadir</span>
                                                            </div>
                                                            <ul class="max-h-48 overflow-y-auto theme-scrollbar divide-y divide-zinc-100 dark:divide-zinc-800">
                                                                @foreach($editingFoundServices as $srv)
                                                                    <li wire:click="addEditingService({{ $srv->id }})" class="p-2.5 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/60 transition flex items-center justify-between group text-xs">
                                                                        <div>
                                                                            <span class="font-medium text-zinc-900 dark:text-zinc-100 block">{{ $srv->name }}</span>
                                                                            <span class="text-[10px] text-zinc-400">{{ $srv->category_label }}</span>
                                                                        </div>
                                                                        <div class="flex items-center gap-2">
                                                                            <span class="font-mono font-semibold text-emerald-600 dark:text-emerald-400 text-xs">${{ number_format($srv->default_price, 0, ',', '.') }}</span>
                                                                            <span class="text-[10px] font-medium px-2 py-0.5 rounded bg-brand-50 dark:bg-brand-950/40 text-brand-600 dark:text-brand-400 border border-brand-200 dark:border-brand-800/40 opacity-0 group-hover:opacity-100 transition">+ Añadir</span>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Opción de Inserción Manual -->
                                                <div x-data="{ showCustom: false }" class="mt-2">
                                                    <button type="button" @click="showCustom = !showCustom" class="text-[11px] text-brand-600 dark:text-brand-400 hover:underline font-medium flex items-center gap-1 cursor-pointer">
                                                        <span>+ ¿Servicio personalizado no catalogado?</span>
                                                    </button>
                                                    <div x-show="showCustom" x-cloak class="mt-2 grid grid-cols-1 sm:grid-cols-12 gap-2 bg-white dark:bg-zinc-950 p-3 rounded-lg border border-zinc-200 dark:border-zinc-800">
                                                        <div class="sm:col-span-6">
                                                            <input type="text" wire:model="customServiceName" placeholder="Nombre del servicio..." class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-700 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-1 focus:ring-brand-500">
                                                        </div>
                                                        <div class="sm:col-span-4">
                                                            <input type="number" wire:model="customServicePrice" placeholder="Precio ($)" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-700 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 font-semibold text-right focus:outline-none focus:ring-1 focus:ring-brand-500">
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <button type="button" wire:click="addCustomService" class="w-full bg-zinc-900 dark:bg-zinc-100 hover:bg-zinc-800 dark:hover:bg-white text-white dark:text-zinc-900 font-medium py-2 rounded-lg text-xs transition cursor-pointer">
                                                                + Añadir
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Servicios Cargados a la Orden -->
                                                @if(count($editingSelectedServices) > 0)
                                                    <div class="mt-2.5 bg-white dark:bg-zinc-950 p-3 rounded-lg border border-zinc-200 dark:border-zinc-800 space-y-2">
                                                        <h5 class="text-[10px] font-semibold text-zinc-500 uppercase tracking-wider border-b border-zinc-100 dark:border-zinc-800 pb-1">Servicios de Mano de Obra Cargados</h5>
                                                        <div class="space-y-1.5 max-h-40 overflow-y-auto pr-1 theme-scrollbar">
                                                            @foreach($editingSelectedServices as $index => $srv)
                                                                <div class="flex items-center justify-between text-xs py-1 border-b border-zinc-100 dark:border-zinc-800/60 last:border-0 gap-3">
                                                                    <span class="text-zinc-800 dark:text-zinc-200 font-medium flex-1 truncate">{{ $srv['name'] }}</span>
                                                                    <div class="flex items-center gap-2">
                                                                        <span class="text-[10px] text-zinc-400">Precio:</span>
                                                                        <input 
                                                                            type="number" 
                                                                            wire:model.live="editingSelectedServices.{{ $index }}.price" 
                                                                            wire:change="recalculateLaborCost"
                                                                            class="w-24 bg-zinc-50 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-700 rounded-md py-1 px-2 text-xs font-semibold text-zinc-900 dark:text-zinc-100 text-right focus:ring-1 focus:ring-brand-500 focus:outline-none"
                                                                        >
                                                                        <button type="button" wire:click="removeEditingService({{ $index }})" class="text-zinc-400 hover:text-rose-500 p-1 rounded hover:bg-rose-50 dark:hover:bg-rose-950/20 cursor-pointer">
                                                                            <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            @endif

                                            <!-- PASO 4: Costs Editor Grid -->
                                            <div class="p-4 rounded-xl bg-zinc-50/60 dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800 space-y-3">
                                                <label class="block text-xs font-semibold text-zinc-900 dark:text-zinc-200 uppercase tracking-wider flex items-center gap-1.5">
                                                    <span class="w-5 h-5 rounded-full bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 flex items-center justify-center text-[10px] font-bold">4</span>
                                                    Mano de Obra (Tu Utilidad) y Presupuesto Final
                                                </label>

                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                                                    <div class="space-y-1">
                                                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Mano de Obra / Utilidad ($) *</label>
                                                        <input 
                                                            type="number" 
                                                            wire:model.live="editingLaborCost" 
                                                            {{ $isLocked ? 'disabled' : '' }}
                                                            class="w-full rounded-lg p-2.5 bg-white dark:bg-zinc-950 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-1 focus:ring-brand-500 transition text-xs font-semibold {{ $isLocked ? 'opacity-70 cursor-not-allowed' : '' }}"
                                                            required
                                                        >
                                                        @error('editingLaborCost') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="space-y-1">
                                                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Fecha Est. Entrega</label>
                                                        <input 
                                                            type="date" 
                                                            wire:model="editingEstimatedDelivery" 
                                                            {{ $isLocked ? 'disabled' : '' }}
                                                            class="w-full rounded-lg p-2.5 bg-white dark:bg-zinc-950 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-1 focus:ring-brand-500 transition text-xs font-medium {{ $isLocked ? 'opacity-70 cursor-not-allowed' : '' }}"
                                                        >
                                                        @error('editingEstimatedDelivery') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                                    </div>

                                                    <!-- Instant Estimated Total display -->
                                                    @php
                                                        $tempPartsCost = collect($editingSelectedParts)->sum(function($p) {
                                                            return (float)($p['sale_price'] ?? 0) * (int)($p['quantity'] ?? 1);
                                                        });
                                                        $tempShippingCost = (float)($editingShippingCost ?? 0);
                                                        $tempTotal = (float)$editingLaborCost + $tempPartsCost + $tempShippingCost;
                                                    @endphp
                                                    <div class="rounded-lg p-2.5 bg-zinc-100 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 flex flex-col justify-between h-[58px]">
                                                        <span class="text-[10px] font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Total a Cobrar Cliente</span>
                                                        <span class="text-base font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($tempTotal, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(!$isLocked)
                                            <div class="flex justify-end pt-3 border-t border-zinc-200 dark:border-zinc-800">
                                                <button type="submit" 
                                                    class="py-2.5 px-5 rounded-lg text-white font-medium text-xs shadow-sm transition cursor-pointer flex items-center gap-2 bg-brand-600 hover:bg-brand-500">
                                                    <x-ui.icon name="check" class="w-4 h-4" />
                                                    Guardar Diagnóstico y Presupuesto
                                                </button>
                                            </div>
                                            @endif
                                            </form>
                                            
                                        </div>
                                    @else
                                        <!-- Readonly technical view for receptionist -->
                                        <div class="space-y-4 text-xs">
                                            <div>
                                                <span class="text-zinc-500 font-semibold uppercase tracking-wider block">Diagnóstico Técnico</span>
                                                <p class="text-zinc-700 dark:text-zinc-300 mt-1 leading-relaxed whitespace-pre-line bg-zinc-50 dark:bg-zinc-900/60 p-3 rounded-lg border border-zinc-200 dark:border-zinc-800">
                                                    {{ $editingDiagnosticNotes ?: 'No se ha registrado diagnóstico técnico aún.' }}
                                                </p>
                                            </div>

                                            <div>
                                                <span class="text-zinc-500 font-semibold uppercase tracking-wider block mb-2">Repuestos Asignados</span>
                                                @if(count($managingOrder->parts) > 0)
                                                    <div class="bg-zinc-50 dark:bg-zinc-900/40 rounded-lg border border-zinc-200 dark:border-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-800 p-2.5">
                                                        @foreach($managingOrder->parts as $part)
                                                            <div class="flex justify-between py-1.5 text-xs px-2">
                                                                <span class="text-zinc-700 dark:text-zinc-300 font-medium">{{ $part->name }} (x{{ $part->pivot->quantity }})</span>
                                                                <span class="text-zinc-900 dark:text-zinc-100 font-semibold">${{ number_format($part->pivot->price_at_time, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-zinc-400 italic">No hay repuestos cargados a esta orden.</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 2. TAB: LOGS / BITACORA -->
                                <div x-show="$wire.activeTab === 'logs'" class="space-y-5">
                                    <div class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 pb-3">
                                        <h4 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Bitácora y Registro de Avances</h4>
                                        <span class="text-xs text-zinc-500">Hitos del estado del servicio</span>
                                    </div>

                                    @if(in_array($managingOrder->status, ['Listo para Entrega', 'Entregado', 'Anulada']))
                                         <!-- Bitácora congelada para órdenes finalizadas -->
                                         <div class="bg-zinc-50 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800 p-4 rounded-xl text-center space-y-1.5">
                                             <div class="flex items-center justify-center gap-1.5 text-amber-600 dark:text-amber-400 font-medium text-xs">
                                                 <x-ui.icon name="lock" class="w-4 h-4" />
                                                 <span>Bitácora Congelada ({{ $managingOrder->status }})</span>
                                             </div>
                                             <p class="text-xs text-zinc-500 dark:text-zinc-400 max-w-md mx-auto leading-relaxed">
                                                 El equipo se encuentra en estado <strong class="text-zinc-900 dark:text-zinc-200 font-semibold">{{ $managingOrder->status }}</strong>. La labor técnica ha finalizado y la bitácora ha sido bloqueada para evitar nuevos ingresos.
                                             </p>
                                         </div>
                                     @else
                                         {{-- ===== QUICK PHOTO FAB + COMPACT FORM ===== --}}
                                         <div x-data="{ formExpanded: false, quickUploading: false }" class="space-y-3">
                                             
                                             {{-- Quick Photo Row --}}
                                             <div class="flex gap-2">
                                                 {{-- Quick Photo Button (Mobile) --}}
                                                 <label class="md:hidden flex-1 flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-medium py-2.5 px-4 rounded-lg cursor-pointer transition active:scale-95 shadow-sm text-xs"
                                                     x-bind:class="quickUploading ? 'opacity-60 pointer-events-none' : ''"
                                                 >
                                                     <template x-if="!quickUploading">
                                                         <span class="flex items-center gap-2">
                                                             <x-ui.icon name="camera" class="w-4 h-4" />
                                                             Foto Rápida
                                                         </span>
                                                     </template>
                                                     <template x-if="quickUploading">
                                                         <span class="flex items-center gap-2">
                                                             <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                             Subiendo...
                                                         </span>
                                                     </template>
                                                     <input type="file" multiple accept="image/*" capture="environment" class="hidden"
                                                         @change="
                                                             quickUploading = true;
                                                             compressAndUploadMultiplePhotos($event, 'quickPhotos', $wire);
                                                             const checkInterval = setInterval(() => {
                                                                 if ($wire.quickPhotos && $wire.quickPhotos.length > 0) {
                                                                     clearInterval(checkInterval);
                                                                     $wire.quickPhotoLog().then(() => { quickUploading = false; });
                                                                 }
                                                             }, 500);
                                                             setTimeout(() => { clearInterval(checkInterval); quickUploading = false; }, 30000);
                                                         "
                                                     >
                                                 </label>
                                                 
                                                 {{-- Desktop Quick Photo --}}
                                                 <label class="hidden md:flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-medium py-2 px-3.5 rounded-lg cursor-pointer transition shadow-sm text-xs"
                                                     x-bind:class="quickUploading ? 'opacity-60 pointer-events-none' : ''"
                                                 >
                                                     <x-ui.icon name="camera" class="w-4 h-4" />
                                                     Foto Rápida
                                                     <input type="file" multiple accept="image/*" class="hidden"
                                                         @change="
                                                             quickUploading = true;
                                                             compressAndUploadMultiplePhotos($event, 'quickPhotos', $wire);
                                                             const checkInterval2 = setInterval(() => {
                                                                 if ($wire.quickPhotos && $wire.quickPhotos.length > 0) {
                                                                     clearInterval(checkInterval2);
                                                                     $wire.quickPhotoLog().then(() => { quickUploading = false; });
                                                                 }
                                                             }, 500);
                                                             setTimeout(() => { clearInterval(checkInterval2); quickUploading = false; }, 30000);
                                                         "
                                                     >
                                                 </label>

                                                 {{-- Toggle full form button --}}
                                                 <button type="button" 
                                                     @click="formExpanded = !formExpanded"
                                                     class="flex items-center justify-center gap-1.5 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-200 font-medium py-2 px-3.5 rounded-lg transition border border-zinc-200 dark:border-zinc-700 text-xs cursor-pointer"
                                                     :class="formExpanded ? 'bg-zinc-200 dark:bg-zinc-700' : ''"
                                                 >
                                                     <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                                                     <span x-text="formExpanded ? 'Cerrar Formulario' : 'Avance Detallado'"></span>
                                                 </button>
                                             </div>

                                             {{-- Quick upload loading indicator --}}
                                             <div wire:loading wire:target="quickPhotos" class="text-xs text-brand-600 dark:text-brand-400 font-medium flex items-center gap-1.5 bg-brand-50 dark:bg-brand-950/30 p-2 rounded-lg border border-brand-200 dark:border-brand-900/40">
                                                 <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                 Procesando foto(s)...
                                             </div>
                                             <div wire:loading wire:target="quickPhotoLog" class="text-xs text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-950/30 p-2 rounded-lg border border-emerald-200 dark:border-emerald-800/40">
                                                 <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                 Guardando en bitácora...
                                             </div>

                                             {{-- EXPANDABLE DETAILED FORM --}}
                                             <div x-show="formExpanded" x-collapse x-cloak>
                                                 <form wire:submit.prevent="saveManualLog" class="bg-zinc-50/60 dark:bg-zinc-900/40 p-3.5 md:p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-3">
                                                     <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider block border-b border-zinc-200 dark:border-zinc-800 pb-1.5 flex items-center gap-1.5">
                                                         <x-ui.icon name="edit" class="w-3.5 h-3.5 text-zinc-500" />
                                                         <span>Registrar Nuevo Hito en la Bitácora</span>
                                                     </span>
                                                     
                                                     {{-- Quick Title Chips --}}
                                                     <div class="space-y-1.5">
                                                         <label class="block text-[10px] text-zinc-500 font-semibold uppercase tracking-wider">Título del Hito *</label>
                                                         <div class="flex flex-wrap gap-1.5 mb-1.5" x-data>
                                                             @foreach(['Avance Técnico', 'Cambio de Pieza', 'Prueba Realizada', 'Diagnóstico', 'Nota Interna'] as $chip)
                                                                 <button 
                                                                     type="button" 
                                                                     wire:click="$set('newLogTitle', '{{ $chip }}')"
                                                                     class="px-2.5 py-1 rounded-md text-[11px] font-medium border transition cursor-pointer {{ $newLogTitle === $chip ? 'bg-brand-50 dark:bg-brand-950/40 border-brand-300 dark:border-brand-700 text-brand-700 dark:text-brand-300' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 hover:border-zinc-300' }}"
                                                                 >{{ $chip }}</button>
                                                             @endforeach
                                                         </div>
                                                         <input 
                                                             type="text" 
                                                             wire:model="newLogTitle" 
                                                             class="w-full bg-white dark:bg-zinc-950 border border-zinc-300 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-1 focus:ring-brand-500 text-xs font-medium"
                                                             placeholder="O escribe un título personalizado..."
                                                             required
                                                         >
                                                     </div>
                                                     
                                                     {{-- Notes --}}
                                                     <div class="space-y-1.5">
                                                         <label class="block text-[10px] text-zinc-500 font-semibold uppercase tracking-wider">Detalle / Notas (Opcional)</label>
                                                         <textarea 
                                                             wire:model="newLogNotes" 
                                                             rows="2" 
                                                             class="w-full bg-white dark:bg-zinc-950 border border-zinc-300 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-1 focus:ring-brand-500 text-xs leading-relaxed" 
                                                             placeholder="Describe las labores realizadas..."
                                                         ></textarea>
                                                         @error('newLogNotes') <span class="text-rose-500 text-xs block font-medium mt-1">{{ $message }}</span> @enderror
                                                     </div>

                                                     {{-- Photo + Submit Row --}}
                                                     <div class="flex items-center gap-2 flex-wrap">
                                                         <label class="flex items-center gap-1.5 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-200 font-medium py-1.5 px-3 rounded-lg cursor-pointer transition border border-zinc-200 dark:border-zinc-700 text-xs shrink-0">
                                                             <x-ui.icon name="camera" class="w-3.5 h-3.5 text-zinc-500" />
                                                             Fotos
                                                             <input type="file" multiple @change="compressAndUploadMultiplePhotos($event, 'newLogPhotos', $wire)" accept="image/*" class="hidden">
                                                         </label>

                                                         {{-- Inline photo thumbnails --}}
                                                         @if(count($newLogPhotos) > 0)
                                                             <div class="flex items-center gap-1.5 flex-wrap flex-1 min-w-0">
                                                                 @foreach($newLogPhotos as $idx => $photo)
                                                                     <div class="relative group w-9 h-9 rounded-md overflow-hidden border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-900 shrink-0">
                                                                         <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                                                         <button type="button" 
                                                                                 wire:click="removeNewLogPhoto({{ $idx }})" 
                                                                                 class="absolute inset-0 bg-rose-600/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                                                                 title="Eliminar">
                                                                             <x-ui.icon name="x" class="w-3 h-3" />
                                                                         </button>
                                                                     </div>
                                                                 @endforeach
                                                                 <button type="button" wire:click="$set('newLogPhotos', [])" class="text-rose-500 hover:text-rose-600 text-[10px] font-medium shrink-0 px-1">
                                                                     ✕ Quitar
                                                                 </button>
                                                             </div>
                                                         @elseif($newLogPhoto)
                                                             <div class="relative group w-9 h-9 rounded-md overflow-hidden border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-900 shrink-0">
                                                                 <img src="{{ $newLogPhoto->temporaryUrl() }}" class="w-full h-full object-cover">
                                                                 <button type="button" 
                                                                         wire:click="$set('newLogPhoto', null)" 
                                                                         class="absolute inset-0 bg-rose-600/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                                                         title="Quitar">
                                                                     <x-ui.icon name="x" class="w-3 h-3" />
                                                                 </button>
                                                             </div>
                                                         @endif

                                                         {{-- Loading indicator inline --}}
                                                         <div wire:loading wire:target="newLogPhotos, newLogPhoto" class="flex items-center gap-1 text-[10px] text-brand-600 dark:text-brand-400 font-medium shrink-0">
                                                             <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                             Cargando...
                                                         </div>

                                                         {{-- Submit button --}}
                                                         <button type="submit" wire:loading.attr="disabled" wire:target="newLogPhotos, newLogPhoto, saveManualLog" class="ml-auto py-1.5 px-4 rounded-lg bg-brand-600 hover:bg-brand-500 text-white font-medium text-xs shadow-sm transition cursor-pointer flex items-center gap-1.5 shrink-0 disabled:opacity-50 disabled:cursor-not-allowed">
                                                             <x-ui.icon name="check" class="w-3.5 h-3.5" wire:loading.remove wire:target="saveManualLog" />
                                                             <svg wire:loading wire:target="saveManualLog" class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                             Registrar
                                                         </button>
                                                     </div>

                                                     @error('newLogPhotos.*') <span class="text-rose-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                                     @error('newLogPhoto') <span class="text-rose-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                                 </form>
                                             </div>
                                         </div>
                                     @endif
 
                                    <!-- Vertical Timeline -->
                                    <div class="space-y-4" 
                                        x-data
                                        x-on:log-saved.window="
                                            $nextTick(() => {
                                                const target = document.getElementById('bitacora-timeline-latest');
                                                if (target) {
                                                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                                    target.classList.add('ring-1', 'ring-brand-500', 'bg-brand-50/50', 'dark:bg-brand-950/20', 'rounded-lg', 'p-2');
                                                    setTimeout(() => { target.classList.remove('ring-1', 'ring-brand-500', 'bg-brand-50/50', 'dark:bg-brand-950/20', 'rounded-lg', 'p-2'); }, 3000);
                                                }
                                            });
                                        "
                                    >
                                        <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider block border-b border-zinc-200 dark:border-zinc-800 pb-1.5">Historial de Eventos</span>
                                        
                                        @if(count($managingOrder->logs) > 0)
                                            @php
                                                $adminAllBitacoraPhotos = [];
                                                $adminBIndexMap = [];
                                                $adminGCount = 0;
                                                $sortedLogsList = $managingOrder->logs->sortByDesc('created_at');
                                                foreach($sortedLogsList as $logItem) {
                                                    if(count($logItem->images) > 0) {
                                                        foreach($logItem->images as $lIdx => $imgPath) {
                                                            $adminAllBitacoraPhotos[] = [
                                                                'src' => asset('storage/' . $imgPath),
                                                                'title' => 'Avance: ' . $logItem->title,
                                                                'description' => $logItem->notes ?? ''
                                                            ];
                                                            $adminBIndexMap[$logItem->id . '_' . $lIdx] = $adminGCount++;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <div class="relative pl-4 border-l border-zinc-200 dark:border-zinc-800 space-y-4">
                                                @foreach($sortedLogsList as $log)
                                                    <div class="relative transition-all duration-300" @if($loop->first) id="bitacora-timeline-latest" @endif>
                                                        <!-- Bullet node point -->
                                                        <span class="absolute -left-[21px] mt-1.5 bg-white dark:bg-zinc-900 border-2 border-brand-500 w-2.5 h-2.5 rounded-full"></span>
                                                        
                                                        <div class="space-y-1">
                                                            <div class="flex items-center gap-2 flex-wrap">
                                                                <span class="font-medium text-zinc-900 dark:text-zinc-100 text-xs">{{ $log->title }}</span>
                                                                <x-ui.badge variant="default">{{ $log->status }}</x-ui.badge>
                                                                <span class="text-[10px] text-zinc-400">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                                                            </div>
                                                            @if($log->notes)
                                                                <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed whitespace-pre-wrap">{{ $log->notes }}</p>
                                                            @endif
                                                            
                                                            @if(count($log->images) > 0)
                                                                <div class="mt-2 flex flex-wrap gap-2">
                                                                    @foreach($log->images as $mLogIdx => $imgPath)
                                                                        @php
                                                                            $adminPos = $adminBIndexMap[$log->id . '_' . $mLogIdx] ?? 0;
                                                                        @endphp
                                                                        <div 
                                                                            onclick='openGlobalLightbox(@json($adminAllBitacoraPhotos), {{ $adminPos }}, "Bitácora de Avances")'
                                                                            class="relative w-16 h-16 shrink-0 aspect-square rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-800 bg-zinc-100 dark:bg-zinc-800 cursor-pointer group hover:border-zinc-300 dark:hover:border-zinc-700 transition"
                                                                            title="Clic para ampliar evidencia"
                                                                        >
                                                                            <img 
                                                                                src="{{ asset('storage/' . $imgPath) }}" 
                                                                                loading="lazy" 
                                                                                class="w-full h-full object-cover group-hover:scale-105 transition duration-200"
                                                                                onerror="this.onerror=null; this.src='/images/logo-dark.png';"
                                                                                alt="Evidencia técnica"
                                                                            >
                                                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/40">
                                                                                <x-ui.icon name="expand" class="w-4 h-4 text-white" />
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            
                                                            @if($log->user)
                                                                <span class="text-[10px] text-zinc-500 font-medium block pt-1">Registrado por: {{ $log->user->name }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-xs text-zinc-500 italic py-2">No se han registrado hitos históricos en la bitácora aún.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- 4. TAB: SHARING & LINKS -->
                                <div x-show="$wire.activeTab === 'share'" class="space-y-6">
                                    <div class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 pb-3">
                                        <h4 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider flex items-center gap-2">
                                            <x-ui.icon name="link" class="w-4 h-4 text-zinc-500" />
                                            Enlaces de Seguimiento y Compartición
                                        </h4>
                                        <span class="text-xs text-zinc-500">Canales de comunicación</span>
                                    </div>

                                    <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-3">
                                        <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider block">Expediente Público para el Cliente</span>
                                        
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">
                                            Tus clientes pueden revisar el estado actual de su dispositivo, ver el presupuesto y la bitácora técnica con fotos en tiempo real ingresando a su portal de seguimiento en vivo con este enlace único.
                                        </p>

                                        <div class="flex flex-col sm:flex-row gap-3 items-center">
                                            <div class="w-full bg-zinc-50 dark:bg-zinc-950 p-2.5 rounded-lg border border-zinc-200 dark:border-zinc-800 font-mono text-xs text-zinc-800 dark:text-zinc-200 select-all break-all">
                                                {{ url('/seguimiento/' . $managingOrder->uuid) }}
                                            </div>
                                            
                                            <button 
                                                x-data="{ copied: false }" 
                                                @click="
                                                    navigator.clipboard.writeText('{{ url('/seguimiento/' . $managingOrder->uuid) }}');
                                                    copied = true;
                                                    setTimeout(() => copied = false, 2000);
                                                " 
                                                class="w-full sm:w-auto shrink-0 py-2.5 px-4 rounded-lg bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-900 dark:text-zinc-100 font-medium text-xs border border-zinc-200 dark:border-zinc-700 transition flex items-center justify-center gap-2 cursor-pointer"
                                            >
                                                <template x-if="!copied">
                                                    <x-ui.icon name="copy" class="w-4 h-4" />
                                                </template>
                                                <template x-if="copied">
                                                    <x-ui.icon name="check" class="w-4 h-4 text-emerald-500" />
                                                </template>
                                                <span x-text="copied ? '¡Copiado!' : 'Copiar Enlace'"></span>
                                            </button>
                                        </div>
                                    </div>

                                    @php
                                        $phone = preg_replace('/[^0-9]/', '', $managingOrder->client->phone);
                                        $clientName = $managingOrder->client->full_name;
                                        $brandModel = $managingOrder->brand_model;
                                        $trackingUrl = url('/seguimiento/' . $managingOrder->uuid);
                                        $totalFormatted = '$' . number_format($totalCost, 0, ',', '.');
                                        $balanceFormatted = '$' . number_format($balanceDue, 0, ',', '.');

                                        switch ($managingOrder->status) {
                                            case 'Ingresado':
                                                $statusText = "Hola {$clientName}, te saluda Sointech. Te informamos que tu equipo {$brandModel} ha sido ingresado al taller con éxito bajo la orden de trabajo #{$managingOrder->id}. Puedes ver la bitácora técnica y evidencias fotográficas en tiempo real ingresando aquí: {$trackingUrl}";
                                                break;
                                            case 'En Revisión':
                                                $statusText = "Hola {$clientName}, te saluda Sointech. Queremos informarte que tu equipo {$brandModel} ya se encuentra en nuestro laboratorio de revisión técnica avanzada. Nuestro técnico está elaborando el diagnóstico. Sigue las pruebas en tiempo real ingresando aquí: {$trackingUrl}";
                                                break;
                                            case 'Presupuestado':
                                                $statusText = "Hola {$clientName}, te saluda Sointech. ¡Excelentes noticias! El diagnóstico y presupuesto de reparación para tu equipo {$brandModel} ya están listos. El costo total estimado es de {$totalFormatted}. Por favor, ingresa al siguiente enlace para ver el detalle de repuestos y dar tu aprobación o rechazo en línea: {$trackingUrl}";
                                                break;
                                            case 'Aprobado':
                                                $statusText = "Hola {$clientName}, te saluda Sointech. Hemos registrado la aprobación del presupuesto para tu equipo {$brandModel} con éxito. Nuestro equipo técnico procederá a programar y realizar la reparación de inmediato. Puedes hacer seguimiento del avance en tiempo real ingresando aquí: {$trackingUrl}";
                                                break;
                                            case 'Rechazado':
                                                $statusText = "Hola {$clientName}, te saluda Sointech. Confirmamos el rechazo del presupuesto para tu equipo {$brandModel}. Procederemos a cerrar el caso y armar tu equipo para devolvértelo en recepción sin costo de reparación. Revisa el estado de la entrega ingresando aquí: {$trackingUrl}";
                                                break;
                                            case 'En Reparación':
                                                $statusText = "Hola {$clientName}, te saluda Sointech. Te informamos que nuestro equipo técnico ha iniciado formalmente la reparación y el cambio de componentes de tu equipo {$brandModel}. Sigue el avance de la reparación y fotos de evidencia en tiempo real aquí: {$trackingUrl}";
                                                break;
                                            case 'Listo para Entrega':
                                                $statusText = "¡Excelentes noticias {$clientName}! Te saluda Sointech. Tu equipo {$brandModel} ha sido REPARADO con éxito y superó todas nuestras pruebas de control de calidad. Ya se encuentra listo para retiro en nuestro local. El saldo restante a pagar al retirar es de {$balanceFormatted}. Revisa el detalle técnico y la bitácora final aquí: {$trackingUrl}";
                                                break;
                                            case 'Entregado':
                                                $statusText = "¡Muchas gracias por tu confianza {$clientName}! Confirmamos la entrega formal de tu equipo {$brandModel}. Esperamos que disfrutes de tu dispositivo y recuerda que cuentas con nuestra garantía de servicio técnico Sointech. Puedes ver el historial de tu servicio en el siguiente enlace: {$trackingUrl}";
                                                break;
                                            default:
                                                $statusText = "Hola {$clientName}, puedes hacer el seguimiento en vivo de tu equipo {$brandModel} ingresando a este enlace: {$trackingUrl}";
                                                break;
                                        }
                                    @endphp

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <!-- WhatsApp Dynamic Automation Card -->
                                        <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-3 flex flex-col justify-between">
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-2">
                                                    <x-ui.icon name="message-square" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                                                    <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Notificación WhatsApp</span>
                                                </div>
                                                
                                                <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-normal">
                                                    Envía de forma automatizada un mensaje formal pre-configurado para mantener al cliente informado del estado actual de su servicio.
                                                </p>
                                            </div>

                                            <a 
                                                href="https://wa.me/{{ $phone }}?text={{ urlencode($statusText) }}"
                                                target="_blank"
                                                class="w-full py-2.5 px-4 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-medium transition flex items-center justify-center gap-2 cursor-pointer shadow-xs"
                                            >
                                                <x-ui.icon name="share" class="w-4 h-4" />
                                                Notificar por WhatsApp
                                            </a>
                                        </div>

                                        <!-- Dynamic Preview Card -->
                                        <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-2 flex flex-col justify-between">
                                            <span class="text-[10px] text-zinc-500 uppercase tracking-wider block font-semibold">Vista Previa Mensaje ({{ $managingOrder->status }})</span>
                                            
                                            <div class="bg-white dark:bg-zinc-950 p-3 rounded-lg border border-zinc-200 dark:border-zinc-800 text-[11px] text-zinc-700 dark:text-zinc-300 font-mono leading-relaxed select-all flex-1 min-h-[90px] max-h-28 overflow-y-auto">
                                                {{ $statusText }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 5. TAB: PAYMENTS (HISTORIAL DE PAGOS) -->
                                <div x-show="$wire.activeTab === 'payments'" class="space-y-6">
                                    <div class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 pb-3">
                                        <h4 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider flex items-center gap-2">
                                            <x-ui.icon name="receipt" class="w-4 h-4 text-zinc-500" />
                                            Historial de Pagos
                                        </h4>
                                        <span class="text-xs text-zinc-500">Manejo de abonos y saldos</span>
                                    </div>
                                    
                                     @php
                                         $hasOpenCashRegister = \App\Models\CashRegister::where('status', 'open')
                                             ->whereDate('opened_at', \Carbon\Carbon::today())
                                             ->exists();
                                     @endphp
                                     
                                     @if(!$hasOpenCashRegister)
                                         <div class="bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/50 text-amber-900 dark:text-amber-200 p-3.5 rounded-xl text-xs space-y-2">
                                             <div class="font-semibold flex items-center gap-2 text-amber-800 dark:text-amber-300">
                                                 <x-ui.icon name="alert-triangle" class="w-4 h-4 text-amber-500 shrink-0" />
                                                 <span>Caja Diaria Cerrada</span>
                                             </div>
                                             <p class="text-amber-700 dark:text-amber-300 text-xs">Para poder registrar cobros de saldos o abonos a esta orden, primero debes abrir la caja del día.</p>
                                             <a href="{{ route('cash-registers.index') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-600 hover:bg-amber-500 text-white font-medium rounded-lg text-xs transition">
                                                 <x-ui.icon name="external-link" class="w-3.5 h-3.5" />
                                                 Ir a Apertura de Caja
                                             </a>
                                         </div>
                                     @endif
                                    
                                     @if (session()->has('error'))
                                         <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl text-xs font-medium" role="alert">
                                             {{ session('error') }}
                                         </div>
                                     @endif
                                     
                                     @if (session()->has('message'))
                                         <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl text-xs font-medium" role="alert">
                                             {{ session('message') }}
                                         </div>
                                     @endif

                                     <!-- Pagos Existentes -->
                                     <div class="space-y-3">
                                         <h5 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Pagos Registrados</h5>
                                         @forelse($managingOrder->payments as $payment)
                                             <div class="bg-white dark:bg-zinc-900 p-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                                                 <div>
                                                     <div class="text-xs font-semibold text-zinc-900 dark:text-zinc-100">{{ $payment->description }}</div>
                                                     <div class="text-[11px] text-zinc-500 mt-0.5 flex items-center gap-2 flex-wrap">
                                                         <span>{{ $payment->created_at->format('d/m/Y H:i') }} • {{ $payment->payment_method }} • {{ $payment->user->name ?? 'Sistema' }}</span>
                                                         <a href="/ot/{{ $managingOrder->id }}/print-payment/{{ $payment->id }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 rounded text-[10px] font-medium transition">
                                                             <x-ui.icon name="printer" class="w-3 h-3 text-zinc-500" />
                                                             Imprimir Boleta
                                                         </a>
                                                     </div>
                                                 </div>
                                                 <div class="text-emerald-600 dark:text-emerald-400 font-semibold text-sm font-mono">
                                                     +${{ number_format($payment->amount, 0, ',', '.') }}
                                                 </div>
                                             </div>
                                         @empty
                                             <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 text-center text-xs text-zinc-500">
                                                 No hay pagos registrados para esta orden.
                                             </div>
                                         @endforelse
                                     </div>

                                     <!-- Saldo Pendiente -->
                                     <div class="bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 p-3.5 rounded-xl flex justify-between items-center">
                                         <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Saldo Pendiente:</span>
                                         <span class="text-base font-semibold text-zinc-900 dark:text-zinc-100 font-mono">${{ number_format($balanceDue, 0, ',', '.') }}</span>
                                     </div>

                                     @if($balanceDue > 0)
                                     <!-- Pago Rápido (antes de POS) -->
                                     <div x-data="{
                                         rawAmount: @entangle('newPaymentAmount').live,
                                         formatted: '',
                                         maxBalance: {{ $balanceDue }},
                                         updateDisplay() {
                                             let clean = String(this.rawAmount || 0).replace(/\D/g, '');
                                             if (!clean || clean === '0') {
                                                 this.formatted = '$ 0';
                                             } else {
                                                 this.formatted = '$ ' + new Intl.NumberFormat('es-CL').format(parseInt(clean, 10));
                                             }
                                         },
                                         onInput(e) {
                                             let val = e.target.value.replace(/\D/g, '');
                                             let num = val ? parseInt(val, 10) : 0;
                                             this.rawAmount = num;
                                             this.updateDisplay();
                                         },
                                         setAmount(val) {
                                             this.rawAmount = val;
                                             this.updateDisplay();
                                         },
                                         init() {
                                             this.updateDisplay();
                                             this.$watch('rawAmount', () => this.updateDisplay());
                                         }
                                     }" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 rounded-xl space-y-3">
                                         <div class="flex items-center justify-between">
                                             <h5 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider flex items-center gap-1.5">
                                                 <x-ui.icon name="credit-card" class="w-4 h-4 text-zinc-500" />
                                                 Registrar Pago Rápido
                                             </h5>
                                             <x-ui.badge variant="success">Auto-Validado</x-ui.badge>
                                         </div>
                                         <p class="text-xs text-zinc-500">Registra un abono o pago anticipado directamente desde aquí sin ir al POS.</p>

                                         <!-- Botones de Selección Rápida de Monto -->
                                         <div class="flex flex-wrap items-center gap-1.5 pt-1">
                                             <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider mr-1">Sugeridos:</span>
                                             <button type="button" @click="setAmount(maxBalance)" class="px-2.5 py-1 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg text-xs font-medium transition cursor-pointer">
                                                 Total (${{ number_format($balanceDue, 0, ',', '.') }})
                                             </button>
                                             @if($thirdPartyTotal > 0 && $paidSoFar < $thirdPartyTotal && ($thirdPartyTotal - $paidSoFar) <= $balanceDue)
                                                 <button type="button" @click="setAmount({{ round($thirdPartyTotal - $paidSoFar) }}); $wire.set('newPaymentDescription', 'Pago Repuesto y Envío')" class="px-2.5 py-1 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg text-xs font-medium transition cursor-pointer">
                                                     Repuesto + Envío (${{ number_format($thirdPartyTotal - $paidSoFar, 0, ',', '.') }})
                                                 </button>
                                             @endif
                                             @if($balanceDue > 1000)
                                                 <button type="button" @click="setAmount(Math.round(maxBalance / 2))" class="px-2.5 py-1 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg text-xs font-medium transition cursor-pointer">
                                                     50% (${{ number_format(round($balanceDue / 2), 0, ',', '.') }})
                                                 </button>
                                             @endif
                                         </div>

                                         <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                             <div>
                                                 <label class="block text-[11px] text-zinc-600 dark:text-zinc-400 font-medium mb-1 uppercase tracking-wider">Monto a Cobrar</label>
                                                 <input
                                                     type="text"
                                                     x-model="formatted"
                                                     @input="onInput($event)"
                                                     placeholder="$ 0"
                                                     :class="{
                                                         'border-red-500 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/20 focus:border-red-500': rawAmount > maxBalance,
                                                         'border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/20 focus:border-emerald-500': rawAmount > 0 && rawAmount <= maxBalance,
                                                         'border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 bg-white dark:bg-zinc-800 focus:border-brand-500': !rawAmount || rawAmount <= 0
                                                     }"
                                                     class="w-full rounded-lg py-2 px-3 font-mono text-sm font-semibold focus:outline-none transition"
                                                 >
                                             </div>
                                             <div>
                                                 <label class="block text-[11px] text-zinc-600 dark:text-zinc-400 font-medium mb-1 uppercase tracking-wider">Método de Pago</label>
                                                 <select wire:model="newPaymentMethod" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg py-2 px-3 text-zinc-900 dark:text-zinc-100 text-xs focus:outline-none focus:border-brand-500 transition">
                                                     <option>Efectivo</option>
                                                     <option>Transferencia</option>
                                                     <option>Débito</option>
                                                     <option>Crédito</option>
                                                     <option>Otro</option>
                                                 </select>
                                             </div>
                                         </div>

                                         <!-- Advertencia en tiempo real si el monto supera el saldo pendiente -->
                                         <template x-if="rawAmount > maxBalance">
                                             <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/50 text-red-700 dark:text-red-300 p-3 rounded-lg text-xs space-y-1">
                                                 <div class="font-semibold flex items-center gap-1.5 text-red-700 dark:text-red-300">
                                                     <x-ui.icon name="alert-triangle" class="w-4 h-4 text-red-500 shrink-0" />
                                                     <span>Monto Excesivo</span>
                                                 </div>
                                                 <p class="text-[11px] leading-tight text-red-600 dark:text-red-300">
                                                     El monto digitado (<strong x-text="formatted" class="font-semibold"></strong>) es superior al saldo pendiente (<strong>${{ number_format($balanceDue, 0, ',', '.') }}</strong>).
                                                     Verifica si agregaste ceros demás por error.
                                                 </p>
                                             </div>
                                         </template>

                                         @error('newPaymentAmount') 
                                             <span class="text-red-500 text-xs font-medium block bg-red-50 dark:bg-red-950/30 p-2.5 rounded-lg border border-red-200 dark:border-red-800">
                                                 {{ $message }}
                                             </span> 
                                         @enderror

                                         <div>
                                             <label class="block text-[11px] text-zinc-600 dark:text-zinc-400 font-medium mb-1 uppercase tracking-wider">Descripción / Glosa</label>
                                             <input
                                                 type="text"
                                                 wire:model="newPaymentDescription"
                                                 placeholder="Abono Parcial"
                                                 class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg py-2 px-3 text-zinc-900 dark:text-zinc-100 text-xs focus:outline-none focus:border-brand-500 transition"
                                             />
                                         </div>

                                         {{-- Checkbox: Pago anticipado sin bitácora --}}
                                         <label class="flex items-center gap-3 bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 rounded-lg p-3 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800/60 transition">
                                             <input
                                                 type="checkbox"
                                                 wire:model="skipLogOnPayment"
                                                 class="w-4 h-4 rounded border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-brand-500 focus:ring-brand-500 focus:ring-1 cursor-pointer"
                                             />
                                             <div>
                                                 <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 block">Pago anticipado (no registrar en bitácora)</span>
                                                 <span class="text-[11px] text-zinc-500">El cliente paga antes de iniciar la reparación. No se generará entrada en la bitácora.</span>
                                             </div>
                                         </label>

                                         <button
                                             type="button"
                                             wire:click="addPayment"
                                             :disabled="rawAmount > maxBalance"
                                             :class="{
                                                 'opacity-50 cursor-not-allowed bg-zinc-300 dark:bg-zinc-800 text-zinc-500': rawAmount > maxBalance,
                                                 'bg-emerald-600 hover:bg-emerald-500 text-white cursor-pointer shadow-xs active:scale-95': rawAmount <= maxBalance
                                             }"
                                             class="w-full font-medium py-2.5 px-4 rounded-lg text-xs transition duration-150 flex items-center justify-center gap-2"
                                         >
                                             <x-ui.icon name="plus" class="w-4 h-4" />
                                             <span>Registrar Pago (<span x-text="formatted"></span>)</span>
                                         </button>
                                     </div>
                                     @endif

                                     <!-- Ir al POS para factura completa -->
                                     <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-2.5 text-center">
                                         <h5 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider flex items-center justify-center gap-1.5">
                                             <x-ui.icon name="shopping-bag" class="w-4 h-4 text-zinc-500" />
                                             Facturación y POS
                                         </h5>
                                         <p class="text-xs text-zinc-600 dark:text-zinc-400">Para emitir boletas, facturas o registrar pagos con múltiples métodos, dirígete al módulo de Punto de Venta (POS).</p>
                                         <a href="/pos?ot_id={{ $managingOrder->id }}" class="inline-flex items-center justify-center gap-2 w-full bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-100 dark:hover:bg-white text-white dark:text-zinc-900 font-medium py-2.5 px-4 rounded-lg text-xs transition duration-150 cursor-pointer shadow-xs">
                                             <x-ui.icon name="shopping-bag" class="w-4 h-4" />
                                             Pagar / Facturar en POS
                                         </a>
                                     </div>
                                 </div>

                             </div>
                         </div>

                     </div>

                     <!-- Desktop Footer actions (hidden on mobile) -->
                     <div class="hidden md:flex bg-zinc-50 dark:bg-zinc-900/80 p-3.5 px-6 border-t border-zinc-200 dark:border-zinc-800 justify-end items-center shrink-0 w-full">
                         <button type="button" wire:click="closeManagingModal" class="py-2 px-4 rounded-lg bg-white hover:bg-zinc-50 dark:bg-zinc-800 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-200 font-medium text-xs transition cursor-pointer shadow-xs flex items-center gap-2">
                             <x-ui.icon name="x" class="w-4 h-4 text-zinc-400" />
                             Cerrar Panel de Gestión
                         </button>
                     </div>

                     <!-- Mobile Bottom Navigation Bar (P2 - Full-screen Modal Bottom Fixed) -->
                     <div class="md:hidden bg-white/95 dark:bg-zinc-900/95 backdrop-blur-md border-t border-zinc-200 dark:border-zinc-800 shrink-0 safe-area-bottom z-50">
                         <div class="grid grid-cols-4 max-w-lg mx-auto items-center py-1.5 px-2">
                             <!-- 1. Costos (Details) -->
                             <button 
                                 wire:click="$set('activeTab', 'details')" 
                                 type="button"
                                 class="flex flex-col items-center justify-center py-1.5 px-1 rounded-lg transition-all duration-150 active:scale-95 cursor-pointer {{ $activeTab === 'details' ? 'text-brand-500 font-semibold bg-brand-500/10' : 'text-zinc-500 font-medium hover:text-zinc-900 dark:hover:text-zinc-200' }}"
                             >
                                 <x-ui.icon name="clipboard" class="w-5 h-5 shrink-0 mb-0.5" />
                                 <span class="text-[10px] leading-tight">Costos</span>
                             </button>

                             <!-- 2. Bitácora (Logs) -->
                             <button 
                                 wire:click="$set('activeTab', 'logs')" 
                                 type="button"
                                 class="flex flex-col items-center justify-center py-1.5 px-1 rounded-lg transition-all duration-150 active:scale-95 cursor-pointer {{ $activeTab === 'logs' ? 'text-brand-500 font-semibold bg-brand-500/10' : 'text-zinc-500 font-medium hover:text-zinc-900 dark:hover:text-zinc-200' }}"
                             >
                                 <x-ui.icon name="clock" class="w-5 h-5 shrink-0 mb-0.5" />
                                 <span class="text-[10px] leading-tight">Bitácora</span>
                             </button>

                             <!-- 3. Links / Compartir -->
                             <button 
                                 wire:click="$set('activeTab', 'share')" 
                                 type="button"
                                 class="flex flex-col items-center justify-center py-1.5 px-1 rounded-lg transition-all duration-150 active:scale-95 cursor-pointer {{ $activeTab === 'share' ? 'text-brand-500 font-semibold bg-brand-500/10' : 'text-zinc-500 font-medium hover:text-zinc-900 dark:hover:text-zinc-200' }}"
                             >
                                 <x-ui.icon name="link" class="w-5 h-5 shrink-0 mb-0.5" />
                                 <span class="text-[10px] leading-tight">Links</span>
                             </button>

                             <!-- 4. Pagos -->
                             <button 
                                 wire:click="$set('activeTab', 'payments')" 
                                 type="button"
                                 class="flex flex-col items-center justify-center py-1.5 px-1 rounded-lg transition-all duration-150 active:scale-95 cursor-pointer {{ $activeTab === 'payments' ? 'text-brand-500 font-semibold bg-brand-500/10' : 'text-zinc-500 font-medium hover:text-zinc-900 dark:hover:text-zinc-200' }}"
                             >
                                 <x-ui.icon name="receipt" class="w-5 h-5 shrink-0 mb-0.5" />
                                 <span class="text-[10px] leading-tight">Pagos</span>
                             </button>
                         </div>
                     </div>
                </div>
                
                {{-- Lightbox removed from here - now handled globally via openGlobalLightbox() in app.blade.php --}}
            </div>
            </div>
        
        <!-- PLANTILLAS DE IMPRESIÓN OCULTAS EN EL DOM PARA EL MODAL -->
        <div wire:key="modal-print-templates-{{ $managingOrder->id }}" style="display: none;">
            
            <!-- 1. COMPROBANTE DE CLIENTE (A4 / Carta) -->
            @include('components.print.work-order-a4', ['templateId' => 'modal-receipt-template', 'order' => $managingOrder, 'qrCanvasId' => 'qr-modal-canvas'])
            
            <!-- 1.5 COTIZACION (A4 / Carta) -->
            @include('components.print.quote-a4', ['templateId' => 'modal-quote-template', 'order' => $managingOrder])

            <!-- 2. COMPROBANTE TÉRMICO DE IDENTIFICACIÓN (58mm / 80mm) -->
            @include('components.print.work-order-thermal', ['templateId' => 'modal-thermal-template', 'order' => $managingOrder, 'qrCanvasId' => 'qr-modal-canvas-thermal'])


            <!-- 3. COMPROBANTE TÉRMICO DE ENTREGA (58mm / 80mm) -->
            <div id="modal-thermal-delivery-template" class="p-2 text-black bg-white flex flex-col items-center font-sans" style="font-family: 'Inter', sans-serif; width: 220px; text-align: center; margin: 0 auto;">
                <div style="font-size: 1.25rem; font-weight: 900; line-height: 1; margin-bottom: 0.5rem; text-transform: uppercase;">
                    SOINTECH
                </div>
                <div style="font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem; border-bottom: 1px dashed black; padding-bottom: 0.25rem; width: 100%;">
                    TICKET DE ENTREGA Y GARANTÍA
                </div>

                <div style="font-size: 0.75rem; text-align: left; width: 100%; margin-bottom: 0.5rem; line-height: 1.3;">
                    <p style="margin: 0;"><strong>OT:</strong> #{{ substr($managingOrder->uuid, 0, 8) }}</p>
                    <p style="margin: 0;"><strong>Cliente:</strong> {{ \Illuminate\Support\Str::limit($managingOrder->client?->full_name ?? 'Cliente N/A', 20) }}</p>
                    <p style="margin: 0;"><strong>Equipo:</strong> {{ \Illuminate\Support\Str::limit($managingOrder->brand_model ?? 'N/A', 20) }}</p>
                    <p style="margin: 0;"><strong>Técnico:</strong> {{ $managingOrder->technician ? \Illuminate\Support\Str::limit($managingOrder->technician->name, 20) : 'N/A' }}</p>
                    <p style="margin: 0;"><strong>Recibido por:</strong> {{ $managingOrder->receivedBy ? \Illuminate\Support\Str::limit($managingOrder->receivedBy->name, 20) : 'Sistema' }}</p>
                    <p style="margin: 0;"><strong>Fecha Entrega:</strong> {{ $managingOrder->delivered_at ? $managingOrder->delivered_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</p>
                </div>

                <div style="font-size: 0.75rem; text-align: left; width: 100%; border-top: 1px dashed black; padding-top: 0.5rem; margin-bottom: 0.5rem; line-height: 1.3;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Total:</span>
                        <strong>${{ number_format($totalCost, 0, ',', '.') }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Abonos:</span>
                        <strong>${{ number_format($managingOrder->down_payment, 0, ',', '.') }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 0.25rem; font-size: 0.875rem;">
                        <span>SALDO FINAL:</span>
                        <strong>$0</strong>
                    </div>
                </div>

                <div style="border: 1px solid black; padding: 0.5rem; border-radius: 0.25rem; margin-bottom: 0.5rem; width: 100%;">
                    <p style="margin: 0; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">GARANTÍA</p>
                    <p style="margin: 0; font-size: 0.75rem;">
                        @if($managingOrder->warranty_months > 0)
                            <strong>{{ $managingOrder->warranty_months }} MES(ES)</strong><br>
                            Válida hasta: {{ \Carbon\Carbon::parse($managingOrder->delivered_at ?? now())->addMonths($managingOrder->warranty_months)->format('d/m/Y') }}
                        @else
                            <strong>SIN GARANTÍA</strong>
                        @endif
                    </p>
                </div>

                <p style="font-size: 0.6rem; text-align: justify; margin-bottom: 1rem; line-height: 1.2;">
                    La garantía cubre exclusívamente el correcto funcionamiento de las piezas reemplazadas. No cubre daños físicos, humedad o alteraciones posteriores.
                </p>

                <div style="width: 100%; margin-top: 1rem;">
                    <div style="border-bottom: 1px solid black; height: 1.5rem; margin-bottom: 0.25rem;"></div>
                    <p style="font-size: 0.65rem; margin: 0; font-weight: 700;">FIRMA CONFORME CLIENTE</p>
                </div>
            </div>

        </div>
        </div>
        @endif
        
        <!-- Script de impresión robusto e instantáneo para el Modal -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    @endif

    <!-- DELIVERY MODAL (GARANTÍA Y ENTREGA) -->
    @if($isDelivering)
        <div class="fixed inset-0 z-[100] flex items-center justify-center animate-fade-in">
            <div class="absolute inset-0 bg-zinc-950/60 backdrop-blur-xs" wire:click="$set('isDelivering', false)"></div>
            <div class="relative w-full max-w-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl p-6 mx-4">
                
                <div class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 pb-4 mb-5">
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2">
                        <x-ui.icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                        Entregar Equipo
                    </h2>
                    <button wire:click="$set('isDelivering', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition">
                        <x-ui.icon name="x" class="w-5 h-5" />
                    </button>
                </div>

                <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-5">
                    Estás a punto de entregar la Orden <strong class="text-zinc-900 dark:text-zinc-100">#{{ $deliveringOrderCode }}</strong>. Por favor, especifica la garantía para que el sistema empiece a contar los días.
                </p>

                <div class="space-y-4">
                    @if($deliveryBalanceDue > 0)
                        <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/40 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <x-ui.icon name="alert-triangle" class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0 mt-0.5" />
                                <div class="flex-1">
                                    <h3 class="text-xs font-semibold text-red-700 dark:text-red-300">Saldo Pendiente: ${{ number_format($deliveryBalanceDue, 0, ',', '.') }}</h3>
                                    <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">Este equipo tiene un saldo sin pagar. Asegúrate de cobrarlo al momento de entregar.</p>
                                    
                                    <label class="flex items-center gap-2 mt-3 cursor-pointer">
                                        <input type="checkbox" wire:model.live="deliveryPayBalance" class="w-4 h-4 text-brand-500 bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-700 rounded focus:ring-brand-500">
                                        <span class="text-xs font-medium text-zinc-900 dark:text-zinc-100">Registrar pago del saldo ahora</span>
                                    </label>

                                    @if(!$deliveryPayBalance)
                                        @if(auth()->user()->hasRole('admin'))
                                            <div class="mt-2.5 text-xs font-medium text-zinc-600 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800/60 p-2.5 rounded-lg border border-zinc-200 dark:border-zinc-700 flex items-center gap-2">
                                                <x-ui.icon name="info" class="w-4 h-4 shrink-0 text-zinc-500" />
                                                <span>Modo Administrador: Si entregas sin marcar el pago, la orden quedará entregada con una nota de autorización en la bitácora.</span>
                                            </div>
                                        @else
                                            <div class="mt-2.5 text-xs font-medium text-amber-800 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/40 p-2.5 rounded-lg border border-amber-200 dark:border-amber-800/50 flex items-center gap-2">
                                                <x-ui.icon name="alert-triangle" class="w-4 h-4 shrink-0 text-amber-500" />
                                                <span>Debes registrar el pago del saldo para poder confirmar la entrega (Requerido para rol Técnico).</span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            @if($deliveryPayBalance)
                                <div class="mt-4 pt-4 border-t border-red-200 dark:border-red-800/40 space-y-3">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Método de Pago</label>
                                            <select wire:model="deliveryPaymentMethod" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none">
                                                <option>Efectivo</option>
                                                <option>Tarjeta Crédito/Débito</option>
                                                <option>Transferencia</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Comprobante</label>
                                            <select wire:model.live="documentType" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none">
                                                <option>Ticket Interno</option>
                                                <option>Boleta</option>
                                                <option>Factura</option>
                                            </select>
                                        </div>
                                    </div>

                                    @if($documentType === 'Factura')
                                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-3.5 rounded-xl border border-zinc-200 dark:border-zinc-700 space-y-2.5">
                                            <h4 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Datos de Facturación</h4>
                                            
                                            <div>
                                                <label class="block text-[11px] text-zinc-600 dark:text-zinc-400 mb-1">Razón Social *</label>
                                                <input type="text" wire:model="clientCompanyName" class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 text-xs focus:border-brand-500 outline-none" placeholder="Ej: Mi Empresa SpA">
                                                @error('clientCompanyName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            
                                            <div>
                                                <label class="block text-[11px] text-zinc-600 dark:text-zinc-400 mb-1">Giro Comercial *</label>
                                                <input type="text" wire:model="clientBusinessActivity" class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 text-xs focus:border-brand-500 outline-none" placeholder="Ej: Servicios Informáticos">
                                                @error('clientBusinessActivity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-[11px] text-zinc-600 dark:text-zinc-400 mb-1">Dirección *</label>
                                                    <input type="text" wire:model="clientAddress" class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 text-xs focus:border-brand-500 outline-none" placeholder="Ej: Av. Principal 123">
                                                    @error('clientAddress') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-[11px] text-zinc-600 dark:text-zinc-400 mb-1">Comuna *</label>
                                                    <input type="text" wire:model="clientCommune" class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 text-xs focus:border-brand-500 outline-none" placeholder="Ej: Santiago">
                                                    @error('clientCommune') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/40 rounded-xl p-3.5 flex items-center gap-3">
                            <x-ui.icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" />
                            <div class="text-xs">
                                <span class="font-semibold text-emerald-700 dark:text-emerald-300">Todo pagado.</span>
                                <span class="text-zinc-600 dark:text-zinc-400">No hay saldos pendientes para esta OT.</span>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Garantía Otorgada al Entregar *</label>
                        <select wire:model="deliveryWarrantyMonths" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none">
                            <option value="0">0 Meses (Sin Garantía - Equipo Mojado / Humedad / Alto Riesgo)</option>
                            <option value="1">1 Mes de Garantía</option>
                            <option value="2">2 Meses de Garantía</option>
                            <option value="3">3 Meses de Garantía (Estándar)</option>
                            <option value="6">6 Meses de Garantía</option>
                            <option value="12">12 Meses de Garantía (1 Año)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Notas de Entrega y Exclusiones (Opcional)</label>
                        <textarea wire:model="deliveryNotes" rows="2" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Ej. Probado en mostrador frente al cliente. Sin garantía por humedad previa..."></textarea>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('isDelivering', false)" class="px-4 py-2 rounded-lg text-xs font-medium text-zinc-700 dark:text-zinc-300 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 transition">
                        Cancelar
                    </button>
                    <button wire:click="processDelivery" class="px-4 py-2 rounded-lg text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-xs transition flex items-center gap-2">
                        <x-ui.icon name="check" class="w-4 h-4" />
                        Confirmar Entrega
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
<script>


    document.addEventListener('livewire:initialized', () => {
        Livewire.on('payment-registered', (event) => {
            const paymentId = event.paymentId;
            const orderId = @this.get('editingOrderId') || @this.get('deliveringOrderId');
            if (paymentId && orderId) {
                // Abre el comprobante en una nueva ventana para impresión
                const printUrl = `/ot/${orderId}/print-payment/${paymentId}`;
                window.open(printUrl, '_blank', 'width=400,height=600');
            }
        });
    });
</script>
