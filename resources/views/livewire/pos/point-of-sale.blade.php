<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto min-h-screen flex flex-col space-y-6">

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 animate-fade-in shadow-sm">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-50 dark:bg-red-950/50 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 animate-fade-in shadow-sm">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{-- ESTADO 1: CAJA CERRADA                                      --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    @if(!$activeRegister)
        <div class="space-y-6 animate-fade-in">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Punto de Venta</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Ventas y cobranzas rápidas del taller.</p>
                </div>
            </div>

            <!-- Caja Cerrada Banner -->
            <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm text-center space-y-4 max-w-2xl mx-auto">
                <div class="w-20 h-20 bg-amber-500/10 rounded-full mx-auto flex items-center justify-center border border-amber-500/20 text-amber-600">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h2 class="text-xl font-black text-slate-900 dark:text-white">La Caja Diaria está Cerrada</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto">Para poder vender o registrar abonos de Órdenes de Trabajo, primero debes abrir la caja del día.</p>
                <a href="/caja" class="inline-block bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-bold py-3 px-6 rounded-xl shadow-md shadow-orange-500/20 transition mt-2">
                    Ir a Apertura de Caja
                </a>
            </div>
        </div>

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{-- ESTADO 2: CAJA ABIERTA → POS COMPLETO                      --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    @else
        <!-- Header + Register Status Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-700">
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                    <span>Punto de Venta</span>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-orange-500/10 text-orange-600 dark:bg-orange-500/20 dark:text-orange-300 border border-orange-500/20">
                        Caja & Cobranzas
                    </span>
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Búsqueda rápida de productos y cobro directo de repuestos u Órdenes de Trabajo.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-2 rounded-xl flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold">Caja Abierta</span>
                </div>
            </div>
        </div>

        {{-- ═══ VENDER ═══ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 flex-1">
            <!-- LEFT COLUMN: Search and Products -->
            <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-6">
                <!-- Search Input -->
                <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input wire:model.live.debounce.150ms="search" type="text" 
                            class="w-full text-slate-900 dark:text-white text-xs rounded-xl focus:ring-2 focus:ring-orange-500 outline-none block pl-11 pr-10 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 placeholder-slate-400 font-medium transition" 
                            placeholder="Buscar por nombre de producto, repuesto o código...">
                        
                        @if(strlen($search) > 0)
                            <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            {{ strlen($search) >= 1 ? 'Resultados para "' . $search . '"' : 'Catálogo de Inventario' }}
                        </h3>
                        <span class="text-[10px] font-bold text-slate-500 bg-slate-100 dark:bg-slate-700 px-2.5 py-1 rounded-xl">
                            {{ count($foundProducts) }} productos
                        </span>
                    </div>

                    @if(count($foundProducts) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3.5 overflow-y-auto max-h-[580px] theme-scrollbar pr-1">
                            @foreach($foundProducts as $product)
                                <div wire:click="addToCart({{ $product['id'] }})" 
                                    class="p-4 rounded-2xl text-left transition-all duration-200 group flex flex-col justify-between h-full cursor-pointer bg-slate-50 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700/80 hover:border-orange-500/50 hover:shadow-md hover:-translate-y-0.5">
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[10px] font-bold text-orange-600 dark:text-orange-300 uppercase tracking-wider bg-orange-500/10 border border-orange-500/20 px-2 py-0.5 rounded-md">
                                                {{ $product['category'] ?? 'General' }}
                                            </span>
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md border {{ $product['stock'] > 5 ? 'text-emerald-700 bg-emerald-50 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300' : 'text-amber-700 bg-amber-50 border-amber-200 dark:bg-amber-950/40 dark:text-amber-300' }}">
                                                Stock: {{ $product['stock'] }}
                                            </span>
                                        </div>
                                        <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-orange-600 transition line-clamp-2 leading-snug">
                                            {{ $product['name'] }}
                                        </h4>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-200/60 dark:border-slate-800 flex justify-between items-center">
                                        <span class="text-slate-900 dark:text-white font-black text-base">
                                            ${{ number_format($product['sale_price'], 0, ',', '.') }}
                                        </span>
                                        <span class="text-[11px] font-bold text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 px-3 py-1.5 rounded-xl shadow-sm transition flex items-center gap-1">
                                            + Añadir
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 opacity-60">
                            <svg class="w-12 h-12 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-slate-500 font-medium text-xs">No se encontraron productos con stock para "{{ $search }}".</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT COLUMN: Cart & Checkout -->
            <div class="lg:col-span-5 xl:col-span-4 flex flex-col gap-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-md overflow-hidden flex flex-col h-full">
                    <!-- Cart Header -->
                    <div class="p-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50 dark:bg-slate-900/60">
                        <h2 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Carrito de Cobro
                        </h2>
                        <span class="bg-orange-500/10 text-orange-600 dark:bg-orange-500/20 dark:text-orange-300 text-[11px] font-bold px-2.5 py-1 rounded-xl border border-orange-500/20">
                            {{ count($cart) }} {{ count($cart) === 1 ? 'Ítem' : 'Ítems' }}
                        </span>
                    </div>

                    <!-- Cart Items List -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-3 theme-scrollbar max-h-[380px]">
                        @forelse($cart as $index => $item)
                            <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700 space-y-2.5">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="flex-1">
                                        @if(!empty($item['is_ot']))
                                            <span class="inline-block text-[9px] font-bold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-950/50 border border-blue-200 dark:border-blue-800 px-2 py-0.5 rounded-md uppercase tracking-wider mb-1">
                                                🛠️ ORDEN DE TRABAJO
                                            </span>
                                        @endif
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white leading-snug">
                                            {{ $item['name'] }}
                                        </h4>
                                    </div>

                                    <button wire:click="removeFromCart({{ $index }})" class="text-slate-400 hover:text-red-500 transition cursor-pointer p-1" title="Eliminar ítem">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>

                                @if(!empty($item['is_ot']))
                                    <div class="space-y-1 pt-1 border-t border-slate-200 dark:border-slate-800">
                                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Monto a Abonar / Cobrar ($):</label>
                                        <div class="relative w-full">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-orange-600 font-bold text-xs">$</span>
                                            <input wire:model.live.debounce.300ms="cart.{{ $index }}.price" type="number" step="1" min="1" max="{{ $item['price'] }}" 
                                                class="w-full text-slate-900 dark:text-white text-sm font-bold rounded-xl py-2 pl-7 pr-3 focus:ring-2 focus:ring-orange-500 bg-white dark:bg-slate-800 border border-orange-500/40 outline-none">
                                        </div>
                                    </div>
                                @else
                                    <div class="flex justify-between items-center pt-2 border-t border-slate-200/60 dark:border-slate-800">
                                        <div class="text-slate-900 dark:text-white font-bold text-xs">
                                            ${{ number_format($item['price'], 0, ',', '.') }} <span class="text-[10px] text-slate-400 font-normal">c/u</span>
                                        </div>
                                        <div class="flex items-center rounded-xl p-0.5 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                                            <button wire:click="updateQuantity({{ $index }}, 'decrease')" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-500 transition cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                            </button>
                                            <span class="w-7 text-center text-xs font-bold text-slate-900 dark:text-white">{{ $item['quantity'] }}</span>
                                            <button wire:click="updateQuantity({{ $index }}, 'increase')" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-500 transition cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-10 opacity-60 space-y-2">
                                <svg class="w-10 h-10 text-slate-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p class="text-xs text-slate-500 font-medium">El carrito está vacío</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Checkout Controls Section -->
                    <div class="p-4 border-t border-slate-100 dark:border-slate-700 space-y-4 bg-slate-50/50 dark:bg-slate-900/40">
                        <!-- 1. Tipo de Documento Cards -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">1. Tipo de Documento</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button type="button" wire:click="$set('documentType', 'ticket')" 
                                    class="py-2 px-2 rounded-xl text-xs font-bold text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $documentType === 'ticket' ? 'bg-orange-500/10 text-orange-600 border-orange-500 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:text-slate-900' }}">
                                    <span>📄 Ticket</span>
                                </button>
                                <button type="button" wire:click="$set('documentType', 'boleta')" 
                                    class="py-2 px-2 rounded-xl text-xs font-bold text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $documentType === 'boleta' ? 'bg-orange-500/10 text-orange-600 border-orange-500 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:text-slate-900' }}">
                                    <span>🧾 Boleta</span>
                                </button>
                                <button type="button" wire:click="$set('documentType', 'factura')" 
                                    class="py-2 px-2 rounded-xl text-xs font-bold text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $documentType === 'factura' ? 'bg-orange-500/10 text-orange-600 border-orange-500 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:text-slate-900' }}">
                                    <span>🏢 Factura</span>
                                </button>
                            </div>
                        </div>

                        <!-- 2. Método de Pago Pills -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">2. Método de Pago</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button type="button" wire:click="$set('paymentMethod', 'Efectivo')" 
                                    class="py-2 px-1.5 rounded-xl text-xs font-bold text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $paymentMethod === 'Efectivo' ? 'bg-emerald-50 text-emerald-700 border-emerald-400 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:text-slate-900' }}">
                                    <span>💵 Efectivo</span>
                                </button>
                                <button type="button" wire:click="$set('paymentMethod', 'Transferencia')" 
                                    class="py-2 px-1.5 rounded-xl text-xs font-bold text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $paymentMethod === 'Transferencia' ? 'bg-blue-50 text-blue-700 border-blue-400 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:text-slate-900' }}">
                                    <span>🏦 Transfer.</span>
                                </button>
                                <button type="button" wire:click="$set('paymentMethod', 'Tarjeta')" 
                                    class="py-2 px-1.5 rounded-xl text-xs font-bold text-center border transition flex items-center justify-center gap-1 cursor-pointer
                                        {{ $paymentMethod === 'Tarjeta' ? 'bg-purple-50 text-purple-700 border-purple-400 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:text-slate-900' }}">
                                    <span>💳 Tarjeta</span>
                                </button>
                            </div>
                        </div>

                        <!-- 3. Cliente Segmented Selector -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">3. Datos del Cliente</label>
                            <div class="grid grid-cols-3 gap-1.5 p-1 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 mb-2.5">
                                <button type="button" wire:click="$set('clientMode', 'generic')" 
                                    class="text-[10px] font-bold uppercase py-1.5 px-1 rounded-lg transition cursor-pointer
                                        {{ $clientMode === 'generic' ? 'bg-orange-600 text-white font-black' : 'text-slate-500 hover:text-slate-900' }}">
                                    Genérico
                                </button>
                                <button type="button" wire:click="$set('clientMode', 'registered')" 
                                    class="text-[10px] font-bold uppercase py-1.5 px-1 rounded-lg transition cursor-pointer
                                        {{ $clientMode === 'registered' ? 'bg-orange-600 text-white font-black' : 'text-slate-500 hover:text-slate-900' }}">
                                    Buscar
                                </button>
                                <button type="button" wire:click="$set('clientMode', 'new')" 
                                    class="text-[10px] font-bold uppercase py-1.5 px-1 rounded-lg transition cursor-pointer
                                        {{ $clientMode === 'new' ? 'bg-orange-600 text-white font-black' : 'text-slate-500 hover:text-slate-900' }}">
                                    Nuevo
                                </button>
                            </div>

                            @if($clientMode === 'generic')
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input wire:model="clientName" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-xl p-2.5 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Nombre (Opcional)">
                                    </div>
                                    <div>
                                        <input wire:model="clientPhone" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-xl p-2.5 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Teléfono (Opcional)">
                                    </div>
                                </div>
                            @elseif($clientMode === 'registered')
                                <div class="space-y-2">
                                    @if(!$selectedClientId)
                                        <div class="relative">
                                            <input wire:model.live.debounce.150ms="searchClient" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-xl p-2.5 pl-8 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Buscar por Nombre, RUT o Teléfono...">
                                            <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                            </div>
                                        </div>
                                        @if(count($foundClients) > 0)
                                            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden max-h-32 overflow-y-auto theme-scrollbar shadow-lg">
                                                @foreach($foundClients as $fclient)
                                                    <div wire:click="selectClient({{ $fclient['id'] }})" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer border-b border-slate-100 dark:border-slate-800 last:border-0">
                                                        <div class="text-xs font-bold text-slate-900 dark:text-white">{{ $fclient['full_name'] }}</div>
                                                        <div class="text-[10px] text-slate-500">{{ $fclient['rut_dni'] ?? 'Sin RUT' }} | {{ $fclient['phone'] }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        <div class="p-3 rounded-xl flex justify-between items-center border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-200">
                                            <div>
                                                <div class="text-[9px] font-bold uppercase tracking-widest mb-0.5">Cliente Seleccionado</div>
                                                <div class="text-xs font-bold">{{ $clientName }}</div>
                                                <div class="text-[10px] text-slate-500">{{ $clientRut ?? 'Sin RUT' }} | {{ $clientPhone }}</div>
                                            </div>
                                            <button wire:click="$set('selectedClientId', null)" class="text-slate-400 hover:text-red-500 transition cursor-pointer p-1" title="Cambiar Cliente">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @elseif($clientMode === 'new')
                                <div class="grid grid-cols-2 gap-2">
                                    <div><input wire:model="clientName" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-xl p-2 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Nombre *"></div>
                                    <div><input wire:model="clientPhone" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-xl p-2 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Teléfono *"></div>
                                    <div><input wire:model="clientRut" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-xl p-2 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="RUT (Opc.)"></div>
                                    <div><input wire:model="clientEmail" type="email" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-xl p-2 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Email (Opc.)"></div>
                                </div>
                            @endif

                            @if($documentType === 'factura')
                                <div class="mt-3 p-3 rounded-xl border border-orange-200 bg-orange-50/50 dark:bg-orange-950/20 space-y-2">
                                    <h4 class="text-[10px] font-bold text-orange-600 dark:text-orange-300 uppercase tracking-widest">Datos Facturación SII</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input wire:model="clientRut" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-lg p-2" placeholder="RUT Empresa *">
                                        <input wire:model="clientName" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-lg p-2" placeholder="Razón Social *">
                                    </div>
                                    <input wire:model="clientGiro" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-lg p-2" placeholder="Giro Comercial *">
                                    <div class="grid grid-cols-2 gap-2">
                                        <input wire:model="clientAddress" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-lg p-2" placeholder="Dirección *">
                                        <input wire:model="clientCity" type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-lg p-2" placeholder="Comuna *">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Totals Breakdown -->
                        <div class="space-y-1.5 pt-3 border-t border-slate-200/80 dark:border-slate-700">
                            <div class="flex justify-between text-xs text-slate-500 font-semibold">
                                <span>Subtotal (Neto)</span>
                                <span>${{ number_format($this->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-xs text-slate-500 font-semibold">
                                <span>IVA ({{ $taxRate }}%)</span>
                                <span>${{ number_format($this->taxAmount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-lg text-slate-900 dark:text-white font-black pt-2 border-t border-slate-200 dark:border-slate-700 mt-2">
                                <span>TOTAL</span>
                                <span class="text-orange-600 font-black">${{ number_format($this->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Process Sale Button -->
                        <button wire:click="processSale" wire:loading.attr="disabled" 
                            class="w-full bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-black text-sm py-4 px-4 rounded-2xl shadow-lg shadow-orange-500/25 transition-all duration-200 flex justify-center items-center gap-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed active:scale-[0.99]">
                            <span wire:loading.remove wire:target="processSale" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                COMPLETAR COBRO (${{ number_format($this->total, 0, ',', '.') }})
                            </span>
                            <span wire:loading wire:target="processSale" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Procesando Cobro...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ═══ RECEIPT MODAL ═══ --}}
    @if($showReceiptModal && $completedSale)
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl w-full max-w-md overflow-hidden shadow-2xl animate-fade-in flex flex-col">
                <div class="p-6 text-center border-b border-slate-100 dark:border-slate-700 bg-emerald-50 dark:bg-emerald-950/20">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 border border-emerald-200 font-bold"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white">¡Venta Exitosa!</h3>
                    <p class="text-xs text-slate-500 mt-1 font-medium">El pago fue registrado correctamente y la caja actualizada.</p>
                </div>
                <div class="p-6 flex flex-col gap-4">
                    <button onclick="window.printContent('pos-thermal-receipt', 'pos-canvas')" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-4 rounded-xl transition-all flex justify-center items-center gap-2 cursor-pointer shadow-md">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Imprimir Ticket Térmico
                    </button>
                    <button wire:click="$set('showReceiptModal', false)" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 px-4 rounded-xl transition-all cursor-pointer">Cerrar y Nueva Venta</button>
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
