<div class="space-y-6 animate-fade-in" wire:poll.visible.8s>
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Caja Diaria</h1>
            <p class="text-sm text-gray-400 mt-1">Apertura, cierre y registro de movimientos financieros diarios.</p>
        </div>
        
        @if(!$activeRegister)
            <button wire:click="$set('showOpenModal', true)" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold px-4 py-3 rounded-2xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition duration-200 self-start sm:self-center cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Abrir Caja del Día
            </button>
        @else
            <div class="flex items-center gap-3">
                <div class="bg-emerald-950/50 border border-emerald-500/30 text-emerald-400 px-4 py-2.5 rounded-2xl flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-sm font-bold">Caja Abierta</span>
                </div>
                <button wire:click="openCloseModal" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-500 text-white text-sm font-bold px-4 py-2.5 rounded-2xl shadow-lg shadow-red-500/20 hover:shadow-red-500/40 transition duration-200 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Cerrar Caja
                </button>
            </div>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 px-5 py-4 rounded-2xl shadow-lg flex items-center gap-3 animate-fade-in">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="text-sm font-bold">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-950/60 border border-red-500/40 text-red-300 px-5 py-4 rounded-2xl shadow-lg flex items-center gap-3 animate-fade-in">
            <span class="w-2.5 h-2.5 rounded-full bg-red-400 animate-ping"></span>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
    @endif

    @if(!$activeRegister)
        <!-- Caja Cerrada State -->
        <div class="bg-gray-850 p-8 rounded-3xl border border-gray-800 shadow-xl text-center space-y-4">
            <div class="w-20 h-20 bg-gray-900 rounded-full mx-auto flex items-center justify-center border border-gray-700">
                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h2 class="text-xl font-bold text-white">La caja está cerrada</h2>
            <p class="text-gray-400 max-w-md mx-auto">Para poder ingresar equipos con abonos o registrar pagos, debes realizar la apertura de caja indicando el monto inicial (base).</p>
        </div>

    @else
        <!-- Dashboard de Caja Abierta -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-850 p-6 rounded-3xl border border-gray-800 shadow-xl">
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-2">Base Inicial</p>
                <p class="text-3xl font-black text-white">${{ number_format($activeRegister->opening_balance, 0, ',', '.') }}</p>
                <p class="text-[10px] text-gray-500 mt-2">Apertura: {{ $activeRegister->opened_at->format('H:i') }} por {{ $activeRegister->user->name }}</p>
            </div>
            
            <div class="bg-gray-850 p-6 rounded-3xl border border-gray-800 shadow-xl relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl"></div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-2">Ingresos del Día</p>
                <p class="text-3xl font-black text-emerald-400">+${{ number_format($activeRegister->payments()->where('type', 'income')->sum('amount'), 0, ',', '.') }}</p>
                <p class="text-[10px] text-gray-500 mt-2">Total recaudado en efectivo/transferencias</p>
            </div>

            <div class="bg-gray-850 p-6 rounded-3xl border border-gray-800 shadow-xl relative overflow-hidden border-b-4 border-b-blue-500">
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-2">Total Estimado en Caja</p>
                <p class="text-4xl font-black text-white">${{ number_format($expected_closing_balance, 0, ',', '.') }}</p>
                <p class="text-[10px] text-gray-500 mt-2">Base + Ingresos - Egresos</p>
            </div>
        </div>

        <!-- Tabla de Movimientos -->
        <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden mt-6">
            <div class="p-5 border-b border-gray-800">
                <h3 class="text-lg font-bold text-white">Movimientos de Hoy</h3>
            </div>
            <!-- DESKTOP TABLE -->
            <div class="hidden md:block overflow-x-auto theme-scrollbar">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-900/40 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                            <th class="px-6 py-4">Hora</th>
                            <th class="px-6 py-4">Tipo</th>
                            <th class="px-6 py-4">Descripción</th>
                            <th class="px-6 py-4">Orden Relacionada</th>
                            <th class="px-6 py-4">Método</th>
                            <th class="px-6 py-4">Usuario</th>
                            <th class="px-6 py-4 text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/60">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-900/20 transition">
                                <td class="px-6 py-4 text-xs text-gray-400">{{ $payment->created_at->format('H:i') }}</td>
                                <td class="px-6 py-4">
                                    @if($payment->type === 'income')
                                        <span class="px-2 py-1 bg-emerald-950/40 text-emerald-400 border border-emerald-500/20 rounded-md text-[10px] font-bold uppercase">Ingreso</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-950/40 text-red-400 border border-red-500/20 rounded-md text-[10px] font-bold uppercase">Egreso</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-white">{{ $payment->description ?: 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    @if($payment->work_order_id)
                                        <a href="{{ route('work-orders.index') }}" class="text-blue-400 hover:text-blue-300 font-mono text-xs font-bold transition">
                                            #{{ substr($payment->workOrder->uuid, 0, 8) }}
                                        </a>
                                    @else
                                        <span class="text-gray-500 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-300">{{ $payment->payment_method }}</td>
                                <td class="px-6 py-4 text-xs text-gray-400">{{ $payment->user->name }}</td>
                                <td class="px-6 py-4 text-right font-bold {{ $payment->type === 'income' ? 'text-emerald-400' : 'text-red-400' }}">
                                    {{ $payment->type === 'income' ? '+' : '-' }}${{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    No hay movimientos registrados hoy.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- MOBILE CARDS -->
            <div class="md:hidden flex flex-col gap-3 p-4">
                @forelse($payments as $payment)
                    <div class="bg-gray-800/50 border border-gray-700/60 rounded-2xl p-4 flex flex-col gap-2">
                        <div class="flex justify-between items-start border-b border-gray-700/50 pb-2">
                            <div>
                                <span class="text-xs font-bold text-gray-300">{{ $payment->created_at->format('H:i') }}</span>
                                <span class="block text-sm font-medium text-white mt-0.5">{{ $payment->description ?: 'Sin descripción' }}</span>
                            </div>
                            @if($payment->type === 'income')
                                <span class="px-2 py-1 bg-emerald-950/40 text-emerald-400 border border-emerald-500/20 rounded-md text-[10px] font-bold uppercase">Ingreso</span>
                            @else
                                <span class="px-2 py-1 bg-red-950/40 text-red-400 border border-red-500/20 rounded-md text-[10px] font-bold uppercase">Egreso</span>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-2 mt-1">
                            <div>
                                <span class="block text-[10px] text-gray-500 uppercase">Orden</span>
                                @if($payment->work_order_id)
                                    <a href="{{ route('work-orders.index') }}" class="text-blue-400 text-xs font-mono font-bold">#{{ substr($payment->workOrder->uuid, 0, 8) }}</a>
                                @else
                                    <span class="text-gray-500 text-xs">-</span>
                                @endif
                            </div>
                            <div>
                                <span class="block text-[10px] text-gray-500 uppercase">Método</span>
                                <span class="text-xs text-gray-300">{{ $payment->payment_method }}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="block text-[10px] text-gray-500 uppercase">Monto</span>
                                <span class="text-sm font-bold {{ $payment->type === 'income' ? 'text-emerald-400' : 'text-red-400' }}">
                                    {{ $payment->type === 'income' ? '+' : '-' }}${{ number_format($payment->amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500 text-sm">No hay movimientos registrados hoy.</div>
                @endforelse
            </div>
        </div>

        <!-- MODAL CERRAR CAJA -->
        @if($showCloseModal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/80 backdrop-blur-sm animate-fade-in">
            <div class="bg-gray-850 rounded-3xl max-w-md w-full border border-gray-700 shadow-2xl p-6 relative">
                <button wire:click="$set('showCloseModal', false)" class="absolute top-4 right-4 text-gray-500 hover:text-white cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <h3 class="text-xl font-black text-white mb-1">Cierre de Caja</h3>
                <p class="text-xs text-gray-400 mb-4">Ingresa el conteo físico real de dinero en gaveta, transferencias y vouchers.</p>

                @if(auth()->user()->isAdmin())
                    <div class="bg-blue-950/30 border border-blue-500/20 p-3.5 rounded-2xl mb-4 flex justify-between items-center">
                        <span class="text-xs font-semibold text-blue-300">Esperado en Sistema (Admin):</span>
                        <span class="text-base font-black text-white">${{ number_format($expected_closing_balance, 0, ',', '.') }}</span>
                    </div>
                @else
                    <div class="bg-amber-950/30 border border-amber-500/30 p-3.5 rounded-2xl mb-4 flex items-center gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-xs font-semibold text-amber-300">Arqueo Ciego Asistido: Cuenta físicamente el dinero de la caja y digita los montos contados.</span>
                    </div>
                @endif

                <form wire:submit="closeRegister" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Efectivo Físico en Gaveta</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">$</span>
                            <input wire:model.live="closing_cash" type="number" step="0.01" placeholder="Ej: 50000" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-3 pl-8 pr-4 text-white font-bold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/50 transition">
                        </div>
                        @if(auth()->user()->isAdmin())
                            <p class="text-[10px] text-gray-500 mt-1">Esperado: ${{ number_format($expected_cash, 0, ',', '.') }}</p>
                        @endif
                        @error('closing_cash') <span class="text-red-400 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Transferencias Contadas</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">$</span>
                            <input wire:model.live="closing_transfer" type="number" step="0.01" placeholder="Ej: 120000" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-3 pl-8 pr-4 text-white font-bold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/50 transition">
                        </div>
                        @if(auth()->user()->isAdmin())
                            <p class="text-[10px] text-gray-500 mt-1">Esperado: ${{ number_format($expected_transfer, 0, ',', '.') }}</p>
                        @endif
                        @error('closing_transfer') <span class="text-red-400 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tarjetas / Vouchers (Transbank)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">$</span>
                            <input wire:model.live="closing_card" type="number" step="0.01" placeholder="Ej: 75000" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-3 pl-8 pr-4 text-white font-bold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/50 transition">
                        </div>
                        @if(auth()->user()->isAdmin())
                            <p class="text-[10px] text-gray-500 mt-1">Esperado: ${{ number_format($expected_card, 0, ',', '.') }}</p>
                        @endif
                        @error('closing_card') <span class="text-red-400 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">
                            Observaciones / Justificación de Descuadre
                        </label>
                        <textarea wire:model="closing_notes" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl p-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition" placeholder="Si el conteo difiere del sistema, explica aquí la causa..."></textarea>
                        @error('closing_notes') <span class="text-red-400 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 text-white font-black py-4 px-6 rounded-2xl text-sm shadow-lg shadow-red-500/20 transition duration-200 cursor-pointer mt-2">
                        CONFIRMAR Y FINALIZAR CIERRE
                    </button>
                </form>
            </div>
        </div>
        @endif
    @endif

    <!-- Historial de Cajas Cerradas (siempre visible) -->
    @if(isset($recentRegisters))
    <div class="mt-8 bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden">
        <div class="p-5 border-b border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-white">Historial de Cajas</h3>
            
            <!-- Buscador -->
            <div class="relative w-full sm:w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input wire:model.live.debounce.300ms="searchRegister" type="text" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition" placeholder="Buscar por ID o responsable...">
            </div>
        </div>

        <!-- DESKTOP TABLE -->
        <div class="hidden md:block overflow-x-auto theme-scrollbar">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-900/40 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                        <th class="px-6 py-4">ID Caja</th>
                        <th class="px-6 py-4">Apertura</th>
                        <th class="px-6 py-4">Cierre</th>
                        <th class="px-6 py-4 text-right">Monto Final</th>
                        <th class="px-6 py-4">Responsable</th>
                        <th class="px-6 py-4 text-center">Tipo Cierre</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($recentRegisters as $reg)
                        <tr class="hover:bg-gray-900/20 transition">
                            <td class="px-6 py-4 text-xs font-bold text-gray-300">#{{ $reg->id }}</td>
                            <td class="px-6 py-4 text-xs text-gray-400">{{ $reg->opened_at ? $reg->opened_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td class="px-6 py-4 text-xs font-medium text-white">
                                {{ $reg->closed_at ? $reg->closed_at->format('d/m/Y H:i') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-right font-black text-white">${{ number_format($reg->closing_balance ?? 0, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-xs text-gray-400">{{ $reg->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($reg->notes && str_contains($reg->notes, 'automático'))
                                    <span class="px-2 py-0.5 bg-amber-950/50 text-amber-400 text-[9px] font-black rounded border border-amber-500/20 uppercase">Auto</span>
                                @else
                                    <span class="px-2 py-0.5 bg-emerald-950/50 text-emerald-400 text-[9px] font-black rounded border border-emerald-500/20 uppercase">Manual</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="/caja/{{ $reg->id }}/print" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 text-xs font-bold rounded-lg border border-blue-500/20 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Imprimir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                No se encontraron registros de caja.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
        <div class="md:hidden flex flex-col gap-3 p-4">
            @forelse($recentRegisters as $reg)
                <div class="bg-gray-800/50 border border-gray-700/60 rounded-2xl p-4 flex flex-col gap-3">
                    <div class="flex justify-between items-center border-b border-gray-700/50 pb-2">
                        <span class="text-xs font-bold text-gray-300">Caja #{{ $reg->id }}</span>
                        @if($reg->notes && str_contains($reg->notes, 'automático'))
                            <span class="px-2 py-0.5 bg-amber-950/50 text-amber-400 text-[9px] font-black rounded border border-amber-500/20 uppercase">Cierre Auto</span>
                        @else
                            <span class="px-2 py-0.5 bg-emerald-950/50 text-emerald-400 text-[9px] font-black rounded border border-emerald-500/20 uppercase">Cierre Manual</span>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Apertura</span>
                            <span class="text-gray-300">{{ $reg->opened_at ? $reg->opened_at->format('d/m H:i') : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Cierre</span>
                            <span class="text-white">{{ $reg->closed_at ? $reg->closed_at->format('d/m H:i') : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Monto Final</span>
                            <span class="font-black text-white">${{ number_format($reg->closing_balance ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Responsable</span>
                            <span class="text-gray-400">{{ $reg->user->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="pt-2">
                        <a href="/caja/{{ $reg->id }}/print" target="_blank" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 text-xs font-bold rounded-xl border border-blue-500/20 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Imprimir
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-gray-500 text-sm">No se encontraron registros de caja.</div>
            @endforelse
        </div>
        
        @if($recentRegisters->hasPages())
            <div class="p-4 border-t border-gray-800 bg-gray-900/30">
                {{ $recentRegisters->links() }}
            </div>
        @endif
    </div>
    @endif

    <!-- MODAL ABRIR CAJA -->
    @if($showOpenModal)
    <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/80 backdrop-blur-sm animate-fade-in">
        <div class="bg-gray-850 rounded-3xl max-w-sm w-full border border-gray-700 shadow-2xl p-6 relative">
            <button wire:click="$set('showOpenModal', false)" class="absolute top-4 right-4 text-gray-500 hover:text-white cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="w-12 h-12 bg-emerald-500/10 rounded-full flex items-center justify-center text-emerald-400 mb-4 border border-emerald-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </div>
            
            <h3 class="text-xl font-black text-white mb-2">Abrir Caja</h3>
            <p class="text-xs text-gray-400 mb-6">Ingresa el monto base (sencillo) con el que inicia el turno.</p>

            <form wire:submit="openRegister" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Monto Inicial (Base)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">$</span>
                        <input wire:model="opening_balance" type="number" step="0.01" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-3 pl-8 pr-4 text-white font-bold focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/50 transition">
                    </div>
                    @error('opening_balance') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 px-6 rounded-2xl text-sm shadow-lg shadow-emerald-500/20 transition duration-200 cursor-pointer mt-2 flex justify-center gap-2">
                    <span wire:loading wire:target="openRegister" class="animate-spin">⏳</span>
                    INICIAR TURNO
                </button>
            </form>
        </div>
    </div>
    @endif
</div>