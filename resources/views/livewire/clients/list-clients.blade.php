<div class="space-y-6 animate-fade-in">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Gestión de Clientes</h1>
            <p class="text-sm text-gray-400 mt-1">Administra el listado de clientes de Sointech y registra nuevos perfiles.</p>
        </div>
        
        <button wire:click="openCreateModal" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded-2xl shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition duration-200 cursor-pointer self-start sm:self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Agregar Cliente
        </button>
    </div>

    <!-- FILTER BAR (SEARCH) -->
    <div class="bg-gray-850 p-5 rounded-3xl border border-gray-800 shadow-md flex flex-col sm:flex-row gap-4 items-center justify-between">
        <!-- Search Input -->
        <div class="relative w-full sm:w-96">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live="search" type="text" placeholder="Buscar por nombre, RUT, teléfono..." 
                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
        </div>

        <span class="text-xs font-semibold text-gray-400">
            {{ count($clients) }} clientes registrados
        </span>
    </div>

    <!-- DESKTOP TABLE -->
    <div class="hidden md:block bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden mt-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-900/40 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                        <th class="px-6 py-4">Nombre Completo</th>
                        <th class="px-6 py-4">RUT / DNI</th>
                        <th class="px-6 py-4">Teléfono</th>
                        <th class="px-6 py-4">Correo Electrónico</th>
                        <th class="px-6 py-4 text-center">Órdenes Registradas</th>
                        <th class="px-6 py-4">Fecha Registro</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($clients as $client)
                        <tr class="hover:bg-gray-900/20 transition">
                            <!-- Name -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center font-bold text-xs text-blue-400 shrink-0">
                                        {{ substr($client->full_name, 0, 2) }}
                                    </div>
                                    <span class="font-bold text-white">{{ $client->full_name }}</span>
                                </div>
                            </td>
                            <!-- RUT -->
                            <td class="px-6 py-4 font-mono text-xs text-gray-300">
                                {{ $client->rut_dni ?: 'No registrado' }}
                            </td>
                            <!-- Phone -->
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $client->phone }}
                            </td>
                            <!-- Email -->
                            <td class="px-6 py-4 text-gray-300">
                                {{ $client->email ?: 'No registrado' }}
                            </td>
                            <!-- Total OTs Count -->
                            <td class="px-6 py-4 text-center">
                                @if($client->work_orders_count > 0)
                                    <button wire:click="viewOrders({{ $client->id }})" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-blue-900/40 text-blue-400 border border-blue-500/20 hover:bg-blue-600 hover:text-white transition duration-200 cursor-pointer" title="Ver Órdenes">
                                        {{ $client->work_orders_count }}
                                    </button>
                                @else
                                    <span class="text-gray-500 text-xs">-</span>
                                @endif
                            </td>
                            <!-- Registered Date -->
                            <td class="px-6 py-4 text-xs text-gray-400">
                                {{ $client->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                No se encontraron clientes que coincidan con la búsqueda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MOBILE CARDS -->
    <div class="md:hidden flex flex-col gap-4 mt-6">
        @forelse($clients as $client)
            <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-md p-4 flex flex-col gap-3">
                <div class="flex items-center gap-3 border-b border-gray-800/60 pb-3">
                    <div class="w-10 h-10 rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center font-bold text-sm text-blue-400 shrink-0">
                        {{ substr($client->full_name, 0, 2) }}
                    </div>
                    <div>
                        <div class="font-bold text-white text-base">{{ $client->full_name }}</div>
                        <div class="text-[10px] text-gray-400 font-mono">{{ $client->rut_dni ?: 'Sin RUT' }}</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <span class="block text-[10px] text-gray-500 uppercase">Teléfono</span>
                        <span class="text-gray-300 font-medium">{{ $client->phone }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-gray-500 uppercase">Órdenes</span>
                        @if($client->work_orders_count > 0)
                            <button wire:click="viewOrders({{ $client->id }})" class="text-blue-400 font-bold bg-blue-500/10 px-2 py-0.5 rounded-md hover:bg-blue-500/20 transition cursor-pointer">Ver Órdenes ({{ $client->work_orders_count }})</button>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </div>
                    <div class="col-span-2">
                        <span class="block text-[10px] text-gray-500 uppercase">Email</span>
                        <span class="text-gray-300">{{ $client->email ?: 'No registrado' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-gray-850 rounded-3xl border border-gray-800 p-8 text-center text-gray-500">
                <svg class="w-10 h-10 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <p class="text-sm font-medium">No se encontraron clientes.</p>
            </div>
        @endforelse
    </div>

    <!-- MODAL: ADD CLIENT -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Overlay background -->
            <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <!-- Modal Box -->
                <div class="relative transform overflow-hidden rounded-3xl bg-gray-850 border border-gray-700 px-6 py-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg animate-scale-up">
                    
                    <!-- Background Glow -->
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>

                    <!-- Title -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-800 mb-6 relative z-10">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2" id="modal-title">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Agregar Nuevo Cliente
                        </h3>
                        <button type="button" wire:click="$set('showModal', false)" class="p-1 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <form wire:submit.prevent="saveClient" class="space-y-4">
                        <!-- Full Name -->
                        <div>
                            <label for="new_full_name" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Nombre Completo *</label>
                            <input wire:model="full_name" id="new_full_name" type="text" placeholder="Ej: Carlos Silva Toledo" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                            @error('full_name') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- RUT/DNI -->
                        <div>
                            <label for="new_rut_dni" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">RUT / DNI</label>
                            <input wire:model="rut_dni" id="new_rut_dni" type="text" placeholder="Ej: 19.345.678-9" 
                                x-data x-on:input="$el.value = window.formatRut($el.value); $dispatch('input', $el.value)"
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                            @error('rut_dni') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="new_phone" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">WhatsApp / Teléfono *</label>
                            <input wire:model="phone" id="new_phone" type="text" placeholder="Ej: +56987654321" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                            @error('phone') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="new_email" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Correo Electrónico</label>
                            <input wire:model="email" id="new_email" type="email" placeholder="Ej: carlos@ejemplo.com" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                            @error('email') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800 mt-6">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold rounded-xl transition">
                                Cancelar
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-blue-500/30 transition flex items-center gap-2 cursor-pointer">
                                <span wire:loading.remove wire:target="saveClient">Guardar Cliente</span>
                                <span wire:loading wire:target="saveClient" class="flex items-center gap-1.5">
                                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Guardando...
                                </span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

    <!-- MODAL: VIEW ORDERS -->
    @if($showOrdersModal && $selectedClient)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Overlay background -->
            <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <!-- Modal Box -->
                <div class="relative transform overflow-hidden rounded-3xl bg-gray-850 border border-gray-700 px-6 py-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl animate-scale-up">
                    
                    <!-- Background Glow -->
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>

                    <!-- Title -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-800 mb-6 relative z-10">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2" id="modal-title">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Órdenes de Trabajo - {{ $selectedClient->full_name }}
                        </h3>
                        <button type="button" wire:click="$set('showOrdersModal', false)" class="p-1 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Search Input -->
                    <div class="mb-4 bg-gray-850 rounded-2xl">
                        <div class="relative w-full">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-blue-500">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input wire:model.live="searchOrders" type="text" placeholder="Buscar por OT, dispositivo, modelo o estado..." 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-3 pl-12 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="rounded-2xl border border-gray-800 bg-gray-850">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full text-left text-sm whitespace-nowrap">
                                <thead>
                                    <tr class="bg-gray-900/50 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                                        <th class="px-4 py-4 w-20">OT #</th>
                                        <th class="px-4 py-4">Dispositivo</th>
                                        <th class="px-4 py-4 w-64">Problema Reportado</th>
                                        <th class="px-4 py-4 w-32">Estado</th>
                                        <th class="px-4 py-4 w-32">Ingreso</th>
                                        <th class="px-4 py-4 w-24 text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800/60">
                                    @forelse($clientOrders as $index => $order)
                                        <tr class="hover:bg-gray-900/30 transition">
                                            <td class="px-4 py-3 font-mono font-bold text-blue-400">
                                                OT-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                            </td>
                                            <td class="px-4 py-3 text-white">
                                                <div class="font-bold">{{ $order->device_type }}</div>
                                                <div class="text-[10px] text-gray-400">{{ $order->brand_model ?: 'Genérico' }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-gray-300 whitespace-normal">
                                                <div class="text-xs line-clamp-2" title="{{ $order->reported_issue }}">
                                                    {{ $order->reported_issue }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @php
                                                    $statusColors = [
                                                        'Ingresado' => 'bg-gray-900/50 text-gray-400 border-gray-700',
                                                        'En Revisión' => 'bg-yellow-900/30 text-yellow-400 border-yellow-700/50',
                                                        'Presupuestado' => 'bg-indigo-900/30 text-indigo-400 border-indigo-700/50',
                                                        'Aprobado' => 'bg-blue-900/30 text-blue-400 border-blue-700/50',
                                                        'Rechazado' => 'bg-red-900/30 text-red-400 border-red-700/50',
                                                        'En Reparación' => 'bg-purple-900/30 text-purple-400 border-purple-700/50',
                                                        'Listo para Entrega' => 'bg-emerald-900/30 text-emerald-400 border-emerald-700/50',
                                                        'Entregado' => 'bg-gray-900/50 text-gray-500 border-gray-800',
                                                    ];
                                                    $colorClass = $statusColors[$order->status] ?? 'bg-gray-800 text-gray-300 border-gray-600';
                                                @endphp
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $colorClass }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-400 text-[10px]">
                                                {{ $order->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <a href="{{ route('work-orders.track', $order->uuid) }}" target="_blank" class="inline-flex items-center justify-center p-1.5 bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 rounded-lg transition border border-blue-500/20" title="Ver Seguimiento">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-8 text-center text-gray-500 text-sm">
                                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                                No hay órdenes registradas para este cliente.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-4 border-t border-gray-800 mt-6">
                        <button type="button" wire:click="$set('showOrdersModal', false)" class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold rounded-xl transition">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
