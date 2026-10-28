<div class="space-y-6 pb-16 md:pb-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50">
                    <x-ui.icon name="file-text" class="w-5 h-5" />
                </span>
                Gestión de Cotizaciones
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Crea, envía, imprime y convierte cotizaciones formales para tus clientes.</p>
        </div>

        <a href="{{ route('quotations.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold rounded-lg shadow-xs transition duration-150 self-start sm:self-auto">
            <x-ui.icon name="plus" class="w-4 h-4" />
            <span>Nueva Cotización</span>
        </a>
    </div>

    <!-- Flash Messages -->
    @if(session()->has('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" />
            <span class="text-emerald-800 dark:text-emerald-300 text-xs font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="alert-triangle" class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" />
            <span class="text-red-800 dark:text-red-300 text-xs font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Buscador y Filtros -->
    <div class="bg-white dark:bg-zinc-900 p-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <!-- Search -->
            <div class="md:col-span-8 w-full min-w-0">
                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Buscar Cotización</label>
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-zinc-400 pointer-events-none">
                        <x-ui.icon name="search" class="w-4 h-4" />
                    </span>
                    <input 
                        wire:model.live.debounce.300ms="search" 
                        type="text" 
                        placeholder="Buscar por Folio, Cliente o Equipo..." 
                        class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-1.5 pl-9 pr-8 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition"
                    >
                    @if($search)
                        <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                            <x-ui.icon name="x" class="w-3.5 h-3.5" />
                        </button>
                    @endif
                </div>
            </div>
            
            <!-- Status Filter -->
            <div class="md:col-span-4 w-full">
                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Estado</label>
                <select wire:model.live="status" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg py-1.5 px-2.5 text-xs text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500 transition cursor-pointer">
                    <option value="">Todos los Estados</option>
                    <option value="borrador">Borrador</option>
                    <option value="enviada">Enviada</option>
                    <option value="aceptada">Aceptada</option>
                    <option value="convertida">Convertida a OT</option>
                    <option value="rechazada">Rechazada / Anulada</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Content Container -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xs overflow-hidden">
        
        <!-- DESKTOP TABLE -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 border-b border-zinc-200 dark:border-zinc-800 text-[10px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        <th class="px-4 py-3">Folio / Fecha</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Equipo / Servicio</th>
                        <th class="px-4 py-3 text-right">Total ($)</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($quotations as $quote)
                        <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition duration-150">
                            <td class="px-4 py-3">
                                <span class="font-mono text-xs font-semibold text-orange-600 dark:text-orange-400">
                                    {{ $quote->quote_number }}
                                </span>
                                <div class="text-[10px] text-zinc-400">{{ $quote->created_at->format('d/m/Y H:i') }} hrs</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col">
                                    <span class="text-zinc-800 dark:text-zinc-200 font-semibold text-xs">{{ $quote->client_name ?? 'Cliente General' }}</span>
                                    <span class="text-[10px] text-zinc-400 font-mono flex items-center gap-1 mt-0.5">
                                        @if($quote->client_phone)
                                            <x-ui.icon name="phone" class="w-3 h-3 text-zinc-400" />
                                            {{ $quote->client_phone }}
                                        @else
                                            {{ $quote->client_email ?? 'Sin contacto' }}
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 max-w-xs">
                                <div class="flex flex-col">
                                    <span class="text-zinc-700 dark:text-zinc-300 font-medium truncate">{{ $quote->device_info ?? 'Equipo' }}</span>
                                    <span class="text-[10px] text-zinc-400 mt-0.5">{{ count($quote->items) }} ítems detallados</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-zinc-900 dark:text-zinc-100 text-xs">
                                <div>${{ number_format($quote->total, 0, ',', '.') }}</div>
                                <div class="text-[10px] font-normal text-zinc-400">
                                    @if($quote->tax_included)
                                        Bruto (IVA Inc.)
                                    @elseif((float)$quote->tax_amount > 0)
                                        @php
                                            $servicesSum = $quote->items->where('type', 'servicio')->sum(fn($i) => $i->quantity * $i->unit_price);
                                            $expectedLaborTax = round($servicesSum * 0.19);
                                            $isLaborOnly = ($servicesSum > 0 && abs($expectedLaborTax - (float)$quote->tax_amount) < 5);
                                        @endphp
                                        {{ $isLaborOnly ? 'IVA M. Obra' : 'Neto + IVA' }}
                                    @else
                                        Exento
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $badgeVariant = match($quote->status) {
                                        'aceptada', 'convertida' => 'success',
                                        'enviada' => 'info',
                                        'rechazada' => 'danger',
                                        default => 'neutral'
                                    };
                                @endphp
                                <x-ui.badge :variant="$badgeVariant" size="xs">
                                    {{ $quote->status_label }}
                                </x-ui.badge>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- Editar -->
                                    <a href="{{ route('quotations.edit', $quote->id) }}" title="Editar Cotización" class="p-1.5 text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 rounded transition">
                                        <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                                    </a>

                                    <!-- Imprimir / PDF -->
                                    <a href="{{ route('quotations.print', $quote->id) }}" target="_blank" title="Imprimir / Ver PDF" class="p-1.5 text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 rounded transition">
                                        <x-ui.icon name="printer" class="w-3.5 h-3.5" />
                                    </a>

                                    <!-- WhatsApp -->
                                    @if($quote->client_phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $quote->client_phone) }}?text={{ urlencode('Hola ' . $quote->client_name . ', te enviamos la cotización N° ' . $quote->quote_number . ' por un total de $' . number_format($quote->total, 0, ',', '.') . ' CLP.') }}" target="_blank" title="Enviar por WhatsApp" class="p-1.5 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 rounded transition">
                                            <x-ui.icon name="whatsapp" class="w-3.5 h-3.5" />
                                        </a>
                                    @endif

                                    <!-- Convertir a OT -->
                                    @if($quote->status !== 'convertida')
                                        <button type="button" wire:click="convertToWorkOrder({{ $quote->id }})" title="Convertir a Orden de Trabajo" class="p-1.5 text-sky-600 dark:text-sky-400 hover:bg-sky-50 dark:hover:bg-sky-950/30 rounded transition cursor-pointer">
                                            <x-ui.icon name="check-square" class="w-3.5 h-3.5" />
                                        </button>
                                    @endif

                                    <!-- Desactivar / Anular -->
                                    <button type="button" 
                                        x-on:click="
                                            if (confirm('¿Anular la cotización N° {{ $quote->quote_number }}?')) {
                                                $wire.deleteQuotation({{ $quote->id }})
                                            }
                                        " 
                                        title="Anular Cotización" 
                                        class="p-1.5 text-zinc-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 rounded transition cursor-pointer">
                                        <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-400 dark:text-zinc-500 text-xs">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <x-ui.icon name="file-text" class="w-8 h-8 text-zinc-300 dark:text-zinc-600" />
                                    <span>No se encontraron cotizaciones registradas.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS VIEW -->
        <div class="md:hidden flex flex-col gap-2.5 p-3">
            @forelse($quotations as $quote)
                <div class="bg-white dark:bg-zinc-850 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 shadow-xs flex flex-col gap-2.5">
                    
                    <!-- Top Bar: Folio & Date -->
                    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-2">
                        <div class="flex items-center gap-1.5">
                            <span class="font-mono text-xs font-semibold text-orange-600 dark:text-orange-400">
                                {{ $quote->quote_number }}
                            </span>
                            @php
                                $badgeVariant = match($quote->status) {
                                    'aceptada', 'convertida' => 'success',
                                    'enviada' => 'info',
                                    'rechazada' => 'danger',
                                    default => 'neutral'
                                };
                            @endphp
                            <x-ui.badge :variant="$badgeVariant" size="xs">
                                {{ $quote->status_label }}
                            </x-ui.badge>
                        </div>
                        <div class="text-[11px] text-zinc-400">
                            {{ $quote->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <!-- Client & Device Info -->
                    <div class="flex flex-col gap-1.5">
                        <div>
                            <span class="text-zinc-900 dark:text-zinc-100 font-bold text-xs leading-tight block">{{ $quote->client_name ?? 'Cliente General' }}</span>
                            @if($quote->client_phone)
                                <span class="text-xs text-zinc-500 dark:text-zinc-400 font-mono flex items-center gap-1 mt-0.5">
                                    <x-ui.icon name="phone" class="w-3 h-3 text-zinc-400" />
                                    {{ $quote->client_phone }}
                                </span>
                            @endif
                        </div>

                        <!-- Device & Items Box -->
                        <div class="bg-zinc-50 dark:bg-zinc-800/60 p-2.5 rounded-lg border border-zinc-200/80 dark:border-zinc-800 flex items-center justify-between text-xs">
                            <span class="text-zinc-700 dark:text-zinc-300 font-medium truncate">{{ $quote->device_info ?? 'Equipo' }}</span>
                            <span class="text-zinc-400 text-[11px] shrink-0 font-medium">
                                {{ count($quote->items) }} ítems
                            </span>
                        </div>
                    </div>

                    <!-- Total Row -->
                    <div class="flex items-center justify-between pt-1">
                        <span class="text-xs text-zinc-400">Total</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-zinc-100 font-mono">
                            ${{ number_format($quote->total, 0, ',', '.') }} CLP
                        </span>
                    </div>

                    <!-- Actions Bar on Mobile -->
                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-zinc-100 dark:border-zinc-800">
                        <a 
                            href="{{ route('quotations.print', $quote->id) }}" 
                            target="_blank" 
                            class="py-1.5 px-2 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1"
                        >
                            <x-ui.icon name="printer" class="w-3.5 h-3.5" />
                            <span>Imprimir</span>
                        </a>

                        <a 
                            href="{{ route('quotations.edit', $quote->id) }}" 
                            class="py-1.5 px-2 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1"
                        >
                            <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                            <span>Editar</span>
                        </a>

                        @if($quote->client_phone)
                            <a 
                                href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $quote->client_phone) }}?text={{ urlencode('Hola ' . $quote->client_name . ', te enviamos la cotización N° ' . $quote->quote_number . ' por un total de $' . number_format($quote->total, 0, ',', '.') . ' CLP.') }}" 
                                target="_blank" 
                                class="py-1.5 px-2 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1"
                            >
                                <x-ui.icon name="whatsapp" class="w-3.5 h-3.5" />
                                <span>WhatsApp</span>
                            </a>
                        @endif

                        @if($quote->status !== 'convertida')
                            <button 
                                type="button" 
                                wire:click="convertToWorkOrder({{ $quote->id }})" 
                                class="py-1.5 px-2 bg-sky-50 dark:bg-sky-950/40 text-sky-700 dark:text-sky-400 border border-sky-200 dark:border-sky-800/60 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1"
                            >
                                <x-ui.icon name="check-square" class="w-3.5 h-3.5" />
                                <span>A Orden</span>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-zinc-400 text-xs">
                    No se encontraron cotizaciones con los filtros aplicados.
                </div>
            @endforelse
        </div>
        
        @if($quotations->hasPages())
            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                {{ $quotations->links() }}
            </div>
        @endif
    </div>
</div>