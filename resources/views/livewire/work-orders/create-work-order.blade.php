<div class="max-w-3xl mx-auto pb-20">
    <div class="rounded-3xl shadow-2xl overflow-hidden border border-white/5" style="background: #0D1117;">

        <!-- Header Premium con gradiente teal -->
        <div class="relative overflow-hidden px-6 py-6 border-b border-white/5"
            style="background: linear-gradient(135deg, #0a1628 0%, #0d2137 40%, #083d35 100%);">
            <!-- Patrón de fondo sutil -->
            <div class="absolute inset-0 opacity-5"
                style="background-image: radial-gradient(circle at 1px 1px, rgba(0,198,182,0.6) 1px, transparent 0); background-size: 24px 24px;">
            </div>
            <!-- Glow orbs -->
            <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full pointer-events-none"
                style="background: radial-gradient(circle, rgba(0,198,182,0.12) 0%, transparent 70%);"></div>
            <div class="absolute -bottom-6 -left-6 w-32 h-32 rounded-full pointer-events-none"
                style="background: radial-gradient(circle, rgba(0,150,255,0.08) 0%, transparent 70%);"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest border"
                            style="background: rgba(0,198,182,0.1); color: #00C6B6; border-color: rgba(0,198,182,0.25);">Sointech
                            • Taller</span>
                    </div>
                    <h2 class="text-2xl font-black tracking-tight" style="color: #f0fffe;">Nueva Orden de Trabajo</h2>
                    <p class="text-xs mt-1" style="color: rgba(180,210,205,0.7);">Registra el ingreso formal de un
                        equipo y protege tu taller ante reclamos.</p>
                </div>
                <div class="shrink-0 w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg"
                    style="background: rgba(0,198,182,0.12); border: 1px solid rgba(0,198,182,0.2);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #00C6B6;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>
        </div>

        @if(session()->has('error'))
            <div class="m-6 mb-0 p-4 rounded-xl text-sm font-bold animate-fade-in flex items-center gap-2"
                style="background: rgba(239,68,68,0.1); border-left: 3px solid #ef4444; color: #fca5a5;">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if($from_quote_number)
            <div class="m-6 mb-0 p-4 rounded-2xl text-xs font-bold animate-fade-in flex items-center justify-between gap-3 bg-purple-950/40 border border-purple-500/30 text-purple-200 shadow-lg">
                <div class="flex items-center gap-2">
                    <span class="text-base">📋</span>
                    <span>Convirtiendo Cotización <strong>#{{ $from_quote_number }}</strong> a Orden de Trabajo. Los datos del cliente, equipo y repuestos han sido cargados. Adjunta las fotos de ingreso y checklist para finalizar el respaldo.</span>
                </div>
                <span class="px-2.5 py-1 bg-purple-900/60 border border-purple-400/30 rounded-xl text-[10px] uppercase font-black shrink-0">Cotización Vinculada</span>
            </div>
        @endif

        <form wire:submit.prevent="save" class="p-6 space-y-8 text-gray-300">

            <!-- SECCIÓN 1: DATOS DEL CLIENTE -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 pb-2.5" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center"
                        style="background: rgba(0,198,182,0.1); border: 1px solid rgba(0,198,182,0.2);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color: #00C6B6;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black tracking-tight" style="color: #00C6B6;">Datos del Cliente</h3>
                        <p class="text-[10px]" style="color: rgba(156,163,175,0.7);">Busca uno existente o ingresa nuevo
                            cliente en caliente</p>
                    </div>
                </div>

                @if(!$client_selected)
                    {{-- Campo de búsqueda limpio, sin icono --}}
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.150ms="searchClient"
                            class="w-full rounded-2xl px-4 py-3.5 text-sm font-medium text-white placeholder-gray-600 transition-all duration-200 focus:outline-none focus:ring-2"
                            style="background:#111827; border:1.5px solid #1f2937; focus-ring-color:#00C6B6;"
                            placeholder="Buscar cliente por nombre, teléfono o RUT..."
                            autocomplete="off"
                            onfocus="this.style.borderColor='#00C6B6'; this.style.boxShadow='0 0 0 3px rgba(0,198,182,.12)';"
                            onblur="this.style.borderColor='#1f2937'; this.style.boxShadow='none';">

                        {{-- Indicador de búsqueda activa --}}
                        @if(strlen($searchClient) > 0 && count($foundClients) === 0)
                            <div class="absolute right-3.5 top-1/2 -translate-y-1/2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" style="color:#4b5563;">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </div>
                        @endif

                        {{-- Dropdown de resultados --}}
                        @if(count($foundClients) > 0)
                            <div class="absolute z-20 w-full mt-1.5 overflow-hidden rounded-2xl shadow-2xl"
                                style="background:#0d1117; border:1.5px solid #1f2937;">
                                {{-- Header del dropdown --}}
                                <div class="px-4 py-2 flex items-center justify-between"
                                    style="border-bottom:1px solid #1f2937;">
                                    <span class="text-[10px] font-black uppercase tracking-widest" style="color:#4b5563;">
                                        {{ count($foundClients) }} resultado{{ count($foundClients) > 1 ? 's' : '' }} encontrado{{ count($foundClients) > 1 ? 's' : '' }}
                                    </span>
                                    <span class="text-[10px]" style="color:#374151;">↵ para seleccionar</span>
                                </div>
                                <ul>
                                    @foreach($foundClients as $fc)
                                        <li wire:click="selectClient({{ $fc->id }})"
                                            class="flex items-center gap-3 px-4 py-3 cursor-pointer transition-all duration-150 border-b last:border-0 group"
                                            style="border-color:#1f2937;"
                                            onmouseover="this.style.background='#111827';"
                                            onmouseout="this.style.background='transparent';">

                                            {{-- Ícono SVG de usuario (sin iniciales) --}}
                                            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                                                style="background:rgba(0,198,182,.08); border:1px solid rgba(0,198,182,.15);">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#2dd4bf;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                                </svg>
                                            </div>

                                            {{-- Info --}}
                                            <div class="flex-1 min-w-0">
                                                <div class="font-bold text-white text-sm leading-tight truncate">{{ $fc->full_name }}</div>
                                                <div class="flex items-center gap-2.5 mt-0.5 text-[11px]" style="color:#6b7280;">
                                                    @if($fc->phone)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3h3m-3 3h3"/>
                                                            </svg>
                                                            {{ $fc->phone }}
                                                        </span>
                                                    @endif
                                                    @if($fc->rut_dni)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                                                            </svg>
                                                            {{ $fc->rut_dni }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- CTA: ícono flecha, sin texto --}}
                                            <div class="shrink-0 w-7 h-7 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-150"
                                                style="background:rgba(0,198,182,.12); border:1px solid rgba(0,198,182,.25); color:#2dd4bf;">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                                </svg>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>


                    <!-- Alerta de Cliente Nuevo -->
                    <div
                        class="bg-blue-950/20 border border-blue-800/30 px-4 py-3.5 rounded-2xl flex items-center gap-2.5 text-blue-300 text-xs">
                        <svg class="w-4.5 h-4.5 text-blue-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span><strong>✨ Registro Automático:</strong> Si completas los campos a continuación, el cliente se
                            creará en caliente al guardar la orden.</span>
                    </div>

                    <!-- Campos de Entrada -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 animate-fade-in">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre
                                Completo *</label>
                            <input type="text" wire:model="full_name"
                                class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Teléfono /
                                WhatsApp *</label>
                            <input type="text" wire:model="phone"
                                class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Ej: +56912345678" required>
                        </div>
                        <div x-data>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">RUT / DNI</label>
                                <template x-if="$wire.rut_dni && $wire.rut_dni.length >= 8">
                                    <span x-text="window.validateRut($wire.rut_dni) ? '✓ RUT Válido' : '✗ RUT Inválido'"
                                        :class="window.validateRut($wire.rut_dni)
                                            ? 'text-emerald-400 bg-emerald-500/10 border-emerald-500/30'
                                            : 'text-amber-400 bg-amber-500/10 border-amber-500/30'"
                                        class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider border"></span>
                                </template>
                            </div>
                            <input type="text" wire:model.live="rut_dni"
                                x-on:input="$el.value = window.formatRut($el.value); $dispatch('input', $el.value)"
                                class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Email</label>
                            <input type="email" wire:model="email"
                                class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                @else
                    {{-- Tarjeta de Cliente Seleccionado — sin iniciales, íconos SVG profesionales --}}
                    <div class="rounded-2xl p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 animate-fade-in"
                        style="background:#0d1117; border:1.5px solid #1f2937;">
                        <div class="flex items-center gap-3.5 min-w-0">
                            {{-- Ícono de usuario SVG (sin iniciales) --}}
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                                style="background:rgba(0,198,182,.1); border:1.5px solid rgba(0,198,182,.2);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#2dd4bf;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                            </div>
                            {{-- Info del cliente --}}
                            <div class="min-w-0">
                                <h4 class="font-black text-white text-sm leading-tight truncate">{{ $full_name }}</h4>
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-1 text-[11.5px]" style="color:#6b7280;">
                                    {{-- Teléfono --}}
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.25 6.338c0 5.594 2.418 10.62 6.278 14.089l.059.055a2.25 2.25 0 003.097-.099l1.016-1.015a2.25 2.25 0 00.144-3.027L11.55 14.4a2.25 2.25 0 00-2.677-.583l-.24.1A13.47 13.47 0 016.166 11.3l.1-.24a2.25 2.25 0 00-.583-2.677L3.74 6.641a2.25 2.25 0 00-3.027.144L0.7 7.8A2.25 2.25 0 00.6 10.9"/>
                                        </svg>
                                        {{ $phone }}
                                    </span>
                                    @if($rut_dni)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/>
                                            </svg>
                                            {{ $rut_dni }}
                                        </span>
                                    @endif
                                    @if($email)
                                        <span class="flex items-center gap-1 truncate max-w-[160px]">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                            </svg>
                                            <span class="truncate">{{ $email }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Botones de acción — solo íconos SVG, sin emojis ni texto de iniciales --}}
                        <div class="flex gap-2 shrink-0">
                            {{-- Botón Editar --}}
                            <button type="button" wire:click="toggleClientEditing"
                                title="{{ $client_editing ? 'Cerrar edición' : 'Editar datos del cliente' }}"
                                class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-150 cursor-pointer"
                                style="{{ $client_editing
                                    ? 'background:rgba(16,185,129,.15); border:1.5px solid rgba(16,185,129,.3); color:#34d399;'
                                    : 'background:#1f2937; border:1.5px solid #374151; color:#9ca3af;' }}"
                                onmouseover="if(!{{ $client_editing ? 'true' : 'false' }}) { this.style.background='#374151'; this.style.color='#e5e7eb'; }"
                                onmouseout="if(!{{ $client_editing ? 'true' : 'false' }}) { this.style.background='#1f2937'; this.style.color='#9ca3af'; }">
                                @if($client_editing)
                                    {{-- Check / Cerrar --}}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    {{-- Lápiz --}}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                                    </svg>
                                @endif
                            </button>

                            {{-- Botón Cambiar cliente --}}
                            <button type="button" wire:click="clearClientSelection"
                                title="Cambiar cliente"
                                class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-150 cursor-pointer"
                                style="background:rgba(239,68,68,.08); border:1.5px solid rgba(239,68,68,.2); color:#f87171;"
                                onmouseover="this.style.background='rgba(239,68,68,.18)';"
                                onmouseout="this.style.background='rgba(239,68,68,.08)';">
                                {{-- Flechas de cambio (arrow-path) --}}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                </svg>
                            </button>
                        </div>
                    </div>


                    <!-- Campos Editables in-situ si se activa -->
                    @if($client_editing)
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-900/40 p-5 rounded-3xl border border-gray-750 animate-fade-in">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre
                                    Completo *</label>
                                <input type="text" wire:model="full_name"
                                    class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Teléfono /
                                    WhatsApp *</label>
                                <input type="text" wire:model="phone"
                                    class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">RUT /
                                    DNI</label>
                                <input type="text" wire:model="rut_dni" x-data
                                    x-on:input="$el.value = window.formatRut($el.value); $dispatch('input', $el.value)"
                                    class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Email</label>
                                <input type="email" wire:model="email"
                                    class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- SECCIÓN 2: DATOS DEL EQUIPO -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 pb-2.5" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center"
                        style="background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.2);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color: #818cf8;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black tracking-tight" style="color: #818cf8;">Datos del Equipo</h3>
                        <p class="text-[10px]" style="color: rgba(156,163,175,0.7);">Tipo, modelo, IMEI y falla
                            reportada</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Tipo de
                            Equipo *</label>
                        <select wire:model.live="device_type"
                            class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="smartphone">📱 Smartphone / Celular</option>
                            <option value="smartwatch">⌚ Smartwatch / Reloj Inteligente</option>
                            <option value="allinone">🖥️ PC All-in-One / iMac</option>
                            <option value="notebook">💻 Notebook / Laptop</option>
                            <option value="desktop">🖥️ PC de Escritorio (Torre)</option>
                            <option value="tablet">📟 Tablet / iPad</option>
                            <option value="console">🎮 Consola de Videojuegos</option>
                            <option value="other">⚙️ Otro Equipo / Especializado</option>
                        </select>
                    </div>

                    <!-- Marca y Modelo con Predictivo -->
                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Marca y
                            Modelo *</label>
                        <input type="text" wire:model.live="brand_model"
                            class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej: iPhone 15 Pro, Galaxy Watch 6, iMac 24" autocomplete="off" required>

                        <!-- Sugerencias del Catálogo Predictivo -->
                        @if(count($foundDevices) > 0)
                            <div
                                class="absolute z-20 w-full mt-1.5 bg-gray-900 border border-gray-750 rounded-2xl shadow-2xl overflow-hidden backdrop-blur-xl">
                                <div class="px-3.5 py-1.5 bg-gray-800/80 border-b border-gray-700 flex items-center justify-between text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                                    <span>Catálogo Predictivo</span>
                                    <span>Sugerencias en tiempo real</span>
                                </div>
                                <ul>
                                    @foreach($foundDevices as $device)
                                        <li wire:click="selectDevice('{{ addslashes($device->brand) }}', '{{ addslashes($device->model) }}', '{{ $device->device_type }}')"
                                            class="px-4 py-3 hover:bg-gray-800 cursor-pointer border-b border-gray-800 last:border-0 flex items-center justify-between text-xs transition duration-150 group">
                                            <div class="flex items-center gap-2">
                                                <span class="font-black text-white group-hover:text-blue-400 transition">{{ $device->brand }}</span>
                                                <span class="font-semibold text-gray-300">{{ $device->model }}</span>
                                            </div>
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border transition {{ $device->device_type === $device_type ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30' : 'bg-blue-500/10 text-blue-400 border-blue-500/30' }}">
                                                @switch($device->device_type)
                                                    @case('smartphone') 📱 Smartphone @break
                                                    @case('smartwatch') ⌚ Reloj @break
                                                    @case('allinone') 🖥️ All-in-One @break
                                                    @case('notebook') 💻 Notebook @break
                                                    @case('desktop') 🖥️ PC @break
                                                    @case('tablet') 📟 Tablet @break
                                                    @case('console') 🎮 Consola @break
                                                    @default ⚙️ {{ ucfirst($device->device_type) }}
                                                @endswitch
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">IMEI /
                            Número de Serie</label>
                        <input type="text" wire:model="imei_serial"
                            class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Nº Serie físico para identificación">
                    </div>
                    <div x-data="{ showPatternDrawer: false }">
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Clave / PIN
                                de Desbloqueo</label>
                            <!-- Pattern Toggle Button -->
                            <button type="button" @click="showPatternDrawer = !showPatternDrawer"
                                class="text-[10px] text-blue-400 hover:text-blue-300 font-black flex items-center gap-1 transition focus:outline-none">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <span x-text="showPatternDrawer ? 'Ocultar Patrón' : 'Dibujar Patrón'"></span>
                            </button>
                        </div>
                        <input type="text" wire:model="unlock_password" id="unlock_password"
                            class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej: Patrón de Z o 1234">

                        <!-- Interactive Pattern Lock Drawer -->
                        <div x-show="showPatternDrawer" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-4"
                            class="bg-gray-900 border border-gray-700 rounded-3xl p-5 mt-3 space-y-4 relative overflow-hidden"
                            x-data="patternLock()">
                            <!-- Glowing details -->
                            <div
                                class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl pointer-events-none">
                            </div>

                            <div class="flex justify-between items-center border-b border-gray-800 pb-2">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Dibujador
                                    de Patrón Interactivo</span>
                                <div class="flex gap-2">
                                    <button type="button" @click="clearPattern"
                                        class="px-2.5 py-1 bg-gray-800 hover:bg-gray-750 text-gray-300 rounded-lg text-[10px] font-bold border border-gray-700 transition">
                                        Borrar
                                    </button>
                                    <button type="button" @click="applyPattern"
                                        class="px-2.5 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-[10px] font-bold transition">
                                        Aplicar Patrón
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-col items-center justify-center gap-6 py-2">
                                <!-- 3x3 interactive dot matrix (Bulletproof Inline-sized CSS Grid) -->
                                <div class="relative bg-gray-950/90 rounded-3xl border border-gray-800 grid grid-cols-3 grid-rows-3 gap-3 p-4 select-none touch-none"
                                    style="width: 220px; height: 220px; min-width: 220px; min-height: 220px;"
                                    @mousedown="startDrawing" @mousemove="draw" @mouseup="stopDrawing"
                                    @mouseleave="stopDrawing" @touchstart="startDrawing" @touchmove="draw"
                                    @touchend="stopDrawing" id="pattern-matrix">

                                    <!-- Dynamic Lines Canvas -->
                                    <canvas id="pattern-canvas"
                                        class="absolute inset-0 w-full h-full pointer-events-none z-10"></canvas>

                                    <!-- 9 Dots -->
                                    <template x-for="i in 9" :key="i">
                                        <div class="flex items-center justify-center relative cursor-pointer z-20"
                                            style="width: 100%; height: 100%;" :data-index="i">
                                            <!-- Android Style Dot Container -->
                                            <div class="w-12 h-12 flex items-center justify-center rounded-full transition-all duration-150"
                                                :class="isDotSelected(i) ? 'bg-orange-500/20 ring-2 ring-orange-500/40 scale-110 shadow-lg shadow-orange-500/10' : 'hover:bg-gray-800/40 scale-100'">
                                                <!-- Inner Core Dot -->
                                                <div class="w-3.5 h-3.5 rounded-full transition-all duration-150"
                                                    :class="isDotSelected(i) ? 'bg-orange-500 shadow-lg shadow-orange-500/80 scale-110' : 'bg-gray-600 scale-100'">
                                                </div>
                                            </div>

                                            <!-- Tiny Index number watermark -->
                                            <span
                                                class="absolute text-[8px] text-gray-700/60 font-mono font-bold select-none pointer-events-none"
                                                style="transform: translateY(18px);" x-text="i"></span>
                                        </div>
                                    </template>
                                </div>

                                <!-- Live visual preview of sequence -->
                                <div
                                    class="flex flex-col items-center space-y-3.5 text-center shrink-0 w-full border-t border-gray-800/65 pt-4">
                                    <div>
                                        <div class="text-[10px] font-black text-gray-500 uppercase tracking-widest">
                                            Secuencia del Patrón</div>
                                        <div class="text-sm font-black text-orange-500 font-mono tracking-wide mt-1 min-h-[20px]"
                                            x-text="getPatternText()"></div>
                                    </div>
                                    <div class="text-[10px] text-gray-400 max-w-[220px] leading-relaxed">
                                        Arrastra tu ratón o dedo conectando los puntos para trazar el patrón de
                                        desbloqueo del equipo.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Falla Reportada por el Cliente *</label>
                        <span class="text-[10px] text-teal-400 font-bold">⚡ Clic para añadir falla frecuente</span>
                    </div>

                    <!-- Quick Tags Sugeridos según Tipo de Equipo -->
                    @if(count($this->quickTags) > 0)
                        <div class="flex flex-wrap gap-1.5 mb-2.5">
                            @foreach($this->quickTags as $tag)
                                <button type="button" wire:click="addQuickTag('{{ $tag }}')"
                                    class="px-2.5 py-1 rounded-xl text-xs font-semibold bg-gray-800 hover:bg-teal-950/60 text-gray-300 hover:text-teal-300 border border-gray-700 hover:border-teal-500/40 transition duration-150 cursor-pointer flex items-center gap-1 active:scale-95">
                                    <span>{{ $tag }}</span>
                                    <span class="text-[10px] text-teal-400 font-bold">+</span>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <textarea wire:model="reported_issue"
                        class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3.5 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        rows="2.5" placeholder="Describe los síntomas o selecciona de las fallas frecuentes arriba..." required></textarea>
                    @error('reported_issue') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Estado de Ingreso Inicial *</label>

                    {{-- 4 botones horizontales con icono, color, nombre y descripción --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">

                        {{-- ── Ingresado ── --}}
                        <button type="button" wire:click="$set('initial_status', 'Ingresado')"
                            class="group relative flex flex-col items-center gap-2 py-4 px-2 rounded-2xl border-2 transition-all duration-200 focus:outline-none cursor-pointer text-center
                                {{ $initial_status === 'Ingresado'
                                    ? 'border-sky-500 bg-sky-500/10 shadow-lg shadow-sky-500/10'
                                    : 'border-gray-700/60 bg-gray-800/40 hover:border-sky-600/40 hover:bg-sky-900/10' }}">
                            {{-- Indicador activo --}}
                            @if($initial_status === 'Ingresado')
                                <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                            @endif
                            {{-- Icono --}}
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xl transition-transform group-hover:scale-110
                                {{ $initial_status === 'Ingresado' ? 'bg-sky-500/20' : 'bg-gray-700/60' }}">
                                ⏳
                            </div>
                            <div>
                                <div class="text-[12px] font-black leading-tight {{ $initial_status === 'Ingresado' ? 'text-sky-300' : 'text-gray-300' }}">
                                    Ingresado
                                </div>
                                <div class="text-[10px] leading-snug mt-0.5 {{ $initial_status === 'Ingresado' ? 'text-sky-400/70' : 'text-gray-600' }}">
                                    Cola de espera
                                </div>
                            </div>
                        </button>

                        {{-- ── En Revisión ── --}}
                        <button type="button" wire:click="$set('initial_status', 'En Revisión')"
                            class="group relative flex flex-col items-center gap-2 py-4 px-2 rounded-2xl border-2 transition-all duration-200 focus:outline-none cursor-pointer text-center
                                {{ $initial_status === 'En Revisión'
                                    ? 'border-amber-500 bg-amber-500/10 shadow-lg shadow-amber-500/10'
                                    : 'border-gray-700/60 bg-gray-800/40 hover:border-amber-600/40 hover:bg-amber-900/10' }}">
                            @if($initial_status === 'En Revisión')
                                <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                            @endif
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xl transition-transform group-hover:scale-110
                                {{ $initial_status === 'En Revisión' ? 'bg-amber-500/20' : 'bg-gray-700/60' }}">
                                🔍
                            </div>
                            <div>
                                <div class="text-[12px] font-black leading-tight {{ $initial_status === 'En Revisión' ? 'text-amber-300' : 'text-gray-300' }}">
                                    En Revisión
                                </div>
                                <div class="text-[10px] leading-snug mt-0.5 {{ $initial_status === 'En Revisión' ? 'text-amber-400/70' : 'text-gray-600' }}">
                                    Diagnóstico directo
                                </div>
                            </div>
                        </button>

                        {{-- ── Aprobado ── --}}
                        <button type="button" wire:click="$set('initial_status', 'Aprobado')"
                            class="group relative flex flex-col items-center gap-2 py-4 px-2 rounded-2xl border-2 transition-all duration-200 focus:outline-none cursor-pointer text-center
                                {{ $initial_status === 'Aprobado'
                                    ? 'border-emerald-500 bg-emerald-500/10 shadow-lg shadow-emerald-500/10'
                                    : 'border-gray-700/60 bg-gray-800/40 hover:border-emerald-600/40 hover:bg-emerald-900/10' }}">
                            @if($initial_status === 'Aprobado')
                                <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            @endif
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xl transition-transform group-hover:scale-110
                                {{ $initial_status === 'Aprobado' ? 'bg-emerald-500/20' : 'bg-gray-700/60' }}">
                                ✅
                            </div>
                            <div>
                                <div class="text-[12px] font-black leading-tight {{ $initial_status === 'Aprobado' ? 'text-emerald-300' : 'text-gray-300' }}">
                                    Aprobado
                                </div>
                                <div class="text-[10px] leading-snug mt-0.5 {{ $initial_status === 'Aprobado' ? 'text-emerald-400/70' : 'text-gray-600' }}">
                                    Pasa a reparación
                                </div>
                            </div>
                        </button>

                        {{-- ── Garantía ── --}}
                        <button type="button" wire:click="$set('initial_status', 'Garantía')"
                            class="group relative flex flex-col items-center gap-2 py-4 px-2 rounded-2xl border-2 transition-all duration-200 focus:outline-none cursor-pointer text-center
                                {{ $initial_status === 'Garantía'
                                    ? 'border-violet-500 bg-violet-500/10 shadow-lg shadow-violet-500/10'
                                    : 'border-gray-700/60 bg-gray-800/40 hover:border-violet-600/40 hover:bg-violet-900/10' }}">
                            @if($initial_status === 'Garantía')
                                <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-violet-400 animate-pulse"></span>
                            @endif
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xl transition-transform group-hover:scale-110
                                {{ $initial_status === 'Garantía' ? 'bg-violet-500/20' : 'bg-gray-700/60' }}">
                                🛡️
                            </div>
                            <div>
                                <div class="text-[12px] font-black leading-tight {{ $initial_status === 'Garantía' ? 'text-violet-300' : 'text-gray-300' }}">
                                    Garantía
                                </div>
                                <div class="text-[10px] leading-snug mt-0.5 {{ $initial_status === 'Garantía' ? 'text-violet-400/70' : 'text-gray-600' }}">
                                    Reingreso revisión
                                </div>
                            </div>
                        </button>

                    </div>

                    {{-- Nota dinámica de bitácora según estado seleccionado --}}
                    <p class="mt-2.5 text-[10.5px] flex items-center gap-1.5
                        {{ $initial_status === 'Ingresado' ? 'text-sky-400/80' : '' }}
                        {{ $initial_status === 'En Revisión' ? 'text-amber-400/80' : '' }}
                        {{ $initial_status === 'Aprobado' ? 'text-emerald-400/80' : '' }}
                        {{ $initial_status === 'Garantía' ? 'text-violet-400/80' : '' }}">
                        <svg class="w-3 h-3 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>
                            @if($initial_status === 'Ingresado') Bitácora: Equipo en cola de espera para diagnóstico técnico.
                            @elseif($initial_status === 'En Revisión') Bitácora: Pasa directo a revisión y diagnóstico inmediato.
                            @elseif($initial_status === 'Aprobado') Bitácora: Presupuesto acordado en mostrador. Directo a reparación.
                            @elseif($initial_status === 'Garantía') Bitácora: Reingreso por garantía. Prioridad en mesa técnica.
                            @endif
                        </span>
                    </p>
                </div>



                <!-- SUB-SECTION: COMPONENTES PC (Conditional) -->
                <div x-show="['desktop', 'notebook', 'other'].includes($wire.device_type)" x-transition
                    class="mt-6 p-5 rounded-2xl bg-gray-900/50 border border-gray-700/50">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-sm font-bold text-blue-400">Componentes de Hardware</h4>
                            <p class="text-[10px] text-gray-500">Registra CPU, GPU, RAM, Discos, etc. para evitar
                                reclamos.</p>
                        </div>
                        <button type="button" wire:click="addComponent"
                            class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-[10px] font-bold transition">
                            + Agregar Componente
                        </button>
                    </div>

                    @if(count($components) > 0)
                        <div class="space-y-3">
                            @foreach($components as $index => $comp)
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-12 gap-2 items-center bg-gray-800/40 p-2 rounded-xl border border-gray-700/80">
                                    <div class="sm:col-span-3">
                                        <select wire:model="components.{{ $index }}.type"
                                            class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-xs focus:ring-1 focus:ring-blue-500">
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
                                        <input type="text" wire:model="components.{{ $index }}.brand"
                                            placeholder="Marca (Ej: Intel)"
                                            class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-xs focus:ring-1 focus:ring-blue-500">
                                    </div>
                                    <div class="sm:col-span-3">
                                        <input type="text" wire:model="components.{{ $index }}.model"
                                            placeholder="Modelo o Capacidad"
                                            class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-xs focus:ring-1 focus:ring-blue-500">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <input type="text" wire:model="components.{{ $index }}.serial_number"
                                            placeholder="Nº Serie"
                                            class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white text-xs focus:ring-1 focus:ring-blue-500">
                                    </div>
                                    <div class="sm:col-span-1 flex justify-end">
                                        <button type="button" wire:click="removeComponent({{ $index }})"
                                            class="p-1.5 text-gray-500 hover:text-red-400 hover:bg-gray-700 rounded-lg transition"
                                            title="Eliminar componente">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
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
            <div class="p-5 rounded-2xl"
                style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06);">
                <div class="flex items-center gap-3 pb-3 mb-4" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center"
                        style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color: #fbbf24;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black tracking-tight" style="color: #fbbf24;">Checklist y Estado Inicial
                        </h3>
                        <p class="text-[10px]" style="color: rgba(156,163,175,0.7);">Condición física y funcional del
                            equipo al recibirlo</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="flex items-center">
                        <label class="flex items-center space-x-2.5 cursor-pointer">
                            <input type="checkbox" wire:model="turns_on"
                                class="w-5 h-5 text-blue-500 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-200">¿El equipo enciende al recibirlo?</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">¿Tiene
                            sospecha de contacto con líquido?</label>
                        <select wire:model="liquid_contact"
                            class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-2.5 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>No</option>
                            <option>Sí</option>
                            <option>No sabe / Mojado anteriormente</option>
                        </select>
                    </div>
                </div>

                <!-- checklist_values cargados dinámicamente desde BD de configuraciones -->
                @if(count($checklist_values) > 0)
                    <div class="space-y-2 mb-4">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Pruebas
                            Funcionales Realizadas (Desmarca las que fallan)</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            @foreach($checklist_values as $item => $checked)
                                @php
                                    $icon = '<svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                                    $i = strtolower($item);
                                    if (str_contains($i, 'enciende'))
                                        $icon = '⚡';
                                    elseif (str_contains($i, 'face id') || str_contains($i, 'touch id'))
                                        $icon = '👁️';
                                    elseif (str_contains($i, 'líquido'))
                                        $icon = '💧';
                                    elseif (str_contains($i, 'cámara'))
                                        $icon = '📷';
                                    elseif (str_contains($i, 'micrófono'))
                                        $icon = '🎤';
                                    elseif (str_contains($i, 'parlante') || str_contains($i, 'auricular'))
                                        $icon = '🔊';
                                    elseif (str_contains($i, 'wi-fi') || str_contains($i, 'bluetooth'))
                                        $icon = '📶';
                                    elseif (str_contains($i, 'botones'))
                                        $icon = '🔘';
                                    elseif (str_contains($i, 'carga'))
                                        $icon = '🔋';
                                    elseif (str_contains($i, 'nfc'))
                                        $icon = '📡';
                                    elseif (str_contains($i, 'táctil') || str_contains($i, 'pantalla'))
                                        $icon = '🖐️';
                                @endphp
                                <label
                                    class="flex items-center space-x-2.5 cursor-pointer bg-gray-800/40 p-3 rounded-2xl border border-gray-700 hover:border-gray-650 hover:bg-gray-800/80 transition-all duration-150">
                                    <input type="checkbox" wire:model="checklist_values.{{ $item }}"
                                        class="w-4.5 h-4.5 text-blue-500 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 cursor-pointer">
                                    <span class="text-xs font-bold text-gray-200 truncate flex items-center gap-1.5"><span
                                            class="text-base">{!! $icon !!}</span> {{ $item }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">📸 Fotos del
                        Estado Inicial (Opcional, máx 3)</label>
                    <div class="flex items-center gap-4">
                        <label
                            class="flex-shrink-0 cursor-pointer bg-gray-800 border border-gray-700 hover:border-blue-500 text-blue-400 p-4 rounded-2xl flex flex-col items-center justify-center gap-2 transition duration-200 w-32 h-24">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-xs font-bold">Subir Fotos</span>
                            <input type="file" @change="compressAndUploadMultiplePhotos($event, 'initialPhotos', $wire)" multiple accept="image/*" class="hidden">
                        </label>

                        <!-- Previews -->
                        <div class="flex flex-wrap gap-3 flex-1">
                            @if($initialPhotos)
                                @foreach($initialPhotos as $index => $photo)
                                    @if(is_object($photo) && method_exists($photo, 'temporaryUrl'))
                                        <div class="w-24 h-24 rounded-2xl border border-gray-700 overflow-hidden relative group">
                                            <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                            <button type="button" 
                                                    wire:click="removeInitialPhoto({{ $index }})" 
                                                    class="absolute top-1.5 right-1.5 bg-red-600/90 hover:bg-red-600 text-white rounded-full p-1 shadow-lg transition duration-150 cursor-pointer flex items-center justify-center"
                                                    title="Quitar foto">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @error('initialPhotos') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    @error('initialPhotos.*') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Daños Físicos
                        o Notas Estéticas (Importante para proteger el taller)</label>
                    <textarea wire:model="aesthetic_notes"
                        class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        rows="2"
                        placeholder="Ej: Pantalla rayada, bisagra suelta, trizado en parte trasera, falta tornillo inferior izquierdo..."></textarea>
                </div>
            </div>

            <!-- SECCIÓN 4: PRESUPUESTO U OPCIÓN DE REVISIÓN -->
            <div>
                <div class="flex items-center gap-3 pb-2.5 mb-4"
                    style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center"
                        style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color: #34d399;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black tracking-tight" style="color: #34d399;">Presupuesto del Servicio
                        </h3>
                        <p class="text-[10px]" style="color: rgba(156,163,175,0.7);">Repuestos, mano de obra y abono
                            inicial (oculto al cliente)</p>
                    </div>
                </div>

                <!-- Tabs Tipo de Presupuesto -->
                <div class="flex gap-2 p-1.5 bg-gray-950 rounded-2xl border border-gray-800 mb-4 w-fit">
                    <button type="button" wire:click="$set('budget_type', 'fixed')"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition duration-150 {{ $budget_type === 'fixed' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white' }}">
                        💰 Presupuesto Fijo
                    </button>
                    <button type="button" wire:click="$set('budget_type', 'pending')"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition duration-150 {{ $budget_type === 'pending' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white' }}">
                        🔍 Por Diagnosticar (Solo Revisión)
                    </button>
                </div>

                @if($budget_type === 'pending')
                    <!-- Tarjeta Modo Diagnóstico sin presupuesto -->
                    <div
                        class="bg-blue-950/20 border border-blue-800/30 p-5 rounded-3xl flex items-start gap-4 text-blue-300 text-xs animate-fade-in">
                        <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <strong class="text-sm font-bold text-white block mb-1">💡 Modo Diagnóstico Técnico
                                Activado</strong>
                            <p class="leading-relaxed">Se registrará la orden con costos de mano de obra y repuestos en
                                <strong>$0</strong>. El equipo ingresará bajo un estado de "Por Diagnosticar" y podrás
                                elaborar y cargar el presupuesto detallado más tarde de forma digital en la bitácora una vez
                                que el técnico en el taller desarme y evalúe la solución.</p>
                        </div>
                    </div>
                @else
                    <!-- Presupuestador normal (Mano de obra, repuestos, etc) -->
                    <div class="space-y-4 animate-fade-in">
                        {{-- Búsqueda de Repuestos con diseño limpio --}}
                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Agregar Repuesto del Inventario</label>
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.150ms="searchPart"
                                    class="w-full rounded-2xl px-4 py-3 text-sm font-medium text-white placeholder-gray-600 transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background:#111827; border:1.5px solid #1f2937;"
                                    placeholder="Buscar repuestos por nombre o categoría..."
                                    autocomplete="off"
                                    onfocus="this.style.borderColor='#00C6B6'; this.style.boxShadow='0 0 0 3px rgba(0,198,182,.12)';"
                                    onblur="this.style.borderColor='#1f2937'; this.style.boxShadow='none';">

                                @if(strlen($searchPart) > 0 && count($foundParts) === 0)
                                    <div class="absolute right-3.5 top-1/2 -translate-y-1/2">
                                        <svg class="w-4 h-4 animate-spin text-gray-500" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            @if(count($foundParts) > 0)
                                <div class="absolute z-20 w-full mt-1.5 overflow-hidden rounded-2xl shadow-2xl"
                                    style="background:#0d1117; border:1.5px solid #1f2937;">
                                    <div class="px-4 py-2 flex items-center justify-between" style="border-bottom:1px solid #1f2937;">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-500">
                                            {{ count($foundParts) }} repuesto{{ count($foundParts) > 1 ? 's' : '' }} encontrado{{ count($foundParts) > 1 ? 's' : '' }}
                                        </span>
                                        <span class="text-[10px] text-gray-600">Clic para añadir</span>
                                    </div>
                                    <ul>
                                        @foreach($foundParts as $fp)
                                            <li wire:click="addPart({{ $fp->id }})"
                                                class="flex items-center justify-between gap-3 px-4 py-3 cursor-pointer transition-all duration-150 border-b last:border-0 group"
                                                style="border-color:#1f2937;"
                                                onmouseover="this.style.background='#111827';"
                                                onmouseout="this.style.background='transparent';">
                                                <div class="flex items-center gap-3 min-w-0">
                                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                                                        style="background:rgba(0,198,182,.08); border:1px solid rgba(0,198,182,.15);">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#2dd4bf;">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="font-bold text-white text-sm leading-tight truncate">{{ $fp->name }}</div>
                                                        <div class="flex items-center gap-2 mt-0.5 text-[11px] text-gray-500">
                                                            <span>{{ $fp->category }}</span>
                                                            <span>•</span>
                                                            @if($fp->stock <= 0)
                                                                <span class="text-red-400 font-bold">Sin Stock</span>
                                                            @elseif($fp->stock < 5)
                                                                <span class="text-amber-400 font-bold">Stock Bajo: {{ $fp->stock }}</span>
                                                            @else
                                                                <span>Stock: {{ $fp->stock }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex items-center gap-2 shrink-0">
                                                    <span class="font-mono font-bold text-emerald-400 text-sm">
                                                        ${{ number_format($fp->sale_price, 0, ',', '.') }}
                                                    </span>
                                                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"
                                                        style="background:rgba(0,198,182,.1); color:#2dd4bf; border:1px solid rgba(0,198,182,.2);">
                                                        + Añadir
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>


                        <!-- Lista de repuestos seleccionados -->
                        @if(count($selected_parts) > 0)
                            <div class="bg-gray-900 border border-gray-700 rounded-2xl p-4 space-y-2 animate-fade-in">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1 mb-2">Repuestos
                                    Añadidos</h4>
                                <ul class="space-y-1.5">
                                    @foreach($selected_parts as $index => $part)
                                        <li
                                            class="flex justify-between items-center py-2 px-3 bg-gray-800/40 rounded-xl border border-gray-700 text-xs">
                                            <span class="font-bold text-gray-200">{{ $part['name'] }}</span>
                                            <div class="flex items-center space-x-4">
                                                <span
                                                    class="font-semibold text-green-400">${{ number_format($part['sale_price'], 0, ',', '.') }}</span>
                                                <button type="button" wire:click="removePart({{ $index }})"
                                                    class="text-gray-500 hover:text-red-400 p-1 rounded transition"
                                                    title="Remover repuesto">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Búsqueda y Selección de Servicios del Catálogo -->
                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Agregar Servicios (Mano de Obra) del Catálogo</label>
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.150ms="searchService"
                                    class="w-full rounded-2xl px-4 py-3 text-sm font-medium text-white placeholder-gray-600 transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background:#111827; border:1.5px solid #1f2937;"
                                    placeholder="Escribe para buscar servicio (Ej: Cambio de pantalla, Limpieza...)..."
                                    autocomplete="off">

                                @if(strlen($searchService) > 0 && count($foundServices) === 0)
                                    <div class="absolute right-3.5 top-1/2 -translate-y-1/2">
                                        <svg class="w-4 h-4 animate-spin text-gray-500" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            @if(count($foundServices) > 0)
                                <div class="absolute z-20 w-full mt-1.5 overflow-hidden rounded-2xl shadow-2xl"
                                    style="background:#0d1117; border:1.5px solid #1f2937;">
                                    <div class="px-4 py-2 flex items-center justify-between" style="border-bottom:1px solid #1f2937;">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-500">
                                            {{ count($foundServices) }} servicio(s) encontrado(s)
                                        </span>
                                        <span class="text-[10px] text-gray-600">Clic para añadir</span>
                                    </div>
                                    <ul>
                                        @foreach($foundServices as $fs)
                                            <li wire:click="addServiceFromCatalog({{ $fs->id }})"
                                                class="flex items-center justify-between gap-3 px-4 py-3 cursor-pointer transition-all duration-150 border-b last:border-0 hover:bg-gray-800/60"
                                                style="border-color:#1f2937;">
                                                <div class="min-w-0">
                                                    <div class="font-bold text-white text-sm leading-tight truncate">{{ $fs->name }}</div>
                                                    <div class="text-[11px] text-gray-400 mt-0.5">{{ $fs->category_label }}</div>
                                                </div>
                                                <div class="flex items-center gap-2 shrink-0">
                                                    <span class="font-mono font-bold text-indigo-400 text-sm">
                                                        ${{ number_format($fs->default_price, 0, ',', '.') }}
                                                    </span>
                                                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-indigo-950/60 text-indigo-300 border border-indigo-500/30">
                                                        + Añadir
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <!-- Lista de servicios seleccionados con precios editables -->
                        @if(count($selected_services) > 0)
                            <div class="bg-gray-900 border border-gray-700 rounded-2xl p-4 space-y-2 animate-fade-in">
                                <h4 class="text-xs font-bold text-indigo-400 uppercase tracking-widest px-1 mb-2">Servicios Asignados a esta OT</h4>
                                <div class="space-y-2">
                                    @foreach($selected_services as $index => $srv)
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 p-3 bg-gray-800/60 rounded-xl border border-gray-700">
                                            <span class="text-xs font-bold text-white flex-1">{{ $srv['name'] }}</span>
                                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                                <span class="text-[10px] text-gray-400">Precio ($):</span>
                                                <input type="number" wire:model.live="selected_services.{{ $index }}.price" class="w-28 bg-gray-900 border border-gray-700 rounded-lg px-2 py-1 text-xs font-bold text-emerald-400 text-right">
                                                <button type="button" wire:click="removeSelectedService({{ $index }})" class="text-gray-500 hover:text-red-400 p-1.5 rounded-lg hover:bg-red-500/10 transition cursor-pointer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Formulario para Servicio Personalizado / Extra -->
                        <div x-data="{ openCustom: false }" class="mt-2">
                            <button type="button" @click="openCustom = !openCustom" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 flex items-center gap-1.5 transition cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span>+ ¿Servicio o labor personalizada no catalogada?</span>
                            </button>

                            <div x-show="openCustom" x-collapse x-cloak class="mt-2.5 p-3.5 bg-gray-900 border border-gray-700 rounded-xl space-y-3">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                                    <div class="sm:col-span-2">
                                        <input type="text" wire:model="customServiceName" placeholder="Nombre de la labor técnica..." class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-xs text-white placeholder-gray-500 focus:ring-1 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <input type="number" wire:model="customServicePrice" placeholder="Precio ($)..." class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-xs font-bold text-emerald-400 placeholder-gray-500 text-right focus:ring-1 focus:ring-indigo-500">
                                    </div>
                                </div>
                                <button type="button" wire:click="addCustomService" @click="openCustom = false" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs px-3.5 py-1.5 rounded-lg transition cursor-pointer">
                                    + Agregar Labor al Presupuesto
                                </button>
                            </div>
                        </div>

                        <!-- Resumen y Presupuesto Estimado -->
                        <div class="bg-gradient-to-r from-blue-950/40 to-indigo-950/40 border border-blue-500/30 rounded-2xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-lg">
                            <div class="space-y-1">
                                <span class="text-xs font-bold text-blue-300 uppercase tracking-widest block">Resumen del Presupuesto</span>
                                <div class="text-xs text-gray-300 flex items-center gap-3">
                                    <span>🛠️ Mano de Obra: <strong class="text-emerald-400 font-bold">${{ number_format($this->labor_cost, 0, ',', '.') }}</strong></span>
                                    <span>•</span>
                                    <span>📦 Repuestos: <strong class="text-emerald-400 font-bold">${{ number_format(collect($selected_parts)->sum(fn($p) => $p['sale_price'] * $p['quantity']), 0, ',', '.') }}</strong></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 self-end sm:self-auto">
                                <span class="text-xs font-black text-blue-200 uppercase tracking-wider">TOTAL ESTIMADO:</span>
                                <span class="text-2xl font-black text-white bg-blue-600/30 px-3.5 py-1 rounded-xl border border-blue-400/30">${{ number_format($this->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div x-data="{
                                options: ['Mismo día', '24 horas', '2 a 3 días hábiles', '3 a 5 días hábiles', '1 semana', 'A convenir'],
                                custom: false,
                                select(opt) {
                                    this.custom = false;
                                    $wire.set('estimated_delivery', opt);
                                },
                                setCustom() {
                                    this.custom = true;
                                    $wire.set('estimated_delivery', '');
                                    $nextTick(() => $refs.customInput.focus());
                                }
                            }">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tiempo Estimado de Entrega</label>

                            {{-- Chips de selección rápida --}}
                            <div class="flex flex-wrap gap-2 mb-2">
                                <template x-for="opt in options" :key="opt">
                                    <button type="button" @click="select(opt)"
                                        :class="!custom && $wire.estimated_delivery === opt
                                            ? 'bg-teal-600/20 border-teal-500 text-teal-300 shadow shadow-teal-500/10'
                                            : 'bg-gray-800/60 border-gray-700 text-gray-400 hover:border-gray-500 hover:text-gray-200'"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-xs font-semibold transition-all duration-150 cursor-pointer">
                                        <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            x-show="!custom && $wire.estimated_delivery === opt">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <svg class="w-3 h-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            x-show="custom || $wire.estimated_delivery !== opt">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span x-text="opt"></span>
                                    </button>
                                </template>

                                {{-- Chip personalizado --}}
                                <button type="button" @click="setCustom()"
                                    :class="custom
                                        ? 'bg-blue-600/20 border-blue-500 text-blue-300 shadow shadow-blue-500/10'
                                        : 'bg-gray-800/60 border-gray-700 text-gray-400 hover:border-gray-500 hover:text-gray-200'"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-xs font-semibold transition-all duration-150 cursor-pointer">
                                    <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Escribir...
                                </button>
                            </div>

                            {{-- Campo manual (solo visible al pulsar "Escribir...") --}}
                            <div x-show="custom" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0">
                                <input type="text" wire:model="estimated_delivery"
                                    x-ref="customInput"
                                    class="w-full bg-gray-700 border border-blue-500/50 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Ej: 48 horas hábiles, 10 días...">
                            </div>

                            <span class="text-[10px] text-gray-500 mt-1.5 block">Aparecerá en el comprobante del cliente.</span>
                        </div>



                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Abono
                                    Inicial (Dejar en 0 si no paga nada hoy)</label>
                                <input type="number" wire:model.live="down_payment"
                                    class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Método de Pago *</label>

                                {{-- Botones interactivos de Método de Pago --}}
                                <div class="grid grid-cols-3 gap-2">
                                    {{-- Efectivo --}}
                                    <button type="button" wire:click="$set('payment_method', 'Efectivo')"
                                        class="flex flex-col sm:flex-row items-center justify-center gap-1.5 py-2.5 px-3 rounded-2xl border transition-all duration-150 cursor-pointer text-xs font-bold
                                            {{ $payment_method === 'Efectivo'
                                                ? 'bg-emerald-500/15 border-emerald-500 text-emerald-300 shadow-md shadow-emerald-500/10'
                                                : 'bg-gray-800/40 border-gray-700 text-gray-400 hover:border-gray-600 hover:text-gray-200' }}">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            style="{{ $payment_method === 'Efectivo' ? 'color:#34d399;' : '' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="truncate">Efectivo</span>
                                    </button>

                                    {{-- Transferencia --}}
                                    <button type="button" wire:click="$set('payment_method', 'Transferencia')"
                                        class="flex flex-col sm:flex-row items-center justify-center gap-1.5 py-2.5 px-3 rounded-2xl border transition-all duration-150 cursor-pointer text-xs font-bold
                                            {{ $payment_method === 'Transferencia'
                                                ? 'bg-blue-500/15 border-blue-500 text-blue-300 shadow-md shadow-blue-500/10'
                                                : 'bg-gray-800/40 border-gray-700 text-gray-400 hover:border-gray-600 hover:text-gray-200' }}">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            style="{{ $payment_method === 'Transferencia' ? 'color:#60a5fa;' : '' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5h-15V21"/>
                                        </svg>
                                        <span class="truncate">Transferencia</span>
                                    </button>

                                    {{-- Débito/Crédito --}}
                                    <button type="button" wire:click="$set('payment_method', 'Débito/Crédito')"
                                        class="flex flex-col sm:flex-row items-center justify-center gap-1.5 py-2.5 px-3 rounded-2xl border transition-all duration-150 cursor-pointer text-xs font-bold
                                            {{ $payment_method === 'Débito/Crédito'
                                                ? 'bg-purple-500/15 border-purple-500 text-purple-300 shadow-md shadow-purple-500/10'
                                                : 'bg-gray-800/40 border-gray-700 text-gray-400 hover:border-gray-600 hover:text-gray-200' }}">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            style="{{ $payment_method === 'Débito/Crédito' ? 'color:#c084fc;' : '' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                                        </svg>
                                        <span class="truncate">Tarjeta</span>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="bg-gray-900 border border-gray-700 rounded-2xl p-4 flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-400">Saldo Pendiente:</span>
                            <span
                                class="text-xl font-black {{ $this->balance > 0 ? 'text-yellow-400' : 'text-green-400' }}">
                                ${{ number_format($this->balance, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- SECCIÓN 5: FIRMA Y TÉRMINOS LEGALES -->
            <div x-data="{
                    signMode: @if($signature_token) 'qr' @elseif($signature_base64) 'done' @else null @endif,
                    setMode(m) { this.signMode = m; }
                }" class="pt-6 border-t border-gray-700/80 space-y-5" @if($signature_token)
                wire:poll.keep-alive.2s="checkSignatureStatus" @endif>
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-blue-400 flex items-center gap-2">
                        <span
                            class="w-5 h-5 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-xs">5</span>
                        Firma Legal y Términos
                    </h3>
                    <!-- Botón volver si hay modo activo y no hay firma guardada -->
                    <button type="button" x-show="signMode !== null && signMode !== 'done'"
                        @click="signMode = null; $wire.cancelSignatureSession()"
                        class="text-[10px] text-gray-500 hover:text-gray-300 flex items-center gap-1 transition cursor-pointer">
                        ← Cambiar método
                    </button>
                </div>

                @if(session()->has('signature_success'))
                    <div
                        class="p-4 bg-emerald-950/40 border-l-4 border-emerald-500 rounded-r-xl text-emerald-300 text-xs font-bold animate-fade-in flex items-center gap-2">
                        ✨ {{ session('signature_success') }}
                    </div>
                @endif

                <!-- Condiciones Legales -->
                <div class="bg-gray-900 border border-gray-700 rounded-2xl p-4 shadow-inner">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 flex items-center justify-between">
                        <span>Condiciones Legales de Recepción (Editable en configuración)</span>
                    </p>
                    <div class="text-xs font-medium text-gray-300 italic leading-relaxed font-sans whitespace-pre-line overflow-y-auto max-h-60 p-3.5 bg-gray-950/70 rounded-xl border border-gray-800 scrollbar-thin scrollbar-thumb-gray-700">
{{ \App\Models\Setting::find(1)->warranty_text ?? "• GARANTÍA LIMITADA (90 DÍAS): Cobertura de 90 días aplicable únicamente a la falla reparada y repuestos instalados.\n• EXCLUSIONES: Se anula por humedad, golpes, sellos rotos o manipulación de terceros.\n• DATOS: El cliente es responsable de su respaldo de datos.\n• NOTIFICACIONES Y ABANDONO (LEY 19.496): Notificación formal por WhatsApp/Email. Bodegaje a los 30 días y abandono legal a los 90 días." }}
                    </div>
                </div>

                <!-- ══════════════════════════════════════════════ -->
                <!-- MODO: Selección de Método de Firma             -->
                <!-- ══════════════════════════════════════════════ -->
                <div class="space-y-3 animate-fade-in">
                    <p class="text-xs text-gray-400 font-semibold text-center">¿Cómo deseas capturar la firma del cliente?</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                        <!-- Opción 1: QR al celular -->
                        <button type="button" @click="setMode('qr'); $wire.generateSignatureToken()"
                            :class="signMode === 'qr' ? 'bg-blue-950/50 border-blue-500 ring-2 ring-blue-500/30' : 'bg-gray-900/60 border-gray-700 hover:border-blue-500/50'"
                            class="group flex flex-col items-center gap-3 p-4 border rounded-2xl transition-all duration-200 cursor-pointer text-center">
                            <span
                                class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/20 group-hover:bg-blue-500/20 flex items-center justify-center text-xl transition">📲</span>
                            <div>
                                <div class="text-xs font-black text-white group-hover:text-blue-300 transition">Enviar por QR</div>
                                <div class="text-[10px] text-gray-500 mt-0.5 leading-relaxed">El cliente firma desde su celular con QR</div>
                            </div>
                        </button>

                        <!-- Opción 2: Kiosco / Tablet -->
                        <button type="button" @click="setMode('kiosk'); $wire.toggleKioskMode()"
                            :class="signMode === 'kiosk' ? 'bg-indigo-950/50 border-indigo-500 ring-2 ring-indigo-500/30' : 'bg-gray-900/60 border-gray-700 hover:border-indigo-500/50'"
                            class="group flex flex-col items-center gap-3 p-4 border rounded-2xl transition-all duration-200 cursor-pointer text-center">
                            <span
                                class="w-10 h-10 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 group-hover:bg-indigo-500/20 flex items-center justify-center text-xl transition">🖥️</span>
                            <div>
                                <div class="text-xs font-black text-white group-hover:text-indigo-300 transition">Tablet / Kiosco</div>
                                <div class="text-[10px] text-gray-500 mt-0.5 leading-relaxed">Gira la pantalla para firma presencial</div>
                            </div>
                        </button>

                        <!-- Opción 3: Firma en mostrador -->
                        <button type="button" @click="setMode('counter')"
                            :class="signMode === 'counter' ? 'bg-emerald-950/50 border-emerald-500 ring-2 ring-emerald-500/30' : 'bg-gray-900/60 border-gray-700 hover:border-emerald-500/50'"
                            class="group flex flex-col items-center gap-3 p-4 border rounded-2xl transition-all duration-200 cursor-pointer text-center">
                            <span
                                class="w-10 h-10 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 group-hover:bg-emerald-500/20 flex items-center justify-center text-xl transition">✍️</span>
                            <div>
                                <div class="text-xs font-black text-white group-hover:text-emerald-300 transition">Firmar aquí</div>
                                <div class="text-[10px] text-gray-500 mt-0.5 leading-relaxed">Firma directamente en esta pantalla</div>
                            </div>
                        </button>

                        <!-- Opción 4: Cliente Ausente (WhatsApp) -->
                        <button type="button" @click="setMode('absent'); $wire.set('terms_accepted', true)"
                            :class="signMode === 'absent' ? 'bg-amber-950/50 border-amber-500 ring-2 ring-amber-500/30' : 'bg-gray-900/60 border-gray-700 hover:border-amber-500/50'"
                            class="group flex flex-col items-center gap-3 p-4 border rounded-2xl transition-all duration-200 cursor-pointer text-center">
                            <span
                                class="w-10 h-10 rounded-2xl bg-amber-500/10 border border-amber-500/20 group-hover:bg-amber-500/20 flex items-center justify-center text-xl transition">💬</span>
                            <div>
                                <div class="text-xs font-black text-white group-hover:text-amber-300 transition">Cliente Ausente</div>
                                <div class="text-[10px] text-gray-500 mt-0.5 leading-relaxed">Aceptado por WhatsApp o Teléfono</div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- ════════════════════════════════════════════════════ -->
                <!-- MODO CLIENTE AUSENTE: Aceptación Remota vía WhatsApp -->
                <!-- ════════════════════════════════════════════════════ -->
                <div x-show="signMode === 'absent'"
                    class="bg-amber-950/20 border border-amber-800/40 p-5 rounded-3xl space-y-4 animate-fade-in">
                    <div class="flex items-center gap-2 text-xs font-bold text-amber-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                        <span>RECEPCIÓN CON CLIENTE AUSENTE (ACEPTACIÓN POR WHATSAPP/REMOTO)</span>
                    </div>

                    <p class="text-xs text-gray-300 leading-relaxed">
                        Se registrará el ingreso sin firma presencial. Al guardar la orden, el sistema incluirá el enlace de seguimiento web para que el cliente reciba por WhatsApp y lea los <strong>Términos, Condiciones Legales y Garantías</strong> en su teléfono.
                    </p>

                    <div class="bg-gray-950/60 p-4 rounded-2xl border border-gray-800 space-y-2">
                        <span class="text-[10px] font-black uppercase text-amber-400 tracking-wider block">Cláusulas informadas y notificadas al cliente:</span>
                        <ul class="list-disc pl-4 space-y-1 text-xs text-gray-400 font-medium">
                            <li>El cliente asume la responsabilidad de respaldar sus datos personales.</li>
                            <li>El taller no responde por accesorios adicionales no declarados en la orden.</li>
                            <li>Equipos apagados o sulfatados por humedad conllevan riesgo progresivo de placa.</li>
                            <li>Equipos no retirados en 30 días posteriores al aviso pasan a custodia o reciclaje.</li>
                            <li>Garantía exclusiva en la reparación efectuada (no cubre golpes ni sulfatación).</li>
                        </ul>
                    </div>
                </div>

                <!-- ═══════════════════════════════════ -->
                <!-- MODO QR: Panel de espera con QR     -->
                <!-- ═══════════════════════════════════ -->
                @if($signature_token)
                    <div x-show="signMode === 'qr'"
                        class="bg-blue-950/20 border border-blue-800/30 p-6 rounded-3xl space-y-4 animate-fade-in text-center">
                        <div class="flex items-center justify-center gap-2 text-xs font-bold text-blue-300">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-ping"></span>
                            <span>ESPERANDO FIRMA DEL CLIENTE DESDE SU MÓVIL...</span>
                        </div>

                        <div class="py-2">
                            <canvas id="mobile-signature-qr"
                                x-init="new QRious({ element: $el, value: '{{ route('client.signature', ['token' => $signature_token]) }}', size: 180 })"
                                class="mx-auto border-4 border-white rounded-2xl bg-white shadow-xl shadow-blue-500/5"></canvas>
                        </div>

                        <div class="text-[10px] text-gray-400 space-y-2">
                            <p>Indica al cliente que escanee el código QR con la cámara de su celular para leer los términos
                                y firmar con su dedo.</p>
                            <div class="flex gap-2 justify-center flex-wrap">
                                <button type="button"
                                    onclick="navigator.clipboard.writeText('{{ route('client.signature', ['token' => $signature_token]) }}'); alert('Enlace de firma copiado!');"
                                    class="px-3 py-1.5 bg-gray-800 hover:bg-gray-700 rounded-xl text-white font-bold cursor-pointer border border-gray-700">
                                    📋 Copiar Enlace
                                </button>
                                <button type="button" wire:click="cancelSignatureSession" @click="signMode = null"
                                    class="px-3 py-1.5 bg-red-950/40 hover:bg-red-900/40 rounded-xl text-red-400 font-bold cursor-pointer border border-red-900/20">
                                    ❌ Cancelar Sesión
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- ════════════════════════════════════════ -->
                <!-- MODO MOSTRADOR: Canvas de firma local    -->
                <!-- ════════════════════════════════════════ -->
                <div x-show="signMode === 'counter' && !{{ $signature_base64 ? 'true' : 'false' }}"
                    x-data="signaturePad()" class="space-y-3 animate-fade-in">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Firma del
                        Cliente — Aquí en Mostrador</label>
                    <div
                        class="bg-white rounded-2xl border-2 border-dashed border-gray-300 w-full h-48 relative overflow-hidden touch-none shadow-md">
                        <canvas id="signature-pad" class="w-full h-full rounded-2xl cursor-crosshair"></canvas>
                        <button type="button" @click="clearPad"
                            class="absolute bottom-2.5 right-2.5 bg-gray-900 hover:bg-gray-800 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl border border-gray-700 transition cursor-pointer">
                            Limpiar Firma
                        </button>
                    </div>
                    <p class="text-[10px] text-gray-500 text-center">Pídele al cliente que dibuje su firma con el dedo o
                        el mouse dentro del recuadro blanco.</p>
                    <button type="button" @click="savePad(); if($wire.get('signature_base64')) { signMode = 'done'; }"
                        class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-xl text-xs transition cursor-pointer">
                        ✅ Confirmar Firma Capturada
                    </button>
                </div>

                <!-- ══════════════════════════════════════════════════ -->
                <!-- FIRMA CAPTURADA (cualquier modo): Previsualización -->
                <!-- ══════════════════════════════════════════════════ -->
                @if($signature_base64)
                    <div x-data="signaturePad()" x-show="true" class="space-y-3 animate-fade-in">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest text-center">✅ Firma
                            Capturada</label>
                        <div
                            class="bg-white rounded-2xl border-2 border-emerald-500 w-full h-44 relative flex items-center justify-center overflow-hidden shadow-lg shadow-emerald-500/5">
                            <img src="{{ $signature_base64 }}" class="max-h-full object-contain p-4">
                            <button type="button" @click="clearPad(); signMode = null"
                                wire:click="$set('signature_base64', '')"
                                class="absolute bottom-2.5 right-2.5 bg-red-500 hover:bg-red-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl transition cursor-pointer">
                                Limpiar y Firmar de Nuevo
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Checkbox términos -->
                <div class="flex items-start py-2">
                    <div class="flex items-center h-5">
                        <input id="terms" type="checkbox" wire:model="terms_accepted"
                            class="w-5 h-5 border border-gray-600 rounded bg-gray-700 text-blue-500 focus:ring-blue-500 cursor-pointer"
                            required>
                    </div>
                    <label for="terms"
                        class="ml-3 text-xs font-semibold text-gray-300 cursor-pointer select-none leading-normal">
                        El cliente declara haber leído, comprendido y aceptado todas las condiciones y observaciones
                        descritas en este ingreso y presupuesto.
                    </label>
                </div>

                <button type="submit" @click="savePad"
                    class="w-full font-black py-4 px-6 rounded-2xl text-base transition duration-200 flex justify-center items-center gap-2 cursor-pointer shadow-xl"
                    style="background: linear-gradient(135deg, #00C6B6 0%, #0096db 100%); color: #fff; box-shadow: 0 8px 32px rgba(0,198,182,0.25);"
                    onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>🛠️ CREAR ORDEN DE TRABAJO</span>
                </button>
                @error('signature_base64') <span
                class="text-red-400 text-xs mt-2 block text-center font-bold">{{ $message }}</span> @enderror
            </div>


        </form>
    </div>

    <!-- MODAL POST-CREACIÓN DE IMPRESIÓN Y QR -->
    @if($show_success_modal)
        <div
            class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/80 backdrop-blur-sm animate-fade-in">
            <div
                class="bg-gray-800 rounded-3xl max-w-md w-full border border-gray-700 shadow-2xl p-6 text-center space-y-6">

                <div
                    class="w-16 h-16 rounded-full bg-green-500/10 border border-green-500/20 flex items-center justify-center mx-auto text-green-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <div>
                    <h3 class="text-xl font-black text-white">¡Orden de Trabajo Creada!</h3>
                    <p class="text-xs text-gray-400 mt-1.5">La orden de servicio <strong>#{{ $created_order_id }}</strong>
                        ha sido ingresada en el sistema. Puedes proceder a imprimir los comprobantes.</p>
                    @if($this->createdOrder && $this->createdOrder->images && $this->createdOrder->images->count() > 0)
                        <div class="mt-2.5 inline-flex items-center gap-1.5 px-3 py-1 bg-blue-950/80 border border-blue-500/30 text-blue-300 text-xs font-bold rounded-xl">
                            📸 {{ $this->createdOrder->images->count() }} foto(s) de check-in respaldada(s)
                        </div>
                    @endif
                </div>

                <!-- FICHA RÁPIDA PARA CINTA DE ENMASCARAR (SIN IMPRESORA) -->
                @if($this->createdOrder)
                    @php
                        $shortUuid = strtoupper(substr($this->createdOrder->uuid, 0, 8));
                        $clientNameShort = explode(' ', $this->createdOrder->client?->full_name ?? '')[0];
                        $passText = $this->createdOrder->unlock_password ?: 'Sin Clave';
                    @endphp
                    <div class="bg-amber-950/40 border border-amber-500/50 p-4 rounded-2xl text-left space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black uppercase text-amber-400 tracking-wider">🏷️ ESCRIBIR EN LA CINTA DEL EQUIPO:</span>
                            <span class="text-[10px] bg-amber-500/20 text-amber-300 font-mono px-2 py-0.5 rounded font-bold">Marcador / Plumón</span>
                        </div>
                        <div class="bg-amber-100 text-slate-900 p-3 rounded-xl font-mono font-black text-sm shadow-inner border border-amber-300 select-all space-y-1">
                            <div class="text-base text-amber-950 font-black border-b border-amber-300 pb-1 flex items-center justify-between">
                                <span>#{{ $shortUuid }}</span>
                                <span class="text-xs bg-amber-900 text-amber-100 px-2 py-0.5 rounded">{{ $clientNameShort }}</span>
                            </div>
                            <div class="text-xs text-amber-900 font-bold flex items-center justify-between pt-0.5">
                                <span>📱 {{ $this->createdOrder->brand_model }}</span>
                                <span>🔒 {{ $passText }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Botones de Acción de Impresión -->
                <div class="grid grid-cols-1 gap-2.5">
                    @if($this->created_order)
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $this->created_order->client?->phone ?? '');
                            $trackingUrl = url('/seguimiento/' . $this->created_order->uuid);
                            $waMessage = "Hola " . ($this->created_order->client?->full_name ?? 'Cliente') . ", confirmamos el ingreso de tu equipo " . $this->created_order->brand_model . ". Puedes revisar la recepción, presupuesto y los Términos y Condiciones Legales del servicio en este enlace: " . $trackingUrl;
                        @endphp
                        @if($cleanPhone)
                            <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($waMessage) }}" target="_blank"
                                class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3.5 px-4 rounded-2xl text-xs tracking-wide flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20 cursor-pointer">
                                💬 ENVIAR COMPROBANTE Y TÉRMINOS POR WHATSAPP
                            </a>
                        @endif
                    @endif

                    <button type="button" onclick="window.printContent('receipt-print-template', 'qr-canvas-a4')"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-2xl text-xs tracking-wide flex items-center justify-center gap-2 shadow-lg shadow-blue-500/10 cursor-pointer">
                        📄 IMPRIMIR RECIBO CLIENTE (A4 / CARTA)
                    </button>

                    <button type="button" onclick="window.printContent('thermal-label-print-template', 'qr-canvas-thermal')"
                        class="bg-gray-750 hover:bg-gray-700 text-white font-bold py-3.5 px-4 rounded-2xl text-xs tracking-wide flex items-center justify-center gap-2 border border-gray-700 cursor-pointer">
                        🏷️ IMPRIMIR ETIQUETA ADHESIVA (TÉRMICA)
                    </button>

                    <button type="button" wire:click="closeSuccessModal"
                        class="bg-gray-900 hover:bg-gray-850 text-gray-300 font-bold py-3 px-4 rounded-2xl text-xs cursor-pointer">
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
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/95 backdrop-blur-md animate-fade-in"
            x-data="kioskSignaturePad()">
            <div class="bg-gray-900 border border-gray-800 rounded-3xl max-w-lg w-full p-6 space-y-6 shadow-2xl relative">

                <div class="text-center">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-black uppercase tracking-widest">
                        🖥️ Modo Kiosco de Firma
                    </div>
                    <h3 class="text-xl font-black text-white mt-2">Valida e Ingresa tu Firma</h3>
                    <p class="text-xs text-gray-400">Por favor, revisa tus datos, acepta las condiciones y firma en el
                        panel.</p>
                </div>

                <!-- Resumen Simplificado -->
                <div class="bg-gray-950/60 rounded-2xl p-4 border border-gray-800 space-y-2.5 text-xs text-gray-300">
                    <p><strong>Cliente:</strong> <span class="text-white font-bold">{{ $full_name }}</span></p>
                    <p><strong>Equipo:</strong> <span class="text-white font-bold capitalize">{{ $device_type }} /
                            {{ $brand_model }}</span></p>
                    <p><strong>Falla Reportada:</strong> <span class="text-gray-400 italic">{{ $reported_issue }}</span></p>
                    @if($aesthetic_notes)
                        <p class="text-yellow-400/90 font-medium"><strong>Observaciones Estéticas:</strong>
                            {{ $aesthetic_notes }}</p>
                    @endif
                    @if($budget_type === 'pending')
                        <p class="text-blue-400"><strong>Presupuesto:</strong> Sujeto a Diagnóstico Técnico</p>
                    @else
                        <p><strong>Total Estimado:</strong> <span
                                class="text-emerald-400 font-bold">${{ number_format($this->total, 0, ',', '.') }}</span></p>
                    @endif
                </div>

                <!-- Condiciones Legales -->
                <div class="space-y-1.5">
                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-wider">Condiciones Legales de
                        Recepción</span>
                    <div
                        class="bg-gray-950 rounded-2xl p-3.5 border border-gray-800 max-h-48 overflow-y-auto text-xs text-gray-300 italic font-sans leading-relaxed whitespace-pre-line scrollbar-thin scrollbar-thumb-gray-800 scrollbar-track-transparent">
{{ \App\Models\Setting::find(1)->warranty_text ?? "• GARANTÍA LIMITADA (90 DÍAS): Cobertura de 90 días aplicable únicamente a la falla reparada y repuestos instalados.\n• EXCLUSIONES: Se anula por humedad, golpes, sellos rotos o manipulación de terceros.\n• DATOS: El cliente es responsable de su respaldo de datos.\n• NOTIFICACIONES Y ABANDONO (LEY 19.496): Notificación formal por WhatsApp/Email. Bodegaje a los 30 días y abandono legal a los 90 días." }}
                    </div>
                </div>

                <!-- Lienzo Kiosco -->
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="kiosk-terms" type="checkbox" wire:model="terms_accepted"
                                class="w-5 h-5 border border-gray-700 rounded bg-gray-950 text-blue-500 focus:ring-blue-500 cursor-pointer"
                                required>
                        </div>
                        <label for="kiosk-terms"
                            class="ml-3 text-xs font-semibold text-gray-300 cursor-pointer select-none leading-normal">
                            Acepto todas las condiciones y observaciones de recepción del equipo descritas anteriormente.
                        </label>
                    </div>

                    <div class="space-y-1.5">
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Firma
                            Digital del Cliente</label>
                        <div
                            class="bg-white rounded-2xl border-2 border-dashed border-gray-300 w-full h-44 relative overflow-hidden touch-none shadow-inner">
                            <canvas id="kiosk-sig-pad" class="w-full h-full rounded-2xl cursor-crosshair"></canvas>
                            <button type="button" @click="clearKioskPad"
                                class="absolute bottom-2.5 right-2.5 bg-gray-900 hover:bg-gray-850 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl border border-gray-750 transition cursor-pointer">
                                Limpiar Firma
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="grid grid-cols-2 gap-3.5 pt-2">
                    <button type="button" wire:click="toggleKioskMode"
                        class="bg-gray-800 hover:bg-gray-750 text-gray-300 font-bold py-3.5 px-4 rounded-2xl text-xs transition cursor-pointer border border-gray-750">
                        ❌ CANCELAR Y SALIR
                    </button>
                    <button type="button" @click="saveKioskPad"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-2xl text-xs tracking-wide transition shadow-lg shadow-blue-500/10 cursor-pointer">
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