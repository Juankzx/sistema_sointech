<div class="p-6 max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-700">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-3">
                <span>Gestión de Cotizaciones Rápidas</span>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-orange-500/10 text-orange-600 dark:bg-orange-500/20 dark:text-orange-300 border border-orange-500/20">
                    PDF & Presupuestos
                </span>
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Crea, envía y convierte cotizaciones formales para tus clientes.</p>
        </div>

        <a href="{{ route('quotations.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white text-sm font-bold rounded-xl shadow-md shadow-orange-500/20 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nueva Cotización
        </a>
    </div>

    <!-- Mensajes Flash -->
    @if(session()->has('success'))
    <div class="p-4 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-800 dark:text-emerald-200 text-sm font-medium flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session()->has('error'))
    <div class="p-4 bg-red-50 dark:bg-red-950/50 border border-red-200 dark:border-red-800 rounded-xl text-red-800 dark:text-red-200 text-sm font-medium flex items-center gap-2">
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Buscador y Filtros -->
    <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-96">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por Folio, Cliente o Equipo..." class="w-full text-xs p-3 pl-9 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto">
            <select wire:model.live="status" class="text-xs p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white outline-none">
                <option value="">Todos los Estados</option>
                <option value="borrador">Borrador</option>
                <option value="enviada">Enviada</option>
                <option value="aceptada">Aceptada</option>
                <option value="convertida">Convertida a OT</option>
                <option value="rechazada">Rechazada</option>
            </select>
        </div>
    </div>

    <!-- Tabla -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-300 font-semibold uppercase tracking-wider border-b border-slate-100 dark:border-slate-700">
                        <th class="p-4">Folio / Fecha</th>
                        <th class="p-4">Cliente</th>
                        <th class="p-4">Equipo / Servicio</th>
                        <th class="p-4 text-right">Total ($)</th>
                        <th class="p-4 text-center">Estado</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($quotations as $quote)
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition">
                        <td class="p-4">
                            <div class="font-bold text-slate-900 dark:text-white font-mono text-sm">{{ $quote->quote_number }}</div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400">{{ $quote->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="p-4">
                            <div class="font-semibold text-slate-800 dark:text-slate-100">{{ $quote->client_name ?? 'Cliente General' }}</div>
                            <div class="text-[11px] text-slate-500">{{ $quote->client_phone ?? $quote->client_email ?? 'Sin contacto' }}</div>
                        </td>
                        <td class="p-4">
                            <div class="font-medium text-slate-800 dark:text-slate-200">{{ $quote->device_info }}</div>
                            <div class="text-[11px] text-slate-500">{{ count($quote->items) }} ítems detallados</div>
                        </td>
                        <td class="p-4 text-right">
                            <div class="font-bold text-slate-900 dark:text-white text-sm">${{ number_format($quote->total, 0, ',', '.') }}</div>
                            <div class="text-[10px] font-semibold text-slate-400">
                                @if($quote->tax_included)
                                    Bruto (IVA Inc.)
                                @elseif((float)$quote->tax_amount > 0)
                                    @php
                                        $servicesSum = $quote->items->where('type', 'servicio')->sum(fn($i) => $i->quantity * $i->unit_price);
                                        $expectedLaborTax = round($servicesSum * 0.19);
                                        $isLaborOnly = ($servicesSum > 0 && abs($expectedLaborTax - (float)$quote->tax_amount) < 5);
                                    @endphp
                                    {{ $isLaborOnly ? 'IVA Solo M. Obra' : 'Neto + 19% IVA' }}
                                @else
                                    Exento
                                @endif
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full border {{ $quote->status_badge_class }}">
                                {{ $quote->status_label }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <!-- Editar -->
                                <a href="{{ route('quotations.edit', $quote->id) }}" title="Editar Cotización" class="p-1.5 text-slate-600 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 bg-slate-100 dark:bg-slate-700 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                <!-- Imprimir / PDF -->
                                <a href="{{ route('quotations.print', $quote->id) }}" target="_blank" title="Imprimir / Ver PDF" class="p-1.5 text-slate-600 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 bg-slate-100 dark:bg-slate-700 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                </a>

                                <!-- WhatsApp -->
                                @if($quote->client_phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $quote->client_phone) }}?text={{ urlencode('Hola ' . $quote->client_name . ', te enviamos la cotización N° ' . $quote->quote_number . ' por un total de $' . number_format($quote->total, 0, ',', '.') . ' CLP.') }}" target="_blank" title="Enviar por WhatsApp" class="p-1.5 text-slate-600 hover:text-emerald-500 dark:text-slate-400 dark:hover:text-emerald-400 bg-slate-100 dark:bg-slate-700 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.002-2.637-1.023-5.115-2.887-6.978C16.578 1.899 14.1 1.849 11.47 1.849c-5.437 0-9.861 4.417-9.865 9.864-.001 1.802.49 3.559 1.42 5.111L1.938 22l5.37-1.41a9.813 9.813 0 004.721 1.218z"/></svg>
                                </a>
                                @endif

                                <!-- Convertir a OT -->
                                @if($quote->status !== 'convertida')
                                <button type="button" wire:click="convertToWorkOrder({{ $quote->id }})" title="Convertir a Orden de Trabajo" class="p-1.5 text-slate-600 hover:text-purple-600 dark:text-slate-400 dark:hover:text-purple-400 bg-slate-100 dark:bg-slate-700 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </button>
                                @endif

                                <!-- Desactivar / Anular -->
                                <button type="button" 
                                    x-on:click="
                                        Swal.fire({
                                            title: '¿Anular / Desactivar Cotización?',
                                            text: 'La cotización N° {{ $quote->quote_number }} cambiará su estado a Rechazada/Anulada.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#ea580c',
                                            cancelButtonColor: '#475569',
                                            confirmButtonText: 'Sí, Desactivar',
                                            cancelButtonText: 'Cancelar',
                                            background: '#0f172a',
                                            color: '#fff'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $wire.deleteQuotation({{ $quote->id }})
                                            }
                                        })
                                    " 
                                    title="Desactivar / Anular Cotización" 
                                    class="p-1.5 text-slate-600 hover:text-red-600 dark:text-slate-400 dark:hover:text-red-400 bg-slate-100 dark:bg-slate-700 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400">
                            No se encontraron cotizaciones. ¡Crea una nueva cotización en segundos!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $quotations->links() }}
        </div>
    </div>
</div>
