<div class="px-2">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight flex items-center gap-3">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Compras y Gastos
            </h2>
            <p class="text-sm text-gray-400 mt-1 font-medium">Registra compras de inventario (repuestos) y gastos generales.</p>
        </div>
        
        <div class="flex items-center gap-3">
            @if(!$showForm)
            <div class="flex items-center gap-3 bg-gray-800/80 p-1.5 rounded-xl border border-gray-700/50">
                <select wire:model.live="currentMonth" class="bg-gray-900 border-none text-white text-sm font-semibold rounded-lg focus:ring-emerald-500 block py-2 px-3">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}">{{ \Carbon\Carbon::create(2000, $m, 1)->locale('es')->monthName }}</option>
                    @endfor
                </select>
                <select wire:model.live="currentYear" class="bg-gray-900 border-none text-white text-sm font-semibold rounded-lg focus:ring-emerald-500 block py-2 px-3">
                    @for($y=date('Y'); $y>=date('Y')-2; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            
            <button wire:click="createExpense" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Compra/Gasto
            </button>
            @endif
        </div>
    </div>

    @if(session()->has('error'))
        <div class="mb-4 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    @if($showForm)
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-lg shadow-black/20 mb-8 max-w-5xl mx-auto">
            <h3 class="text-lg font-black text-white tracking-tight mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                {{ $expenseId ? 'Editar Documento' : 'Nuevo Documento' }}
            </h3>
            
            <form wire:submit.prevent="saveExpense">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Fecha</label>
                        <input type="date" wire:model="date" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3 transition">
                        @error('date') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tipo de Documento</label>
                        <select wire:model.live="document_type" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3 transition">
                            <option value="factura">Factura de Compra</option>
                            <option value="boleta">Boleta</option>
                            <option value="recibo">Recibo / Vale</option>
                            <option value="otro">Otro</option>
                        </select>
                        @error('document_type') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">N° Documento / Folio</label>
                        <input type="text" wire:model="document_number" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3 transition" placeholder="Ej: 1542">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Proveedor</label>
                        @if($supplier_id)
                            <div class="flex items-center justify-between w-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm rounded-xl p-3">
                                <div class="font-bold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $supplier_name }}
                                </div>
                                <button type="button" wire:click="clearSupplier" class="text-emerald-500 hover:text-white transition-colors p-1 bg-emerald-500/20 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        @else
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="text" wire:model.live.debounce.300ms="searchSupplier" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block pl-10 p-3 transition" placeholder="Buscar proveedor por nombre o RUT...">
                            </div>
                            
                            @if(count($foundSuppliers) > 0)
                                <div class="absolute z-50 w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl shadow-xl overflow-hidden">
                                    <ul class="max-h-60 overflow-y-auto theme-scrollbar">
                                        @foreach($foundSuppliers as $supplier)
                                            <li>
                                                <button type="button" wire:click="selectSupplier({{ $supplier->id }})" class="w-full text-left px-4 py-3 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none transition-colors border-b border-gray-700/50 last:border-0">
                                                    <div class="text-sm font-bold text-white">{{ $supplier->name }}</div>
                                                    @if($supplier->rut)
                                                        <div class="text-[10px] text-gray-400">{{ $supplier->rut }}</div>
                                                    @endif
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Categoría Principal</label>
                        <select wire:model="category" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3 transition">
                            <option value="Inventario/Repuestos">Inventario / Repuestos</option>
                            <option value="General">General</option>
                            <option value="Arriendo">Arriendo</option>
                            <option value="Servicios Básicos">Servicios Básicos (Luz, Agua, Internet)</option>
                            <option value="Sueldos">Sueldos</option>
                            <option value="Marketing">Marketing / Publicidad</option>
                        </select>
                        @error('category') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Descripción General (Opcional)</label>
                    <input type="text" wire:model="description" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3 transition" placeholder="Ej: Compra de mercadería del mes">
                </div>

                <!-- Detalles de Productos (Inventario) -->
                <div class="bg-gray-900 p-4 rounded-xl border border-gray-700 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                        <div>
                            <h4 class="text-sm font-black text-white">Detalle de Productos (Inventario)</h4>
                            <p class="text-xs text-gray-400">Si agregas productos, el stock se actualizará automáticamente y los montos totales se calcularán en base a estos productos.</p>
                        </div>
                        
                        <!-- Buscador -->
                        <div class="relative w-full md:w-64">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="searchProduct" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block pl-10 p-2.5 transition" placeholder="Buscar repuesto para comprar...">
                            
                            @if(count($foundProducts) > 0)
                                <div class="absolute z-50 w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl shadow-xl overflow-hidden">
                                    <ul class="max-h-60 overflow-y-auto theme-scrollbar">
                                        @foreach($foundProducts as $product)
                                            <li>
                                                <button type="button" wire:click="addProductToCart({{ $product->id }})" class="w-full text-left px-4 py-3 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none transition-colors border-b border-gray-700/50 last:border-0 flex justify-between items-center group">
                                                    <div>
                                                        <div class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">{{ $product->name }}</div>
                                                        <div class="text-xs text-gray-500">Stock: <span class="{{ $product->stock <= $product->min_stock ? 'text-red-400' : 'text-emerald-400' }}">{{ $product->stock }}</span></div>
                                                    </div>
                                                    <svg class="w-4 h-4 text-gray-500 group-hover:text-emerald-400 opacity-0 group-hover:opacity-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(count($cart) > 0)
                        <div class="overflow-x-auto theme-scrollbar mb-4">
                            <table class="w-full text-left text-sm text-gray-300">
                                <thead class="bg-gray-800/50 border-b border-gray-700 text-[10px] uppercase text-gray-500 tracking-wider">
                                    <tr>
                                        <th class="px-4 py-3 font-black w-1/3">Producto</th>
                                        <th class="px-4 py-3 font-black text-center w-24">Cant.</th>
                                        <th class="px-4 py-3 font-black text-right w-32">Costo Unitario (Neto)</th>
                                        <th class="px-4 py-3 font-black text-right w-32">Subtotal (Neto)</th>
                                        <th class="px-4 py-3 font-black text-center w-12"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700/50">
                                    @foreach($cart as $index => $item)
                                        <tr class="hover:bg-gray-800/50 transition-colors">
                                            <td class="px-4 py-2 font-medium text-white">
                                                {{ $item['name'] }}
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="number" wire:model.live.debounce.500ms="cart.{{ $index }}.quantity" wire:change="updateCartItem({{ $index }}, 'quantity', $event.target.value)" class="w-full bg-gray-800 border border-gray-700 text-white text-sm text-center rounded-lg p-1.5 focus:ring-emerald-500 focus:border-emerald-500" min="1">
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="relative">
                                                    <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-gray-500">$</span>
                                                    <input type="number" wire:model.live.debounce.500ms="cart.{{ $index }}.unit_cost" wire:change="updateCartItem({{ $index }}, 'unit_cost', $event.target.value)" class="w-full bg-gray-800 border border-gray-700 text-white text-sm text-right rounded-lg pl-6 p-1.5 focus:ring-emerald-500 focus:border-emerald-500" min="0">
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 text-right font-bold text-white">
                                                ${{ number_format($item['subtotal'], 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button" wire:click="removeProductFromCart({{ $index }})" class="p-1.5 text-gray-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="flex items-center gap-2 px-2 pb-2">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="updateCostPrice" class="sr-only peer">
                                <div class="relative w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                                <span class="ms-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Actualizar Precio de Costo en Inventario</span>
                            </label>
                        </div>
                    @else
                        <div class="text-center py-6 border-2 border-dashed border-gray-700 rounded-xl">
                            <svg class="w-8 h-8 text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <p class="text-xs text-gray-500 font-medium">No hay productos en esta compra.</p>
                            <p class="text-[10px] text-gray-600">Busca repuestos arriba o ingresa solo los montos totales si es un gasto genérico.</p>
                        </div>
                    @endif
                </div>

                <!-- Montos -->
                <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-700 mb-6">
                    <h4 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Totales del Documento</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Monto Total *</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                <input type="number" wire:model.live.debounce.500ms="total_amount" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block pl-8 p-3 transition font-bold text-emerald-400" {{ count($cart) > 0 ? 'readonly' : '' }} placeholder="0">
                            </div>
                            @error('total_amount') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Monto Neto</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                <input type="number" wire:model="net_amount" class="w-full bg-gray-800 border border-gray-700 text-gray-400 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block pl-8 p-3 transition" {{ count($cart) > 0 || $autoCalculateTax ? 'readonly' : '' }}>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">IVA</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                <input type="number" wire:model="tax_amount" class="w-full bg-gray-800 border border-gray-700 text-gray-400 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block pl-8 p-3 transition" {{ count($cart) > 0 || $autoCalculateTax ? 'readonly' : '' }}>
                            </div>
                        </div>
                    </div>
                    @if($document_type === 'factura' && count($cart) == 0)
                        <div class="mt-3 flex items-center">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="autoCalculateTax" class="sr-only peer">
                                <div class="relative w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                                <span class="ms-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Calcular Neto e IVA automáticamente desde el Total</span>
                            </label>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-700/50">
                    <button type="button" wire:click="cancel" class="px-5 py-2.5 text-sm font-bold text-gray-300 bg-gray-800 hover:bg-gray-700 rounded-xl transition-all">Cancelar</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 rounded-xl transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Guardar Documento
                    </button>
                </div>
            </form>
        </div>
    @else
        <!-- Table -->
        <div class="bg-gray-800 border border-gray-700 rounded-2xl overflow-hidden shadow-lg shadow-black/20">
            <div class="overflow-x-auto theme-scrollbar">
                <table class="w-full text-left text-sm text-gray-300">
                    <thead class="bg-gray-900/50 border-b border-gray-700 text-[10px] uppercase text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-black">Fecha</th>
                            <th class="px-6 py-4 font-black">Documento</th>
                            <th class="px-6 py-4 font-black">Proveedor</th>
                            <th class="px-6 py-4 font-black">Ítems</th>
                            <th class="px-6 py-4 font-black">Categoría</th>
                            <th class="px-6 py-4 font-black text-right">Total</th>
                            <th class="px-6 py-4 font-black text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($expenses as $expense)
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 font-semibold text-white whitespace-nowrap">{{ $expense->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-lg border w-max mb-1
                                            {{ $expense->document_type === 'factura' ? 'bg-orange-500/10 text-orange-400 border-orange-500/20' : 
                                              ($expense->document_type === 'boleta' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 'bg-gray-700 text-gray-300 border-gray-600') }}">
                                            {{ ucfirst($expense->document_type) }}
                                        </span>
                                        @if($expense->document_number)
                                            <span class="text-xs text-gray-500">Folio: {{ $expense->document_number }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($expense->supplier)
                                        <div class="font-bold text-white flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            {{ $expense->supplier->name }}
                                        </div>
                                        @if($expense->supplier->rut)
                                            <div class="text-[10px] text-gray-400">{{ $expense->supplier->rut }}</div>
                                        @endif
                                    @else
                                        <div class="font-bold text-white">{{ $expense->supplier_name ?? 'N/A' }}</div>
                                        @if($expense->supplier_rut)
                                            <div class="text-[10px] text-gray-400">{{ $expense->supplier_rut }}</div>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($expense->purchaseItems->count() > 0)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs font-bold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            {{ $expense->purchaseItems->sum('quantity') }} prod.
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-500 italic">Gasto general</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg border bg-gray-800 text-gray-300 border-gray-700">
                                        {{ $expense->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="font-black text-red-400">${{ number_format($expense->total_amount, 0, ',', '.') }}</div>
                                    @if($expense->document_type === 'factura')
                                        <div class="text-[10px] text-gray-500">IVA: ${{ number_format($expense->tax_amount, 0, ',', '.') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="editExpense({{ $expense->id }})" class="p-2 text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 rounded-lg transition-all" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button wire:click="deleteExpense({{ $expense->id }})" wire:confirm="¿Estás seguro de eliminar este registro? Si tiene productos, se revertirá el stock del inventario." class="p-2 text-gray-400 hover:text-red-400 bg-gray-800 hover:bg-red-500/10 rounded-lg transition-all" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="font-semibold text-gray-400">No hay compras ni gastos registrados en este mes.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($expenses->hasPages())
                <div class="px-6 py-4 border-t border-gray-700/50 bg-gray-900/30">
                    {{ $expenses->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
