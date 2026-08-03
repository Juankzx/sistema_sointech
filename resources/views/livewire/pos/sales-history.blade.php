<div class="space-y-6 animate-fade-in">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Historial de Ventas</h1>
            <p class="text-sm text-gray-400 mt-1">Revisa los detalles de todas las ventas realizadas por los usuarios.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-gray-850 p-4 rounded-3xl border border-gray-800 shadow-xl flex flex-col md:flex-row gap-4 items-end">
        <div class="flex-1 w-full">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Buscar</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cliente, Usuario, Código..." class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 pl-10 pr-4 text-white text-sm focus:outline-none focus:border-orange-500 transition">
            </div>
        </div>
        
        <div class="w-full md:w-auto">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Desde</label>
            <input wire:model.live="dateFrom" type="date" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-white text-sm focus:outline-none focus:border-orange-500 transition" max="{{ date('Y-m-d') }}">
        </div>

        <div class="w-full md:w-auto">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Hasta</label>
            <input wire:model.live="dateTo" type="date" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-white text-sm focus:outline-none focus:border-orange-500 transition" max="{{ date('Y-m-d') }}">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden">
        <!-- DESKTOP TABLE -->
        <div class="hidden md:block overflow-x-auto theme-scrollbar">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-900/40 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Código Venta</th>
                        <th class="px-6 py-4">Cliente</th>
                        <th class="px-6 py-4">Artículos</th>
                        <th class="px-6 py-4">Método Pago</th>
                        <th class="px-6 py-4">Usuario</th>
                        <th class="px-6 py-4 text-right">Total</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-gray-900/20 transition">
                            <td class="px-6 py-4 text-xs text-gray-400">
                                {{ $sale->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-bold text-orange-400">#{{ substr($sale->uuid, 0, 8) }}</span>
                            </td>
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $sale->client_name }}
                                @if($sale->client_phone)
                                    <span class="block text-[10px] text-gray-500">{{ $sale->client_phone }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    @foreach($sale->items as $item)
                                        <span class="text-[11px] text-gray-400">{{ $item->quantity }}x {{ $item->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-300">
                                {{ $sale->payment_method }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-400">
                                {{ $sale->user ? $sale->user->name : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-right font-black text-white">
                                ${{ number_format($sale->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('sales.print', $sale->id) }}" target="_blank" class="px-3 py-1.5 bg-orange-500/10 hover:bg-orange-500/20 text-orange-400 border border-orange-500/20 rounded-xl text-xs font-bold transition inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    <span>Imprimir Comprobante</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                No se encontraron ventas registradas con los filtros actuales.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
        <div class="md:hidden flex flex-col gap-3 p-4">
            @forelse($sales as $sale)
                <div class="bg-gray-800/50 border border-gray-700/60 rounded-2xl p-4 flex flex-col gap-3">
                    <div class="flex justify-between items-center border-b border-gray-700/50 pb-2">
                        <span class="font-mono text-xs font-bold text-orange-400">#{{ substr($sale->uuid, 0, 8) }}</span>
                        <span class="text-[10px] text-gray-400">{{ $sale->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="col-span-2">
                            <span class="block text-[10px] text-gray-500 uppercase">Cliente</span>
                            <span class="text-white font-medium">{{ $sale->client_name }}</span>
                            @if($sale->client_phone)
                                <span class="block text-[10px] text-gray-400">{{ $sale->client_phone }}</span>
                            @endif
                        </div>
                        <div class="col-span-2">
                            <span class="block text-[10px] text-gray-500 uppercase">Artículos</span>
                            <div class="flex flex-col gap-1 mt-1">
                                @foreach($sale->items as $item)
                                    <span class="text-[11px] text-gray-400">- {{ $item->quantity }}x {{ $item->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Método Pago</span>
                            <span class="text-xs text-gray-300">{{ $sale->payment_method }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Usuario</span>
                            <span class="text-xs text-gray-400">{{ $sale->user ? $sale->user->name : 'N/A' }}</span>
                        </div>
                        <div class="col-span-2 pt-2 border-t border-gray-700/50 mt-1 flex justify-between items-center">
                            <span class="block text-[10px] text-gray-500 uppercase">Total</span>
                            <span class="text-sm font-black text-white">${{ number_format($sale->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-gray-500 text-sm">No se encontraron ventas.</div>
            @endforelse
        </div>
        
        @if($sales->hasPages())
            <div class="px-6 py-4 border-t border-gray-800">
                {{ $sales->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>
</div>
