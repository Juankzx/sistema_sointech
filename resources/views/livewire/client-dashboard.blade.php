<div class="space-y-6 pb-16">
    <!-- Header Principal -->
    <x-ui.card class="p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-500 flex items-center justify-center text-lg font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-lg sm:text-xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                        <span>Hola, {{ auth()->user()->name }}</span>
                    </h1>
                    <p class="text-xs text-zinc-500 mt-0.5">Consulta el estado en vivo y avance técnico de tus equipos ingresados.</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @php
                    $supportPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::find(1)->support_whatsapp ?? '');
                @endphp
                @if($supportPhone)
                    <a href="https://wa.me/{{ $supportPhone }}" target="_blank" 
                       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 text-xs font-medium hover:bg-emerald-100 dark:hover:bg-emerald-900/40 transition">
                        <x-ui.icon name="whatsapp" class="w-4 h-4" />
                        <span>Soporte WhatsApp</span>
                    </a>
                @endif
            </div>
        </div>
    </x-ui.card>

    <!-- Summary Metrics -->
    @php
        $total = $clientOrders->count();
        $enProceso = $clientOrders->whereIn('status', ['Ingresado', 'En Revisión', 'Presupuestado', 'Aprobado', 'Esperando Repuestos', 'En Reparación'])->count();
        $listos = $clientOrders->where('status', 'Listo para Entrega')->count();
        $entregados = $clientOrders->where('status', 'Entregado')->count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <x-ui.card class="p-4 flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 flex items-center justify-center shrink-0">
                <x-ui.icon name="package" class="w-5 h-5" />
            </div>
            <div>
                <span class="text-[11px] font-medium text-zinc-500 block">Total Órdenes</span>
                <span class="text-lg font-bold text-zinc-900 dark:text-zinc-100">{{ $total }}</span>
            </div>
        </x-ui.card>

        <x-ui.card class="p-4 flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                <x-ui.icon name="wrench" class="w-5 h-5" />
            </div>
            <div>
                <span class="text-[11px] font-medium text-zinc-500 block">En Proceso</span>
                <span class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ $enProceso }}</span>
            </div>
        </x-ui.card>

        <x-ui.card class="p-4 flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <x-ui.icon name="check-circle" class="w-5 h-5" />
            </div>
            <div>
                <span class="text-[11px] font-medium text-zinc-500 block">Listos para Retiro</span>
                <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ $listos }}</span>
            </div>
        </x-ui.card>

        <x-ui.card class="p-4 flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 flex items-center justify-center shrink-0">
                <x-ui.icon name="archive" class="w-5 h-5" />
            </div>
            <div>
                <span class="text-[11px] font-medium text-zinc-500 block">Finalizados</span>
                <span class="text-lg font-bold text-zinc-600 dark:text-zinc-400">{{ $entregados }}</span>
            </div>
        </x-ui.card>
    </div>

    <!-- Lista de Órdenes de Trabajo -->
    <div class="space-y-4">
        <div class="flex items-center justify-between px-1">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 flex items-center gap-2">
                <span>Mis Órdenes de Servicio</span>
                <span class="text-[11px] font-mono px-2 py-0.5 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">{{ $total }}</span>
            </h2>
        </div>

        @forelse($clientOrders as $order)
            @php
                $deviceLower = strtolower($order->device_type);
                $deviceIcon = 'smartphone';
                if (str_contains($deviceLower, 'notebook') || str_contains($deviceLower, 'laptop') || str_contains($deviceLower, 'macbook')) {
                    $deviceIcon = 'laptop';
                } elseif (str_contains($deviceLower, 'desktop') || str_contains($deviceLower, 'pc') || str_contains($deviceLower, 'computador')) {
                    $deviceIcon = 'monitor';
                } elseif (str_contains($deviceLower, 'consola') || str_contains($deviceLower, 'ps') || str_contains($deviceLower, 'xbox') || str_contains($deviceLower, 'nintendo')) {
                    $deviceIcon = 'gamepad-2';
                } elseif (str_contains($deviceLower, 'tablet') || str_contains($deviceLower, 'ipad')) {
                    $deviceIcon = 'tablet';
                } elseif (str_contains($deviceLower, 'reloj') || str_contains($deviceLower, 'watch')) {
                    $deviceIcon = 'watch';
                }

                $statusProgress = [
                    'Ingresado' => 20,
                    'En Revisión' => 40,
                    'Presupuestado' => 50,
                    'Aprobado' => 65,
                    'Esperando Repuestos' => 70,
                    'En Reparación' => 75,
                    'Listo para Entrega' => 90,
                    'Entregado' => 100,
                    'Rechazado' => 0,
                    'Sin Reparación' => 0,
                ];
                $percent = $statusProgress[$order->status] ?? 25;

                $statusBadgeVariants = [
                    'Ingresado' => 'zinc',
                    'En Revisión' => 'blue',
                    'Presupuestado' => 'amber',
                    'Aprobado' => 'orange',
                    'Esperando Repuestos' => 'purple',
                    'En Reparación' => 'blue',
                    'Listo para Entrega' => 'emerald',
                    'Entregado' => 'zinc',
                    'Rechazado' => 'red',
                ];
                $variant = $statusBadgeVariants[$order->status] ?? 'zinc';

                $partsCostTotal = $order->parts ? $order->parts->sum(function($p) { return $p->pivot->price_at_time * $p->pivot->quantity; }) : 0;
                $orderTotal = (float)$order->labor_cost + $partsCostTotal;
                $balanceDue = max(0, $orderTotal - (float)$order->down_payment);
            @endphp

            <x-ui.card class="p-5 space-y-4 hover:border-zinc-300 dark:hover:border-zinc-700 transition">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                    
                    <!-- Columna 1: Dispositivo & Info -->
                    <div class="flex items-start gap-3.5 flex-1 min-w-0">
                        <div class="w-11 h-11 rounded-xl bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 flex items-center justify-center shrink-0">
                            <x-ui.icon name="{{ $deviceIcon }}" class="w-5 h-5" />
                        </div>

                        <div class="space-y-1 flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs font-semibold text-zinc-500">
                                    #{{ substr($order->uuid, 0, 8) }}
                                </span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                    {{ $order->device_type }}
                                </span>
                            </div>

                            <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                {{ $order->brand_model ?: $order->brand ?: ucfirst($order->device_type) }}
                            </h3>

                            <p class="text-xs text-zinc-500 line-clamp-1">
                                <span class="font-medium text-zinc-700 dark:text-zinc-300">Falla:</span> {{ $order->reported_issue }}
                            </p>
                        </div>
                    </div>

                    <!-- Columna 2: Progreso -->
                    <div class="lg:w-64 p-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Estado</span>
                            <x-ui.badge :variant="$variant">
                                {{ $order->status }}
                            </x-ui.badge>
                        </div>

                        <div class="space-y-1">
                            <div class="w-full bg-zinc-200 dark:bg-zinc-800 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-brand-500 h-full rounded-full transition-all duration-300" style="width: {{ $percent }}%;"></div>
                            </div>
                            <div class="flex justify-between text-[9px] text-zinc-400 font-medium">
                                <span>Recepción</span>
                                <span>Proceso</span>
                                <span>Entrega</span>
                            </div>
                        </div>
                    </div>

                    <!-- Columna 3: Costo y Acción -->
                    <div class="flex flex-col sm:flex-row lg:flex-col sm:items-center lg:items-end justify-between gap-3 shrink-0">
                        <div class="text-left lg:text-right space-y-0.5">
                            <div class="text-[11px] text-zinc-400">
                                Ingreso: <span class="font-mono text-zinc-700 dark:text-zinc-300">{{ $order->created_at->format('d/m/Y') }}</span>
                            </div>
                            @if($orderTotal > 0)
                                <div class="text-xs font-semibold text-zinc-900 dark:text-zinc-100">
                                    Total: ${{ number_format($orderTotal, 0, ',', '.') }}
                                    @if($balanceDue > 0)
                                        <span class="text-[10px] font-normal text-amber-600 dark:text-amber-400 block sm:inline sm:ml-1">
                                            (Saldo: ${{ number_format($balanceDue, 0, ',', '.') }})
                                        </span>
                                    @else
                                        <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-normal block sm:inline sm:ml-1">
                                            (Pagado)
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('work-orders.track', $order->uuid) }}" 
                           class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer">
                            <span>Ver Seguimiento</span>
                            <x-ui.icon name="arrow-right" class="w-3.5 h-3.5" />
                        </a>
                    </div>

                </div>
            </x-ui.card>
        @empty
            <x-ui.card class="p-12 text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-400 flex items-center justify-center mx-auto">
                    <x-ui.icon name="inbox" class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">No tienes órdenes de trabajo registradas</h3>
                    <p class="text-xs text-zinc-500 mt-1">Cuando ingreses un equipo a nuestro taller, podrás realizar el seguimiento en vivo desde aquí.</p>
                </div>
            </x-ui.card>
        @endforelse
    </div>
</div>
