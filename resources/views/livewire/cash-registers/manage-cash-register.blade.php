<div class="space-y-6 pb-16 md:pb-6" wire:poll.visible.8s>
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50">
                    <x-ui.icon name="wallet" class="w-5 h-5" />
                </span>
                Caja Diaria
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Apertura, cierre y registro de movimientos financieros diarios.</p>
        </div>
        
        @if(!$activeRegister)
            <button 
                wire:click="$set('showOpenModal', true)" 
                class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-xs transition duration-150 self-start sm:self-center cursor-pointer"
            >
                <x-ui.icon name="plus" class="w-4 h-4" />
                Abrir Caja del Día
            </button>
        @else
            <div class="flex items-center gap-3">
                <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-700 dark:text-emerald-400 px-3 py-1.5 rounded-lg flex items-center gap-2 text-xs font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Caja Abierta</span>
                </div>
                <button 
                    wire:click="openCloseModal" 
                    class="inline-flex items-center justify-center gap-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3.5 py-2 rounded-lg shadow-xs transition duration-150 cursor-pointer"
                >
                    <x-ui.icon name="lock" class="w-4 h-4" />
                    Cerrar Caja
                </button>
            </div>
        @endif
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" />
            <span class="text-emerald-800 dark:text-emerald-300 text-xs font-medium">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="alert-triangle" class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" />
            <span class="text-red-800 dark:text-red-300 text-xs font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if(!$activeRegister)
        <!-- Caja Cerrada Empty State -->
        <div class="bg-white dark:bg-zinc-900 p-8 sm:p-12 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs text-center space-y-3">
            <div class="w-14 h-14 bg-zinc-100 dark:bg-zinc-800 rounded-full mx-auto flex items-center justify-center border border-zinc-200 dark:border-zinc-700 text-zinc-400">
                <x-ui.icon name="lock" class="w-6 h-6" />
            </div>
            <h2 class="text-base font-bold text-zinc-900 dark:text-zinc-100">La caja está cerrada</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 max-w-md mx-auto">Para ingresar equipos con abonos o registrar ventas, debes realizar la apertura de caja indicando el monto inicial (base).</p>
            <div class="pt-2">
                <button 
                    wire:click="$set('showOpenModal', true)" 
                    class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-xs transition duration-150 cursor-pointer"
                >
                    <x-ui.icon name="plus" class="w-4 h-4" />
                    Abrir Caja Ahora
                </button>
            </div>
        </div>

    @else
        <!-- Dashboard de Caja Abierta -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-zinc-900 p-5 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Base Inicial</span>
                    <span class="p-1.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400">
                        <x-ui.icon name="dollar-sign" class="w-4 h-4" />
                    </span>
                </div>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mt-2">${{ number_format($activeRegister->opening_balance, 0, ',', '.') }}</p>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Apertura: {{ $activeRegister->opened_at->format('H:i') }} por {{ $activeRegister->user->name }}</p>
            </div>
            
            <div class="bg-white dark:bg-zinc-900 p-5 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Ingresos del Día</span>
                    <span class="p-1.5 rounded-md bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                        <x-ui.icon name="trending-up" class="w-4 h-4" />
                    </span>
                </div>
                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">+${{ number_format($activeRegister->payments()->where('type', 'income')->sum('amount'), 0, ',', '.') }}</p>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Total recaudado en efectivo/transferencias</p>
            </div>

            <div class="bg-white dark:bg-zinc-900 p-5 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs border-l-4 border-l-orange-500">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Total Estimado en Caja</span>
                    <span class="p-1.5 rounded-md bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400">
                        <x-ui.icon name="wallet" class="w-4 h-4" />
                    </span>
                </div>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mt-2">${{ number_format($expected_closing_balance, 0, ',', '.') }}</p>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Base + Ingresos - Egresos</p>
            </div>
        </div>

        <!-- Tabla de Movimientos -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs overflow-hidden">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-800">
                <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Movimientos de Hoy</h3>
            </div>
            
            <!-- DESKTOP TABLE -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-xs whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 text-zinc-500 dark:text-zinc-400 font-semibold uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                            <th class="px-4 py-3">Hora</th>
                            <th class="px-4 py-3">Tipo</th>
                            <th class="px-4 py-3">Descripción</th>
                            <th class="px-4 py-3">Orden Relacionada</th>
                            <th class="px-4 py-3">Método</th>
                            <th class="px-4 py-3">Usuario</th>
                            <th class="px-4 py-3 text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition">
                                <td class="px-4 py-3 font-mono text-zinc-500 dark:text-zinc-400 text-[11px]">{{ $payment->created_at->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    @if($payment->type === 'income')
                                        <x-ui.badge variant="success" size="xs">Ingreso</x-ui.badge>
                                    @else
                                        <x-ui.badge variant="danger" size="xs">Egreso</x-ui.badge>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-medium text-zinc-800 dark:text-zinc-200">{{ $payment->description ?: 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    @if($payment->work_order_id)
                                        <a href="{{ route('work-orders.index') }}" class="text-orange-600 dark:text-orange-400 hover:underline font-mono text-xs font-semibold transition">
                                            #{{ substr($payment->workOrder->uuid, 0, 8) }}
                                        </a>
                                    @else
                                        <span class="text-zinc-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-zinc-600 dark:text-zinc-300">{{ $payment->payment_method }}</td>
                                <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">{{ $payment->user->name }}</td>
                                <td class="px-4 py-3 text-right font-bold {{ $payment->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $payment->type === 'income' ? '+' : '-' }}${{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-zinc-400 dark:text-zinc-500 text-xs">
                                    No hay movimientos registrados hoy.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- MOBILE CARDS -->
            <div class="md:hidden flex flex-col gap-2.5 p-3">
                @forelse($payments as $payment)
                    <div class="bg-zinc-50 dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-800 rounded-lg p-3 flex flex-col gap-2">
                        <div class="flex justify-between items-start border-b border-zinc-200/80 dark:border-zinc-800 pb-2">
                            <div>
                                <span class="text-[11px] font-mono text-zinc-400">{{ $payment->created_at->format('H:i') }}</span>
                                <span class="block text-xs font-semibold text-zinc-900 dark:text-zinc-100 mt-0.5">{{ $payment->description ?: 'Sin descripción' }}</span>
                            </div>
                            @if($payment->type === 'income')
                                <x-ui.badge variant="success" size="xs">Ingreso</x-ui.badge>
                            @else
                                <x-ui.badge variant="danger" size="xs">Egreso</x-ui.badge>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Orden</span>
                                @if($payment->work_order_id)
                                    <a href="{{ route('work-orders.index') }}" class="text-orange-600 dark:text-orange-400 font-mono text-xs font-semibold">#{{ substr($payment->workOrder->uuid, 0, 8) }}</a>
                                @else
                                    <span class="text-zinc-400 text-xs">-</span>
                                @endif
                            </div>
                            <div>
                                <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Método</span>
                                <span class="text-xs text-zinc-600 dark:text-zinc-300">{{ $payment->payment_method }}</span>
                            </div>
                            <div class="col-span-2 pt-1 border-t border-zinc-200/60 dark:border-zinc-800 flex items-center justify-between">
                                <span class="text-[11px] text-zinc-500">{{ $payment->user->name }}</span>
                                <span class="text-xs font-bold {{ $payment->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $payment->type === 'income' ? '+' : '-' }}${{ number_format($payment->amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-zinc-400 text-xs">No hay movimientos registrados hoy.</div>
                @endforelse
            </div>
        </div>

        <!-- MODAL CERRAR CAJA -->
        @if($showCloseModal)
        <div class="fixed inset-0 z-[100] overflow-y-auto overscroll-contain flex items-center justify-center p-4 bg-zinc-950/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 rounded-xl max-w-md w-full max-h-[90dvh] overflow-y-auto overscroll-contain border border-zinc-200 dark:border-zinc-800 shadow-2xl p-5 relative my-auto">
                <button wire:click="$set('showCloseModal', false)" class="absolute top-4 right-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-pointer">
                    <x-ui.icon name="x" class="w-5 h-5" />
                </button>
                
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="p-2 rounded-lg bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/50">
                        <x-ui.icon name="lock" class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">Cierre de Caja</h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Ingresa el conteo físico real de dinero</p>
                    </div>
                </div>

                @if(auth()->user()->isAdmin())
                    <div class="bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 p-3 rounded-lg mb-4 flex justify-between items-center text-xs">
                        <span class="text-zinc-600 dark:text-zinc-300 font-medium">Esperado en Sistema (Admin):</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($expected_closing_balance, 0, ',', '.') }}</span>
                    </div>
                @else
                    <div class="bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900/40 p-3 rounded-lg mb-4 flex items-center gap-2.5 text-xs text-amber-800 dark:text-amber-300">
                        <x-ui.icon name="alert-triangle" class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0" />
                        <span>Arqueo Ciego Asistido: Cuenta físicamente el dinero de la caja y digita los montos contados.</span>
                    </div>
                @endif

                <form wire:submit="closeRegister" class="space-y-3.5">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Efectivo Físico en Gaveta</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-zinc-400 text-xs font-semibold">$</span>
                            <input wire:model.live="closing_cash" type="number" step="0.01" placeholder="Ej: 50000" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-2 pl-7 pr-3 text-zinc-900 dark:text-zinc-100 text-xs font-semibold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/30 transition">
                        </div>
                        @if(auth()->user()->isAdmin())
                            <p class="text-[10px] text-zinc-400 mt-1">Esperado: ${{ number_format($expected_cash, 0, ',', '.') }}</p>
                        @endif
                        @error('closing_cash') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Transferencias Contadas</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-zinc-400 text-xs font-semibold">$</span>
                            <input wire:model.live="closing_transfer" type="number" step="0.01" placeholder="Ej: 120000" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-2 pl-7 pr-3 text-zinc-900 dark:text-zinc-100 text-xs font-semibold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/30 transition">
                        </div>
                        @if(auth()->user()->isAdmin())
                            <p class="text-[10px] text-zinc-400 mt-1">Esperado: ${{ number_format($expected_transfer, 0, ',', '.') }}</p>
                        @endif
                        @error('closing_transfer') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Tarjetas / Vouchers (Transbank)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-zinc-400 text-xs font-semibold">$</span>
                            <input wire:model.live="closing_card" type="number" step="0.01" placeholder="Ej: 75000" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-2 pl-7 pr-3 text-zinc-900 dark:text-zinc-100 text-xs font-semibold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/30 transition">
                        </div>
                        @if(auth()->user()->isAdmin())
                            <p class="text-[10px] text-zinc-400 mt-1">Esperado: ${{ number_format($expected_card, 0, ',', '.') }}</p>
                        @endif
                        @error('closing_card') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">
                            Observaciones / Justificación de Descuadre
                        </label>
                        <textarea wire:model="closing_notes" rows="2" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2.5 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/30 transition resize-none" placeholder="Si el conteo difiere del sistema, explica aquí la causa..."></textarea>
                        @error('closing_notes') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-2.5 pt-2">
                        <button 
                            type="button" 
                            wire:click="$set('showCloseModal', false)" 
                            class="flex-1 py-2 px-3 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 rounded-lg text-xs font-semibold transition cursor-pointer"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit" 
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-3 rounded-lg text-xs shadow-xs transition duration-150 cursor-pointer"
                        >
                            Confirmar Cierre
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    @endif

    <!-- Historial de Cajas Cerradas -->
    @if(isset($recentRegisters))
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs overflow-hidden mt-6">
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Historial de Cajas</h3>
            
            <!-- Buscador -->
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                    <x-ui.icon name="search" class="w-4 h-4" />
                </span>
                <input wire:model.live.debounce.300ms="searchRegister" type="text" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-1.5 pl-9 pr-3 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/30 transition" placeholder="Buscar por ID o responsable...">
            </div>
        </div>

        <!-- DESKTOP TABLE -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 text-zinc-500 dark:text-zinc-400 font-semibold uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                        <th class="px-4 py-3">ID Caja</th>
                        <th class="px-4 py-3">Apertura</th>
                        <th class="px-4 py-3">Cierre</th>
                        <th class="px-4 py-3 text-right">Monto Final</th>
                        <th class="px-4 py-3">Responsable</th>
                        <th class="px-4 py-3 text-center">Tipo Cierre</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($recentRegisters as $reg)
                        <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition">
                            <td class="px-4 py-3 font-mono font-semibold text-zinc-700 dark:text-zinc-300 text-xs">#{{ $reg->id }}</td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{{ $reg->opened_at ? $reg->opened_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td class="px-4 py-3 text-zinc-800 dark:text-zinc-200 text-xs">
                                {{ $reg->closed_at ? $reg->closed_at->format('d/m/Y H:i') : 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($reg->closing_balance ?? 0, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{{ $reg->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($reg->notes && str_contains($reg->notes, 'automático'))
                                    <x-ui.badge variant="warning" size="xs">Auto</x-ui.badge>
                                @else
                                    <x-ui.badge variant="success" size="xs">Manual</x-ui.badge>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="/caja/{{ $reg->id }}/print" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 text-zinc-700 dark:text-zinc-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-950/30 rounded border border-zinc-200 dark:border-zinc-700 text-xs font-medium transition">
                                    <x-ui.icon name="printer" class="w-3.5 h-3.5" />
                                    <span>Imprimir</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-zinc-400 dark:text-zinc-500 text-xs">
                                No se encontraron registros de caja.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
        <div class="md:hidden flex flex-col gap-2.5 p-3">
            @forelse($recentRegisters as $reg)
                <div class="bg-zinc-50 dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-800 rounded-lg p-3 flex flex-col gap-2.5">
                    <div class="flex justify-between items-center border-b border-zinc-200/80 dark:border-zinc-800 pb-2">
                        <span class="text-xs font-bold font-mono text-zinc-800 dark:text-zinc-200">Caja #{{ $reg->id }}</span>
                        @if($reg->notes && str_contains($reg->notes, 'automático'))
                            <x-ui.badge variant="warning" size="xs">Cierre Auto</x-ui.badge>
                        @else
                            <x-ui.badge variant="success" size="xs">Cierre Manual</x-ui.badge>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Apertura</span>
                            <span class="text-zinc-600 dark:text-zinc-300">{{ $reg->opened_at ? $reg->opened_at->format('d/m H:i') : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Cierre</span>
                            <span class="text-zinc-800 dark:text-zinc-200">{{ $reg->closed_at ? $reg->closed_at->format('d/m H:i') : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Monto Final</span>
                            <span class="font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($reg->closing_balance ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Responsable</span>
                            <span class="text-zinc-500">{{ $reg->user->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="pt-1.5 border-t border-zinc-200/60 dark:border-zinc-800">
                        <a href="/caja/{{ $reg->id }}/print" target="_blank" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 text-xs font-medium rounded-lg border border-zinc-200 dark:border-zinc-700 transition">
                            <x-ui.icon name="printer" class="w-3.5 h-3.5" />
                            <span>Imprimir Comprobante</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-zinc-400 text-xs">No se encontraron registros de caja.</div>
            @endforelse
        </div>
        
        @if($recentRegisters->hasPages())
            <div class="p-3 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                {{ $recentRegisters->links() }}
            </div>
        @endif
    </div>
    @endif

    <!-- MODAL ABRIR CAJA -->
    @if($showOpenModal)
    <div class="fixed inset-0 z-[100] overflow-y-auto overscroll-contain flex items-center justify-center p-4 bg-zinc-950/70 backdrop-blur-xs">
        <div class="bg-white dark:bg-zinc-900 rounded-xl max-w-sm w-full max-h-[90dvh] overflow-y-auto overscroll-contain border border-zinc-200 dark:border-zinc-800 shadow-2xl p-5 relative my-auto">
            <button wire:click="$set('showOpenModal', false)" class="absolute top-4 right-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-pointer">
                <x-ui.icon name="x" class="w-5 h-5" />
            </button>
            
            <div class="flex items-center gap-2.5 mb-3">
                <div class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60">
                    <x-ui.icon name="plus" class="w-5 h-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">Abrir Caja</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Ingresa el monto base para iniciar</p>
                </div>
            </div>

            <form wire:submit="openRegister" class="space-y-4">
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Monto Inicial (Base)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-zinc-400 font-semibold text-xs">$</span>
                        <input wire:model="opening_balance" type="number" step="0.01" placeholder="Ej: 50000" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-2 pl-7 pr-3 text-zinc-900 dark:text-zinc-100 font-semibold text-xs focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/30 transition">
                    </div>
                    @error('opening_balance') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-2.5 pt-1">
                    <button 
                        type="button" 
                        wire:click="$set('showOpenModal', false)" 
                        class="flex-1 py-2 px-3 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 rounded-lg text-xs font-semibold transition cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button 
                        type="submit" 
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-3 rounded-lg text-xs shadow-xs transition duration-150 cursor-pointer flex justify-center items-center gap-1.5"
                    >
                        <span wire:loading wire:target="openRegister" class="w-3.5 h-3.5 border-2 border-white/20 border-t-white rounded-full animate-spin"></span>
                        Iniciar Turno
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>