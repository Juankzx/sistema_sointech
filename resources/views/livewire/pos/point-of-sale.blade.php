<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto min-h-screen flex flex-col space-y-6">

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 p-3.5 rounded-lg text-xs font-medium flex items-center gap-2 animate-fade-in shadow-xs">
            <x-ui.icon name="check" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />
            <span>{{ session('message') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 p-3.5 rounded-lg text-xs font-medium flex items-center gap-2 animate-fade-in shadow-xs">
            <x-ui.icon name="alert-triangle" class="w-4 h-4 text-red-600 dark:text-red-400 shrink-0" />
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- ESTADO 1: CAJA CERRADA --}}
    @if(!$activeRegister)
        <div class="space-y-6 animate-fade-in">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight">Punto de Venta</h1>
                    <p class="text-xs text-zinc-500 mt-0.5 font-medium">Ventas y cobranzas rápidas del taller.</p>
                </div>
            </div>

            <!-- Caja Cerrada Banner -->
            <div class="bg-white dark:bg-zinc-900 p-8 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs text-center space-y-4 max-w-xl mx-auto">
                <div class="w-12 h-12 bg-amber-500/10 rounded-full mx-auto flex items-center justify-center border border-amber-500/20 text-amber-600 dark:text-amber-400">
                    <x-ui.icon name="lock" class="w-6 h-6" />
                </div>
                <div>
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">La Caja Diaria está Cerrada</h2>
                    <p class="text-xs text-zinc-500 mt-1 max-w-md mx-auto">Para poder vender o registrar abonos de Órdenes de Trabajo, primero debes abrir la caja del día.</p>
                </div>
                <div>
                    <a href="{{ route('cash-registers.index') }}" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-medium text-xs py-2.5 px-5 rounded-lg transition shadow-xs">
                        <x-ui.icon name="external-link" class="w-4 h-4" />
                        <span>Ir a Apertura de Caja</span>
                    </a>
                </div>
            </div>
        </div>

    {{-- ESTADO 2: CAJA ABIERTA → POS COMPLETO --}}
    @else
        <!-- Header + Register Status Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-zinc-900 p-4 px-5 rounded-xl shadow-xs border border-zinc-200 dark:border-zinc-800">
            <div>
                <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                    <span>Punto de Venta</span>
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-brand-500/10 text-brand-600 dark:text-brand-400 border border-brand-500/20 uppercase tracking-wider">
                        Caja & Cobranzas
                    </span>
                </h1>
                <p class="text-xs text-zinc-500 mt-0.5">Búsqueda rápida de productos y cobro directo de repuestos u Órdenes de Trabajo.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-3 py-1.5 rounded-lg flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-medium">Caja Abierta</span>
                </div>
            </div>
        </div>

        {{-- VENDER --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 flex-1">
            <!-- LEFT COLUMN: Search and Products -->
            <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-4">
                <!-- Search Input -->
                <div class="bg-white dark:bg-zinc-900 p-3 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                            <x-ui.icon name="search" class="w-4 h-4" />
                        </div>
                        <input wire:model.live.debounce.150ms="search" type="text" 
                            class="w-full text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-brand-500 outline-none block pl-9 pr-9 py-2 bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 placeholder-zinc-400 transition" 
                            placeholder="Buscar por nombre de producto, repuesto o código...">
                        
                        @if(strlen($search) > 0)
                            <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition">
                                <x-ui.icon name="x" class="w-4 h-4" />
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-zinc-100 dark:border-zinc-800">
                        <h3 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider flex items-center gap-1.5">
                            <x-ui.icon name="package" class="w-4 h-4 text-zinc-500" />
                            <span>{{ strlen($search) >= 1 ? 'Resultados para "' . $search . '"' : 'Catálogo de Inventario' }}</span>
                        </h3>
                        <span class="text-[10px] font-medium text-zinc-500 bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded">
                            {{ count($foundProducts) }} productos
                        </span>
                    </div>

                    @if(count($foundProducts) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 overflow-y-auto max-h-[580px] pr-1">
                            @foreach($foundProducts as $product)
                                <div wire:click="addToCart({{ $product['id'] }})" 
                                    class="p-3.5 rounded-lg text-left transition duration-150 group flex flex-col justify-between h-full cursor-pointer bg-white dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 shadow-xs">
                                    <div>
                                        <div class="flex items-center justify-between mb-1.5">
                                            <span class="text-[10px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider bg-zinc-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">
                                                {{ $product['category'] ?? 'General' }}
                                            </span>
                                            <span class="text-[10px] font-medium px-1.5 py-0.5 rounded border {{ $product['stock'] > 5 ? 'text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/30 border-emerald-200 dark:border-emerald-800' : 'text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/30 border-amber-200 dark:border-amber-800' }}">
                                                Stock: {{ $product['stock'] }}
                                            </span>
                                        </div>
                                        <h4 class="text-xs font-medium text-zinc-900 dark:text-zinc-100 group-hover:text-brand-600 transition line-clamp-2 leading-snug">
                                            {{ $product['name'] }}
                                        </h4>
                                    </div>

                                    <div class="mt-3 pt-2.5 border-t border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
                                        <span class="text-zinc-900 dark:text-zinc-100 font-semibold font-mono text-sm">
                                            ${{ number_format($product['sale_price'], 0, ',', '.') }}
                                        </span>
                                        <span class="text-[11px] font-medium text-zinc-700 dark:text-zinc-200 bg-zinc-100 dark:bg-zinc-800 group-hover:bg-brand-500 group-hover:text-white px-2.5 py-1 rounded transition flex items-center gap-1">
                                            + Añadir
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 text-zinc-400">
                            <x-ui.icon name="package" class="w-8 h-8 mx-auto mb-2 text-zinc-300 dark:text-zinc-600" />
                            <p class="font-medium text-xs text-zinc-500">No se encontraron productos con stock para "{{ $search }}".</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT COLUMN: Cart & Checkout -->
            <div class="lg:col-span-5 xl:col-span-4 flex flex-col gap-4">
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs overflow-hidden flex flex-col h-full">
                    <!-- Cart Header -->
                    <div class="p-3.5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-900/60">
                        <h2 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider flex items-center gap-2">
                            <x-ui.icon name="shopping-bag" class="w-4 h-4 text-zinc-500" />
                            Carrito de Cobro
                        </h2>
                        <span class="bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 text-[10px] font-medium px-2 py-0.5 rounded border border-zinc-200 dark:border-zinc-700">
                            {{ count($cart) }} {{ count($cart) === 1 ? 'Ítem' : 'Ítems' }}
                        </span>
                    </div>

                    <!-- Cart Items List -->
                    <div class="flex-1 overflow-y-auto p-3.5 space-y-2.5 max-h-[380px]">
                        @forelse($cart as $index => $item)
                            <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-800 space-y-2">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="flex-1">
                                        @if(!empty($item['is_ot']))
                                            <span class="inline-block text-[9px] font-semibold text-brand-700 dark:text-brand-300 bg-brand-50 dark:bg-brand-950/40 border border-brand-200 dark:border-brand-800 px-1.5 py-0.5 rounded uppercase tracking-wider mb-1">
                                                Orden de Trabajo
                                            </span>
                                        @endif
                                        <h4 class="text-xs font-medium text-zinc-900 dark:text-zinc-100 leading-snug">
                                            {{ $item['name'] }}
                                        </h4>
                                    </div>

                                    <button wire:click="removeFromCart({{ $index }})" class="text-zinc-400 hover:text-red-500 transition cursor-pointer p-0.5" title="Eliminar ítem">
                                        <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                    </button>
                                </div>

                                @if(!empty($item['is_ot']))
                                    <div class="space-y-1 pt-1.5 border-t border-zinc-200 dark:border-zinc-800">
                                        <label class="block text-[10px] font-medium text-zinc-500 uppercase tracking-wider">Monto a Abonar / Cobrar ($):</label>
                                        <div class="relative w-full">
                                            <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center text-zinc-500 font-mono text-xs">$</span>
                                            <input wire:model.live.debounce.300ms="cart.{{ $index }}.price" type="number" step="1" min="1" max="{{ $item['price'] }}" 
                                                class="w-full text-zinc-900 dark:text-zinc-100 text-xs font-mono font-semibold rounded-lg py-1.5 pl-6 pr-3 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 focus:ring-1 focus:ring-brand-500 outline-none">
                                        </div>
                                    </div>
                                @else
                                    <div class="flex justify-between items-center pt-2 border-t border-zinc-200/80 dark:border-zinc-800">
                                        <div class="text-zinc-900 dark:text-zinc-100 font-mono font-medium text-xs">
                                            ${{ number_format($item['price'], 0, ',', '.') }} <span class="text-[10px] text-zinc-400 font-sans">c/u</span>
                                        </div>
                                        <div class="flex items-center rounded-lg p-0.5 border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                                            <button wire:click="updateQuantity({{ $index }}, 'decrease')" class="p-1 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded text-zinc-500 transition cursor-pointer">
                                                <x-ui.icon name="minus" class="w-3 h-3" />
                                            </button>
                                            <span class="w-6 text-center text-xs font-medium text-zinc-900 dark:text-zinc-100">{{ $item['quantity'] }}</span>
                                            <button wire:click="updateQuantity({{ $index }}, 'increase')" class="p-1 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded text-zinc-500 transition cursor-pointer">
                                                <x-ui.icon name="plus" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-10 opacity-60 space-y-1.5">
                                <x-ui.icon name="shopping-bag" class="w-8 h-8 text-zinc-400 mx-auto" />
                                <p class="text-xs text-zinc-500 font-medium">El carrito está vacío</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Checkout Controls Section -->
                    <div class="p-3.5 border-t border-zinc-100 dark:border-zinc-800 space-y-3.5 bg-zinc-50/50 dark:bg-zinc-900/40">
                        <!-- 1. Tipo de Documento -->
                        <div>
                            <label class="block text-[10px] font-medium text-zinc-500 uppercase tracking-wider mb-1">1. Tipo de Comprobante</label>
                            <div class="grid grid-cols-3 gap-1.5">
                                <button type="button" wire:click="$set('documentType', 'ticket')" 
                                    class="py-1.5 px-2 rounded-lg text-xs font-medium text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $documentType === 'ticket' ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-xs' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-750' }}">
                                    <x-ui.icon name="file-text" class="w-3.5 h-3.5" />
                                    <span>Ticket</span>
                                </button>
                                <button type="button" wire:click="$set('documentType', 'boleta')" 
                                    class="py-1.5 px-2 rounded-lg text-xs font-medium text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $documentType === 'boleta' ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-xs' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-750' }}">
                                    <x-ui.icon name="receipt" class="w-3.5 h-3.5" />
                                    <span>Boleta</span>
                                </button>
                                <button type="button" wire:click="$set('documentType', 'factura')" 
                                    class="py-1.5 px-2 rounded-lg text-xs font-medium text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $documentType === 'factura' ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-xs' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-750' }}">
                                    <x-ui.icon name="building" class="w-3.5 h-3.5" />
                                    <span>Factura</span>
                                </button>
                            </div>
                        </div>

                        <!-- 2. Método de Pago -->
                        <div>
                            <label class="block text-[10px] font-medium text-zinc-500 uppercase tracking-wider mb-1">2. Método de Pago</label>
                            <div class="grid grid-cols-3 gap-1.5">
                                <button type="button" wire:click="$set('paymentMethod', 'Efectivo')" 
                                    class="py-1.5 px-1.5 rounded-lg text-xs font-medium text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $paymentMethod === 'Efectivo' ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-xs' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-750' }}">
                                    <x-ui.icon name="banknote" class="w-3.5 h-3.5" />
                                    <span>Efectivo</span>
                                </button>
                                <button type="button" wire:click="$set('paymentMethod', 'Transferencia')" 
                                    class="py-1.5 px-1.5 rounded-lg text-xs font-medium text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $paymentMethod === 'Transferencia' ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-xs' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-750' }}">
                                    <x-ui.icon name="arrow-right-left" class="w-3.5 h-3.5" />
                                    <span>Transfer.</span>
                                </button>
                                <button type="button" wire:click="$set('paymentMethod', 'Tarjeta')" 
                                    class="py-1.5 px-1.5 rounded-lg text-xs font-medium text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $paymentMethod === 'Tarjeta' ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-xs' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-750' }}">
                                    <x-ui.icon name="credit-card" class="w-3.5 h-3.5" />
                                    <span>Tarjeta</span>
                                </button>
                            </div>
                        </div>

                        <!-- 3. Cliente Segmented Selector -->
                        <div>
                            <label class="block text-[10px] font-medium text-zinc-500 uppercase tracking-wider mb-1">3. Datos del Cliente</label>
                            <div class="grid grid-cols-3 gap-1 p-0.5 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 mb-2">
                                <button type="button" wire:click="$set('clientMode', 'generic')" 
                                    class="text-[10px] font-medium uppercase py-1 px-1 rounded transition cursor-pointer
                                        {{ $clientMode === 'generic' ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
                                    Genérico
                                </button>
                                <button type="button" wire:click="$set('clientMode', 'registered')" 
                                    class="text-[10px] font-medium uppercase py-1 px-1 rounded transition cursor-pointer
                                        {{ $clientMode === 'registered' ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
                                    Buscar
                                </button>
                                <button type="button" wire:click="$set('clientMode', 'new')" 
                                    class="text-[10px] font-medium uppercase py-1 px-1 rounded transition cursor-pointer
                                        {{ $clientMode === 'new' ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
                                    Nuevo
                                </button>
                            </div>

                            @if($clientMode === 'generic')
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input wire:model="clientName" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg p-2 focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Nombre (Opcional)">
                                    </div>
                                    <div>
                                        <input wire:model="clientPhone" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg p-2 focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Teléfono (Opcional)">
                                    </div>
                                </div>
                            @elseif($clientMode === 'registered')
                                <div class="space-y-1.5">
                                    @if(!$selectedClientId)
                                        <div class="relative">
                                            <input wire:model.live.debounce.150ms="searchClient" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg p-2 pl-7 focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Buscar por Nombre, RUT o Teléfono...">
                                            <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none text-zinc-400">
                                                <x-ui.icon name="search" class="w-3.5 h-3.5" />
                                            </div>
                                        </div>
                                        @if(count($foundClients) > 0)
                                            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden max-h-32 overflow-y-auto shadow-md">
                                                @foreach($foundClients as $fclient)
                                                    <div wire:click="selectClient({{ $fclient['id'] }})" class="p-2 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                                                        <div class="text-xs font-medium text-zinc-900 dark:text-zinc-100">{{ $fclient['full_name'] }}</div>
                                                        <div class="text-[10px] text-zinc-500">{{ $fclient['rut_dni'] ?? 'Sin RUT' }} | {{ $fclient['phone'] }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        <div class="p-2.5 rounded-lg flex justify-between items-center border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/40 text-zinc-800 dark:text-zinc-200">
                                            <div>
                                                <div class="text-[9px] font-medium uppercase tracking-wider text-zinc-500">Cliente Seleccionado</div>
                                                <div class="text-xs font-semibold">{{ $clientName }}</div>
                                                <div class="text-[10px] text-zinc-500">{{ $clientRut ?? 'Sin RUT' }} | {{ $clientPhone }}</div>
                                            </div>
                                            <button wire:click="$set('selectedClientId', null)" class="text-zinc-400 hover:text-red-500 transition cursor-pointer p-1" title="Cambiar Cliente">
                                                <x-ui.icon name="x" class="w-4 h-4" />
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @elseif($clientMode === 'new')
                                <div class="grid grid-cols-2 gap-2">
                                    <div><input wire:model="clientName" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg p-1.5 focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Nombre *"></div>
                                    <div><input wire:model="clientPhone" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg p-1.5 focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Teléfono *"></div>
                                    <div><input wire:model="clientRut" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg p-1.5 focus:ring-1 focus:ring-brand-500 outline-none" placeholder="RUT (Opc.)"></div>
                                    <div><input wire:model="clientEmail" type="email" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg p-1.5 focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Email (Opc.)"></div>
                                </div>
                            @endif

                            @if($documentType === 'factura')
                                <div class="mt-2.5 p-2.5 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/40 space-y-2">
                                    <h4 class="text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Datos Facturación SII</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input wire:model="clientRut" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded p-1.5" placeholder="RUT Empresa *">
                                        <input wire:model="clientName" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded p-1.5" placeholder="Razón Social *">
                                    </div>
                                    <input wire:model="clientGiro" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded p-1.5" placeholder="Giro Comercial *">
                                    <div class="grid grid-cols-2 gap-2">
                                        <input wire:model="clientAddress" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded p-1.5" placeholder="Dirección *">
                                        <input wire:model="clientCity" type="text" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded p-1.5" placeholder="Comuna *">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Totals Breakdown -->
                        <div class="space-y-1 pt-2.5 border-t border-zinc-200 dark:border-zinc-800">
                            <div class="flex justify-between text-xs text-zinc-500">
                                <span>Subtotal (Neto)</span>
                                <span class="font-mono">${{ number_format($this->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-xs text-zinc-500">
                                <span>IVA ({{ $taxRate }}%)</span>
                                <span class="font-mono">${{ number_format($this->taxAmount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-base text-zinc-900 dark:text-zinc-100 font-semibold pt-1.5 border-t border-zinc-200 dark:border-zinc-800 mt-1">
                                <span>TOTAL</span>
                                <span class="font-mono font-semibold">${{ number_format($this->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Process Sale Button -->
                        <button wire:click="processSale" wire:loading.attr="disabled" 
                            class="w-full bg-brand-500 hover:bg-brand-600 text-white font-medium text-xs py-3 px-4 rounded-lg shadow-xs transition duration-150 flex justify-center items-center gap-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="processSale" class="flex items-center gap-1.5">
                                <x-ui.icon name="check" class="w-4 h-4" />
                                <span>Completar Cobro (${{ number_format($this->total, 0, ',', '.') }})</span>
                            </span>
                            <span wire:loading wire:target="processSale" class="flex items-center gap-1.5">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span>Procesando Cobro...</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- RECEIPT MODAL --}}
    @if($showReceiptModal && $completedSale)
        <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl w-full max-w-md overflow-hidden shadow-xl animate-fade-in flex flex-col">
                <div class="p-5 text-center border-b border-zinc-100 dark:border-zinc-800">
                    <div class="w-12 h-12 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-3 border border-emerald-500/20">
                        <x-ui.icon name="check" class="w-6 h-6" />
                    </div>
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">¡Venta Exitosa!</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">El pago fue registrado correctamente y la caja actualizada.</p>
                </div>
                <div class="p-5 flex flex-col gap-2.5">
                    <button onclick="window.printContent('pos-thermal-receipt', 'pos-canvas')" class="w-full bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-100 dark:hover:bg-white text-white dark:text-zinc-900 font-medium py-2.5 px-4 rounded-lg text-xs transition flex justify-center items-center gap-2 cursor-pointer shadow-xs">
                        <x-ui.icon name="printer" class="w-4 h-4" />
                        <span>Imprimir Ticket Térmico</span>
                    </button>
                    <button wire:click="$set('showReceiptModal', false)" class="w-full bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 font-medium py-2 px-4 rounded-lg text-xs transition cursor-pointer">
                        Cerrar y Nueva Venta
                    </button>
                </div>
                <!-- Hidden Thermal Template -->
                <div class="hidden">
                    @php
                        $posLogoData = '';
                        $posLogoPath = public_path('images/logo-dark.png');
                        if (file_exists($posLogoPath)) {
                            $posLogoData = 'data:image/png;base64,' . base64_encode(file_get_contents($posLogoPath));
                        }
                    @endphp
                    <div id="pos-thermal-receipt" class="thermal-ticket-container" style="font-family: 'Inter', Arial, sans-serif; width: 100%; max-width: 76mm; text-align: center; margin: 0 auto; color: #000; background: #fff; padding: 2px;">
                        
                        <!-- Header / Logo -->
                        <div style="text-align: center; padding-bottom: 6px; border-bottom: 2px dashed #000; margin-bottom: 6px;">
                            @if($posLogoData)
                                <div style="background: #0f172a; padding: 6px 12px; border-radius: 8px; display: inline-block; margin-bottom: 4px;">
                                    <img src="{{ $posLogoData }}" alt="Logo" style="max-height: 28px; width: auto; display: block; margin: 0 auto;">
                                </div>
                            @endif
                            <div style="font-size: 14px; font-weight: 900; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 2px;">
                                {{ $companySettings->company_name ?? 'SOIN TECHNOLOGY' }}
                            </div>
                            <div style="font-size: 9px; color: #333; margin-top: 2px; line-height: 1.2;">
                                @if($companySettings && $companySettings->company_rut)<div>RUT: {{ $companySettings->company_rut }}</div>@endif
                                @if($companySettings && $companySettings->company_address)<div>{{ $companySettings->company_address }}</div>@endif
                                @if($companySettings && $companySettings->company_phone)<div>Tel: {{ $companySettings->company_phone }}</div>@endif
                            </div>
                        </div>

                        <!-- Ticket Type Title -->
                        <div style="font-size: 11px; font-weight: 900; text-transform: uppercase; border-bottom: 1.5px solid #000; padding: 3px 0; margin-bottom: 6px; letter-spacing: 0.5px;">
                            {{ strtoupper($completedSale->document_type ?? 'COMPROBANTE DE PAGO') }}
                        </div>

                        <!-- Info Metadata Grid -->
                        <div style="font-size: 10px; text-align: left; margin-bottom: 6px; line-height: 1.35; border-bottom: 1px dashed #000; padding-bottom: 6px;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Fecha:</strong> {{ $completedSale->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Folio:</strong> #{{ substr($completedSale->uuid, 0, 8) }}</span>
                                <span><strong>Pago:</strong> {{ $completedSale->payment_method }}</span>
                            </div>
                            <div style="margin-top: 2px;">
                                <strong>Cliente:</strong> {{ \Illuminate\Support\Str::limit($completedSale->client_name, 28) }}
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div style="width: 100%; margin-bottom: 6px;">
                            <table style="width: 100%; font-size: 10px; text-align: left; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 1.5px solid #000; font-size: 9px;">
                                        <th style="padding-bottom: 3px; width: 12%;">CANT</th>
                                        <th style="padding-bottom: 3px; width: 63%;">DESCRIPCIÓN</th>
                                        <th style="padding-bottom: 3px; width: 25%; text-align: right;">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completedSale->items as $item)
                                        <tr style="border-bottom: 1px dashed #ddd;">
                                            <td style="padding: 4px 0; vertical-align: top; font-weight: bold;">{{ $item->quantity }}x</td>
                                            <td style="padding: 4px 2px; vertical-align: top;">
                                                <div style="font-weight: 700; word-break: break-word;">{{ $item->name }}</div>
                                                <div style="font-size: 8px; color: #444;">${{ number_format($item->unit_price, 0, ',', '.') }} c/u</div>
                                            </td>
                                            <td style="padding: 4px 0; text-align: right; vertical-align: top; font-weight: 800;">
                                                ${{ number_format($item->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Totals Summary -->
                        <div style="font-size: 10px; text-align: left; border-top: 1.5px solid #000; padding-top: 4px; margin-bottom: 8px; line-height: 1.4;">
                            <div style="display: flex; justify-content: space-between;">
                                <span>Subtotal Neto:</span>
                                <span>${{ number_format($completedSale->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>IVA ({{ $completedSale->tax_rate }}%):</span>
                                <span>${{ number_format($completedSale->tax_amount, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-top: 3px; font-size: 13px; font-weight: 900; border-top: 1px solid #000; padding-top: 3px;">
                                <span>TOTAL:</span>
                                <span>${{ number_format($completedSale->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- QR Code & Footer -->
                        <div style="text-align: center; border-top: 1px dashed #000; padding-top: 6px;">
                            <div style="margin: 0 auto 4px; display: inline-block;">
                                <canvas id="pos-canvas" data-url="{{ url('/ventas/comprobante/'.$completedSale->uuid) }}"></canvas>
                            </div>
                            <div style="font-size: 8px; font-weight: bold; margin-bottom: 2px;">
                                ¡Gracias por preferir a SOIN TECHNOLOGY!
                            </div>
                            <div style="font-size: 7.5px; color: #555;">
                                Conserve este comprobante para cualquier consulta.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
