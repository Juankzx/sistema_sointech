<div class="max-w-3xl mx-auto pb-20">
    <div class="rounded-3xl shadow-2xl overflow-hidden border border-white/5" style="background: #0D1117;">

        <!-- Header Premium con gradiente teal -->
        <div class="relative overflow-hidden px-6 py-6 border-b border-white/5" style="background: linear-gradient(135deg, #0a1628 0%, #0d2137 40%, #083d35 100%);">
            <!-- Patrón de fondo sutil -->
            <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 1px 1px, rgba(0,198,182,0.6) 1px, transparent 0); background-size: 24px 24px;"></div>
            <!-- Glow orbs -->
            <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(0,198,182,0.12) 0%, transparent 70%);"></div>
            <div class="absolute -bottom-6 -left-6 w-32 h-32 rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(0,150,255,0.08) 0%, transparent 70%);"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest border" style="background: rgba(0,198,182,0.1); color: #00C6B6; border-color: rgba(0,198,182,0.25);">Sointech • Taller</span>
                    </div>
                    <h2 class="text-2xl font-black tracking-tight" style="color: #f0fffe;">Nueva Orden de Trabajo</h2>
                    <p class="text-xs mt-1" style="color: rgba(180,210,205,0.7);">Registra el ingreso formal de un equipo y protege tu taller ante reclamos.</p>
                </div>
                <div class="shrink-0 w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg" style="background: rgba(0,198,182,0.12); border: 1px solid rgba(0,198,182,0.2);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #00C6B6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
        </div>

        @if(session()->has('error'))
            <div class="m-6 mb-0 p-4 rounded-xl text-sm font-bold animate-fade-in flex items-center gap-2" style="background: rgba(239,68,68,0.1); border-left: 3px solid #ef4444; color: #fca5a5;">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="p-6 space-y-8 text-gray-300">

            <!-- SECCIÓN 1: DATOS DEL CLIENTE -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 pb-2.5" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center" style="background: rgba(0,198,182,0.1); border: 1px solid rgba(0,198,182,0.2);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #00C6B6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black tracking-tight" style="color: #00C6B6;">Datos del Cliente</h3>
                        <p class="text-[10px]" style="color: rgba(156,163,175,0.7);">Busca uno existente o ingresa nuevo cliente en caliente</p>
                    </div>
                </div>

                @if(!$client_selected)
                    <!-- Buscar Cliente Existente -->
                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Buscar Cliente Registrado</label>
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="searchClient" class="w-full bg-gray-700 border border-gray-600 rounded-2xl pl-10 pr-4 py-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Escribe nombre, RUT/DNI o teléfono del cliente...">
                            <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                        </div>
                        
                        @if(count($foundClients) > 0)
                            <div class="absolute z-10 w-full mt-1 bg-gray-800 border border-gray-700 rounded-2xl shadow-xl overflow-hidden animate-fade-in">
                                <ul>
                                    @foreach($foundClients as $fc)
                                        <li wire:click="selectClient({{ $fc->id }})" class="p-3.5 hover:bg-gray-750 cursor-pointer border-b border-gray-700/60 last:border-0 flex justify-between items-center transition">
                                            <div>
                                                <div class="font-bold text-white text-sm">{{ $fc->full_name }}</div>
                                                <div class="text-xs text-gray-400 mt-0.5">📞 {{ $fc->phone }} • 📄 {{ $fc->rut_dni ?: 'Sin RUT/DNI' }}</div>
                                            </div>
                                            <span class="text-[10px] bg-blue-500/10 text-blue-400 border border-blue-500/20 font-bold px-2 py-0.5 rounded-full uppercase">Seleccionar</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Alerta de Cliente Nuevo -->
                    <div class="bg-blue-950/20 border border-blue-800/30 px-4 py-3.5 rounded-2xl flex items-center gap-2.5 text-blue-300 text-xs">
                        <svg class="w-4.5 h-4.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span><strong>✨ Registro Automático:</strong> Si completas los campos a continuación, el cliente se creará en caliente al guardar la orden.</span>
                    </div>

                    <!-- Campos de Entrada -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 animate-fade-in">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre Completo *</label>
                            <input type="text" wire:model="full_name" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Teléfono / WhatsApp *</label>
                            <input type="text" wire:model="phone" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: +56912345678" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">RUT / DNI</label>
                            <input type="text" wire:model="rut_dni" 
                                x-data x-on:input="$el.value = window.formatRut($el.value); $dispatch('input', $el.value)"
                                class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Email</label>
                            <input type="email" wire:model="email" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                @else
                    <!-- Tarjeta Premium de Cliente Seleccionado -->
                    <div class="bg-gray-900 border border-gray-700 rounded-3xl p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-inner animate-fade-in">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-black text-lg shadow-md shadow-blue-500/20 uppercase">
                                {{ substr($full_name, 0, 2) }}
                            </div>
                            <div>
                                <h4 class="font-black text-white text-base tracking-tight">{{ $full_name }}</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4 gap-y-1 text-xs text-gray-400 mt-1">
                                    <span>📞 <strong>Tel:</strong> {{ $phone }}</span>
                                    <span>📄 <strong>DNI:</strong> {{ $rut_dni ?: 'N/A' }}</span>
                                    <span class="truncate">✉️ <strong>Email:</strong> {{ $email ?: 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex gap-2 w-full md:w-auto shrink-0 justify-end">
                            <button type="button" wire:click="toggleClientEditing" class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-bold rounded-xl text-xs transition border border-gray-700 cursor-pointer">
                                {{ $client_editing ? '💾 Cerrar Edición' : '✏️ Editar Datos' }}
                            </button>
                            <button type="button" wire:click="clearClientSelection" class="px-4 py-2.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 font-bold rounded-xl text-xs transition border border-red-500/20 cursor-pointer">
                                🔄 Cambiar
                            </button>
                        </div>
                    </div>

                    <!-- Campos Editables in-situ si se activa -->
                    @if($client_editing)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-900/40 p-5 rounded-3xl border border-gray-750 animate-fade-in">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre Completo *</label>
                                <input type="text" wire:model="full_name" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Teléfono / WhatsApp *</label>
                                <input type="text" wire:model="phone" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">RUT / DNI</label>
                                <input type="text" wire:model="rut_dni" 
                                    x-data x-on:input="$el.value = window.formatRut($el.value); $dispatch('input', $el.value)"
                                    class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Email</label>
                                <input type="email" wire:model="email" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- SECCIÓN 2: DATOS DEL EQUIPO -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 pb-2.5" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center" style="background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.2);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #818cf8;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black tracking-tight" style="color: #818cf8;">Datos del Equipo</h3>
                        <p class="text-[10px]" style="color: rgba(156,163,175,0.7);">Tipo, modelo, IMEI y falla reportada</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Tipo de Equipo *</label>
                        <select wire:model.live="device_type" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="smartphone">📱 Smartphone</option>
                            <option value="notebook">💻 Notebook / PC</option>
                            <option value="desktop">🖥️ PC de Escritorio (Torre)</option>
                            <option value="tablet">📟 Tablet</option>
                            <option value="console">🎮 Consola de Videojuegos</option>
                            <option value="other">⚙️ Otro Tipo</option>
                        </select>
                    </div>
                    
                    <!-- Marca y Modelo con Predictivo -->
                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Marca y Modelo *</label>
                        <input type="text" wire:model.live="brand_model" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: iPhone 13 Pro" autocomplete="off" required>
                        
                        <!-- Sugerencias del Catálogo Predictivo -->
                        @if(count($foundDevices) > 0)
                            <div class="absolute z-10 w-full mt-1 bg-gray-800 border border-gray-700 rounded-2xl shadow-xl overflow-hidden">
                                <ul>
                                    @foreach($foundDevices as $device)
                                        <li wire:click="selectDevice('{{ $device->brand }}', '{{ $device->model }}')" class="p-3 hover:bg-gray-750 cursor-pointer border-b border-gray-700/60 last:border-0 flex items-center justify-between text-xs transition">
                                            <span class="font-bold text-white">{{ $device->brand }} {{ $device->model }}</span>
                                            <span class="text-[9px] bg-gray-900/60 text-gray-400 px-2 py-0.5 rounded-full">Sugerido</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">IMEI / Número de Serie</label>
                        <input type="text" wire:model="imei_serial" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nº Serie físico para identificación">
                    </div>
                    <div x-data="{ showPatternDrawer: false }">
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Clave / PIN de Desbloqueo</label>
                            <!-- Pattern Toggle Button -->
                            <button type="button" @click="showPatternDrawer = !showPatternDrawer" class="text-[10px] text-blue-400 hover:text-blue-300 font-black flex items-center gap-1 transition focus:outline-none">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <span x-text="showPatternDrawer ? 'Ocultar Patrón' : 'Dibujar Patrón'"></span>
                            </button>
                        </div>
                        <input type="text" wire:model="unlock_password" id="unlock_password" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Patrón de Z o 1234">

                        <!-- Interactive Pattern Lock Drawer -->
                        <div x-show="showPatternDrawer" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="bg-gray-900 border border-gray-700 rounded-3xl p-5 mt-3 space-y-4 relative overflow-hidden" x-data="patternLock()">
                            <!-- Glowing details -->
                            <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>
                            
                            <div class="flex justify-between items-center border-b border-gray-800 pb-2">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Dibujador de Patrón Interactivo</span>
                                <div class="flex gap-2">
                                    <button type="button" @click="clearPattern" class="px-2.5 py-1 bg-gray-800 hover:bg-gray-750 text-gray-300 rounded-lg text-[10px] font-bold border border-gray-700 transition">
                                        Borrar
                                    </button>
                                    <button type="button" @click="applyPattern" class="px-2.5 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-[10px] font-bold transition">
                                        Aplicar Patrón
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-col items-center justify-center gap-6 py-2">
                                <!-- 3x3 interactive dot matrix (Bulletproof Inline-sized CSS Grid) -->
                                <div class="relative bg-gray-950/90 rounded-3xl border border-gray-800 grid grid-cols-3 grid-rows-3 gap-3 p-4 select-none touch-none"
                                     style="width: 220px; height: 220px; min-width: 220px; min-height: 220px;"
                                     @mousedown="startDrawing"
                                     @mousemove="draw"
                                     @mouseup="stopDrawing"
                                     @mouseleave="stopDrawing"
                                     @touchstart="startDrawing"
                                     @touchmove="draw"
                                     @touchend="stopDrawing"
                                     id="pattern-matrix">
                                    
                                    <!-- Dynamic Lines Canvas -->
                                    <canvas id="pattern-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-10"></canvas>
                                    
                                    <!-- 9 Dots -->
                                    <template x-for="i in 9" :key="i">
                                        <div class="flex items-center justify-center relative cursor-pointer z-20" style="width: 100%; height: 100%;" :data-index="i">
                                            <!-- Android Style Dot Container -->
                                            <div class="w-12 h-12 flex items-center justify-center rounded-full transition-all duration-150"
                                                 :class="isDotSelected(i) ? 'bg-orange-500/20 ring-2 ring-orange-500/40 scale-110 shadow-lg shadow-orange-500/10' : 'hover:bg-gray-800/40 scale-100'">
                                                <!-- Inner Core Dot -->
                                                <div class="w-3.5 h-3.5 rounded-full transition-all duration-150"
                                                     :class="isDotSelected(i) ? 'bg-orange-500 shadow-lg shadow-orange-500/80 scale-110' : 'bg-gray-600 scale-100'"></div>
                                            </div>
                                            
                                            <!-- Tiny Index number watermark -->
                                            <span class="absolute text-[8px] text-gray-700/60 font-mono font-bold select-none pointer-events-none" style="transform: translateY(18px);" x-text="i"></span>
                                        </div>
                                    </template>
                                </div>

                                <!-- Live visual preview of sequence -->
                                <div class="flex flex-col items-center space-y-3.5 text-center shrink-0 w-full border-t border-gray-800/65 pt-4">
                                    <div>
                                        <div class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Secuencia del Patrón</div>
                                        <div class="text-sm font-black text-orange-500 font-mono tracking-wide mt-1 min-h-[20px]" x-text="getPatternText()"></div>
                                    </div>
                                    <div class="text-[10px] text-gray-400 max-w-[220px] leading-relaxed">
                                        Arrastra tu ratón o dedo conectando los puntos para trazar el patrón de desbloqueo del equipo.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Falla Reportada por el Cliente *</label>
                    <textarea wire:model="reported_issue" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3.5 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="2.5" placeholder="Describe los síntomas y problemas reportados..." required></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Estado de Ingreso Inicial *</label>
                        <select wire:model="initial_status" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Ingresado">Ingresado (En cola de espera)</option>
                            <option value="En Revisión">En Revisión (Pasa directo a diagnóstico)</option>
                            <option value="Aprobado">Aprobado (Pasa a reparación directa)</option>
                            <option value="Garantía">Garantía (Reingreso por revisión)</option>
                        </select>
                        <span class="text-[10px] text-gray-400 mt-1 block">Elige si el equipo queda en espera o pasa directo a manos del técnico.</span>
                    </div>
                </div>

                <!-- SUB-SECTION: COMPONENTES PC (Conditional) -->
                <div x-show="['desktop', 'notebook', 'other'].includes($wire.device_type)" x-transition class="mt-6 p-5 rounded-2xl bg-gray-900/50 border border-gray-700/50">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-sm font-bold text-blue-400">Componentes de Hardware</h4>
                            <p class="text-[10px] text-gray-500">Registra CPU, GPU, RAM, Discos, etc. para evitar reclamos.</p>
                        </div>
                        <button type="button" wire:click="addComponent" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-[10px] font-bold transition">
                            + Agregar Componente
                        </button>
                    </div>

                    @if(count($components) > 0)
                        <div class="space-y-3">
                            @foreach($components as $index => $comp)
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 items-center bg-gray-800/40 p-2 rounded-xl border border-gray-700/80">
                                    <div class="sm:col-span-3">
                                        <select wire:model="components.{{ $index }}.type" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-xs focus:ring-1 focus:ring-blue-500">
                                            <option value="cpu">CPU / Procesador</option>
                                            <option value="gpu">Tarjeta de Video (GPU)</option>
                                            <option value="ram">Memoria RAM</option>
                                            <option value="storage">Disco Duro / SSD</option>
                                            <option value="motherboard">Placa Madre</option>
                                            <option value="psu">Fuente de Poder</option>
                                            <option value="case">Gabinete / Carcasa</option>
                                            <option value="cooler">Refrigeración / Cooler</option>
                                            <option value="keyboard">Teclado</option>
                                            <option value="mouse">Ratón / Mouse</option>
                                            <option value="other">Otro Accesorio</option>
                                        </select>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <input type="text" wire:model="components.{{ $index }}.brand" placeholder="Marca (Ej: Intel)" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-xs focus:ring-1 focus:ring-blue-500">
                                    </div>
                                    <div class="sm:col-span-3">
                                        <input type="text" wire:model="components.{{ $index }}.model" placeholder="Modelo o Capacidad" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-xs focus:ring-1 focus:ring-blue-500">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <input type="text" wire:model="components.{{ $index }}.serial_number" placeholder="Nº Serie" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-xs focus:ring-1 focus:ring-blue-500">
                                    </div>
                                    <div class="sm:col-span-1 flex justify-end">
                                        <button type="button" wire:click="removeComponent({{ $index }})" class="p-1.5 text-gray-500 hover:text-red-400 hover:bg-gray-700 rounded-lg transition" title="Eliminar componente">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-4 border border-dashed border-gray-700 rounded-xl">
                            <span class="text-gray-500 text-xs">No se han registrado componentes adicionales.</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SECCIÓN 3: CHECKLIST DE INGRESO PARAMETRIZABLE -->
            <div class="p-5 rounded-2xl" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06);">
                <div class="flex items-center gap-3 pb-3 mb-4" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #fbbf24;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black tracking-tight" style="color: #fbbf24;">Checklist y Estado Inicial</h3>
                        <p class="text-[10px]" style="color: rgba(156,163,175,0.7);">Condición física y funcional del equipo al recibirlo</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="flex items-center">
                        <label class="flex items-center space-x-2.5 cursor-pointer">
                            <input type="checkbox" wire:model="turns_on" class="w-5 h-5 text-blue-500 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-200">¿El equipo enciende al recibirlo?</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">¿Tiene sospecha de contacto con líquido?</label>
                        <select wire:model="liquid_contact" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-2.5 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>No</option>
                            <option>Sí</option>
                            <option>No sabe / Mojado anteriormente</option>
                        </select>
                    </div>
                </div>

                <!-- checklist_values cargados dinámicamente desde BD de configuraciones -->
                @if(count($checklist_values) > 0)
                    <div class="space-y-2 mb-4">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Pruebas Funcionales Realizadas (Desmarca las que fallan)</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            @foreach($checklist_values as $item => $checked)
                                @php
                                    $icon = '<svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                                    $i = strtolower($item);
                                    if (str_contains($i, 'enciende')) $icon = '⚡';
                                    elseif (str_contains($i, 'face id') || str_contains($i, 'touch id')) $icon = '👁️';
                                    elseif (str_contains($i, 'líquido')) $icon = '💧';
                                    elseif (str_contains($i, 'cámara')) $icon = '📷';
                                    elseif (str_contains($i, 'micrófono')) $icon = '🎤';
                                    elseif (str_contains($i, 'parlante') || str_contains($i, 'auricular')) $icon = '🔊';
                                    elseif (str_contains($i, 'wi-fi') || str_contains($i, 'bluetooth')) $icon = '📶';
                                    elseif (str_contains($i, 'botones')) $icon = '🔘';
                                    elseif (str_contains($i, 'carga')) $icon = '🔋';
                                    elseif (str_contains($i, 'nfc')) $icon = '📡';
                                    elseif (str_contains($i, 'táctil') || str_contains($i, 'pantalla')) $icon = '🖐️';
                                @endphp
                                <label class="flex items-center space-x-2.5 cursor-pointer bg-gray-800/40 p-3 rounded-2xl border border-gray-700 hover:border-gray-650 hover:bg-gray-800/80 transition-all duration-150">
                                    <input type="checkbox" wire:model="checklist_values.{{ $item }}" class="w-4.5 h-4.5 text-blue-500 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 cursor-pointer">
                                    <span class="text-xs font-bold text-gray-200 truncate flex items-center gap-1.5"><span class="text-base">{!! $icon !!}</span> {{ $item }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">📸 Fotos del Estado Inicial (Opcional, máx 3)</label>
                    <div class="flex items-center gap-4">
                        <label class="flex-shrink-0 cursor-pointer bg-gray-800 border border-gray-700 hover:border-blue-500 text-blue-400 p-4 rounded-2xl flex flex-col items-center justify-center gap-2 transition duration-200 w-32 h-24">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-xs font-bold">Subir Fotos</span>
                            <input type="file" wire:model="initialPhotos" multiple accept="image/*" class="hidden">
                        </label>
                        
                        <!-- Previews -->
                        <div class="flex flex-wrap gap-3 flex-1">
                            @if($initialPhotos)
                                @foreach($initialPhotos as $photo)
                                    <div class="w-24 h-24 rounded-2xl border border-gray-700 overflow-hidden relative">
                                        <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @error('initialPhotos.*') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Daños Físicos o Notas Estéticas (Importante para proteger el taller)</label>
                    <textarea wire:model="aesthetic_notes" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="2" placeholder="Ej: Pantalla rayada, bisagra suelta, trizado en parte trasera, falta tornillo inferior izquierdo..."></textarea>
                </div>
            </div>

            <!-- SECCIÓN 4: PRESUPUESTO U OPCIÓN DE REVISIÓN -->
            <div>
                <div class="flex items-center gap-3 pb-2.5 mb-4" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center" style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #34d399;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black tracking-tight" style="color: #34d399;">Presupuesto del Servicio</h3>
                        <p class="text-[10px]" style="color: rgba(156,163,175,0.7);">Repuestos, mano de obra y abono inicial (oculto al cliente)</p>
                    </div>
                </div>

                <!-- Tabs Tipo de Presupuesto -->
                <div class="flex gap-2 p-1.5 bg-gray-950 rounded-2xl border border-gray-800 mb-4 w-fit">
                    <button type="button" wire:click="$set('budget_type', 'fixed')" class="px-4 py-2 rounded-xl text-xs font-bold transition duration-150 {{ $budget_type === 'fixed' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white' }}">
                        💰 Presupuesto Fijo
                    </button>
                    <button type="button" wire:click="$set('budget_type', 'pending')" class="px-4 py-2 rounded-xl text-xs font-bold transition duration-150 {{ $budget_type === 'pending' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white' }}">
                        🔍 Por Diagnosticar (Solo Revisión)
                    </button>
                </div>

                @if($budget_type === 'pending')
                    <!-- Tarjeta Modo Diagnóstico sin presupuesto -->
                    <div class="bg-blue-950/20 border border-blue-800/30 p-5 rounded-3xl flex items-start gap-4 text-blue-300 text-xs animate-fade-in">
                        <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <strong class="text-sm font-bold text-white block mb-1">💡 Modo Diagnóstico Técnico Activado</strong>
                            <p class="leading-relaxed">Se registrará la orden con costos de mano de obra y repuestos en <strong>$0</strong>. El equipo ingresará bajo un estado de "Por Diagnosticar" y podrás elaborar y cargar el presupuesto detallado más tarde de forma digital en la bitácora una vez que el técnico en el taller desarme y evalúe la solución.</p>
                        </div>
                    </div>
                @else
                    <!-- Presupuestador normal (Mano de obra, repuestos, etc) -->
                    <div class="space-y-4 animate-fade-in">
                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Agregar Repuesto del Inventario</label>
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="searchPart" class="w-full bg-gray-700 border border-gray-600 rounded-2xl pl-10 pr-4 py-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar repuestos por nombre, categoría o código...">
                                <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-400">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                            </div>
                            
                            @if(count($foundParts) > 0)
                                <div class="absolute z-10 w-full mt-1 bg-gray-800 border border-gray-700 rounded-2xl shadow-xl overflow-hidden animate-fade-in">
                                    <ul>
                                        @foreach($foundParts as $fp)
                                            <li wire:click="addPart({{ $fp->id }})" class="p-3 hover:bg-gray-750 cursor-pointer border-b border-gray-700/60 last:border-0 flex justify-between items-center transition">
                                                <div>
                                                    <div class="font-bold text-white text-sm">{{ $fp->name }}</div>
                                                    <div class="text-xs text-gray-400 mt-0.5">{{ $fp->category }} • Stock: {{ $fp->stock }}</div>
                                                </div>
                                                <div class="text-green-400 font-bold text-sm">${{ number_format($fp->sale_price, 0, ',', '.') }}</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <!-- Lista de repuestos seleccionados -->
                        @if(count($selected_parts) > 0)
                            <div class="bg-gray-900 border border-gray-700 rounded-2xl p-4 space-y-2 animate-fade-in">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1 mb-2">Repuestos Añadidos</h4>
                                <ul class="space-y-1.5">
                                    @foreach($selected_parts as $index => $part)
                                        <li class="flex justify-between items-center py-2 px-3 bg-gray-800/40 rounded-xl border border-gray-700 text-xs">
                                            <span class="font-bold text-gray-200">{{ $part['name'] }}</span>
                                            <div class="flex items-center space-x-4">
                                                <span class="font-semibold text-green-400">${{ number_format($part['sale_price'], 0, ',', '.') }}</span>
                                                <button type="button" wire:click="removePart({{ $index }})" class="text-gray-500 hover:text-red-400 p-1 rounded transition" title="Remover repuesto">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Costo Mano de Obra ($)</label>
                                <input type="number" wire:model.live="labor_cost" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3.5 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="bg-blue-900/30 border border-blue-500 rounded-2xl p-4 flex justify-between items-center">
                                <span class="text-xs font-bold text-blue-200">PRESUPUESTO ESTIMADO</span>
                                <span class="text-xl font-black text-white">${{ number_format($this->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Tiempo Estimado de Entrega</label>
                            <input type="text" wire:model="estimated_delivery" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: 2 a 3 días hábiles">
                            <span class="text-[10px] text-gray-400 mt-1 block">Aparecerá en el comprobante del cliente.</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Abono Inicial (Dejar en 0 si no paga nada hoy)</label>
                                <input type="number" wire:model.live="down_payment" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Método de Pago</label>
                                <select wire:model="payment_method" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option>Efectivo</option>
                                    <option>Transferencia</option>
                                    <option>Débito/Crédito</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="bg-gray-900 border border-gray-700 rounded-2xl p-4 flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-400">Saldo Pendiente:</span>
                            <span class="text-xl font-black {{ $this->balance > 0 ? 'text-yellow-400' : 'text-green-400' }}">
                                ${{ number_format($this->balance, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- SECCIÓN 5: FIRMA Y TÉRMINOS LEGALES -->
            <div
                x-data="{
                    signMode: @if($signature_token) 'qr' @elseif($signature_base64) 'done' @else null @endif,
                    setMode(m) { this.signMode = m; }
                }"
                class="pt-6 border-t border-gray-700/80 space-y-5"
                @if($signature_token) wire:poll.keep-alive.2s="checkSignatureStatus" @endif
            >
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-blue-400 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-xs">5</span>
                        Firma Legal y Términos
                    </h3>
                    <!-- Botón volver si hay modo activo y no hay firma guardada -->
                    <button
                        type="button"
                        x-show="signMode !== null && signMode !== 'done'"
                        @click="signMode = null; $wire.cancelSignatureSession()"
                        class="text-[10px] text-gray-500 hover:text-gray-300 flex items-center gap-1 transition cursor-pointer"
                    >
                        ← Cambiar método
                    </button>
                </div>

                @if(session()->has('signature_success'))
                    <div class="p-4 bg-emerald-950/40 border-l-4 border-emerald-500 rounded-r-xl text-emerald-300 text-xs font-bold animate-fade-in flex items-center gap-2">
                        ✨ {{ session('signature_success') }}
                    </div>
                @endif

                <!-- Condiciones Legales -->
                <div class="bg-gray-900 border border-gray-700 rounded-2xl p-4 shadow-inner">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Condiciones Legales de Recepción (Editable en configuración)</p>
                    <p class="text-xs font-medium text-gray-300 italic leading-relaxed font-sans">
                        "{{ \App\Models\Setting::find(1)->warranty_text ?? 'Garantía exclusiva por fallas de funcionamiento de la pieza reemplazada. No cubre daños por golpes, presión o humedad.' }}"
                    </p>
                </div>

                <!-- ══════════════════════════════════════════════ -->
                <!-- MODO: Selección inicial — sin modo elegido aún -->
                <!-- ══════════════════════════════════════════════ -->
                <div x-show="signMode === null" class="space-y-3 animate-fade-in">
                    <p class="text-xs text-gray-400 font-semibold text-center">¿Cómo deseas capturar la firma del cliente?</p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Opción 1: QR al celular -->
                        <button
                            type="button"
                            @click="setMode('qr'); $wire.generateSignatureToken()"
                            class="group flex flex-col items-center gap-3 p-5 bg-gray-900/60 hover:bg-blue-950/30 border border-gray-700 hover:border-blue-500/50 rounded-2xl transition-all duration-200 cursor-pointer text-center"
                        >
                            <span class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 group-hover:bg-blue-500/20 flex items-center justify-center text-2xl transition">📲</span>
                            <div>
                                <div class="text-xs font-black text-white group-hover:text-blue-300 transition">Enviar por QR</div>
                                <div class="text-[10px] text-gray-500 mt-0.5 leading-relaxed">El cliente firma desde su celular escaneando un código QR</div>
                            </div>
                        </button>

                        <!-- Opción 2: Kiosco / Tablet -->
                        <button
                            type="button"
                            @click="setMode('kiosk'); $wire.toggleKioskMode()"
                            class="group flex flex-col items-center gap-3 p-5 bg-gray-900/60 hover:bg-indigo-950/30 border border-gray-700 hover:border-indigo-500/50 rounded-2xl transition-all duration-200 cursor-pointer text-center"
                        >
                            <span class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 group-hover:bg-indigo-500/20 flex items-center justify-center text-2xl transition">🖥️</span>
                            <div>
                                <div class="text-xs font-black text-white group-hover:text-indigo-300 transition">Tablet / Kiosco</div>
                                <div class="text-[10px] text-gray-500 mt-0.5 leading-relaxed">Gira la pantalla o usa una tablet para que el cliente firme</div>
                            </div>
                        </button>

                        <!-- Opción 3: Firma en mostrador -->
                        <button
                            type="button"
                            @click="setMode('counter')"
                            class="group flex flex-col items-center gap-3 p-5 bg-gray-900/60 hover:bg-emerald-950/30 border border-gray-700 hover:border-emerald-500/50 rounded-2xl transition-all duration-200 cursor-pointer text-center"
                        >
                            <span class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 group-hover:bg-emerald-500/20 flex items-center justify-center text-2xl transition">✍️</span>
                            <div>
                                <div class="text-xs font-black text-white group-hover:text-emerald-300 transition">Firmar aquí</div>
                                <div class="text-[10px] text-gray-500 mt-0.5 leading-relaxed">El cliente firma directamente con el mouse o el dedo en esta pantalla</div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- ═══════════════════════════════════ -->
                <!-- MODO QR: Panel de espera con QR     -->
                <!-- ═══════════════════════════════════ -->
                @if($signature_token)
                <div x-show="signMode === 'qr'" class="bg-blue-950/20 border border-blue-800/30 p-6 rounded-3xl space-y-4 animate-fade-in text-center">
                    <div class="flex items-center justify-center gap-2 text-xs font-bold text-blue-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-ping"></span>
                        <span>ESPERANDO FIRMA DEL CLIENTE DESDE SU MÓVIL...</span>
                    </div>

                    <div class="py-2">
                        <canvas
                            id="mobile-signature-qr"
                            x-init="new QRious({ element: $el, value: '{{ route('client.signature', ['token' => $signature_token]) }}', size: 180 })"
                            class="mx-auto border-4 border-white rounded-2xl bg-white shadow-xl shadow-blue-500/5"
                        ></canvas>
                    </div>

                    <div class="text-[10px] text-gray-400 space-y-2">
                        <p>Indica al cliente que escanee el código QR con la cámara de su celular para leer los términos y firmar con su dedo.</p>
                        <div class="flex gap-2 justify-center flex-wrap">
                            <button type="button" onclick="navigator.clipboard.writeText('{{ route('client.signature', ['token' => $signature_token]) }}'); alert('Enlace de firma copiado!');" class="px-3 py-1.5 bg-gray-800 hover:bg-gray-700 rounded-xl text-white font-bold cursor-pointer border border-gray-700">
                                📋 Copiar Enlace
                            </button>
                            <button type="button" wire:click="cancelSignatureSession" @click="signMode = null" class="px-3 py-1.5 bg-red-950/40 hover:bg-red-900/40 rounded-xl text-red-400 font-bold cursor-pointer border border-red-900/20">
                                ❌ Cancelar Sesión
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                <!-- ════════════════════════════════════════ -->
                <!-- MODO MOSTRADOR: Canvas de firma local    -->
                <!-- ════════════════════════════════════════ -->
                <div x-show="signMode === 'counter' && !{{ $signature_base64 ? 'true' : 'false' }}" x-data="signaturePad()" class="space-y-3 animate-fade-in">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Firma del Cliente — Aquí en Mostrador</label>
                    <div class="bg-white rounded-2xl border-2 border-dashed border-gray-300 w-full h-48 relative overflow-hidden touch-none shadow-md">
                        <canvas id="signature-pad" class="w-full h-full rounded-2xl cursor-crosshair"></canvas>
                        <button type="button" @click="clearPad" class="absolute bottom-2.5 right-2.5 bg-gray-900 hover:bg-gray-800 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl border border-gray-700 transition cursor-pointer">
                            Limpiar Firma
                        </button>
                    </div>
                    <p class="text-[10px] text-gray-500 text-center">Pídele al cliente que dibuje su firma con el dedo o el mouse dentro del recuadro blanco.</p>
                    <button
                        type="button"
                        @click="savePad(); if($wire.get('signature_base64')) { signMode = 'done'; }"
                        class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-xl text-xs transition cursor-pointer"
                    >
                        ✅ Confirmar Firma Capturada
                    </button>
                </div>

                <!-- ══════════════════════════════════════════════════ -->
                <!-- FIRMA CAPTURADA (cualquier modo): Previsualización -->
                <!-- ══════════════════════════════════════════════════ -->
                @if($signature_base64)
                <div x-data="signaturePad()" x-show="true" class="space-y-3 animate-fade-in">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest text-center">✅ Firma Capturada</label>
                    <div class="bg-white rounded-2xl border-2 border-emerald-500 w-full h-44 relative flex items-center justify-center overflow-hidden shadow-lg shadow-emerald-500/5">
                        <img src="{{ $signature_base64 }}" class="max-h-full object-contain p-4">
                        <button
                            type="button"
                            @click="clearPad(); signMode = null"
                            wire:click="$set('signature_base64', '')"
                            class="absolute bottom-2.5 right-2.5 bg-red-500 hover:bg-red-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl transition cursor-pointer"
                        >
                            Limpiar y Firmar de Nuevo
                        </button>
                    </div>
                </div>
                @endif

                <!-- Checkbox términos -->
                <div class="flex items-start py-2">
                    <div class="flex items-center h-5">
                        <input id="terms" type="checkbox" wire:model="terms_accepted" class="w-5 h-5 border border-gray-600 rounded bg-gray-700 text-blue-500 focus:ring-blue-500 cursor-pointer" required>
                    </div>
                    <label for="terms" class="ml-3 text-xs font-semibold text-gray-300 cursor-pointer select-none leading-normal">
                        El cliente declara haber leído, comprendido y aceptado todas las condiciones y observaciones descritas en este ingreso y presupuesto.
                    </label>
                </div>

                <button type="submit" @click="savePad" class="w-full font-black py-4 px-6 rounded-2xl text-base transition duration-200 flex justify-center items-center gap-2 cursor-pointer shadow-xl" style="background: linear-gradient(135deg, #00C6B6 0%, #0096db 100%); color: #fff; box-shadow: 0 8px 32px rgba(0,198,182,0.25);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span>🛠️ CREAR ORDEN DE TRABAJO</span>
                </button>
                @error('signature_base64') <span class="text-red-400 text-xs mt-2 block text-center font-bold">{{ $message }}</span> @enderror
            </div>


        </form>
    </div>

    <!-- MODAL POST-CREACIÓN DE IMPRESIÓN Y QR -->
    @if($show_success_modal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/80 backdrop-blur-sm animate-fade-in">
            <div class="bg-gray-800 rounded-3xl max-w-md w-full border border-gray-700 shadow-2xl p-6 text-center space-y-6">
                
                <div class="w-16 h-16 rounded-full bg-green-500/10 border border-green-500/20 flex items-center justify-center mx-auto text-green-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                
                <div>
                    <h3 class="text-xl font-black text-white">¡Orden de Trabajo Creada!</h3>
                    <p class="text-xs text-gray-400 mt-1.5">La orden de servicio <strong>#{{ $created_order_id }}</strong> ha sido ingresada en el sistema. Puedes proceder a imprimir los comprobantes.</p>
                </div>

                <!-- Botones de Acción de Impresión -->
                <div class="grid grid-cols-1 gap-2.5">
                    <button type="button" onclick="window.printContent('receipt-print-template', 'qr-canvas-a4')" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-2xl text-xs tracking-wide flex items-center justify-center gap-2 shadow-lg shadow-blue-500/10 cursor-pointer">
                        📄 IMPRIMIR RECIBO CLIENTE (A4 / CARTA)
                    </button>
                    
                    <button type="button" onclick="window.printContent('thermal-label-print-template', 'qr-canvas-thermal')" class="bg-gray-750 hover:bg-gray-700 text-white font-bold py-3.5 px-4 rounded-2xl text-xs tracking-wide flex items-center justify-center gap-2 border border-gray-700 cursor-pointer">
                        🏷️ IMPRIMIR ETIQUETA ADHESIVA (TÉRMICA)
                    </button>

                    <button type="button" wire:click="closeSuccessModal" class="bg-gray-900 hover:bg-gray-850 text-gray-300 font-bold py-3 px-4 rounded-2xl text-xs cursor-pointer">
                        Ir al Panel de Control
                    </button>
                </div>
            </div>
        </div>

        <!-- PLANTILLAS DE IMPRESIÓN OCULTAS EN EL DOM -->
        <div style="display: none;">
            
            <!-- 1. COMPROBANTE DE CLIENTE (A4 / Carta) -->
            @if($this->createdOrder)
                @include('components.print.work-order-a4', ['templateId' => 'receipt-print-template', 'order' => $this->createdOrder, 'qrCanvasId' => 'qr-canvas-a4'])
                
                <!-- 2. COMPROBANTE TÉRMICO DE IDENTIFICACIÓN (58mm / 80mm) -->
                @include('components.print.work-order-thermal', ['templateId' => 'thermal-label-print-template', 'order' => $this->createdOrder, 'qrCanvasId' => 'qr-canvas-thermal'])
            @endif

        </div>
    @endif

    <!-- MODAL CLIENTE KIOSCO (FIRMA EN PANTALLA) -->
    @if($kiosk_mode)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/95 backdrop-blur-md animate-fade-in" x-data="kioskSignaturePad()">
            <div class="bg-gray-900 border border-gray-800 rounded-3xl max-w-lg w-full p-6 space-y-6 shadow-2xl relative">
                
                <div class="text-center">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-black uppercase tracking-widest">
                        🖥️ Modo Kiosco de Firma
                    </div>
                    <h3 class="text-xl font-black text-white mt-2">Valida e Ingresa tu Firma</h3>
                    <p class="text-xs text-gray-400">Por favor, revisa tus datos, acepta las condiciones y firma en el panel.</p>
                </div>

                <!-- Resumen Simplificado -->
                <div class="bg-gray-950/60 rounded-2xl p-4 border border-gray-800 space-y-2.5 text-xs text-gray-300">
                    <p><strong>Cliente:</strong> <span class="text-white font-bold">{{ $full_name }}</span></p>
                    <p><strong>Equipo:</strong> <span class="text-white font-bold capitalize">{{ $device_type }} / {{ $brand_model }}</span></p>
                    <p><strong>Falla Reportada:</strong> <span class="text-gray-400 italic">{{ $reported_issue }}</span></p>
                    @if($aesthetic_notes)
                        <p class="text-yellow-400/90 font-medium"><strong>Observaciones Estéticas:</strong> {{ $aesthetic_notes }}</p>
                    @endif
                    @if($budget_type === 'pending')
                        <p class="text-blue-400"><strong>Presupuesto:</strong> Sujeto a Diagnóstico Técnico</p>
                    @else
                        <p><strong>Total Estimado:</strong> <span class="text-emerald-400 font-bold">${{ number_format($this->total, 0, ',', '.') }}</span></p>
                    @endif
                </div>

                <!-- Condiciones Legales -->
                <div class="space-y-1.5">
                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-wider">Condiciones Legales de Recepción</span>
                    <div class="bg-gray-950 rounded-2xl p-3.5 border border-gray-800 max-h-32 overflow-y-auto text-xs text-gray-400 italic font-sans leading-relaxed scrollbar-thin scrollbar-thumb-gray-800 scrollbar-track-transparent">
                        "{{ \App\Models\Setting::find(1)->warranty_text ?? 'Garantía exclusiva por fallas de funcionamiento de la pieza reemplazada. No cubre daños por golpes, presión o humedad.' }}"
                    </div>
                </div>

                <!-- Lienzo Kiosco -->
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="kiosk-terms" type="checkbox" wire:model="terms_accepted" class="w-5 h-5 border border-gray-700 rounded bg-gray-950 text-blue-500 focus:ring-blue-500 cursor-pointer" required>
                        </div>
                        <label for="kiosk-terms" class="ml-3 text-xs font-semibold text-gray-300 cursor-pointer select-none leading-normal">
                            Acepto todas las condiciones y observaciones de recepción del equipo descritas anteriormente.
                        </label>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Firma Digital del Cliente</label>
                        <div class="bg-white rounded-2xl border-2 border-dashed border-gray-300 w-full h-44 relative overflow-hidden touch-none shadow-inner">
                            <canvas id="kiosk-sig-pad" class="w-full h-full rounded-2xl cursor-crosshair"></canvas>
                            <button type="button" @click="clearKioskPad" class="absolute bottom-2.5 right-2.5 bg-gray-900 hover:bg-gray-850 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl border border-gray-750 transition cursor-pointer">
                                Limpiar Firma
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="grid grid-cols-2 gap-3.5 pt-2">
                    <button type="button" wire:click="toggleKioskMode" class="bg-gray-800 hover:bg-gray-750 text-gray-300 font-bold py-3.5 px-4 rounded-2xl text-xs transition cursor-pointer border border-gray-750">
                        ❌ CANCELAR Y SALIR
                    </button>
                    <button type="button" @click="saveKioskPad" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-2xl text-xs tracking-wide transition shadow-lg shadow-blue-500/10 cursor-pointer">
                        💾 GUARDAR Y ACEPTAR
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>

<!-- DEPENDENCIAS DE FIRMA Y QR -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('signaturePad', () => ({
            pad: null,
            init() {
                const canvas = document.getElementById('signature-pad');
                if (!canvas) return;
                
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);

                this.pad = new SignaturePad(canvas, {
                    backgroundColor: 'rgb(255, 255, 255)',
                    penColor: 'rgb(0, 0, 0)'
                });
            },
            clearPad() {
                if (this.pad) this.pad.clear();
            },
            savePad() {
                if (this.pad && !this.pad.isEmpty()) {
                    @this.set('signature_base64', this.pad.toDataURL('image/png'));
                } else {
                    @this.set('signature_base64', '');
                }
            }
        }));

        Alpine.data('kioskSignaturePad', () => ({
            pad: null,
            init() {
                setTimeout(() => {
                    const canvas = document.getElementById('kiosk-sig-pad');
                    if (!canvas) return;
                    
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);

                    this.pad = new SignaturePad(canvas, {
                        backgroundColor: 'rgb(255, 255, 255)',
                        penColor: 'rgb(0, 0, 0)'
                    });
                }, 150);
            },
            clearKioskPad() {
                if (this.pad) this.pad.clear();
            },
            saveKioskPad() {
                if (this.pad && !this.pad.isEmpty()) {
                    @this.set('signature_base64', this.pad.toDataURL('image/png'));
                    @this.set('terms_accepted', true);
                    @this.call('toggleKioskMode'); // Close modal
                } else {
                    alert('Por favor, dibuja tu firma antes de guardar.');
                }
            }
        }));

        Alpine.data('patternLock', () => ({
            selectedDots: [],
            isDrawing: false,
            canvas: null,
            ctx: null,
            dots: [],
            
            init() {
                setTimeout(() => {
                    this.canvas = document.getElementById('pattern-canvas');
                    if (this.canvas) {
                        this.ctx = this.canvas.getContext('2d');
                        this.resizeCanvas();
                    }
                    this.cacheDots();
                }, 100);
                
                // Re-cache dots on window resize
                window.addEventListener('resize', () => {
                    this.resizeCanvas();
                    this.cacheDots();
                });
            },
            
            resizeCanvas() {
                if (this.canvas) {
                    const rect = this.canvas.getBoundingClientRect();
                    this.canvas.width = rect.width;
                    this.canvas.height = rect.height;
                }
            },
            
            cacheDots() {
                this.dots = [];
                const container = document.getElementById('pattern-matrix');
                if (!container) return;
                
                const rect = container.getBoundingClientRect();
                const elements = container.querySelectorAll('[data-index]');
                
                elements.forEach(el => {
                    const index = parseInt(el.getAttribute('data-index'));
                    const elRect = el.getBoundingClientRect();
                    this.dots.push({
                        index: index,
                        x: elRect.left - rect.left + elRect.width / 2,
                        y: elRect.top - rect.top + elRect.height / 2
                    });
                });
                this.dots.sort((a, b) => a.index - b.index);
            },
            
            startDrawing(e) {
                this.isDrawing = true;
                this.selectedDots = [];
                this.resizeCanvas();
                this.cacheDots();
                this.processMove(e);
            },
            
            draw(e) {
                if (!this.isDrawing) return;
                this.processMove(e);
                this.renderLines(e);
            },
            
            stopDrawing() {
                if (!this.isDrawing) return;
                this.isDrawing = false;
                this.renderLines();
            },
            
            processMove(e) {
                e.preventDefault();
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                
                const container = document.getElementById('pattern-matrix');
                if (!container) return;
                
                const containerRect = container.getBoundingClientRect();
                const x = clientX - containerRect.left;
                const y = clientY - containerRect.top;
                
                this.dots.forEach(dot => {
                    const dist = Math.hypot(dot.x - x, dot.y - y);
                    if (dist < 24) { // slightly adjusted collision size for perfect ergonomics
                        if (!this.selectedDots.includes(dot.index)) {
                            this.selectedDots.push(dot.index);
                            if (navigator.vibrate) {
                                navigator.vibrate(15);
                            }
                        }
                    }
                });
            },
            
            isDotSelected(index) {
                return this.selectedDots.includes(index);
            },
            
            getPatternText() {
                if (this.selectedDots.length === 0) return 'Sin trazar';
                return this.selectedDots.join(' ➔ ');
            },
            
            renderLines(e = null) {
                if (!this.canvas || !this.ctx) return;
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                
                if (this.selectedDots.length === 0) return;
                
                this.ctx.lineWidth = 4;
                this.ctx.lineCap = 'round';
                this.ctx.lineJoin = 'round';
                
                this.ctx.strokeStyle = '#f97316'; // orange-500
                this.ctx.shadowBlur = 10;
                this.ctx.shadowColor = '#ea580c'; // orange-600
                
                this.ctx.beginPath();
                
                this.selectedDots.forEach((index, idx) => {
                    const dot = this.dots.find(d => d.index === index);
                    if (dot) {
                        if (idx === 0) {
                            this.ctx.moveTo(dot.x, dot.y);
                        } else {
                            this.ctx.lineTo(dot.x, dot.y);
                        }
                    }
                });
                
                this.ctx.stroke();
                
                if (this.isDrawing && e) {
                    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                    const containerRect = document.getElementById('pattern-matrix').getBoundingClientRect();
                    const curX = clientX - containerRect.left;
                    const curY = clientY - containerRect.top;
                    
                    const lastDotIdx = this.selectedDots[this.selectedDots.length - 1];
                    const lastDot = this.dots.find(d => d.index === lastDotIdx);
                    if (lastDot) {
                        this.ctx.beginPath();
                        this.ctx.lineWidth = 3;
                        this.ctx.strokeStyle = 'rgba(249, 115, 22, 0.6)';
                        this.ctx.moveTo(lastDot.x, lastDot.y);
                        this.ctx.lineTo(curX, curY);
                        this.ctx.stroke();
                    }
                }
            },
            
            clearPattern() {
                this.selectedDots = [];
                this.renderLines();
            },
            
            applyPattern() {
                if (this.selectedDots.length > 0) {
                    const patternString = 'Patrón: ' + this.selectedDots.join('-');
                    @this.set('unlock_password', patternString);
                }
            }
        }));
    });
</script>
