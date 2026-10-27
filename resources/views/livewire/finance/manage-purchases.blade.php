<div class="space-y-6 pb-16 md:pb-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50">
                    <x-ui.icon name="shopping-bag" class="w-5 h-5" />
                </span>
                Compras y Gastos
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Registra compras de inventario (repuestos) y gastos generales.</p>
        </div>
        
        <div class="flex items-center gap-3 self-start sm:self-auto">
            @if(!$showForm)
            <div class="flex items-center gap-2 bg-white dark:bg-zinc-900 p-1 rounded-lg border border-zinc-200 dark:border-zinc-800 shadow-xs">
                <select wire:model.live="currentMonth" class="bg-transparent text-zinc-800 dark:text-zinc-200 text-xs font-medium rounded-md border-0 py-1.5 pl-2.5 pr-7 focus:ring-1 focus:ring-orange-500">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}">{{ ucfirst(\Carbon\Carbon::create(2000, $m, 1)->locale('es')->monthName) }}</option>
                    @endfor
                </select>
                <div class="w-px h-4 bg-zinc-200 dark:bg-zinc-700"></div>
                <select wire:model.live="currentYear" class="bg-transparent text-zinc-800 dark:text-zinc-200 text-xs font-medium rounded-md border-0 py-1.5 pl-2.5 pr-7 focus:ring-1 focus:ring-orange-500">
                    @for($y=date('Y'); $y>=date('Y')-2; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            
            <button wire:click="createExpense" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-xs transition duration-150 cursor-pointer">
                <x-ui.icon name="plus" class="w-4 h-4" />
                Registrar Compra/Gasto
            </button>
            @endif
        </div>
    </div>

    @if(session()->has('error'))
        <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="alert-triangle" class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" />
            <span class="text-red-800 dark:text-red-300 text-xs font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if($showForm)
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs max-w-5xl mx-auto">
            <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 tracking-tight mb-4 flex items-center gap-2">
                <x-ui.icon name="file-text" class="w-4 h-4 text-orange-500" />
                {{ $expenseId ? 'Editar Documento' : 'Nuevo Documento' }}
            </h3>
            
            <form wire:submit.prevent="saveExpense" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Fecha</label>
                        <input type="date" wire:model="date" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition">
                        @error('date') <span class="text-xs text-red-600 dark:text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Tipo de Documento</label>
                        <select wire:model.live="document_type" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition">
                            <option value="factura">Factura de Compra</option>
                            <option value="boleta">Boleta</option>
                            <option value="recibo">Recibo / Vale</option>
                            <option value="otro">Otro</option>
                        </select>
                        @error('document_type') <span class="text-xs text-red-600 dark:text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">N° Documento / Folio</label>
                        <input type="text" wire:model="document_number" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition" placeholder="Ej: 1542">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                    <div class="relative">
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Proveedor</label>
                        @if($supplier_id)
                            <div class="flex items-center justify-between w-full bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-700 dark:text-emerald-400 text-xs rounded-lg p-2.5">
                                <div class="font-medium flex items-center gap-1.5">
                                    <x-ui.icon name="check" class="w-4 h-4" />
                                    {{ $supplier_name }}
                                </div>
                                <button type="button" wire:click="clearSupplier" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-200 p-0.5">
                                    <x-ui.icon name="x" class="w-4 h-4" />
                                </button>
                            </div>
                        @else
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-zinc-400">
                                    <x-ui.icon name="search" class="w-4 h-4" />
                                </span>
                                <input type="text" wire:model.live.debounce.300ms="searchSupplier" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block pl-9 p-2 transition" placeholder="Buscar proveedor por nombre o RUT...">
                            </div>
                            
                            @if(count($foundSuppliers) > 0)
                                <div class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg overflow-hidden">
                                    <ul class="max-h-60 overflow-y-auto">
                                        @foreach($foundSuppliers as $supplier)
                                            <li>
                                                <button type="button" wire:click="selectSupplier({{ $supplier->id }})" class="w-full text-left px-3 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-700/60 focus:outline-none transition-colors border-b border-zinc-100 dark:border-zinc-700/50 last:border-0">
                                                    <div class="text-xs font-semibold text-zinc-800 dark:text-zinc-200">{{ $supplier->name }}</div>
                                                    @if($supplier->rut)
                                                        <div class="text-[10px] text-zinc-400 font-mono">{{ $supplier->rut }}</div>
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
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Categoría Principal</label>
                        <select wire:model="category" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition">
                            <option value="Inventario/Repuestos">Inventario / Repuestos</option>
                            <option value="General">General</option>
                            <option value="Arriendo">Arriendo</option>
                            <option value="Servicios Básicos">Servicios Básicos (Luz, Agua, Internet)</option>
                            <option value="Sueldos">Sueldos</option>
                            <option value="Marketing">Marketing / Publicidad</option>
                        </select>
                        @error('category') <span class="text-xs text-red-600 dark:text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Descripción General (Opcional)</label>
                    <input type="text" wire:model="description" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition" placeholder="Ej: Compra de mercadería del mes">
                </div>

                <!-- Detalles de Productos (Inventario) -->
                <div class="bg-zinc-50/60 dark:bg-zinc-850/60 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <div>
                            <h4 class="text-xs font-bold text-zinc-800 dark:text-zinc-200">Detalle de Productos (Inventario)</h4>
                            <p class="text-[11px] text-zinc-400 dark:text-zinc-500">Si agregas productos, el stock se actualizará automáticamente y los montos totales se calcularán de ellos.</p>
                        </div>
                        
                        <!-- Buscador -->
                        <div class="relative w-full md:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-zinc-400">
                                <x-ui.icon name="search" class="w-3.5 h-3.5" />
                            </span>
                            <input type="text" wire:model.live.debounce.300ms="searchProduct" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block pl-8 py-1.5 pr-2 transition" placeholder="Buscar repuesto para comprar...">
                            
                            @if(count($foundProducts) > 0)
                                <div class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg overflow-hidden">
                                    <ul class="max-h-60 overflow-y-auto">
                                        @foreach($foundProducts as $product)
                                            <li>
                                                <button type="button" wire:click="addProductToCart({{ $product->id }})" class="w-full text-left px-3 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-700/60 focus:outline-none transition-colors border-b border-zinc-100 dark:border-zinc-700/50 last:border-0 flex justify-between items-center group">
                                                    <div>
                                                        <div class="text-xs font-semibold text-zinc-800 dark:text-zinc-200 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">{{ $product->name }}</div>
                                                        <div class="text-[10px] text-zinc-400">Stock: <span class="{{ $product->stock <= $product->min_stock ? 'text-red-500' : 'text-emerald-500' }}">{{ $product->stock }}</span></div>
                                                    </div>
                                                    <x-ui.icon name="plus" class="w-3.5 h-3.5 text-zinc-400 group-hover:text-orange-500" />
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(count($cart) > 0)
                        <div class="overflow-x-auto mb-3">
                            <table class="w-full text-left text-xs whitespace-nowrap">
                                <thead>
                                    <tr class="bg-zinc-100/80 dark:bg-zinc-800/80 border-b border-zinc-200 dark:border-zinc-700 text-[10px] uppercase text-zinc-500 dark:text-zinc-400 font-semibold tracking-wider">
                                        <th class="px-3 py-2 w-1/3">Producto</th>
                                        <th class="px-3 py-2 text-center w-24">Cant.</th>
                                        <th class="px-3 py-2 text-right w-32">Costo Unitario (Neto)</th>
                                        <th class="px-3 py-2 text-right w-32">Subtotal (Neto)</th>
                                        <th class="px-3 py-2 text-center w-12"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200/60 dark:divide-zinc-700/60">
                                    @foreach($cart as $index => $item)
                                        <tr class="hover:bg-zinc-100/50 dark:hover:bg-zinc-800/50 transition-colors">
                                            <td class="px-3 py-1.5 font-medium text-zinc-800 dark:text-zinc-200">
                                                {{ $item['name'] }}
                                            </td>
                                            <td class="px-3 py-1.5">
                                                <input type="number" wire:model.live.debounce.500ms="cart.{{ $index }}.quantity" wire:change="updateCartItem({{ $index }}, 'quantity', $event.target.value)" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-zinc-200 text-xs text-center rounded p-1 focus:ring-1 focus:ring-orange-500 focus:border-orange-500" min="1">
                                            </td>
                                            <td class="px-3 py-1.5">
                                                <div class="relative">
                                                    <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-zinc-400 text-xs">$</span>
                                                    <input type="number" wire:model.live.debounce.500ms="cart.{{ $index }}.unit_cost" wire:change="updateCartItem({{ $index }}, 'unit_cost', $event.target.value)" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-zinc-200 text-xs text-right rounded pl-5 p-1 focus:ring-1 focus:ring-orange-500 focus:border-orange-500" min="0">
                                                </div>
                                            </td>
                                            <td class="px-3 py-1.5 text-right font-semibold text-zinc-900 dark:text-zinc-100">
                                                ${{ number_format($item['subtotal'], 0, ',', '.') }}
                                            </td>
                                            <td class="px-3 py-1.5 text-center">
                                                <button type="button" wire:click="removeProductFromCart({{ $index }})" class="p-1 text-zinc-400 hover:text-red-500 rounded transition-colors">
                                                    <x-ui.icon name="x" class="w-3.5 h-3.5" />
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="updateCostPrice" class="rounded border-zinc-300 dark:border-zinc-700 text-orange-500 focus:ring-orange-500">
                                <span class="text-xs text-zinc-600 dark:text-zinc-400 font-medium">Actualizar Precio de Costo en Inventario</span>
                            </label>
                        </div>
                    @else
                        <div class="text-center py-5 border border-dashed border-zinc-200 dark:border-zinc-700 rounded-lg">
                            <x-ui.icon name="package" class="w-6 h-6 text-zinc-300 dark:text-zinc-600 mx-auto mb-1.5" />
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 font-medium">No hay productos en esta compra.</p>
                            <p class="text-[10px] text-zinc-400 dark:text-zinc-500">Busca repuestos arriba o ingresa solo los montos totales si es un gasto genérico.</p>
                        </div>
                    @endif
                </div>

                <!-- Montos -->
                <div class="bg-zinc-50/60 dark:bg-zinc-850/60 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <h4 class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-3">Totales del Documento</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Monto Total *</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400 font-semibold text-xs">$</span>
                                <input type="number" wire:model.live.debounce.500ms="total_amount" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 text-xs font-bold rounded-lg pl-7 p-2 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition" {{ count($cart) > 0 ? 'readonly' : '' }} placeholder="0">
                            </div>
                            @error('total_amount') <span class="text-xs text-red-600 dark:text-red-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Monto Neto</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400 font-semibold text-xs">$</span>
                                <input type="number" wire:model="net_amount" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 text-xs rounded-lg pl-7 p-2 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition" {{ count($cart) > 0 || $autoCalculateTax ? 'readonly' : '' }}>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">IVA</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400 font-semibold text-xs">$</span>
                                <input type="number" wire:model="tax_amount" class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 text-xs rounded-lg pl-7 p-2 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition" {{ count($cart) > 0 || $autoCalculateTax ? 'readonly' : '' }}>
                            </div>
                        </div>
                    </div>
                    @if($document_type === 'factura' && count($cart) == 0)
                        <div class="mt-2.5 flex items-center">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model.live="autoCalculateTax" class="rounded border-zinc-300 dark:border-zinc-700 text-orange-500 focus:ring-orange-500">
                                <span class="text-xs text-zinc-600 dark:text-zinc-400 font-medium">Calcular Neto e IVA automáticamente desde el Total</span>
                            </label>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" wire:click="cancel" class="px-4 py-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-lg transition cursor-pointer">Cancelar</button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition shadow-xs flex items-center gap-1.5 cursor-pointer">
                        <x-ui.icon name="check" class="w-4 h-4" />
                        Guardar Documento
                    </button>
                </div>
            </form>
        </div>
    @else
        <!-- Table -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 border-b border-zinc-200 dark:border-zinc-800 text-[10px] uppercase text-zinc-500 dark:text-zinc-400 font-semibold tracking-wider">
                            <th class="px-4 py-3">Fecha</th>
                            <th class="px-4 py-3">Documento</th>
                            <th class="px-4 py-3">Proveedor</th>
                            <th class="px-4 py-3">Ítems</th>
                            <th class="px-4 py-3">Categoría</th>
                            <th class="px-4 py-3 text-right">Total</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                        @forelse($expenses as $expense)
                            <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors">
                                <td class="px-4 py-3 font-mono text-zinc-500 dark:text-zinc-400 text-xs">{{ $expense->date->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col gap-0.5">
                                        @php
                                            $badgeVariant = match($expense->document_type) {
                                                'factura' => 'warning',
                                                'boleta' => 'info',
                                                default => 'neutral'
                                            };
                                        @endphp
                                        <x-ui.badge :variant="$badgeVariant" size="xs">
                                            {{ ucfirst($expense->document_type) }}
                                        </x-ui.badge>
                                        @if($expense->document_number)
                                            <span class="text-[10px] font-mono text-zinc-400">Folio: {{ $expense->document_number }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($expense->supplier)
                                        <div class="font-semibold text-zinc-800 dark:text-zinc-200 flex items-center gap-1.5">
                                            {{ $expense->supplier->name }}
                                        </div>
                                        @if($expense->supplier->rut)
                                            <div class="text-[10px] font-mono text-zinc-400">{{ $expense->supplier->rut }}</div>
                                        @endif
                                    @else
                                        <div class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $expense->supplier_name ?? 'N/A' }}</div>
                                        @if($expense->supplier_rut)
                                            <div class="text-[10px] font-mono text-zinc-400">{{ $expense->supplier_rut }}</div>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($expense->purchaseItems->count() > 0)
                                        <x-ui.badge variant="success" size="xs">
                                            {{ $expense->purchaseItems->sum('quantity') }} prod.
                                        </x-ui.badge>
                                    @else
                                        <span class="text-xs text-zinc-400 italic">Gasto general</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <x-ui.badge variant="neutral" size="xs">
                                        {{ $expense->category }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($expense->total_amount, 0, ',', '.') }}</div>
                                    @if($expense->document_type === 'factura')
                                        <div class="text-[10px] text-zinc-400">IVA: ${{ number_format($expense->tax_amount, 0, ',', '.') }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="editExpense({{ $expense->id }})" class="p-1.5 text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded transition cursor-pointer" title="Editar">
                                            <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                                        </button>
                                        <button wire:click="deleteExpense({{ $expense->id }})" wire:confirm="¿Estás seguro de eliminar este registro? Si tiene productos, se revertirá el stock del inventario." class="p-1.5 text-zinc-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 rounded transition cursor-pointer" title="Eliminar">
                                            <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-zinc-400 dark:text-zinc-500 text-xs">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <x-ui.icon name="shopping-bag" class="w-8 h-8 text-zinc-300 dark:text-zinc-600" />
                                        <span>No hay compras ni gastos registrados en este mes.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($expenses->hasPages())
                <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                    {{ $expenses->links() }}
                </div>
            @endif
        </div>
    @endif
</div>