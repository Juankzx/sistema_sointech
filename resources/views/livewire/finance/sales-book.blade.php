<div class="px-2">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight flex items-center gap-3">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Libro de Ventas
            </h2>
            <p class="text-sm text-gray-400 mt-1 font-medium">Revisa las ventas y exporta la información tributaria.</p>
        </div>
        
        <div class="flex items-center gap-3 bg-gray-800/80 p-1.5 rounded-xl border border-gray-700/50">
            <select wire:model.live="currentMonth" class="bg-gray-900 border-none text-white text-sm font-semibold rounded-lg focus:ring-emerald-500 block py-2 px-3">
                @for($m=1; $m<=12; $m++)
                    <option value="{{ $m }}">{{ \Carbon\Carbon::create(2000, $m, 1)->locale('es')->monthName }}</option>
                @endfor
            </select>
            <select wire:model.live="currentYear" class="bg-gray-900 border-none text-white text-sm font-semibold rounded-lg focus:ring-emerald-500 block py-2 px-3">
                @for($y=date('Y'); $y>=date('Y')-2; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>

    <!-- Export Button -->
    <div class="flex justify-end mb-4">
        <button wire:click="exportCsv" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Exportar a Excel (CSV)
        </button>
    </div>

    <!-- Table -->
    <div class="bg-gray-800 border border-gray-700 rounded-2xl overflow-hidden shadow-lg shadow-black/20">
        <div class="overflow-x-auto theme-scrollbar">
            <table class="w-full text-left text-sm text-gray-300">
                <thead class="bg-gray-900/50 border-b border-gray-700 text-[10px] uppercase text-gray-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-black">Fecha</th>
                        <th class="px-6 py-4 font-black">Documento</th>
                        <th class="px-6 py-4 font-black">OT / Referencia</th>
                        <th class="px-6 py-4 font-black">Folio (SII)</th>
                        <th class="px-6 py-4 font-black">Cliente / RUT</th>
                        <th class="px-6 py-4 font-black text-right">Neto</th>
                        <th class="px-6 py-4 font-black text-right">IVA</th>
                        <th class="px-6 py-4 font-black text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 font-semibold text-white whitespace-nowrap">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg border 
                                    {{ $sale->document_type === 'factura' ? 'bg-orange-500/10 text-orange-400 border-orange-500/20' : 
                                      ($sale->document_type === 'boleta' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 'bg-gray-700 text-gray-300 border-gray-600') }}">
                                    {{ ucfirst($sale->document_type) }}
                                </span>
                            </td>
                            {{-- Columna OT / Referencia --}}
                            <td class="px-6 py-4">
                                @if($sale->work_order_id)
                                    <a href="/ordenes-trabajo" class="inline-flex items-center gap-1 text-xs font-bold text-blue-400 hover:text-blue-300 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        OT #{{ substr($sale->workOrder->uuid ?? '', 0, 8) }}
                                    </a>
                                @else
                                    <span class="text-xs text-gray-500">Venta POS</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-400">
                                @if($sale->document_type !== 'ticket')
                                    <div class="flex flex-col gap-1">
                                        <span class="text-white">{{ $sale->sii_document_number ?? 'Pendiente' }}</span>
                                        <div class="flex items-center gap-1 text-[10px] uppercase font-bold 
                                            {{ $sale->sii_status === 'accepted' ? 'text-emerald-400' : ($sale->sii_status === 'pending' ? 'text-amber-400' : 'text-gray-500') }}">
                                            @if($sale->sii_status === 'accepted')
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Aceptado SII
                                            @elseif($sale->sii_status === 'pending')
                                                <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                Pendiente
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-600">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-white">{{ $sale->client_name ?? 'Genérico' }}</div>
                                @if($sale->client_rut)
                                    <div class="text-[10px] text-gray-400">{{ $sale->client_rut }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-gray-400">
                                ${{ number_format($sale->subtotal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-gray-400">
                                ${{ number_format($sale->tax_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-black text-emerald-400">
                                ${{ number_format($sale->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="font-semibold text-gray-400">No hay ventas registradas en este mes.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
