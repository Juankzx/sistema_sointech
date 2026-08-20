<div class="p-6 max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-700">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-3">
                <span>{{ $quote_id ? 'Editar Cotización' : 'Nueva Cotización Rápida' }}</span>
                <span class="text-xs font-mono font-bold px-2.5 py-1 rounded-full bg-orange-500/10 text-orange-600 dark:bg-orange-500/20 dark:text-orange-300 border border-orange-500/20">
                    N° {{ $quote_number }}
                </span>
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Presupuesto formal de repuestos, servicios y condiciones de garantía.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('quotations.index') }}" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-xl transition">
                ← Volver al Listado
            </a>
            
            <button type="button" wire:click="save('borrador')" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition shadow-sm">
                💾 Guardar Borrador
            </button>

            <button type="button" wire:click="save('enviada')" class="px-5 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white text-xs font-bold rounded-xl shadow-md shadow-orange-500/20 transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Finalizar Cotización
            </button>
        </div>
    </div>

    <!-- Contenido Principal (Grid 2 Columnas) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Columna Izquierda (Datos Cliente y Equipo) -->
        <div class="space-y-6">

            <!-- Card Buscar / Datos Cliente -->
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 space-y-4">
                <h3 class="font-semibold text-slate-800 dark:text-white flex items-center gap-2 text-sm border-b pb-2 border-slate-100 dark:border-slate-700">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Información del Cliente
                </h3>

                <!-- Buscador de Cliente -->
                <div class="relative">
                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Buscar Cliente Registrado</label>
                    <input type="text" wire:model.live.debounce.300ms="search_client" placeholder="Buscar por Nombre, RUT o Teléfono..." class="w-full text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">

                    @if(!empty($found_clients))
                    <div class="absolute z-20 top-full left-0 right-0 mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl max-h-48 overflow-y-auto">
                        @foreach($found_clients as $fc)
                        <button type="button" wire:click="selectClient({{ $fc['id'] }})" class="w-full text-left p-2.5 hover:bg-slate-50 dark:hover:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700/50 transition">
                            <div class="font-bold text-xs text-slate-800 dark:text-white">
                                {{ $fc['full_name'] }} @if(!empty($fc['company_name'])) <span class="text-orange-500 font-semibold">({{ $fc['company_name'] }})</span> @endif
                            </div>
                            <div class="text-[10px] text-slate-400">RUT: {{ $fc['rut_dni'] ?: 'N/A' }} | Tel: {{ $fc['phone'] }}</div>
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                @if($client_id)
                <div class="p-2.5 bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 rounded-xl flex items-center justify-between">
                    <span class="text-xs font-semibold text-blue-700 dark:text-blue-300">Cliente Asociado</span>
                    <button type="button" wire:click="clearClient" class="text-[10px] text-red-500 hover:underline">Desvincular</button>
                </div>
                @endif

                <div class="space-y-3 pt-1">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Nombre Completo / Razón Social <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="client_name" placeholder="Ej: Juan Pérez o Empresa SpA" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('client_name') <span class="text-[11px] text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">RUT / DNI</label>
                            <input type="text" wire:model="client_rut" placeholder="12.345.678-9" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Teléfono</label>
                            <input type="text" wire:model="client_phone" placeholder="+56 9 1234 5678" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Correo Electrónico</label>
                        <input type="email" wire:model="client_email" placeholder="cliente@correo.com" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
                    </div>
                </div>
            </div>

            <!-- Card Datos del Equipo -->
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 space-y-3">
                <h3 class="font-semibold text-slate-800 dark:text-white flex items-center gap-2 text-sm border-b pb-2 border-slate-100 dark:border-slate-700">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Especificaciones del Equipo
                </h3>

                <!-- Selector Tipo de Equipo -->
                <div>
                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Tipo de Equipo</label>
                    <select wire:model.live="device_type" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
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
                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Marca y Modelo / Servicio <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.live.debounce.250ms="brand_model" placeholder="Ej: iPhone 15 Pro, Galaxy Watch 6, iMac 24" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    
                    @if(!empty($found_devices))
                    <div class="absolute z-20 top-full left-0 right-0 mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl max-h-56 overflow-y-auto">
                        @foreach($found_devices as $dev)
                        <button type="button" wire:click="selectDevice('{{ addslashes($dev['brand']) }}', '{{ addslashes($dev['model']) }}', '{{ $dev['device_type'] }}')" class="w-full text-left p-2.5 hover:bg-slate-50 dark:hover:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700/50 transition flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-800 dark:text-white">{{ $dev['brand'] }} {{ $dev['model'] }}</span>
                            <span class="text-[10px] bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-300 px-2 py-0.5 rounded-full font-semibold border border-blue-200 dark:border-blue-800">
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
                    @error('device_info') <span class="text-[11px] text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- N° Serie / IMEI (Opcional) -->
                <div>
                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">N° Serie / IMEI <span class="text-slate-400 font-normal">(Opcional)</span></label>
                    <input type="text" wire:model.live.debounce.300ms="imei_serial" wire:change="syncDeviceInfo" placeholder="Ej: 354892019482..." class="w-full text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
                </div>

                <div class="grid grid-cols-2 gap-2 pt-1">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Válido Hasta</label>
                        <input type="date" wire:model="valid_until" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Estado</label>
                        <select wire:model="status" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
                            <option value="borrador">Borrador</option>
                            <option value="enviada">Enviada</option>
                            <option value="aceptada">Aceptada</option>
                            <option value="rechazada">Rechazada</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <!-- Columna Derecha (Ítems, Precios, Totales y Términos) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Tabla Dinámica de Ítems -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b pb-3 border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-white text-base">Detalle de Repuestos y Servicios</h3>
                        <p class="text-xs text-slate-500">Define el tipo (Servicio o Producto) para aplicar impuestos automáticamente.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" wire:click="addOnDemandPart" class="px-3 py-1.5 bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 hover:bg-amber-100 text-xs font-semibold rounded-lg transition border border-amber-200 dark:border-amber-800 flex items-center gap-1">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            + Repuesto a Pedido
                        </button>

                        <button type="button" wire:click="addItem" class="px-3 py-1.5 bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-400 hover:bg-blue-100 text-xs font-semibold rounded-lg transition flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            + Fila Libre
                        </button>
                    </div>
                </div>

                <!-- Tabla de Ítems -->
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-300 font-semibold uppercase border-b border-slate-100 dark:border-slate-700">
                                <th class="p-3">Descripción</th>
                                <th class="p-3 w-28">Tipo</th>
                                <th class="p-3 w-20 text-center">Cant.</th>
                                <th class="p-3 w-32 text-right">P. Unitario ($)</th>
                                <th class="p-3 w-32 text-right">Subtotal ($)</th>
                                <th class="p-3 w-10 text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @foreach($items as $index => $item)
                            <tr>
                                <td class="p-2">
                                    <input type="text" wire:model="items.{{ $index }}.description" placeholder="Ej: SSD Crucial MX500 500GB 2.5 SATA III" class="w-full text-xs p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
                                </td>
                                <td class="p-2">
                                    <select wire:model.live="items.{{ $index }}.type" class="w-full text-xs p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none font-semibold text-blue-600 dark:text-blue-400">
                                        <option value="servicio">Servicio (M. Obra)</option>
                                        <option value="producto">Producto (Repuesto)</option>
                                    </select>
                                </td>
                                <td class="p-2 text-center">
                                    <input type="number" min="1" wire:model.live="items.{{ $index }}.quantity" class="w-16 text-center text-xs p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
                                </td>
                                <td class="p-2 text-right">
                                    <input type="number" min="0" step="500" wire:model.live="items.{{ $index }}.unit_price" class="w-full text-right text-xs p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
                                </td>
                                <td class="p-2 text-right font-semibold text-slate-800 dark:text-slate-100">
                                    ${{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="p-2 text-center">
                                    <button type="button" wire:click="removeItem({{ $index }})" class="p-1 text-slate-400 hover:text-red-500 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Bloque Totales & Opciones Fiscales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <div class="space-y-3">
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400">Observaciones / Notas Internas</label>
                        <textarea wire:model="notes" rows="3" placeholder="Comentarios adicionales para el cliente o plazos de entrega..." class="w-full text-xs p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none"></textarea>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-900/60 p-4 rounded-xl space-y-3 text-xs">
                        <div class="flex justify-between items-center text-slate-600 dark:text-slate-400">
                            <span>Suma de Ítems (Bruto/Neto):</span>
                            <span class="font-medium">${{ number_format($subtotal + $discount, 0, ',', '.') }} CLP</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-slate-600 dark:text-slate-400">Descuento ($):</span>
                            <input type="number" min="0" wire:model.live="discount" class="w-28 text-right text-xs p-1 rounded border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white">
                        </div>

                        <!-- Selector de Opciones Fiscales de IVA -->
                        <div class="pt-2 border-t border-slate-200 dark:border-slate-700 space-y-1.5">
                            <label class="block font-bold text-slate-700 dark:text-slate-300 text-[11px] uppercase tracking-wider">Cálculo de IVA (19%):</label>
                            <div class="space-y-1.5 text-xs">
                                <label class="flex items-center gap-2 cursor-pointer text-slate-800 dark:text-slate-200 bg-orange-50 dark:bg-orange-950/30 p-2 rounded-lg border border-orange-200 dark:border-orange-800/50">
                                    <input type="radio" wire:model.live="tax_mode" value="labor_only" class="text-orange-600 focus:ring-orange-500">
                                    <span><strong>IVA 19% SOLO a Mano de Obra</strong> (Repuestos sin recargo)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-slate-700 dark:text-slate-300 p-1">
                                    <input type="radio" wire:model.live="tax_mode" value="included" class="text-orange-600 focus:ring-orange-500">
                                    <span><strong>Precios Incluyen IVA</strong> (Total Bruto Fijo)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-slate-700 dark:text-slate-300 p-1">
                                    <input type="radio" wire:model.live="tax_mode" value="added" class="text-orange-600 focus:ring-orange-500">
                                    <span><strong>Precios son NETOS</strong> (+ 19% IVA a todo)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-slate-700 dark:text-slate-300 p-1">
                                    <input type="radio" wire:model.live="tax_mode" value="exempt" class="text-orange-600 focus:ring-orange-500">
                                    <span><strong>Exento de IVA</strong> (Sin impuesto)</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-2 border-t border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400">
                            <span>Monto Neto / Base:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">${{ number_format($subtotal, 0, ',', '.') }} CLP</span>
                        </div>

                        <div class="flex justify-between items-center text-slate-600 dark:text-slate-400">
                            <span>IVA (19%):</span>
                            <span class="font-semibold text-orange-600 dark:text-orange-400">
                                @if($tax_amount > 0)
                                    +${{ number_format($tax_amount, 0, ',', '.') }} CLP
                                    <span class="text-[10px] text-slate-400">({{ $tax_mode === 'labor_only' ? 'Solo M. Obra' : ($tax_mode === 'included' ? 'Incluido' : 'Adicionado') }})</span>
                                @else
                                    $0 (Exento)
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between items-center pt-3 border-t-2 border-slate-300 dark:border-slate-600 font-bold text-base text-slate-900 dark:text-white">
                            <span>TOTAL PRESUPUESTO:</span>
                            <span class="text-orange-600 dark:text-orange-400">${{ number_format($total, 0, ',', '.') }} CLP</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Términos y Condiciones -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b pb-3 border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-white flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Términos, Condiciones y Garantías del Trabajo
                        </h3>
                        <p class="text-xs text-slate-400">Selecciona una plantilla de garantía rápida o edita libremente los términos.</p>
                    </div>

                    <!-- Botones de Presets de Garantía -->
                    <div class="flex flex-wrap items-center gap-1.5">
                        <button type="button" wire:click="setWarrantyPreset('standard')" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-700 hover:bg-emerald-500/10 hover:text-emerald-500 text-slate-600 dark:text-slate-300 text-[11px] font-semibold rounded-lg border border-slate-200 dark:border-slate-600 transition">
                            🔰 90 Días / 12 Meses
                        </button>
                        <button type="button" wire:click="setWarrantyPreset('parts_12m')" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-700 hover:bg-blue-500/10 hover:text-blue-500 text-slate-600 dark:text-slate-300 text-[11px] font-semibold rounded-lg border border-slate-200 dark:border-slate-600 transition">
                            🛡️ 1 Año Repuestos
                        </button>
                        <button type="button" wire:click="setWarrantyPreset('express_30d')" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-700 hover:bg-amber-500/10 hover:text-amber-500 text-slate-600 dark:text-slate-300 text-[11px] font-semibold rounded-lg border border-slate-200 dark:border-slate-600 transition">
                            ⚡ 30 Días Express
                        </button>
                        <button type="button" wire:click="setWarrantyPreset('no_warranty')" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-700 hover:bg-red-500/10 hover:text-red-500 text-slate-600 dark:text-slate-300 text-[11px] font-semibold rounded-lg border border-slate-200 dark:border-slate-600 transition">
                            ⚠️ Sin Garantía
                        </button>
                    </div>
                </div>

                <textarea wire:model="terms_and_conditions" rows="6" class="w-full text-xs p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white outline-none leading-relaxed focus:ring-2 focus:ring-emerald-500" placeholder="Especifica vigencia del presupuesto, plazo de llegada de repuestos a pedido, garantía de repuestos y mano de obra, etc."></textarea>
            </div>

        </div>

    </div>
</div>
