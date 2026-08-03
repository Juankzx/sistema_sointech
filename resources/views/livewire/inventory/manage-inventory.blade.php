<div class="space-y-6 animate-fade-in pb-16">

    {{-- CSS Custom Scrollbar para eliminar la barra blanca del navegador --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0d1117;
            border-radius: 999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #1f2937;
            border-radius: 999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #374151;
        }
    </style>

    {{-- Flash Notifications --}}
    @if(session()->has('message'))
        <div class="p-4 rounded-2xl text-sm font-bold flex items-center justify-between gap-3 animate-fade-in"
            style="background:rgba(16,185,129,.1); border:1.5px solid rgba(16,185,129,.25); color:#34d399;">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    {{-- ══ HEADER PREMIUM ══ --}}
    <div class="relative overflow-hidden rounded-3xl p-6 sm:p-7 border"
        style="background:linear-gradient(135deg, #0a1628 0%, #0d2137 40%, #083d35 100%); border-color:rgba(255,255,255,.06);">
        <div class="absolute inset-0 opacity-5"
            style="background-image: radial-gradient(circle at 1px 1px, rgba(0,198,182,0.6) 1px, transparent 0); background-size: 24px 24px;">
        </div>
        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full pointer-events-none"
            style="background: radial-gradient(circle, rgba(0,198,182,0.12) 0%, transparent 70%);"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border mb-2.5"
                    style="background:rgba(0,198,182,.1); color:#00C6B6; border-color:rgba(0,198,182,.25);">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                    Sointech • Taller & Stock
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Inventario de Repuestos</h1>
                <p class="text-xs sm:text-sm mt-1" style="color:rgba(180,210,205,0.7);">
                    Supervisa y ajusta en tiempo real el stock de repuestos, insumos y componentes del taller.
                </p>
            </div>

            <button type="button" wire:click="openCreateModal"
                class="inline-flex items-center justify-center gap-2 text-xs font-black uppercase tracking-wider px-5 py-3.5 rounded-2xl shadow-xl transition-all duration-200 cursor-pointer self-start sm:self-center shrink-0"
                style="background:linear-gradient(135deg,#00C6B6 0%,#2563eb 100%); color:#ffffff; box-shadow:0 8px 20px rgba(0,198,182,.25);"
                onmouseover="this.style.transform='translateY(-1px)';"
                onmouseout="this.style.transform='none';">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Agregar Repuesto
            </button>
        </div>
    </div>

    {{-- ══ TARJETAS DE MÉTRICAS KPI ══ --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        {{-- Total Catálogo --}}
        <div class="rounded-2xl p-4 flex items-center gap-3.5" style="background:#0d1117; border:1.5px solid #1f2937;">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(0,198,182,.1); border:1px solid rgba(0,198,182,.2);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#2dd4bf;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                </svg>
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Repuestos en Catálogo</div>
                <div class="text-lg font-black text-white mt-0.5">{{ $totalParts }}</div>
            </div>
        </div>

        {{-- Alertas de Stock Bajo --}}
        <div class="rounded-2xl p-4 flex items-center gap-3.5" style="background:#0d1117; border:1.5px solid #1f2937;">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(245,158,11,.1); border:1px solid rgba(245,158,11,.2);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#fbbf24;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Stock Bajo (&lt; 5)</div>
                <div class="text-lg font-black text-amber-400 mt-0.5">{{ $lowStockCount }}</div>
            </div>
        </div>

        {{-- Agotados --}}
        <div class="rounded-2xl p-4 flex items-center gap-3.5" style="background:#0d1117; border:1.5px solid #1f2937;">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.2);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#f87171;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Sin Stock</div>
                <div class="text-lg font-black text-red-400 mt-0.5">{{ $outOfStockCount }}</div>
            </div>
        </div>

        {{-- Valorización --}}
        <div class="rounded-2xl p-4 flex items-center gap-3.5" style="background:#0d1117; border:1.5px solid #1f2937;">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(59,130,246,.1); border:1px solid rgba(59,130,246,.2);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#60a5fa;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Valor Inventario</div>
                <div class="text-lg font-black text-emerald-400 mt-0.5">${{ number_format($totalValuation, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- ══ BARRA DE BÚSQUEDA ══ --}}
    <div class="rounded-2xl p-4 flex flex-col sm:flex-row gap-3 items-center justify-between"
        style="background:#0d1117; border:1.5px solid #1f2937;">
        <div class="relative w-full sm:w-96">
            <span class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none" style="color:#4b5563;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>
            <input wire:model.live.debounce.150ms="search" type="text"
                placeholder="Buscar repuesto por nombre o categoría..."
                class="w-full rounded-xl py-2.5 pl-10 pr-9 text-xs font-medium text-white placeholder-gray-600 transition-all duration-200 focus:outline-none"
                style="background:#111827; border:1.5px solid #1f2937;"
                onfocus="this.style.borderColor='#00C6B6'; this.style.boxShadow='0 0 0 3px rgba(0,198,182,.12)';"
                onblur="this.style.borderColor='#1f2937'; this.style.boxShadow='none';">

            @if($search)
                <button type="button" wire:click="$set('search', '')"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            @endif
        </div>

        <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wider self-end sm:self-center shrink-0">
            Mostrando <span class="text-teal-400 font-mono">{{ count($parts) }}</span> repuesto{{ count($parts) !== 1 ? 's' : '' }}
        </div>
    </div>

    {{-- ══ TABLA DESKTOP ══ --}}
    <div class="hidden md:block rounded-2xl overflow-hidden shadow-2xl"
        style="background:#0d1117; border:1.5px solid #1f2937;">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-gray-500 font-extrabold uppercase text-[10px] tracking-widest border-b"
                        style="background:#111827; border-color:#1f2937;">
                        <th class="px-5 py-4">Nombre del Repuesto</th>
                        <th class="px-5 py-4">Categoría</th>
                        <th class="px-5 py-4 text-center">Stock Disponible</th>
                        <th class="px-5 py-4">Precio Venta</th>
                        @if(auth()->user()->isAdmin())
                            <th class="px-5 py-4">Precio Costo</th>
                            <th class="px-5 py-4">Margen Ganancia</th>
                        @endif
                        <th class="px-5 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($parts as $part)
                        <tr class="transition-colors duration-150 group"
                            onmouseover="this.style.background='#111827';"
                            onmouseout="this.style.background='transparent';">
                            {{-- Nombre --}}
                            <td class="px-5 py-4">
                                <span class="font-bold text-white text-sm block leading-tight">{{ $part->name }}</span>
                            </td>

                            {{-- Categoría --}}
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold rounded-lg uppercase tracking-wider"
                                    style="background:#111827; border:1px solid #1f2937; color:#9ca3af;">
                                    {{ $part->category }}
                                </span>
                            </td>

                            {{-- Stock --}}
                            <td class="px-5 py-4 text-center">
                                @if($part->stock <= 0)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10.5px] font-black uppercase tracking-wider animate-pulse"
                                        style="background:rgba(239,68,68,.12); color:#f87171; border:1px solid rgba(239,68,68,.3);">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Sin Stock
                                    </span>
                                @elseif($part->stock < 5)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10.5px] font-black uppercase tracking-wider"
                                        style="background:rgba(245,158,11,.12); color:#fbbf24; border:1px solid rgba(245,158,11,.3);">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        Stock Bajo ({{ $part->stock }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10.5px] font-bold uppercase tracking-wider"
                                        style="background:rgba(14,165,233,.1); color:#38bdf8; border:1px solid rgba(14,165,233,.2);">
                                        {{ $part->stock }} unidades
                                    </span>
                                @endif
                            </td>

                            {{-- Precio Venta --}}
                            <td class="px-5 py-4 font-mono font-bold text-white text-sm">
                                ${{ number_format($part->sale_price, 0, ',', '.') }}
                            </td>

                            {{-- Precio Costo (Admin Only) --}}
                            @if(auth()->user()->isAdmin())
                                <td class="px-5 py-4 font-mono text-xs text-gray-400">
                                    ${{ number_format($part->cost_price, 0, ',', '.') }}
                                </td>

                                {{-- Margen Ganancia --}}
                                <td class="px-5 py-4 font-mono text-xs">
                                    @php
                                        $margin = $part->sale_price - $part->cost_price;
                                        $percent = $part->cost_price > 0 ? round(($margin / $part->cost_price) * 100) : 100;
                                    @endphp
                                    <span class="inline-flex items-center gap-1 font-bold text-emerald-400">
                                        ${{ number_format($margin, 0, ',', '.') }}
                                        <span class="text-[10px] opacity-75">(+{{ $percent }}%)</span>
                                    </span>
                                </td>
                            @endif

                            {{-- Acciones --}}
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Ajustar Stock --}}
                                    <button type="button" wire:click="openAdjustModal({{ $part->id }})"
                                        title="Ajustar inventario"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition cursor-pointer"
                                        style="background:#1f2937; border:1.5px solid #374151; color:#d1d5db;"
                                        onmouseover="this.style.background='#374151'; this.style.color='#ffffff';"
                                        onmouseout="this.style.background='#1f2937'; this.style.color='#d1d5db';">
                                        <svg class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
                                        </svg>
                                        Ajustar
                                    </button>

                                    {{-- Eliminar (Admin Only) --}}
                                    @if(auth()->user()->isAdmin())
                                        <button type="button" wire:click="deletePart({{ $part->id }})"
                                            wire:confirm="¿Seguro que deseas eliminar este repuesto del catálogo?"
                                            title="Eliminar del catálogo"
                                            class="w-8 h-8 rounded-xl flex items-center justify-center transition cursor-pointer"
                                            style="background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.2); color:#f87171;"
                                            onmouseover="this.style.background='rgba(239,68,68,.2)';"
                                            onmouseout="this.style.background='rgba(239,68,68,.08)';">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                </svg>
                                <div class="font-bold text-gray-400">No se encontraron repuestos</div>
                                <div class="text-xs text-gray-600 mt-1">Ajusta la búsqueda o agrega un nuevo repuesto al catálogo.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ══ TARJETAS MOBILE ══ --}}
    <div class="md:hidden flex flex-col gap-3">
        @forelse($parts as $part)
            <div class="rounded-2xl p-4 space-y-3" style="background:#0d1117; border:1.5px solid #1f2937;">
                <div class="flex items-center justify-between gap-3 pb-2.5 border-b border-gray-800">
                    <span class="font-bold text-white text-sm">{{ $part->name }}</span>
                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-md bg-gray-900 text-gray-400 border border-gray-700">{{ $part->category }}</span>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <span class="block text-[10px] font-bold text-gray-500 uppercase">Stock</span>
                        @if($part->stock <= 0)
                            <span class="text-red-400 font-black animate-pulse">Sin Stock</span>
                        @elseif($part->stock < 5)
                            <span class="text-amber-400 font-black">Bajo ({{ $part->stock }})</span>
                        @else
                            <span class="text-teal-400 font-bold">{{ $part->stock }} un.</span>
                        @endif
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-gray-500 uppercase">Precio Venta</span>
                        <span class="text-white font-bold font-mono">${{ number_format($part->sale_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2 border-t border-gray-800">
                    <button wire:click="openAdjustModal({{ $part->id }})"
                        class="flex-1 py-2 bg-gray-800 text-gray-300 text-xs font-bold rounded-xl border border-gray-700 flex items-center justify-center gap-1">
                        ⚡ Ajustar Stock
                    </button>
                    @if(auth()->user()->isAdmin())
                        <button wire:click="deletePart({{ $part->id }})" wire:confirm="¿Deseas eliminar este repuesto?"
                            class="p-2 bg-red-950/40 text-red-400 text-xs font-bold rounded-xl border border-red-800/40">
                            🗑️
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-2xl p-6 text-center text-gray-500" style="background:#0d1117; border:1.5px solid #1f2937;">
                No se encontraron repuestos.
            </div>
        @endforelse
    </div>

    {{-- ══ MODAL: AGREGAR REPUESTO ══ --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl p-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                    style="background:#0d1117; border:1.5px solid #1f2937;">

                    <div class="flex items-center justify-between pb-4 border-b border-gray-800 mb-5">
                        <h3 class="text-base font-black text-white flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:rgba(0,198,182,.1); border:1px solid rgba(0,198,182,.2);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#2dd4bf;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                            </div>
                            <span>Registrar Nuevo Repuesto</span>
                        </h3>
                        <button type="button" wire:click="$set('showModal', false)"
                            class="p-1.5 rounded-xl text-gray-500 hover:text-white hover:bg-gray-800 transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="savePart" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre del Repuesto *</label>
                            <input wire:model="name" type="text" placeholder="Ej: Pantalla OLED OEM iPhone 13" required
                                class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                style="background:#111827; border:1.5px solid #1f2937;"
                                onfocus="this.style.borderColor='#00C6B6';" onblur="this.style.borderColor='#1f2937';">
                            @error('name') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Categoría *</label>
                            <input wire:model="category" type="text" placeholder="Ej: Pantallas, Baterías, Conectores..." required
                                class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                style="background:#111827; border:1.5px solid #1f2937;"
                                onfocus="this.style.borderColor='#00C6B6';" onblur="this.style.borderColor='#1f2937';">
                            @error('category') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Stock Inicial *</label>
                                <input wire:model="stock" type="number" min="0" required
                                    class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                    style="background:#111827; border:1.5px solid #1f2937;"
                                    onfocus="this.style.borderColor='#00C6B6';" onblur="this.style.borderColor='#1f2937';">
                                @error('stock') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Precio Costo ($) *</label>
                                <input wire:model="cost_price" type="number" step="1" min="0" required
                                    class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                    style="background:#111827; border:1.5px solid #1f2937;"
                                    onfocus="this.style.borderColor='#00C6B6';" onblur="this.style.borderColor='#1f2937';">
                                @error('cost_price') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Precio Venta ($) *</label>
                            <input wire:model="sale_price" type="number" step="1" min="0" required
                                class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                style="background:#111827; border:1.5px solid #1f2937;"
                                onfocus="this.style.borderColor='#00C6B6';" onblur="this.style.borderColor='#1f2937';">
                            @error('sale_price') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800 mt-6">
                            <button type="button" wire:click="$set('showModal', false)"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold text-gray-400 transition cursor-pointer"
                                style="background:#111827; border:1.5px solid #1f2937;">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider text-white transition shadow-lg cursor-pointer"
                                style="background:linear-gradient(135deg,#00C6B6,#2563eb);">
                                Guardar Repuesto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- ══ MODAL: AJUSTAR STOCK ══ --}}
    @if($showAdjustModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl p-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md"
                    style="background:#0d1117; border:1.5px solid #1f2937;">

                    <div class="flex items-center justify-between pb-4 border-b border-gray-800 mb-5">
                        <h3 class="text-base font-black text-white flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:rgba(0,198,182,.1); border:1px solid rgba(0,198,182,.2);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#2dd4bf;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
                                </svg>
                            </div>
                            <span>Ajustar Balance de Stock</span>
                        </h3>
                        <button type="button" wire:click="$set('showAdjustModal', false)"
                            class="p-1.5 rounded-xl text-gray-500 hover:text-white hover:bg-gray-800 transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="adjustStock" class="space-y-4">
                        <p class="text-xs text-gray-400 leading-relaxed">
                            Ingresa un número positivo para sumar stock (ej: <strong class="text-teal-400">+5</strong>) o un número negativo para descontar stock (ej: <strong class="text-red-400">-2</strong>).
                        </p>

                        {{-- Botones de acceso rápido --}}
                        <div class="flex flex-wrap gap-2">
                            <button type="button" wire:click="$set('adjustAmount', 1)"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold bg-gray-800 hover:bg-gray-700 text-teal-300 border border-gray-700 transition">
                                +1 un.
                            </button>
                            <button type="button" wire:click="$set('adjustAmount', 5)"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold bg-gray-800 hover:bg-gray-700 text-teal-300 border border-gray-700 transition">
                                +5 un.
                            </button>
                            <button type="button" wire:click="$set('adjustAmount', -1)"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold bg-gray-800 hover:bg-gray-700 text-red-400 border border-gray-700 transition">
                                -1 un.
                            </button>
                            <button type="button" wire:click="$set('adjustAmount', -5)"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold bg-gray-800 hover:bg-gray-700 text-red-400 border border-gray-700 transition">
                                -5 un.
                            </button>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Cantidad a Ajustar *</label>
                            <input wire:model="adjustAmount" type="number" placeholder="Ej: 5 o -3" required
                                class="w-full rounded-xl p-3 text-sm font-bold text-white placeholder-gray-600 transition-all focus:outline-none"
                                style="background:#111827; border:1.5px solid #1f2937;"
                                onfocus="this.style.borderColor='#00C6B6';" onblur="this.style.borderColor='#1f2937';">
                            @error('adjustAmount') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800 mt-6">
                            <button type="button" wire:click="$set('showAdjustModal', false)"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold text-gray-400 transition cursor-pointer"
                                style="background:#111827; border:1.5px solid #1f2937;">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider text-white transition shadow-lg cursor-pointer"
                                style="background:linear-gradient(135deg,#00C6B6,#2563eb);">
                                Aplicar Ajuste
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

</div>
