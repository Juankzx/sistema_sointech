<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto min-h-screen flex flex-col">

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 bg-emerald-950/40 border border-emerald-500/20 text-emerald-400 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 animate-fade-in">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 bg-red-950/40 border border-red-500/20 text-red-400 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 animate-fade-in">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Punto de Venta</h1>
                    <p class="text-sm text-gray-400 mt-1">Gestión completa de ventas y cobros.</p>
                </div>
            </div>

            <!-- Caja Cerrada Banner -->
            <div class="bg-gray-850 p-8 rounded-3xl border border-gray-800 shadow-xl text-center space-y-4">
                <div class="w-20 h-20 bg-gray-900 rounded-full mx-auto flex items-center justify-center border border-gray-700">
                    <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h2 class="text-xl font-bold text-white">La caja está cerrada</h2>
                <p class="text-gray-400 max-w-md mx-auto">Para poder vender o registrar pagos, debes dirigirte al módulo de Caja y realizar la apertura.</p>
                <a href="/caja" class="inline-block bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 px-6 rounded-xl transition mt-4">
                    Ir al Módulo de Caja
                </a>
            </div>
        </div>

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{-- ESTADO 2: CAJA ABIERTA → POS COMPLETO                      --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    @else
        <!-- Header + Register Status Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Punto de Venta</h1>
                <p class="text-sm text-gray-400 mt-1">Ventas y cobranzas rápidas.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-emerald-950/50 border border-emerald-500/30 text-emerald-400 px-4 py-2.5 rounded-2xl flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-sm font-bold">Caja Abierta</span>
                </div>
            </div>
        </div>

        {{-- ═══ VENDER ═══ --}}
        <div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 flex-1">
                <!-- LEFT COLUMN: Search and Products -->
                <div class="lg:col-span-8 flex flex-col gap-6">
                    <div class="bg-gray-850 p-5 rounded-3xl border border-gray-800 shadow-xl shadow-black/20">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text" class="w-full bg-gray-900 border border-gray-700 text-white text-lg rounded-2xl focus:ring-orange-500 focus:border-orange-500 block pl-12 p-4 transition-colors placeholder-gray-500" placeholder="Buscar por código, nombre o categoría...">
                        </div>
                    </div>

                    @if(strlen($search) > 2)
                        <div class="bg-gray-850 p-5 rounded-3xl border border-gray-800 shadow-xl flex-1">
                            <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-4">Resultados de Búsqueda</h3>
                            @if(count($foundProducts) > 0)
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($foundProducts as $product)
                                        <button wire:click="addToCart({{ $product['id'] }})" class="bg-gray-900/50 hover:bg-gray-800 border border-gray-700/60 hover:border-orange-500/50 rounded-2xl p-4 text-left transition-all group flex flex-col justify-between h-full cursor-pointer">
                                            <div>
                                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 block">{{ $product['category'] ?? 'General' }}</span>
                                                <h4 class="text-sm font-semibold text-gray-200 group-hover:text-white line-clamp-2 leading-tight">{{ $product['name'] }}</h4>
                                            </div>
                                            <div class="mt-4 flex justify-between items-end">
                                                <span class="text-orange-400 font-black text-lg">${{ number_format($product['sale_price'], 0, ',', '.') }}</span>
                                                <span class="text-xs font-medium {{ $product['stock'] > 5 ? 'text-emerald-500' : 'text-red-400' }}">Stock: {{ $product['stock'] }}</span>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10">
                                    <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-gray-400 font-medium text-sm">No se encontraron productos con stock para "{{ $search }}".</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-gray-850 p-10 rounded-3xl border border-gray-800 shadow-xl flex-1 flex flex-col items-center justify-center text-center opacity-50">
                            <div class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center mb-4 border border-gray-700">
                                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-300">Busca un producto</h3>
                            <p class="text-sm text-gray-500 max-w-sm mt-2">Utiliza la barra superior para buscar los repuestos o accesorios que deseas vender y añádelos al carrito.</p>
                        </div>
                    @endif
                </div>

                <!-- RIGHT COLUMN: Cart & Checkout -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-xl shadow-black/20 overflow-hidden flex flex-col h-full">
                        <div class="p-5 border-b border-gray-800 bg-gray-900/50 flex justify-between items-center">
                            <h2 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Carrito
                            </h2>
                            <span class="bg-orange-500/20 text-orange-400 text-xs font-bold px-2 py-1 rounded-lg border border-orange-500/20">{{ count($cart) }} Ítems</span>
                        </div>

                        <div class="flex-1 overflow-y-auto p-5 space-y-4 theme-scrollbar bg-gray-850">
                            @forelse($cart as $index => $item)
                                <div class="flex items-start justify-between group bg-gray-900/50 p-3 rounded-2xl border border-gray-800 hover:border-gray-700 transition">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-200 leading-tight pr-4">{{ $item['name'] }}</h4>
                                        @if(!empty($item['is_ot']))
                                            <div class="mt-2 flex items-center gap-2">
                                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Abonar:</span>
                                                <div class="relative w-32">
                                                    <span class="absolute inset-y-0 left-0 pl-2 flex items-center text-gray-500 font-bold text-xs">$</span>
                                                    <input wire:model.live.debounce.500ms="cart.{{ $index }}.price" type="number" step="1" min="1" max="{{ $item['price'] }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg py-1 pl-6 pr-2 text-orange-400 text-sm font-bold focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/50 transition">
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-orange-400 font-bold text-sm mt-1">${{ number_format($item['price'], 0, ',', '.') }} c/u</div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <button wire:click="removeFromCart({{ $index }})" class="text-gray-600 hover:text-red-400 transition cursor-pointer" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                        @if(empty($item['is_ot']))
                                        <div class="flex items-center bg-gray-800 rounded-lg p-0.5 border border-gray-700">
                                            <button wire:click="updateQuantity({{ $index }}, 'decrease')" class="p-1 hover:bg-gray-700 rounded-md text-gray-400 hover:text-white transition cursor-pointer"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg></button>
                                            <span class="w-8 text-center text-xs font-bold text-white">{{ $item['quantity'] }}</span>
                                            <button wire:click="updateQuantity({{ $index }}, 'increase')" class="p-1 hover:bg-gray-700 rounded-md text-gray-400 hover:text-white transition cursor-pointer"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></button>
                                        </div>
                                        @else
                                        <div class="flex items-center bg-gray-800/50 rounded-lg p-1 px-3 border border-gray-700/50">
                                            <span class="text-xs font-bold text-gray-400">Cant: 1</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 opacity-50">
                                    <svg class="w-10 h-10 text-gray-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <p class="text-xs text-gray-400 font-medium">No hay productos en el carrito</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Checkout Section -->
                        <div class="p-5 border-t border-gray-800 bg-gray-900">
                            <div class="space-y-4 mb-5">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Tipo de Documento</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <label class="cursor-pointer"><input type="radio" wire:model.live="documentType" value="ticket" class="peer sr-only"><div class="text-center bg-gray-800 border border-gray-700 text-gray-400 text-xs py-2 px-1 rounded-xl peer-checked:bg-orange-500/20 peer-checked:border-orange-500 peer-checked:text-orange-400 transition">Ticket Int.</div></label>
                                        <label class="cursor-pointer"><input type="radio" wire:model.live="documentType" value="boleta" class="peer sr-only"><div class="text-center bg-gray-800 border border-gray-700 text-gray-400 text-xs py-2 px-1 rounded-xl peer-checked:bg-orange-500/20 peer-checked:border-orange-500 peer-checked:text-orange-400 transition">Boleta Elect.</div></label>
                                        <label class="cursor-pointer"><input type="radio" wire:model.live="documentType" value="factura" class="peer sr-only"><div class="text-center bg-gray-800 border border-gray-700 text-gray-400 text-xs py-2 px-1 rounded-xl peer-checked:bg-orange-500/20 peer-checked:border-orange-500 peer-checked:text-orange-400 transition">Factura</div></label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Método de Pago</label>
                                    <select wire:model="paymentMethod" class="w-full bg-gray-800 border border-gray-700 text-white text-xs rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-2.5 transition">
                                        <option value="Efectivo">💵 Efectivo</option>
                                        <option value="Tarjeta">💳 Tarjeta / Tbank</option>
                                        <option value="Transferencia">🏦 Transferencia</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="grid grid-cols-3 gap-2 p-1 bg-gray-800 rounded-xl border border-gray-700">
                                        <label class="cursor-pointer"><input type="radio" wire:model.live="clientMode" value="generic" class="peer sr-only"><div class="text-center text-[10px] font-bold text-gray-400 uppercase py-1.5 px-1 rounded-lg peer-checked:bg-gray-700 peer-checked:text-white transition">Genérico</div></label>
                                        <label class="cursor-pointer"><input type="radio" wire:model.live="clientMode" value="registered" class="peer sr-only"><div class="text-center text-[10px] font-bold text-gray-400 uppercase py-1.5 px-1 rounded-lg peer-checked:bg-gray-700 peer-checked:text-white transition">Registrado</div></label>
                                        <label class="cursor-pointer"><input type="radio" wire:model.live="clientMode" value="new" class="peer sr-only"><div class="text-center text-[10px] font-bold text-gray-400 uppercase py-1.5 px-1 rounded-lg peer-checked:bg-gray-700 peer-checked:text-white transition">Nuevo</div></label>
                                    </div>
                                </div>
                                @if($clientMode === 'generic')
                                    <div class="grid grid-cols-2 gap-3 mb-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Nombre (Opcional)</label>
                                            <input wire:model="clientName" type="text" class="w-full bg-gray-800 border border-gray-700 text-white text-xs rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-2.5 transition" placeholder="Cliente Genérico">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Teléfono (Opcional)</label>
                                            <input wire:model="clientPhone" type="text" class="w-full bg-gray-800 border border-gray-700 text-white text-xs rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-2.5 transition" placeholder="Ej: 912345678">
                                        </div>
                                    </div>
                                @elseif($clientMode === 'registered')
                                    <div class="mb-4 space-y-2">
                                        @if(!$selectedClientId)
                                            <div class="relative">
                                                <input wire:model.live.debounce.300ms="searchClient" type="text" class="w-full bg-gray-800 border border-gray-700 text-white text-xs rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-2.5 pl-8 transition" placeholder="Buscar por Nombre, RUT o Teléfono...">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="h-3.5 w-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
                                            </div>
                                            @if(count($foundClients) > 0)
                                                <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden mt-1 max-h-32 overflow-y-auto theme-scrollbar">
                                                    @foreach($foundClients as $fclient)
                                                        <div wire:click="selectClient({{ $fclient['id'] }})" class="p-2 hover:bg-gray-700 cursor-pointer border-b border-gray-700/50 last:border-0">
                                                            <div class="text-xs font-bold text-white">{{ $fclient['full_name'] }}</div>
                                                            <div class="text-[10px] text-gray-400">{{ $fclient['rut_dni'] ?? 'Sin RUT' }} | {{ $fclient['phone'] }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            <div class="bg-emerald-950/30 border border-emerald-500/30 rounded-xl p-3 flex justify-between items-center">
                                                <div>
                                                    <div class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-0.5">Cliente Seleccionado</div>
                                                    <div class="text-sm font-bold text-white">{{ $clientName }}</div>
                                                    <div class="text-[10px] text-gray-400">{{ $clientRut ?? 'Sin RUT' }} | {{ $clientPhone }}</div>
                                                </div>
                                                <button wire:click="$set('selectedClientId', null)" class="text-gray-500 hover:text-red-400 transition cursor-pointer" title="Cambiar Cliente"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                            </div>
                                        @endif
                                    </div>
                                @elseif($clientMode === 'new')
                                    <div class="grid grid-cols-2 gap-3 mb-4">
                                        <div><label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Nombre *</label><input wire:model="clientName" type="text" class="w-full bg-gray-800 border border-gray-700 text-white text-xs rounded-xl p-2.5" placeholder="Juan Pérez">@error('clientName') <span class="text-[9px] text-red-400">{{ $message }}</span> @enderror</div>
                                        <div><label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Teléfono *</label><input wire:model="clientPhone" type="text" class="w-full bg-gray-800 border border-gray-700 text-white text-xs rounded-xl p-2.5" placeholder="912345678">@error('clientPhone') <span class="text-[9px] text-red-400">{{ $message }}</span> @enderror</div>
                                        <div><label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">RUT (Opc.)</label><input wire:model="clientRut" type="text" class="w-full bg-gray-800 border border-gray-700 text-white text-xs rounded-xl p-2.5" placeholder="12.345.678-9"></div>
                                        <div><label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Email (Opc.)</label><input wire:model="clientEmail" type="email" class="w-full bg-gray-800 border border-gray-700 text-white text-xs rounded-xl p-2.5" placeholder="correo@ejemplo.com"></div>
                                    </div>
                                @endif

                                @if($documentType === 'factura')
                                    <div class="space-y-3 bg-gray-850 p-3 rounded-xl border border-orange-500/30">
                                        <h4 class="text-[10px] font-black text-orange-400 uppercase tracking-widest">Datos Facturación (SII)</h4>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div><label class="block text-[10px] font-bold text-gray-400 mb-1">RUT *</label><input wire:model="clientRut" type="text" class="w-full bg-gray-900 border border-gray-700 text-white text-xs rounded-lg p-2 focus:border-orange-500" placeholder="12.345.678-9">@error('clientRut') <span class="text-[9px] text-red-400">{{ $message }}</span> @enderror</div>
                                            <div><label class="block text-[10px] font-bold text-gray-400 mb-1">Razón Social *</label><input wire:model="clientName" type="text" class="w-full bg-gray-900 border border-gray-700 text-white text-xs rounded-lg p-2 focus:border-orange-500" placeholder="Nombre Empresa">@error('clientName') <span class="text-[9px] text-red-400">{{ $message }}</span> @enderror</div>
                                        </div>
                                        <div><label class="block text-[10px] font-bold text-gray-400 mb-1">Giro *</label><input wire:model="clientGiro" type="text" class="w-full bg-gray-900 border border-gray-700 text-white text-xs rounded-lg p-2 focus:border-orange-500" placeholder="Actividad económica">@error('clientGiro') <span class="text-[9px] text-red-400">{{ $message }}</span> @enderror</div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div><label class="block text-[10px] font-bold text-gray-400 mb-1">Dirección *</label><input wire:model="clientAddress" type="text" class="w-full bg-gray-900 border border-gray-700 text-white text-xs rounded-lg p-2 focus:border-orange-500" placeholder="Calle 123">@error('clientAddress') <span class="text-[9px] text-red-400">{{ $message }}</span> @enderror</div>
                                            <div><label class="block text-[10px] font-bold text-gray-400 mb-1">Comuna *</label><input wire:model="clientCity" type="text" class="w-full bg-gray-900 border border-gray-700 text-white text-xs rounded-lg p-2 focus:border-orange-500" placeholder="Comuna">@error('clientCity') <span class="text-[9px] text-red-400">{{ $message }}</span> @enderror</div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-2 mb-5">
                                <div class="flex justify-between text-xs text-gray-400 font-medium"><span>Subtotal (Neto)</span><span>${{ number_format($this->subtotal, 0, ',', '.') }}</span></div>
                                <div class="flex justify-between text-xs text-gray-400 font-medium"><span>IVA ({{ $taxRate }}%)</span><span>${{ number_format($this->taxAmount, 0, ',', '.') }}</span></div>
                                <div class="flex justify-between text-lg text-white font-black pt-2 border-t border-gray-800/50 mt-2"><span>TOTAL</span><span class="text-orange-400">${{ number_format($this->total, 0, ',', '.') }}</span></div>
                            </div>

                            <button wire:click="processSale" wire:loading.attr="disabled" class="w-full bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-black py-4 px-4 rounded-2xl shadow-lg shadow-orange-500/20 transition-all flex justify-center items-center gap-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="processSale">Cobrar e Imprimir ($ {{ number_format($this->total, 0, ',', '.') }})</span>
                                <span wire:loading wire:target="processSale" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Procesando...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ═══ RECEIPT MODAL ═══ --}}
    @if($showReceiptModal && $completedSale)
        <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-gray-900 border border-gray-800 rounded-3xl w-full max-w-md overflow-hidden shadow-2xl animate-fade-in flex flex-col">
                <div class="p-6 text-center border-b border-gray-800 bg-emerald-950/20">
                    <div class="w-16 h-16 bg-emerald-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-emerald-500/30 text-emerald-400"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                    <h3 class="text-xl font-black text-white">¡Venta Exitosa!</h3>
                    <p class="text-sm text-gray-400 mt-1">El stock ha sido descontado y la caja actualizada.</p>
                </div>
                <div class="p-6 flex flex-col gap-4">
                    <button onclick="window.printContent('pos-thermal-receipt', 'pos-canvas')" class="w-full bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white font-bold py-3 px-4 rounded-xl transition-all flex justify-center items-center gap-2 cursor-pointer shadow-md">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Imprimir Ticket Térmico
                    </button>
                    <button wire:click="$set('showReceiptModal', false)" class="w-full bg-transparent hover:bg-gray-800 text-gray-400 hover:text-white font-semibold py-3 px-4 rounded-xl transition-all cursor-pointer">Cerrar y Nueva Venta</button>
                </div>
                <!-- Hidden Thermal Template -->
                <div class="hidden">
                    <div id="pos-thermal-receipt" class="p-2 text-black bg-white flex flex-col items-center font-sans" style="font-family: 'Inter', sans-serif; width: 250px; text-align: center; margin: 0 auto; color: #000;">
                        @if($companySettings && $companySettings->logo_path)
                            <img src="{{ Storage::url($companySettings->logo_path) }}" alt="Logo" style="max-width: 150px; margin-bottom: 0.5rem; filter: grayscale(100%) contrast(1.2);">
                        @else
                            <div style="font-size: 1.5rem; font-weight: 900; line-height: 1; margin-bottom: 0.25rem; text-transform: uppercase;">{{ $companySettings->company_name ?? 'SOINTECH' }}</div>
                        @endif
                        <div style="font-size: 0.75rem; text-align: center; line-height: 1.2; margin-bottom: 0.5rem; width: 100%;">
                            @if($companySettings && $companySettings->company_rut)<p style="margin: 0;">RUT: {{ $companySettings->company_rut }}</p>@endif
                            @if($companySettings && $companySettings->company_address)<p style="margin: 0;">{{ $companySettings->company_address }}</p>@endif
                            @if($companySettings && $companySettings->company_phone)<p style="margin: 0;">Tel: {{ $companySettings->company_phone }}</p>@endif
                        </div>
                        <div style="font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; border-top: 1px dashed black; border-bottom: 1px dashed black; padding: 0.25rem 0; width: 100%;">BOLETA ELECTRÓNICA</div>
                        <div style="font-size: 0.75rem; text-align: left; width: 100%; margin-bottom: 0.5rem; line-height: 1.3;">
                            <p style="margin: 0;"><strong>Fecha:</strong> {{ $completedSale->created_at->format('d/m/Y H:i') }}</p>
                            <p style="margin: 0;"><strong>Venta ID:</strong> {{ substr($completedSale->uuid, 0, 8) }}</p>
                            <p style="margin: 0;"><strong>Cliente:</strong> {{ \Illuminate\Support\Str::limit($completedSale->client_name, 20) }}</p>
                            <p style="margin: 0;"><strong>Método Pago:</strong> {{ $completedSale->payment_method }}</p>
                        </div>
                        <div style="width: 100%; margin-bottom: 0.5rem;">
                            <table style="width: 100%; font-size: 0.75rem; text-align: left; border-collapse: collapse;">
                                <thead><tr style="border-bottom: 1px solid black;"><th style="padding-bottom: 2px;">CANT</th><th style="padding-bottom: 2px;">DESCRIPCIÓN</th><th style="padding-bottom: 2px; text-align: right;">TOTAL</th></tr></thead>
                                <tbody>
                                    @foreach($completedSale->items as $item)
                                    <tr><td style="padding: 2px 0; vertical-align: top;">{{ $item->quantity }}</td><td style="padding: 2px 2px; vertical-align: top; max-width: 100px; word-wrap: break-word;">{{ \Illuminate\Support\Str::limit($item->name, 25) }}<br><small style="font-size: 0.6rem;">${{ number_format($item->unit_price, 0, ',', '.') }}</small></td><td style="padding: 2px 0; text-align: right; vertical-align: top;">${{ number_format($item->subtotal, 0, ',', '.') }}</td></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="font-size: 0.75rem; text-align: left; width: 100%; border-top: 1px solid black; padding-top: 0.5rem; margin-bottom: 0.5rem; line-height: 1.3;">
                            <div style="display: flex; justify-content: space-between;"><span>Subtotal Neto:</span><span>${{ number_format($completedSale->subtotal, 0, ',', '.') }}</span></div>
                            <div style="display: flex; justify-content: space-between;"><span>IVA ({{ $completedSale->tax_rate }}%):</span><span>${{ number_format($completedSale->tax_amount, 0, ',', '.') }}</span></div>
                            <div style="display: flex; justify-content: space-between; margin-top: 0.25rem; font-size: 1rem; font-weight: 900;"><span>TOTAL:</span><span>${{ number_format($completedSale->total, 0, ',', '.') }}</span></div>
                        </div>
                        <div style="font-size: 0.65rem; text-align: center; margin-top: 0.5rem; width: 100%;"><p style="margin: 0; font-weight: bold;">¡Gracias por su compra!</p><p style="margin: 0; margin-top: 0.25rem;">Conserve su boleta para cambios o devoluciones.</p></div>
                    </div>
                </div>
            </div>
            <canvas id="pos-canvas" class="hidden"></canvas>
        </div>
    @endif

    <script>
        if (typeof window.printContent === 'undefined') {
            window.printContent = function(templateId, canvasId) {
                const element = document.getElementById(templateId);
                const printWindow = window.open('', '', 'width=800,height=600');
                printWindow.document.write('<html><head><title>Impresión de Ticket</title>');
                printWindow.document.write('<style>body { margin: 0; padding: 0; background: #fff; } @page { margin: 0; } </style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(element.innerHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();
                setTimeout(() => { printWindow.print(); printWindow.close(); }, 500);
            };
        }
    </script>
</div>
