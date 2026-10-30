<div class="space-y-6 pb-16 md:pb-6" wire:poll.visible.10s>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50">
                    <x-ui.icon name="receipt" class="w-5 h-5" />
                </span>
                Historial de Ventas
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Revisa el historial de ventas, comprobantes y envíos por WhatsApp.</p>
        </div>

        <div class="flex items-center gap-2 self-start sm:self-auto">
            <div class="px-3 py-1.5 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-xs font-medium text-zinc-600 dark:text-zinc-300 shadow-xs flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Total Ventas: <span class="text-zinc-900 dark:text-zinc-100 font-bold">${{ number_format($totalActiveSales, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session()->has('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" />
            <span class="text-emerald-800 dark:text-emerald-300 text-xs font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="alert-triangle" class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" />
            <span class="text-red-800 dark:text-red-300 text-xs font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filters Bar -->
    <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 items-end">
            <!-- Search -->
            <div class="md:col-span-6 w-full min-w-0">
                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Buscar Venta</label>
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-zinc-400 dark:text-zinc-500 pointer-events-none">
                        <x-ui.icon name="search" class="w-4 h-4" />
                    </span>
                    <input 
                        wire:model.live.debounce.300ms="search" 
                        type="text" 
                        placeholder="Cliente, teléfono, código #..." 
                        class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 focus:border-orange-500 rounded-lg py-2 pl-9 pr-8 text-zinc-900 dark:text-zinc-100 text-xs placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-1 focus:ring-orange-500/30 transition duration-150"
                    >
                    @if($search)
                        <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                            <x-ui.icon name="x" class="w-3.5 h-3.5" />
                        </button>
                    @endif
                </div>
            </div>
            
            <!-- Dates -->
            <div class="md:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-3 w-full">
                <div class="w-full">
                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Desde</label>
                    <input 
                        wire:model.live="dateFrom" 
                        type="date" 
                        class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 focus:border-orange-500 rounded-lg py-2 px-3 text-zinc-900 dark:text-zinc-100 text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/30 transition duration-150" 
                        max="{{ date('Y-m-d') }}"
                    >
                </div>

                <div class="w-full">
                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Hasta</label>
                    <input 
                        wire:model.live="dateTo" 
                        type="date" 
                        class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 focus:border-orange-500 rounded-lg py-2 px-3 text-zinc-900 dark:text-zinc-100 text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/30 transition duration-150" 
                        max="{{ date('Y-m-d') }}"
                    >
                </div>
            </div>
        </div>
    </div>

    <!-- Content Container -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs overflow-hidden">
        
        <!-- DESKTOP TABLE -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-xs table-fixed">
                <colgroup>
                    <col class="w-[4%]">  {{-- N° --}}
                    <col class="w-[10%]"> {{-- Fecha --}}
                    <col class="w-[9%]">  {{-- Código --}}
                    <col class="w-[15%]"> {{-- Cliente --}}
                    <col class="w-[24%]"> {{-- Detalle --}}
                    <col class="w-[10%]"> {{-- Método Pago --}}
                    <col class="w-[9%]">  {{-- Usuario --}}
                    <col class="w-[8%]">  {{-- Total --}}
                    <col class="w-[11%]"> {{-- Acciones --}}
                </colgroup>
                <thead>
                    <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 text-zinc-500 dark:text-zinc-400 font-semibold uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                        <th class="px-2 py-3 text-center">#</th>
                        <th class="px-3 py-3">Fecha</th>
                        <th class="px-3 py-3">Código</th>
                        <th class="px-3 py-3">Cliente</th>
                        <th class="px-3 py-3">Detalle Artículos</th>
                        <th class="px-3 py-3">Pago</th>
                        <th class="px-3 py-3">Usuario</th>
                        <th class="px-3 py-3 text-right">Total</th>
                        <th class="px-3 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($sales as $index => $sale)
                        <tr class="{{ $sale->isVoided() ? 'opacity-60 bg-red-50/40 dark:bg-red-950/10' : 'hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40' }} transition duration-150">
                            <td class="px-2 py-3 text-center font-mono font-medium text-zinc-400 dark:text-zinc-500 text-[11px] align-top">
                                {{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-3 py-3 align-top">
                                <div class="flex flex-col leading-tight">
                                    <span class="text-zinc-800 dark:text-zinc-200 font-medium text-[11px] {{ $sale->isVoided() ? 'line-through' : '' }}">{{ $sale->created_at->format('d/m/Y') }}</span>
                                    <span class="text-[10px] text-zinc-400 dark:text-zinc-500 mt-0.5">{{ $sale->created_at->format('H:i') }} hrs</span>
                                </div>
                            </td>
                            <td class="px-3 py-3 align-top">
                                <span class="font-mono text-[11px] font-semibold {{ $sale->isVoided() ? 'text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-950/30 border-red-200 dark:border-red-900/40' : 'text-orange-700 dark:text-orange-400 bg-orange-50 dark:bg-orange-950/30 border-orange-200 dark:border-orange-900/40' }} px-2 py-0.5 rounded border inline-block">
                                    #{{ substr($sale->uuid, 0, 7) }}
                                </span>
                            </td>
                            <td class="px-3 py-3 align-top">
                                <div class="flex flex-col leading-tight min-w-0">
                                    <span class="text-zinc-900 dark:text-zinc-100 font-semibold text-[11px] truncate {{ $sale->isVoided() ? 'line-through' : '' }}" title="{{ $sale->client_name }}">{{ $sale->client_name }}</span>
                                    @if($sale->client_phone)
                                        <span class="text-[10px] text-zinc-500 dark:text-zinc-400 font-mono flex items-center gap-1 mt-0.5">
                                            <x-ui.icon name="phone" class="w-2.5 h-2.5 text-zinc-400" />
                                            <span class="truncate">{{ $sale->client_phone }}</span>
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3 align-top">
                                <div class="flex flex-col gap-1 {{ $sale->isVoided() ? 'line-through' : '' }}">
                                    @foreach($sale->items->take(3) as $item)
                                        <div class="flex items-start gap-1.5 text-zinc-700 dark:text-zinc-300 leading-tight">
                                            <span class="px-1 py-0 rounded bg-zinc-100 dark:bg-zinc-800 text-[9px] font-bold text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 shrink-0 mt-px">{{ $item->quantity }}x</span>
                                            <span class="text-[11px] break-words line-clamp-1" title="{{ $item->name }}">{{ $item->name }}</span>
                                        </div>
                                    @endforeach
                                    @if($sale->items->count() > 3)
                                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500 italic pl-0.5">+{{ $sale->items->count() - 3 }} más...</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3 align-top">
                                @php
                                    $method = strtolower($sale->payment_method ?? '');
                                    $badgeVariant = match(true) {
                                        str_contains($method, 'efectivo') => 'success',
                                        str_contains($method, 'transf') => 'info',
                                        str_contains($method, 'débito') || str_contains($method, 'credito') || str_contains($method, 'tarjeta') => 'blue',
                                        default => 'neutral'
                                    };
                                @endphp
                                <x-ui.badge :variant="$badgeVariant" size="xs">
                                    {{ $sale->payment_method }}
                                </x-ui.badge>
                            </td>
                            <td class="px-3 py-3 align-top text-zinc-500 dark:text-zinc-400">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <div class="w-5 h-5 rounded-full bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-[9px] font-bold text-zinc-700 dark:text-zinc-300 uppercase shrink-0">
                                        {{ substr($sale->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <span class="truncate text-[11px]" title="{{ $sale->user ? $sale->user->name : 'N/A' }}">{{ $sale->user ? $sale->user->name : 'N/A' }}</span>
                                </div>
                                @if($sale->isVoided())
                                    <div class="mt-1">
                                        <x-ui.badge variant="danger" size="xs" title="Motivo: {{ $sale->void_reason }}">
                                            Anulada
                                        </x-ui.badge>
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-right font-bold text-[12px] align-top {{ $sale->isVoided() ? 'text-red-500 dark:text-red-400 line-through' : 'text-zinc-900 dark:text-zinc-100' }}">
                                ${{ number_format($sale->total, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-center align-top">
                                <div class="flex items-center justify-center gap-1">
                                    <a 
                                        href="{{ route('sales.print', $sale->id) }}" 
                                        target="_blank" 
                                        class="p-1.5 text-zinc-600 dark:text-zinc-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-950/30 rounded border border-zinc-200 dark:border-zinc-700 transition"
                                        title="Ver comprobante"
                                    >
                                        <x-ui.icon name="printer" class="w-3.5 h-3.5" />
                                    </a>

                                    @if($sale->client_phone)
                                        <a 
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sale->client_phone) }}?text={{ urlencode('Hola ' . $sale->client_name . ', te compartimos el detalle de tu compra #' . substr($sale->uuid, 0, 8) . ' por un total de $' . number_format($sale->total, 0, ',', '.')) }}" 
                                            target="_blank" 
                                            title="Enviar WhatsApp"
                                            class="p-1.5 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 rounded border border-emerald-200 dark:border-emerald-800/60 transition"
                                        >
                                            <x-ui.icon name="whatsapp" class="w-3.5 h-3.5" />
                                        </a>
                                    @endif

                                    @if(!$sale->isVoided())
                                        <button 
                                            wire:click="confirmVoid({{ $sale->id }})"
                                            class="p-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 rounded border border-red-200 dark:border-red-800/60 transition cursor-pointer"
                                            title="Anular venta"
                                        >
                                            <x-ui.icon name="x-circle" class="w-3.5 h-3.5" />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <x-ui.icon name="receipt" class="w-8 h-8 text-zinc-300 dark:text-zinc-600" />
                                    <span class="text-xs">No se encontraron ventas registradas con los filtros actuales.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS VIEW -->
        <div class="md:hidden flex flex-col gap-3 p-3">
            @forelse($sales as $index => $sale)
                <div class="bg-white dark:bg-zinc-850 border {{ $sale->isVoided() ? 'border-red-300 dark:border-red-900/60 opacity-60' : 'border-zinc-200 dark:border-zinc-800' }} rounded-xl p-3.5 shadow-xs flex flex-col gap-3 relative">
                    
                    <!-- Top Bar: Index Number, Code & Date -->
                    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-2">
                        <div class="flex items-center gap-1.5">
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-mono font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                                #{{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}
                            </span>
                            <span class="font-mono text-xs font-semibold {{ $sale->isVoided() ? 'text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-950/30 border-red-200 dark:border-red-900/40' : 'text-orange-700 dark:text-orange-400 bg-orange-50 dark:bg-orange-950/30 border-orange-200 dark:border-orange-900/40' }} px-2 py-0.5 rounded border">
                                #{{ substr($sale->uuid, 0, 8) }}
                            </span>
                            @if($sale->isVoided())
                                <x-ui.badge variant="danger" size="xs">Anulada</x-ui.badge>
                            @endif
                        </div>
                        <div class="text-[11px] text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                            <x-ui.icon name="clock" class="w-3 h-3 text-zinc-400" />
                            <span>{{ $sale->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <!-- Client Info -->
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <span class="text-[10px] font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider block">Cliente</span>
                            <span class="text-zinc-900 dark:text-zinc-100 font-bold text-sm block leading-tight {{ $sale->isVoided() ? 'line-through' : '' }}">{{ $sale->client_name }}</span>
                            @if($sale->client_phone)
                                <span class="text-xs text-zinc-500 dark:text-zinc-400 font-mono flex items-center gap-1 mt-0.5">
                                    <x-ui.icon name="phone" class="w-3 h-3 text-zinc-400" />
                                    {{ $sale->client_phone }}
                                </span>
                            @endif
                        </div>

                        <!-- User Pill -->
                        <div class="flex items-center gap-1 px-2 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded-md border border-zinc-200 dark:border-zinc-700 shrink-0">
                            <span class="w-3.5 h-3.5 rounded-full bg-orange-100 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 text-[8px] font-bold flex items-center justify-center">
                                {{ substr($sale->user->name ?? 'A', 0, 1) }}
                            </span>
                            <span class="text-[10px] font-medium text-zinc-700 dark:text-zinc-300 truncate max-w-[80px]">{{ $sale->user ? $sale->user->name : 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Items Detail Box -->
                    <div class="bg-zinc-50 dark:bg-zinc-900/60 p-2.5 rounded-lg border border-zinc-200 dark:border-zinc-800 space-y-1">
                        <span class="text-[9px] font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider block">Artículos</span>
                        <div class="space-y-1 max-h-32 overflow-y-auto {{ $sale->isVoided() ? 'line-through' : '' }}">
                            @foreach($sale->items as $item)
                                <div class="flex items-start gap-1.5 text-xs">
                                    <span class="px-1 py-0 rounded bg-zinc-200/80 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-bold text-[9px] shrink-0 mt-0.5">
                                        {{ $item->quantity }}x
                                    </span>
                                    <span class="text-zinc-700 dark:text-zinc-300 leading-tight line-clamp-1" title="{{ $item->name }}">{{ $item->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Void Reason (if voided) -->
                    @if($sale->isVoided())
                        <div class="bg-red-50 dark:bg-red-950/30 p-2.5 rounded-lg border border-red-200 dark:border-red-900/40">
                            <span class="text-[9px] font-bold text-red-700 dark:text-red-400 uppercase tracking-wider block mb-0.5">Motivo Anulación</span>
                            <span class="text-xs text-red-800 dark:text-red-300">{{ $sale->void_reason }}</span>
                            <span class="text-[10px] text-red-500 dark:text-red-400/70 block mt-1">Por: {{ $sale->voidedByUser->name ?? 'N/A' }} — {{ $sale->voided_at?->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif

                    <!-- Payment Method & Total Row -->
                    <div class="flex items-center justify-between pt-1">
                        <div>
                            @php
                                $method = strtolower($sale->payment_method ?? '');
                                $badgeVariant = match(true) {
                                    str_contains($method, 'efectivo') => 'success',
                                    str_contains($method, 'transf') => 'info',
                                    str_contains($method, 'débito') || str_contains($method, 'credito') || str_contains($method, 'tarjeta') => 'blue',
                                    default => 'neutral'
                                };
                            @endphp
                            <x-ui.badge :variant="$badgeVariant" size="xs">
                                {{ $sale->payment_method }}
                            </x-ui.badge>
                        </div>

                        <div class="text-right">
                            <span class="text-base font-bold {{ $sale->isVoided() ? 'text-red-500 dark:text-red-400 line-through' : 'text-zinc-900 dark:text-zinc-100' }} block">
                                ${{ number_format($sale->total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions Bar on Mobile -->
                    <div class="grid {{ $sale->isVoided() ? 'grid-cols-1' : 'grid-cols-3' }} gap-2 pt-2 border-t border-zinc-100 dark:border-zinc-800">
                        <a 
                            href="{{ route('sales.print', $sale->id) }}" 
                            target="_blank" 
                            class="py-1.5 px-2 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-200 border border-zinc-200 dark:border-zinc-700 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1.5"
                        >
                            <x-ui.icon name="printer" class="w-3.5 h-3.5" />
                            <span>Comprobante</span>
                        </a>

                        @if(!$sale->isVoided())
                            @if($sale->client_phone)
                                <a 
                                    href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sale->client_phone) }}?text={{ urlencode('Hola ' . $sale->client_name . ', te compartimos el detalle de tu compra #' . substr($sale->uuid, 0, 8) . ' por un total de $' . number_format($sale->total, 0, ',', '.')) }}" 
                                    target="_blank" 
                                    class="py-1.5 px-2 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1.5"
                                >
                                    <x-ui.icon name="whatsapp" class="w-3.5 h-3.5" />
                                    <span>WhatsApp</span>
                                </a>
                            @else
                                <button disabled class="py-1.5 px-2 bg-zinc-50 dark:bg-zinc-900 text-zinc-400 border border-zinc-200 dark:border-zinc-800 rounded-lg text-xs font-medium flex items-center justify-center gap-1 opacity-50 cursor-not-allowed">
                                    <span>Sin Teléfono</span>
                                </button>
                            @endif

                            <button 
                                wire:click="confirmVoid({{ $sale->id }})"
                                class="py-1.5 px-2 bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800/60 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1.5 cursor-pointer"
                            >
                                <x-ui.icon name="x-circle" class="w-3.5 h-3.5" />
                                <span>Anular</span>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-zinc-500 text-xs font-medium flex flex-col items-center gap-2">
                    <x-ui.icon name="receipt" class="w-8 h-8 text-zinc-400" />
                    <span>No se encontraron ventas con los filtros aplicados.</span>
                </div>
            @endforelse
        </div>
        
        @if($sales->hasPages())
            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                {{ $sales->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>

    <!-- VOID CONFIRMATION MODAL -->
    @if($showVoidModal)
        <div class="fixed inset-0 z-[100] overflow-y-auto overscroll-contain flex items-center justify-center p-4 bg-zinc-950/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-2xl w-full max-w-md max-h-[90dvh] overflow-y-auto overscroll-contain p-5 space-y-4 my-auto">
                <!-- Header -->
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-lg bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/50">
                        <x-ui.icon name="alert-triangle" class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">Anular Venta</h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Esta acción no se puede revertir</p>
                    </div>
                </div>

                <!-- Warning Callout -->
                <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900/40 rounded-lg p-3 text-xs text-red-800 dark:text-red-300 space-y-1.5">
                    <p class="font-semibold flex items-center gap-1.5">
                        <x-ui.icon name="alert-circle" class="w-3.5 h-3.5 shrink-0" />
                        Al anular esta venta:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5 text-red-700 dark:text-red-300/80 pl-1 text-[11px]">
                        <li>Se devolverá el stock de los productos al inventario</li>
                        <li>No se contará en los totales de caja ni reportes</li>
                        <li>El comprobante mostrará sello de "ANULADA"</li>
                    </ul>
                </div>

                <!-- Reason Input -->
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Motivo de Anulación *</label>
                    <textarea 
                        wire:model="voidReason"
                        rows="3"
                        placeholder="Ej: Error de cobro, devolución de producto, venta duplicada..."
                        class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 focus:border-red-500 rounded-lg p-3 text-zinc-900 dark:text-zinc-100 text-xs placeholder-zinc-400 focus:outline-none focus:ring-1 focus:ring-red-500/30 transition duration-150 resize-none"
                    ></textarea>
                    @error('voidReason')
                        <span class="text-red-600 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2.5 pt-1">
                    <button 
                        wire:click="cancelVoid"
                        class="flex-1 py-2 px-3 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 rounded-lg text-xs font-semibold transition cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button 
                        wire:click="voidSale"
                        wire:loading.attr="disabled"
                        class="flex-1 py-2 px-3 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold transition flex items-center justify-center gap-1.5 disabled:opacity-50 cursor-pointer shadow-xs"
                    >
                        <span wire:loading wire:target="voidSale" class="w-3.5 h-3.5 border-2 border-white/20 border-t-white rounded-full animate-spin"></span>
                        <x-ui.icon name="x-circle" class="w-3.5 h-3.5" />
                        Confirmar Anulación
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>