<div class="max-w-7xl mx-auto pb-20 space-y-6">

    <!-- HEADER DE COTIZACIÓN -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-gray-900 border border-gray-800 p-6 rounded-2xl shadow-sm">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-black text-white tracking-tight">
                    {{ $quote_id ? 'Editar Cotización' : 'Nueva Cotización Rápida' }}
                </h1>
                <span class="text-xs font-mono font-bold px-3 py-1 rounded-xl bg-orange-500/10 text-orange-400 border border-orange-500/20">
                    N° {{ $quote_number }}
                </span>
            </div>
            <p class="text-xs text-gray-400 mt-1">Presupuesto formal de repuestos, servicios de mano de obra y términos de garantía.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('quotations.index') }}" class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-bold rounded-xl transition cursor-pointer">
                ← Volver al Listado
            </a>
            
            <button type="button" wire:click="save('borrador')" class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold rounded-xl transition cursor-pointer">
                💾 Guardar Borrador
            </button>

            <button type="button" wire:click="save('enviada')" class="px-5 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-400 text-white text-xs font-bold rounded-xl shadow-lg shadow-orange-500/20 transition flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Finalizar Cotización
            </button>
        </div>
    </div>

    <!-- GRID PRINCIPAL (2 COLUMNAS) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- COLUMNA IZQUIERDA: CLIENTE Y EQUIPO (4 columnas) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Card Informacion del Cliente -->
            <div class="bg-gray-900 border border-gray-800 p-5 rounded-2xl space-y-4">
                <h3 class="font-bold text-white text-sm border-b border-gray-800 pb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Información del Cliente
                </h3>

                <!-- Buscador de Cliente -->
                <div class="relative">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Buscar Cliente Registrado</label>
                    <input type="text" wire:model.live.debounce.300ms="search_client" placeholder="Nombre, RUT o Teléfono..." class="w-full text-xs p-2.5 rounded-xl border border-gray-800 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-gray-600">

                    @if(!empty($found_clients))
                        <div class="absolute z-30 top-full left-0 right-0 mt-1 bg-gray-900 border border-gray-700 rounded-xl shadow-2xl max-h-48 overflow-y-auto divide-y divide-gray-800">
                            @foreach($found_clients as $fc)
                                <button type="button" wire:click="selectClient({{ $fc['id'] }})" class="w-full text-left p-2.5 hover:bg-gray-800 transition cursor-pointer">
                                    <div class="font-bold text-xs text-white">
                                        {{ $fc['full_name'] }} @if(!empty($fc['company_name'])) <span class="text-orange-400 font-semibold">({{ $fc['company_name'] }})</span> @endif
                                    </div>
                                    <div class="text-[10px] text-gray-400">RUT: {{ $fc['rut_dni'] ?: 'N/A' }} | Tel: {{ $fc['phone'] }}</div>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if($client_id)
                    <div class="p-2.5 bg-blue-950/40 border border-blue-800/50 rounded-xl flex items-center justify-between">
                        <span class="text-xs font-semibold text-blue-300">✓ Cliente Vinculado</span>
                        <button type="button" wire:click="clearClient" class="text-[10px] text-red-400 hover:underline cursor-pointer">Desvincular</button>
                    </div>
                @endif

                <div class="space-y-3 pt-1">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nombre Completo / Empresa <span class="text-red-400">*</span></label>
                        <input type="text" wire:model="client_name" placeholder="Ej: Juan Pérez o Empresa SpA" class="w-full text-xs p-2.5 rounded-xl border border-gray-800 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-gray-600">
                        @error('client_name') <span class="text-[11px] text-red-400">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">RUT / DNI</label>
                            <input type="text" wire:model="client_rut" placeholder="12.345.678-9" class="w-full text-xs p-2.5 rounded-xl border border-gray-800 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-gray-600">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Teléfono</label>
                            <input type="text" wire:model="client_phone" placeholder="+56 9 1234 5678" class="w-full text-xs p-2.5 rounded-xl border border-gray-800 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-gray-600">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Correo Electrónico</label>
                        <input type="email" wire:model="client_email" placeholder="cliente@correo.com" class="w-full text-xs p-2.5 rounded-xl border border-gray-800 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-gray-600">
                    </div>
                </div>
            </div>

            <!-- Card Especificaciones del Equipo -->
            <div class="bg-gray-900 border border-gray-800 p-5 rounded-2xl space-y-3">
                <h3 class="font-bold text-white text-sm border-b border-gray-800 pb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Especificaciones del Equipo
                </h3>

                <!-- Selector Tipo de Equipo -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tipo de Equipo</label>
                    <select wire:model.live="device_type" class="w-full text-xs p-2.5 rounded-xl border border-gray-800 bg-gray-950 text-white focus:outline-none focus:border-gray-600 cursor-pointer">
                        <option value="smartphone">📱 Smartphone / Celular</option>
                        <option value="smartwatch">⌚ Smartwatch / Reloj Inteligente</option>
                        <option value="allinone">🖥️ PC All-in-One / iMac</option>
                        <option value="notebook">💻 Notebook / Laptop</option>
                        <option value="desktop">🖥️ PC de Escritorio (Torre)</option>
                        <option value="tablet">📟 Tablet / iPad</option>
                        <option value="console">🎮 Consola de Videojuegos</option>
                        <option value="other">⚙️ Otro Equipo / Servicio</option>
                    </select>
                </div>

                <!-- Marca y Modelo con Predictivo -->
                <div class="relative">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Marca y Modelo <span class="text-red-400">*</span></label>
                    <input type="text" wire:model.live.debounce.250ms="brand_model" placeholder="Ej: iPhone 15 Pro, Galaxy Watch 6, Mac..." class="w-full text-xs p-2.5 rounded-xl border border-gray-800 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-gray-600">
                    
                    @if(!empty($found_devices))
                        <div class="absolute z-30 top-full left-0 right-0 mt-1 bg-gray-900 border border-gray-700 rounded-xl shadow-2xl max-h-48 overflow-y-auto divide-y divide-gray-800">
                            @foreach($found_devices as $dev)
                                <button type="button" wire:click="selectDevice('{{ addslashes($dev['brand']) }}', '{{ addslashes($dev['model']) }}', '{{ $dev['device_type'] }}')" class="w-full text-left p-2.5 hover:bg-gray-800 transition cursor-pointer flex items-center justify-between text-xs">
                                    <span class="font-bold text-white">{{ $dev['brand'] }} {{ $dev['model'] }}</span>
                                    <span class="text-[10px] bg-blue-950/80 text-blue-300 px-2 py-0.5 rounded-full font-semibold border border-blue-800">
                                        @switch($dev['device_type'])
                                            @case('smartphone') 📱 Smartphone @break
                                            @case('smartwatch') ⌚ Reloj @break
                                            @case('allinone') 🖥️ All-in-One @break
                                            @case('notebook') 💻 Notebook @break
                                            @case('desktop') 🖥️ PC @break
                                            @case('tablet') 📟 Tablet @break
                                            @case('console') 🎮 Consola @break
                                            @default ⚙️ {{ ucfirst($dev['device_type']) }}
                                        @endswitch
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- N° Serie / IMEI -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">N° Serie / IMEI <span class="text-gray-600 font-normal">(Opcional)</span></label>
                    <input type="text" wire:model.live.debounce.300ms="imei_serial" wire:change="syncDeviceInfo" placeholder="Ej: 354892019482..." class="w-full text-xs p-2.5 rounded-xl border border-gray-800 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-gray-600">
                </div>

                <div class="grid grid-cols-2 gap-2 pt-1">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Válido Hasta</label>
                        <input type="date" wire:model="valid_until" class="w-full text-xs p-2.5 rounded-xl border border-gray-800 bg-gray-950 text-white focus:outline-none focus:border-gray-600">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Estado</label>
                        <select wire:model="status" class="w-full text-xs p-2.5 rounded-xl border border-gray-800 bg-gray-950 text-white focus:outline-none focus:border-gray-600 cursor-pointer">
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
        <div class="lg:col-span-8 space-y-6">

            <!-- Card Detalle de Ítems y Buscadores -->
            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl space-y-5">
                
                <!-- Encabezado del Detalle -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-800 pb-4">
                    <div>
                        <h3 class="font-bold text-white text-base">Detalle de Repuestos y Servicios</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Agrega labores del catálogo o productos del inventario.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" wire:click="addOnDemandPart" class="px-3 py-2 bg-amber-950/40 hover:bg-amber-900/60 text-amber-300 text-xs font-bold rounded-xl transition border border-amber-500/30 flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            + Repuesto a Pedido
                        </button>

                        <button type="button" wire:click="addItem" class="px-3 py-2 bg-gray-800 hover:bg-gray-700 text-gray-200 text-xs font-bold rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            + Fila Libre
                        </button>
                    </div>
                </div>

                <!-- Buscadores Predictivos de Servicios y Repuestos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-2 border-b border-gray-800">
                    <!-- Buscador Predictivo de Servicios del Catálogo -->
                    <div class="relative">
                        <label class="block text-[11px] font-bold text-indigo-400 uppercase tracking-wider mb-1.5">🛠️ Añadir Servicio del Catálogo</label>
                        <input type="text" wire:model.live.debounce.150ms="search_service"
                            class="w-full text-xs p-2.5 rounded-xl border border-indigo-500/30 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-indigo-500"
                            placeholder="Buscar labor técnica (Ej: Pantalla, Limpieza)..." autocomplete="off">

                        @if(count($found_services) > 0)
                            <div class="absolute z-30 w-full mt-1.5 overflow-hidden rounded-xl shadow-2xl bg-gray-900 border border-indigo-700 divide-y divide-gray-800">
                                <div class="px-3 py-1.5 bg-indigo-950/60 flex items-center justify-between text-[10px] text-indigo-300 font-bold">
                                    <span>Servicios Compatibles</span>
                                    <span>Clic para añadir</span>
                                </div>
                                <ul class="max-h-48 overflow-y-auto">
                                    @foreach($found_services as $fs)
                                        <li wire:click="addServiceItem({{ $fs['id'] }})" class="p-2.5 hover:bg-indigo-950/40 cursor-pointer flex items-center justify-between transition">
                                            <div>
                                                <div class="font-bold text-xs text-white">{{ $fs['name'] }}</div>
                                                <div class="text-[10px] text-gray-400">🛠️ Servicio</div>
                                            </div>
                                            <span class="font-mono font-bold text-xs text-emerald-400">${{ number_format($fs['default_price'], 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Buscador Predictivo de Repuestos del Inventario -->
                    <div class="relative">
                        <label class="block text-[11px] font-bold text-teal-400 uppercase tracking-wider mb-1.5">📦 Añadir Repuesto del Inventario</label>
                        <input type="text" wire:model.live.debounce.150ms="search_inventory"
                            class="w-full text-xs p-2.5 rounded-xl border border-teal-500/30 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-teal-500"
                            placeholder="Buscar repuesto en stock..." autocomplete="off">

                        @if(count($found_inventory) > 0)
                            <div class="absolute z-30 w-full mt-1.5 overflow-hidden rounded-xl shadow-2xl bg-gray-900 border border-teal-700 divide-y divide-gray-800">
                                <div class="px-3 py-1.5 bg-teal-950/60 flex items-center justify-between text-[10px] text-teal-300 font-bold">
                                    <span>Stock de Inventario</span>
                                    <span>Clic para añadir</span>
                                </div>
                                <ul class="max-h-48 overflow-y-auto">
                                    @foreach($found_inventory as $fi)
                                        <li wire:click="addInventoryItem({{ $fi['id'] }})" class="p-2.5 hover:bg-teal-950/40 cursor-pointer flex items-center justify-between transition">
                                            <div>
                                                <div class="font-bold text-xs text-white">{{ $fi['name'] }}</div>
                                                <div class="text-[10px] text-gray-400">Stock: {{ $fi['stock'] }} uds</div>
                                            </div>
                                            <span class="font-mono font-bold text-xs text-emerald-400">${{ number_format($fi['sale_price'] ?? 0, 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tabla de Ítems -->
                <div class="overflow-x-auto rounded-xl border border-gray-800">
                    <table class="w-full text-xs text-left">
                        <thead>
                            <tr class="bg-gray-950 text-gray-400 font-black uppercase text-[10px] tracking-wider border-b border-gray-800">
                                <th class="p-3">Descripción</th>
                                <th class="p-3 w-32">Tipo</th>
                                <th class="p-3 w-20 text-center">Cant.</th>
                                <th class="p-3 w-32 text-right">P. Unitario ($)</th>
                                <th class="p-3 w-32 text-right">Subtotal ($)</th>
                                <th class="p-3 w-10 text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($items as $index => $item)
                                <tr class="hover:bg-gray-800/40 transition">
                                    <td class="p-2">
                                        <input type="text" wire:model="items.{{ $index }}.description" placeholder="Descripción del ítem..." class="w-full text-xs p-2 rounded-lg border border-gray-800 bg-gray-950 text-white focus:outline-none focus:border-gray-600">
                                    </td>
                                    <td class="p-2">
                                        <select wire:model.live="items.{{ $index }}.type" class="w-full text-xs p-2 rounded-lg border border-gray-800 bg-gray-950 font-bold text-indigo-400 focus:outline-none cursor-pointer">
                                            <option value="servicio">Servicio (M. Obra)</option>
                                            <option value="producto">Producto (Repuesto)</option>
                                        </select>
                                    </td>
                                    <td class="p-2 text-center">
                                        <input type="number" min="1" wire:model.live="items.{{ $index }}.quantity" class="w-16 text-center text-xs p-2 rounded-lg border border-gray-800 bg-gray-950 text-white font-bold focus:outline-none">
                                    </td>
                                    <td class="p-2 text-right">
                                        <input type="number" min="0" step="500" wire:model.live="items.{{ $index }}.unit_price" class="w-full text-right text-xs p-2 rounded-lg border border-gray-800 bg-gray-950 text-emerald-400 font-bold focus:outline-none">
                                    </td>
                                    <td class="p-2 text-right font-mono font-bold text-white text-xs">
                                        ${{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="p-2 text-center">
                                        <button type="button" wire:click="removeItem({{ $index }})" class="p-1.5 text-gray-500 hover:text-red-400 hover:bg-red-950/40 rounded-lg transition cursor-pointer" title="Eliminar ítem">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Bloque Totales & Opciones Fiscales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-800">
                    <div class="space-y-3">
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Observaciones / Notas Internas</label>
                        <textarea wire:model="notes" rows="4" placeholder="Comentarios adicionales para el cliente o plazos de entrega..." class="w-full text-xs p-3 rounded-xl border border-gray-800 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-gray-600 resize-none"></textarea>
                    </div>

                    <div class="bg-gray-950 p-4 rounded-xl space-y-3 text-xs border border-gray-800">
                        <div class="flex justify-between items-center text-gray-400">
                            <span>Suma de Ítems (Bruto/Neto):</span>
                            <span class="font-bold text-white">${{ number_format($subtotal + $discount, 0, ',', '.') }} CLP</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Descuento ($):</span>
                            <input type="number" min="0" wire:model.live="discount" class="w-28 text-right text-xs p-1.5 rounded-lg border border-gray-800 bg-gray-900 text-white font-bold focus:outline-none">
                        </div>

                        <!-- Selector de Opciones Fiscales de IVA -->
                        <div class="pt-2 border-t border-gray-800 space-y-2">
                            <label class="block font-bold text-gray-300 text-[11px] uppercase tracking-wider">Cálculo de IVA (19%):</label>
                            <div class="space-y-1.5 text-xs">
                                <label class="flex items-center gap-2 cursor-pointer text-gray-200 bg-orange-950/30 p-2 rounded-lg border border-orange-500/20">
                                    <input type="radio" wire:model.live="tax_mode" value="labor_only" class="text-orange-500 focus:ring-orange-500">
                                    <span><strong>IVA 19% SOLO a Mano de Obra</strong></span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-gray-400 p-1">
                                    <input type="radio" wire:model.live="tax_mode" value="included" class="text-orange-500 focus:ring-orange-500">
                                    <span>Precios Incluyen IVA</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-gray-400 p-1">
                                    <input type="radio" wire:model.live="tax_mode" value="added" class="text-orange-500 focus:ring-orange-500">
                                    <span>Precios son NETOS (+ 19% IVA)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-gray-400 p-1">
                                    <input type="radio" wire:model.live="tax_mode" value="exempt" class="text-orange-500 focus:ring-orange-500">
                                    <span>Exento de IVA</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-2 border-t border-gray-800 text-gray-400">
                            <span>Monto Neto / Base:</span>
                            <span class="font-bold text-white">${{ number_format($subtotal, 0, ',', '.') }} CLP</span>
                        </div>

                        <div class="flex justify-between items-center text-gray-400">
                            <span>IVA (19%):</span>
                            <span class="font-bold text-orange-400">
                                @if($tax_amount > 0)
                                    +${{ number_format($tax_amount, 0, ',', '.') }} CLP
                                @else
                                    $0 (Exento)
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between items-center pt-3 border-t border-gray-800 font-black text-sm text-white">
                            <span>TOTAL PRESUPUESTO:</span>
                            <span class="text-xl text-orange-400 font-mono">${{ number_format($total, 0, ',', '.') }} CLP</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Términos y Condiciones -->
            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-800 pb-3">
                    <div>
                        <h3 class="font-bold text-white text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Términos, Condiciones y Garantías del Trabajo
                        </h3>
                        <p class="text-xs text-gray-400">Plantillas de garantía rápida predefinidas.</p>
                    </div>

                    <!-- Botones de Presets de Garantía -->
                    <div class="flex flex-wrap items-center gap-1.5">
                        <button type="button" wire:click="setWarrantyPreset('standard')" class="px-2.5 py-1 bg-gray-800 hover:bg-emerald-950/60 hover:text-emerald-400 text-gray-300 text-[11px] font-bold rounded-lg border border-gray-700 transition cursor-pointer">
                            🔰 90 Días / 12 Meses
                        </button>
                        <button type="button" wire:click="setWarrantyPreset('parts_12m')" class="px-2.5 py-1 bg-gray-800 hover:bg-blue-950/60 hover:text-blue-400 text-gray-300 text-[11px] font-bold rounded-lg border border-gray-700 transition cursor-pointer">
                            🛡️ 1 Año Repuestos
                        </button>
                        <button type="button" wire:click="setWarrantyPreset('express_30d')" class="px-2.5 py-1 bg-gray-800 hover:bg-amber-950/60 hover:text-amber-400 text-gray-300 text-[11px] font-bold rounded-lg border border-gray-700 transition cursor-pointer">
                            ⚡ 30 Días Express
                        </button>
                        <button type="button" wire:click="setWarrantyPreset('no_warranty')" class="px-2.5 py-1 bg-gray-800 hover:bg-red-950/60 hover:text-red-400 text-gray-300 text-[11px] font-bold rounded-lg border border-gray-700 transition cursor-pointer">
                            ⚠️ Sin Garantía
                        </button>
                    </div>
                </div>

                <textarea wire:model="terms_and_conditions" rows="5" class="w-full text-xs p-3.5 rounded-xl border border-gray-800 bg-gray-950 text-white placeholder-gray-600 focus:outline-none focus:border-gray-600 leading-relaxed resize-none"></textarea>
            </div>

        </div>

    </div>
</div>
