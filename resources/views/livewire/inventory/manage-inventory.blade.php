<div class="space-y-6 animate-fade-in">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Inventario de Repuestos</h1>
            <p class="text-sm text-gray-400 mt-1">Supervisa y ajusta el stock de repuestos, insumos y componentes del taller.</p>
        </div>
        
        <button wire:click="openCreateModal" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded-2xl shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition duration-200 cursor-pointer self-start sm:self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Agregar Repuesto
        </button>
    </div>

    <!-- FILTER BAR (SEARCH) -->
    <div class="bg-gray-850 p-5 rounded-3xl border border-gray-800 shadow-md flex flex-col sm:flex-row gap-4 items-center justify-between">
        <!-- Search Input -->
        <div class="relative w-full sm:w-96">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live="search" type="text" placeholder="Buscar por nombre, categoría..." 
                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
        </div>

        <span class="text-xs font-semibold text-gray-400">
            {{ count($parts) }} repuestos registrados
        </span>
    </div>

    <!-- DESKTOP TABLE -->
    <div class="hidden md:block bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden mt-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-900/40 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                        <th class="px-6 py-4">Nombre del Repuesto</th>
                        <th class="px-6 py-4">Categoría</th>
                        <th class="px-6 py-4 text-center">Stock Disponible</th>
                        <th class="px-6 py-4">Precio Venta</th>
                        @if(auth()->user()->isAdmin())
                            <th class="px-6 py-4">Precio Costo</th>
                            <th class="px-6 py-4">Margen Ganancia</th>
                        @endif
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($parts as $part)
                        <tr class="hover:bg-gray-900/20 transition">
                            <!-- Name -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-white block">{{ $part->name }}</span>
                            </td>
                            <!-- Category -->
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold bg-gray-900/60 border border-gray-700/60 rounded-lg text-gray-300">
                                    {{ $part->category }}
                                </span>
                            </td>
                            <!-- Stock -->
                            <td class="px-6 py-4 text-center">
                                @if($part->stock <= 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black bg-red-950/40 text-red-400 border border-red-500/20 animate-pulse">
                                        Sin Stock
                                    </span>
                                @elseif($part->stock < 5)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black bg-amber-950/40 text-amber-400 border border-amber-500/20">
                                        Stock Bajo ({{ $part->stock }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-900/40 text-blue-400 border border-blue-500/10">
                                        {{ $part->stock }} unidades
                                    </span>
                                @endif
                            </td>
                            <!-- Sale Price -->
                            <td class="px-6 py-4 font-semibold text-white">
                                ${{ number_format($part->sale_price, 0, ',', '.') }}
                            </td>
                            <!-- Cost Price (Admin Only) -->
                            @if(auth()->user()->isAdmin())
                                <td class="px-6 py-4 text-gray-300">
                                    ${{ number_format($part->cost_price, 0, ',', '.') }}
                                </td>
                                <!-- Margin -->
                                <td class="px-6 py-4">
                                    @php
                                        $margin = $part->sale_price - $part->cost_price;
                                        $percent = $part->cost_price > 0 ? round(($margin / $part->cost_price) * 100) : 100;
                                    @endphp
                                    <span class="text-xs font-bold text-emerald-400">
                                        ${{ number_format($margin, 0, ',', '.') }} (+{{ $percent }}%)
                                    </span>
                                </td>
                            @endif
                            <!-- Actions -->
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <button wire:click="openAdjustModal({{ $part->id }})" class="px-3 py-1.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-semibold rounded-lg transition flex items-center gap-1 cursor-pointer">
                                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                        Ajustar Stock
                                    </button>

                                    @if(auth()->user()->isAdmin())
                                        <button wire:click="deletePart({{ $part->id }})" wire:confirm="¿Seguro que deseas eliminar este repuesto del catálogo?" class="p-1.5 bg-red-950/20 hover:bg-red-500/10 border border-red-500/10 rounded-lg text-red-400 hover:text-red-300 transition cursor-pointer" title="Eliminar Repuesto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                No se encontraron repuestos registrados en el catálogo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MOBILE CARDS -->
    <div class="md:hidden flex flex-col gap-4 mt-6">
        @forelse($parts as $part)
            <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-md p-4 flex flex-col gap-3">
                <div class="flex items-center justify-between border-b border-gray-800/60 pb-3">
                    <span class="font-bold text-white text-base">{{ $part->name }}</span>
                    <span class="px-2 py-0.5 text-[10px] font-semibold bg-gray-900/60 border border-gray-700/60 rounded-lg text-gray-300">{{ $part->category }}</span>
                </div>
                
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <span class="block text-[10px] text-gray-500 uppercase">Stock</span>
                        @if($part->stock <= 0)
                            <span class="text-red-400 font-black animate-pulse">Sin Stock</span>
                        @elseif($part->stock < 5)
                            <span class="text-amber-400 font-black">Bajo ({{ $part->stock }})</span>
                        @else
                            <span class="text-blue-400 font-bold">{{ $part->stock }} un.</span>
                        @endif
                    </div>
                    <div>
                        <span class="block text-[10px] text-gray-500 uppercase">Precio Venta</span>
                        <span class="text-white font-bold">${{ number_format($part->sale_price, 0, ',', '.') }}</span>
                    </div>
                    @if(auth()->user()->isAdmin())
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Precio Costo</span>
                            <span class="text-gray-300 font-medium">${{ number_format($part->cost_price, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Margen</span>
                            @php
                                $margin = $part->sale_price - $part->cost_price;
                                $percent = $part->cost_price > 0 ? round(($margin / $part->cost_price) * 100) : 100;
                            @endphp
                            <span class="text-emerald-400 font-bold">${{ number_format($margin, 0, ',', '.') }} (+{{ $percent }}%)</span>
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-2 pt-2 border-t border-gray-800/60 mt-1">
                    <button wire:click="openAdjustModal({{ $part->id }})" class="flex-1 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-semibold rounded-xl transition flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        Ajustar Stock
                    </button>
                    @if(auth()->user()->isAdmin())
                        <button wire:click="deletePart({{ $part->id }})" wire:confirm="¿Seguro que deseas eliminar este repuesto?" class="p-2 bg-red-950/20 hover:bg-red-500/10 border border-red-500/10 rounded-xl text-red-400 hover:text-red-300 transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-gray-850 rounded-3xl border border-gray-800 p-8 text-center text-gray-500">
                <svg class="w-10 h-10 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <p class="text-sm font-medium">No se encontraron repuestos registrados.</p>
            </div>
        @endforelse
    </div>

    <!-- MODAL: ADD REPUESTO -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm transition-opacity"></div>
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-gray-850 border border-gray-700 px-6 py-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg animate-scale-up">
                    
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>

                    <div class="flex items-center justify-between pb-4 border-b border-gray-800 mb-6">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Registrar Nuevo Repuesto
                        </h3>
                        <button wire:click="$set('showModal', false)" class="p-1 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="savePart" class="space-y-4">
                        <div>
                            <label for="p_name" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Nombre del Repuesto/Componente *</label>
                            <input wire:model="name" id="p_name" type="text" placeholder="Ej: Pantalla OLED OEM iPhone 13" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                            @error('name') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="p_cat" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Categoría *</label>
                            <input wire:model="category" id="p_cat" type="text" placeholder="Ej: Pantallas, Baterías, Ventiladores..." 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                            @error('category') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="p_stock" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Stock Inicial *</label>
                                <input wire:model="stock" id="p_stock" type="number" 
                                    class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                                @error('stock') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="p_cost" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Precio Costo ($) *</label>
                                <input wire:model="cost_price" id="p_cost" type="number" step="0.01" 
                                    class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                                @error('cost_price') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="p_sale" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Precio de Venta ($) *</label>
                            <input wire:model="sale_price" id="p_sale" type="number" step="0.01" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                            @error('sale_price') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800 mt-6">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold rounded-xl transition">
                                Cancelar
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-blue-500/30 transition flex items-center gap-2 cursor-pointer">
                                <span wire:loading.remove wire:target="savePart">Guardar Repuesto</span>
                                <span wire:loading wire:target="savePart" class="flex items-center gap-1.5">
                                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Guardando...
                                </span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

    <!-- MODAL: ADJUST STOCK -->
    @if($showAdjustModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm transition-opacity"></div>
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-gray-850 border border-gray-700 px-6 py-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md animate-scale-up">
                    
                    <div class="flex items-center justify-between pb-4 border-b border-gray-800 mb-6">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Ajustar Balance de Stock
                        </h3>
                        <button wire:click="$set('showAdjustModal', false)" class="p-1 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="adjustStock" class="space-y-4">
                        <div>
                            <p class="text-xs text-gray-400 mb-4">Ingresa un número positivo para añadir stock (ej: `5` para sumar 5 unidades) o un número negativo para restar stock (ej: `-2` para descontar 2 unidades).</p>
                            <label for="adj_amount" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Cantidad a Ajustar *</label>
                            <input wire:model="adjustAmount" id="adj_amount" type="number" placeholder="Ej: 5 o -3" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                            @error('adjustAmount') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800 mt-6">
                            <button type="button" wire:click="$set('showAdjustModal', false)" class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold rounded-xl transition">
                                Cancelar
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-blue-500/30 transition cursor-pointer">
                                Aplicar Ajuste
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif
</div>
