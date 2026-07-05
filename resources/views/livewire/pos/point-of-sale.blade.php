<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto min-h-screen flex flex-col" x-data="{ posTab: @entangle('posTab') }">

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
                    <p class="text-sm text-gray-400 mt-1">Gestión completa de ventas, caja y movimientos.</p>
                </div>
                <button wire:click="$set('showOpenModal', true)" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold px-5 py-3 rounded-2xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition duration-200 self-start sm:self-center cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Abrir Caja del Día
                </button>
            </div>

            <!-- Caja Cerrada Banner -->
            <div class="bg-gray-850 p-8 rounded-3xl border border-gray-800 shadow-xl text-center space-y-4">
                <div class="w-20 h-20 bg-gray-900 rounded-full mx-auto flex items-center justify-center border border-gray-700">
                    <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h2 class="text-xl font-bold text-white">La caja está cerrada</h2>
                <p class="text-gray-400 max-w-md mx-auto">Para poder vender, registrar pagos o ingresar equipos con abonos, debes realizar la apertura de caja indicando el monto inicial (base).</p>
            </div>

            <!-- Historial de Cajas Cerradas -->
            @if($recentRegisters && $recentRegisters->count() > 0)
            <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden">
                <div class="p-5 border-b border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h3 class="text-lg font-bold text-white">Historial de Cajas</h3>
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
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Apertura</th>
                                <th class="px-6 py-4">Cierre</th>
                                <th class="px-6 py-4 text-right">Monto Final</th>
                                <th class="px-6 py-4">Responsable</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/60">
                            @foreach($recentRegisters as $reg)
                            <tr class="hover:bg-gray-900/20 transition">
                                <td class="px-6 py-4 text-xs font-bold text-gray-300">#{{ $reg->id }}</td>
                                <td class="px-6 py-4 text-xs text-gray-400">{{ $reg->opened_at ? $reg->opened_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td class="px-6 py-4 text-xs font-medium text-white">
                                    {{ $reg->closed_at ? $reg->closed_at->format('d/m/Y H:i') : 'N/A' }}
                                    <span class="ml-2 px-2 py-0.5 bg-red-950/50 text-red-400 text-[9px] font-black rounded border border-red-500/20 uppercase">Cerrada</span>
                                </td>
                                <td class="px-6 py-4 text-right font-black text-white">${{ number_format($reg->closing_balance, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-xs text-gray-400">{{ $reg->user->name }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="/caja/{{ $reg->id }}/print" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 text-xs font-bold rounded-lg border border-blue-500/20 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        Imprimir
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- MOBILE CARDS -->
                <div class="md:hidden flex flex-col gap-3 p-4">
                    @foreach($recentRegisters as $reg)
                        <div class="bg-gray-800/50 border border-gray-700/60 rounded-2xl p-4 flex flex-col gap-3">
                            <div class="flex justify-between items-center border-b border-gray-700/50 pb-2">
                                <span class="text-xs font-bold text-gray-300">Caja #{{ $reg->id }}</span>
                                <span class="px-2 py-0.5 bg-red-950/50 text-red-400 text-[9px] font-black rounded border border-red-500/20 uppercase">Cerrada</span>
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
                                    <span class="font-black text-white">${{ number_format($reg->closing_balance, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] text-gray-500 uppercase">Responsable</span>
                                    <span class="text-gray-400">{{ $reg->user->name }}</span>
                                </div>
                            </div>
                            <div class="pt-2">
                                <a href="/caja/{{ $reg->id }}/print" target="_blank" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 text-xs font-bold rounded-xl border border-blue-500/20 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Imprimir
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($recentRegisters->hasPages())
                    <div class="p-4 border-t border-gray-800 bg-gray-900/30">
                        {{ $recentRegisters->links() }}
                    </div>
                @endif
            </div>
            @endif
        </div>

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{-- ESTADO 2: CAJA ABIERTA → POS COMPLETO                      --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    @else
        <!-- Header + Register Status Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Punto de Venta</h1>
                <p class="text-sm text-gray-400 mt-1">Gestión completa de ventas, caja y movimientos.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-emerald-950/50 border border-emerald-500/30 text-emerald-400 px-4 py-2.5 rounded-2xl flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-sm font-bold">Caja Abierta</span>
                </div>
                <button wire:click="$set('showCloseModal', true)" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-500 text-white text-sm font-bold px-4 py-2.5 rounded-2xl shadow-lg shadow-red-500/20 hover:shadow-red-500/40 transition duration-200 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Cerrar Caja
                </button>
            </div>
        </div>

        <!-- Register Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
            <div class="bg-gray-850 p-4 rounded-2xl border border-gray-800">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Base Inicial</p>
                <p class="text-lg font-black text-white">${{ number_format($activeRegister->opening_balance, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-850 p-4 rounded-2xl border border-gray-800">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Ingresos</p>
                <p class="text-lg font-black text-emerald-400">+${{ number_format($activeRegister->payments()->where('type', 'income')->sum('amount'), 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-850 p-4 rounded-2xl border border-gray-800">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Egresos</p>
                <p class="text-lg font-black text-red-400">-${{ number_format($activeRegister->payments()->where('type', 'expense')->sum('amount'), 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-850 p-4 rounded-2xl border border-gray-800 border-b-4 border-b-blue-500">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Total Caja</p>
                <p class="text-lg font-black text-white">${{ number_format($expected_closing_balance, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex gap-2 bg-gray-950 p-1.5 rounded-2xl border border-gray-800 mb-5 w-fit">
            <button @click="posTab = 'sell'; $wire.switchPosTab('sell')" :class="posTab === 'sell' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition duration-200 cursor-pointer flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Vender
            </button>
            <button @click="posTab = 'movements'; $wire.switchPosTab('movements')" :class="posTab === 'movements' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition duration-200 cursor-pointer flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Movimientos
            </button>
            <button @click="posTab = 'history'; $wire.switchPosTab('history')" :class="posTab === 'history' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition duration-200 cursor-pointer flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Historial
            </button>
        </div>

        {{-- ═══ TAB: VENDER ═══ --}}
        <div x-show="posTab === 'sell'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
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
                                        <div class="text-orange-400 font-bold text-sm mt-1">${{ number_format($item['price'], 0, ',', '.') }} c/u</div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <button wire:click="removeFromCart({{ $index }})" class="text-gray-600 hover:text-red-400 transition cursor-pointer" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                        <div class="flex items-center bg-gray-800 rounded-lg p-0.5 border border-gray-700">
                                            <button wire:click="updateQuantity({{ $index }}, 'decrease')" class="p-1 hover:bg-gray-700 rounded-md text-gray-400 hover:text-white transition cursor-pointer"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg></button>
                                            <span class="w-8 text-center text-xs font-bold text-white">{{ $item['quantity'] }}</span>
                                            <button wire:click="updateQuantity({{ $index }}, 'increase')" class="p-1 hover:bg-gray-700 rounded-md text-gray-400 hover:text-white transition cursor-pointer"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></button>
                                        </div>
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

        {{-- ═══ TAB: MOVIMIENTOS DE HOY ═══ --}}
        <div x-show="posTab === 'movements'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak>
            <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden">
                <div class="p-5 border-b border-gray-800">
                    <h3 class="text-lg font-bold text-white">Movimientos de Hoy</h3>
                    <p class="text-xs text-gray-500 mt-1">Apertura: {{ $activeRegister->opened_at->format('H:i') }} por {{ $activeRegister->user->name }}</p>
                </div>
                <!-- DESKTOP TABLE -->
                <div class="hidden md:block overflow-x-auto theme-scrollbar">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-900/40 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                                <th class="px-6 py-4">Hora</th>
                                <th class="px-6 py-4">Tipo</th>
                                <th class="px-6 py-4">Descripción</th>
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
                                    <td class="px-6 py-4 text-xs text-gray-300">{{ $payment->payment_method }}</td>
                                    <td class="px-6 py-4 text-xs text-gray-400">{{ $payment->user->name }}</td>
                                    <td class="px-6 py-4 text-right font-bold {{ $payment->type === 'income' ? 'text-emerald-400' : 'text-red-400' }}">
                                        {{ $payment->type === 'income' ? '+' : '-' }}${{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No hay movimientos registrados hoy.</td></tr>
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
                                    <span class="block text-[10px] text-gray-500 uppercase">Método</span>
                                    <span class="text-xs text-gray-300">{{ $payment->payment_method }}</span>
                                </div>
                                <div>
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
        </div>

        {{-- ═══ TAB: HISTORIAL DE VENTAS ═══ --}}
        <div x-show="posTab === 'history'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak>
            <div class="space-y-6">
                <div class="bg-gray-850 p-4 rounded-3xl border border-gray-800 shadow-xl flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Buscar</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></span>
                            <input wire:model.live.debounce.300ms="searchSales" type="text" placeholder="Cliente, Usuario, Código..." class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 pl-10 pr-4 text-white text-sm focus:outline-none focus:border-orange-500 transition">
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

                <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden">
                    <!-- DESKTOP TABLE -->
                    <div class="hidden md:block overflow-x-auto theme-scrollbar">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-900/40 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                                    <th class="px-6 py-4">Fecha</th>
                                    <th class="px-6 py-4">Código</th>
                                    <th class="px-6 py-4">Cliente</th>
                                    <th class="px-6 py-4">Artículos</th>
                                    <th class="px-6 py-4">Método</th>
                                    <th class="px-6 py-4">Usuario</th>
                                    <th class="px-6 py-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800/60">
                                @forelse($sales as $sale)
                                    <tr class="hover:bg-gray-900/20 transition">
                                        <td class="px-6 py-4 text-xs text-gray-400">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4"><span class="font-mono text-xs font-bold text-orange-400">#{{ substr($sale->uuid, 0, 8) }}</span></td>
                                        <td class="px-6 py-4 text-white font-medium">{{ $sale->client_name }}@if($sale->client_phone)<span class="block text-[10px] text-gray-500">{{ $sale->client_phone }}</span>@endif</td>
                                        <td class="px-6 py-4"><div class="flex flex-col gap-1">@foreach($sale->items as $item)<span class="text-[11px] text-gray-400">{{ $item->quantity }}x {{ $item->name }}</span>@endforeach</div></td>
                                        <td class="px-6 py-4 text-xs text-gray-300">{{ $sale->payment_method }}</td>
                                        <td class="px-6 py-4 text-xs text-gray-400">{{ $sale->user ? $sale->user->name : 'N/A' }}</td>
                                        <td class="px-6 py-4 text-right font-black text-white">${{ number_format($sale->total, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No se encontraron ventas con los filtros actuales.</td></tr>
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
                                        <span class="block text-[10px] text-gray-500 uppercase">Método</span>
                                        <span class="text-xs text-gray-300">{{ $sale->payment_method }}</span>
                                    </div>
                                    <div>
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
                        <div class="px-6 py-4 border-t border-gray-800">{{ $sales->links(data: ['scrollTo' => false]) }}</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ═══ MODAL: CERRAR CAJA ═══ --}}
        @if($showCloseModal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/80 backdrop-blur-sm animate-fade-in">
            <div class="bg-gray-850 rounded-3xl max-w-md w-full border border-gray-700 shadow-2xl p-6 relative">
                <button wire:click="$set('showCloseModal', false)" class="absolute top-4 right-4 text-gray-500 hover:text-white cursor-pointer"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                <h3 class="text-xl font-black text-white mb-2">Cierre de Caja</h3>
                <p class="text-xs text-gray-400 mb-6">Realiza el cuadre final ingresando el monto real contabilizado.</p>
                <div class="bg-blue-950/30 border border-blue-500/20 p-4 rounded-xl mb-6 flex justify-between items-center">
                    <span class="text-sm font-semibold text-blue-300">Esperado en sistema:</span>
                    <span class="text-lg font-black text-white">${{ number_format($expected_closing_balance, 0, ',', '.') }}</span>
                </div>
                <form wire:submit="closeRegister" class="space-y-4">
                    <div><label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Efectivo Físico</label><div class="relative"><span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">$</span><input wire:model="closing_cash" type="number" step="0.01" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-3 pl-8 pr-4 text-white font-bold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/50 transition"></div><p class="text-[10px] text-gray-500 mt-1">Esperado: ${{ number_format($expected_cash, 0, ',', '.') }}</p>@error('closing_cash') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror</div>
                    <div><label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Total Transferencias</label><div class="relative"><span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">$</span><input wire:model="closing_transfer" type="number" step="0.01" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-3 pl-8 pr-4 text-white font-bold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/50 transition"></div><p class="text-[10px] text-gray-500 mt-1">Esperado: ${{ number_format($expected_transfer, 0, ',', '.') }}</p>@error('closing_transfer') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror</div>
                    <div><label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Total Tarjetas (Transbank)</label><div class="relative"><span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">$</span><input wire:model="closing_card" type="number" step="0.01" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-3 pl-8 pr-4 text-white font-bold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/50 transition"></div><p class="text-[10px] text-gray-500 mt-1">Esperado: ${{ number_format($expected_card, 0, ',', '.') }}</p>@error('closing_card') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror</div>
                    <div><label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Notas / Diferencias</label><textarea wire:model="closing_notes" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl p-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition" placeholder="Explica si hay descuadres..."></textarea></div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-500 text-white font-black py-4 px-6 rounded-2xl text-sm shadow-lg shadow-red-500/20 transition duration-200 cursor-pointer mt-2">CONFIRMAR CIERRE DE CAJA</button>
                </form>
            </div>
        </div>
        @endif
    @endif

    {{-- ═══ MODAL: ABRIR CAJA ═══ --}}
    @if($showOpenModal)
    <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/80 backdrop-blur-sm animate-fade-in">
        <div class="bg-gray-850 rounded-3xl max-w-sm w-full border border-gray-700 shadow-2xl p-6 relative">
            <button wire:click="$set('showOpenModal', false)" class="absolute top-4 right-4 text-gray-500 hover:text-white cursor-pointer"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            <div class="w-12 h-12 bg-emerald-500/10 rounded-full flex items-center justify-center text-emerald-400 mb-4 border border-emerald-500/20"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></div>
            <h3 class="text-xl font-black text-white mb-2">Abrir Caja</h3>
            <p class="text-xs text-gray-400 mb-6">Ingresa el monto base (sencillo) con el que inicia el turno.</p>
            <form wire:submit="openRegister" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Monto Inicial (Base)</label>
                    <div class="relative"><span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">$</span><input wire:model="opening_balance" type="number" step="0.01" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-3 pl-8 pr-4 text-white font-bold focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/50 transition"></div>
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
