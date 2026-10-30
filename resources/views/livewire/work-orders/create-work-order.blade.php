<div class="max-w-4xl mx-auto pb-20" x-data x-init="window.scrollTo({ top: 0, behavior: 'instant' }); $wire.on('order-created', () => window.scrollTo({ top: 0, behavior: 'instant' }))">

    @if(!empty($created_order_id) && !empty($createdOrder))
        <!-- ============================================================== -->
        <!-- VISTA DEDICADA: CONFIRMACIÓN Y COMPROBANTE DE INGRESO EXITOSO   -->
        <!-- (Reemplaza el formulario completo: sin modales, sin scroll extra)-->
        <!-- ============================================================== -->
        @php
            $order = $createdOrder;
            $cleanPhone = preg_replace('/[^0-9]/', '', $order->client?->phone ?? '');
            if (strlen($cleanPhone) === 9 && str_starts_with($cleanPhone, '9')) {
                $cleanPhone = '56' . $cleanPhone;
            }
            $trackingUrl = url('/seguimiento/' . $order->uuid);
            $clientNameShort = explode(' ', $order->client?->full_name ?? 'Cliente')[0];
            $shortUuid = strtoupper(substr($order->uuid, 0, 8));
            $passText = $order->unlock_password ?: 'Sin Clave';
            $waMessage = "Hola {$order->client?->full_name}, confirmamos el ingreso formal de tu equipo {$order->brand_model} (OT #{$order->id}). Puedes revisar el informe técnico, presupuesto y los Términos y Condiciones Legales del servicio en este enlace: {$trackingUrl}";
        @endphp

        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden animate-fade-in space-y-6 p-6 sm:p-8">

            <!-- Banner Principal de Éxito -->
            <div class="text-center space-y-3 pb-6 border-b border-zinc-200 dark:border-zinc-800">
                <div class="w-16 h-16 rounded-full bg-emerald-500/10 border-2 border-emerald-500/30 flex items-center justify-center mx-auto text-emerald-600 dark:text-emerald-400 shadow-inner">
                    <x-ui.icon name="check" class="w-8 h-8 stroke-[2.5]" />
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold uppercase tracking-wider bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Ingreso Registrado con Éxito
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 mt-2">
                        Orden de Trabajo #{{ $order->id }}
                    </h1>
                    <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1 max-w-lg mx-auto">
                        El equipo ha sido registrado formalmente en el laboratorio. Puedes enviar el comprobante digital al cliente e imprimir las etiquetas.
                    </p>
                </div>
            </div>

            <!-- Botonera de Acción Rápida (Optimizado para móvil y escritorio) -->
            <div class="space-y-3">
                <div class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 flex items-center gap-2">
                    <x-ui.icon name="zap" class="w-4 h-4 text-brand-500" />
                    <span>Acciones Inmediatas de Recepción</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @if($cleanPhone)
                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($waMessage) }}" target="_blank"
                            class="sm:col-span-3 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-3.5 px-5 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2.5 transition shadow-sm cursor-pointer">
                            <x-ui.icon name="whatsapp" class="w-5 h-5 shrink-0" />
                            <span>Enviar Comprobante y Términos por WhatsApp</span>
                        </a>
                    @endif

                    <button type="button" onclick="window.printContent('receipt-print-template', 'qr-canvas-a4')"
                        class="bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-100 dark:hover:bg-white text-white dark:text-zinc-900 font-medium py-3 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition cursor-pointer shadow-xs">
                        <x-ui.icon name="printer" class="w-4 h-4 shrink-0" />
                        <span>Imprimir Recibo (A4 / Carta)</span>
                    </button>

                    <button type="button" onclick="window.printStickerLabel({{ $order->id }})"
                        class="bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-900 dark:text-zinc-100 border border-zinc-200 dark:border-zinc-700 font-medium py-3 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition cursor-pointer">
                        <x-ui.icon name="tag" class="w-4 h-4 shrink-0" />
                        <span>Imprimir Etiqueta (Sticker)</span>
                    </button>

                    <a href="{{ $trackingUrl }}" target="_blank"
                        class="bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-900 dark:text-zinc-100 border border-zinc-200 dark:border-zinc-700 font-medium py-3 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition cursor-pointer">
                        <x-ui.icon name="external-link" class="w-4 h-4 shrink-0" />
                        <span>Ver Portal de Seguimiento</span>
                    </a>
                </div>
            </div>

            <!-- Ficha Rápida para Cinta de Enmascarar / Rotulación en Taller -->
            <div class="bg-amber-50 dark:bg-amber-950/20 border-2 border-dashed border-amber-300 dark:border-amber-700/60 rounded-xl p-4 space-y-2">
                <div class="flex items-center justify-between text-xs font-semibold text-amber-800 dark:text-amber-300">
                    <span class="flex items-center gap-1.5 uppercase tracking-wider text-[11px]">
                        🏷️ Rotulación Rápida (Cinta Adhesiva en Equipo):
                    </span>
                    <span class="font-mono bg-amber-200 dark:bg-amber-900/60 px-2 py-0.5 rounded text-[11px]">
                        OT #{{ $order->id }} ({{ $shortUuid }})
                    </span>
                </div>
                <div class="bg-amber-100 dark:bg-amber-900/40 p-3 rounded-lg text-zinc-900 dark:text-zinc-100 space-y-1 font-mono text-xs">
                    <div class="flex justify-between items-center font-bold">
                        <span>OT #{{ $order->id }} • {{ $clientNameShort }}</span>
                        <span class="text-[11px] text-zinc-600 dark:text-zinc-400 font-normal">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[11px] pt-1">
                        <span class="truncate max-w-[240px] font-semibold">{{ $order->brand_model }}</span>
                        <span class="bg-black/10 dark:bg-white/10 px-2 py-0.5 rounded font-bold">{{ $passText }}</span>
                    </div>
                    @if($order->reported_issue)
                        <div class="text-[11px] text-zinc-700 dark:text-zinc-300 pt-1 line-clamp-1 italic">
                            Falla: {{ $order->reported_issue }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Resumen de Datos Clave de la Orden -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <!-- Tarjeta Cliente -->
                <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 space-y-2">
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-zinc-500 block">Datos del Cliente</span>
                    <div class="space-y-1">
                        <div class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm">{{ $order->client?->full_name }}</div>
                        <div class="text-zinc-600 dark:text-zinc-400 flex items-center gap-2">
                            <span>📞 {{ $order->client?->phone ?: 'Sin teléfono' }}</span>
                            @if($order->client?->rut_dni)
                                <span>• RUT: {{ $order->client->rut_dni }}</span>
                            @endif
                        </div>
                        @if($order->client?->email)
                            <div class="text-zinc-500">✉️ {{ $order->client->email }}</div>
                        @endif
                    </div>
                </div>

                <!-- Tarjeta Equipo & Presupuesto -->
                <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 space-y-2">
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-zinc-500 block">Detalles del Equipo</span>
                    <div class="space-y-1">
                        <div class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm">{{ $order->brand_model }}</div>
                        <div class="text-zinc-600 dark:text-zinc-400 flex items-center gap-2">
                            <span class="capitalize">Tipo: {{ $order->device_type }}</span>
                            @if($order->imei_serial)
                                <span>• S/N: {{ $order->imei_serial }}</span>
                            @endif
                        </div>
                        <div class="text-zinc-500">
                            Estado: <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $order->status }}</span>
                            @if($order->total_estimated > 0)
                                • Total: <span class="font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($order->total_estimated, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navegación y Flujo de Trabajo (Dashboard, Nueva OT, Lista) -->
            <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                <button type="button" wire:click="goToDashboard"
                    class="w-full sm:w-auto bg-brand-500 hover:bg-brand-600 text-white font-semibold py-3 px-6 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition shadow-sm cursor-pointer">
                    <x-ui.icon name="layout" class="w-4 h-4 shrink-0" />
                    <span>Ir al Panel de Control (Dashboard)</span>
                </button>

                <div class="flex items-center gap-2.5 w-full sm:w-auto">
                    <button type="button" wire:click="resetForm"
                        class="w-full sm:w-auto bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-800 dark:text-zinc-200 font-medium py-3 px-4 rounded-xl text-xs flex items-center justify-center gap-1.5 transition cursor-pointer">
                        <x-ui.icon name="plus" class="w-3.5 h-3.5 shrink-0" />
                        <span>Ingresar Otra Orden</span>
                    </button>

                    <a href="{{ route('work-orders.index') }}"
                        class="w-full sm:w-auto bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-800 dark:text-zinc-200 font-medium py-3 px-4 rounded-xl text-xs flex items-center justify-center gap-1.5 transition cursor-pointer text-center">
                        <x-ui.icon name="list" class="w-3.5 h-3.5 shrink-0" />
                        <span>Ver Todas</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- PLANTILLAS DE IMPRESIÓN OCULTAS EN EL DOM -->
        <div style="display: none;">
            @include('components.print.work-order-a4', ['templateId' => 'receipt-print-template', 'order' => $order, 'qrCanvasId' => 'qr-canvas-a4'])
            @include('components.print.work-order-thermal', ['templateId' => 'thermal-label-print-template', 'order' => $order, 'qrCanvasId' => 'qr-canvas-thermal'])
        </div>

    @else
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs overflow-hidden">

        <!-- Header -->
        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 mb-1.5">
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider bg-brand-500/10 text-brand-600 dark:text-brand-400 border border-brand-500/20">
                            Sointech • Taller
                        </span>
                    </div>
                    <h2 class="text-xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-100">Nueva Orden de Trabajo</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Registra el ingreso formal de un equipo y respalda el estado de recepción.</p>
                </div>
                <div class="shrink-0 w-10 h-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-600 dark:text-zinc-400">
                    <x-ui.icon name="clipboard" class="w-5 h-5" />
                </div>
            </div>
        </div>

        @if(session()->has('error'))
            <div class="m-6 mb-0 p-3.5 rounded-lg text-xs font-medium flex items-center gap-2 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300">
                <x-ui.icon name="alert-triangle" class="w-4 h-4 shrink-0 text-red-500" />
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($from_quote_number)
            <div class="m-6 mb-0 p-3.5 rounded-lg text-xs font-medium flex items-center justify-between gap-3 bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300">
                <div class="flex items-center gap-2">
                    <x-ui.icon name="file-text" class="w-4 h-4 text-brand-500 shrink-0" />
                    <span>Convirtiendo Cotización <strong class="text-zinc-900 dark:text-zinc-100">#{{ $from_quote_number }}</strong> a Orden de Trabajo. Los datos del cliente, equipo y repuestos han sido cargados.</span>
                </div>
                <span class="px-2 py-0.5 bg-zinc-100 dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 rounded text-[10px] uppercase font-semibold text-zinc-600 dark:text-zinc-300 shrink-0">Cotización Vinculada</span>
            </div>
        @endif

        <form wire:submit.prevent="save" class="p-6 space-y-8">

            <!-- SECCIÓN 1: DATOS DEL CLIENTE -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-700 dark:text-zinc-300 shrink-0">
                        <x-ui.icon name="user" class="w-4 h-4" />
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Datos del Cliente</h3>
                        <p class="text-[11px] text-zinc-500">Busca uno existente o ingresa uno nuevo en caliente</p>
                    </div>
                </div>

                @if(!$client_selected)
                    {{-- Campo de búsqueda --}}
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.150ms="searchClient"
                            class="w-full rounded-lg px-3.5 py-2.5 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"
                            placeholder="Buscar cliente por nombre, teléfono o RUT..."
                            autocomplete="off">

                        @if(strlen($searchClient) > 0 && count($foundClients) === 0)
                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                <svg class="w-4 h-4 animate-spin text-zinc-400" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </div>
                        @endif

                        @if(count($foundClients) > 0)
                            <div class="absolute z-20 w-full mt-1 overflow-hidden rounded-lg shadow-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                                <div class="px-3 py-1.5 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-[10px] font-medium text-zinc-500">
                                    <span>{{ count($foundClients) }} resultado{{ count($foundClients) > 1 ? 's' : '' }} encontrado{{ count($foundClients) > 1 ? 's' : '' }}</span>
                                    <span>Clic para seleccionar</span>
                                </div>
                                <ul class="max-h-60 overflow-y-auto">
                                    @foreach($foundClients as $fc)
                                        <li wire:click="selectClient({{ $fc->id }})"
                                            class="flex items-center gap-3 px-3.5 py-2.5 cursor-pointer transition hover:bg-zinc-50 dark:hover:bg-zinc-800/60 border-b border-zinc-100 dark:border-zinc-800/50 last:border-0 group">
                                            <div class="w-7 h-7 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-600 dark:text-zinc-400 shrink-0">
                                                <x-ui.icon name="user" class="w-3.5 h-3.5" />
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-zinc-900 dark:text-zinc-100 text-xs truncate">{{ $fc->full_name }}</div>
                                                <div class="flex items-center gap-2 mt-0.5 text-[10px] text-zinc-500">
                                                    @if($fc->phone)
                                                        <span class="flex items-center gap-1">
                                                            <x-ui.icon name="phone" class="w-3 h-3 text-zinc-400" />
                                                            {{ $fc->phone }}
                                                        </span>
                                                    @endif
                                                    @if($fc->rut_dni)
                                                        <span>• {{ $fc->rut_dni }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <x-ui.icon name="arrow-right" class="w-3.5 h-3.5 text-zinc-400 opacity-0 group-hover:opacity-100 transition shrink-0" />
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Alerta de Cliente Nuevo -->
                    <div class="bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 px-3.5 py-2.5 rounded-lg flex items-center gap-2.5 text-zinc-600 dark:text-zinc-400 text-xs">
                        <x-ui.icon name="info" class="w-4 h-4 text-zinc-500 shrink-0" />
                        <span><strong>Registro Automático:</strong> Si completas los campos a continuación, el cliente se creará en caliente al guardar la orden.</span>
                    </div>

                    <!-- Campos de Entrada -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Nombre Completo *</label>
                            <input type="text" wire:model="full_name"
                                class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"
                                required>
                        </div>
                        <div>
                            <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Teléfono / WhatsApp *</label>
                            <input type="text" wire:model="phone"
                                class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"
                                placeholder="Ej: +56912345678" required>
                        </div>
                        <div x-data>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">RUT / DNI</label>
                                <template x-if="$wire.rut_dni && $wire.rut_dni.length >= 8">
                                    <span x-text="window.validateRut($wire.rut_dni) ? 'RUT Válido' : 'RUT Inválido'"
                                        :class="window.validateRut($wire.rut_dni)
                                            ? 'text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/30 border-emerald-200 dark:border-emerald-800'
                                            : 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/30 border-amber-200 dark:border-amber-800'"
                                        class="px-1.5 py-0.5 rounded text-[10px] font-medium border"></span>
                                </template>
                            </div>
                            <input type="text" wire:model.live="rut_dni"
                                x-on:input="$el.value = window.formatRut($el.value); $dispatch('input', $el.value)"
                                class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Email</label>
                            <input type="email" wire:model="email"
                                class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>
                @else
                    {{-- Tarjeta de Cliente Seleccionado --}}
                    <div class="rounded-xl p-3.5 bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-700 dark:text-zinc-300 shrink-0">
                                <x-ui.icon name="user" class="w-4 h-4" />
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-semibold text-zinc-900 dark:text-zinc-100 text-xs truncate">{{ $full_name }}</h4>
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-0.5 text-[11px] text-zinc-500">
                                    <span class="flex items-center gap-1">
                                        <x-ui.icon name="phone" class="w-3 h-3 text-zinc-400" />
                                        {{ $phone }}
                                    </span>
                                    @if($rut_dni)
                                        <span>• {{ $rut_dni }}</span>
                                    @endif
                                    @if($email)
                                        <span class="truncate max-w-[160px]">• {{ $email }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2 shrink-0">
                            <button type="button" wire:click="toggleClientEditing"
                                title="{{ $client_editing ? 'Cerrar edición' : 'Editar datos del cliente' }}"
                                class="p-2 rounded-lg border text-xs font-medium transition cursor-pointer {{ $client_editing ? 'bg-zinc-200 dark:bg-zinc-700 border-zinc-300 dark:border-zinc-600 text-zinc-900 dark:text-zinc-100' : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-750' }}">
                                @if($client_editing)
                                    <x-ui.icon name="check" class="w-4 h-4" />
                                @else
                                    <x-ui.icon name="edit" class="w-4 h-4" />
                                @endif
                            </button>

                            <button type="button" wire:click="clearClientSelection"
                                title="Cambiar cliente"
                                class="p-2 rounded-lg bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-500 hover:text-red-600 dark:hover:text-red-400 transition cursor-pointer">
                                <x-ui.icon name="refresh-cw" class="w-4 h-4" />
                            </button>
                        </div>
                    </div>

                    @if($client_editing)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-zinc-50 dark:bg-zinc-800/40 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <div>
                                <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Nombre Completo *</label>
                                <input type="text" wire:model="full_name"
                                    class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none"
                                    required>
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Teléfono / WhatsApp *</label>
                                <input type="text" wire:model="phone"
                                    class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none"
                                    required>
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">RUT / DNI</label>
                                <input type="text" wire:model="rut_dni" x-data
                                    x-on:input="$el.value = window.formatRut($el.value); $dispatch('input', $el.value)"
                                    class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Email</label>
                                <input type="email" wire:model="email"
                                    class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none">
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- SECCIÓN 2: DATOS DEL EQUIPO -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-700 dark:text-zinc-300 shrink-0">
                        <x-ui.icon name="smartphone" class="w-4 h-4" />
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Datos del Dispositivo</h3>
                        <p class="text-[11px] text-zinc-500">Tipo, modelo, número de serie / IMEI y falla reportada</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Tipo de Equipo *</label>
                        <select wire:model.live="device_type"
                            class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none transition"
                            required>
                            <option value="smartphone">Smartphone / Celular</option>
                            <option value="smartwatch">Smartwatch / Reloj Inteligente</option>
                            <option value="allinone">PC All-in-One / iMac</option>
                            <option value="notebook">Notebook / Laptop</option>
                            <option value="desktop">PC de Escritorio (Torre)</option>
                            <option value="tablet">Tablet / iPad</option>
                            <option value="console">Consola de Videojuegos</option>
                            <option value="other">Otro Equipo / Especializado</option>
                        </select>
                    </div>

                    <!-- Marca y Modelo con Predictivo -->
                    <div class="relative">
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Marca y Modelo *</label>
                        <input type="text" wire:model.live="brand_model"
                            class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none transition"
                            placeholder="Ej: iPhone 15 Pro, Galaxy Watch 6, iMac 24" autocomplete="off" required>

                        <!-- Sugerencias del Catálogo Predictivo -->
                        @if(count($foundDevices) > 0)
                            <div class="absolute z-20 w-full mt-1 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg shadow-lg overflow-hidden">
                                <div class="px-3 py-1.5 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-[10px] text-zinc-500 font-medium">
                                    <span>Catálogo Predictivo</span>
                                    <span>Sugerencias en tiempo real</span>
                                </div>
                                <ul class="max-h-60 overflow-y-auto">
                                    @foreach($foundDevices as $device)
                                        <li wire:click="selectDevice('{{ addslashes($device->brand) }}', '{{ addslashes($device->model) }}', '{{ $device->device_type }}')"
                                            class="px-3.5 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-800/60 cursor-pointer border-b border-zinc-100 dark:border-zinc-800/50 last:border-0 flex items-center justify-between text-xs transition group">
                                            <div class="flex items-center gap-2">
                                                <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $device->brand }}</span>
                                                <span class="text-zinc-500">{{ $device->model }}</span>
                                            </div>
                                            <span class="text-[10px] font-medium px-2 py-0.5 rounded border {{ $device->device_type === $device_type ? 'bg-brand-500/10 text-brand-600 dark:text-brand-400 border-brand-500/20' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 border-zinc-200 dark:border-zinc-700' }}">
                                                {{ ucfirst($device->device_type) }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">IMEI / Número de Serie</label>
                        <input type="text" wire:model="imei_serial"
                            class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none transition"
                            placeholder="Nº Serie físico para identificación">
                    </div>
                    <div x-data="{ showPatternDrawer: false }">
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Clave / PIN de Desbloqueo</label>
                            <button type="button" @click="showPatternDrawer = !showPatternDrawer"
                                class="text-[11px] text-brand-600 dark:text-brand-400 hover:underline font-medium flex items-center gap-1 transition">
                                <x-ui.icon name="lock" class="w-3.5 h-3.5" />
                                <span x-text="showPatternDrawer ? 'Ocultar Patrón' : 'Dibujar Patrón'"></span>
                            </button>
                        </div>
                        <input type="text" wire:model="unlock_password" id="unlock_password"
                            class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none transition"
                            placeholder="Ej: Patrón de Z o 1234">

                        <!-- Pattern Drawer -->
                        <div x-show="showPatternDrawer" x-transition
                            class="mt-3 bg-zinc-50 dark:bg-zinc-950 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 space-y-4">
                            <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-800 pb-2">
                                <span class="text-[11px] font-medium text-zinc-500 uppercase tracking-wider">Dibujador de Patrón Interactivo</span>
                                <div class="flex gap-2">
                                    <button type="button" @click="clearPattern"
                                        class="px-2.5 py-1 bg-white hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md text-xs font-medium border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                                        Borrar
                                    </button>
                                    <button type="button" @click="applyPattern"
                                        class="px-2.5 py-1 bg-brand-500 hover:bg-brand-600 text-white rounded-md text-xs font-medium transition cursor-pointer">
                                        Aplicar Patrón
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-col items-center justify-center gap-4 py-2">
                                <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 grid grid-cols-3 grid-rows-3 gap-3 p-4 select-none touch-none shadow-xs"
                                    style="width: 220px; height: 220px; min-width: 220px; min-height: 220px;"
                                    @mousedown="startDrawing" @mousemove="draw" @mouseup="stopDrawing"
                                    @mouseleave="stopDrawing" @touchstart="startDrawing" @touchmove="draw"
                                    @touchend="stopDrawing" id="pattern-matrix">

                                    <canvas id="pattern-canvas"
                                        class="absolute inset-0 w-full h-full pointer-events-none z-10"></canvas>

                                    <template x-for="i in 9" :key="i">
                                        <div class="flex items-center justify-center relative cursor-pointer z-20"
                                            style="width: 100%; height: 100%;" :data-index="i">
                                            <div class="w-10 h-10 flex items-center justify-center rounded-full transition-all duration-150"
                                                :class="isDotSelected(i) ? 'bg-brand-500/20 ring-2 ring-brand-500/40 scale-105' : 'hover:bg-zinc-100 dark:hover:bg-zinc-800 scale-100'">
                                                <div class="w-3 h-3 rounded-full transition-all duration-150"
                                                    :class="isDotSelected(i) ? 'bg-brand-500' : 'bg-zinc-400 dark:bg-zinc-600'">
                                                </div>
                                            </div>
                                            <span class="absolute text-[8px] text-zinc-400 font-mono font-medium pointer-events-none"
                                                style="transform: translateY(16px);" x-text="i"></span>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex flex-col items-center space-y-1.5 text-center shrink-0 w-full border-t border-zinc-200 dark:border-zinc-800 pt-3">
                                    <div class="text-[10px] font-medium text-zinc-500 uppercase tracking-wider">Secuencia del Patrón</div>
                                    <div class="text-xs font-semibold text-brand-600 dark:text-brand-400 font-mono min-h-[18px]" x-text="getPatternText()"></div>
                                    <div class="text-[11px] text-zinc-400 max-w-[240px]">Conecta los puntos para registrar el patrón de desbloqueo.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Falla Reportada por el Cliente *</label>
                        <span class="text-[11px] text-zinc-500">Selecciona fallas frecuentes para añadir rápido</span>
                    </div>

                    @if(count($this->quickTags) > 0)
                        <div class="flex flex-wrap gap-1.5 mb-2">
                            @foreach($this->quickTags as $tag)
                                <button type="button" wire:click="addQuickTag('{{ $tag }}')"
                                    class="px-2.5 py-1 rounded-lg text-xs font-medium bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer flex items-center gap-1 active:scale-95">
                                    <span>{{ $tag }}</span>
                                    <span class="text-zinc-400">+</span>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <textarea wire:model="reported_issue"
                        class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none transition"
                        rows="2.5" placeholder="Describe los síntomas o selecciona de las fallas frecuentes arriba..." required></textarea>
                    @error('reported_issue') <span class="text-red-500 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Estado Inicial Selector (4 Segmented Cards) -->
                <div>
                    <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-2">Estado de Ingreso Inicial *</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2.5">
                        <!-- Ingresado (Celeste / Azul) -->
                        <button type="button" wire:click="$set('initial_status', 'Ingresado')"
                            class="relative flex flex-col items-center gap-2 py-3.5 px-3 rounded-xl border text-center transition-all duration-200 cursor-pointer {{ $initial_status === 'Ingresado' ? 'border-sky-500 bg-sky-500/15 dark:bg-sky-500/20 text-sky-800 dark:text-sky-200 ring-2 ring-sky-500/30 shadow-md shadow-sky-500/10 -translate-y-0.5' : 'border-zinc-200 dark:border-zinc-700/80 bg-zinc-50/80 dark:bg-zinc-800/60 hover:bg-white dark:hover:bg-zinc-800 hover:border-sky-400/60 text-zinc-700 dark:text-zinc-300' }}">
                            @if($initial_status === 'Ingresado')
                                <span class="w-2 h-2 rounded-full bg-sky-400 absolute top-2.5 right-2.5 animate-pulse"></span>
                            @endif
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center transition {{ $initial_status === 'Ingresado' ? 'bg-gradient-to-br from-sky-400 to-blue-600 text-white shadow-md shadow-sky-500/30' : 'bg-sky-500/10 dark:bg-sky-500/15 text-sky-600 dark:text-sky-400' }}">
                                <x-ui.icon name="clock" class="w-4 h-4" />
                            </div>
                            <div>
                                <div class="text-xs font-bold leading-tight">Ingresado</div>
                                <div class="text-[10px] {{ $initial_status === 'Ingresado' ? 'text-sky-700/80 dark:text-sky-300/80' : 'text-zinc-500 dark:text-zinc-400' }} mt-0.5">Cola de espera</div>
                            </div>
                        </button>

                        <!-- En Revisión (Cyan / Azul Tech) -->
                        <button type="button" wire:click="$set('initial_status', 'En Revisión')"
                            class="relative flex flex-col items-center gap-2 py-3.5 px-3 rounded-xl border text-center transition-all duration-200 cursor-pointer {{ $initial_status === 'En Revisión' ? 'border-cyan-500 bg-cyan-500/15 dark:bg-cyan-500/20 text-cyan-800 dark:text-cyan-200 ring-2 ring-cyan-500/30 shadow-md shadow-cyan-500/15 -translate-y-0.5' : 'border-zinc-200 dark:border-zinc-700/80 bg-zinc-50/80 dark:bg-zinc-800/60 hover:bg-white dark:hover:bg-zinc-800 hover:border-cyan-400/60 text-zinc-700 dark:text-zinc-300' }}">
                            @if($initial_status === 'En Revisión')
                                <span class="w-2 h-2 rounded-full bg-cyan-400 absolute top-2.5 right-2.5 animate-pulse"></span>
                            @endif
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center transition {{ $initial_status === 'En Revisión' ? 'bg-gradient-to-br from-cyan-500 to-blue-600 text-white shadow-md shadow-cyan-500/30' : 'bg-cyan-500/10 dark:bg-cyan-500/15 text-cyan-600 dark:text-cyan-400' }}">
                                <x-ui.icon name="search" class="w-4 h-4" />
                            </div>
                            <div>
                                <div class="text-xs font-bold leading-tight">En Revisión</div>
                                <div class="text-[10px] {{ $initial_status === 'En Revisión' ? 'text-cyan-700/80 dark:text-cyan-300/80' : 'text-zinc-500 dark:text-zinc-400' }} mt-0.5">Diagnóstico directo</div>
                            </div>
                        </button>

                        <!-- Aprobado (Esmeralda / Turquesa) -->
                        <button type="button" wire:click="$set('initial_status', 'Aprobado')"
                            class="relative flex flex-col items-center gap-2 py-3.5 px-3 rounded-xl border text-center transition-all duration-200 cursor-pointer {{ $initial_status === 'Aprobado' ? 'border-emerald-500 bg-emerald-500/15 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-200 ring-2 ring-emerald-500/30 shadow-md shadow-emerald-500/10 -translate-y-0.5' : 'border-zinc-200 dark:border-zinc-700/80 bg-zinc-50/80 dark:bg-zinc-800/60 hover:bg-white dark:hover:bg-zinc-800 hover:border-emerald-400/60 text-zinc-700 dark:text-zinc-300' }}">
                            @if($initial_status === 'Aprobado')
                                <span class="w-2 h-2 rounded-full bg-emerald-400 absolute top-2.5 right-2.5 animate-pulse"></span>
                            @endif
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center transition {{ $initial_status === 'Aprobado' ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/30' : 'bg-emerald-500/10 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400' }}">
                                <x-ui.icon name="check-circle" class="w-4 h-4" />
                            </div>
                            <div>
                                <div class="text-xs font-bold leading-tight">Aprobado</div>
                                <div class="text-[10px] {{ $initial_status === 'Aprobado' ? 'text-emerald-700/80 dark:text-emerald-300/80' : 'text-zinc-500 dark:text-zinc-400' }} mt-0.5">Pasa a reparación</div>
                            </div>
                        </button>

                        <!-- Garantía (Ámbar Cálido) -->
                        <button type="button" wire:click="$set('initial_status', 'Garantía')"
                            class="relative flex flex-col items-center gap-2 py-3.5 px-3 rounded-xl border text-center transition-all duration-200 cursor-pointer {{ $initial_status === 'Garantía' ? 'border-amber-500 bg-amber-500/15 dark:bg-amber-500/20 text-amber-800 dark:text-amber-200 ring-2 ring-amber-500/30 shadow-md shadow-amber-500/15 -translate-y-0.5' : 'border-zinc-200 dark:border-zinc-700/80 bg-zinc-50/80 dark:bg-zinc-800/60 hover:bg-white dark:hover:bg-zinc-800 hover:border-amber-400/60 text-zinc-700 dark:text-zinc-300' }}">
                            @if($initial_status === 'Garantía')
                                <span class="w-2 h-2 rounded-full bg-amber-400 absolute top-2.5 right-2.5 animate-pulse"></span>
                            @endif
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center transition {{ $initial_status === 'Garantía' ? 'bg-gradient-to-br from-amber-500 to-orange-600 text-white shadow-md shadow-amber-500/30' : 'bg-amber-500/10 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400' }}">
                                <x-ui.icon name="shield" class="w-4 h-4" />
                            </div>
                            <div>
                                <div class="text-xs font-bold leading-tight">Garantía</div>
                                <div class="text-[10px] {{ $initial_status === 'Garantía' ? 'text-amber-700/80 dark:text-amber-300/80' : 'text-zinc-500 dark:text-zinc-400' }} mt-0.5">Reingreso revisión</div>
                            </div>
                        </button>
                    </div>

                    <p class="mt-2.5 text-[11px] text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                        <x-ui.icon name="info" class="w-3.5 h-3.5 text-brand-500 shrink-0" />
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
                    class="mt-4 p-4 rounded-xl bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Componentes de Hardware</h4>
                            <p class="text-[11px] text-zinc-500">Registra CPU, GPU, RAM, Discos, etc. para evitar reclamos.</p>
                        </div>
                        <button type="button" wire:click="addComponent"
                            class="px-2.5 py-1 bg-white hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 rounded-lg text-xs font-medium transition cursor-pointer">
                            + Agregar Componente
                        </button>
                    </div>

                    @if(count($components) > 0)
                        <div class="space-y-2">
                            @foreach($components as $index => $comp)
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 items-center bg-white dark:bg-zinc-900 p-2.5 rounded-lg border border-zinc-200 dark:border-zinc-800">
                                    <div class="sm:col-span-3">
                                        <select wire:model="components.{{ $index }}.type"
                                            class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-1.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none">
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
                                            class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-1.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none">
                                    </div>
                                    <div class="sm:col-span-3">
                                        <input type="text" wire:model="components.{{ $index }}.model"
                                            placeholder="Modelo o Capacidad"
                                            class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-1.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <input type="text" wire:model="components.{{ $index }}.serial_number"
                                            placeholder="Nº Serie"
                                            class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-1.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none">
                                    </div>
                                    <div class="sm:col-span-1 flex justify-end">
                                        <button type="button" wire:click="removeComponent({{ $index }})"
                                            class="p-1 text-zinc-400 hover:text-red-500 transition"
                                            title="Eliminar componente">
                                            <x-ui.icon name="trash" class="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-3 border border-dashed border-zinc-200 dark:border-zinc-800 rounded-lg">
                            <span class="text-zinc-400 text-xs">No se han registrado componentes adicionales.</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SECCIÓN 3: CHECKLIST DE INGRESO PARAMETRIZABLE -->
            <div class="p-5 rounded-xl bg-zinc-50 dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center gap-3 pb-3 mb-4 border-b border-zinc-200 dark:border-zinc-800">
                    <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-700 dark:text-zinc-300 shrink-0">
                        <x-ui.icon name="check-square" class="w-4 h-4" />
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Checklist y Estado Inicial</h3>
                        <p class="text-[11px] text-zinc-500">Condición física y funcional del equipo al recibirlo</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="flex items-center">
                        <label class="flex items-center space-x-2.5 cursor-pointer">
                            <input type="checkbox" wire:model="turns_on"
                                class="w-4 h-4 text-brand-500 bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-700 rounded focus:ring-brand-500 cursor-pointer">
                            <span class="text-xs font-medium text-zinc-800 dark:text-zinc-200">¿El equipo enciende al recibirlo?</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">¿Tiene sospecha de contacto con líquido?</label>
                        <select wire:model="liquid_contact"
                            class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none">
                            <option>No</option>
                            <option>Sí</option>
                            <option>No sabe / Mojado anteriormente</option>
                        </select>
                    </div>
                </div>

                <!-- checklist_values cargados dinámicamente desde BD de configuraciones -->
                @if(count($checklist_values) > 0)
                    <div class="space-y-2 mb-4">
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-2 px-1">
                            Pruebas Funcionales Realizadas (Desmarca las que fallan)
                        </label>
                        <div class="grid grid-cols-1 min-[440px]:grid-cols-2 sm:grid-cols-3 gap-2" wire:key="chk-grid-{{ $device_type }}">
                            @foreach($checklist_values as $item => $checked)
                                @php
                                    $iconName = 'check-circle';
                                    $i = strtolower($item);
                                    if (str_contains($i, 'enciende')) $iconName = 'zap';
                                    elseif (str_contains($i, 'face id') || str_contains($i, 'touch id')) $iconName = 'shield';
                                    elseif (str_contains($i, 'líquido')) $iconName = 'alert-triangle';
                                    elseif (str_contains($i, 'cámara')) $iconName = 'camera';
                                    elseif (str_contains($i, 'micrófono') || str_contains($i, 'parlante') || str_contains($i, 'auricular')) $iconName = 'volume-2';
                                    elseif (str_contains($i, 'wi-fi') || str_contains($i, 'bluetooth') || str_contains($i, 'red')) $iconName = 'wifi';
                                    elseif (str_contains($i, 'carga') || str_contains($i, 'batería')) $iconName = 'battery';
                                    elseif (str_contains($i, 'teclado') || str_contains($i, 'mouse') || str_contains($i, 'touchpad')) $iconName = 'laptop';
                                    elseif (str_contains($i, 'táctil') || str_contains($i, 'pantalla') || str_contains($i, 'display')) $iconName = 'monitor';
                                @endphp
                                <label wire:key="chk-item-{{ $device_type }}-{{ \Illuminate\Support\Str::slug($item) }}"
                                    class="flex items-center gap-2.5 cursor-pointer p-2.5 rounded-lg border transition duration-150 select-none
                                    {{ $checked
                                        ? 'bg-brand-500/5 border-brand-500/30 text-zinc-900 dark:text-zinc-100'
                                        : 'bg-white dark:bg-zinc-800/40 border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 text-zinc-600 dark:text-zinc-400' }}">
                                    <input type="checkbox" wire:model.live="checklist_values.{{ $item }}"
                                        class="w-4 h-4 text-brand-500 bg-white dark:bg-zinc-900 border-zinc-300 dark:border-zinc-700 rounded focus:ring-brand-500 cursor-pointer shrink-0">
                                    <span class="text-xs font-medium leading-snug whitespace-normal break-words flex-1 flex items-center gap-1.5 min-w-0">
                                        <x-ui.icon :name="$iconName" class="w-3.5 h-3.5 text-zinc-400 shrink-0" />
                                        <span class="break-words leading-tight">{{ $item }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Fotos del Estado Inicial (Opcional, máx 3)</label>
                    <div class="flex items-center gap-3">
                        <label
                            class="flex-shrink-0 cursor-pointer bg-white dark:bg-zinc-800 border border-dashed border-zinc-300 dark:border-zinc-700 hover:border-brand-500 text-zinc-600 dark:text-zinc-400 p-3 rounded-lg flex flex-col items-center justify-center gap-1 transition duration-150 w-28 h-20">
                            <x-ui.icon name="camera" class="w-5 h-5 text-zinc-400" />
                            <span class="text-[11px] font-medium">Subir Fotos</span>
                            <input type="file" @change="compressAndUploadMultiplePhotos($event, 'initialPhotos', $wire)" multiple accept="image/*" class="hidden">
                        </label>

                        <!-- Previews -->
                        <div class="flex flex-wrap gap-2 flex-1">
                            @if($initialPhotos)
                                @foreach($initialPhotos as $index => $photo)
                                    @if(is_object($photo) && method_exists($photo, 'temporaryUrl'))
                                        <div class="w-20 h-20 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden relative group">
                                            <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                            <button type="button"
                                                    wire:click="removeInitialPhoto({{ $index }})"
                                                    class="absolute top-1 right-1 bg-red-600/90 hover:bg-red-600 text-white rounded p-0.5 shadow transition cursor-pointer flex items-center justify-center"
                                                    title="Quitar foto">
                                                <x-ui.icon name="x" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @error('initialPhotos') <span class="text-red-500 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                    @error('initialPhotos.*') <span class="text-red-500 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Daños Físicos o Notas Estéticas (Importante para proteger el taller)</label>
                    <textarea wire:model="aesthetic_notes"
                        class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none transition"
                        rows="2"
                        placeholder="Ej: Pantalla rayada, bisagra suelta, trizado en parte trasera, falta tornillo inferior izquierdo..."></textarea>
                </div>
            </div>

            <!-- SECCIÓN 4: PRESUPUESTO U OPCIÓN DE REVISIÓN -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-700 dark:text-zinc-300 shrink-0">
                        <x-ui.icon name="dollar-sign" class="w-4 h-4" />
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Presupuesto del Servicio</h3>
                        <p class="text-[11px] text-zinc-500">Repuestos, mano de obra y abono inicial (oculto al cliente)</p>
                    </div>
                </div>

                <!-- Tabs Tipo de Presupuesto -->
                <div class="flex gap-1.5 p-1 bg-zinc-100 dark:bg-zinc-800/80 rounded-lg border border-zinc-200 dark:border-zinc-700 w-fit">
                    <button type="button" wire:click="$set('budget_type', 'fixed')"
                        class="px-3 py-1.5 rounded-md text-xs font-medium transition cursor-pointer {{ $budget_type === 'fixed' ? 'bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 shadow-xs' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100' }}">
                        Presupuesto Fijo
                    </button>
                    <button type="button" wire:click="$set('budget_type', 'pending')"
                        class="px-3 py-1.5 rounded-md text-xs font-medium transition cursor-pointer {{ $budget_type === 'pending' ? 'bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 shadow-xs' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100' }}">
                        Por Diagnosticar (Solo Revisión)
                    </button>
                </div>

                @if($budget_type === 'pending')
                    <!-- Tarjeta Modo Diagnóstico sin presupuesto -->
                    <div class="bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 p-4 rounded-xl flex items-start gap-3 text-zinc-600 dark:text-zinc-400 text-xs">
                        <x-ui.icon name="info" class="w-4 h-4 text-zinc-500 shrink-0 mt-0.5" />
                        <div>
                            <strong class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 block mb-1">Modo Diagnóstico Técnico Activado</strong>
                            <p class="leading-relaxed">Se registrará la orden con costos de mano de obra y repuestos en <strong>$0</strong>. El equipo ingresará bajo un estado de "Por Diagnosticar" y podrás elaborar y cargar el presupuesto detallado más tarde de forma digital en la bitácora una vez que el técnico en el taller evalúe la solución.</p>
                        </div>
                    </div>
                @else
                    <!-- Presupuestador normal (Mano de obra, repuestos, etc) -->
                    <div class="space-y-4">
                        {{-- Búsqueda de Repuestos --}}
                        <div class="relative">
                            <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Agregar Repuesto del Inventario</label>
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.150ms="searchPart"
                                    class="w-full rounded-lg px-3 py-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"
                                    placeholder="Buscar repuestos por nombre o categoría..."
                                    autocomplete="off">

                                @if(strlen($searchPart) > 0 && count($foundParts) === 0)
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                        <svg class="w-4 h-4 animate-spin text-zinc-400" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            @if(count($foundParts) > 0)
                                <div class="absolute z-20 w-full mt-1 overflow-hidden rounded-lg shadow-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                                    <div class="px-3 py-1.5 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-[10px] text-zinc-500 font-medium">
                                        <span>{{ count($foundParts) }} repuesto{{ count($foundParts) > 1 ? 's' : '' }} encontrado{{ count($foundParts) > 1 ? 's' : '' }}</span>
                                        <span>Clic para añadir</span>
                                    </div>
                                    <ul class="max-h-56 overflow-y-auto">
                                        @foreach($foundParts as $fp)
                                            <li wire:click="addPart({{ $fp->id }})"
                                                class="flex items-center justify-between px-3.5 py-2 cursor-pointer transition hover:bg-zinc-50 dark:hover:bg-zinc-800/60 border-b border-zinc-100 dark:border-zinc-800/50 last:border-0 group">
                                                <div class="min-w-0">
                                                    <span class="font-medium text-xs text-zinc-900 dark:text-zinc-100 truncate block">{{ $fp->name }}</span>
                                                    <span class="text-[10px] text-zinc-500">Stock: {{ $fp->stock }} • Ref: ${{ number_format($fp->cost_price ?? $fp->sale_price, 0, ',', '.') }}</span>
                                                </div>
                                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 group-hover:border-brand-500/50 group-hover:text-brand-600 transition">
                                                    + Añadir
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <!-- Ingreso directo de Repuesto a Pedido -->
                        <div class="p-3 bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 rounded-xl space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider flex items-center gap-1.5">
                                    <x-ui.icon name="package" class="w-3.5 h-3.5 text-zinc-500" />
                                    Repuesto a Pedido / Precio Costo (Pagado por el Cliente)
                                </span>
                                <span class="text-[10px] text-zinc-500">No requiere stock físico</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                                <div class="sm:col-span-6">
                                    <input type="text" wire:model="customPartName" placeholder="Ej: Pantalla Original Samsung A54..."
                                        class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-2.5 py-1.5 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:ring-1 focus:ring-brand-500 outline-none">
                                </div>
                                <div class="sm:col-span-3">
                                    <input type="number" wire:model="customPartCost" placeholder="Costo ($)..."
                                        class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-2.5 py-1.5 text-xs font-mono font-semibold text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 text-right focus:ring-1 focus:ring-brand-500 outline-none">
                                </div>
                                <div class="sm:col-span-3">
                                    <button type="button" wire:click="addCustomPart"
                                        class="w-full bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-100 dark:hover:bg-white text-white dark:text-zinc-900 font-medium text-xs px-3 py-1.5 rounded-lg transition cursor-pointer">
                                        + Añadir Repuesto
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de repuestos seleccionados -->
                        @if(count($selected_parts) > 0)
                            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 space-y-2">
                                <h4 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider mb-1">Repuestos Asignados (Costo Cliente)</h4>
                                <ul class="space-y-1.5">
                                    @foreach($selected_parts as $index => $part)
                                        <li class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 py-1.5 px-2.5 bg-zinc-50 dark:bg-zinc-800/40 rounded-lg border border-zinc-200 dark:border-zinc-700 text-xs">
                                            <span class="font-medium text-zinc-900 dark:text-zinc-100 flex-1">{{ $part['name'] }}</span>
                                            <div class="flex items-center space-x-2 w-full sm:w-auto justify-end">
                                                <span class="text-[11px] text-zinc-500">Costo ($):</span>
                                                <input type="number" wire:model.live="selected_parts.{{ $index }}.sale_price"
                                                    class="w-24 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded px-2 py-0.5 text-xs font-mono font-semibold text-zinc-900 dark:text-zinc-100 text-right focus:ring-1 focus:ring-brand-500 outline-none">
                                                <button type="button" wire:click="removePart({{ $index }})"
                                                    class="text-zinc-400 hover:text-red-500 transition cursor-pointer p-0.5"
                                                    title="Remover repuesto">
                                                    <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Costo de Envío del Repuesto (Pagado por el Cliente) -->
                        <div class="p-3 bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider flex items-center gap-1.5">
                                    <x-ui.icon name="truck" class="w-3.5 h-3.5 text-zinc-500" />
                                    Costo de Envío del Repuesto (Opcional)
                                </label>
                                <span class="text-[11px] text-zinc-500">Se suma al total del cliente como costo de encargo (no afecta tu utilidad ni IVA)</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto justify-end">
                                <button type="button" wire:click="setQuickShipping(10000)"
                                    class="px-2.5 py-1 rounded-lg text-xs font-medium border transition cursor-pointer {{ (float)$shipping_cost == 10000 ? 'bg-brand-500/10 border-brand-500 text-brand-600 dark:text-brand-400' : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-750' }}">
                                    +$10.000 Envío
                                </button>
                                @if((float)$shipping_cost > 0)
                                    <button type="button" wire:click="setQuickShipping(0)"
                                        class="px-2 py-1 rounded-lg text-xs font-medium bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-500 hover:text-red-500 transition cursor-pointer">
                                        Quitar ($0)
                                    </button>
                                @endif
                                <div class="relative w-28">
                                    <input type="number" wire:model.live="shipping_cost" min="0" step="500"
                                        class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-2.5 py-1 text-xs font-mono font-semibold text-zinc-900 dark:text-zinc-100 text-right focus:ring-1 focus:ring-brand-500 outline-none"
                                        placeholder="0">
                                </div>
                            </div>
                        </div>

                        <!-- Selector del Catálogo de Servicios / Mano de Obra -->
                        <div class="relative">
                            <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">
                                Mano de Obra / Servicios desde Catálogo (Tu Utilidad)
                            </label>
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.150ms="searchService"
                                    class="w-full rounded-lg px-3 py-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"
                                    placeholder="Buscar servicios técnicos por nombre..."
                                    autocomplete="off">

                                @if(strlen($searchService) > 0 && count($foundServices) === 0)
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                        <svg class="w-4 h-4 animate-spin text-zinc-400" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            @if(count($foundServices) > 0)
                                <div class="absolute z-20 w-full mt-1 overflow-hidden rounded-lg shadow-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                                    <div class="px-3 py-1.5 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-[10px] text-zinc-500 font-medium">
                                        <span>{{ count($foundServices) }} servicio{{ count($foundServices) > 1 ? 's' : '' }} en catálogo</span>
                                        <span>Clic para añadir</span>
                                    </div>
                                    <ul class="max-h-56 overflow-y-auto">
                                        @foreach($foundServices as $fs)
                                            <li wire:click="addSelectedService({{ $fs->id }})"
                                                class="flex items-center justify-between px-3.5 py-2 cursor-pointer transition hover:bg-zinc-50 dark:hover:bg-zinc-800/60 border-b border-zinc-100 dark:border-zinc-800/50 last:border-0 group">
                                                <div class="min-w-0">
                                                    <span class="font-medium text-xs text-zinc-900 dark:text-zinc-100 truncate block">{{ $fs->name }}</span>
                                                    <span class="text-[10px] text-zinc-500">Mano de Obra Sugerida: ${{ number_format($fs->price, 0, ',', '.') }}</span>
                                                </div>
                                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 group-hover:border-brand-500/50 group-hover:text-brand-600 transition">
                                                    + Añadir
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <!-- Lista de servicios seleccionados con precios editables -->
                        @if(count($selected_services) > 0)
                            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 space-y-2">
                                <h4 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider mb-1">Servicios Asignados a esta OT</h4>
                                <div class="space-y-1.5">
                                    @foreach($selected_services as $index => $srv)
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 p-2 bg-zinc-50 dark:bg-zinc-800/40 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                            <span class="text-xs font-medium text-zinc-900 dark:text-zinc-100 flex-1">{{ $srv['name'] }}</span>
                                            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                                <span class="text-[11px] text-zinc-500">Precio ($):</span>
                                                <input type="number" wire:model.live="selected_services.{{ $index }}.price" class="w-24 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded px-2 py-0.5 text-xs font-mono font-semibold text-zinc-900 dark:text-zinc-100 text-right focus:ring-1 focus:ring-brand-500 outline-none">
                                                <button type="button" wire:click="removeSelectedService({{ $index }})" class="text-zinc-400 hover:text-red-500 transition cursor-pointer p-0.5">
                                                    <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Formulario para Servicio Personalizado / Extra -->
                        <div x-data="{ openCustom: false }" class="mt-1">
                            <button type="button" @click="openCustom = !openCustom" class="text-xs font-medium text-brand-600 dark:text-brand-400 hover:underline flex items-center gap-1.5 transition cursor-pointer">
                                <x-ui.icon name="plus" class="w-3.5 h-3.5" />
                                <span>¿Servicio o labor personalizada no catalogada?</span>
                            </button>

                            <div x-show="openCustom" x-collapse x-cloak class="mt-2 p-3 bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-700 rounded-lg space-y-2">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <div class="sm:col-span-2">
                                        <input type="text" wire:model="customServiceName" placeholder="Nombre de la labor técnica..." class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-2.5 py-1.5 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:ring-1 focus:ring-brand-500 outline-none">
                                    </div>
                                    <div>
                                        <input type="number" wire:model="customServicePrice" placeholder="Precio ($)..." class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-2.5 py-1.5 text-xs font-mono font-semibold text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 text-right focus:ring-1 focus:ring-brand-500 outline-none">
                                    </div>
                                </div>
                                <button type="button" wire:click="addCustomService" @click="openCustom = false" class="bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-100 dark:hover:bg-white text-white dark:text-zinc-900 font-medium text-xs px-3 py-1.5 rounded-lg transition cursor-pointer">
                                    + Agregar Labor al Presupuesto
                                </button>
                            </div>
                        </div>

                        @php
                            $partsSum = collect($selected_parts)->sum(fn($p) => (float)($p['sale_price'] ?? 0) * (int)($p['quantity'] ?? 1));
                            $thirdPartySum = $partsSum + (float)$this->shipping_cost;
                        @endphp

                        <!-- Resumen y Presupuesto Estimado -->
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div class="space-y-1">
                                <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider block">Resumen del Presupuesto</span>
                                <div class="text-xs text-zinc-600 dark:text-zinc-400 flex flex-wrap items-center gap-x-3 gap-y-1">
                                    <span>Mano de Obra: <strong class="text-zinc-900 dark:text-zinc-100 font-semibold font-mono">${{ number_format((float)$this->labor_cost, 0, ',', '.') }}</strong></span>
                                    <span>•</span>
                                    <span>Repuestos: <strong class="text-zinc-900 dark:text-zinc-100 font-semibold font-mono">${{ number_format($partsSum, 0, ',', '.') }}</strong></span>
                                    @if((float)$this->shipping_cost > 0)
                                        <span>•</span>
                                        <span>Envío: <strong class="text-zinc-900 dark:text-zinc-100 font-semibold font-mono">${{ number_format((float)$this->shipping_cost, 0, ',', '.') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-3 self-end sm:self-auto">
                                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">TOTAL CLIENTE:</span>
                                <span class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 font-mono">${{ number_format($this->total, 0, ',', '.') }}</span>
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
                            <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-2">Tiempo Estimado de Entrega</label>

                            <div class="flex flex-wrap gap-1.5">
                                <template x-for="opt in options" :key="opt">
                                    <button type="button"
                                        @click="select(opt)"
                                        :class="!custom && $wire.estimated_delivery === opt
                                            ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100'
                                            : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-750'"
                                        class="px-2.5 py-1 rounded-lg text-xs font-medium border transition cursor-pointer">
                                        <span x-text="opt"></span>
                                    </button>
                                </template>
                                <button type="button"
                                    @click="setCustom()"
                                    :class="custom || !options.includes($wire.estimated_delivery) && $wire.estimated_delivery !== ''
                                        ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100'
                                        : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-750'"
                                    class="px-2.5 py-1 rounded-lg text-xs font-medium border transition cursor-pointer">
                                    Personalizado...
                                </button>
                            </div>

                            <div x-show="custom || (!options.includes($wire.estimated_delivery) && $wire.estimated_delivery !== '')"
                                x-transition
                                class="mt-2">
                                <input type="text" wire:model="estimated_delivery"
                                    x-ref="customInput"
                                    class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-zinc-900 dark:text-zinc-100 text-xs focus:ring-1 focus:ring-brand-500 outline-none"
                                    placeholder="Ej: 48 horas hábiles, 10 días...">
                            </div>

                            <span class="text-[10px] text-zinc-500 mt-1 block">Aparecerá en el comprobante del cliente.</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Abono Inicial</label>
                                    @if($thirdPartySum > 0)
                                        <button type="button" wire:click="$set('down_payment', {{ $thirdPartySum }})"
                                            class="text-[10px] font-medium text-brand-600 dark:text-brand-400 hover:underline cursor-pointer">
                                            Abonar Repuesto+Envío (${{ number_format($thirdPartySum, 0, ',', '.') }})
                                        </button>
                                    @endif
                                </div>
                                <input type="number" wire:model.live="down_payment"
                                    class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2.5 text-zinc-900 dark:text-zinc-100 text-xs font-mono font-semibold focus:ring-1 focus:ring-brand-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-1">Método de Pago *</label>

                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" wire:click="$set('payment_method', 'Efectivo')"
                                        class="flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg border transition cursor-pointer text-xs font-medium
                                            {{ $payment_method === 'Efectivo'
                                                ? 'bg-zinc-900 dark:bg-zinc-100 border-zinc-900 dark:border-zinc-100 text-white dark:text-zinc-900 shadow-xs'
                                                : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-750' }}">
                                        <x-ui.icon name="banknote" class="w-3.5 h-3.5 shrink-0" />
                                        <span class="truncate">Efectivo</span>
                                    </button>

                                    <button type="button" wire:click="$set('payment_method', 'Transferencia')"
                                        class="flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg border transition cursor-pointer text-xs font-medium
                                            {{ $payment_method === 'Transferencia'
                                                ? 'bg-zinc-900 dark:bg-zinc-100 border-zinc-900 dark:border-zinc-100 text-white dark:text-zinc-900 shadow-xs'
                                                : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-750' }}">
                                        <x-ui.icon name="arrow-right-left" class="w-3.5 h-3.5 shrink-0" />
                                        <span class="truncate">Transferencia</span>
                                    </button>

                                    <button type="button" wire:click="$set('payment_method', 'Débito/Crédito')"
                                        class="flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg border transition cursor-pointer text-xs font-medium
                                            {{ $payment_method === 'Débito/Crédito'
                                                ? 'bg-zinc-900 dark:bg-zinc-100 border-zinc-900 dark:border-zinc-100 text-white dark:text-zinc-900 shadow-xs'
                                                : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-750' }}">
                                        <x-ui.icon name="credit-card" class="w-3.5 h-3.5 shrink-0" />
                                        <span class="truncate">Tarjeta</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 flex justify-between items-center">
                            <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Saldo Pendiente:</span>
                            <span class="text-base font-semibold font-mono text-zinc-900 dark:text-zinc-100">
                                ${{ number_format($this->balance, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- SECCIÓN 5: FIRMA Y TÉRMINOS LEGALES -->
            <div x-data="{
                signMode: 'absent',
                setMode(m) {
                    this.signMode = m;
                    if (m === 'counter') {
                        $nextTick(() => {
                            if (window.sigPad) window.sigPad.resize();
                        });
                    }
                }
            }" class="space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-700 dark:text-zinc-300 shrink-0">
                        <x-ui.icon name="edit" class="w-4 h-4" />
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Firma y Aceptación de Condiciones</h3>
                        <p class="text-[11px] text-zinc-500">Selecciona el canal para la firma y consentimiento del cliente</p>
                    </div>
                </div>

                <!-- Selector de Canal de Firma -->
                <div>
                    <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider mb-2">Canal de Firma del Cliente</label>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                        <!-- Opción 1: QR (Morado) -->
                        <!-- Opción 1: QR Smartphone (Azul Tech) -->
                        <button type="button" @click="setMode('qr'); $wire.generateSignatureToken()"
                            :class="signMode === 'qr' ? 'border-blue-500 bg-blue-500/15 dark:bg-blue-500/20 text-blue-800 dark:text-blue-200 ring-2 ring-blue-500/30 shadow-md shadow-blue-500/15 -translate-y-0.5' : 'bg-zinc-50/80 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700/80 hover:bg-white dark:hover:bg-zinc-800 hover:border-blue-400/60'"
                            class="flex flex-col items-center gap-2 p-3.5 border rounded-xl transition-all duration-200 cursor-pointer text-center">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center transition" :class="signMode === 'qr' ? 'bg-gradient-to-br from-blue-600 to-cyan-500 text-white shadow-md shadow-blue-500/30' : 'bg-blue-500/10 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400'">
                                <x-ui.icon name="qr-code" class="w-4 h-4" />
                            </div>
                            <div>
                                <div class="text-xs font-bold">Código QR</div>
                                <div class="text-[10px] opacity-75 mt-0.5">Desde su smartphone</div>
                            </div>
                        </button>

                        <!-- Opción 2: Kiosco / Tablet (Celeste / Azul) -->
                        <button type="button" @click="setMode('kiosk'); $wire.toggleKioskMode()"
                            :class="signMode === 'kiosk' ? 'border-sky-500 bg-sky-500/15 dark:bg-sky-500/20 text-sky-800 dark:text-sky-200 ring-2 ring-sky-500/30 shadow-md shadow-sky-500/10 -translate-y-0.5' : 'bg-zinc-50/80 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700/80 hover:bg-white dark:hover:bg-zinc-800 hover:border-sky-400/60'"
                            class="flex flex-col items-center gap-2 p-3.5 border rounded-xl transition-all duration-200 cursor-pointer text-center">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center transition" :class="signMode === 'kiosk' ? 'bg-gradient-to-br from-sky-400 to-blue-600 text-white shadow-md shadow-sky-500/30' : 'bg-sky-500/10 dark:bg-sky-500/15 text-sky-600 dark:text-sky-400'">
                                <x-ui.icon name="tablet" class="w-4 h-4" />
                            </div>
                            <div>
                                <div class="text-xs font-bold">Tablet / Kiosco</div>
                                <div class="text-[10px] opacity-75 mt-0.5">Gira la pantalla</div>
                            </div>
                        </button>

                        <!-- Opción 3: Firma en mostrador (Esmeralda / Teal) -->
                        <button type="button" @click="setMode('counter')"
                            :class="signMode === 'counter' ? 'border-emerald-500 bg-emerald-500/15 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-200 ring-2 ring-emerald-500/30 shadow-md shadow-emerald-500/15 -translate-y-0.5' : 'bg-zinc-50/80 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700/80 hover:bg-white dark:hover:bg-zinc-800 hover:border-emerald-400/60'"
                            class="flex flex-col items-center gap-2 p-3.5 border rounded-xl transition-all duration-200 cursor-pointer text-center">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center transition" :class="signMode === 'counter' ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/30' : 'bg-emerald-500/10 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400'">
                                <x-ui.icon name="edit-3" class="w-4 h-4" />
                            </div>
                            <div>
                                <div class="text-xs font-bold">Firmar Aquí</div>
                                <div class="text-[10px] opacity-75 mt-0.5">Firma en pantalla</div>
                            </div>
                        </button>

                        <!-- Opción 4: Cliente Ausente (WhatsApp Esmeralda) -->
                        <button type="button" @click="setMode('absent'); $wire.set('terms_accepted', true)"
                            :class="signMode === 'absent' ? 'border-emerald-500 bg-emerald-500/15 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-200 ring-2 ring-emerald-500/30 shadow-md shadow-emerald-500/10 -translate-y-0.5' : 'bg-zinc-50/80 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700/80 hover:bg-white dark:hover:bg-zinc-800 hover:border-emerald-400/60'"
                            class="flex flex-col items-center gap-2 p-3.5 border rounded-xl transition-all duration-200 cursor-pointer text-center">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center transition" :class="signMode === 'absent' ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/30' : 'bg-emerald-500/10 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400'">
                                <x-ui.icon name="whatsapp" class="w-4 h-4" />
                            </div>
                            <div>
                                <div class="text-xs font-bold">Cliente Ausente</div>
                                <div class="text-[10px] opacity-75 mt-0.5">WhatsApp / Remoto</div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- MODO CLIENTE AUSENTE -->
                <div x-show="signMode === 'absent'"
                    class="bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 p-4 rounded-xl space-y-3">
                    <div class="flex items-center gap-2 text-xs font-semibold text-zinc-900 dark:text-zinc-100">
                        <x-ui.icon name="check-circle" class="w-4 h-4 text-emerald-500" />
                        <span>Recepción con Cliente Ausente (Aceptación por WhatsApp / Remoto)</span>
                    </div>

                    <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Se registrará el ingreso sin firma presencial. Al guardar la orden, el sistema incluirá el enlace de seguimiento web para que el cliente reciba por WhatsApp los <strong>Términos, Condiciones Legales y Garantías</strong> en su teléfono.
                    </p>

                    <div class="bg-white dark:bg-zinc-900 p-3 rounded-lg border border-zinc-200 dark:border-zinc-800 space-y-1.5">
                        <span class="text-[10px] font-semibold uppercase text-zinc-500 tracking-wider block">Cláusulas informadas al cliente:</span>
                        <ul class="list-disc pl-4 space-y-1 text-xs text-zinc-600 dark:text-zinc-400">
                            <li>El cliente asume la responsabilidad de respaldar sus datos personales.</li>
                            <li>El taller no responde por accesorios adicionales no declarados en la orden.</li>
                            <li>Equipos apagados o sulfatados por humedad conllevan riesgo progresivo de placa.</li>
                            <li>Equipos no retirados en 30 días posteriores al aviso pasan a custodia o reciclaje.</li>
                            <li>Garantía exclusiva en la reparación efectuada (no cubre golpes ni sulfatación).</li>
                        </ul>
                    </div>
                </div>

                <!-- MODO QR -->
                @if($signature_token)
                    <div x-show="signMode === 'qr'"
                        class="bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 p-5 rounded-xl space-y-3 text-center">
                        <div class="flex items-center justify-center gap-2 text-xs font-semibold text-zinc-900 dark:text-zinc-100">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                            <span>Esperando firma del cliente desde su móvil...</span>
                        </div>

                        <div class="py-2">
                            <canvas id="mobile-signature-qr"
                                x-init="new QRious({ element: $el, value: '{{ route('client.signature', ['token' => $signature_token]) }}', size: 160 })"
                                class="mx-auto border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white p-2 shadow-xs"></canvas>
                        </div>

                        <p class="text-xs text-zinc-500">Pídele al cliente que escanee el código con su cámara para firmar en pantalla.</p>
                    </div>
                @endif

                <!-- MODO MOSTRADOR (Firma en esta pantalla) -->
                <div x-show="signMode === 'counter'" class="space-y-3" x-data="signaturePad()">
                    <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider text-center">Lienzo de Firma en Mostrador</label>
                    <div class="bg-white rounded-xl border border-zinc-300 dark:border-zinc-700 w-full h-44 relative overflow-hidden touch-none shadow-xs">
                        <canvas id="signature-pad" class="w-full h-full cursor-crosshair"></canvas>
                        <button type="button" @click="clearPad"
                            class="absolute bottom-2 right-2 bg-zinc-800 hover:bg-zinc-700 text-white text-[10px] font-medium px-2.5 py-1 rounded border border-zinc-600 transition cursor-pointer">
                            Limpiar Firma
                        </button>
                    </div>
                    <p class="text-[11px] text-zinc-500 text-center">Dibuja la firma con el dedo o el mouse dentro del recuadro.</p>
                    <button type="button" @click="savePad(); if($wire.get('signature_base64')) { signMode = 'done'; }"
                        class="w-full py-2 bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-100 dark:hover:bg-white text-white dark:text-zinc-900 font-medium rounded-lg text-xs transition cursor-pointer">
                        Confirmar Firma Capturada
                    </button>
                </div>

                <!-- FIRMA CAPTURADA: Previsualización -->
                @if($signature_base64)
                    <div x-data="signaturePad()" x-show="true" class="space-y-2">
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider text-center">Firma Registrada</label>
                        <div class="bg-white rounded-xl border border-zinc-200 dark:border-zinc-700 w-full h-40 relative flex items-center justify-center overflow-hidden shadow-xs">
                            <img src="{{ $signature_base64 }}" class="max-h-full object-contain p-4">
                            <button type="button" @click="clearPad(); signMode = null"
                                wire:click="$set('signature_base64', '')"
                                class="absolute bottom-2 right-2 bg-zinc-800 hover:bg-zinc-700 text-white text-[10px] font-medium px-2.5 py-1 rounded transition cursor-pointer">
                                Limpiar y Firmar de Nuevo
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Checkbox términos -->
                <div class="flex items-start py-2">
                    <div class="flex items-center h-5">
                        <input id="terms" type="checkbox" wire:model="terms_accepted"
                            class="w-4 h-4 border border-zinc-300 dark:border-zinc-700 rounded bg-white dark:bg-zinc-900 text-brand-500 focus:ring-brand-500 cursor-pointer"
                            required>
                    </div>
                    <label for="terms"
                        class="ml-2.5 text-xs text-zinc-600 dark:text-zinc-400 cursor-pointer select-none leading-normal">
                        El cliente declara haber leído, comprendido y aceptado todas las condiciones y observaciones descritas en este ingreso y presupuesto.
                    </label>
                </div>

                @if ($errors->any())
                    <div class="p-3 bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 text-xs rounded-lg space-y-1">
                        <div class="font-semibold flex items-center gap-1.5">
                            <x-ui.icon name="alert-triangle" class="w-4 h-4 shrink-0" />
                            <span>Por favor corrige los siguientes campos antes de guardar:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 text-[11px] pl-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" @click="savePad"
                    class="w-full font-medium py-3 px-6 rounded-lg text-sm transition duration-150 flex justify-center items-center gap-2 cursor-pointer bg-brand-500 hover:bg-brand-600 text-white shadow-xs">
                    <svg wire:loading wire:target="save" class="animate-spin h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Crear Orden de Trabajo</span>
                </button>
                @error('signature_base64') <span class="text-red-500 text-xs mt-1 block text-center font-medium">{{ $message }}</span> @enderror
            </div>

        </form>
    </div>
    @endif

    <!-- MODAL CLIENTE KIOSCO (FIRMA EN PANTALLA) -->
    @if($kiosk_mode)
        <div class="fixed inset-0 z-[100] overflow-y-auto overscroll-contain flex items-center justify-center p-4 bg-zinc-950/80 backdrop-blur-xs animate-fade-in"
            x-data="kioskSignaturePad()">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl max-w-lg w-full max-h-[90dvh] overflow-y-auto overscroll-contain p-6 space-y-5 shadow-2xl relative my-auto">

                <div class="text-center">
                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-brand-500/10 border border-brand-500/20 text-brand-600 dark:text-brand-400 text-xs font-medium uppercase tracking-wider">
                        Modo Kiosco de Firma
                    </div>
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100 mt-2">Valida e Ingresa tu Firma</h3>
                    <p class="text-xs text-zinc-500">Por favor, revisa tus datos, acepta las condiciones y firma en el panel.</p>
                </div>

                <!-- Resumen Simplificado -->
                <div class="bg-zinc-50 dark:bg-zinc-950 rounded-lg p-3.5 border border-zinc-200 dark:border-zinc-800 space-y-2 text-xs text-zinc-600 dark:text-zinc-400">
                    <p><strong class="text-zinc-900 dark:text-zinc-100">Cliente:</strong> {{ $full_name }}</p>
                    <p><strong class="text-zinc-900 dark:text-zinc-100">Equipo:</strong> {{ ucfirst($device_type) }} / {{ $brand_model }}</p>
                    <p><strong class="text-zinc-900 dark:text-zinc-100">Falla Reportada:</strong> {{ $reported_issue }}</p>
                    @if($aesthetic_notes)
                        <p><strong class="text-zinc-900 dark:text-zinc-100">Observaciones Estéticas:</strong> {{ $aesthetic_notes }}</p>
                    @endif
                    @if($budget_type === 'pending')
                        <p class="text-brand-600 dark:text-brand-400 font-medium">Presupuesto: Sujeto a Diagnóstico Técnico</p>
                    @else
                        <p><strong class="text-zinc-900 dark:text-zinc-100">Total Estimado:</strong> <span class="font-mono font-semibold text-zinc-900 dark:text-zinc-100">${{ number_format($this->total, 0, ',', '.') }}</span></p>
                    @endif
                </div>

                <!-- Condiciones Legales -->
                <div class="space-y-1">
                    <span class="text-[10px] font-medium text-zinc-500 uppercase tracking-wider">Condiciones Legales de Recepción</span>
                    <div class="bg-zinc-50 dark:bg-zinc-950 rounded-lg p-3 border border-zinc-200 dark:border-zinc-800 max-h-40 overflow-y-auto text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed whitespace-pre-line">
{{ \App\Models\Setting::find(1)->warranty_text ?? "• GARANTÍA LIMITADA (90 DÍAS): Cobertura de 90 días aplicable únicamente a la falla reparada y repuestos instalados.
• EXCLUSIONES: Se anula por humedad, golpes, sellos rotos o manipulación de terceros.
• DATOS: El cliente es responsable de su respaldo de datos.
• NOTIFICACIONES Y ABANDONO (LEY 19.496): Notificación formal por WhatsApp/Email. Bodegaje a los 30 días y abandono legal a los 90 días." }}
                    </div>
                </div>

                <!-- Lienzo Kiosco -->
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="kiosk-terms" type="checkbox" wire:model="terms_accepted"
                                class="w-4 h-4 border border-zinc-300 dark:border-zinc-700 rounded bg-white dark:bg-zinc-900 text-brand-500 focus:ring-brand-500 cursor-pointer"
                                required>
                        </div>
                        <label for="kiosk-terms"
                            class="ml-2.5 text-xs text-zinc-600 dark:text-zinc-400 cursor-pointer select-none leading-normal">
                            Acepto las condiciones legales y observaciones aquí declaradas.
                        </label>
                    </div>

                    <div class="bg-white rounded-lg border border-zinc-300 dark:border-zinc-700 w-full h-44 relative overflow-hidden touch-none shadow-xs">
                        <canvas id="kiosk-signature-pad" class="w-full h-full cursor-crosshair"></canvas>
                        <button type="button" @click="clearKioskPad"
                            class="absolute bottom-2 right-2 bg-zinc-800 hover:bg-zinc-700 text-white text-[10px] font-medium px-2.5 py-1 rounded transition cursor-pointer">
                            Limpiar
                        </button>
                    </div>

                    <div class="flex gap-2">
                        <button type="button" wire:click="toggleKioskMode"
                            class="w-1/3 py-2 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 font-medium rounded-lg text-xs transition cursor-pointer">
                            Salir
                        </button>
                        <button type="button" @click="saveKioskPad"
                            class="w-2/3 py-2 bg-brand-500 hover:bg-brand-600 text-white font-medium rounded-lg text-xs transition cursor-pointer">
                            Confirmar y Cerrar
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>

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
