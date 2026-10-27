<div class="space-y-6 pb-16 md:pb-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/50">
                    <x-ui.icon name="trending-up" class="w-5 h-5" />
                </span>
                Panel Financiero
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Resumen mensual de ingresos, egresos y utilidad.</p>
        </div>
        
        <div class="flex items-center gap-2 bg-white dark:bg-zinc-900 p-1 rounded-lg border border-zinc-200 dark:border-zinc-800 shadow-xs self-start sm:self-auto">
            <select wire:model.live="currentMonth" class="bg-transparent text-zinc-800 dark:text-zinc-200 text-xs font-medium rounded-md border-0 py-1.5 pl-2.5 pr-7 focus:ring-1 focus:ring-orange-500">
                @for($m=1; $m<=12; $m++)
                    <option value="{{ $m }}">{{ ucfirst(\Carbon\Carbon::create(2000, $m, 1)->locale('es')->monthName) }}</option>
                @endfor
            </select>
            <div class="w-px h-4 bg-zinc-200 dark:bg-zinc-700"></div>
            <select wire:model.live="currentYear" class="bg-transparent text-zinc-800 dark:text-zinc-200 text-xs font-medium rounded-md border-0 py-1.5 pl-2.5 pr-7 focus:ring-1 focus:ring-orange-500">
                @for($y=date('Y'); $y>=date('Y')-2; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>

    <!-- Main Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        <!-- Total Ingresos Reales (Mano de Obra + POS) -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs transition duration-150">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Ingresos Reales (Mano de Obra + POS)</span>
                <span class="p-1.5 rounded-md bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                    <x-ui.icon name="trending-up" class="w-4 h-4" />
                </span>
            </div>
            <div class="mt-2">
                <span class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight">${{ number_format($totalSales, 0, ',', '.') }}</span>
                <div class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Neto sin IVA: ${{ number_format($totalSalesNet, 0, ',', '.') }} (Excluye repuestos de clientes)</div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs transition duration-150">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Total Egresos / Gastos</span>
                <span class="p-1.5 rounded-md bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400">
                    <x-ui.icon name="trending-down" class="w-4 h-4" />
                </span>
            </div>
            <div class="mt-2">
                <span class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight">${{ number_format($totalExpenses, 0, ',', '.') }}</span>
                <div class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Neto: ${{ number_format($totalExpensesNet, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs border-l-4 {{ $netProfit >= 0 ? 'border-l-emerald-500' : 'border-l-orange-500' }} transition duration-150">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Utilidad Neta Final</span>
                <span class="p-1.5 rounded-md {{ $netProfit >= 0 ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400' : 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400' }}">
                    <x-ui.icon name="dollar-sign" class="w-4 h-4" />
                </span>
            </div>
            <div class="mt-2">
                <span class="text-2xl font-bold tracking-tight {{ $netProfit >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-orange-600 dark:text-orange-400' }}">${{ number_format($netProfit, 0, ',', '.') }}</span>
                <div class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Mano de Obra + POS menos Gastos</div>
            </div>
        </div>
    </div>

    <!-- Breakdown Section: Servicios vs Repuestos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Servicios / Mano de Obra (Utilidad Directa) -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <span class="p-1.5 rounded-md bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                        <x-ui.icon name="wrench" class="w-4 h-4" />
                    </span>
                    <div>
                        <h3 class="text-xs font-semibold text-zinc-800 dark:text-zinc-200">Mano de Obra OT (Utilidad del Taller)</h3>
                        <p class="text-[11px] text-zinc-400 dark:text-zinc-500">Ingreso real directo por servicio de reparaciones</p>
                    </div>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($servicesIncome, 0, ',', '.') }}</span>
                <span class="text-[11px] font-medium text-emerald-600 dark:text-emerald-400">Ganancia directa</span>
            </div>
        </div>

        <!-- Repuestos / Componentes + Envío (Plata del Cliente) -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <span class="p-1.5 rounded-md bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400">
                        <x-ui.icon name="package" class="w-4 h-4" />
                    </span>
                    <div>
                        <h3 class="text-xs font-semibold text-zinc-800 dark:text-zinc-200">Repuestos y Envíos (Costo Cliente)</h3>
                        <p class="text-[11px] text-zinc-400 dark:text-zinc-500">Cobrado al costo al cliente (no suma a tu utilidad)</p>
                    </div>
                </div>
            </div>
            <div class="mt-3 flex flex-wrap items-baseline gap-2">
                <span class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($productsIncome, 0, ',', '.') }}</span>
                <span class="text-[11px] text-zinc-500 dark:text-zinc-400">
                    Repuestos: ${{ number_format($otPartsTotal ?? 0, 0, ',', '.') }} • Envíos: ${{ number_format($otShippingTotal ?? 0, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Taxes (IVA) section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs">
            <h3 class="text-xs font-semibold text-zinc-800 dark:text-zinc-200 uppercase tracking-wider mb-3 flex items-center gap-2">
                <x-ui.icon name="file-text" class="w-4 h-4 text-zinc-400" />
                Resumen de IVA (19%)
            </h3>
            
            <div class="space-y-2.5">
                <div class="flex items-center justify-between p-2.5 rounded-lg bg-zinc-50 dark:bg-zinc-850 border border-zinc-200/80 dark:border-zinc-800 text-xs">
                    <span class="text-zinc-500 dark:text-zinc-400">IVA Débito (Ventas)</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">${{ number_format($totalSalesTax, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex items-center justify-between p-2.5 rounded-lg bg-zinc-50 dark:bg-zinc-850 border border-zinc-200/80 dark:border-zinc-800 text-xs">
                    <span class="text-zinc-500 dark:text-zinc-400">IVA Crédito (Compras/Gastos)</span>
                    <span class="font-semibold text-red-600 dark:text-red-400">-${{ number_format($totalExpensesTax, 0, ',', '.') }}</span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                    <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Saldo IVA (Estimado)</span>
                    <span class="text-base font-bold {{ $taxBalance > 0 ? 'text-zinc-900 dark:text-zinc-100' : 'text-emerald-600 dark:text-emerald-400' }}">
                        ${{ number_format($taxBalance, 0, ',', '.') }}
                    </span>
                </div>
                @if($taxBalance > 0)
                    <p class="text-[11px] text-zinc-400 text-center">Tienes IVA a pagar al SII por este mes.</p>
                @else
                    <p class="text-[11px] text-zinc-400 text-center">Tienes saldo a favor (Remanente) para el próximo mes.</p>
                @endif
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs flex flex-col">
            <h3 class="text-xs font-semibold text-zinc-800 dark:text-zinc-200 uppercase tracking-wider mb-3">Acciones Rápidas</h3>
            <div class="grid grid-cols-1 gap-2.5 flex-1">
                <a href="{{ route('finance.sales-book') }}" class="flex items-center justify-between p-3 rounded-lg bg-zinc-50 dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 hover:bg-zinc-100/60 dark:hover:bg-zinc-800/60 transition group">
                    <div class="flex items-center gap-2.5">
                        <div class="p-1.5 rounded-md bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                            <x-ui.icon name="file-text" class="w-4 h-4" />
                        </div>
                        <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-zinc-100 transition">Ver Libro de Ventas</span>
                    </div>
                    <x-ui.icon name="chevron-right" class="w-4 h-4 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-200 transition" />
                </a>

                <a href="{{ route('finance.purchases') }}" class="flex items-center justify-between p-3 rounded-lg bg-zinc-50 dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 hover:bg-zinc-100/60 dark:hover:bg-zinc-800/60 transition group">
                    <div class="flex items-center gap-2.5">
                        <div class="p-1.5 rounded-md bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400">
                            <x-ui.icon name="shopping-bag" class="w-4 h-4" />
                        </div>
                        <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-zinc-100 transition">Registrar Compra o Gasto</span>
                    </div>
                    <x-ui.icon name="chevron-right" class="w-4 h-4 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-200 transition" />
                </a>
            </div>
        </div>
    </div>
</div>