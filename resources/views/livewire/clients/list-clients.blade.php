<div class="space-y-6 pb-16 md:pb-6">

    {{-- Flash Notifications --}}
    @if(session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" />
            <span class="text-emerald-800 dark:text-emerald-300 text-xs font-medium">{{ session('message') }}</span>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="alert-triangle" class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" />
            <span class="text-red-800 dark:text-red-300 text-xs font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50">
                    <x-ui.icon name="user" class="w-5 h-5" />
                </span>
                Gestión de Clientes
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Directorio de clientes, historial de reparaciones y contactos directos.</p>
        </div>

        <button type="button" wire:click="openCreateModal"
            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold rounded-lg shadow-xs transition duration-150 cursor-pointer self-start sm:self-auto">
            <x-ui.icon name="plus" class="w-4 h-4" />
            Nuevo Cliente
        </button>
    </div>

    {{-- Tarjetas de Métricas Rápidas --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        {{-- Total Clientes --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">
                <x-ui.icon name="user" class="w-5 h-5" />
            </div>
            <div>
                <div class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400">Total Clientes</div>
                <div class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mt-0.5">{{ count($clients) }}</div>
            </div>
        </div>

        {{-- Con WhatsApp --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                <x-ui.icon name="phone" class="w-5 h-5" />
            </div>
            <div>
                <div class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400">Contactos Directos</div>
                <div class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mt-0.5">{{ $clients->whereNotNull('phone')->count() }}</div>
            </div>
        </div>

        {{-- Con Órdenes --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400">
                <x-ui.icon name="file-text" class="w-5 h-5" />
            </div>
            <div>
                <div class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400">Clientes Activos</div>
                <div class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mt-0.5">{{ $clients->where('work_orders_count', '>', 0)->count() }}</div>
            </div>
        </div>
    </div>

    {{-- Barra de Búsqueda --}}
    <div class="bg-white dark:bg-zinc-900 rounded-xl p-3.5 border border-zinc-200 dark:border-zinc-800 shadow-xs flex flex-col sm:flex-row gap-3 items-center justify-between">
        <div class="relative w-full sm:w-96">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-zinc-400">
                <x-ui.icon name="search" class="w-4 h-4" />
            </span>
            <input wire:model.live.debounce.150ms="search" type="text"
                placeholder="Buscar por nombre, RUT, teléfono o email..."
                class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-1.5 pl-9 pr-8 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">

            @if($search)
                <button type="button" wire:click="$set('search', '')"
                    class="absolute inset-y-0 right-2.5 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <x-ui.icon name="x" class="w-3.5 h-3.5" />
                </button>
            @endif
        </div>

        <div class="text-[11px] font-medium text-zinc-400 self-end sm:self-center shrink-0">
            Mostrando <span class="font-semibold text-zinc-800 dark:text-zinc-200 font-mono">{{ count($clients) }}</span> cliente{{ count($clients) !== 1 ? 's' : '' }}
        </div>
    </div>

    {{-- TABLA DESKTOP --}}
    <div class="hidden md:block bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 border-b border-zinc-200 dark:border-zinc-800 text-[10px] uppercase text-zinc-500 dark:text-zinc-400 font-semibold tracking-wider">
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">RUT / DNI</th>
                        <th class="px-4 py-3">Teléfono</th>
                        <th class="px-4 py-3">Correo Electrónico</th>
                        <th class="px-4 py-3 text-center">Órdenes</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($clients as $client)
                        <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors">
                            {{-- Nombre --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0 {{ $client->company_name ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}">
                                        @if($client->company_name)
                                            <x-ui.icon name="briefcase" class="w-3.5 h-3.5" />
                                        @else
                                            <x-ui.icon name="user" class="w-3.5 h-3.5" />
                                        @endif
                                    </div>
                                    <div>
                                        @if($client->company_name)
                                            <div class="font-bold text-zinc-900 dark:text-zinc-100 text-xs flex items-center gap-1.5">
                                                <span>{{ $client->company_name }}</span>
                                                <x-ui.badge variant="warning" size="xs">B2B</x-ui.badge>
                                            </div>
                                            <div class="text-[10px] text-zinc-500 mt-0.5">Contacto: {{ $client->full_name }}</div>
                                        @else
                                            <div class="font-semibold text-zinc-800 dark:text-zinc-200 text-xs">{{ $client->full_name }}</div>
                                            <div class="text-[10px] text-zinc-400 mt-0.5">Persona Natural</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- RUT / DNI --}}
                            <td class="px-4 py-3 font-mono text-xs">
                                @if($client->rut_dni)
                                    <span class="text-zinc-700 dark:text-zinc-300 font-semibold">{{ $client->rut_dni }}</span>
                                @else
                                    <span class="text-zinc-400 text-xs italic">Sin RUT</span>
                                @endif
                            </td>

                            {{-- Teléfono / WhatsApp --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-zinc-700 dark:text-zinc-300 text-xs">{{ $client->phone }}</span>
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $client->phone);
                                    @endphp
                                    @if($cleanPhone)
                                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank"
                                            title="Abrir WhatsApp"
                                            class="p-1 rounded text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 transition">
                                            <x-ui.icon name="whatsapp" class="w-3.5 h-3.5" />
                                        </a>
                                    @endif
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="px-4 py-3 text-xs text-zinc-500 dark:text-zinc-400">
                                @if($client->email)
                                    <span class="truncate max-w-[200px] block" title="{{ $client->email }}">{{ $client->email }}</span>
                                @else
                                    <span class="text-zinc-400 italic">No registrado</span>
                                @endif
                            </td>

                            {{-- Órdenes --}}
                            <td class="px-4 py-3 text-center">
                                @if($client->work_orders_count > 0)
                                    <button type="button" wire:click="viewOrders({{ $client->id }})"
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-950/30 hover:bg-orange-100 transition cursor-pointer">
                                        <x-ui.icon name="file-text" class="w-3 h-3" />
                                        <span>{{ $client->work_orders_count }} OT{{ $client->work_orders_count > 1 ? 's' : '' }}</span>
                                    </button>
                                @else
                                    <span class="text-zinc-400 text-xs">0 OTs</span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    {{-- Editar --}}
                                    <button type="button" wire:click="editClient({{ $client->id }})"
                                        title="Editar perfil"
                                        class="p-1.5 text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 rounded transition cursor-pointer">
                                        <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                                    </button>

                                    {{-- Eliminar --}}
                                    <button type="button" wire:click="deleteClient({{ $client->id }})"
                                        wire:confirm="¿Estás seguro de que deseas eliminar este cliente?"
                                        title="Eliminar cliente"
                                        class="p-1.5 text-zinc-400 hover:text-red-500 rounded transition cursor-pointer">
                                        <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-400 dark:text-zinc-500 text-xs">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <x-ui.icon name="user" class="w-8 h-8 text-zinc-300 dark:text-zinc-600" />
                                    <span>No se encontraron clientes registrados.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TARJETAS MOBILE --}}
    <div class="md:hidden flex flex-col gap-2.5">
        @forelse($clients as $client)
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 shadow-xs space-y-2">
                <div class="flex items-center justify-between gap-3 pb-2 border-b border-zinc-100 dark:border-zinc-800">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0 bg-zinc-100 dark:bg-zinc-800 text-zinc-500">
                            <x-ui.icon name="user" class="w-3.5 h-3.5" />
                        </div>
                        <div class="min-w-0">
                            <div class="font-bold text-zinc-900 dark:text-zinc-100 text-xs truncate">{{ $client->full_name }}</div>
                            <div class="text-[10px] text-zinc-400 font-mono">{{ $client->rut_dni ?: 'Sin RUT' }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-1 shrink-0">
                        <button type="button" wire:click="editClient({{ $client->id }})"
                            class="p-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 text-xs font-semibold">
                            <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                        </button>
                        <button type="button" wire:click="deleteClient({{ $client->id }})"
                            wire:confirm="¿Deseas eliminar este cliente?"
                            class="p-1.5 rounded-lg bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 text-xs font-semibold">
                            <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Teléfono</span>
                        <span class="text-zinc-700 dark:text-zinc-300 font-mono">{{ $client->phone }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Órdenes</span>
                        @if($client->work_orders_count > 0)
                            <button wire:click="viewOrders({{ $client->id }})" class="text-orange-600 dark:text-orange-400 font-semibold text-xs hover:underline">
                                Ver {{ $client->work_orders_count }} OT(s)
                            </button>
                        @else
                            <span class="text-zinc-400">-</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-8 text-center text-zinc-400 text-xs">
                No se encontraron clientes.
            </div>
        @endforelse
    </div>

    {{-- MODAL: AGREGAR / EDITAR CLIENTE --}}
    @if($showModal)
        <div class="fixed inset-0 z-[100] overflow-y-auto overscroll-contain flex items-center justify-center p-4 bg-zinc-950/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-2xl p-5 max-w-lg w-full max-h-[90dvh] overflow-y-auto overscroll-contain relative my-auto">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-100 dark:border-zinc-800 mb-4">
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                        <x-ui.icon name="user" class="w-4 h-4 text-orange-500" />
                        <span>{{ $editingClientId ? 'Editar Cliente' : 'Agregar Nuevo Cliente' }}</span>
                    </h3>
                    <button type="button" wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-pointer">
                        <x-ui.icon name="x" class="w-4 h-4" />
                    </button>
                </div>

                <form wire:submit.prevent="saveClient" class="space-y-3.5">
                    <!-- Selector Tipo de Cliente -->
                    <div class="flex bg-zinc-100 dark:bg-zinc-800 p-1 rounded-lg border border-zinc-200 dark:border-zinc-700">
                        <button type="button" wire:click="$set('is_company', false)" 
                            class="flex-1 py-1.5 text-xs font-medium rounded-md transition flex items-center justify-center gap-1.5 cursor-pointer {{ !$is_company ? 'bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 shadow-xs' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100' }}">
                            <x-ui.icon name="user" class="w-3.5 h-3.5" />
                            Persona Natural
                        </button>
                        <button type="button" wire:click="$set('is_company', true)" 
                            class="flex-1 py-1.5 text-xs font-medium rounded-md transition flex items-center justify-center gap-1.5 cursor-pointer {{ $is_company ? 'bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 shadow-xs' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100' }}">
                            <x-ui.icon name="briefcase" class="w-3.5 h-3.5" />
                            Empresa (B2B)
                        </button>
                    </div>

                    @if($is_company)
                    <!-- Campos Empresa -->
                    <div class="space-y-3 bg-zinc-50 dark:bg-zinc-850 p-3.5 rounded-lg border border-zinc-200 dark:border-zinc-800">
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1">Razón Social / Nombre Empresa *</label>
                            <input wire:model="company_name" type="text" placeholder="Ej: Inversiones & Servicios SpA" required
                                class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
                            @error('company_name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Giro Comercial</label>
                                <input wire:model="business_activity" type="text" placeholder="Ej: Servicios Informáticos"
                                    class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Comuna</label>
                                <input wire:model="commune" type="text" placeholder="Ej: Providencia"
                                    class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Dirección Tributaria</label>
                            <input wire:model="address" type="text" placeholder="Ej: Av. Providencia 1234, Oficina 601"
                                class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
                        </div>
                    </div>
                    @endif

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">
                            {{ $is_company ? 'Nombre de Contacto / Encargado *' : 'Nombre Completo *' }}
                        </label>
                        <input wire:model="full_name" type="text" placeholder="Ej: Carlos Silva Toledo" required
                            class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
                        @error('full_name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div x-data>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ $is_company ? 'RUT Empresa *' : 'RUT / DNI' }}
                            </label>
                            <template x-if="$wire.rut_dni && $wire.rut_dni.length >= 8">
                                <span x-text="window.validateRut ? (window.validateRut($wire.rut_dni) ? '✓ Válido' : '✗ Inválido') : ''"
                                    :class="window.validateRut && window.validateRut($wire.rut_dni)
                                        ? 'text-emerald-600 dark:text-emerald-400'
                                        : 'text-amber-600 dark:text-amber-400'"
                                    class="text-[10px] font-mono font-semibold"></span>
                            </template>
                        </div>
                        <input wire:model.live="rut_dni" type="text" placeholder="Ej: 76.543.210-K"
                            x-on:input="if(window.formatRut) { $el.value = window.formatRut($el.value); $dispatch('input', $el.value); }"
                            class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
                        @error('rut_dni') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">WhatsApp / Teléfono *</label>
                        <input wire:model="phone" type="text" placeholder="Ej: +56987654321" required
                            class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
                        @error('phone') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Correo Electrónico (Facturación)</label>
                        <input wire:model="email" type="email" placeholder="Ej: contacto@empresa.cl"
                            class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
                        @error('email') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-zinc-100 dark:border-zinc-800 mt-4">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-4 py-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-lg transition cursor-pointer">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-xs font-semibold text-white bg-orange-600 hover:bg-orange-700 rounded-lg transition shadow-xs cursor-pointer">
                            {{ $editingClientId ? 'Guardar Cambios' : 'Registrar Cliente' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL: VER ÓRDENES DEL CLIENTE --}}
    @if($showOrdersModal && $selectedClient)
        <div class="fixed inset-0 z-[100] overflow-y-auto overscroll-contain flex items-center justify-center p-4 bg-zinc-950/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-2xl p-5 max-w-4xl w-full max-h-[90dvh] overflow-y-auto overscroll-contain relative my-auto">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-100 dark:border-zinc-800 mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                            <x-ui.icon name="file-text" class="w-4 h-4 text-orange-500" />
                            Historial de Órdenes — {{ $selectedClient->full_name }}
                        </h3>
                        <p class="text-[11px] text-zinc-400 mt-0.5">Órdenes de trabajo registradas a nombre de este cliente.</p>
                    </div>
                    <button type="button" wire:click="$set('showOrdersModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-pointer">
                        <x-ui.icon name="x" class="w-4 h-4" />
                    </button>
                </div>

                {{-- Buscador modal --}}
                <div class="relative mb-3">
                    <span class="absolute inset-y-0 left-2.5 flex items-center text-zinc-400">
                        <x-ui.icon name="search" class="w-3.5 h-3.5" />
                    </span>
                    <input wire:model.live="searchOrders" type="text"
                        placeholder="Buscar por OT, equipo, problema o estado..."
                        class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-1.5 pl-8 pr-3 text-xs text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500">
                </div>

                {{-- Tabla de Órdenes --}}
                <div class="rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-800 overflow-x-auto">
                    <table class="w-full text-left text-xs whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 border-b border-zinc-200 dark:border-zinc-800 text-[10px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                <th class="px-3 py-2">Nº OT</th>
                                <th class="px-3 py-2">Equipo</th>
                                <th class="px-3 py-2">Problema Reportado</th>
                                <th class="px-3 py-2">Estado</th>
                                <th class="px-3 py-2">Fecha Ingreso</th>
                                <th class="px-3 py-2 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                            @forelse($clientOrders as $order)
                                <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition">
                                    <td class="px-3 py-2 font-mono font-bold text-orange-600 dark:text-orange-400">
                                        OT-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="font-medium text-zinc-800 dark:text-zinc-200">{{ $order->device_type }}</div>
                                        <div class="text-[10px] text-zinc-400">{{ $order->brand_model ?: 'Genérico' }}</div>
                                    </td>
                                    <td class="px-3 py-2 text-zinc-600 dark:text-zinc-400 max-w-xs truncate" title="{{ $order->reported_issue }}">
                                        {{ $order->reported_issue }}
                                    </td>
                                    <td class="px-3 py-2">
                                        <x-ui.badge variant="neutral" size="xs">
                                            {{ $order->status }}
                                        </x-ui.badge>
                                    </td>
                                    <td class="px-3 py-2 text-zinc-400 font-mono text-[11px]">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <a href="{{ route('work-orders.track', $order->uuid) }}" target="_blank"
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-950/30 hover:underline">
                                            <span>Ver</span> →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-zinc-400 text-xs">
                                        No hay órdenes registradas para este cliente.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end pt-3 mt-3 border-t border-zinc-100 dark:border-zinc-800">
                    <button type="button" wire:click="$set('showOrdersModal', false)"
                        class="px-4 py-1.5 rounded-lg text-xs font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 transition cursor-pointer">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>