<div class="space-y-6 pb-16 md:pb-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/50">
                    <x-ui.icon name="file-text" class="w-5 h-5" />
                </span>
                Libro de Ventas
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Revisa las ventas y exporta la información tributaria.</p>
        </div>
        
        <div class="flex items-center gap-3 self-start sm:self-auto">
            <div class="flex items-center gap-2 bg-white dark:bg-zinc-900 p-1 rounded-lg border border-zinc-200 dark:border-zinc-800 shadow-xs">
                <select wire:model.live="currentMonth" class="bg-transparent text-zinc-800 dark:text-zinc-200 text-xs font-medium rounded-md border-0 py-1.5 pl-2.5 pr-7 focus:ring-1 focus:ring-orange-500">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}">{{ ucfirst(\Carbon\Carbon::create(2000, $m, 1)->locale('es')->monthName) }}</option>
                    @endfor
                </select>
                <div class="w-px h-4 bg-zinc-200 dark:bg-zinc-700"></div>
                <select wire:model.live="currentYear" class="bg-transparent text-zinc-800 dark:text-zinc-200 text-xs font-medium rounded-md border-0 py-1.5 pl-2.5 pr-7 focus:ring-1 focus:ring-orange-500">
                    @for($y=date('Y'); $y>=date('Y')-2; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <button wire:click="exportCsv" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-xs transition duration-150 cursor-pointer">
                <x-ui.icon name="download" class="w-4 h-4" />
                Exportar CSV
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 border-b border-zinc-200 dark:border-zinc-800 text-[10px] uppercase text-zinc-500 dark:text-zinc-400 font-semibold tracking-wider">
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Documento</th>
                        <th class="px-4 py-3">OT / Referencia</th>
                        <th class="px-4 py-3">Folio (SII)</th>
                        <th class="px-4 py-3">Cliente / RUT</th>
                        <th class="px-4 py-3 text-right">Neto</th>
                        <th class="px-4 py-3 text-right">IVA</th>
                        <th class="px-4 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors">
                            <td class="px-4 py-3 font-mono text-zinc-500 dark:text-zinc-400 text-xs">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $badgeVariant = match($sale->document_type) {
                                        'factura' => 'warning',
                                        'boleta' => 'info',
                                        default => 'neutral'
                                    };
                                @endphp
                                <x-ui.badge :variant="$badgeVariant" size="xs">
                                    {{ ucfirst($sale->document_type) }}
                                </x-ui.badge>
                            </td>
                            {{-- Columna OT / Referencia --}}
                            <td class="px-4 py-3">
                                @if($sale->work_order_id)
                                    <a href="/ordenes-trabajo" class="inline-flex items-center gap-1 text-xs font-semibold text-orange-600 dark:text-orange-400 hover:underline font-mono transition">
                                        OT #{{ substr($sale->workOrder->uuid ?? '', 0, 8) }}
                                    </a>
                                @else
                                    <span class="text-xs text-zinc-400">Venta POS</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-zinc-500 dark:text-zinc-400">
                                @if($sale->document_type !== 'ticket')
                                    <div class="flex flex-col gap-0.5">
                                        <span class="text-zinc-800 dark:text-zinc-200 font-mono text-xs">{{ $sale->sii_document_number ?? 'Pendiente' }}</span>
                                        <div class="flex items-center gap-1 text-[10px] font-semibold 
                                            {{ $sale->sii_status === 'accepted' ? 'text-emerald-600 dark:text-emerald-400' : ($sale->sii_status === 'pending' ? 'text-amber-600 dark:text-amber-400' : 'text-zinc-400') }}">
                                            @if($sale->sii_status === 'accepted')
                                                <x-ui.icon name="check-circle" class="w-3 h-3" />
                                                Aceptado SII
                                            @elseif($sale->sii_status === 'pending')
                                                <span class="w-3 h-3 border border-amber-500 border-t-transparent rounded-full animate-spin"></span>
                                                Pendiente
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="text-zinc-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-zinc-800 dark:text-zinc-200 text-xs">{{ $sale->client_name ?? 'Genérico' }}</div>
                                @if($sale->client_rut)
                                    <div class="text-[10px] font-mono text-zinc-400">{{ $sale->client_rut }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-zinc-500 dark:text-zinc-400">
                                ${{ number_format($sale->subtotal, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-zinc-500 dark:text-zinc-400">
                                ${{ number_format($sale->tax_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-zinc-900 dark:text-zinc-100">
                                ${{ number_format($sale->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-zinc-400 dark:text-zinc-500 text-xs">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <x-ui.icon name="file-text" class="w-8 h-8 text-zinc-300 dark:text-zinc-600" />
                                    <span>No hay ventas registradas en este mes.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>