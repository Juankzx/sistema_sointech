<div class="space-y-6 animate-fade-in pb-16 md:pb-6" wire:poll.visible.10s>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight flex items-center gap-3">
                <span class="p-2.5 rounded-2xl bg-orange-500/10 border border-orange-500/20 text-orange-500 shadow-lg shadow-orange-500/5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </span>
                Historial de Ventas
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Revisa el historial de ventas, comprobantes y envíos por WhatsApp.</p>
        </div>

        <div class="flex items-center gap-2 self-start sm:self-auto">
            <span class="px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-800 text-xs font-bold text-slate-300 shadow-sm flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Total Ventas: <span class="text-white font-black">${{ number_format($totalActiveSales, 0, ',', '.') }}</span>
            </span>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session()->has('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-4 flex items-center gap-3 animate-fade-in">
            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-emerald-300 text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4 flex items-center gap-3 animate-fade-in">
            <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-red-300 text-sm font-semibold">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filters Bar -->
    <div class="bg-slate-900/90 backdrop-blur-xl p-4 sm:p-5 rounded-3xl border border-slate-800/80 shadow-2xl space-y-4 max-w-full overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 items-end">
            <!-- Search -->
            <div class="md:col-span-6 w-full min-w-0">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Buscar Venta</label>
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input 
                        wire:model.live.debounce.300ms="search" 
                        type="text" 
                        placeholder="Cliente, teléfono, código #..." 
                        class="w-full max-w-full bg-slate-950/80 border border-slate-700/80 focus:border-orange-500 rounded-2xl py-2.5 pl-10 pr-9 text-white text-xs font-medium placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition duration-200"
                    >
                    @if($search)
                        <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    @endif
                </div>
            </div>
            
            <!-- Dates: Stacked on Mobile (iPhone 13 Pro friendly), 2 Cols on Tablet/Desktop -->
            <div class="md:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-3 w-full">
                <div class="w-full">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Desde</label>
                    <input 
                        wire:model.live="dateFrom" 
                        type="date" 
                        class="w-full bg-slate-950/80 border border-slate-700/80 focus:border-orange-500 rounded-2xl py-2.5 px-3 text-white text-xs font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition duration-200" 
                        max="{{ date('Y-m-d') }}"
                        style="-webkit-appearance: none; appearance: none; min-height: 42px;"
                    >
                </div>

                <div class="w-full">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Hasta</label>
                    <input 
                        wire:model.live="dateTo" 
                        type="date" 
                        class="w-full bg-slate-950/80 border border-slate-700/80 focus:border-orange-500 rounded-2xl py-2.5 px-3 text-white text-xs font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition duration-200" 
                        max="{{ date('Y-m-d') }}"
                        style="-webkit-appearance: none; appearance: none; min-height: 42px;"
                    >
                </div>
            </div>
        </div>
    </div>

    <!-- Content Container -->
    <div class="bg-slate-900/60 backdrop-blur-xl rounded-3xl border border-slate-800 shadow-2xl overflow-hidden max-w-full">
        
        <!-- DESKTOP TABLE -->
        <div class="hidden md:block overflow-x-auto theme-scrollbar">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-950/80 text-slate-400 font-bold uppercase text-[10px] tracking-widest border-b border-slate-800">
                        <th class="px-4 py-4 w-12 text-center">N°</th>
                        <th class="px-6 py-4">Fecha & Hora</th>
                        <th class="px-6 py-4">Código</th>
                        <th class="px-6 py-4">Cliente</th>
                        <th class="px-6 py-4">Detalle Artículos</th>
                        <th class="px-6 py-4">Método Pago</th>
                        <th class="px-6 py-4">Usuario</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-right">Total</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($sales as $index => $sale)
                        <tr class="{{ $sale->isVoided() ? 'opacity-50 bg-red-950/10' : 'hover:bg-slate-800/40' }} transition duration-150 group">
                            <td class="px-4 py-4 text-center font-mono font-bold text-slate-500 text-xs">
                                #{{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 text-slate-400 font-medium">
                                <div class="flex flex-col">
                                    <span class="text-slate-200 font-semibold {{ $sale->isVoided() ? 'line-through' : '' }}">{{ $sale->created_at->format('d/m/Y') }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $sale->created_at->format('H:i') }} hrs</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-extrabold {{ $sale->isVoided() ? 'text-red-400 bg-red-500/10 border-red-500/20' : 'text-orange-400 bg-orange-500/10 border-orange-500/20' }} px-2.5 py-1 rounded-lg border">
                                    #{{ substr($sale->uuid, 0, 8) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-white font-bold {{ $sale->isVoided() ? 'line-through' : '' }}">{{ $sale->client_name }}</span>
                                    @if($sale->client_phone)
                                        <span class="text-[10px] text-slate-400 font-mono flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            {{ $sale->client_phone }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <div class="flex flex-col gap-1 overflow-hidden {{ $sale->isVoided() ? 'line-through' : '' }}">
                                    @foreach($sale->items as $item)
                                        <div class="flex items-center gap-1.5 text-slate-300">
                                            <span class="px-1.5 py-0.5 rounded bg-slate-800 text-[10px] font-black text-amber-400 border border-slate-700/60 shrink-0">{{ $item->quantity }}x</span>
                                            <span class="truncate text-xs font-medium" title="{{ $item->name }}">{{ $item->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $method = strtolower($sale->payment_method ?? '');
                                    $badgeClass = match(true) {
                                        str_contains($method, 'efectivo') => 'bg-emerald-950/60 text-emerald-400 border-emerald-500/30',
                                        str_contains($method, 'transf') => 'bg-indigo-950/60 text-indigo-400 border-indigo-500/30',
                                        str_contains($method, 'débito') || str_contains($method, 'credito') || str_contains($method, 'tarjeta') => 'bg-purple-950/60 text-purple-400 border-purple-500/30',
                                        default => 'bg-slate-800 text-slate-300 border-slate-700'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-bold border uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $sale->payment_method }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-400 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-5 h-5 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-[9px] font-black text-slate-300 uppercase">
                                        {{ substr($sale->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <span>{{ $sale->user ? $sale->user->name : 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($sale->isVoided())
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-black border uppercase tracking-wider bg-red-950/60 text-red-400 border-red-500/30" title="Anulada por: {{ $sale->voidedByUser->name ?? 'N/A' }} — {{ $sale->void_reason }}">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        ANULADA
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-bold border uppercase tracking-wider bg-emerald-950/60 text-emerald-400 border-emerald-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5"></span>
                                        Activa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-black text-sm {{ $sale->isVoided() ? 'text-red-400 line-through' : 'text-white' }}">
                                ${{ number_format($sale->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a 
                                        href="{{ route('sales.print', $sale->id) }}" 
                                        target="_blank" 
                                        class="px-3 py-1.5 bg-orange-500/10 hover:bg-orange-500 text-orange-400 hover:text-white border border-orange-500/30 rounded-xl text-xs font-bold transition duration-200 inline-flex items-center gap-1.5 shadow-sm"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        <span>Comp.</span>
                                    </a>

                                    @if($sale->client_phone)
                                        <a 
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sale->client_phone) }}?text={{ urlencode('Hola ' . $sale->client_name . ', te compartimos el detalle de tu compra #' . substr($sale->uuid, 0, 8) . ' por un total de $' . number_format($sale->total, 0, ',', '.')) }}" 
                                            target="_blank" 
                                            title="Enviar WhatsApp"
                                            class="p-2 bg-emerald-500/10 hover:bg-emerald-600 text-emerald-400 hover:text-white rounded-xl border border-emerald-500/30 transition duration-200 cursor-pointer flex items-center justify-center shadow-sm"
                                        >
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c-.001 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                        </a>
                                    @endif

                                    @if(!$sale->isVoided())
                                        <button 
                                            wire:click="confirmVoid({{ $sale->id }})"
                                            class="p-2 bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white rounded-xl border border-red-500/30 transition duration-200 cursor-pointer flex items-center justify-center shadow-sm"
                                            title="Anular venta"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>No se encontraron ventas registradas con los filtros actuales.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS VIEW -->
        <div class="md:hidden flex flex-col gap-4 p-3.5 sm:p-4">
            @forelse($sales as $index => $sale)
                <div class="bg-gradient-to-br from-slate-900/90 to-slate-950/90 border {{ $sale->isVoided() ? 'border-red-800/40 opacity-60' : 'border-slate-800' }} rounded-3xl p-4 shadow-xl flex flex-col gap-3.5 relative overflow-hidden transition-all duration-200 border-l-4 {{ $sale->isVoided() ? 'border-l-red-500' : 'border-l-orange-500' }}">
                    
                    <!-- Voided Watermark on Mobile -->
                    @if($sale->isVoided())
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">
                            <span class="text-red-500/15 font-black text-5xl uppercase tracking-widest -rotate-12">ANULADA</span>
                        </div>
                    @endif

                    <!-- Top Bar: Index Number, Code & Date -->
                    <div class="flex items-center justify-between border-b border-slate-800/80 pb-2.5 relative z-20">
                        <div class="flex items-center gap-1.5">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-slate-800 text-slate-300 border border-slate-700/80">
                                N° {{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}
                            </span>
                            <span class="font-mono text-xs font-black {{ $sale->isVoided() ? 'text-red-400 bg-red-500/10 border-red-500/20' : 'text-orange-400 bg-orange-500/10 border-orange-500/20' }} px-2.5 py-0.5 rounded-lg border shadow-xs">
                                #{{ substr($sale->uuid, 0, 8) }}
                            </span>
                            @if($sale->isVoided())
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-black bg-red-950/80 text-red-400 border border-red-500/30 uppercase">Anulada</span>
                            @endif
                        </div>
                        <div class="text-[11px] text-slate-400 font-semibold flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $sale->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <!-- Client Info -->
                    <div class="flex items-start justify-between gap-2 relative z-20">
                        <div>
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-0.5">Cliente</span>
                            <span class="text-white font-extrabold text-sm block leading-tight {{ $sale->isVoided() ? 'line-through' : '' }}">{{ $sale->client_name }}</span>
                            @if($sale->client_phone)
                                <span class="text-xs text-slate-400 font-mono flex items-center gap-1 mt-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    {{ $sale->client_phone }}
                                </span>
                            @endif
                        </div>

                        <!-- User Avatar Pill -->
                        <div class="flex items-center gap-1.5 px-2 py-1 bg-slate-800/80 rounded-xl border border-slate-700/60 shrink-0">
                            <span class="w-4 h-4 rounded-full bg-orange-500/20 text-orange-400 text-[9px] font-black flex items-center justify-center">
                                {{ substr($sale->user->name ?? 'A', 0, 1) }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-300 truncate max-w-[80px]">{{ $sale->user ? $sale->user->name : 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Items Detail Box -->
                    <div class="bg-slate-950/60 p-3 rounded-2xl border border-slate-800/60 space-y-1.5 relative z-20">
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block">Artículos</span>
                        <div class="space-y-1 max-h-36 overflow-y-auto theme-scrollbar {{ $sale->isVoided() ? 'line-through' : '' }}">
                            @foreach($sale->items as $item)
                                <div class="flex items-start gap-2 text-xs">
                                    <span class="px-1.5 py-0.5 rounded-md bg-amber-500/10 text-amber-400 border border-amber-500/20 font-black text-[10px] shrink-0 mt-0.5">
                                        {{ $item->quantity }}x
                                    </span>
                                    <span class="text-slate-300 font-medium leading-tight line-clamp-2" title="{{ $item->name }}">{{ $item->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Void Reason (if voided) -->
                    @if($sale->isVoided())
                        <div class="bg-red-950/30 p-2.5 rounded-xl border border-red-500/20 relative z-20">
                            <span class="text-[9px] font-black text-red-400 uppercase tracking-widest block mb-1">Motivo Anulación</span>
                            <span class="text-xs text-red-300 font-medium">{{ $sale->void_reason }}</span>
                            <span class="text-[10px] text-red-400/60 block mt-1">Por: {{ $sale->voidedByUser->name ?? 'N/A' }} — {{ $sale->voided_at?->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif

                    <!-- Payment Method & Total Row -->
                    <div class="flex items-center justify-between pt-1 relative z-20">
                        <div>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Método Pago</span>
                            @php
                                $method = strtolower($sale->payment_method ?? '');
                                $badgeClass = match(true) {
                                    str_contains($method, 'efectivo') => 'bg-emerald-950/80 text-emerald-400 border-emerald-500/30',
                                    str_contains($method, 'transf') => 'bg-indigo-950/80 text-indigo-400 border-indigo-500/30',
                                    str_contains($method, 'débito') || str_contains($method, 'credito') || str_contains($method, 'tarjeta') => 'bg-purple-950/80 text-purple-400 border-purple-500/30',
                                    default => 'bg-slate-800 text-slate-300 border-slate-700'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-extrabold border uppercase tracking-wider {{ $badgeClass }}">
                                {{ $sale->payment_method }}
                            </span>
                        </div>

                        <div class="text-right">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-0.5">Total Venta</span>
                            <span class="text-base sm:text-lg font-black {{ $sale->isVoided() ? 'text-red-400 line-through' : 'text-amber-400' }} block">
                                ${{ number_format($sale->total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions Bar on Mobile -->
                    <div class="grid {{ $sale->isVoided() ? 'grid-cols-1' : 'grid-cols-3' }} gap-2 pt-2 border-t border-slate-800/80 mt-1 relative z-20">
                        <a 
                            href="{{ route('sales.print', $sale->id) }}" 
                            target="_blank" 
                            class="py-2 px-3 bg-orange-500/10 hover:bg-orange-500 text-orange-400 hover:text-white border border-orange-500/30 rounded-xl text-xs font-extrabold transition flex items-center justify-center gap-1.5 shadow-sm active:scale-95"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            <span>Comprobante</span>
                        </a>

                        @if(!$sale->isVoided())
                            @if($sale->client_phone)
                                <a 
                                    href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sale->client_phone) }}?text={{ urlencode('Hola ' . $sale->client_name . ', te compartimos el detalle de tu compra #' . substr($sale->uuid, 0, 8) . ' por un total de $' . number_format($sale->total, 0, ',', '.')) }}" 
                                    target="_blank" 
                                    class="py-2 px-3 bg-emerald-500/10 hover:bg-emerald-600 text-emerald-400 hover:text-white border border-emerald-500/30 rounded-xl text-xs font-extrabold transition flex items-center justify-center gap-1.5 shadow-sm active:scale-95"
                                >
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c-.001 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    <span>WhatsApp</span>
                                </a>
                            @else
                                <button disabled class="py-2 px-3 bg-slate-900 text-slate-600 border border-slate-800 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 opacity-50 cursor-not-allowed">
                                    <span>Sin Teléfono</span>
                                </button>
                            @endif

                            <button 
                                wire:click="confirmVoid({{ $sale->id }})"
                                class="py-2 px-3 bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white border border-red-500/30 rounded-xl text-xs font-extrabold transition flex items-center justify-center gap-1.5 shadow-sm active:scale-95"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                <span>Anular</span>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-slate-500 text-xs font-medium flex flex-col items-center gap-2">
                    <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>No se encontraron ventas con los filtros aplicados.</span>
                </div>
            @endforelse
        </div>
        
        @if($sales->hasPages())
            <div class="px-6 py-4 border-t border-slate-800/80 bg-slate-950/60">
                {{ $sales->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>

    <!-- VOID CONFIRMATION MODAL -->
    @if($showVoidModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7); backdrop-filter: blur(8px);">
            <div class="bg-slate-900 border border-slate-700 rounded-3xl shadow-2xl w-full max-w-md p-6 space-y-5 animate-fade-in">
                <!-- Header -->
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-2xl bg-red-500/10 border border-red-500/20">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white">Anular Venta</h3>
                        <p class="text-xs text-slate-400">Esta acción no se puede revertir</p>
                    </div>
                </div>

                <!-- Warning -->
                <div class="bg-red-950/30 border border-red-500/20 rounded-2xl p-4 text-xs text-red-300 space-y-1.5">
                    <p class="font-bold">⚠️ Al anular esta venta:</p>
                    <ul class="list-disc list-inside space-y-1 text-red-300/80">
                        <li>Se devolverá el stock de los productos al inventario</li>
                        <li>No se contará en los totales de caja ni reportes</li>
                        <li>El comprobante mostrará sello de "ANULADA"</li>
                    </ul>
                </div>

                <!-- Reason Input -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Motivo de Anulación *</label>
                    <textarea 
                        wire:model="voidReason"
                        rows="3"
                        placeholder="Ej: Error de cobro, devolución de producto, venta duplicada..."
                        class="w-full bg-slate-950/80 border border-slate-700/80 focus:border-red-500 rounded-2xl py-3 px-4 text-white text-sm font-medium placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition duration-200 resize-none"
                    ></textarea>
                    @error('voidReason')
                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button 
                        wire:click="cancelVoid"
                        class="flex-1 py-3 px-4 bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 rounded-2xl text-sm font-bold transition duration-200"
                    >
                        Cancelar
                    </button>
                    <button 
                        wire:click="voidSale"
                        wire:loading.attr="disabled"
                        class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white border border-red-500 rounded-2xl text-sm font-black transition duration-200 flex items-center justify-center gap-2 disabled:opacity-50"
                    >
                        <wire:loading wire:target="voidSale">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        </wire:loading>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        Confirmar Anulación
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
