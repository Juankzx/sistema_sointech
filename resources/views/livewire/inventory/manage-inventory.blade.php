<div class="space-y-6 pb-16 md:pb-6">

    {{-- Flash Notifications --}}
    @if(session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" />
            <span class="text-emerald-800 dark:text-emerald-300 text-xs font-medium">{{ session('message') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50">
                    <x-ui.icon name="package" class="w-5 h-5" />
                </span>
                Inventario de Repuestos
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Supervisa y ajusta en tiempo real el stock de repuestos e insumos del taller.</p>
        </div>

        <button type="button" wire:click="openCreateModal"
            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold rounded-lg shadow-xs transition duration-150 cursor-pointer self-start sm:self-auto">
            <x-ui.icon name="plus" class="w-4 h-4" />
            Agregar Repuesto
        </button>
    </div>

    {{-- Tarjetas de Métricas KPI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Catálogo --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">
                <x-ui.icon name="package" class="w-5 h-5" />
            </div>
            <div>
                <div class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400">Repuestos en Catálogo</div>
                <div class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mt-0.5">{{ $totalParts }}</div>
            </div>
        </div>

        {{-- Alertas de Stock Bajo --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400">
                <x-ui.icon name="alert-triangle" class="w-5 h-5" />
            </div>
            <div>
                <div class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400">Stock Bajo (< 5)</div>
                <div class="text-xl font-bold text-amber-600 dark:text-amber-400 mt-0.5">{{ $lowStockCount }}</div>
            </div>
        </div>

        {{-- Agotados --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400">
                <x-ui.icon name="x-circle" class="w-5 h-5" />
            </div>
            <div>
                <div class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400">Sin Stock</div>
                <div class="text-xl font-bold text-red-600 dark:text-red-400 mt-0.5">{{ $outOfStockCount }}</div>
            </div>
        </div>

        {{-- Valorización --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                <x-ui.icon name="dollar-sign" class="w-5 h-5" />
            </div>
            <div>
                <div class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400">Valor Inventario</div>
                <div class="text-xl font-bold text-emerald-600 dark:text-emerald-400 mt-0.5">${{ number_format($totalValuation, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Barra de Búsqueda --}}
    <div class="bg-white dark:bg-zinc-900 rounded-xl p-3.5 border border-zinc-200 dark:border-zinc-800 shadow-xs flex flex-col sm:flex-row gap-3 items-center justify-between">
        <div class="relative w-full sm:w-96">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-zinc-400">
                <x-ui.icon name="search" class="w-4 h-4" />
            </span>
            <input wire:model.live.debounce.150ms="search" type="text"
                placeholder="Buscar repuesto por nombre o categoría..."
                class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-1.5 pl-9 pr-8 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">

            @if($search)
                <button type="button" wire:click="$set('search', '')"
                    class="absolute inset-y-0 right-2.5 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <x-ui.icon name="x" class="w-3.5 h-3.5" />
                </button>
            @endif
        </div>

        <div class="text-[11px] font-medium text-zinc-400 self-end sm:self-center shrink-0">
            Mostrando <span class="font-semibold text-zinc-800 dark:text-zinc-200 font-mono">{{ count($parts) }}</span> repuesto{{ count($parts) !== 1 ? 's' : '' }}
        </div>
    </div>

    {{-- TABLA DESKTOP --}}
    <div class="hidden md:block bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 border-b border-zinc-200 dark:border-zinc-800 text-[10px] uppercase text-zinc-500 dark:text-zinc-400 font-semibold tracking-wider">
                        <th class="px-4 py-3">Nombre del Repuesto</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3 text-center">Stock Disponible</th>
                        <th class="px-4 py-3 text-right">Precio Venta</th>
                        @if(auth()->user()->isAdmin())
                            <th class="px-4 py-3 text-right">Precio Costo</th>
                            <th class="px-4 py-3 text-right">Margen Ganancia</th>
                        @endif
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($parts as $part)
                        <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors">
                            {{-- Nombre --}}
                            <td class="px-4 py-3">
                                <span class="font-semibold text-zinc-800 dark:text-zinc-200 text-xs block leading-tight">{{ $part->name }}</span>
                            </td>

                            {{-- Categoría --}}
                            <td class="px-4 py-3">
                                <x-ui.badge variant="neutral" size="xs">
                                    {{ $part->category }}
                                </x-ui.badge>
                            </td>

                            {{-- Stock --}}
                            <td class="px-4 py-3 text-center">
                                @if($part->stock <= 0)
                                    <x-ui.badge variant="danger" size="xs">
                                        Sin Stock
                                    </x-ui.badge>
                                @elseif($part->stock < 5)
                                    <x-ui.badge variant="warning" size="xs">
                                        Bajo ({{ $part->stock }})
                                    </x-ui.badge>
                                @else
                                    <x-ui.badge variant="info" size="xs">
                                        {{ $part->stock }} uds
                                    </x-ui.badge>
                                @endif
                            </td>

                            {{-- Precio Venta --}}
                            <td class="px-4 py-3 text-right font-mono font-bold text-zinc-900 dark:text-zinc-100 text-xs">
                                ${{ number_format($part->sale_price, 0, ',', '.') }}
                            </td>

                            {{-- Precio Costo (Admin Only) --}}
                            @if(auth()->user()->isAdmin())
                                <td class="px-4 py-3 text-right font-mono text-zinc-500 dark:text-zinc-400 text-xs">
                                    ${{ number_format($part->cost_price, 0, ',', '.') }}
                                </td>

                                {{-- Margen Ganancia --}}
                                <td class="px-4 py-3 text-right font-mono text-xs">
                                    @php
                                        $margin = $part->sale_price - $part->cost_price;
                                        $percent = $part->cost_price > 0 ? round(($margin / $part->cost_price) * 100) : 100;
                                    @endphp
                                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">
                                        ${{ number_format($margin, 0, ',', '.') }}
                                        <span class="text-[10px] text-zinc-400">(+{{ $percent }}%)</span>
                                    </span>
                                </td>
                            @endif

                            {{-- Acciones --}}
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Ajustar Stock --}}
                                    <button type="button" wire:click="openAdjustModal({{ $part->id }})"
                                        title="Ajustar inventario"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-zinc-700 dark:text-zinc-300 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                                        <x-ui.icon name="sliders" class="w-3 h-3 text-orange-500" />
                                        Ajustar
                                    </button>

                                    {{-- Eliminar (Admin Only) --}}
                                    @if(auth()->user()->isAdmin())
                                        <button type="button" wire:click="deletePart({{ $part->id }})"
                                            wire:confirm="¿Seguro que deseas eliminar este repuesto del catálogo?"
                                            title="Eliminar del catálogo"
                                            class="p-1.5 rounded-md text-zinc-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 transition cursor-pointer">
                                            <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-zinc-400 dark:text-zinc-500 text-xs">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <x-ui.icon name="package" class="w-8 h-8 text-zinc-300 dark:text-zinc-600" />
                                    <span>No se encontraron repuestos registrados.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TARJETAS MOBILE --}}
    <div class="md:hidden flex flex-col gap-2.5">
        @forelse($parts as $part)
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 shadow-xs space-y-2.5">
                <div class="flex items-center justify-between gap-3 pb-2 border-b border-zinc-100 dark:border-zinc-800">
                    <span class="font-bold text-zinc-900 dark:text-zinc-100 text-xs">{{ $part->name }}</span>
                    <x-ui.badge variant="neutral" size="xs">{{ $part->category }}</x-ui.badge>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Stock</span>
                        @if($part->stock <= 0)
                            <span class="text-red-600 dark:text-red-400 font-bold">Sin Stock</span>
                        @elseif($part->stock < 5)
                            <span class="text-amber-600 dark:text-amber-400 font-bold">Bajo ({{ $part->stock }})</span>
                        @else
                            <span class="text-zinc-700 dark:text-zinc-300 font-medium">{{ $part->stock }} un.</span>
                        @endif
                    </div>
                    <div>
                        <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Precio Venta</span>
                        <span class="text-zinc-900 dark:text-zinc-100 font-bold font-mono">${{ number_format($part->sale_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2 border-t border-zinc-100 dark:border-zinc-800">
                    <button wire:click="openAdjustModal({{ $part->id }})"
                        class="flex-1 py-1.5 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs font-semibold rounded-lg border border-zinc-200 dark:border-zinc-700 flex items-center justify-center gap-1.5 cursor-pointer">
                        <x-ui.icon name="sliders" class="w-3.5 h-3.5 text-orange-500" />
                        Ajustar Stock
                    </button>
                    @if(auth()->user()->isAdmin())
                        <button wire:click="deletePart({{ $part->id }})" wire:confirm="¿Deseas eliminar este repuesto?"
                            class="p-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/40 text-red-700 dark:text-red-400 text-xs font-semibold rounded-lg border border-red-200 dark:border-red-800/60 cursor-pointer">
                            <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-8 text-center text-zinc-400 dark:text-zinc-500 text-xs">
                No se encontraron repuestos.
            </div>
        @endforelse
    </div>

    {{-- MODAL: AGREGAR REPUESTO --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-zinc-950/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl p-5 max-w-lg w-full relative">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-100 dark:border-zinc-800 mb-4">
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                        <x-ui.icon name="package" class="w-4 h-4 text-orange-500" />
                        Registrar Nuevo Repuesto
                    </h3>
                    <button type="button" wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-pointer">
                        <x-ui.icon name="x" class="w-4 h-4" />
                    </button>
                </div>

                <form wire:submit.prevent="savePart" class="space-y-3.5">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Nombre del Repuesto *</label>
                        <input wire:model="name" type="text" placeholder="Ej: Pantalla OLED OEM iPhone 13" required
                            class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
                        @error('name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Categoría *</label>
                        <input wire:model="category" type="text" placeholder="Ej: Pantallas, Baterías, Conectores..." required
                            class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
                        @error('category') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Stock Inicial *</label>
                            <input wire:model="stock" type="number" min="0" required
                                class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500 transition">
                            @error('stock') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Precio Costo ($) *</label>
                            <input wire:model="cost_price" type="number" step="1" min="0" required
                                class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500 transition">
                            @error('cost_price') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Precio Venta ($) *</label>
                        <input wire:model="sale_price" type="number" step="1" min="0" required
                            class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500 transition">
                        @error('sale_price') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-zinc-100 dark:border-zinc-800 mt-4">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-4 py-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-lg transition cursor-pointer">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-xs font-semibold text-white bg-orange-600 hover:bg-orange-700 rounded-lg transition shadow-xs cursor-pointer">
                            Guardar Repuesto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL: AJUSTAR STOCK --}}
    @if($showAdjustModal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-zinc-950/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl p-5 max-w-md w-full relative">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-100 dark:border-zinc-800 mb-3">
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                        <x-ui.icon name="sliders" class="w-4 h-4 text-orange-500" />
                        Ajustar Balance de Stock
                    </h3>
                    <button type="button" wire:click="$set('showAdjustModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-pointer">
                        <x-ui.icon name="x" class="w-4 h-4" />
                    </button>
                </div>

                <form wire:submit.prevent="adjustStock" class="space-y-3.5">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        Ingresa un número positivo para sumar stock (ej: <strong class="text-emerald-600 dark:text-emerald-400">+5</strong>) o negativo para descontar (ej: <strong class="text-red-600 dark:text-red-400">-2</strong>).
                    </p>

                    {{-- Botones de acceso rápido --}}
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" wire:click="$set('adjustAmount', 1)"
                            class="px-2.5 py-1 rounded-md text-xs font-medium bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                            +1 un.
                        </button>
                        <button type="button" wire:click="$set('adjustAmount', 5)"
                            class="px-2.5 py-1 rounded-md text-xs font-medium bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                            +5 un.
                        </button>
                        <button type="button" wire:click="$set('adjustAmount', -1)"
                            class="px-2.5 py-1 rounded-md text-xs font-medium bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                            -1 un.
                        </button>
                        <button type="button" wire:click="$set('adjustAmount', -5)"
                            class="px-2.5 py-1 rounded-md text-xs font-medium bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                            -5 un.
                        </button>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Cantidad a Ajustar *</label>
                        <input wire:model="adjustAmount" type="number" placeholder="Ej: 5 o -3" required
                            class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 font-bold focus:outline-none focus:border-orange-500 transition">
                        @error('adjustAmount') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                        <button type="button" wire:click="$set('showAdjustModal', false)"
                            class="px-4 py-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-lg transition cursor-pointer">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-xs font-semibold text-white bg-orange-600 hover:bg-orange-700 rounded-lg transition shadow-xs cursor-pointer">
                            Aplicar Ajuste
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>