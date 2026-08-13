<div class="space-y-6 animate-fade-in">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Órdenes de Trabajo</h1>
            <p class="text-sm text-gray-400 mt-1">Busca, filtra e interactúa con todas las órdenes de servicio del taller.</p>
        </div>
        
        @if(auth()->user()->isAdmin() || auth()->user()->role === 'recepcionista')
            <a href="{{ route('work-orders.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded-2xl shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition duration-200 self-start sm:self-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Crear Nueva OT
            </a>
        @endif
    </div>

    <!-- TOP FINANCIAL METRICS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        {{-- Tarjeta 1: Saldos por Cobrar --}}
        <div wire:click="$toggle('hasPendingBalanceFilter')" 
            class="p-4 rounded-2xl border transition duration-200 cursor-pointer flex items-center justify-between group
                {{ $hasPendingBalanceFilter ? 'bg-red-950/40 border-red-500/60 shadow-lg shadow-red-500/10' : 'bg-gray-850 border-gray-800 hover:border-gray-700' }}">
            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-widest text-red-400 block">
                    🔴 Por Cobrar (Cuentas Pendientes)
                </span>
                <div class="text-xl font-black text-white">
                    ${{ number_format($totalPendingReceivables, 0, ',', '.') }}
                </div>
                <span class="text-[11px] text-gray-400 block">
                    {{ $pendingCount }} {{ $pendingCount === 1 ? 'orden' : 'órdenes' }} con saldo por cobrar
                </span>
            </div>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                style="background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.2);">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Tarjeta 2: Recaudación por Abonos --}}
        <div class="p-4 rounded-2xl bg-gray-850 border border-gray-800 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-400 block">
                    🟢 Total Recaudado (Abonos)
                </span>
                <div class="text-xl font-black text-white">
                    ${{ number_format($totalCollected, 0, ',', '.') }}
                </div>
                <span class="text-[11px] text-gray-400 block">Ingresos ingresados a caja</span>
            </div>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                style="background:rgba(16,185,129,.1); border:1px solid rgba(16,185,129,.2);">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Tarjeta 3: Total Registros --}}
        <div class="p-4 rounded-2xl bg-gray-850 border border-gray-800 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-widest text-blue-400 block">
                    📋 Órdenes en Sistema
                </span>
                <div class="text-xl font-black text-white">
                    {{ count($workOrders) }}
                </div>
                <span class="text-[11px] text-gray-400 block">Mostrando según filtros aplicados</span>
            </div>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                style="background:rgba(59,130,246,.1); border:1px solid rgba(59,130,246,.2);">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- FILTER BAR (SEARCH & STATUS PILLS) -->
    <div class="bg-gray-850 p-5 rounded-3xl border border-gray-800 shadow-md space-y-4">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Search Input -->
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input wire:model.live="search" type="text" placeholder="Buscar por cliente, código..." 
                    class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
            </div>

            <!-- Date & Tech Filters -->
            <div class="flex flex-wrap gap-3 w-full md:w-auto items-center">
                <input wire:model.live="dateFrom" type="date" title="Desde" class="bg-gray-900 border border-gray-700 rounded-xl py-2 px-3 text-sm text-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                <span class="text-gray-500 text-xs">-</span>
                <input wire:model.live="dateTo" type="date" title="Hasta" class="bg-gray-900 border border-gray-700 rounded-xl py-2 px-3 text-sm text-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                
                @if(auth()->user()->isAdmin())
                <select wire:model.live="technicianFilter" class="bg-gray-900 border border-gray-700 rounded-xl py-2 px-3 text-sm text-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition cursor-pointer">
                    <option value="">Técnicos: Todos</option>
                    <option value="unassigned">No Asignado</option>
                    @foreach($technicians as $tech)
                        <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                    @endforeach
                </select>
                @endif
            </div>

            <!-- Right side tools -->
            <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                <!-- Export CSV -->
                <button wire:click="exportCSV" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-950/40 hover:bg-emerald-900/50 text-emerald-400 border border-emerald-500/30 font-bold rounded-xl text-xs transition duration-150 cursor-pointer" title="Exportar a Excel/CSV">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Exportar
                </button>
                <span class="text-xs font-semibold text-gray-400 bg-gray-900 px-3 py-2 rounded-xl border border-gray-700">
                    {{ count($workOrders) }} result(s)
                </span>
            </div>
        </div>

        <!-- Status Filter Pills -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2 border-t border-gray-800/60">
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('statusFilter', '')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition border {{ $statusFilter === '' && !$hasPendingBalanceFilter ? 'bg-blue-600 text-white border-blue-500 shadow-md shadow-blue-500/10' : 'bg-gray-900 text-gray-400 border-gray-700/60 hover:text-white' }}">
                    Todos
                </button>
                <button wire:click="$toggle('hasPendingBalanceFilter')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition border cursor-pointer {{ $hasPendingBalanceFilter ? 'bg-red-600 text-white border-red-500 shadow-md shadow-red-500/20' : 'bg-gray-900 text-red-400 border-red-900/60 hover:bg-red-950/40' }}">
                    🔴 Con Saldo Pendiente ({{ $pendingCount }})
                </button>
                <button wire:click="$set('statusFilter', 'Ingresado')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition border {{ $statusFilter === 'Ingresado' ? 'bg-gray-700 text-white border-gray-600 shadow-md' : 'bg-gray-900 text-gray-400 border-gray-700/60 hover:text-white' }}">
                    Ingresados
                </button>
                <button wire:click="$set('statusFilter', 'En Reparación')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition border {{ $statusFilter === 'En Reparación' ? 'bg-indigo-600 text-white border-indigo-500 shadow-md' : 'bg-gray-900 text-gray-400 border-gray-700/60 hover:text-white' }}">
                    En Reparación
                </button>
                <button wire:click="$set('statusFilter', 'Esperando Repuestos')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition border {{ $statusFilter === 'Esperando Repuestos' ? 'bg-orange-600 text-white border-orange-500 shadow-md' : 'bg-gray-900 text-gray-400 border-gray-700/60 hover:text-white' }}">
                    Esperando Repuestos
                </button>
                <button wire:click="$set('statusFilter', 'Listo para Entrega')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition border {{ $statusFilter === 'Listo para Entrega' ? 'bg-emerald-600 text-white border-emerald-500 shadow-md' : 'bg-gray-900 text-gray-400 border-gray-700/60 hover:text-white' }}">
                    Listos para Entrega
                </button>
                <button wire:click="$set('statusFilter', 'Entregado')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition border {{ $statusFilter === 'Entregado' ? 'bg-purple-600 text-white border-purple-500 shadow-md' : 'bg-gray-900 text-gray-400 border-gray-700/60 hover:text-white' }}">
                    Entregados
                </button>
            </div>

            
            <div class="flex items-center gap-2 pr-2">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.live="hasWarrantyFilter" class="sr-only peer">
                    <div class="relative w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                    <span class="ml-2 text-xs font-bold {{ $hasWarrantyFilter ? 'text-emerald-400' : 'text-gray-400' }}">Solo Garantía Vigente</span>
                </label>
            </div>
        </div>
    </div>

    <!-- DESKTOP TABLE -->
    <div class="hidden md:block bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden mt-6">
        <div class="overflow-x-auto theme-scrollbar">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-900/40 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                        <th class="px-3 py-3 text-xs md:text-xs">Código</th>
                        <th class="px-3 py-3 text-xs md:text-xs">Cliente</th>
                        <th class="px-3 py-3 text-xs md:text-xs">Equipo / Dispositivo</th>
                        <th class="px-3 py-3 text-xs md:text-xs">Estado</th>
                        <th class="px-3 py-3 text-xs md:text-xs">Finanzas</th>
                        <th class="px-3 py-3 text-xs md:text-xs">Fechas / Gar.</th>
                        @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                            <th class="px-3 py-3 text-center text-xs md:text-xs">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($workOrders as $order)
                        <tr class="hover:bg-gray-900/20 transition">
                            <!-- Code -->
                            <td class="px-3 py-3">
                                <span class="font-mono text-xs font-bold text-blue-400 uppercase tracking-tight">
                                    #{{ substr($order->uuid, 0, 8) }}
                                </span>
                            </td>
                            <!-- Client -->
                            <td class="px-3 py-3">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-white text-xs">{{ $order->client->full_name }}</span>
                                    <span class="text-[10px] text-gray-500">{{ $order->client->phone }}</span>
                                </div>
                            </td>
                            <!-- Device -->
                            <td class="px-3 py-3">
                                <div class="flex flex-col gap-1">
                                    <span class="text-white font-bold text-xs">{{ $order->brand_model }}</span>
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-800 text-blue-300 border border-blue-500/30">
                                            {{ $order->device_type_label }}
                                        </span>
                                        @if($order->imei_serial)
                                            <span class="text-[10px] text-gray-400 font-mono">SN: {{ $order->imei_serial }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <!-- Status -->
                            <td class="px-3 py-3">
                                @php
                                    $statusClasses = [
                                        'Ingresado' => 'bg-gray-900/50 text-gray-400 border-gray-700/60',
                                        'En Revisión' => 'bg-indigo-950/40 text-indigo-400 border-indigo-500/20',
                                        'Presupuestado' => 'bg-amber-950/40 text-amber-400 border-amber-500/20',
                                        'Aprobado' => 'bg-blue-950/40 text-blue-400 border-blue-500/20',
                                        'Esperando Repuestos' => 'bg-orange-950/40 text-orange-400 border-orange-500/20',
                                        'Rechazado' => 'bg-red-950/40 text-red-400 border-red-500/20 animate-pulse',
                                        'En Reparación' => 'bg-indigo-950/40 text-indigo-400 border-indigo-500/20',
                                        'Listo para Entrega' => 'bg-emerald-950/40 text-emerald-400 border-emerald-500/20',
                                        'Entregado' => 'bg-purple-950/40 text-purple-400 border-purple-500/20',
                                    ];
                                    $class = $statusClasses[$order->status] ?? 'bg-gray-900 text-gray-300 border-gray-700';
                                @endphp
                                @if(auth()->user()->hasRole(['admin', 'tecnico']))
                                    <div class="relative inline-block" x-data="{ openTableStatus: false }">
                                        <button 
                                            type="button" 
                                            @click="openTableStatus = !openTableStatus" 
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border transition cursor-pointer hover:scale-105 {{ $class }}"
                                            title="Clic para cambiar estado"
                                        >
                                            <span>{{ $order->status }}</span>
                                            <svg class="w-3 h-3 text-current opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                        <div 
                                            x-show="openTableStatus" 
                                            @click.outside="openTableStatus = false" 
                                            x-transition 
                                            class="absolute left-0 mt-1 z-50 w-48 bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-1.5 space-y-1 max-h-56 overflow-y-auto"
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
                                                    class="w-full text-left px-2.5 py-1.5 text-[11px] font-bold text-gray-300 hover:text-white hover:bg-gray-800 rounded-xl flex items-center justify-between transition"
                                                >
                                                    <span>{{ $st }}</span>
                                                    @if($order->status === $st)
                                                        <span class="text-orange-400 font-bold">✓</span>
                                                    @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold border {{ $class }}">
                                        {{ $order->status }}
                                    </span>
                                @endif
                            </td>
                            <!-- Finanzas -->
                             <td class="px-3 py-3">
                                 @php
                                     $totalCostTable = $order->calculated_total;
                                     $balanceTable   = $order->pending_balance;
                                 @endphp
                                 <div class="flex flex-col gap-0.5">
                                     @if($totalCostTable > 0)
                                         <span class="font-bold text-white text-xs" title="Presupuesto Total">
                                             Total: ${{ number_format($totalCostTable, 0, ',', '.') }}
                                         </span>
                                     @endif
                                     @if($order->down_payment > 0)
                                         <span class="text-[10px] text-emerald-400 font-semibold">
                                             Abonado: ${{ number_format($order->down_payment, 0, ',', '.') }}
                                         </span>
                                     @else
                                         <span class="text-[10px] text-gray-500 font-normal">
                                             Sin Abono
                                         </span>
                                     @endif

                                     @php
                                          $finBadge = $order->financial_status_badge;
                                      @endphp
                                      <span class="inline-flex items-center text-[10px] font-black border px-2 py-0.5 rounded-lg w-fit mt-0.5 {{ $finBadge['class'] }}">
                                          {{ $finBadge['label'] }}
                                      </span>
                                 </div>
                             </td>
                            <!-- Fechas / Gar. -->
                            <td class="px-3 py-3">
                                <div class="flex flex-col gap-0.5 items-start">
                                    <span class="text-[11px] text-gray-400">{{ $order->created_at->format('d/m/y') }}</span>
                                    @php
                                        $daysInWorkshop = $order->created_at->startOfDay()->diffInDays(now()->startOfDay());
                                        $isDelayed = $daysInWorkshop >= 3 && !in_array($order->status, ['Entregado', 'Rechazado', 'Listo para Entrega']);
                                        $warranty = $order->warrantyStatus;
                                    @endphp
                                    @if($isDelayed)
                                        <span class="inline-flex items-center gap-0.5 text-[9px] text-red-400 font-bold bg-red-500/10 border border-red-500/20 px-1 rounded animate-pulse" title="Retraso ({{ $daysInWorkshop }} días)">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            +{{ $daysInWorkshop }}d
                                        </span>
                                    @endif
                                    @if($warranty['status'] === 'active')
                                        <span class="text-[9px] font-bold text-emerald-400 mt-0.5">Gar: {{ $warranty['days_remaining'] }}d</span>
                                    @elseif($warranty['status'] === 'expired')
                                        <span class="text-[9px] font-bold text-red-400 mt-0.5">Gar: Vencida</span>
                                    @endif
                                </div>
                            </td>
                            <!-- Actions -->
                            @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                                <td class="px-3 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button 
                                            wire:click="openWorkOrderDetails({{ $order->id }})" 
                                            class="w-9 h-9 rounded-xl bg-blue-500/10 hover:bg-blue-600 text-blue-400 hover:text-white border border-blue-500/20 hover:border-blue-500 transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-blue-500/30 hover:-translate-y-0.5 cursor-pointer group"
                                            title="Gestionar / Ver Detalles"
                                        >
                                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                            class="w-9 h-9 rounded-xl bg-emerald-500/10 hover:bg-emerald-600 text-emerald-400 hover:text-white border border-emerald-500/20 hover:border-emerald-500 transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-emerald-500/30 hover:-translate-y-0.5 cursor-pointer group"
                                            title="Notificar por WhatsApp"
                                        >
                                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c-.001 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                No se encontraron órdenes de trabajo registradas con ese criterio.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MOBILE CARDS -->
    <div class="md:hidden flex flex-col gap-4 mt-6">
        @forelse($workOrders as $order)
            <div class="bg-gray-850/80 backdrop-blur-md rounded-3xl border border-gray-800 shadow-lg p-5 flex flex-col relative overflow-hidden group hover:border-gray-700 transition">
                <!-- Header: Code & Status -->
                <div class="flex items-center justify-between border-b border-gray-800/60 pb-3 mb-3">
                    <span class="font-mono text-xs font-bold text-blue-400 uppercase tracking-tight">
                        #{{ substr($order->uuid, 0, 8) }}
                    </span>
                    @php
                        $statusClasses = [
                            'Ingresado' => 'bg-gray-900/50 text-gray-400 border-gray-700/60',
                            'En Revisión' => 'bg-indigo-950/40 text-indigo-400 border-indigo-500/20',
                            'Presupuestado' => 'bg-amber-950/40 text-amber-400 border-amber-500/20',
                            'Aprobado' => 'bg-blue-950/40 text-blue-400 border-blue-500/20',
                            'Esperando Repuestos' => 'bg-orange-950/40 text-orange-400 border-orange-500/20',
                            'Rechazado' => 'bg-red-950/40 text-red-400 border-red-500/20 animate-pulse',
                            'En Reparación' => 'bg-indigo-950/40 text-indigo-400 border-indigo-500/20',
                            'Listo para Entrega' => 'bg-emerald-950/40 text-emerald-400 border-emerald-500/20',
                            'Entregado' => 'bg-purple-950/40 text-purple-400 border-purple-500/20',
                        ];
                        $class = $statusClasses[$order->status] ?? 'bg-gray-900 text-gray-300 border-gray-700';
                    @endphp
                    @if(auth()->user()->hasRole(['admin', 'tecnico']))
                        <div class="relative inline-block" x-data="{ openMobileStatus: false }">
                            <button 
                                type="button" 
                                @click="openMobileStatus = !openMobileStatus" 
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border transition cursor-pointer hover:scale-105 {{ $class }}"
                                title="Toca para cambiar estado"
                            >
                                <span>{{ $order->status }}</span>
                                <svg class="w-3 h-3 text-current opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div 
                                x-show="openMobileStatus" 
                                @click.outside="openMobileStatus = false" 
                                x-transition 
                                class="absolute right-0 mt-1 z-50 w-52 bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-2 space-y-1 max-h-60 overflow-y-auto"
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
                                        class="w-full text-left px-3 py-2 text-xs font-bold text-gray-300 hover:text-white hover:bg-gray-800 rounded-xl flex items-center justify-between transition"
                                    >
                                        <span>{{ $st }}</span>
                                        @if($order->status === $st)
                                            <span class="text-orange-400 font-bold">✓</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $class }}">
                            {{ $order->status }}
                        </span>
                    @endif
                </div>
                
                <!-- Client & Device -->
                <div class="space-y-2 mb-4">
                    <div>
                        <span class="text-[10px] text-gray-500 uppercase tracking-wider block">Cliente</span>
                        <span class="text-white font-semibold text-sm">{{ $order->client->full_name }}</span>
                        <span class="text-[10px] text-gray-400 ml-1">{{ $order->client->phone }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-500 uppercase tracking-wider block mb-0.5">Equipo</span>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-white font-bold text-sm leading-snug">{{ $order->brand_model }}</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-black bg-blue-950/80 text-blue-300 border border-blue-500/30 shadow-sm">
                                {{ $order->device_type_label }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Cost & Warranty Row -->
                <div class="flex items-center justify-between bg-gray-900/50 rounded-xl p-3 mb-4 border border-gray-800/50">
                    <div>
                        <span class="text-[10px] text-gray-500 block">Costo M.O.</span>
                        <span class="text-white font-bold text-sm">${{ number_format($order->labor_cost, 0, ',', '.') }}</span>
                    </div>
                    @php
                        $warranty = $order->warrantyStatus;
                    @endphp
                    <div class="text-right">
                        @if($warranty['status'] === 'active')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-black border bg-emerald-950/40 text-emerald-400 border-emerald-500/30">
                                <span class="w-1 h-1 rounded-full bg-emerald-400 animate-pulse"></span>
                                Vigente {{ $warranty['days_remaining'] }}d
                            </span>
                        @elseif($warranty['status'] === 'expired')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-black border bg-red-950/40 text-red-400 border-red-500/30">
                                Vencida
                            </span>
                        @else
                            <span class="text-gray-500 text-[10px]">&mdash;</span>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons (P6 - simplified) -->
                <div class="flex gap-2 mt-auto">
                    @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                        <button wire:click="openWorkOrderDetails({{ $order->id }})" class="flex-1 py-3 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl transition duration-150 shadow-md shadow-blue-500/20 text-center flex items-center justify-center gap-2 active:scale-95">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Gestionar
                            <svg class="w-3.5 h-3.5 opacity-50 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                        @php
                            $clientNameShort = explode(' ', $order->client->full_name)[0];
                            $waMessage = "Hola {$clientNameShort}, puedes hacer el seguimiento de la reparación de tu {$order->brand_model} en tiempo real aquí: " . url('/seguimiento/' . $order->uuid);
                        @endphp
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client->phone) }}?text={{ urlencode($waMessage) }}" target="_blank" class="py-3 px-4 bg-emerald-950/40 hover:bg-emerald-900/60 text-emerald-400 border border-emerald-500/30 rounded-xl transition flex items-center justify-center active:scale-95">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c-.001 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-gray-850 rounded-3xl border border-gray-800 p-8 text-center text-gray-500">
                <svg class="w-10 h-10 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium">No se encontraron órdenes</p>
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
                $partsCost = $managingOrder->parts->sum(function($p) {
                    return $p->pivot->price_at_time * $p->pivot->quantity;
                });
                $totalCost = (float)$managingOrder->labor_cost + $partsCost;
                $balanceDue = $totalCost - (float)$managingOrder->down_payment;
            @endphp
            <div x-data="{ previewImage: null, zoomLevel: 1, mobileMenuOpen: false }" 
                 x-init="document.body.style.overflow = 'hidden'" 
                 x-on:destroy="document.body.style.overflow = ''" 
                 @keydown.escape.window="if(!previewImage) $wire.closeManagingModal()"
                 class="fixed inset-0 bg-gray-950/85 backdrop-blur-md z-50 flex items-center justify-center p-2 sm:p-4 md:p-6 overflow-hidden">
                <div class="bg-gray-850 border border-gray-800 rounded-2xl md:rounded-3xl w-full max-w-6xl h-full md:h-[90vh] overflow-hidden shadow-2xl animate-fade-in flex flex-col min-w-0">
                    
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b border-gray-800 p-3 md:p-6 shrink-0">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="hidden sm:inline px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase bg-blue-950 text-blue-400 border border-blue-800/40">Orden de Trabajo</span>
                                <h3 class="text-lg md:text-xl font-black text-white tracking-tight">#{{ substr($managingOrder->uuid, 0, 8) }}</h3>
                            </div>
                            <p class="hidden md:block text-xs text-gray-400 mt-1">
                                Dispositivo: <span class="text-gray-200 font-semibold">{{ $managingOrder->brand_model }}</span> • Cliente: <span class="text-gray-200 font-semibold">{{ $managingOrder->client->full_name }}</span>
                            </p>
                            <p class="md:hidden text-[10px] text-gray-400 mt-0.5 truncate max-w-[200px]">
                                {{ $managingOrder->brand_model }} • {{ $managingOrder->client->full_name }}
                            </p>
                        </div>
                        
                        <!-- Desktop Print Buttons -->
                        <div class="hidden md:flex items-center gap-3 ml-auto mr-4">
                            @if($managingOrder->status === 'Entregado')
                                <button type="button" onclick="window.printContent('modal-thermal-delivery-template', 'qr-modal-canvas-thermal')" class="inline-flex items-center gap-1.5 px-3 py-2 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-xl text-xs transition duration-150 cursor-pointer shadow">
                                    🏷️ Ticket Entrega
                                </button>
                            @else
                                @if(in_array($managingOrder->status, ['Presupuestado', 'Aprobado', 'Esperando Repuestos']))
                                    <button type="button" onclick="window.printContent('modal-quote-template', 'qr-modal-canvas')" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs transition duration-150 cursor-pointer shadow">
                                        📄 Cotización A4
                                    </button>
                                @endif
                                <button type="button" onclick="window.printContent('modal-receipt-template', 'qr-modal-canvas')" class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl text-xs transition duration-150 cursor-pointer shadow">
                                    📄 Recibo A4
                                </button>
                                <button type="button" onclick="window.printContent('modal-thermal-template', 'qr-modal-canvas-thermal')" class="inline-flex items-center gap-1.5 px-3 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 font-bold rounded-xl text-xs transition duration-150 border border-gray-700 cursor-pointer">
                                    🏷️ Etiqueta Térmica
                                </button>
                            @endif
                        </div>

                        <!-- Mobile Overflow Menu -->
                        <div class="md:hidden relative ml-auto mr-2">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-2 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"></path></svg>
                            </button>
                            <div x-show="mobileMenuOpen" @click.outside="mobileMenuOpen = false" x-transition class="absolute right-0 top-full mt-1 w-56 bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl z-50 p-2 space-y-1" style="display:none;">
                                @if($managingOrder->status === 'Entregado')
                                    <button type="button" onclick="window.printContent('modal-thermal-delivery-template', 'qr-modal-canvas-thermal')" @click="mobileMenuOpen=false" class="w-full text-left px-3 py-2.5 text-xs font-bold text-white hover:bg-gray-800 rounded-xl transition flex items-center gap-2">
                                        🏷️ Ticket Entrega
                                    </button>
                                @else
                                    @if(in_array($managingOrder->status, ['Presupuestado', 'Aprobado', 'Esperando Repuestos']))
                                        <button type="button" onclick="window.printContent('modal-quote-template', 'qr-modal-canvas')" @click="mobileMenuOpen=false" class="w-full text-left px-3 py-2.5 text-xs font-bold text-white hover:bg-gray-800 rounded-xl transition flex items-center gap-2">
                                            📄 Cotización A4
                                        </button>
                                    @endif
                                    <button type="button" onclick="window.printContent('modal-receipt-template', 'qr-modal-canvas')" @click="mobileMenuOpen=false" class="w-full text-left px-3 py-2.5 text-xs font-bold text-white hover:bg-gray-800 rounded-xl transition flex items-center gap-2">
                                        📄 Recibo A4
                                    </button>
                                    <button type="button" onclick="window.printContent('modal-thermal-template', 'qr-modal-canvas-thermal')" @click="mobileMenuOpen=false" class="w-full text-left px-3 py-2.5 text-xs font-bold text-white hover:bg-gray-800 rounded-xl transition flex items-center gap-2">
                                        🏷️ Etiqueta Térmica
                                    </button>
                                @endif
                            </div>
                        </div>

                        <button wire:click="closeManagingModal" class="text-gray-500 hover:text-white transition cursor-pointer p-1.5 hover:bg-gray-800 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Mobile Compact Summary Bar (P1) -->
                    <div class="lg:hidden bg-gray-900/60 border-b border-gray-800 px-3 py-2.5 shrink-0">
                        <div class="flex items-center justify-between gap-2">
                            @php
                                $mobileStatusColors = [
                                    'Ingresado' => 'bg-gray-800 text-gray-300 border-gray-700',
                                    'En Revisión' => 'bg-indigo-950/60 text-indigo-400 border-indigo-800/50',
                                    'Presupuestado' => 'bg-amber-950/60 text-amber-400 border-amber-800/50',
                                    'Aprobado' => 'bg-blue-950/60 text-blue-400 border-blue-800/50',
                                    'En Reparación' => 'bg-indigo-950/60 text-indigo-400 border-indigo-800/50',
                                    'Listo para Entrega' => 'bg-emerald-950/60 text-emerald-400 border-emerald-800/50',
                                    'Entregado' => 'bg-purple-950/60 text-purple-400 border-purple-800/50',
                                ];
                                $mStatusClass = $mobileStatusColors[$managingOrder->status] ?? 'bg-gray-800 text-gray-300 border-gray-700';
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-black border {{ $mStatusClass }}">
                                {{ $managingOrder->status }}
                            </span>
                            <div class="text-right">
                                @if($balanceDue > 0)
                                    <span class="text-[10px] text-red-400 font-black">Pendiente: ${{ number_format($balanceDue, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-[10px] text-emerald-400 font-black">✅ Pagado</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Sticky Action Banner (P4) -->
                    @if(auth()->user()->hasRole(['admin', 'tecnico']))
                        @if($managingOrder->status === 'Aprobado')
                            <div class="lg:hidden bg-blue-900/40 border-b border-blue-800 px-3 py-3 shrink-0">
                                <button wire:click="startRepair" type="button" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-blue-900/50 transition text-sm flex items-center justify-center gap-2">
                                    ▶ Iniciar Reparación
                                </button>
                            </div>
                        @elseif($managingOrder->status === 'En Reparación')
                            <div class="lg:hidden bg-amber-900/30 border-b border-amber-800 px-3 py-3 shrink-0">
                                <button wire:click="finishRepair" type="button" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-amber-900/50 transition text-sm flex items-center justify-center gap-2">
                                    ✔ Finalizar Reparación
                                </button>
                            </div>
                        @endif
                    @endif

                    <!-- Main Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-6 p-3 sm:p-4 lg:p-6 overflow-y-auto flex-1 theme-scrollbar min-w-0 w-full pb-20 lg:pb-8">
                        
                        <!-- LEFT COLUMN: Summary & Financials (4 cols) -->
                        <div class="col-span-12 lg:col-span-4 space-y-5 min-w-0 w-full">
                            
                            <!-- Status Selector Card -->
                            <div class="bg-gray-900/40 p-4 rounded-2xl border border-gray-800 space-y-3">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Estado de la OT</span>
                                
                                @if(auth()->user()->hasRole(['admin', 'tecnico']))
                                    @php
                                        $statuses = [
                                            'Ingresado' => ['label' => 'Ingresado', 'color' => 'bg-gray-800 text-gray-300 border-gray-700', 'dot' => 'bg-gray-400'],
                                            'En Revisión' => ['label' => 'En Revisión', 'color' => 'bg-indigo-950/60 text-indigo-400 border-indigo-800/50', 'dot' => 'bg-indigo-400'],
                                            'Presupuestado' => ['label' => 'Presupuestado', 'color' => 'bg-amber-950/60 text-amber-400 border-amber-800/50', 'dot' => 'bg-amber-400'],
                                            'Aprobado' => ['label' => 'Aprobado', 'color' => 'bg-blue-950/60 text-blue-400 border-blue-800/50', 'dot' => 'bg-blue-400'],
                                            'Esperando Repuestos' => ['label' => 'Esperando Repuestos', 'color' => 'bg-orange-950/60 text-orange-400 border-orange-800/50', 'dot' => 'bg-orange-400'],
                                            'Rechazado' => ['label' => 'Rechazado', 'color' => 'bg-red-950/60 text-red-400 border-red-800/50', 'dot' => 'bg-red-400'],
                                            'En Reparación' => ['label' => 'En Reparación', 'color' => 'bg-indigo-950/60 text-indigo-400 border-indigo-800/50', 'dot' => 'bg-indigo-400'],
                                            'Listo para Entrega' => ['label' => 'Listo para Entrega', 'color' => 'bg-emerald-950/60 text-emerald-400 border-emerald-800/50', 'dot' => 'bg-emerald-400'],
                                            'Entregado' => ['label' => 'Entregado', 'color' => 'bg-purple-950/60 text-purple-400 border-purple-800/50', 'dot' => 'bg-purple-400'],
                                        ];
                                        $currentStatus = $statuses[$managingOrder->status] ?? ['label' => $managingOrder->status, 'color' => 'bg-gray-800 text-gray-300 border-gray-700', 'dot' => 'bg-gray-400'];
                                    @endphp
                                    <div class="relative w-full" x-data="{ open: false }">
                                        <!-- Custom Select Button Trigger -->
                                        <button 
                                            type="button" 
                                            @click="open = !open" 
                                            class="w-full flex items-center justify-between bg-gray-850 hover:bg-gray-800 text-xs font-bold px-3.5 py-2.5 rounded-xl border border-gray-700/80 transition duration-150 cursor-pointer select-none text-left"
                                        >
                                            <span class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-lg border {{ $currentStatus['color'] }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $currentStatus['dot'] }}"></span>
                                                {{ $currentStatus['label'] }}
                                            </span>
                                            <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                            class="absolute z-30 w-full mt-2 bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-2 space-y-1 max-h-60 overflow-y-auto theme-scrollbar"
                                            style="display: none;"
                                        >
                                            @foreach($statuses as $value => $data)
                                                <button 
                                                    type="button"
                                                    wire:click="updateStatus({{ $managingOrder->id }}, '{{ $value }}')"
                                                    @click="open = false"
                                                    class="w-full flex items-center gap-2 px-3 py-2 text-left text-xs font-bold text-gray-300 hover:text-white hover:bg-gray-800 rounded-xl transition duration-150 cursor-pointer select-none"
                                                >
                                                    <span class="inline-flex items-center gap-2 px-2 py-0.5 rounded-md border text-[10px] {{ $data['color'] }}">
                                                        <span class="w-1.5 h-1.5 rounded-full {{ $data['dot'] }}"></span>
                                                        {{ $data['label'] }}
                                                    </span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    @php
                                        $statusColors = [
                                            'Ingresado' => 'bg-gray-900/50 text-gray-400 border-gray-700/60',
                                            'En Revisión' => 'bg-indigo-950/40 text-indigo-400 border-indigo-500/20',
                                            'Presupuestado' => 'bg-amber-950/40 text-amber-400 border-amber-500/20',
                                            'Aprobado' => 'bg-blue-950/40 text-blue-400 border-blue-500/20',
                                            'Esperando Repuestos' => 'bg-orange-950/40 text-orange-400 border-orange-500/20',
                                            'Rechazado' => 'bg-red-950/40 text-red-400 border-red-500/20',
                                            'En Reparación' => 'bg-indigo-950/40 text-indigo-400 border-indigo-500/20',
                                            'Listo para Entrega' => 'bg-emerald-950/40 text-emerald-400 border-emerald-500/20',
                                            'Entregado' => 'bg-purple-950/40 text-purple-400 border-purple-500/20',
                                        ];
                                        $statusClass = $statusColors[$managingOrder->status] ?? 'bg-gray-900 text-gray-300 border-gray-700';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold border {{ $statusClass }}">
                                        {{ $managingOrder->status }}
                                    </span>
                                @endif
                            </div>

                            @if(auth()->user()->isAdmin() && $managingOrder->status !== 'Entregado')
                            <!-- Danger Zone: Anular / Eliminar -->
                            <div class="bg-red-950/10 p-4 rounded-2xl border border-red-900/40 space-y-2.5">
                                <span class="text-[10px] font-black text-red-400/70 uppercase tracking-widest block border-b border-red-900/30 pb-2">⚠️ Zona de Peligro</span>

                                {{-- Botón Anular --}}
                                @if($managingOrder->status !== 'Anulada')
                                <button
                                    type="button"
                                    wire:click="cancelWorkOrder({{ $managingOrder->id }})"
                                    wire:confirm="¿Anular esta orden de trabajo? Se cambiará su estado a 'Anulada'. Esta acción es reversible cambiando el estado nuevamente."
                                    class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-amber-950/40 hover:bg-amber-900/60 border border-amber-600/30 text-amber-400 font-bold text-xs transition duration-200 cursor-pointer"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    Anular Orden
                                </button>
                                @else
                                <div class="flex items-center gap-2 py-2 px-3 rounded-xl bg-amber-950/20 border border-amber-700/20">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    <span class="text-xs text-amber-400 font-bold">Orden Anulada</span>
                                </div>
                                @endif

                                {{-- Botón Eliminar Permanentemente --}}
                                <button
                                    type="button"
                                    wire:click="deleteWorkOrder({{ $managingOrder->id }})"
                                    wire:confirm="⚠️ ELIMINAR PERMANENTEMENTE\n\nEsta acción es IRREVERSIBLE. Se eliminará la orden, sus fotos, logs y se devolverá el stock de repuestos. ¿Estás absolutamente seguro?"
                                    class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-red-950/40 hover:bg-red-900/60 border border-red-600/30 text-red-400 font-bold text-xs transition duration-200 cursor-pointer"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Eliminar Permanentemente
                                </button>
                            </div>
                            @endif

                            <!-- Financial Summary Card -->
                            <div class="bg-gray-900/40 p-5 rounded-2xl border border-gray-800 space-y-4">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block border-b border-gray-800 pb-2">Resumen de Caja</span>
                                
                                <div class="space-y-2.5 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Mano de Obra</span>
                                        <span class="text-white font-semibold">${{ number_format($managingOrder->labor_cost, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Repuestos</span>
                                        <span class="text-white font-semibold">${{ number_format($partsCost, 0, ',', '.') }}</span>
                                    </div>
                                    @if($totalCost > 0)
                                        <div class="flex justify-between border-t border-gray-800/50 pt-2 font-bold">
                                            <span class="text-gray-300">Costo Total</span>
                                            <span class="text-white">${{ number_format($totalCost, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between text-emerald-400 font-semibold border-b border-gray-800/50 pb-2">
                                        <span>Abonado</span>
                                        @if($managingOrder->down_payment > 0)
                                            <span>${{ number_format($managingOrder->down_payment, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-gray-500 font-normal">Sin Abono</span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center pt-1">
                                        <span class="text-gray-400 font-semibold">Pendiente</span>
                                        @if($totalCost <= 0)
                                            <span class="px-2.5 py-1 bg-amber-950/40 border border-amber-500/20 text-amber-400 rounded-lg font-black text-sm">
                                                Por Evaluar
                                            </span>
                                        @elseif($balanceDue > 0)
                                            <span class="px-2.5 py-1 bg-red-950/40 border border-red-500/20 text-red-400 rounded-lg font-black text-sm">
                                                ${{ number_format($balanceDue, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 bg-emerald-950/40 border border-emerald-500/20 text-emerald-400 rounded-lg font-black text-sm">
                                                $0 (Pagado)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Device Quick Info Card -->
                            <div class="bg-gray-900/40 p-5 rounded-2xl border border-gray-800 space-y-3.5">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block border-b border-gray-800 pb-2">Ficha del Dispositivo</span>
                                
                                <div class="space-y-3 text-xs">
                                    <div>
                                        <span class="text-[10px] text-gray-500 uppercase tracking-wider block">Equipo</span>
                                        <div class="flex items-center gap-2 flex-wrap mt-0.5">
                                            <span class="text-white font-black text-sm">{{ $managingOrder->brand_model }}</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-blue-950/80 text-blue-300 border border-blue-500/30 shadow-sm">
                                                {{ $managingOrder->device_type_label }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if($managingOrder->imei_serial)
                                        <div>
                                            <span class="text-[10px] text-gray-500 uppercase tracking-wider block">IMEI / Serie</span>
                                            <span class="text-white font-mono font-medium">{{ $managingOrder->imei_serial }}</span>
                                        </div>
                                    @endif

                                    @if($managingOrder->unlock_password)
                                        <div>
                                            <span class="text-[10px] text-gray-500 uppercase tracking-wider block">Clave de Acceso</span>
                                            <span class="text-yellow-400 font-mono font-bold">{{ $managingOrder->unlock_password }}</span>
                                        </div>
                                    @endif

                                    <div>
                                        <span class="text-[10px] text-gray-500 uppercase tracking-wider block">Falla Reportada</span>
                                        <span class="text-gray-300 italic block mt-0.5 bg-gray-950/60 p-2.5 rounded-xl border border-gray-850/80 leading-relaxed">
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
                            <div class="rounded-2xl border p-4 space-y-3
                                {{ $mWarranty['status'] === 'active'
                                    ? 'bg-emerald-950/20 border-emerald-800/40'
                                    : ($mWarranty['status'] === 'expired'
                                        ? 'bg-red-950/20 border-red-800/40'
                                        : 'bg-gray-900/40 border-gray-800') }}">

                                <div class="flex items-center justify-between border-b pb-2
                                    {{ $mWarranty['status'] === 'active' ? 'border-emerald-800/40' : ($mWarranty['status'] === 'expired' ? 'border-red-800/40' : 'border-gray-800') }}">
                                    <span class="text-[10px] font-black uppercase tracking-widest
                                        {{ $mWarranty['status'] === 'active' ? 'text-emerald-400' : ($mWarranty['status'] === 'expired' ? 'text-red-400' : 'text-gray-400') }}">
                                        🛡️ Garantía de Servicio
                                    </span>
                                    @if($mWarranty['status'] === 'active')
                                        <span class="flex items-center gap-1 text-[10px] font-black text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            VIGENTE
                                        </span>
                                    @elseif($mWarranty['status'] === 'expired')
                                        <span class="flex items-center gap-1 text-[10px] font-black text-red-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            VENCIDA
                                        </span>
                                    @else
                                        <span class="text-[10px] font-semibold text-gray-500">Pendiente entrega</span>
                                    @endif
                                </div>

                                <div class="space-y-2 text-xs">
                                    @if($mWarranty['months'] > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Meses de Garantía</span>
                                            <span class="font-bold text-gray-200">{{ $mWarranty['months'] }} mes(es)</span>
                                        </div>
                                    @endif

                                    @if($managingOrder->delivered_at)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Fecha de Entrega</span>
                                            <span class="font-bold text-gray-200">{{ $managingOrder->delivered_at->format('d/m/Y') }}</span>
                                        </div>
                                    @endif

                                    @if($mWarranty['expiry_date'])
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Vencimiento</span>
                                            <span class="font-bold {{ $mWarranty['status'] === 'active' ? 'text-emerald-400' : 'text-red-400' }}">
                                                {{ $mWarranty['expiry_date']->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    @endif

                                    @if($mWarranty['status'] === 'active')
                                        <div class="mt-2 pt-2 border-t border-emerald-800/30">
                                            {{-- Progress bar de días restantes --}}
                                            @php
                                                $totalDays = $mWarranty['months'] * 30;
                                                $daysLeft  = $mWarranty['days_remaining'];
                                                $pct       = min(100, round(($daysLeft / max(1, $totalDays)) * 100));
                                            @endphp
                                            <div class="flex justify-between text-[10px] mb-1">
                                                <span class="text-emerald-500">Tiempo restante</span>
                                                <span class="font-black text-emerald-400">{{ $daysLeft }} días</span>
                                            </div>
                                            <div class="w-full bg-emerald-950/40 rounded-full h-1.5">
                                                <div class="bg-emerald-500 h-1.5 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                                            </div>
                                        </div>
                                    @elseif($mWarranty['status'] === 'expired')
                                        <div class="mt-2 pt-2 border-t border-red-800/30">
                                            <p class="text-[10px] text-red-400/80 leading-relaxed">
                                                La garantía de esta reparación ha expirado el {{ $mWarranty['expiry_date']->format('d/m/Y') }}.
                                            </p>
                                        </div>
                                    @endif

                                    @if($managingOrder->status === 'Entregado' && $mWarranty['status'] === 'active')
                                        <button wire:click="reenterWarranty({{ $managingOrder->id }})" wire:confirm="¿Deseas reingresar este equipo al taller por concepto de garantía? El estado cambiará a Garantía y el equipo volverá a estar activo para los técnicos." class="mt-3 w-full py-2 px-4 bg-emerald-950/40 hover:bg-emerald-900/60 border border-emerald-500/30 text-emerald-400 rounded-xl font-bold text-xs transition duration-200 flex justify-center items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
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
                            <div class="hidden md:flex border-b border-gray-800 gap-1 overflow-x-auto min-w-0 w-full no-scrollbar">
                                <button 
                                    wire:click="$set('activeTab', 'details')" 
                                    class="px-4 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition duration-200 cursor-pointer flex items-center gap-1.5 shrink-0 {{ $activeTab === 'details' ? 'border-blue-500 text-blue-400 bg-blue-500/5 rounded-t-xl' : 'border-transparent text-gray-400 hover:text-white hover:bg-gray-800/30' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    📋 Diagnóstico y Costos
                                </button>
                                <button 
                                    wire:click="$set('activeTab', 'logs')" 
                                    class="px-4 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition duration-200 cursor-pointer flex items-center gap-1.5 shrink-0 {{ $activeTab === 'logs' ? 'border-indigo-500 text-indigo-400 bg-indigo-500/5 rounded-t-xl' : 'border-transparent text-gray-400 hover:text-white hover:bg-gray-800/30' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    💬 Bitácora
                                </button>

                                <button 
                                    wire:click="$set('activeTab', 'share')" 
                                    class="px-4 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition duration-200 cursor-pointer flex items-center gap-1.5 shrink-0 {{ $activeTab === 'share' ? 'border-amber-500 text-amber-400 bg-amber-500/5 rounded-t-xl' : 'border-transparent text-gray-400 hover:text-white hover:bg-gray-800/30' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 10.742l-3.684 2.821 3.684 2.822m8-5.643L21 13.56l-4.316 3.185m-4 1v-7.185"></path></svg>
                                    🔗 Enlaces y WhatsApp
                                </button>
                                <button 
                                    wire:click="$set('activeTab', 'payments')" 
                                    class="px-4 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition duration-200 cursor-pointer flex items-center gap-1.5 shrink-0 {{ $activeTab === 'payments' ? 'border-emerald-500 text-emerald-400 bg-emerald-500/5 rounded-t-xl' : 'border-transparent text-gray-400 hover:text-white hover:bg-gray-800/30' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    💰 Historial de Pagos
                                </button>
                            </div>

                            <!-- Tab Contents -->
                            <div class="flex-1 lg:bg-gray-900/10 rounded-2xl lg:border lg:border-gray-800/60 p-0 sm:p-6 lg:shadow-inner lg:min-h-[350px]">
                                
                                <!-- 1. TAB: DETAILS & DIAGNOSTIC & BUDGETING -->
                                <div x-show="$wire.activeTab === 'details'" class="space-y-6">
                                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                                        <h4 class="text-sm font-black text-white uppercase tracking-wider">📋 Diagnóstico Técnico y Presupuesto</h4>
                                        <span class="text-xs text-gray-500">Manejo de repuestos y cobros</span>
                                    </div>

                                    @if(auth()->user()->hasRole(['admin', 'tecnico']))
                                        @if($managingOrder && $managingOrder->status === 'Aprobado')
                                            <!-- Botón Iniciar Reparación -->
                                            <div class="bg-blue-900/20 border border-blue-800 rounded-xl p-5 mb-5 flex flex-col items-center text-center">
                                                <h5 class="text-blue-400 font-bold mb-2">Presupuesto Aprobado</h5>
                                                <p class="text-gray-400 text-xs mb-4">El cliente ha aprobado el presupuesto. Puedes comenzar con los trabajos técnicos en el equipo.</p>
                                                <button wire:click="startRepair" type="button" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-900/50 transition">
                                                    ▶ Iniciar Reparación
                                                </button>
                                            </div>
                                        @elseif($managingOrder && $managingOrder->status === 'En Reparación')
                                            <!-- Botón Finalizar Reparación -->
                                            <div class="bg-amber-900/20 border border-amber-800 rounded-xl p-5 mb-5 flex flex-col items-center text-center">
                                                <h5 class="text-amber-400 font-bold mb-2">Reparación en Proceso</h5>
                                                <p class="text-gray-400 text-xs mb-4">La reparación está en curso. Una vez termines todas las pruebas y labores técnicas, marca la reparación como finalizada.</p>
                                                <button wire:click="finishRepair" type="button" class="bg-amber-600 hover:bg-amber-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-amber-900/50 transition">
                                                    ✔ Marcar Reparación como Finalizada
                                                </button>
                                            </div>
                                        @endif
                                        <form wire:submit.prevent="saveBudget" class="space-y-5">
                                            
                                            @php
                                                $isLocked = in_array($managingOrder->status, ['Presupuestado', 'Aprobado', 'En Reparación', 'Listo para Entrega', 'Entregado', 'Rechazado']) && !$forceEditBudget;
                                            @endphp
                                            
                                            <!-- PASO 1: Asignar Técnico -->
                                            @if(auth()->user()->isAdmin())
                                            @php
                                                $isDelivered = $managingOrder->status === 'Entregado';
                                            @endphp
                                            <div class="space-y-1.5 p-4 rounded-2xl" style="background:#111827; border:1.5px solid #1f2937;">
                                                <div class="flex justify-between items-center mb-1">
                                                    <label class="block text-xs font-black text-teal-400 uppercase tracking-widest flex items-center gap-1.5">
                                                        <span class="w-5 h-5 rounded-full bg-teal-500/10 border border-teal-500/30 text-teal-400 flex items-center justify-center text-[10px]">1</span>
                                                        Técnico Responsable
                                                    </label>
                                                    @if($isDelivered)
                                                        <span class="text-[10px] font-bold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded-lg flex items-center gap-1">
                                                            🔒 Métrica Congelada al Entregar
                                                        </span>
                                                    @endif
                                                </div>
                                                <select wire:model.live="managingTechnicianId" wire:change="assignTechnician"
                                                    {{ $isDelivered ? 'disabled' : '' }}
                                                    class="w-full rounded-xl py-2.5 px-3 text-white text-xs font-medium focus:outline-none transition {{ $isDelivered ? 'opacity-60 cursor-not-allowed' : 'cursor-pointer' }}"
                                                    style="background:#0d1117; border:1px solid #1f2937;">
                                                    <option value="">-- Sin Asignar --</option>
                                                    @foreach($technicians as $tech)
                                                        <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                                    @endforeach
                                                </select>

                                                @if($isDelivered)
                                                    <p class="text-[10px] text-amber-400/80 mt-1">
                                                        No se puede cambiar el técnico asignado a una orden en estado Entregado (métrica fija para reportes y comisiones).
                                                    </p>
                                                @else
                                                    <p class="text-[10px] text-gray-500 mt-1">Se guarda automáticamente al seleccionar.</p>
                                                @endif
                                            </div>
                                            @endif



                                            <!-- PASO 2: Diagnostic Notes -->
                                            <div class="space-y-1.5 p-4 rounded-2xl" style="background:#111827; border:1.5px solid #1f2937;">
                                                <div class="flex justify-between items-center mb-1">
                                                    <label class="block text-xs font-black text-teal-400 uppercase tracking-widest flex items-center gap-1.5">
                                                        <span class="w-5 h-5 rounded-full bg-teal-500/10 border border-teal-500/30 text-teal-400 flex items-center justify-center text-[10px]">2</span>
                                                        Diagnóstico Técnico del Dispositivo *
                                                    </label>
                                                    @if($isLocked && $managingOrder->status === 'Presupuestado')
                                                        <button type="button" wire:click="unlockBudgetEditing" class="text-[10px] text-amber-400 hover:text-amber-300 font-bold px-2 py-1 border border-amber-500/30 rounded-lg bg-amber-950/30 transition">
                                                            ✏️ Desbloquear Edición
                                                        </button>
                                                    @endif
                                                </div>
                                                <textarea 
                                                    wire:model="editingDiagnosticNotes" 
                                                    rows="3" 
                                                    {{ $isLocked ? 'disabled' : '' }}
                                                    class="w-full rounded-xl p-3 text-white placeholder-gray-600 focus:outline-none transition text-xs leading-relaxed {{ $isLocked ? 'opacity-70 cursor-not-allowed' : '' }}"
                                                    style="background:#0d1117; border:1px solid #1f2937;"
                                                    placeholder="Describe en detalle la falla encontrada, repuestos requeridos y la solución técnica..."
                                                    required
                                                ></textarea>
                                                @error('editingDiagnosticNotes') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- PASO 3: Parts Search and Catalog -->
                                            @if(!$isLocked)
                                            <div class="space-y-1.5 p-4 rounded-2xl relative" style="background:#111827; border:1.5px solid #1f2937;">
                                                <label class="block text-xs font-black text-teal-400 uppercase tracking-widest flex items-center gap-1.5 mb-1">
                                                    <span class="w-5 h-5 rounded-full bg-teal-500/10 border border-teal-500/30 text-teal-400 flex items-center justify-center text-[10px]">3</span>
                                                    Añadir Repuestos del Inventario
                                                </label>
                                                <div class="relative">
                                                    <input 
                                                        type="text" 
                                                        wire:model.live.debounce.150ms="editingSearchPart" 
                                                        class="w-full rounded-xl py-2.5 px-3.5 text-white placeholder-gray-600 focus:outline-none transition text-xs font-medium"
                                                        style="background:#0d1117; border:1px solid #1f2937;"
                                                        placeholder="Buscar repuesto por nombre o categoría..."
                                                        autocomplete="off"
                                                        onfocus="this.style.borderColor='#00C6B6';"
                                                        onblur="this.style.borderColor='#1f2937';"
                                                    >

                                                    @if(strlen($editingSearchPart) > 0 && count($editingFoundParts) === 0)
                                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                                            <svg class="w-3.5 h-3.5 animate-spin text-gray-500" fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if(count($editingFoundParts) > 0)
                                                    <div class="absolute z-30 w-full left-0 right-0 mt-1 overflow-hidden rounded-xl shadow-2xl"
                                                        style="background:#0d1117; border:1.5px solid #1f2937;">
                                                        <div class="px-3 py-1.5 flex items-center justify-between border-b border-gray-800">
                                                            <span class="text-[10px] font-bold text-gray-500 uppercase">
                                                                {{ count($editingFoundParts) }} repuesto(s) encontrado(s)
                                                            </span>
                                                            <span class="text-[9.5px] text-gray-600">Clic para añadir</span>
                                                        </div>
                                                        <ul class="max-h-48 overflow-y-auto custom-scrollbar">
                                                            @foreach($editingFoundParts as $part)
                                                                <li wire:click="addEditingPart({{ $part->id }})"
                                                                    class="flex items-center justify-between gap-3 p-3 cursor-pointer border-b border-gray-800/80 last:border-0 hover:bg-gray-800/60 transition group text-xs">
                                                                    <div class="flex items-center gap-2.5 min-w-0">
                                                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0"
                                                                            style="background:rgba(0,198,182,.08); border:1px solid rgba(0,198,182,.15);">
                                                                            <svg class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="min-w-0">
                                                                            <div class="font-bold text-white leading-tight truncate">{{ $part->name }}</div>
                                                                            <div class="text-[10px] text-gray-500 mt-0.5">
                                                                                <span>{{ $part->category }}</span>
                                                                                <span>•</span>
                                                                                @if($part->stock <= 0)
                                                                                    <span class="text-red-400 font-bold">Sin Stock</span>
                                                                                @elseif($part->stock < 5)
                                                                                    <span class="text-amber-400 font-bold">Stock Bajo: {{ $part->stock }}</span>
                                                                                @else
                                                                                    <span>Stock: {{ $part->stock }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex items-center gap-2 shrink-0">
                                                                        <span class="font-mono font-bold text-emerald-400 text-xs">
                                                                            ${{ number_format($part->sale_price, 0, ',', '.') }}
                                                                        </span>
                                                                        <span class="text-[9.5px] font-bold px-2 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity"
                                                                            style="background:rgba(0,198,182,.1); color:#2dd4bf; border:1px solid rgba(0,198,182,.2);">
                                                                            + Añadir
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            @endif

                                            <!-- Added Parts Grid/List -->
                                            @if(count($editingSelectedParts) > 0)
                                                <div class="bg-gray-900/50 p-4 rounded-2xl border border-gray-800 space-y-2.5">
                                                    <h5 class="text-xs font-black text-white uppercase tracking-widest mb-2 border-b border-gray-800 pb-1.5">Repuestos Cargados al Servicio</h5>
                                                    <div class="space-y-2 max-h-40 overflow-y-auto pr-1 custom-scrollbar">
                                                        @foreach($editingSelectedParts as $index => $part)
                                                            <div class="flex justify-between items-center text-xs py-1.5 border-b border-gray-800/60 last:border-0">
                                                                <div class="flex flex-col">
                                                                    <span class="text-white font-semibold">{{ $part['name'] }}</span>
                                                                    <span class="text-[10px] text-gray-500">Cantidad: {{ $part['quantity'] }}</span>
                                                                </div>
                                                                <div class="flex items-center gap-3">
                                                                    <span class="text-gray-300 font-bold">${{ number_format($part['sale_price'], 0, ',', '.') }}</span>
                                                                    @if(!$isLocked)
                                                                    <button type="button" wire:click="removeEditingPart({{ $index }})" class="text-red-400 hover:text-red-300 transition cursor-pointer p-1 hover:bg-red-950/20 rounded-lg border border-transparent hover:border-red-500/10">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                    </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            <!-- 📸 FOTOS DE INGRESO DEL EQUIPO -->
                                            @if($managingOrder->images && $managingOrder->images->count() > 0)
                                            <div class="bg-gray-900/50 p-3 sm:p-4 rounded-2xl border border-blue-900/40 space-y-2.5 min-w-0">
                                                <div class="flex items-center gap-2 border-b border-gray-800 pb-2">
                                                    <span class="text-xs font-black text-blue-400 uppercase tracking-widest flex items-center gap-1.5">
                                                        📸 Fotos de Ingreso del Equipo
                                                    </span>
                                                    <span class="ml-auto px-2 py-0.5 bg-blue-950/60 text-blue-400 text-[9px] font-black uppercase rounded-full border border-blue-800/40">{{ $managingOrder->images->count() }} foto(s)</span>
                                                </div>
                                                <div class="flex flex-wrap gap-2.5">
                                                    @foreach($managingOrder->images as $img)
                                                        <div 
                                                            onclick="openGlobalLightbox('{{ asset('storage/' . $img->image_path) }}')"
                                                            class="relative w-20 h-20 shrink-0 aspect-square rounded-xl overflow-hidden border border-blue-800/40 bg-gray-950 cursor-pointer group shadow hover:scale-105 transition active:scale-95"
                                                            title="Clic para ampliar foto"
                                                        >
                                                            <img 
                                                                src="{{ asset('storage/' . $img->image_path) }}" 
                                                                loading="lazy"
                                                                class="w-full h-full object-cover group-hover:opacity-80 transition"
                                                                onerror="this.onerror=null; this.src='/images/logo-dark.png';"
                                                                alt="Foto de ingreso"
                                                            >
                                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/50">
                                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <p class="text-[10px] text-gray-500 italic">Miniaturas compactas. Toca cualquier foto para verla en pantalla completa con zoom.</p>
                                            </div>
                                            @endif

                                            <!-- PASO 4: Costs Editor Grid -->

                                            <div class="p-4 rounded-2xl space-y-3" style="background:#111827; border:1.5px solid #1f2937;">
                                                <label class="block text-xs font-black text-teal-400 uppercase tracking-widest flex items-center gap-1.5">
                                                    <span class="w-5 h-5 rounded-full bg-teal-500/10 border border-teal-500/30 text-teal-400 flex items-center justify-center text-[10px]">4</span>
                                                    Mano de Obra y Presupuesto Final
                                                </label>

                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                                                    <div class="space-y-1.5">
                                                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Costo Mano de Obra ($) *</label>
                                                        <input 
                                                            type="number" 
                                                            wire:model.live="editingLaborCost" 
                                                            {{ $isLocked ? 'disabled' : '' }}
                                                            class="w-full rounded-xl p-3 text-white focus:outline-none transition text-xs font-bold {{ $isLocked ? 'opacity-70 cursor-not-allowed' : '' }}"
                                                            style="background:#0d1117; border:1px solid #1f2937;"
                                                            required
                                                        >
                                                        @error('editingLaborCost') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="space-y-1.5">
                                                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Fecha Est. Entrega (Calendario)</label>
                                                        <input 
                                                            type="date" 
                                                            wire:model="editingEstimatedDelivery" 
                                                            {{ $isLocked ? 'disabled' : '' }}
                                                            class="w-full rounded-xl p-3 text-white focus:outline-none transition text-xs font-bold {{ $isLocked ? 'opacity-70 cursor-not-allowed' : '' }}"
                                                            style="background:#0d1117; border:1px solid #1f2937; color-scheme: dark;"
                                                        >
                                                        @error('editingEstimatedDelivery') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                                    </div>

                                                    <!-- Instant Estimated Total display -->
                                                    @php
                                                        $tempPartsCost = collect($editingSelectedParts)->sum(function($p) {
                                                            return $p['sale_price'] * $p['quantity'];
                                                        });
                                                        $tempTotal = (float)$editingLaborCost + $tempPartsCost;
                                                    @endphp
                                                    <div class="rounded-xl p-3 flex flex-col justify-between h-[64px]"
                                                        style="background:rgba(0,198,182,.08); border:1px solid rgba(0,198,182,.2);">
                                                        <span class="text-[9px] font-black uppercase tracking-widest text-teal-400">Total Presupuestado</span>
                                                        <span class="text-lg font-black text-emerald-400 mt-1">${{ number_format($tempTotal, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(!$isLocked)
                                            <div class="flex justify-end pt-4 border-t border-gray-800">
                                                <button type="submit" 
                                                    class="py-3.5 px-7 rounded-2xl text-white font-bold text-xs shadow-xl transition cursor-pointer flex items-center gap-2 hover:opacity-90 active:scale-95"
                                                    style="background: linear-gradient(135deg, #00C6B6 0%, #2563eb 100%);">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
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
                                                <span class="text-gray-500 font-bold uppercase tracking-wider block">Diagnóstico Técnico</span>
                                                <p class="text-gray-200 mt-1 leading-relaxed whitespace-pre-line bg-gray-900/60 p-3.5 rounded-xl border border-gray-800">
                                                    {{ $editingDiagnosticNotes ?: 'No se ha registrado diagnóstico técnico aún.' }}
                                                </p>
                                            </div>

                                            <div>
                                                <span class="text-gray-500 font-bold uppercase tracking-wider block mb-2">Repuestos Asignados</span>
                                                @if(count($managingOrder->parts) > 0)
                                                    <div class="bg-gray-900/40 rounded-xl border border-gray-800 divide-y divide-gray-850 p-2.5">
                                                        @foreach($managingOrder->parts as $part)
                                                            <div class="flex justify-between py-1.5 text-xs px-2">
                                                                <span class="text-gray-300 font-medium">{{ $part->name }} (x{{ $part->pivot->quantity }})</span>
                                                                <span class="text-white font-semibold">${{ number_format($part->pivot->price_at_time, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-gray-500 italic">No hay repuestos cargados a esta orden.</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 2. TAB: LOGS / BITACORA -->
                                <div x-show="$wire.activeTab === 'logs'" class="space-y-6">
                                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                                        <h4 class="text-sm font-black text-white uppercase tracking-wider">💬 Bitácora y Registro de Avances</h4>
                                        <span class="text-xs text-gray-500">Hitos del estado del servicio</span>
                                    </div>

                                    @if(in_array($managingOrder->status, ['Listo para Entrega', 'Entregado', 'Anulada']))
                                         <!-- Bitácora congelada para órdenes finalizadas -->
                                         <div class="bg-gray-900/60 border border-gray-800 p-5 rounded-2xl text-center space-y-2">
                                             <div class="flex items-center justify-center gap-2 text-amber-400 font-bold text-xs uppercase tracking-wider">
                                                 <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                 <span>Bitácora Congelada ({{ $managingOrder->status }})</span>
                                             </div>
                                             <p class="text-xs text-gray-400 max-w-md mx-auto leading-relaxed">
                                                 El equipo se encuentra en estado <strong class="text-white font-bold">{{ $managingOrder->status }}</strong>. La labor técnica ha finalizado y la bitácora ha sido bloqueada para evitar nuevos ingresos.
                                             </p>
                                         </div>
                                     @else
                                         <!-- Formulario de nuevo avance con soporte de múltiples fotos -->
                                         <form wire:submit.prevent="saveManualLog" class="bg-gray-900/50 p-3 md:p-4 rounded-2xl border border-gray-800 space-y-3 md:space-y-4">
                                             <span class="text-xs font-black text-white uppercase tracking-wider block border-b border-gray-800 pb-1.5 flex items-center gap-1.5">
                                                 <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                 <span class="hidden sm:inline">Registrar Nuevo Hito en la Bitácora</span>
                                                 <span class="sm:hidden">Nuevo Avance</span>
                                             </span>
                                             
                                             <!-- Quick Title Chips -->
                                             <div class="space-y-1.5">
                                                 <label class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Título del Hito *</label>
                                                 <div class="flex flex-wrap gap-1.5 mb-2" x-data>
                                                     @foreach(['Avance Técnico', 'Cambio de Pieza', 'Prueba Realizada', 'Diagnóstico', 'Nota Interna'] as $chip)
                                                         <button 
                                                             type="button" 
                                                             wire:click="$set('newLogTitle', '{{ $chip }}')"
                                                             class="px-3 py-1.5 rounded-lg text-[11px] font-bold border transition active:scale-95 {{ $newLogTitle === $chip ? 'bg-indigo-600 text-white border-indigo-500' : 'bg-gray-900 text-gray-400 border-gray-700 hover:text-white' }}"
                                                         >{{ $chip }}</button>
                                                     @endforeach
                                                 </div>
                                                 <input 
                                                     type="text" 
                                                     wire:model="newLogTitle" 
                                                     class="w-full bg-gray-950 border border-gray-700 rounded-xl p-2.5 text-white focus:outline-none focus:border-indigo-500 text-xs font-bold"
                                                     placeholder="O escribe un título personalizado..."
                                                     required
                                                 >
                                             </div>
                                             
                                             <!-- Notes -->
                                             <div class="space-y-1.5">
                                                 <label class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Detalle / Notas *</label>
                                                 <textarea 
                                                     wire:model="newLogNotes" 
                                                     rows="3" 
                                                     class="w-full bg-gray-950 border border-gray-700 rounded-xl p-3 text-white focus:outline-none focus:border-indigo-500 text-sm leading-relaxed" 
                                                     placeholder="Describe el estado o labores realizadas..."
                                                     required
                                                 ></textarea>
                                                 @error('newLogNotes') <span class="text-red-400 text-xs block font-bold mt-1">{{ $message }}</span> @enderror
                                             </div>

                                             <!-- Photo Attachment - Multiple Photos Supported -->
                                             <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between pt-1">
                                                 <!-- Camera capture button / file input -->
                                                 <div class="w-full sm:w-auto">
                                                     <label class="md:hidden flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-xl cursor-pointer transition active:scale-95 border border-gray-700">
                                                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                         📸 Adjuntar / Tomar Fotos
                                                         <input type="file" multiple @change="compressAndUploadMultiplePhotos($event, 'newLogPhotos', $wire)" accept="image/*" class="hidden">
                                                     </label>
                                                     <div class="hidden md:flex items-center gap-3">
                                                         <label class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider shrink-0">Adjuntar Foto(s):</label>
                                                         <input 
                                                             type="file" 
                                                             multiple
                                                             @change="compressAndUploadMultiplePhotos($event, 'newLogPhotos', $wire)" 
                                                             accept="image/*"
                                                             class="text-xs text-gray-400 focus:outline-none file:mr-2 file:py-1.5 file:px-2.5 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-gray-800 file:text-white file:cursor-pointer"
                                                         >
                                                     </div>
                                                     @error('newLogPhotos.*') <span class="text-red-400 text-xs block mt-1">{{ $message }}</span> @enderror
                                                     @error('newLogPhoto') <span class="text-red-400 text-xs block mt-1">{{ $message }}</span> @enderror
                                                 </div>

                                                 <button type="submit" wire:loading.attr="disabled" wire:target="newLogPhotos, newLogPhoto, saveManualLog" class="w-full sm:w-auto py-3 sm:py-2.5 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm sm:text-xs shadow-md shadow-indigo-500/25 transition cursor-pointer flex justify-center items-center shrink-0 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                                                     ✅ Registrar Avance
                                                 </button>
                                             </div>

                                             <!-- Preview and loading -->
                                             <div wire:loading wire:target="newLogPhotos, newLogPhoto" class="text-xs text-blue-400 font-semibold flex items-center gap-1.5">
                                                 <svg class="animate-spin h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                 Procesando y cargando fotos adjuntas...
                                             </div>

                                             <!-- Gallery preview list of attached photos -->
                                             @if(count($newLogPhotos) > 0)
                                                 <div class="space-y-2 bg-gray-955 p-3 rounded-xl border border-gray-850">
                                                     <div class="flex items-center justify-between text-xs font-bold text-gray-300">
                                                         <span>📷 Fotos Adjuntas ({{ count($newLogPhotos) }})</span>
                                                         <button type="button" wire:click="$set('newLogPhotos', [])" class="text-red-400 hover:underline text-[10px] font-bold">
                                                             Quitar todas
                                                         </button>
                                                     </div>
                                                     <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                                         @foreach($newLogPhotos as $idx => $photo)
                                                             <div class="relative group aspect-square rounded-xl overflow-hidden border border-gray-700 bg-gray-900 shadow">
                                                                 <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                                                 <button type="button" 
                                                                         wire:click="removeNewLogPhoto({{ $idx }})" 
                                                                         class="absolute top-1 right-1 bg-red-600/90 text-white rounded-full p-1 hover:bg-red-500 transition shadow"
                                                                         title="Eliminar esta foto">
                                                                     <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                 </button>
                                                             </div>
                                                         @endforeach
                                                     </div>
                                                 </div>
                                             @elseif($newLogPhoto)
                                                 <div class="flex items-center justify-between bg-gray-955 p-2.5 rounded-xl border border-gray-850">
                                                     <div class="flex items-center gap-3">
                                                         <img src="{{ $newLogPhoto->temporaryUrl() }}" class="w-14 h-14 object-cover rounded-lg border border-gray-800">
                                                         <div>
                                                             <div class="text-xs font-bold text-white">Foto adjunta lista</div>
                                                             <div class="text-[10px] text-gray-400">Se incluirá en este registro de bitácora.</div>
                                                         </div>
                                                     </div>
                                                     <button type="button" 
                                                             wire:click="$set('newLogPhoto', null)" 
                                                             class="px-3 py-1.5 bg-red-950/60 hover:bg-red-900 border border-red-700/60 text-red-300 hover:text-white rounded-lg text-xs font-bold transition duration-150 cursor-pointer flex items-center gap-1.5 shrink-0"
                                                             title="Quitar esta foto">
                                                         <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                         </svg>
                                                         Quitar foto
                                                     </button>
                                                 </div>
                                             @endif
                                         </form>
                                     @endif
 
                                    <!-- Vertical Timeline -->
                                    <div class="space-y-4">
                                        <span class="text-xs font-black text-gray-400 uppercase tracking-widest block border-b border-gray-800 pb-1.5">Historial de Eventos</span>
                                        
                                        @if(count($managingOrder->logs) > 0)
                                            <div class="relative pl-5 border-l-2 border-gray-800 space-y-5">
                                                @foreach($managingOrder->logs as $log)
                                                    <div class="relative">
                                                        <!-- Bullet node point -->
                                                        <span class="absolute -left-[27px] mt-1 bg-gray-900 border-2 border-indigo-500 w-3.5 h-3.5 rounded-full flex items-center justify-center"></span>
                                                        
                                                        <div class="space-y-1.5">
                                                            <div class="flex items-center gap-2.5">
                                                                <span class="font-bold text-white text-xs">{{ $log->title }}</span>
                                                                <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider bg-gray-800 text-gray-300 border border-gray-700/60">{{ $log->status }}</span>
                                                                <span class="text-[9px] text-gray-500">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                                                            </div>
                                                            <p class="text-xs text-gray-400 leading-relaxed whitespace-pre-wrap">{{ $log->notes }}</p>
                                                            
                                                            @if($log->image_path)
                                                                <div 
                                                                    onclick="openGlobalLightbox('{{ asset('storage/' . $log->image_path) }}')"
                                                                    class="mt-2.5 relative inline-block group max-w-[240px] rounded-2xl overflow-hidden border border-indigo-700/60 shadow-lg bg-gray-950 cursor-pointer active:scale-95 transition"
                                                                >
                                                                    <img 
                                                                        src="{{ asset('storage/' . $log->image_path) }}" 
                                                                        loading="lazy" 
                                                                        class="w-full max-h-48 object-cover group-hover:scale-105 transition duration-300 rounded-2xl"
                                                                        onerror="this.onerror=null; this.src='/images/logo-dark.png';"
                                                                        alt="Evidencia técnica"
                                                                    >
                                                                    <span class="absolute bottom-2 right-2 px-2 py-1 rounded-lg text-[9px] font-black uppercase bg-gray-900/90 text-gray-100 border border-gray-700/80 pointer-events-none flex items-center gap-1 shadow-md">
                                                                        🔍 Ampliar
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            
                                                            @if($log->user)
                                                                <span class="text-[9px] text-indigo-400/80 font-semibold block pt-0.5">Registrado por: {{ $log->user->name }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-xs text-gray-500 italic py-2">No se han registrado hitos históricos en la bitácora aún.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- 4. TAB: SHARING & LINKS -->
                                <div x-show="$wire.activeTab === 'share'" class="space-y-6">
                                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                                        <h4 class="text-sm font-black text-white uppercase tracking-wider">🔗 Enlaces de Seguimiento y Compartición</h4>
                                        <span class="text-xs text-gray-500">Canales de comunicación</span>
                                    </div>

                                    <div class="bg-gray-900/50 p-5 rounded-2xl border border-gray-800 space-y-4">
                                        <span class="text-xs font-black text-white uppercase tracking-wider block">Expediente Público para el Cliente</span>
                                        
                                        <p class="text-xs text-gray-400 leading-relaxed">
                                            Tus clientes pueden revisar el estado actual de su dispositivo, ver el presupuesto y la bitácora técnica con fotos en tiempo real ingresando a su portal de seguimiento en vivo con este enlace único.
                                        </p>

                                        <div class="flex flex-col sm:flex-row gap-3 items-center">
                                            <div class="w-full bg-gray-950 p-3 rounded-xl border border-gray-855 font-mono text-xs text-blue-400 select-all break-all">
                                                {{ url('/seguimiento/' . $managingOrder->uuid) }}
                                            </div>
                                            
                                            <button 
                                                x-data="{ copied: false }" 
                                                @click="
                                                    navigator.clipboard.writeText('{{ url('/seguimiento/' . $managingOrder->uuid) }}');
                                                    copied = true;
                                                    setTimeout(() => copied = false, 2000);
                                                " 
                                                class="w-full sm:w-auto shrink-0 py-3 px-5 rounded-xl bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs border border-gray-700 transition flex items-center justify-center gap-2 cursor-pointer"
                                            >
                                                <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                <svg x-show="copied" class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
                                        <div class="bg-gradient-to-r from-emerald-950/20 to-teal-950/10 p-5 rounded-2xl border border-emerald-500/20 space-y-4 shadow-lg shadow-emerald-950/5 relative overflow-hidden flex flex-col justify-between">
                                            <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl pointer-events-none"></div>
                                            
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c-.001 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                    </svg>
                                                    <span class="text-xs font-black text-emerald-400 uppercase tracking-wider">Notificación WhatsApp</span>
                                                </div>
                                                
                                                <p class="text-[11px] text-gray-400 leading-normal">
                                                    Envía de forma automatizada un mensaje formal pre-configurado para mantener al cliente informado del estado actual de su servicio.
                                                </p>
                                            </div>

                                            <a 
                                                href="https://wa.me/{{ $phone }}?text={{ urlencode($statusText) }}"
                                                target="_blank"
                                                class="w-full py-3 px-4 rounded-xl bg-emerald-650 hover:bg-emerald-600 text-white text-xs font-black transition flex items-center justify-center gap-1.5 shadow-md shadow-emerald-500/10 cursor-pointer"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                                Notificar por WhatsApp
                                            </a>
                                        </div>

                                        <!-- Dynamic Preview Card -->
                                        <div class="bg-gray-900/30 p-5 rounded-2xl border border-gray-800 space-y-2.5 flex flex-col justify-between">
                                            <span class="text-[10px] text-gray-500 uppercase tracking-wider block font-bold">Vista Previa Mensaje ({{ $managingOrder->status }})</span>
                                            
                                            <div class="bg-gray-955 p-3 rounded-xl border border-gray-850 text-[10px] text-gray-400 font-mono leading-relaxed select-all flex-1 min-h-[90px] max-h-28 overflow-y-auto theme-scrollbar">
                                                {{ $statusText }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 5. TAB: PAYMENTS (HISTORIAL DE PAGOS) -->
                                <div x-show="$wire.activeTab === 'payments'" class="space-y-6">
                                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                                        <h4 class="text-sm font-black text-white uppercase tracking-wider">💰 Historial de Pagos</h4>
                                        <span class="text-xs text-gray-500">Manejo de abonos y saldos</span>
                                    </div>
                                    
                                    @if (session()->has('error'))
                                        <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-xl relative" role="alert">
                                            <span class="block sm:inline font-bold text-xs">{{ session('error') }}</span>
                                        </div>
                                    @endif
                                    
                                    @if (session()->has('message'))
                                        <div class="bg-emerald-900/50 border border-emerald-500 text-emerald-200 px-4 py-3 rounded-xl relative" role="alert">
                                            <span class="block sm:inline font-bold text-xs">{{ session('message') }}</span>
                                        </div>
                                    @endif

                                    <!-- Pagos Existentes -->
                                    <div class="space-y-4">
                                        <h5 class="text-xs font-black text-white uppercase tracking-wider">Pagos Registrados</h5>
                                        @forelse($managingOrder->payments as $payment)
                                            <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-800 flex justify-between items-center">
                                                <div>
                                                    <div class="text-sm font-bold text-white">{{ $payment->description }}</div>
                                                    <div class="text-[10px] text-gray-500 mt-1 flex items-center justify-between">
                                                        <span>{{ $payment->created_at->format('d/m/Y H:i') }} • {{ $payment->payment_method }} • {{ $payment->user->name ?? 'Sistema' }}</span>
                                                        <a href="/ot/{{ $managingOrder->id }}/print-payment/{{ $payment->id }}" target="_blank" class="ml-2 px-2 py-1 bg-gray-800 hover:bg-gray-700 text-gray-300 border border-gray-700 rounded-md text-[10px] font-bold transition">
                                                            🖨️ Imprimir Boleta
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="text-emerald-400 font-black text-base">
                                                    +${{ number_format($payment->amount, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @empty
                                            <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-800 text-center text-xs text-gray-500">
                                                No hay pagos registrados para esta orden.
                                            </div>
                                        @endforelse
                                    </div>

                                    <!-- Saldo Pendiente -->
                                    <div class="bg-blue-950/20 border border-blue-500/20 p-4 rounded-xl flex justify-between items-center">
                                        <span class="text-sm font-bold text-blue-400">Saldo Pendiente:</span>
                                        <span class="text-lg font-black text-white">${{ number_format($balanceDue, 0, ',', '.') }}</span>
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
                                     }" class="bg-gray-900/60 border border-gray-700/50 p-4 rounded-2xl space-y-3">
                                         <div class="flex items-center justify-between">
                                             <h5 class="text-xs font-black text-white uppercase tracking-wider">💳 Registrar Pago Rápido</h5>
                                             <span class="text-[10px] font-bold text-emerald-400 bg-emerald-950/60 px-2 py-0.5 rounded-md border border-emerald-500/30">Auto-Validado</span>
                                         </div>
                                         <p class="text-[10px] text-gray-500">Registra un abono o pago anticipado directamente desde aquí sin ir al POS.</p>

                                         <!-- Botones de Selección Rápida de Monto -->
                                         <div class="flex flex-wrap items-center gap-1.5 pt-1">
                                             <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mr-1">Sugeridos:</span>
                                             <button type="button" @click="setAmount(maxBalance)" class="px-2.5 py-1 bg-emerald-950/60 hover:bg-emerald-900/80 border border-emerald-500/40 text-emerald-300 rounded-lg text-[10px] font-bold transition flex items-center gap-1 cursor-pointer active:scale-95">
                                                 💰 Todo (${{ number_format($balanceDue, 0, ',', '.') }})
                                             </button>
                                             @if($balanceDue > 1000)
                                                 <button type="button" @click="setAmount(Math.round(maxBalance / 2))" class="px-2.5 py-1 bg-blue-950/60 hover:bg-blue-900/80 border border-blue-500/40 text-blue-300 rounded-lg text-[10px] font-bold transition flex items-center gap-1 cursor-pointer active:scale-95">
                                                     🌓 50% (${{ number_format(round($balanceDue / 2), 0, ',', '.') }})
                                                 </button>
                                             @endif
                                         </div>

                                         <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                             <div>
                                                 <label class="block text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">Monto a Cobrar</label>
                                                 <input
                                                     type="text"
                                                     x-model="formatted"
                                                     @input="onInput($event)"
                                                     placeholder="$ 0"
                                                     :class="{
                                                         'border-red-500 text-red-300 bg-red-950/30 focus:border-red-500': rawAmount > maxBalance,
                                                         'border-emerald-500 text-emerald-300 bg-emerald-950/20 focus:border-emerald-500': rawAmount > 0 && rawAmount <= maxBalance,
                                                         'border-gray-700 text-white bg-gray-800 focus:border-emerald-500': !rawAmount || rawAmount <= 0
                                                     }"
                                                     class="w-full rounded-xl py-2.5 px-3 font-mono text-sm font-black focus:outline-none transition"
                                                 >
                                             </div>
                                             <div>
                                                 <label class="block text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">Método de Pago</label>
                                                 <select wire:model="newPaymentMethod" class="w-full bg-gray-800 border border-gray-700 rounded-xl py-2.5 px-3 text-white text-xs focus:outline-none focus:border-emerald-500 transition">
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
                                             <div class="bg-red-950/80 border border-red-500/80 text-red-200 p-3 rounded-xl text-xs space-y-1 animate-pulse">
                                                 <div class="font-bold flex items-center gap-1.5 text-red-300">
                                                     <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                     <span>⚠️ ¡ALERTA DE DIGITACIÓN!</span>
                                                 </div>
                                                 <p class="text-[11px] leading-tight text-red-200">
                                                     El monto digitado <strong x-text="formatted" class="underline text-white"></strong> es <strong class="text-white">SUPERIOR</strong> al saldo pendiente (<strong class="text-white">${{ number_format($balanceDue, 0, ',', '.') }}</strong>).
                                                     Verifica si agregaste ceros demás por error.
                                                 </p>
                                             </div>
                                         </template>

                                         @error('newPaymentAmount') 
                                             <span class="text-red-400 text-xs font-bold block bg-red-950/40 p-2.5 rounded-xl border border-red-500/30">
                                                 {{ $message }}
                                             </span> 
                                         @enderror

                                         <div>
                                             <label class="block text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">Descripción / Glosa</label>
                                             <input
                                                 type="text"
                                                 wire:model="newPaymentDescription"
                                                 placeholder="Abono Parcial"
                                                 class="w-full bg-gray-800 border border-gray-700 rounded-xl py-2 px-3 text-white text-xs focus:outline-none focus:border-emerald-500 transition"
                                             />
                                         </div>

                                         {{-- Checkbox: Pago anticipado sin bitácora --}}
                                         <label class="flex items-center gap-3 bg-amber-950/20 border border-amber-700/30 rounded-xl p-3 cursor-pointer hover:bg-amber-950/30 transition">
                                             <input
                                                 type="checkbox"
                                                 wire:model="skipLogOnPayment"
                                                 class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-amber-500 focus:ring-amber-500 focus:ring-1 cursor-pointer"
                                             />
                                             <div>
                                                 <span class="text-xs font-bold text-amber-400 block">Pago anticipado (no registrar en bitácora)</span>
                                                 <span class="text-[10px] text-gray-500">El cliente paga antes de iniciar la reparación. No se generará entrada en la bitácora.</span>
                                             </div>
                                         </label>

                                         <button
                                             type="button"
                                             wire:click="addPayment"
                                             :disabled="rawAmount > maxBalance"
                                             :class="{
                                                 'opacity-50 cursor-not-allowed bg-gray-700': rawAmount > maxBalance,
                                                 'bg-emerald-600 hover:bg-emerald-500 cursor-pointer shadow-lg shadow-emerald-500/10 active:scale-95': rawAmount <= maxBalance
                                             }"
                                             class="w-full text-white font-bold py-3 px-4 rounded-xl text-xs transition duration-200 flex items-center justify-center gap-2"
                                         >
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                             <span>Registrar Pago (<span x-text="formatted"></span>)</span>
                                         </button>
                                     </div>
                                    @endif

                                    <!-- Ir al POS para factura completa -->
                                    <div class="bg-gray-850 p-4 rounded-2xl border border-gray-700 space-y-3 text-center">
                                        <h5 class="text-xs font-black text-blue-400 uppercase tracking-wider">🖨️ Facturación y POS</h5>
                                        <p class="text-[11px] text-gray-400">Para emitir boletas, facturas o registrar pagos con múltiples métodos, dirígete al módulo de Punto de Venta (POS).</p>
                                        <a href="/pos?ot_id={{ $managingOrder->id }}" class="inline-flex items-center justify-center gap-2 w-full bg-blue-700 hover:bg-blue-600 text-white font-bold py-2.5 px-6 rounded-xl text-xs transition duration-200 cursor-pointer shadow">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            PAGAR / FACTURAR EN POS
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Desktop Footer actions (hidden on mobile) -->
                    <div class="hidden md:flex bg-gray-900/60 p-4 px-6 border-t border-gray-800 justify-end items-center shrink-0 w-full">
                        <button type="button" wire:click="closeManagingModal" class="py-2.5 px-6 rounded-xl bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-200 hover:text-white font-bold text-xs transition cursor-pointer shadow flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Cerrar Panel de Gestión
                        </button>
                    </div>

                    <!-- Mobile Bottom Navigation Bar (P2) -->
                    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-gray-900 border-t border-gray-800 z-50 safe-area-bottom shrink-0">
                        <div class="grid grid-cols-4 h-16">
                            <button 
                                wire:click="$set('activeTab', 'details')" 
                                class="flex flex-col items-center justify-center gap-0.5 transition {{ $activeTab === 'details' ? 'text-blue-400 bg-blue-500/10' : 'text-gray-500' }}"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span class="text-[9px] font-bold">Costos</span>
                            </button>
                            <button 
                                wire:click="$set('activeTab', 'logs')" 
                                class="flex flex-col items-center justify-center gap-0.5 transition {{ $activeTab === 'logs' ? 'text-indigo-400 bg-indigo-500/10' : 'text-gray-500' }}"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <span class="text-[9px] font-bold">Bitácora</span>
                            </button>
                            <button 
                                wire:click="$set('activeTab', 'share')" 
                                class="flex flex-col items-center justify-center gap-0.5 transition {{ $activeTab === 'share' ? 'text-amber-400 bg-amber-500/10' : 'text-gray-500' }}"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                <span class="text-[9px] font-bold">Links</span>
                            </button>
                            <button 
                                wire:click="$set('activeTab', 'payments')" 
                                class="flex flex-col items-center justify-center gap-0.5 transition {{ $activeTab === 'payments' ? 'text-emerald-400 bg-emerald-500/10' : 'text-gray-500' }}"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-[9px] font-bold">Pagos</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- Lightbox removed from here - now handled globally via openGlobalLightbox() in app.blade.php --}}
            </div>
            </div>
        
        <!-- PLANTILLAS DE IMPRESIÓN OCULTAS EN EL DOM PARA EL MODAL -->
        <div style="display: none;">
            
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
                    <p style="margin: 0;"><strong>Cliente:</strong> {{ \Illuminate\Support\Str::limit($managingOrder->client->full_name, 20) }}</p>
                    <p style="margin: 0;"><strong>Equipo:</strong> {{ \Illuminate\Support\Str::limit($managingOrder->brand_model, 20) }}</p>
                    <p style="margin: 0;"><strong>Técnico:</strong> {{ $managingOrder->technician ? \Illuminate\Support\Str::limit($managingOrder->technician->name, 20) : 'N/A' }}</p>
                    <p style="margin: 0;"><strong>Recibido por:</strong> {{ $managingOrder->receivedBy ? \Illuminate\Support\Str::limit($managingOrder->receivedBy->name, 20) : 'Sistema' }}</p>
                    <p style="margin: 0;"><strong>Fecha Entrega:</strong> {{ $managingOrder->delivered_at ? $managingOrder->delivered_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</p>
                </div>

                <div style="font-size: 0.75rem; text-align: left; width: 100%; border-top: 1px dashed black; padding-top: 0.5rem; margin-bottom: 0.5rem; line-height: 1.3;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Total:</span>
                        <strong>${{ number_format((float)$managingOrder->labor_cost + $partsCost, 0, ',', '.') }}</strong>
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
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('isDelivering', false)"></div>
            <div class="relative w-full max-w-lg bg-gray-900 border border-gray-700 rounded-3xl shadow-2xl p-6 mx-4">
                
                <div class="flex items-center justify-between border-b border-gray-800 pb-4 mb-5">
                    <h2 class="text-xl font-black text-white tracking-tight flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Entregar Equipo
                    </h2>
                    <button wire:click="$set('isDelivering', false)" class="text-gray-500 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <p class="text-sm text-gray-400 mb-5">
                    Estás a punto de entregar la Orden <strong>#{{ $deliveringOrderCode }}</strong>. Por favor, especifica la garantía para que el sistema empiece a contar los días.
                </p>

                <div class="space-y-4">
                    @if($deliveryBalanceDue > 0)
                        <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4 animate-fade-in">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <div>
                                    <h3 class="text-sm font-bold text-red-400">Saldo Pendiente: ${{ number_format($deliveryBalanceDue, 0, ',', '.') }}</h3>
                                    <p class="text-xs text-gray-300 mt-1">Este equipo tiene un saldo sin pagar. Asegúrate de cobrarlo al momento de entregar.</p>
                                    
                                    <label class="flex items-center gap-2 mt-3 cursor-pointer">
                                        <input type="checkbox" wire:model.live="deliveryPayBalance" class="w-4 h-4 text-purple-600 bg-gray-800 border-gray-600 rounded focus:ring-purple-500">
                                        <span class="text-sm font-semibold text-white">Registrar pago del saldo ahora</span>
                                    </label>

                                    @if(!$deliveryPayBalance)
                                        @if(auth()->user()->hasRole('admin'))
                                            <div class="mt-2 text-xs font-semibold text-purple-300 bg-purple-950/60 p-2.5 rounded-xl border border-purple-800/50 flex items-center gap-2">
                                                <svg class="w-4 h-4 shrink-0 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <span>ℹ️ Modo Administrador: Si entregas sin marcar el pago, la orden quedará entregada con una nota de autorización en la bitácora.</span>
                                            </div>
                                        @else
                                            <div class="mt-2 text-xs font-semibold text-amber-300 bg-amber-950/60 p-2.5 rounded-xl border border-amber-800/50 flex items-center gap-2">
                                                <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                                <span>⚠️ Debes registrar el pago del saldo para poder confirmar la entrega (Requerido para rol Técnico).</span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            @if($deliveryPayBalance)
                                <div class="mt-4 pt-4 border-t border-red-500/20 space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Método de Pago</label>
                                            <select wire:model="deliveryPaymentMethod" class="w-full bg-gray-800 border border-gray-700 rounded-xl p-2.5 text-white text-sm focus:ring-2 focus:ring-purple-500 outline-none">
                                                <option>Efectivo</option>
                                                <option>Tarjeta Crédito/Débito</option>
                                                <option>Transferencia</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Comprobante</label>
                                            <select wire:model.live="documentType" class="w-full bg-gray-800 border border-gray-700 rounded-xl p-2.5 text-white text-sm focus:ring-2 focus:ring-purple-500 outline-none">
                                                <option>Ticket Interno</option>
                                                <option>Boleta</option>
                                                <option>Factura</option>
                                            </select>
                                        </div>
                                    </div>

                                    @if($documentType === 'Factura')
                                        <div class="bg-gray-800/50 p-4 rounded-xl border border-gray-700 space-y-3">
                                            <h4 class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-2">Datos de Facturación</h4>
                                            
                                            <div>
                                                <label class="block text-xs text-gray-400 mb-1">Razón Social *</label>
                                                <input type="text" wire:model="clientCompanyName" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-sm" placeholder="Ej: Mi Empresa SpA">
                                                @error('clientCompanyName') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            
                                            <div>
                                                <label class="block text-xs text-gray-400 mb-1">Giro Comercial *</label>
                                                <input type="text" wire:model="clientBusinessActivity" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-sm" placeholder="Ej: Servicios Informáticos">
                                                @error('clientBusinessActivity') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs text-gray-400 mb-1">Dirección *</label>
                                                    <input type="text" wire:model="clientAddress" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-sm" placeholder="Ej: Av. Principal 123">
                                                    @error('clientAddress') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-xs text-gray-400 mb-1">Comuna *</label>
                                                    <input type="text" wire:model="clientCommune" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-sm" placeholder="Ej: Santiago">
                                                    @error('clientCommune') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-4 flex items-center gap-3">
                            <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <div class="text-sm">
                                <span class="font-bold text-emerald-400">Todo pagado.</span>
                                <span class="text-gray-300">No hay saldos pendientes para esta OT.</span>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Garantía Otorgada al Entregar *</label>
                        <select wire:model="deliveryWarrantyMonths" class="w-full bg-gray-800 border border-gray-700 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-purple-500 outline-none">
                            <option value="0">0 Meses (Sin Garantía - Equipo Mojado / Humedad / Alto Riesgo)</option>
                            <option value="1">1 Mes de Garantía</option>
                            <option value="2">2 Meses de Garantía</option>
                            <option value="3">3 Meses de Garantía (Estándar)</option>
                            <option value="6">6 Meses de Garantía</option>
                            <option value="12">12 Meses de Garantía (1 Año)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Notas de Entrega y Exclusiones (Opcional)</label>
                        <textarea wire:model="deliveryNotes" rows="2" class="w-full bg-gray-800 border border-gray-700 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Ej. Probado en mostrador frente al cliente. Sin garantía por humedad previa..."></textarea>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('isDelivering', false)" class="px-5 py-2.5 rounded-xl text-sm font-bold text-gray-400 bg-gray-800 hover:bg-gray-700 hover:text-white transition">
                        Cancelar
                    </button>
                    <button wire:click="processDelivery" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-purple-600 hover:bg-purple-500 shadow-lg shadow-purple-500/20 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
