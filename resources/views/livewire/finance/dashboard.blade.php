<div class="px-2">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight flex items-center gap-3">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Panel Financiero
            </h2>
            <p class="text-sm text-gray-400 mt-1 font-medium">Resumen de ingresos, egresos y utilidad.</p>
        </div>
        
        <div class="flex items-center gap-3 bg-gray-800/80 p-1.5 rounded-xl border border-gray-700/50">
            <select wire:model.live="currentMonth" class="bg-gray-900 border-none text-white text-sm font-semibold rounded-lg focus:ring-emerald-500 block py-2 px-3">
                @for($m=1; $m<=12; $m++)
                    <option value="{{ $m }}">{{ \Carbon\Carbon::create(2000, $m, 1)->locale('es')->monthName }}</option>
                @endfor
            </select>
            <select wire:model.live="currentYear" class="bg-gray-900 border-none text-white text-sm font-semibold rounded-lg focus:ring-emerald-500 block py-2 px-3">
                @for($y=date('Y'); $y>=date('Y')-2; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>

    <!-- Main Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Total Sales (Net) -->
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 relative overflow-hidden group hover:border-emerald-500/50 transition-all duration-300 shadow-lg shadow-black/20">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl group-hover:bg-emerald-500/20 transition-all duration-500"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div>
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Ingresos (Neto)</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
            </div>
            <div class="relative z-10">
                <span class="text-3xl font-black text-white tracking-tight">${{ number_format($totalSalesNet, 0, ',', '.') }}</span>
                <div class="text-xs font-semibold text-gray-500 mt-2">Bruto: ${{ number_format($totalSales, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Total Expenses (Net) -->
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 relative overflow-hidden group hover:border-red-500/50 transition-all duration-300 shadow-lg shadow-black/20">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-500/10 rounded-full blur-xl group-hover:bg-red-500/20 transition-all duration-500"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div>
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Egresos (Neto)</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                </div>
            </div>
            <div class="relative z-10">
                <span class="text-3xl font-black text-white tracking-tight">${{ number_format($totalExpensesNet, 0, ',', '.') }}</span>
                <div class="text-xs font-semibold text-gray-500 mt-2">Bruto: ${{ number_format($totalExpenses, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6 relative overflow-hidden group {{ $netProfit >= 0 ? 'hover:border-blue-500/50' : 'hover:border-orange-500/50' }} transition-all duration-300 shadow-lg shadow-black/20">
            <div class="absolute -right-4 -top-4 w-24 h-24 {{ $netProfit >= 0 ? 'bg-blue-500/10 group-hover:bg-blue-500/20' : 'bg-orange-500/10 group-hover:bg-orange-500/20' }} rounded-full blur-xl transition-all duration-500"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div>
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Utilidad Neta</h3>
                </div>
                <div class="w-10 h-10 rounded-xl {{ $netProfit >= 0 ? 'bg-blue-500/10 border-blue-500/20 text-blue-400' : 'bg-orange-500/10 border-orange-500/20 text-orange-400' }} border flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
            <div class="relative z-10">
                <span class="text-3xl font-black tracking-tight {{ $netProfit >= 0 ? 'text-blue-400' : 'text-orange-400' }}">${{ number_format($netProfit, 0, ',', '.') }}</span>
                <div class="text-xs font-semibold text-gray-500 mt-2">Antes de impuestos</div>
            </div>
        </div>
    </div>

    <!-- Taxes (IVA) section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-lg shadow-black/20">
            <h3 class="text-sm font-black text-white tracking-tight mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                Resumen de IVA (19%)
            </h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-900 border border-gray-800">
                    <span class="text-xs font-semibold text-gray-400">IVA Débito (Ventas)</span>
                    <span class="text-sm font-bold text-emerald-400">${{ number_format($totalSalesTax, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-900 border border-gray-800">
                    <span class="text-xs font-semibold text-gray-400">IVA Crédito (Compras/Gastos)</span>
                    <span class="text-sm font-bold text-red-400">-${{ number_format($totalExpensesTax, 0, ',', '.') }}</span>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl bg-purple-500/10 border border-purple-500/20">
                    <span class="text-xs font-black text-purple-400 uppercase tracking-widest">Saldo IVA (Estimado)</span>
                    <span class="text-lg font-black {{ $taxBalance > 0 ? 'text-white' : 'text-purple-300' }}">
                        ${{ number_format($taxBalance, 0, ',', '.') }}
                    </span>
                </div>
                @if($taxBalance > 0)
                    <p class="text-[10px] text-gray-500 text-center font-medium">Tienes IVA a pagar al SII por este mes.</p>
                @else
                    <p class="text-[10px] text-gray-500 text-center font-medium">Tienes saldo a favor (Remanente) para el próximo mes.</p>
                @endif
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-lg shadow-black/20 flex flex-col">
            <h3 class="text-sm font-black text-white tracking-tight mb-4">Acciones Rápidas</h3>
            <div class="grid grid-cols-1 gap-3 flex-1">
                <a href="{{ route('finance.sales-book') }}" class="flex items-center justify-between p-4 rounded-xl bg-gray-900 border border-gray-800 hover:border-emerald-500/50 hover:bg-gray-800 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-300 group-hover:text-white transition-colors">Ver Libro de Ventas</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <a href="{{ route('finance.purchases') }}" class="flex items-center justify-between p-4 rounded-xl bg-gray-900 border border-gray-800 hover:border-red-500/50 hover:bg-gray-800 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-300 group-hover:text-white transition-colors">Registrar Compra o Gasto</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>
</div>
