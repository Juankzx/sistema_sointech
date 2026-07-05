<div class="space-y-6 animate-fade-in">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Bienvenido, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-gray-400 mt-1">Aquí puedes ver el estado y progreso de todas tus órdenes de trabajo.</p>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden mt-6">
        <!-- DESKTOP TABLE -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-900/40 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                        <th class="px-6 py-4 text-xs md:text-sm">Orden #</th>
                        <th class="px-6 py-4 text-xs md:text-sm">Dispositivo</th>
                        <th class="px-6 py-4 text-xs md:text-sm">Estado Actual</th>
                        <th class="px-6 py-4 text-xs md:text-sm">Fecha Ingreso</th>
                        <th class="px-6 py-4 text-center text-xs md:text-sm">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($clientOrders as $order)
                        <tr class="hover:bg-gray-900/20 transition">
                            <td class="px-6 py-4 font-mono font-bold text-blue-400">
                                {{ substr($order->uuid, 0, 8) }}
                            </td>
                            <td class="px-6 py-4 text-white">
                                <div class="font-bold">{{ $order->device_type }}</div>
                                <div class="text-xs text-gray-400">{{ $order->brand }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'Ingresado' => 'bg-gray-900/50 text-gray-400 border-gray-700',
                                        'En Revisión' => 'bg-yellow-900/30 text-yellow-400 border-yellow-700/50',
                                        'Presupuestado' => 'bg-indigo-900/30 text-indigo-400 border-indigo-700/50',
                                        'Aprobado' => 'bg-blue-900/30 text-blue-400 border-blue-700/50',
                                        'En Reparación' => 'bg-blue-900/30 text-blue-400 border-blue-700/50',
                                        'Listo para Entrega' => 'bg-emerald-900/30 text-emerald-400 border-emerald-700/50',
                                        'Entregado' => 'bg-gray-900/50 text-gray-500 border-gray-800',
                                    ];
                                    $colorClass = $statusColors[$order->status] ?? 'bg-gray-800 text-gray-300 border-gray-600';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $colorClass }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-xs">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('work-orders.track', $order->uuid) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 text-xs font-semibold rounded-lg transition border border-blue-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Ver Detalle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                No tienes órdenes de trabajo registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
        <div class="md:hidden flex flex-col gap-3 p-4">
            @forelse($clientOrders as $order)
                <div class="bg-gray-800/50 border border-gray-700/60 rounded-2xl p-4 flex flex-col gap-3">
                    <div class="flex items-center justify-between border-b border-gray-700/50 pb-2">
                        <span class="font-mono text-xs font-bold text-blue-400">#{{ substr($order->uuid, 0, 8) }}</span>
                        <span class="text-[10px] text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="font-bold text-white">{{ $order->device_type }}</span>
                        <span class="text-xs text-gray-400">{{ $order->brand }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-2">
                        @php
                            $statusColors = [
                                'Ingresado' => 'bg-gray-900/50 text-gray-400 border-gray-700',
                                'En Revisión' => 'bg-yellow-900/30 text-yellow-400 border-yellow-700/50',
                                'Presupuestado' => 'bg-indigo-900/30 text-indigo-400 border-indigo-700/50',
                                'Aprobado' => 'bg-blue-900/30 text-blue-400 border-blue-700/50',
                                'En Reparación' => 'bg-blue-900/30 text-blue-400 border-blue-700/50',
                                'Listo para Entrega' => 'bg-emerald-900/30 text-emerald-400 border-emerald-700/50',
                                'Entregado' => 'bg-gray-900/50 text-gray-500 border-gray-800',
                            ];
                            $colorClass = $statusColors[$order->status] ?? 'bg-gray-800 text-gray-300 border-gray-600';
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border {{ $colorClass }}">
                            {{ $order->status }}
                        </span>
                        
                        <a href="{{ route('work-orders.track', $order->uuid) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 text-xs font-semibold rounded-lg transition border border-blue-500/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Ver
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-gray-500 text-sm">No tienes órdenes de trabajo registradas.</div>
            @endforelse
        </div>
    </div>
</div>
