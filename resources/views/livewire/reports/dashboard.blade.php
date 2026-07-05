<div class="space-y-6 animate-fade-in">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Reportes Consolidados</h1>
            <p class="text-sm text-gray-400 mt-1">Métricas y estadísticas del negocio en tiempo real.</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-gray-850 p-5 rounded-3xl border border-gray-800 shadow-md">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <!-- Rango Rápido -->
            <div class="w-full md:w-1/3">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Período</label>
                <select wire:model.live="dateRange" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white focus:outline-none focus:border-blue-500 transition">
                    <option value="today">Hoy</option>
                    <option value="week">Esta Semana</option>
                    <option value="month">Este Mes</option>
                    <option value="custom">Personalizado</option>
                </select>
            </div>

            <!-- Rango Personalizado -->
            @if($dateRange === 'custom')
            <div class="w-full md:w-1/3">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Desde</label>
                <input wire:model.live="startDate" type="date" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white focus:outline-none focus:border-blue-500 transition">
            </div>
            <div class="w-full md:w-1/3">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Hasta</label>
                <input wire:model.live="endDate" type="date" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white focus:outline-none focus:border-blue-500 transition">
            </div>
            @endif
            
            <!-- Loading Indicator -->
            <div wire:loading wire:target="dateRange, startDate, endDate" class="text-blue-400 text-sm font-semibold mb-2 hidden md:block">
                Actualizando...
            </div>
        </div>
    </div>

    <!-- KPIs Globales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 relative">
        <div wire:loading.class="opacity-50 blur-sm" wire:target="dateRange, startDate, endDate" class="absolute inset-0 z-10 transition-all duration-300 hidden"></div>
        
        <!-- Ingresos -->
        <div class="bg-gray-850 border border-gray-800 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Ingresos Totales</h3>
                <div class="p-2 bg-blue-500/10 text-blue-400 rounded-xl border border-blue-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-3xl font-black text-white">${{ number_format($totalSales + $otTotalRecaudado, 0, ',', '.') }}</p>
                <div class="text-xs text-gray-500 mt-2 font-semibold">
                    <span class="text-blue-400">Ventas:</span> ${{ number_format($totalSales, 0, ',', '.') }} <br>
                    <span class="text-indigo-400">Órdenes:</span> ${{ number_format($otTotalRecaudado, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- Egresos -->
        <div class="bg-gray-850 border border-gray-800 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-red-500/10 rounded-full blur-2xl group-hover:bg-red-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Egresos Totales</h3>
                <div class="p-2 bg-red-500/10 text-red-400 rounded-xl border border-red-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-3xl font-black text-white">${{ number_format($totalExpenses, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-2 font-semibold">Compras registradas en el período</p>
            </div>
        </div>

        <!-- Ganancia Neta -->
        <div class="bg-gray-850 border border-gray-800 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Flujo de Caja</h3>
                <div class="p-2 bg-emerald-500/10 text-emerald-400 rounded-xl border border-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-3xl font-black {{ $netProfit >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                    ${{ number_format($netProfit, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500 mt-2 font-semibold">Ingresos menos Egresos</p>
            </div>
        </div>
    </div>

    <!-- Secciones Detalladas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        
        <!-- Órdenes de Trabajo -->
        <div class="bg-gray-850 border border-gray-800 rounded-3xl p-6 shadow-xl">
            <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-800">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <h3 class="text-lg font-bold text-white">Órdenes de Trabajo</h3>
            </div>
            
            <div class="flex items-center justify-between mb-4 bg-gray-900/50 p-4 rounded-2xl border border-gray-800">
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase">Órdenes Recibidas</span>
                    <span class="text-2xl font-black text-white">{{ $otCount }}</span>
                </div>
                <div class="text-right">
                    <span class="block text-xs font-semibold text-gray-400 uppercase">Abonado/Pagado</span>
                    <span class="text-xl font-black text-indigo-400">${{ number_format($otTotalRecaudado, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($otStatuses->count() > 0)
                <div class="space-y-3">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Desglose por Estado</p>
                    @foreach($otStatuses as $status => $count)
                    <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-xl border border-gray-800/50">
                        <span class="text-sm font-semibold text-gray-300">{{ $status }}</span>
                        <span class="px-2 py-1 bg-gray-900 rounded-lg text-xs font-bold text-white border border-gray-700">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No hay órdenes en este período.</p>
            @endif
        </div>

        <!-- Ventas (POS) -->
        <div class="bg-gray-850 border border-gray-800 rounded-3xl p-6 shadow-xl">
            <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-800">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <h3 class="text-lg font-bold text-white">Ventas y Productos</h3>
            </div>
            
            <div class="flex items-center justify-between mb-4 bg-gray-900/50 p-4 rounded-2xl border border-gray-800">
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase">Total Ventas</span>
                    <span class="text-2xl font-black text-white">{{ $salesCount }}</span>
                </div>
                <div class="text-right">
                    <span class="block text-xs font-semibold text-gray-400 uppercase">Recaudado</span>
                    <span class="text-xl font-black text-blue-400">${{ number_format($totalSales, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($salesByMethod->count() > 0)
                <div class="space-y-3">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Desglose por Método</p>
                    @foreach($salesByMethod as $method => $amount)
                    <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-xl border border-gray-800/50">
                        <span class="text-sm font-semibold text-gray-300">{{ $method ?: 'Efectivo' }}</span>
                        <span class="text-sm font-bold text-white">${{ number_format($amount, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No hay ventas en este período.</p>
            @endif
        </div>

        <!-- Inventario -->
        <div class="bg-gray-850 border border-gray-800 rounded-3xl p-6 shadow-xl md:col-span-2">
            <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-800">
                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <h3 class="text-lg font-bold text-white">Estado del Inventario <span class="text-xs text-gray-500 ml-2 font-normal">(Actual, sin filtro de fecha)</span></h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-gray-900/50 p-4 rounded-2xl border border-gray-800">
                    <span class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Costo Total en Stock</span>
                    <span class="text-2xl font-black text-white mt-1 block">${{ number_format($inventoryValue, 0, ',', '.') }}</span>
                </div>
                
                <div class="bg-gray-900/50 p-4 rounded-2xl border border-gray-800">
                    <span class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Venta Potencial Total</span>
                    <span class="text-2xl font-black text-emerald-400 mt-1 block">${{ number_format($inventorySaleValue, 0, ',', '.') }}</span>
                </div>

                <div class="bg-red-900/10 p-4 rounded-2xl border border-red-900/30">
                    <span class="block text-[10px] font-black text-red-500 uppercase tracking-widest">Productos Stock Crítico</span>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-2xl font-black text-red-400">{{ $lowStockCount }}</span>
                        @if($lowStockCount > 0)
                            <a href="{{ route('inventory.index') }}" class="text-xs font-semibold text-red-400 hover:text-red-300 underline">Ver inventario</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
