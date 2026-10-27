<div class="space-y-6 pb-20">

    <!-- HEADER DE COTIZACIÓN -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 sm:p-5 rounded-xl shadow-xs">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-lg sm:text-xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight">
                    {{ $quote_id ? 'Editar Cotización' : 'Nueva Cotización' }}
                </h1>
                <span class="text-xs font-mono font-semibold px-2.5 py-0.5 rounded bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50">
                    N° {{ $quote_number }}
                </span>
            </div>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Presupuesto formal de repuestos, servicios de mano de obra y términos de garantía.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('quotations.index') }}" class="px-3 py-1.5 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs font-medium rounded-lg transition cursor-pointer">
                ← Volver
            </a>
            
            <button type="button" wire:click="save('borrador')" class="px-3 py-1.5 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-800 dark:text-zinc-200 text-xs font-medium rounded-lg transition cursor-pointer">
                Guardar Borrador
            </button>

            <button type="button" wire:click="save('enviada')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold rounded-lg shadow-xs transition cursor-pointer">
                <x-ui.icon name="check" class="w-4 h-4" />
                Finalizar Cotización
            </button>
        </div>
    </div>

    <!-- GRID PRINCIPAL (2 COLUMNAS) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

        <!-- COLUMNA IZQUIERDA: CLIENTE Y EQUIPO (4 columnas) -->
        <div class="lg:col-span-4 space-y-4">

            <!-- Card Informacion del Cliente -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 rounded-xl shadow-xs space-y-3.5">
                <h3 class="font-bold text-zinc-900 dark:text-zinc-100 text-xs border-b border-zinc-100 dark:border-zinc-800 pb-2 flex items-center gap-2">
                    <x-ui.icon name="user" class="w-4 h-4 text-orange-500" />
                    Información del Cliente
                </h3>

                <!-- Buscador de Cliente -->
                <div class="relative">
                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Buscar Cliente</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center text-zinc-400">
                            <x-ui.icon name="search" class="w-3.5 h-3.5" />
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search_client" placeholder="Nombre, RUT o Teléfono..." class="w-full text-xs py-1.5 pl-8 pr-3 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500">
                    </div>

                    @if(!empty($found_clients))
                        <div class="absolute z-30 top-full left-0 right-0 mt-1 bg-white dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg max-h-48 overflow-y-auto divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($found_clients as $fc)
                                <button type="button" wire:click="selectClient({{ $fc['id'] }})" class="w-full text-left p-2 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition cursor-pointer">
                                    <div class="font-semibold text-xs text-zinc-800 dark:text-zinc-200">
                                        {{ $fc['full_name'] }} @if(!empty($fc['company_name'])) <span class="text-orange-600 dark:text-orange-400 font-normal">({{ $fc['company_name'] }})</span> @endif
                                    </div>
                                    <div class="text-[10px] text-zinc-400">RUT: {{ $fc['rut_dni'] ?: 'N/A' }} • Tel: {{ $fc['phone'] }}</div>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if($client_id)
                    <div class="p-2 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-lg flex items-center justify-between text-xs">
                        <span class="font-medium text-emerald-700 dark:text-emerald-400">Cliente Vinculado</span>
                        <button type="button" wire:click="clearClient" class="text-[11px] text-red-500 hover:underline cursor-pointer">Desvincular</button>
                    </div>
                @endif

                <div class="space-y-2.5 pt-1">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Nombre Completo / Empresa *</label>
                        <input type="text" wire:model="client_name" placeholder="Ej: Juan Pérez o Empresa SpA" class="w-full text-xs p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500">
                        @error('client_name') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">RUT / DNI</label>
                            <input type="text" wire:model="client_rut" placeholder="12.345.678-9" class="w-full text-xs p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Teléfono</label>
                            <input type="text" wire:model="client_phone" placeholder="+56 9 1234 5678" class="w-full text-xs p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Correo Electrónico</label>
                        <input type="email" wire:model="client_email" placeholder="cliente@correo.com" class="w-full text-xs p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500">
                    </div>
                </div>
            </div>

            <!-- Card Especificaciones del Equipo -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 rounded-xl shadow-xs space-y-3">
                <h3 class="font-bold text-zinc-900 dark:text-zinc-100 text-xs border-b border-zinc-100 dark:border-zinc-800 pb-2 flex items-center gap-2">
                    <x-ui.icon name="monitor" class="w-4 h-4 text-orange-500" />
                    Especificaciones del Equipo
                </h3>

                <!-- Selector Tipo de Equipo -->
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Tipo de Equipo</label>
                    <select wire:model.live="device_type" class="w-full text-xs p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500 cursor-pointer">
                        <option value="smartphone">Smartphone / Celular</option>
                        <option value="smartwatch">Smartwatch / Reloj</option>
                        <option value="allinone">PC All-in-One / iMac</option>
                        <option value="notebook">Notebook / Laptop</option>
                        <option value="desktop">PC de Escritorio</option>
                        <option value="tablet">Tablet / iPad</option>
                        <option value="console">Consola de Videojuegos</option>
                        <option value="other">Otro Equipo / Servicio</option>
                    </select>
                </div>

                <!-- Marca y Modelo con Predictivo -->
                <div class="relative">
                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Marca y Modelo *</label>
                    <input type="text" wire:model.live.debounce.250ms="brand_model" placeholder="Ej: iPhone 15 Pro, Mac..." class="w-full text-xs p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500">
                    
                    @if(!empty($found_devices))
                        <div class="absolute z-30 top-full left-0 right-0 mt-1 bg-white dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg max-h-48 overflow-y-auto divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($found_devices as $dev)
                                <button type="button" wire:click="selectDevice('{{ addslashes($dev['brand']) }}', '{{ addslashes($dev['model']) }}', '{{ $dev['device_type'] }}')" class="w-full text-left p-2 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition cursor-pointer flex items-center justify-between text-xs">
                                    <span class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $dev['brand'] }} {{ $dev['model'] }}</span>
                                    <span class="text-[10px] text-zinc-400">
                                        {{ ucfirst($dev['device_type']) }}
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- N° Serie / IMEI -->
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">N° Serie / IMEI <span class="text-zinc-400 font-normal">(Opcional)</span></label>
                    <input type="text" wire:model.live.debounce.300ms="imei_serial" wire:change="syncDeviceInfo" placeholder="Ej: 354892019482..." class="w-full text-xs p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500">
                </div>

                <div class="grid grid-cols-2 gap-2 pt-1">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Válido Hasta</label>
                        <input type="date" wire:model="valid_until" class="w-full text-xs p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Estado</label>
                        <select wire:model="status" class="w-full text-xs p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500 cursor-pointer">
                            <option value="borrador">Borrador</option>
                            <option value="enviada">Enviada</option>
                            <option value="aceptada">Aceptada</option>
                            <option value="rechazada">Rechazada</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <!-- COLUMNA DERECHA: ÍTEMS, BUSCADORES Y TOTALES (8 columnas) -->
        <div class="lg:col-span-8 space-y-4">

            <!-- Card Detalle de Ítems y Buscadores -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-5 rounded-xl shadow-xs space-y-4">
                
                <!-- Encabezado del Detalle -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-3">
                    <div>
                        <h3 class="font-bold text-zinc-900 dark:text-zinc-100 text-sm">Detalle de Repuestos y Servicios</h3>
                        <p class="text-xs text-zinc-400 mt-0.5">Agrega labores del catálogo o productos del inventario.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" wire:click="addOnDemandPart" class="px-3 py-1.5 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs font-semibold rounded-lg transition border border-zinc-200 dark:border-zinc-700 flex items-center gap-1.5 cursor-pointer">
                            <x-ui.icon name="package" class="w-3.5 h-3.5 text-amber-500" />
                            + Repuesto a Pedido
                        </button>

                        <button type="button" wire:click="addItem" class="px-3 py-1.5 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs font-semibold rounded-lg transition flex items-center gap-1.5 cursor-pointer border border-zinc-200 dark:border-zinc-700">
                            <x-ui.icon name="plus" class="w-3.5 h-3.5" />
                            + Fila Libre
                        </button>
                    </div>
                </div>

                <!-- Buscadores Predictivos de Servicios y Repuestos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pb-2 border-b border-zinc-100 dark:border-zinc-800">
                    <!-- Buscador Predictivo de Servicios del Catálogo -->
                    <div class="relative">
                        <label class="block text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Añadir Servicio del Catálogo</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center text-zinc-400">
                                <x-ui.icon name="wrench" class="w-3.5 h-3.5" />
                            </span>
                            <input type="text" wire:model.live.debounce.150ms="search_service"
                                class="w-full text-xs py-1.5 pl-8 pr-3 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500"
                                placeholder="Buscar labor técnica..." autocomplete="off">
                        </div>

                        @if(count($found_services) > 0)
                            <div class="absolute z-30 w-full mt-1 overflow-hidden rounded-lg shadow-lg bg-white dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-700 divide-y divide-zinc-100 dark:divide-zinc-800">
                                <ul class="max-h-48 overflow-y-auto">
                                    @foreach($found_services as $fs)
                                        <li wire:click="addServiceItem({{ $fs['id'] }})" class="p-2 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer flex items-center justify-between transition">
                                            <div>
                                                <div class="font-semibold text-xs text-zinc-800 dark:text-zinc-200">{{ $fs['name'] }}</div>
                                                <div class="text-[10px] text-zinc-400">Servicio</div>
                                            </div>
                                            <span class="font-mono font-bold text-xs text-emerald-600 dark:text-emerald-400">${{ number_format($fs['default_price'], 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Buscador Predictivo de Repuestos del Inventario -->
                    <div class="relative">
                        <label class="block text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Añadir Repuesto del Inventario</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center text-zinc-400">
                                <x-ui.icon name="package" class="w-3.5 h-3.5" />
                            </span>
                            <input type="text" wire:model.live.debounce.150ms="search_inventory"
                                class="w-full text-xs py-1.5 pl-8 pr-3 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500"
                                placeholder="Buscar repuesto en stock..." autocomplete="off">
                        </div>

                        @if(count($found_inventory) > 0)
                            <div class="absolute z-30 w-full mt-1 overflow-hidden rounded-lg shadow-lg bg-white dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-700 divide-y divide-zinc-100 dark:divide-zinc-800">
                                <ul class="max-h-48 overflow-y-auto">
                                    @foreach($found_inventory as $fi)
                                        <li wire:click="addInventoryItem({{ $fi['id'] }})" class="p-2 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer flex items-center justify-between transition">
                                            <div>
                                                <div class="font-semibold text-xs text-zinc-800 dark:text-zinc-200">{{ $fi['name'] }}</div>
                                                <div class="text-[10px] text-zinc-400">Stock: {{ $fi['stock'] }} uds</div>
                                            </div>
                                            <span class="font-mono font-bold text-xs text-emerald-600 dark:text-emerald-400">${{ number_format($fi['sale_price'] ?? 0, 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tabla de Ítems -->
                <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-800">
                    <table class="w-full text-xs text-left">
                        <thead>
                            <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 text-zinc-500 dark:text-zinc-400 font-semibold uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                                <th class="p-2.5">Descripción</th>
                                <th class="p-2.5 w-28">Tipo</th>
                                <th class="p-2.5 w-16 text-center">Cant.</th>
                                <th class="p-2.5 w-28 text-right">P. Unitario ($)</th>
                                <th class="p-2.5 w-28 text-right">Subtotal ($)</th>
                                <th class="p-2.5 w-8 text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($items as $index => $item)
                                <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition">
                                    <td class="p-2">
                                        <input type="text" wire:model="items.{{ $index }}.description" placeholder="Descripción del servicio o producto..." class="w-full text-xs py-1 px-2 rounded border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium focus:outline-none focus:border-orange-500">
                                    </td>
                                    <td class="p-2">
                                        <select wire:model.live="items.{{ $index }}.type" class="w-full text-xs py-1 px-1.5 rounded border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 font-medium text-zinc-800 dark:text-zinc-200 focus:outline-none cursor-pointer">
                                            <option value="servicio">Servicio</option>
                                            <option value="producto">Producto</option>
                                        </select>
                                    </td>
                                    <td class="p-2 text-center">
                                        <input type="number" min="1" wire:model.live="items.{{ $index }}.quantity" class="w-14 text-center text-xs p-1 rounded border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-bold focus:outline-none">
                                    </td>
                                    <td class="p-2 text-right">
                                        <input type="number" min="0" step="500" wire:model.live="items.{{ $index }}.unit_price" class="w-full text-right text-xs p-1 rounded border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-bold focus:outline-none">
                                    </td>
                                    <td class="p-2 text-right font-mono font-bold text-zinc-900 dark:text-zinc-100 text-xs">
                                        ${{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="p-2 text-center">
                                        <button type="button" wire:click="removeItem({{ $index }})" class="p-1 text-zinc-400 hover:text-red-500 rounded transition cursor-pointer" title="Eliminar ítem">
                                            <x-ui.icon name="x" class="w-3.5 h-3.5" />
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Bloque Totales & Opciones Fiscales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Observaciones / Notas</label>
                        <textarea wire:model="notes" rows="4" placeholder="Comentarios adicionales para el cliente..." class="w-full text-xs p-2.5 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 resize-none"></textarea>
                    </div>

                    <div class="bg-zinc-50 dark:bg-zinc-850 p-3.5 rounded-lg space-y-2.5 text-xs border border-zinc-200/80 dark:border-zinc-800">
                        <div class="flex justify-between items-center text-zinc-600 dark:text-zinc-400">
                            <span>Suma de Ítems:</span>
                            <span class="font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($subtotal + $discount, 0, ',', '.') }} CLP</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-zinc-500 dark:text-zinc-400">Descuento ($):</span>
                            <input type="number" min="0" wire:model.live="discount" class="w-24 text-right text-xs p-1 rounded border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-bold focus:outline-none">
                        </div>

                        <!-- Selector de Opciones Fiscales de IVA -->
                        <div class="pt-2 border-t border-zinc-200 dark:border-zinc-800 space-y-1.5">
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 text-[11px] uppercase tracking-wider">Cálculo de IVA (19%):</label>
                            <div class="space-y-1 text-xs">
                                <label class="flex items-center gap-2 cursor-pointer text-zinc-800 dark:text-zinc-200 p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800">
                                    <input type="radio" wire:model.live="tax_mode" value="labor_only" class="text-orange-500 focus:ring-orange-500">
                                    <span>IVA 19% SOLO a Mano de Obra</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-zinc-600 dark:text-zinc-400 p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800">
                                    <input type="radio" wire:model.live="tax_mode" value="included" class="text-orange-500 focus:ring-orange-500">
                                    <span>Precios Incluyen IVA</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-zinc-600 dark:text-zinc-400 p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800">
                                    <input type="radio" wire:model.live="tax_mode" value="added" class="text-orange-500 focus:ring-orange-500">
                                    <span>Precios son NETOS (+ 19% IVA)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-zinc-600 dark:text-zinc-400 p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800">
                                    <input type="radio" wire:model.live="tax_mode" value="exempt" class="text-orange-500 focus:ring-orange-500">
                                    <span>Exento de IVA</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-2 border-t border-zinc-200 dark:border-zinc-800 text-zinc-500 dark:text-zinc-400">
                            <span>Base Neta:</span>
                            <span class="font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($subtotal, 0, ',', '.') }} CLP</span>
                        </div>

                        <div class="flex justify-between items-center text-zinc-500 dark:text-zinc-400">
                            <span>IVA (19%):</span>
                            <span class="font-bold text-zinc-900 dark:text-zinc-100">
                                @if($tax_amount > 0)
                                    +${{ number_format($tax_amount, 0, ',', '.') }} CLP
                                @else
                                    $0 (Exento)
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between items-center pt-2.5 border-t border-zinc-200 dark:border-zinc-800 font-bold text-sm text-zinc-900 dark:text-zinc-100">
                            <span>TOTAL PRESUPUESTO:</span>
                            <span class="text-base text-orange-600 dark:text-orange-400 font-mono">${{ number_format($total, 0, ',', '.') }} CLP</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Términos y Condiciones -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-5 rounded-xl shadow-xs space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-2.5">
                    <div>
                        <h3 class="font-bold text-zinc-900 dark:text-zinc-100 text-xs flex items-center gap-1.5">
                            <x-ui.icon name="check-circle" class="w-3.5 h-3.5 text-emerald-500" />
                            Términos, Condiciones y Garantías
                        </h3>
                        <p class="text-[11px] text-zinc-400">Plantillas de garantía rápida predefinidas.</p>
                    </div>

                    <!-- Botones de Presets de Garantía -->
                    <div class="flex flex-wrap items-center gap-1.5">
                        <button type="button" wire:click="setWarrantyPreset('standard')" class="px-2 py-1 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-[11px] font-medium rounded border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                            90 Días / 12 Meses
                        </button>
                        <button type="button" wire:click="setWarrantyPreset('parts_12m')" class="px-2 py-1 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-[11px] font-medium rounded border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                            1 Año Repuestos
                        </button>
                        <button type="button" wire:click="setWarrantyPreset('express_30d')" class="px-2 py-1 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-[11px] font-medium rounded border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                            30 Días Express
                        </button>
                        <button type="button" wire:click="setWarrantyPreset('no_warranty')" class="px-2 py-1 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-[11px] font-medium rounded border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                            Sin Garantía
                        </button>
                    </div>
                </div>

                <textarea wire:model="terms_and_conditions" rows="4" class="w-full text-xs p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 leading-relaxed resize-none"></textarea>
            </div>

        </div>

    </div>
</div>