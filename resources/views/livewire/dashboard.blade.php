<div class="space-y-8 animate-fade-in">
    <!-- Header Welcome Card -->
    <div class="relative bg-gray-900 p-6 sm:p-10 rounded-[2rem] border border-gray-800 overflow-hidden shadow-2xl group transition-all duration-500 hover:shadow-blue-500/10">
        <!-- Mesh Gradient Background -->
        <div class="absolute inset-0 opacity-40">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/30 rounded-full blur-[80px] mix-blend-screen animate-pulse" style="animation-duration: 8s;"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-600/30 rounded-full blur-[80px] mix-blend-screen animate-pulse" style="animation-duration: 12s; animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-indigo-600/10 blur-[100px] mix-blend-screen"></div>
        </div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 backdrop-blur-sm">
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-100 to-gray-400 tracking-tight drop-shadow-sm">¡Hola, {{ auth()->user()->name }}!</h1>
                <p class="text-sm text-gray-300 mt-2 font-medium">Bienvenido de vuelta a Sointech. Esto es lo que está pasando hoy en el taller.</p>
                <div class="flex items-center gap-2 mt-5">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20 backdrop-blur-md shadow-[0_0_15px_rgba(59,130,246,0.15)]">
                        <span class="w-2 h-2 rounded-full bg-blue-400 mr-2 animate-pulse shadow-[0_0_8px_rgba(59,130,246,0.8)]"></span>
                        Rol: {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>
            
            <!-- Quick Action Widgets by Role -->
            <div class="flex flex-wrap gap-3">
                @if(auth()->user()->isAdmin() || auth()->user()->role === 'recepcionista')
                    <a href="{{ route('work-orders.create') }}" class="group/btn inline-flex items-center justify-center gap-2 bg-gradient-to-b from-blue-500 to-blue-600 hover:from-blue-400 hover:to-blue-500 text-white text-sm font-bold px-5 py-3.5 rounded-2xl shadow-[0_0_20px_rgba(59,130,246,0.3)] hover:shadow-[0_0_25px_rgba(59,130,246,0.5)] border border-blue-400/20 transition-all duration-300 hover:-translate-y-0.5 active:scale-95">
                        <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Crear Nueva OT
                    </a>
                @endif
                @if(auth()->user()->role === 'tecnico')
                    <a href="#" class="group/btn inline-flex items-center justify-center gap-2 bg-gradient-to-b from-indigo-500 to-indigo-600 hover:from-indigo-400 hover:to-indigo-500 text-white text-sm font-bold px-5 py-3.5 rounded-2xl shadow-[0_0_20px_rgba(99,102,241,0.3)] hover:shadow-[0_0_25px_rgba(99,102,241,0.5)] border border-indigo-400/20 transition-all duration-300 hover:-translate-y-0.5 active:scale-95">
                        <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Ver Mis Tareas
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- MAIN METRICS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- Metrics: Total OTs -->
        <div class="relative bg-gray-850/80 backdrop-blur-xl p-4 sm:p-6 rounded-3xl border border-gray-800 shadow-lg hover:border-blue-500/30 hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 flex items-center justify-between group overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest block mb-1.5">Órdenes Totales</span>
                <span class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400 block">{{ $totalOrders }}</span>
            </div>
            <div class="relative z-10 p-3.5 bg-blue-500/10 text-blue-400 rounded-2xl group-hover:scale-110 group-hover:bg-blue-500/20 group-hover:shadow-[0_0_15px_rgba(59,130,246,0.2)] transition-all duration-300 border border-blue-500/10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>

        <!-- Metrics: En Reparación -->
        <div class="relative bg-gray-850/80 backdrop-blur-xl p-4 sm:p-6 rounded-3xl border border-gray-800 shadow-lg hover:border-indigo-500/30 hover:shadow-indigo-500/10 transition-all duration-300 hover:-translate-y-1 flex items-center justify-between group overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest block mb-1.5">En Reparación</span>
                <span class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 to-indigo-500 block drop-shadow-[0_0_10px_rgba(99,102,241,0.2)]">{{ $enReparacion }}</span>
            </div>
            <div class="relative z-10 p-3.5 bg-indigo-500/10 text-indigo-400 rounded-2xl group-hover:scale-110 group-hover:bg-indigo-500/20 group-hover:shadow-[0_0_15px_rgba(99,102,241,0.2)] transition-all duration-300 border border-indigo-500/10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
        </div>

        <!-- Metrics: Listas para Entrega -->
        <div class="relative bg-gray-850/80 backdrop-blur-xl p-4 sm:p-6 rounded-3xl border border-gray-800 shadow-lg hover:border-emerald-500/30 hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 flex items-center justify-between group overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest block mb-1.5">Listas Entrega</span>
                <span class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-emerald-500 block drop-shadow-[0_0_10px_rgba(52,211,153,0.2)]">{{ $listas }}</span>
            </div>
            <div class="relative z-10 p-3.5 bg-emerald-500/10 text-emerald-400 rounded-2xl group-hover:scale-110 group-hover:bg-emerald-500/20 group-hover:shadow-[0_0_15px_rgba(52,211,153,0.2)] transition-all duration-300 border border-emerald-500/10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Metrics: Entregadas -->
        <div class="relative bg-gray-850/80 backdrop-blur-xl p-4 sm:p-6 rounded-3xl border border-gray-800 shadow-lg hover:border-purple-500/30 hover:shadow-purple-500/10 transition-all duration-300 hover:-translate-y-1 flex items-center justify-between group overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest block mb-1.5">Completadas</span>
                <span class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-purple-500 block drop-shadow-[0_0_10px_rgba(168,85,247,0.2)]">{{ $entregadas }}</span>
            </div>
            <div class="relative z-10 p-3.5 bg-purple-500/10 text-purple-400 rounded-2xl group-hover:scale-110 group-hover:bg-purple-500/20 group-hover:shadow-[0_0_15px_rgba(168,85,247,0.2)] transition-all duration-300 border border-purple-500/10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>

    </div>

    <!-- MAIN MIDDLE SECTION: CHARTS AND FINANCIAL OVERVIEW -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Financial Overview (Admin Only) -->
        <div class="bg-gray-850/80 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border border-gray-800 shadow-xl flex flex-col justify-between relative overflow-hidden group hover:border-emerald-500/30 transition-all duration-300 {{ auth()->user()->isAdmin() ? '' : 'opacity-40 select-none' }}">
            <!-- Emerald Glow Background -->
            <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-emerald-500/10 rounded-full blur-[80px] pointer-events-none group-hover:bg-emerald-500/15 transition-all duration-500"></div>

            @if(!auth()->user()->isAdmin())
                <div class="absolute inset-0 bg-gray-950/40 backdrop-blur-sm z-10 flex flex-col items-center justify-center text-center p-4">
                    <svg class="w-8 h-8 text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span class="text-sm font-bold text-gray-300">Widget Restringido</span>
                    <span class="text-xs text-gray-500 mt-0.5">Acceso exclusivo para administradores</span>
                </div>
            @endif
            
            <div class="relative z-10">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <div class="p-1.5 bg-emerald-500/10 rounded-lg border border-emerald-500/20">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V5"></path></svg>
                    </div>
                    Ingresos Totales (Caja)
                </h2>
                <div class="mt-5">
                    <span class="text-xs font-medium text-gray-500 block mb-1">Recaudación acumulada (Mano de Obra + Abonos)</span>
                    <span class="text-4xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200 tracking-tight drop-shadow-[0_0_12px_rgba(52,211,153,0.3)]">
                        $ {{ number_format($totalRevenue, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            
            <div class="relative z-10 border-t border-gray-700/50 pt-5 mt-8">
                <div class="flex items-center justify-between text-sm text-gray-400">
                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_5px_rgba(16,185,129,0.8)]"></span>
                        Abonos Recibidos
                    </span>
                    <span class="font-black text-white bg-gray-900/50 px-2 py-0.5 rounded-md border border-gray-700/50">${{ number_format(\App\Models\WorkOrder::sum('down_payment'), 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between text-sm text-gray-400 mt-3">
                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_5px_rgba(52,211,153,0.8)]"></span>
                        Mano de Obra Entregada
                    </span>
                    <span class="font-black text-white bg-gray-900/50 px-2 py-0.5 rounded-md border border-gray-700/50">${{ number_format(\App\Models\WorkOrder::where('status', 'Entregado')->sum('labor_cost'), 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Repair Process Progress Chart -->
        <div class="bg-gray-850/80 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border border-gray-800 shadow-xl flex flex-col justify-between lg:col-span-2">
            <div>
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Embudo de Procesos del Taller</h2>
                <p class="text-xs text-gray-500 mt-1">Representación porcentual de las reparaciones según su estado actual.</p>
            </div>
            
            <div class="space-y-4 my-6">
                @php
                    $percentIngresadas = $totalOrders > 0 ? round(($ingresadas / $totalOrders) * 100) : 0;
                    $percentReparacion = $totalOrders > 0 ? round(($enReparacion / $totalOrders) * 100) : 0;
                    $percentListas = $totalOrders > 0 ? round(($listas / $totalOrders) * 100) : 0;
                    $percentEntregadas = $totalOrders > 0 ? round(($entregadas / $totalOrders) * 100) : 0;
                @endphp
                
                <!-- Progress: Ingresadas -->
                <div>
                    <div class="flex justify-between text-xs text-gray-300 mb-1.5">
                        <span class="font-bold flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-gray-500 shadow-[0_0_5px_rgba(107,114,128,0.8)]"></span>
                            Ingresadas ({{ $ingresadas }} OTs)
                        </span>
                        <span class="font-black text-gray-400">{{ $percentIngresadas }}%</span>
                    </div>
                    <div class="w-full bg-gray-900/80 rounded-full h-3 overflow-hidden border border-gray-800/80 p-0.5">
                        <div class="bg-gradient-to-r from-gray-600 to-gray-400 h-full rounded-full shadow-[0_0_10px_rgba(107,114,128,0.5)]" style="width: {{ $percentIngresadas }}%"></div>
                    </div>
                </div>

                <!-- Progress: En Reparación -->
                <div>
                    <div class="flex justify-between text-xs text-gray-300 mb-1.5">
                        <span class="font-bold flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.8)]"></span>
                            En Reparación ({{ $enReparacion }} OTs)
                        </span>
                        <span class="font-black text-indigo-400">{{ $percentReparacion }}%</span>
                    </div>
                    <div class="w-full bg-gray-900/80 rounded-full h-3 overflow-hidden border border-gray-800/80 p-0.5">
                        <div class="bg-gradient-to-r from-indigo-600 to-indigo-400 h-full rounded-full shadow-[0_0_10px_rgba(99,102,241,0.5)]" style="width: {{ $percentReparacion }}%"></div>
                    </div>
                </div>

                <!-- Progress: Listas para Entrega -->
                <div>
                    <div class="flex justify-between text-xs text-gray-300 mb-1.5">
                        <span class="font-bold flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_5px_rgba(16,185,129,0.8)]"></span>
                            Listas para Entrega ({{ $listas }} OTs)
                        </span>
                        <span class="font-black text-emerald-400">{{ $percentListas }}%</span>
                    </div>
                    <div class="w-full bg-gray-900/80 rounded-full h-3 overflow-hidden border border-gray-800/80 p-0.5">
                        <div class="bg-gradient-to-r from-emerald-600 to-emerald-400 h-full rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]" style="width: {{ $percentListas }}%"></div>
                    </div>
                </div>

                <!-- Progress: Entregadas -->
                <div>
                    <div class="flex justify-between text-xs text-gray-300 mb-1.5">
                        <span class="font-bold flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500 shadow-[0_0_5px_rgba(168,85,247,0.8)]"></span>
                            Entregadas ({{ $entregadas }} OTs)
                        </span>
                        <span class="font-black text-purple-400">{{ $percentEntregadas }}%</span>
                    </div>
                    <div class="w-full bg-gray-900/80 rounded-full h-3 overflow-hidden border border-gray-800/80 p-0.5">
                        <div class="bg-gradient-to-r from-purple-600 to-purple-400 h-full rounded-full shadow-[0_0_10px_rgba(168,85,247,0.5)]" style="width: {{ $percentEntregadas }}%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- RECENT WORK ORDERS TABLE -->
    <!-- RECENT WORK ORDERS TABLE -->
    <div class="bg-gray-850/80 backdrop-blur-xl rounded-3xl border border-gray-800 shadow-xl overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gray-900/30">
            <div>
                <h2 class="text-lg font-bold text-white tracking-tight flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Órdenes de Trabajo Recientes
                </h2>
                <p class="text-xs text-gray-400 mt-1 ml-7">Últimas órdenes ingresadas activas.</p>
            </div>
            
            <a href="#" class="text-xs font-bold text-blue-400 bg-blue-500/10 hover:bg-blue-500/20 px-4 py-2 rounded-xl transition-all flex items-center gap-1 self-start sm:self-center border border-blue-500/20 hover:shadow-[0_0_10px_rgba(59,130,246,0.2)]">
                Ver Todas las Órdenes
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="overflow-x-auto p-4">
            <table class="w-full text-left text-sm whitespace-nowrap border-separate" style="border-spacing: 0 0.5rem;">
                <thead>
                    <tr class="text-gray-400 font-bold uppercase text-[10px] tracking-wider">
                        <th class="px-6 py-2">Código OT</th>
                        <th class="px-6 py-2">Cliente</th>
                        <th class="px-6 py-2">Equipo / Dispositivo</th>
                        <th class="px-6 py-2">Estado</th>
                        <th class="px-6 py-2">Mano de Obra</th>
                        <th class="px-6 py-2">Abono</th>
                        <th class="px-6 py-2">Fecha de Ingreso</th>
                        @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                            <th class="px-6 py-2 text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr class="bg-gray-900/40 hover:bg-gray-800 transition-all duration-300 group shadow-sm hover:shadow-md hover:-translate-y-0.5 rounded-2xl relative">
                            <td class="px-6 py-4 rounded-l-2xl border-y border-l border-gray-800 group-hover:border-l-blue-500 group-hover:border-y-gray-700/50 group-hover:bg-blue-500/5 transition-colors relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <span class="font-mono text-xs font-bold text-blue-400 uppercase tracking-tight ml-2">
                                    #{{ substr($order->uuid, 0, 8) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 border-y border-gray-800 group-hover:border-y-gray-700/50 transition-colors">
                                <div class="flex flex-col">
                                    <span class="font-bold text-white">{{ $order->client->full_name }}</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">{{ $order->client->phone }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 border-y border-gray-800 group-hover:border-y-gray-700/50 transition-colors">
                                <div class="flex flex-col">
                                    <span class="text-white font-medium">{{ $order->brand_model }}</span>
                                    <span class="text-[10px] text-gray-500 font-mono">{{ $order->device_type }} @if($order->imei_serial) • IMEI: {{ $order->imei_serial }} @endif</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 border-y border-gray-800 group-hover:border-y-gray-700/50 transition-colors">
                                @php
                                    $statusClasses = [
                                        'Ingresado' => 'bg-gray-900/50 text-gray-400 border-gray-700/60',
                                        'En Revisión' => 'bg-indigo-950/40 text-indigo-400 border-indigo-500/20',
                                        'Presupuestado' => 'bg-amber-950/40 text-amber-400 border-amber-500/20',
                                        'Aprobado' => 'bg-blue-950/40 text-blue-400 border-blue-500/20',
                                        'Rechazado' => 'bg-red-950/40 text-red-400 border-red-500/20 animate-pulse',
                                        'En Reparación' => 'bg-indigo-950/40 text-indigo-400 border-indigo-500/20',
                                        'Listo para Entrega' => 'bg-emerald-950/40 text-emerald-400 border-emerald-500/20',
                                        'Entregado' => 'bg-purple-950/40 text-purple-400 border-purple-500/20',
                                    ];
                                    $class = $statusClasses[$order->status] ?? 'bg-gray-900 text-gray-300 border-gray-700';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $class }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-white border-y border-gray-800 group-hover:border-y-gray-700/50 transition-colors">
                                ${{ number_format($order->labor_cost, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-emerald-400 border-y border-gray-800 group-hover:border-y-gray-700/50 transition-colors">
                                @if($order->down_payment > 0)
                                    ${{ number_format($order->down_payment, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-500 text-xs font-normal">Sin abono</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-400 border-y border-gray-800 group-hover:border-y-gray-700/50 transition-colors">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            @if(auth()->user()->hasRole(['admin', 'tecnico', 'recepcionista']))
                                <td class="px-6 py-4 rounded-r-2xl border-y border-r border-gray-800 group-hover:border-y-gray-700/50 group-hover:border-r-gray-700/50 transition-colors">
                                    <div class="flex items-center justify-center gap-2">
                                        @if(auth()->user()->hasRole(['admin', 'tecnico']))
                                            <div class="inline-flex rounded-lg overflow-hidden border border-gray-800">
                                                <select 
                                                    wire:change="updateStatus({{ $order->id }}, $event.target.value)" 
                                                    class="bg-gray-900 text-gray-300 text-xs font-semibold px-2 py-1.5 focus:outline-none focus:bg-gray-950 border-0 cursor-pointer">
                                                    <option value="Ingresado" {{ $order->status === 'Ingresado' ? 'selected' : '' }}>Ingresado</option>
                                                    <option value="En Revisión" {{ $order->status === 'En Revisión' ? 'selected' : '' }}>En Revisión</option>
                                                    <option value="Presupuestado" {{ $order->status === 'Presupuestado' ? 'selected' : '' }}>Presupuestado</option>
                                                    <option value="Aprobado" {{ $order->status === 'Aprobado' ? 'selected' : '' }}>Aprobado</option>
                                                    <option value="Rechazado" {{ $order->status === 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                                                    <option value="En Reparación" {{ $order->status === 'En Reparación' ? 'selected' : '' }}>En Reparación</option>
                                                    <option value="Listo para Entrega" {{ $order->status === 'Listo para Entrega' ? 'selected' : '' }}>Listo para Entrega</option>
                                                    <option value="Entregado" {{ $order->status === 'Entregado' ? 'selected' : '' }}>Entregado</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Progress Comments and Photos Button -->
                                            <button 
                                                wire:click="startLogging({{ $order->id }})" 
                                                class="p-2 bg-indigo-950/20 hover:bg-indigo-900/30 text-indigo-400 hover:text-indigo-300 rounded-lg border border-indigo-500/20 transition duration-150 cursor-pointer flex items-center justify-center shrink-0"
                                                title="Comentarios y Fotos de Avance"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            </button>

                                            <!-- Budget / Diagnostic Wrench Button -->
                                            <button 
                                                wire:click="startBudgeting({{ $order->id }})" 
                                                class="p-2 bg-blue-950/20 hover:bg-blue-900/30 text-blue-400 hover:text-blue-300 rounded-lg border border-blue-500/20 transition duration-150 cursor-pointer flex items-center justify-center shrink-0"
                                                title="Diagnosticar y Presupuestar"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            </button>
                                        @endif
                                        
                                        <!-- WhatsApp Share -->
                                        <a 
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client->phone) }}?text={{ urlencode('Hola ' . $order->client->full_name . ', puedes hacer el seguimiento en vivo de tu equipo ' . $order->brand_model . ' ingresando a este enlace: ' . url('/seguimiento/' . $order->uuid)) }}"
                                            target="_blank" 
                                            class="p-2 bg-emerald-950/20 hover:bg-emerald-900/30 text-emerald-400 hover:text-emerald-300 rounded-lg border border-emerald-500/20 transition duration-150 cursor-pointer flex items-center justify-center"
                                            title="Compartir por WhatsApp"
                                        >
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.002-2.637-1.023-5.115-2.887-6.978C16.578 1.899 14.1 1.849 11.47 1.849c-5.437 0-9.861 4.417-9.865 9.864-.001 1.802.49 3.559 1.42 5.111L1.938 22l5.37-1.41a9.813 9.813 0 004.721 1.218z"/>
                                            </svg>
                                        </a>

                                        <!-- Copy Link -->
                                        <button 
                                            x-data="{ copied: false }" 
                                            @click="
                                                navigator.clipboard.writeText('{{ url('/seguimiento/' . $order->uuid) }}');
                                                copied = true;
                                                setTimeout(() => copied = false, 2000);
                                            " 
                                            class="p-2 bg-gray-900 hover:bg-gray-800 text-gray-400 hover:text-white rounded-lg border border-gray-800 transition duration-150 relative cursor-pointer flex items-center justify-center"
                                            title="Copiar Link de Seguimiento"
                                        >
                                            <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                            <svg x-show="copied" class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                No se encontraron órdenes de trabajo registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL DIAGNÓSTICO Y PRESUPUESTO -->
    @if($isBudgeting)
        <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-md z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-gray-850 border border-gray-800 rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl p-6 sm:p-8 space-y-6 animate-fade-in my-8">
                
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b border-gray-800 pb-4">
                    <div>
                        <h3 class="text-lg font-black text-white tracking-tight">Diagnóstico y Presupuesto</h3>
                        <p class="text-xs text-gray-500 mt-0.5 uppercase tracking-wider font-mono">Orden de Trabajo #{{ $editingOrderCode }}</p>
                    </div>
                    <button wire:click="$set('isBudgeting', false)" class="text-gray-500 hover:text-white transition cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveBudget" class="space-y-5 text-sm text-gray-300">
                    
                    <!-- 1. Technical Diagnostic Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Diagnóstico Técnico *</label>
                        <textarea 
                            wire:model="editingDiagnosticNotes" 
                            rows="3" 
                            class="w-full bg-gray-900 border border-gray-700 rounded-xl p-3 text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition text-xs" 
                            placeholder="Describe detalladamente la falla detectada y la reparación requerida..."
                            required
                        ></textarea>
                        @error('editingDiagnosticNotes') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- 2. Search Parts in Catalog -->
                    <div class="space-y-1.5 relative">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Agregar Repuestos del Catálogo</label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="editingSearchPart" 
                            class="w-full bg-gray-900 border border-gray-700 rounded-xl p-3 text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition text-xs" 
                            placeholder="Buscar por nombre o categoría..."
                        >
                        
                        @if(count($editingFoundParts) > 0)
                            <div class="absolute z-10 w-full mt-1 bg-gray-900 border border-gray-800 rounded-xl shadow-2xl overflow-hidden max-h-48 overflow-y-auto">
                                <ul>
                                    @foreach($editingFoundParts as $part)
                                        <li wire:click="addEditingPart({{ $part->id }})" class="p-3 hover:bg-gray-800 cursor-pointer border-b border-gray-850 flex justify-between items-center text-xs">
                                            <div>
                                                <div class="font-bold text-white">{{ $part->name }}</div>
                                                <div class="text-[10px] text-gray-500">Stock: {{ $part->stock }}</div>
                                            </div>
                                            <div class="text-emerald-400 font-bold">${{ number_format($part->sale_price, 0, ',', '.') }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- 3. Selected Parts List -->
                    @if(count($editingSelectedParts) > 0)
                        <div class="bg-gray-900/60 p-3.5 rounded-2xl border border-gray-800 space-y-2">
                            <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-1.5">Repuestos Asignados</h4>
                            <div class="space-y-1.5 max-h-32 overflow-y-auto">
                                @foreach($editingSelectedParts as $index => $part)
                                    <div class="flex justify-between items-center text-xs py-1 border-b border-gray-850 last:border-0">
                                        <span class="text-gray-300 font-medium">{{ $part['name'] }}</span>
                                        <div class="flex items-center gap-3">
                                            <span class="text-gray-400 font-bold">${{ number_format($part['sale_price'], 0, ',', '.') }}</span>
                                            <button type="button" wire:click="removeEditingPart({{ $index }})" class="text-red-400 hover:text-red-300 transition cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- 4. Labor Cost and Total Estimation -->
                    <div class="grid grid-cols-2 gap-4 items-end pt-2">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Costo Mano de Obra ($)</label>
                            <input 
                                type="number" 
                                wire:model="editingLaborCost" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl p-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition text-xs font-bold"
                            >
                            @error('editingLaborCost') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Running Total Summary -->
                        @php
                            $editingPartsCost = collect($editingSelectedParts)->sum(function($p) {
                                return $p['sale_price'] * $p['quantity'];
                            });
                            $editingTotalBudget = (float)$editingLaborCost + $editingPartsCost;
                        @endphp
                        <div class="bg-blue-950/20 border border-blue-500/20 p-3 rounded-xl flex flex-col justify-between h-[68px]">
                            <span class="text-[9px] font-black text-blue-400 uppercase tracking-widest block">Total Presupuestado</span>
                            <span class="text-lg font-black text-white block mt-1">${{ number_format($editingTotalBudget, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-800">
                        <button type="button" wire:click="$set('isBudgeting', false)" class="w-full py-3 px-4 rounded-xl border border-gray-800 hover:border-gray-700 text-gray-400 hover:text-white font-semibold text-xs transition cursor-pointer">
                            Cancelar
                        </button>
                        
                        <button type="submit" class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition cursor-pointer">
                            Guardar y Enviar Presupuesto
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif

    <!-- MODAL BITÁCORA Y FOTOS -->
    @if($isLogging)
        <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-md z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-gray-850 border border-gray-800 rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl p-6 sm:p-8 space-y-6 animate-fade-in my-8">
                
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b border-gray-800 pb-4">
                    <div>
                        <h3 class="text-lg font-black text-white tracking-tight">Bitácora y Galería de Fotos</h3>
                        <p class="text-xs text-gray-500 mt-0.5 uppercase tracking-wider font-mono">Orden de Trabajo #{{ $loggingOrderCode }}</p>
                    </div>
                    <button wire:click="$set('isLogging', false)" class="text-gray-500 hover:text-white transition cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-6 text-sm text-gray-300">
                    
                    <!-- Form 1: Add a Manual Text Hito / Comment with Photo Attachment -->
                    <form wire:submit.prevent="saveManualLog" class="space-y-4 bg-gray-900/40 p-4 rounded-2xl border border-gray-800">
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-2">1. Registrar Nuevo Avance Técnico</h4>
                        
                        <div class="space-y-1.5">
                            <label class="block text-xs text-gray-400 font-semibold uppercase">Título del Hito *</label>
                            <input 
                                type="text" 
                                wire:model="newLogTitle" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl p-2.5 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50 text-xs font-bold"
                                placeholder="Ej: Ultrasonido Completado, Reemplazo de Placa..."
                                required
                            >
                        </div>
                        
                        <div class="space-y-1.5">
                            <label class="block text-xs text-gray-400 font-semibold uppercase">Detalle / Notas *</label>
                            <textarea 
                                wire:model="newLogNotes" 
                                rows="2" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl p-2.5 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50 text-xs" 
                                placeholder="Describe el estado de avance del equipo..."
                                required
                            ></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between pt-1">
                            <!-- Attachment input -->
                            <div class="w-full sm:w-auto flex items-center gap-3">
                                <label class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider shrink-0">Adjuntar Foto:</label>
                                <input 
                                    type="file" 
                                    wire:model="newLogPhoto" 
                                    class="text-xs text-gray-400 focus:outline-none file:mr-2 file:py-1.5 file:px-2.5 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-gray-800 file:text-white file:cursor-pointer"
                                >
                                @error('newLogPhoto') <span class="text-red-400 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full sm:w-auto py-2.5 px-5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-md shadow-indigo-500/25 transition cursor-pointer flex justify-center items-center shrink-0">
                                Agregar Comentario
                            </button>
                        </div>

                        <!-- Preview and loading -->
                        <div wire:loading wire:target="newLogPhoto" class="text-xs text-blue-400 font-semibold flex items-center gap-1.5">
                            <svg class="animate-spin h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Cargando foto adjunta...
                        </div>

                        @if($newLogPhoto)
                            <div class="flex items-center gap-3 bg-gray-950 p-2.5 rounded-xl border border-gray-850 mt-2">
                                <img src="{{ $newLogPhoto->temporaryUrl() }}" class="w-12 h-12 object-cover rounded-lg border border-gray-800">
                                <div class="text-[10px] text-gray-400">Previsualización lista. La foto se guardará y adjuntará automáticamente a este hito de la bitácora técnica.</div>
                            </div>
                        @endif
                    </form>


                </div>

                <!-- Footer close actions -->
                <div class="pt-4 border-t border-gray-800 flex justify-end">
                    <button wire:click="$set('isLogging', false)" class="py-2.5 px-5 rounded-xl border border-gray-800 hover:border-gray-700 text-gray-400 hover:text-white font-semibold text-xs transition cursor-pointer">
                        Cerrar Ventana
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
